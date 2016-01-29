<?php
namespace Vividcrestrealestate\Core\Administration;

class Connection extends \Vividcrestrealestate\Core\Libs\Administration 
{   
    public static function getOptionsPrefix()
    {
        return "rets_connection_";
    }    
    
    public static function getOptionsList()
    {
        return ["url", "login", "password", "google_api_key"];
    }
    
    public static function getView()
    {
        return "admin/rets/connection";
    }
}
