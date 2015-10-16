<?php
namespace Vividcrestrealestate\Core\Libs;

abstract class Administration 
{   
    // Settings. Can be redefined in descendant
    public static function getOptionsPrefix()
    {
        return "manage_";
    }
    
    public static function getOptionsList()
    {
        return [];
    }
    
    public static function getAllowedActions()
    {
        return ["set", "show"];
    }
    
    public static function getView()
    {
        return "admin/manage";
    }
    
    
    
    
    // Actions
    public static function show()
    {   
        // Define actual action 
        $action = (isset($_POST['action']) && in_array($_POST['action'], static::getAllowedActions()) ? $_POST['action'] : "show");
        
        // Do the action
        if ($action !== "show") {
            static::{$action}();
        }
        
        // Get options   
        $options = static::getStoredOptions();
        
        // Show content
        echo \Vividcrestrealestate\Core\Template::renderPart(static::getView(), $options);
    }
    
    public static function set()
    {
        $options_to_store = (isset($_POST['options']) ? $_POST['options'] : []);
        
        static::storeOptions($options_to_store);    
    }
    
    
    
    
    
    
    // Store
    public static function storeOptions(array $options)
    {
        $prefix = static::getOptionsPrefix();
        
        foreach ($options as $name=>$value) {
            if (is_array($value) || is_object($value)) {
                $value = json_encode($value);
            }
            
            update_option($prefix . $name, $value);
        }   
    }
    
    public static function getStoredOptions() 
    {
        $prefix = static::getOptionsPrefix();
        $options = static::getOptionsList();
        $stored = [];
        
        foreach ($options as $option) {
            $value = get_option($prefix . $option);
            
            $decoded = json_decode($value, true);
            
            if(!json_last_error()) {
                $value = $decoded;
            }
            
            $stored[$option] = static::mergeWithDefaultValues($option, $value);
        }
        
        return static::tuneOptions(Ancillary::toObject($stored));
    }
    
    public static function tuneOptions($options) 
    {           
        return $options;
    }
    
    private static function mergeWithDefaultValues($name, $value)
    {           
        return $value;
    }
}
