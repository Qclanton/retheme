<?php
// Load js
add_action("wp_enqueue_scripts", function() {
    $template_part = \Vividcrestrealestate\Core\Router::definePart();
    
    // Fetch Google API key
    $key = get_option("rets_connection_google_api_key", "");
    $key_url_part = (!empty($key) ? "key={$key}&" : "");
    
    
    
    if ($template_part == "map") {        
        // Load Google Maps Api Library
        wp_enqueue_script("google-maps-api", "https://maps.googleapis.com/maps/api/js?{$key_url_part}libraries=places,drawing,geometry");
        
        // Load clusteriztion library
        wp_enqueue_script("google-maps-clusterization", "https://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/src/markerclusterer_compiled.js");
        
        // Load handlers
        wp_enqueue_script("vividcrest-google-map-autocomplete", get_template_directory_uri() . "/js/handlers/google_map_autocomplete.js", ["jquery"]);
        wp_enqueue_script("vividcrest-properties-sort", get_template_directory_uri() . "/js/properties/map.js", ["jquery"]);
        wp_enqueue_script("vividcrest-handlers-view_toggle", get_template_directory_uri() . "/js/handlers/view_toggle.js", ["jquery"]); 
    
    
    
    } elseif ($template_part == "properties") {
        // Load Google Maps Api Library
        wp_enqueue_script("google-maps-api", "https://maps.googleapis.com/maps/api/js?{$key_url_part}libraries=places,drawing,geometry");
        
        // Load lib for cookie
        wp_enqueue_script("jquery-cookies",  get_template_directory_uri() . "/js/libs/jquery.cookie.js", ["jquery"]);
        
        // wp_enqueue_script("vividcrest-properties-pagination", get_template_directory_uri() . "/js/properties/pagination.js", ["jquery"]);
        wp_enqueue_script("vividcrest-properties-compare", get_template_directory_uri() . "/js/properties/compare.js", ["jquery"]);
        // wp_enqueue_script("vividcrest-properties-sort", get_template_directory_uri() . "/js/properties/sort.js", ["jquery"]);
        
        wp_enqueue_script("vividcrest-google-map-autocomplete", get_template_directory_uri() . "/js/handlers/google_map_autocomplete.js", ["jquery"]);
        wp_enqueue_script("vividcrest-handlers-view_toggle", get_template_directory_uri() . "/js/handlers/view_toggle.js", ["jquery"]);     
    
    
    
    } elseif ($template_part == "property") {           
        // Datepicker for forms
        wp_enqueue_style("vividcrest-jquery-ui", "//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css");

        wp_enqueue_script("vividcrest-properties-slider", get_template_directory_uri() . "/js/properties/slider.js", ["jquery", "jquery-effects-core", "jquery-effects-slide"]);
        wp_enqueue_script("vividcrest-handlers-agent_contact_form", get_template_directory_uri() . "/js/handlers/agent_contact_form.js", ["jquery", "jquery-ui-datepicker"]);
    
    
    
    } elseif ($template_part == "main") {
        // Load Google Maps Api Library
        wp_enqueue_script("google-maps-api", "https://maps.googleapis.com/maps/api/js?{$key_url_part}libraries=places,drawing,geometry");
        
        // Load clusteriztion library
        wp_enqueue_script("google-maps-clusterization", "https://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/src/markerclusterer_compiled.js");
              
                
        wp_enqueue_script("vividcrest-properties-map", get_template_directory_uri() . "/js/properties/map.js", ["jquery"]);
        wp_enqueue_script("vividcrest-properties-slider", get_template_directory_uri() . "/js/properties/slider.js", ["jquery", "jquery-effects-core", "jquery-effects-slide"]); 
        
        wp_enqueue_script("vividcrest-google-map-autocomplete", get_template_directory_uri() . "/js/handlers/google_map_autocomplete.js", ["jquery"]);
    }
    
    
    
    
    
    wp_enqueue_script("vividcrest-tabs", get_template_directory_uri() . "/js/mobile-menu.js", ["jquery"]); 
    wp_enqueue_script("vividcrest-tabs", get_template_directory_uri() . "/js/tabs.js", ["jquery"]);   
});





