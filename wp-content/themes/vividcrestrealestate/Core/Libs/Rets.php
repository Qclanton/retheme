<?php
namespace Vividcrestrealestate\Core\Libs;

class Rets 
{
    protected $url;
    protected $login;
    protected $password;
    protected $connection;


    
    public function setCredentials($url, $login, $password)
    {
        $this->url = $url;
        $this->login = $login;
        $this->password = $password;
        
        return $this;
    }
    
    public function __construct($url, $login, $password) 
    {
        $this->setCredentials($url, $login, $password);
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
    
    public function getProperties()
    {
        $timestamp_field = "Timestamp_sql";
        $previous_timestamp = date("Y-m-d", strtotime("-1 day")) . "T00:00:00";
        $query = "({$timestamp_field}={$previous_timestamp}+)";	
        $batch_size = 2;        
        $resource = "Property";
        // $classes = ["ResidentialProperty", "CommercialProperty", "CondoProperty"];
        $classes = ["ResidentialProperty"];
        
        $data = new \stdClass();
        
        foreach ($classes as $class) {
            $result = $this->connection->Search($resource, $class, $query, [
                'QueryType' => "DMQL2",
                'Limit'  => $batch_size, 
                'Format' => "COMPACT-DECODED", 
                'Count'  => 1
            ]);
            
            $data->{$class} = $result->toArray();
        }
        
        return $data;
    }
}
