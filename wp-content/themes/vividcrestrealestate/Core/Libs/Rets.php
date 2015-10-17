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

    
    
    
    public static function fetchProperties($class, $start, $end)
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
        $PropertyImages = new \Vividcrestrealestate\Core\Structures\PropertyImages();
        
        
        $processing_properties = $ProcessingProperties->get([
            'confines' => ["`status`='NEW'"],
            'limit' => $batch_size
        ]);
        
        foreach ($processing_properties as $processing_property) {
            // Prepare property to save
            $property = json_decode($processing_property->data);
            $property->type = "ResidentialProperty"; // So hardcode
            
            
            
            // Save property
            $property_id = $Properties->set($property);
            
            
            
            // Save images
            if ($property_id) {
                $photos = $this->connection->GetObject($this->resource, "Photo", $property->Ml_num);
                
                if (!empty($photos)) {
                    $saved = $this->saveImages($photos, $property_id);
                    
                    // Attach images
                    if (!empty($saved)) {
                        $property->main_image = $saved[0]->link;
                        
                        $PropertyImages->set($saved);                        
                        $Properties->set($property);
                    }                    
                }
            }


            
            // Mark property as processed
            $processing_property->status = (!empty($property_id) ? "DONE" : "FAILED");
            $processing_property->processing_date = date("Y-m-d H:i:s");
            
            $ProcessingProperties->set($processing_property);
        }
    }
    
    public function saveImages($images, $property_id)
    {
        $saved = [];
        
        foreach ($images as $image) {
            // Define vars
            $name = $image->getObjectId() . ".jpg";
            $dir = get_template_directory() . "/images/rets/{$property_id}";            
            
            
            
            // Create directory		
            if (!is_dir($dir)) {
                $is_created = mkdir($dir, 0777, true);
                
                if (!$is_created) {
                    return false;
                }
            }         
            
            
            // Save file
            $result = file_put_contents("{$dir}/{$name}", $image->getContent());
            
            if (!$result) {
                return false;
            }
            
            
            
            // Set info about image
            $saved[] = (object)[
                'property_id' => $property_id,
                'link' => get_template_directory_uri() . "/images/rets/{$property_id}/{$name}",
                'title' => $image->getContentDescription()
            ];
        }
        
        return $saved;     
    }
}