// Register menus
if (function_exists("register_nav_menus")) {
    add_action("init", function() { 
        register_nav_menus([
            'top-menu' => "top-menu", 
        ]);  
    }); 
}





// Autoload
spl_autoload_register(function($class) {
    // Set params
    $prefix = "Vividcrestrealestate";
    $base_dir = __DIR__;

    // Check namespace
    $len = strlen($prefix);
    
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    // Get the file
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace("\\", "/", $relative_class) . ".php";
    
    
    // Require file
    if (file_exists($file)) {
        require $file;
    }
});

require __DIR__ . "/Core/Libs/ThirdParty/autoload.php";





// Rewrite rules
add_filter("query_vars", function($vars) { 
    array_push($vars, "property_id");
    
    return $vars;
});

add_filter("rewrite_rules_array", function($rules) { 
	$newrules['properties/([0-9]{1,10})'] = 'index.php?pagename=properties&property_id=$matches[1]';
    
	return $newrules + $rules;
});

add_action("wp_loaded", function() { 	
	global $wp_rewrite;
    
	$wp_rewrite->flush_rules();
});	




// Admin side
add_action("admin_menu", function() { 
    add_menu_page("RETS", "RETS", "edit_posts", "rets", null, "dashicons-admin-multisite", "6.5");
    
    add_submenu_page("rets", "Connection", "Connection", "edit_posts", "rets_connection", ["\Vividcrestrealestate\Core\Administration\Connection", "show"]);
    add_submenu_page("rets", "Exchange", "Exchange", "edit_posts", "rets_exchange", ["\Vividcrestrealestate\Core\Administration\Exchange", "show"]);
	
	remove_submenu_page("rets", "rets");
    
    
    
    add_menu_page("Featured Properties", "Featured Properties", "edit_posts", "featured_properties", ["\Vividcrestrealestate\Core\Administration\FeaturedProperties", "show"], "dashicons-admin-home", "6.6");
    add_menu_page("Customer Requests", "Customer Requests", "edit_posts", "customer_requests", ["\Vividcrestrealestate\Core\Administration\CustomerRequests", "show"], "dashicons-admin-users", "6.7");
});





// Ajax handlers for forms
add_action("wp_ajax_nopriv_vividcrest_send_form", ["\Vividcrestrealestate\Core\Ajax", "saveCustomerRequest"]);
add_action("wp_ajax_vividcrest_send_form", ["\Vividcrestrealestate\Core\Ajax", "saveCustomerRequest"]);





// Ajax handlers for propery actions
add_action("wp_ajax_nopriv_vividcrest_get_property_images", ["\Vividcrestrealestate\Core\Ajax", "getPropertyImages"]);
add_action("wp_ajax_vividcrest_get_property_images", ["\Vividcrestrealestate\Core\Ajax", "getPropertyImages"]);





// Additional functions
function generate_excerpt($content, $more_text="More", $max_symbols=false, $post_id=false) {
	$more_button = $more_text;
	$excerpt = $content;

	if ($post_id) {
		$permalink = get_permalink($post_id);
		$more_button = "<a href='{$permalink}'>{$more_text}</a>";
	}

	if (substr_count($content, "<!--more") !== 0) {
		$excerpt = explode("<!--more", $content)[0];
	}

	if ($max_symbols && strlen($content) > $max_symbols) {
        $max_symbols = strpos($content, " ", $max_symbols);
		$excerpt = substr($excerpt, 0, $max_symbols);
	}

    if (!empty($more_button)) {
        $excerpt = "{$excerpt} {$more_button}";
    }
    
    
	return $excerpt;
}
