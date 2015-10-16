<?php
namespace Vividcrestrealestate\Core\Administration;

class Exchange extends \Vividcrestrealestate\Core\Libs\Administration 
{   
    public static function getOptionsPrefix()
    {
        return "rets_exchange_";
    }    
    
    public static function getView()
    {
        return "admin/rets/exchange";
    }
}
