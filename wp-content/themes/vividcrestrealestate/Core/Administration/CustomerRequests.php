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
}
