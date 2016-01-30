<?php
namespace Vividcrestrealestate\Core;

class Ajax 
{   
    public static function saveCustomerRequest()
    {
        if (!isset($_POST['contact'])) {
            die(0);
        }
        
        $CustomerRequests = new Structures\CustomerRequests();
    
        $request = Forms::sanitize($_POST['contact']);
        $result = $CustomerRequests->set((object)$request);
        
        
        
        // Also notify admin
        Forms::sendToAdmin($request);
        
        
        
        die(!empty($result));
    }
    
    public static function getPropertyImages()
    {
        if (!isset($_POST['property_id'])) {
            die("Where is property id?");
        }
        
        $Properties = new Structures\Properties();
        $images = $Properties->getImages($_POST['property_id']);
        
        die(stripslashes(json_encode($images)));
    }
}
