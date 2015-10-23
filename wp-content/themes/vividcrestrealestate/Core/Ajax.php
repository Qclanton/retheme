<?php
namespace Vividcrestrealestate\Core;

class Ajax 
{   
    public static function sendFormToAdmin($data)
    {
        if (!isset($_POST['contact'])) {
            die(0);
        }
        
        die(Forms::sendToAdmin($_POST['contact']));
    }
    
    public static function getPropertyImages($data)
    {
        if (!isset($_POST['property_id'])) {
            die("Where is property id?");
        }
        
        $Properties = new Structures\Properties();
        $images = $Properties->getImages($_POST['property_id']);
        
        die(stripslashes(json_encode($images)));
    }
}
