<?php
namespace Vividcrestrealestate\Core;

class Router 
{
    public static function definePart()
    {
        global $wp_query;
        
        switch ($wp_query->query_vars['pagename']) {
            case "properties":
                $template_part = (isset($wp_query->query_vars['property_id'])
                    ? "property"
                    : "properties"
                );
                break;
            
            case "rets":
                $template_part = "rets";
                break;
                
            case "compare":
                $template_part = "compare";
                break;
                
            case "map":
                $template_part = "map";
                break;
                
            default: 
                $template_part = (is_front_page() ? "main" : "content");
        }
        
        return $template_part;
    }
        
    public static function loadData($part)
    {          
        // Load structures
        if (in_array($part, ["map", "compare", "properties", "property"])) {
            $Properties = new Structures\Properties();
        }
        
        // Handle search form
        $search = (isset($_POST['search_property']) ? (object)$_POST['search_property'] : null);
        $data = (object)['search'=>$search];
             
        
        // Extract necessary data
        switch ($part) {
            case "map":                  
            case "properties":
                $criterion = self::makeCriterion($search);            
                $data->properties = $Properties->get($criterion);
                break;            
            
            case "compare":
                $comparsions = [];
                $properties = [];
                
               
                if (!empty($_COOKIE['comparsions'])) {
                    $decoded = json_decode(stripcslashes($_COOKIE['comparsions']));                    
                    
                    if (!json_last_error()) {
                       $comparsions = $decoded;
                    }  
                }                
                
                foreach ($comparsions as $comparsion) {
                    $properties[] = $Properties->getDetailed((int)$comparsion->id);
                }
                
                // TODO: move to admin panel
                $data->compare_fields = [
                    'publish_date' => "Publish Date",
                    'bedrooms' => "Bedrooms",
                    'bathrooms' => "Bathrooms",
                    'size' => "Square Feet",
                    'Extras' => "Extras",
                    'Gar_type' => "Garage Type",
                    'Gar_spaces' => "Garage Spaces",
                    'Bsmt1_out' => "Basement",
                ];
                
                $data->properties = $properties;
                break;
                
            case "property":
                global $wp_query;
                $property_id = $wp_query->query_vars['property_id'];
                $data->property = $Properties->getDetailed($property_id);
                break;
            
            case "content":
                global $wp_query;
                $data->post = get_post($wp_query->queried_object_id);
                break;
                
            case "rets":
                // Fixing start
                $start = new \Datetime();
                
                
                // Do the action
                $credentials = Administration\Connection::getStoredOptions();
                $Rets = new Libs\Rets($credentials->url, $credentials->login, $credentials->password);
                $Rets->login();
                $processed_property = $Rets->processProperties(1);
                $data->property = $processed_property; 
                // $data->rets_data = $Rets->synchronizeProperties();
                
                
                // Fixing end and interval
                $end = new \Datetime();
                $interval = $start->diff($end);
                
                
                // Attach info about execution time
                $data->execition_time = $interval->format("%s");
                
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
        $criterion['limit'] = 120;

        
        
        return $criterion;
    }
}
