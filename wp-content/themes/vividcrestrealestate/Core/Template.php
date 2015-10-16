<?php
namespace Vividcrestrealestate\Core;

class Template 
{   
    public static function renderPart($view, $vars=[])
    {
        // Define template file and check existance
        $file = get_template_directory() . "/{$view}.php";
        
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
    
    public static function loadPart($part=null)
    {
        $part = (empty($part) ? Router::definePart() : $part);
        $data = Router::loadData($part);
        
        return self::renderPart($part, $data);
    }
}
