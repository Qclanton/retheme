<?php
namespace Vividcrestrealestate\Core\Administration;

use \Vividcrestrealestate\Core\Structures;

class FeaturedProperties extends \Vividcrestrealestate\Core\Libs\Administration 
{   
    public static $positive_messages;
    public static $negative_messages;  
    
    
    
    public static function getAllowedActions()
    {
        return ["show", "set", "remove"];
    }
    
    public static function getView()
    {
        return "admin/featured_properties";
    }
    
    public static function getPositiveMessages()
    {
        return self::$positive_messages;
    }
    
    public static function getNegativeMessages()
    {
        return self::$negative_messages;
    }
    
    
    
    
    
    public static function show($params=null)
    {   
        // Init libs
        $FeaturedProperties = new Structures\FeaturedProperties();
        $Properties = new Structures\Properties();
        
                
                
        // Define actual action 
        $action = (isset($_REQUEST['action']) && in_array($_REQUEST['action'], static::getAllowedActions()) ? $_REQUEST['action'] : "show");
        
        // Do the action
        if ($action !== "show") {
            static::{$action}();
        } 
        
        
        
        // Get featured properties
        $featured_properties = $FeaturedProperties->get();
        
        // Attach info about properties
        foreach ($featured_properties as &$property) {
            $property = $Properties->get($property->property_id);
        }
    
        
                
        // Prepare vars
        $vars = (object)[
            'positive_messages' => static::getPositiveMessages(),
            'negative_messages' => static::getNegativeMessages(),
            'featured_properties' => $featured_properties,
            'searched_mls_id' => (isset($_POST['searched_mls_id']) ? $_POST['searched_mls_id'] : "")
        ];
        
        // Show content
        echo \Vividcrestrealestate\Core\Template::renderPart(static::getView(), $vars);
    }
    
    public static function set()
    {
        // Init libs
        $Properties = new Structures\Properties();
        $FeaturedProperties = new Structures\FeaturedProperties();
        
        // Find the property
        $mls_id = (!empty($_POST['searched_mls_id']) ? $_POST['searched_mls_id'] : "");
        $properties = $Properties->get(["mls_id='{$mls_id}'"]);
        
        // Inform if not found
        if (empty($properties)) {
            self::$negative_messages[] = "Property with MLS #{$mls_id} not found";            
            return false;
        }

        // Set property
        $property = array_pop($properties);
        $FeaturedProperties->set((object)['mls_id'=>$mls_id, 'property_id'=>$property->id]);        
        self::$positive_messages[] = "Property with MLS #{$mls_id} setted as futured";  
    }
    
    public static function remove() 
    {
        // Init libs   
        $FeaturedProperties = new Structures\FeaturedProperties();
        
        // Find the property
        $mls_id = (!empty($_GET['mls_id']) ? $_GET['mls_id'] : "");      
        $property = $FeaturedProperties->get($mls_id);
        
        // Inform if not found
        if (empty($property)) {
            self::$negative_messages[] = "Featured property MLS #{$mls_id} does not exists";            
            return false;
        }
        
        // Remove featured property
        $FeaturedProperties->delete_constatly($mls_id);
        self::$positive_messages[] = "Property with MLS #{$mls_id} has been removed from futured properties";          
    }
}
