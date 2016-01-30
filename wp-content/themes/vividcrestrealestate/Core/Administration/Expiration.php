<?php
namespace Vividcrestrealestate\Core\Administration;

class Expiration extends \Vividcrestrealestate\Core\Libs\Administration 
{   
    public static function getOptionsPrefix()
    {
        return "rets_expiration_";
    }    
    
    public static function getOptionsList()
    {
        return ["period_for_buy", "period_for_rent"];
    }
    
    public static function getView()
    {
        return "admin/rets/expiration";
    }
    
    
    
    public static function mergeWithDefaultValues($name, $value)
    {  
        // Define default values
        $options = self::getOptionsList();
        $default = [
            'period_for_buy' => "3 month",
            'period_for_rent' => "1 month"
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
