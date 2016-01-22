<?php
namespace Vividcrestrealestate\Core\Administration;

use \Vividcrestrealestate\Core\Structures;

class CustomerRequests extends \Vividcrestrealestate\Core\Libs\Administration 
{     
    public static function getAllowedActions()
    {
        return ["show"];
    }
    
    public static function getView()
    {
        return "admin/customer_requests";
    }
    

    
    
    
    
    public static function show($params=null)
    {   
        // Init libs
        $CustomerRequests = new Structures\CustomerRequests();
        $Properties = new Structures\Properties();       
        
        // Get requests
        $requests = $CustomerRequests->get();
        
        // Attach info about properties
        foreach ($requests as &$request) {
            $request->property = $Properties->get($request->property_id);
        }
        
        // Do the regular action 
        parent::show(['requests'=>$requests]);
    }
    
    public static function mergeWithDefaultValues($name, $value)
    {  
        // Define default values
        $default = [
            'last_fetch_date' => "2000-01-01 00:00:00",
            'is_processing_in_progress' => false
        ];
        
        
        
        // Set default values against of undefnid options
        if (array_key_exists($name, $default)) {  
            $value = (is_array($default[$name])
                ? array_replace_recursive($default[$name], (array)$value)
                : (empty($value) ? $default[$name] : $value)
            );            
        }   
        
        
        
        // Return result       
        return $value;
    }
}
