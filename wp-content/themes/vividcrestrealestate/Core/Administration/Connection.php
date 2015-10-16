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
        return ["url", "login", "password"];
    }
    
    public static function getView()
    {
        return "admin/rets/connection";
    }
}
