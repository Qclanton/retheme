<?php
namespace Vividcrestrealestate\Core\Administration;

class Mailgun extends \Vividcrestrealestate\Core\Libs\Administration 
{   
    public static function getOptionsPrefix()
    {
        return "mailgun_";
    }    
    
    public static function getOptionsList()
    {
        return ["domain", "key"];
    }
    
    public static function getView()
    {
        return "admin/mailgun";
    }
}
