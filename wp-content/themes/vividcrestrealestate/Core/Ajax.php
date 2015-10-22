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
}
