<?php
namespace Vividcrestrealestate\Core\Libs;

class Rets 
{
    protected $url;
    protected $login;
    protected $password;
    protected $connection;
    protected $classes;
    
    protected $resource = "Property";
    protected $timestamp_field = "Timestamp_sql";
    

    
    public function setCredentials($url, $login, $password)
    {
        $this->url = $url;
        $this->login = $login;
        $this->password = $password;
        
        return $this;
    }
    
    public function __construct($url="", $login="", $password="") 
    {
        $this
            ->setCredentials($url, $login, $password)
            ->setAllPossibleClasses();
    }
    
    
    
    
    public function login()
    {
        // Prepare config
        $config = new \PHRETS\Configuration;
        $config->setLoginUrl($this->url);
        $config->setUsername($this->login);
        $config->setPassword($this->password);   
        
        
        // Create the connection 
        $this->connection = new \PHRETS\Session($config);
        
        
        // Try to login
        $result = $this->connection->Login();
        
        
        return (bool)$result;
    }
    
    public function getPossibleClasses()
    {
        // return ["ResidentialProperty", "CommercialProperty", "CondoProperty"];
        return ["ResidentialProperty"];
    }
    
    public function setClasses(array $classes)
    {
        $this->classes = $classes;
        
        return $this;
    }
    
    public function setAllPossibleClasses()
    {
        $this->setClasses($this->getPossibleClasses());
        
        return $this;
    }
    
    
    
    public function getFields($class)
    {
        $fields = [
            'ResidentialProperty' => [
                "Ml_num",
                "Ad_text",
                "Addr",
                "S_r",
                "Extras",
                "Community",
                "Bsmt1_out",
                "Br",
                "Bath_tot",
                "Area",
                "County",
                "Timestamp_sql",
                "Gar_type",
                "Gar_spaces",
                "Lse_terms",
                "Zip",
                "Lotsz_code",
                "Lp_dol",
                "Rms",
                "Sqft",
                "Yr_built"
            ]
        ];
        
        return (array_key_exists($class, $fields) ? $fields[$class] : []);
    }
    
    protected function getProperties($class, $start, $end)
    {
        $timestamp_field = $this->timestamp_field;
        $resource = $this->resource;
        $fields = implode(",", $this->getFields($class));
        	
        $query = "({$timestamp_field}={$start}+),({$timestamp_field}={$end}-)";
        
        $result = $this->connection->Search($resource, $class, $query, [
            'QueryType' => "DMQL2",
            'Limit'  => 999999, // Unlimited
            'Format' => "COMPACT-DECODED", 
            'Count'  => 1,
            'Select' => $fields
        ]);
            
        return $result->toArray();
    }

    
    
    
    public function fetchProperties($class, $start, $end)
    {
        $ProcessingProperties = new \Vividcrestrealestate\Core\Structures\ProcessingProperties();
        
        $properties = $this->getProperties($class, $start, $end);
        $ProcessingProperties->set($properties);
        
        return count($properties);
    }
    
    public function processProperties($batch_size)
    {
        $ProcessingProperties = new \Vividcrestrealestate\Core\Structures\ProcessingProperties();
        $Properties = new \Vividcrestrealestate\Core\Structures\Properties();
        $PropertyInfo = new \Vividcrestrealestate\Core\Structures\PropertyInfo();
        
        
        $processing_properties = $ProcessingProperties->get([
            'confines' => ["`status`='NEW'"],
            'limit' => $batch_size
        ]);
        
        foreach ($processing_properties as $processing_property) {
            // Prepare property to save
            $property = json_decode($processing_property->data);
            $property->type = $processing_property->class;
            
            
            // Save info about photo
            $photos = $this->connection->GetObject($this->resource, "Photo", $property->Ml_num);
            
            if (!empty($photos)) {
                $photos_ids = $this->saveImages($photos, $property->Ml_num);         
                
                if (!empty($photos_ids)) {
                    $property->main_image = get_template_directory_uri() . "/images/rets/{$property->Ml_num}/{$photos_ids[0]}.jpg";
                }          
            }



            // Save property
            $property_id = $Properties->set($property);
            
            
            
            // Save Images Info
            if (!empty($property_id) && !empty($photos_ids)) {
                $PropertyInfo->set((object)[
                    'property_id' => $property_id,
                    'title' => "",
                    'key' => "images_ids",
                    'value' => implode(",", $photos_ids)
                ]);
            }
            

            
            // Mark property as processed
            $processing_property->status = (!empty($property_id) ? "DONE" : "FAILED");
            $processing_property->processing_date = date("Y-m-d H:i:s");
            
            $ProcessingProperties->set($processing_property);
        }
    }
    
    
    
    
    
    protected function saveImages($images, $mls_id)
    {
        $ids = [];
        
        foreach ($images as $i=>$image) {
            // Check object
            $id = $image->getObjectId();         
            
            if (empty($id) || $id === "null") {
                continue;
            }
            
            
            
            // Save main image
            if ($i == 0) {
                // Define vars
                $name = "{$id}.jpg";
                $path = "images/rets/{$mls_id}";
                $dir = get_template_directory() . "/{$path}";
                
                // Create directory		
                if (!is_dir($dir)) {
                    $is_created = mkdir($dir, 0777, true);
                    
                    if (!$is_created) {
                        return false;
                    }
                }  
                
                $this->saveImage($image->getContent(), "{$dir}/{$name}");
            }
            
            
            
            // Save image id    
            $ids[] = $id;
        }
        
        return $ids;
    } 
    
    public function saveImage($binary, $file, $width=640, $height=480, $quality=70)
    {        
        $Imagick = new \Imagick();
        $Imagick->readImageBlob($binary);
        $Imagick->setImageFormat("jpeg");
        
        if ($Imagick->getImageWidth() > $width) {
            $Imagick->resizeImage($width, $height , FILTER_GAUSSIAN, 1);   
        }        
        
        $Imagick->setImageCompression($Imagick::COMPRESSION_JPEG);
        $Imagick->setImageCompressionQuality($quality);
        $Imagick->stripImage();
        $result = $Imagick->writeImage($file);
        
        return $result;
    }
    
    public function cacheImages($mls_id)
    {
        $images = $this->connection->GetObject($this->resource, "Photo", $mls_id);
        $result = false;
        
        if (!empty($images)) {
            foreach ($images as $image) {
                // Check object
                $id = $image->getObjectId();         
                
                if (empty($id) || $id === "null") {
                    continue;
                }
                
                // Define vars
                $name = "{$id}.jpg";
                $path = "images/rets_cached/{$mls_id}";
                $dir = get_template_directory() . "/{$path}";
                
                // Create directory		
                if (!is_dir($dir)) {
                    $is_created = mkdir($dir, 0777, true);
                    
                    if (!$is_created) {
                        return false;
                    }
                }  
                
                // Save image
                $result = $this->saveImage($image->getContent(), "{$dir}/{$name}");
            }      
        } 
        
        return $result;
    }
    
    public function getCachedImage($id, $mls_id)
    {
        $path = "images/rets_cached/{$mls_id}/{$id}.jpg";
        $file = get_template_directory() . "/{$path}";
        $url = get_template_directory_uri() . "/{$path}";
        
        if (!file_exists($file)) {
            $result = $this->cacheImages($mls_id);
            
            if (!$result) {
                return false;
            }
        }
        
        return $url;
    }
}
