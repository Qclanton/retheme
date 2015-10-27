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
                // Part "category" does not have template for display
                if ($wp_query->is_category) {         
                    $main_post = $wp_query->posts[0];
                    
                    // Redirect to main page if category is empty
                    if (empty($main_post)) {
                        wp_redirect(get_site_url());
                    }
                    
                    // Redirect to post page int the other case
                    wp_redirect(get_permalink($main_post->id));
                }
                
                $template_part = (is_front_page() ? 
                    "main" 
                    : (!empty($wp_query->query_vars['s']) 
                        ? "search_posts" 
                        : "content")
                );
        }
        
        return $template_part;
    }
        
    public static function loadData($part)
    {    
        // Define coordinates by ip
        $coordinates = Libs\Address::recognizeCoordinates();
              
        // Load structures
        $Properties = new Structures\Properties();
        
        // Handle search form
        $search = (isset($_POST['search_property']) ? (object)Forms::sanitize($_POST['search_property']) : new \stdClass);
        
        if (empty($search->address)) {
            // $search->address = $coordinates->city;
        }
        
        // Set default data
        $data = (object)[
            'search' => $search
        ];             
        
        
        
        // Extract necessary data
        switch ($part) {            
            case "main":
                $criterion = self::makeCriterion($search);            
                $data->properties = $Properties->get($criterion);
                $data->recent_properties = $Properties->get([
                    'orderby' => "publish_date",
                    'order' => "DESC",
                    'limit' => 4
                ]);
                break;
                
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
                
                // Fetch property
                $property_id = $wp_query->query_vars['property_id'];
                $property = $Properties->getDetailed($property_id);
                
                // Fetch simlar properties
                $range = 50000;
                $min_price = $property->price - $range;
                $max_price = $property->price + $range;
                $similar_properties = $Properties->get([
                    'confines' => [
                        "`city`='{$property->city}'",
                        "`price`>={$min_price}",
                        "`price`<={$max_price}"
                    ],
                    'limit' => 4
                ]);
                
                // Assign data
                $data->property = $property;
                $data->similar_properties = $similar_properties;
                break;
            
            case "search_posts":
                global $wp_query;
                
                $search_query = new \WP_Query([
                    's' => $wp_query->query_vars['s'],
                    'posts_per_page' => 999,
                ]);	
                
                $data->posts = $search_query->posts;
                $data->search_query = $wp_query->query_vars['s'];
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
                
        if (!empty($search->type)) {
            $confines[] = "`type`='{$search->type}'";
        }
        
        if (!empty($search->deal_type)) {
            $confines[] = "`deal_type`='{$search->deal_type}'";
        }
        
        
        
        $criterion['confines'] = $confines;
        $criterion['limit'] = 1000;

        
        
        return $criterion;
    }
}
