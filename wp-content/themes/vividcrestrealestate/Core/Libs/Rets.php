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
    
    public function __construct($url, $login, $password) 
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
    
    protected function getPropertiesByClass($class, $start, $end)
    {
        $timestamp_field = $this->timestamp_field;
        $resource = $this->resource;
        $fields = implode(",", $this->getFields($class));
        
        $previous_timestamp = date("Y-m-d\TH:00:00", strtotime("-4 days"));
        $query = "({$timestamp_field}={$previous_timestamp}+)";	
        // $query = "({$timestamp_field}={$start}+),({$timestamp_field}={$end}-)";
        
        $result = $this->connection->Search($resource, $class, $query, [
            'QueryType' => "DMQL2",
            'Limit'  => 5, // Unlimited
            'Format' => "COMPACT-DECODED", 
            'Count'  => 1,
            'Select' => $fields
        ]);
        
        echo "<pre>"; var_dump($result->toArray()); echo "</pre>";       
        return $result->toArray();
    }
    
    public function synchronizeProperties()
    {
        $classes = $this->classes;
        $timestamps = [
            "2015-10-13T11:00:00",
            "2015-10-13T12:00:00"            
        ];
        
        $data = [];
        
        foreach ($classes as $class) {
            foreach ($timestamps as $i=>$timestamp) {
                $next_timestamp = (isset($timestamps[$i+1]) ? $timestamps[$i+1] : null);
                
                if (!is_null($next_timestamp)) {
                    $data[$timestamp] = $this->getPropertiesByClass($class, $timestamp, $next_timestamp);
                    $this->storePropertiesData($data[$timestamp]);
                }                
            }
            // $properties = $this->getPropertiesByClass($class);
            // $properties = implode(",", $this->getFields($class));
        }
        
        return $data;
    }
    
    protected function storePropertiesData($data)
    {
        $Properties = new \Vividcrestrealestate\Core\Structures\Properties();
        
        foreach ($data as $property) {
            if (empty($property['Addr']) || empty($property['Zip']) || empty($property['Ml_num'])) {
                continue;
            }
            
            $address = "{$data['Addr']} {$data['Zip']}";
            $recognized = Address::recognize($address);
            
            $to_save = (object)[
                'mls_id' => $property['Ml_num'],
                'country' => $recognized->country,
                'city' => $recognized->city,
                'sublocality' => $recognized->sublocality,
                'neighborhood' => $recognized->neighborhood,
                'postal_code' => $recognized->postal_code,
                'address' => $recognized->address,
                'latitude' => $recognized->latitude,
                'longitude' => $recognized->longitude,
                'bedrooms' => $property['Br'],
                'bathrooms' => $property['Bath_tot'],
                'type' => "Residential",
                'deal_type' => "buy",
                'price' => $property['Lp_dol'],
                'size' => $property['Sqft']
            ];
            
            $Properties->set($to_save);
        }
    }
}
