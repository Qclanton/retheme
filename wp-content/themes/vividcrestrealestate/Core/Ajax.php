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
    
        $request = (object)Forms::sanitize($_POST['contact']);
        $result = $CustomerRequests->set($request);
        
        die(!empty($result));
    }
    
    public static function sendFormToAdmin()
    {
        if (!isset($_POST['contact'])) {
            die(0);
        }
        
        die(Forms::sendToAdmin($_POST['contact']));
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
