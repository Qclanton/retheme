<?php
namespace Vividcrestrealestate\Core;

class Router 
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
        
    public static function loadData($part)
    {   
        $data = new \stdClass();
        
        // Load structures
        if (in_array($part, ["properties", "property"])) {
            $Properties = new Structures\Properties();
        }     
        
        // Extract necessary data
        switch ($part) {
            case "properties":
                // Handle search params
                $search = (isset($_POST['search']) ? (object)$_POST['search'] : null);
                $criterion = self::makeCriterion($search);              
                
                $data->properties = $Properties->get($criterion);
                break;
                
            case "property":
                global $wp_query;
                $property_id = $wp_query->query_vars['property_id'];
                $data->property = $Properties->get($property_id);
                break;
        }
        
        return $data;     
    }
    
    public static function makeCriterion($search)
    {
        $criterion = null;
        
        if (!empty($search->address)) {
            $recognized = Libs\Address::recognize($search->address);
            
            if (!empty($recognized->city)) {
                $criterion = ["`city`='{$recognized->city}'"];
            } elseif(!empty($recognized->country)) {
                $criterion = ["`country`='{$recognized->country}'"];
            }
        }
        
        return $criterion;
    }
}
