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
        // Load structures
        if (in_array($part, ["properties", "property"])) {
            $Properties = new Structures\Properties();
        }
        
        // Handle search form
        $search = (isset($_POST['search_property']) ? (object)$_POST['search_property'] : null);
        $data = (object)['search'=>$search];
             
        
        // Extract necessary data
        switch ($part) {                
            case "properties":
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
        $confines = [];
        
        

        if (!empty($search->address)) {
            $recognized = Libs\Address::recognize($search->address);
            
            if(!empty($recognized->postal_code)) {
                $confines[] = "`postal_code`='{$recognized->postal_code}'";
            } elseif (!empty($recognized->neighborhood)) {
                $confines[] = "`neighborhood`='{$recognized->neighborhood}'";
            } elseif (!empty($recognized->sublocality)) {
                $confines[] = "`sublocality`='{$recognized->sublocality}'";
            } elseif(!empty($recognized->city)) {
                $confines[] = "`city`='{$recognized->city}'";
            } 
        }
        
        if (!empty($search->bathrooms)) {
            $confines[] = "`bathrooms`>='{$search->bathrooms}'";
        }
        
        if (!empty($search->bedrooms)) {
            $confines[] = "`bedrooms`>='{$search->bedrooms}'";
        }
        
        if (!empty($search->min_price)) {
            $confines[] = "`price`>='{$search->min_price}'";
        }
        
        if (!empty($search->max_price)) {
            $confines[] = "`price`<='{$search->max_price}'";
        }
        
        if (!empty($search->types) && $search->types !== ["0"]) {
            $types = implode("', '", $search->types);
            $confines[] = "`type` IN ('{$types}')";
        }
        
        if (!empty($search->deal_type)) {
            $confines[] = "`deal_type`='{$search->deal_type}'";
        }
        
        

        $criterion['confines'] = $confines;

        
        
        return $criterion;
    }
}
