<?php
namespace Vividcrestrealestate\Core;

class Template 
{
    public static function definePart()
    {
        global $wp_query;
        $template_part = "main";
        
        switch ($wp_query->query_vars['pagename']) {
            case "properties":
                $template_part = (isset($wp_query->query_vars['property_id'])
                    ? "property"
                    : "properties"
                );
                break;
        }
        
        return $template_part;
    }
    
    public static function renderPart($view, $vars=[])
    {
        // Define template file and check existance
        $file = __DIR__ . "/../{$view}.php";
        
        if (!file_exists($file)) {
            return false;
        }
        
        
        
        // Extract vars
        extract((array)$vars);
        
        

        // Load template part
        ob_start();        
        require $file;
        $content = ob_get_contents();
        ob_end_clean();
        
        
        
        // Return rendered content
        return $content;
    }
    
    
    
    
    
    public static function loadData($template_part)
    {   
        $data = new \stdClass();
        
        // Load structures
        if (in_array($template_part, ["properties", "property"])) {
            $Properties = new Structures\Properties();
        }     
        
        // Extract necessary data
        switch ($template_part) {
            case "properties":                
                $data->properties = $Properties->get();
                break;
                
            case "property":
                global $wp_query;
                $property_id = $wp_query->query_vars['property_id'];
                $data->property = $Properties->get($property_id);
                break;
        }
        
        return $data;     
    }
    
    public static function loadPart()
    {
        $template_part = self::definePart();
        $template_part_data = self::loadData($template_part);
        
        return self::renderPart($template_part, $template_part_data);
    }
}
