<?php
// Load js
add_action("wp_enqueue_scripts", function() {
    $template_part = \Vividcrestrealestate\Core\Router::definePart();
    
    if ($template_part == "map") {
        // Load Google Maps Api Library
        wp_enqueue_script("google-maps-api", "https://maps.googleapis.com/maps/api/js?libraries=places,drawing,geometry");
        
        // Load clusteriztion library
        wp_enqueue_script("google-maps-clusterization", "https://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/src/markerclusterer_compiled.js");
        
        // Load handler
        wp_enqueue_script("vividcrest-properties-sort", get_template_directory_uri() . "/js/properties/map.js", ["jquery"]);  
    } else if ($template_part == "properties") {
        // Load lib for cookie
        wp_enqueue_script("jquery-cookies",  get_template_directory_uri() . "/js/libs/jquery.cookie.js", ["jquery"]);
        
        wp_enqueue_script("vividcrest-properties-pagination", get_template_directory_uri() . "/js/properties/pagination.js", ["jquery"]);
        wp_enqueue_script("vividcrest-properties-compare", get_template_directory_uri() . "/js/properties/compare.js", ["jquery"]);
        wp_enqueue_script("vividcrest-properties-sort", get_template_directory_uri() . "/js/properties/sort.js", ["jquery"]);
    }
    
    
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





// Define function for generate of an excerpt
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

	if ($max_symbols) {
		$excerpt = substr($excerpt, 0, $max_symbols) . "...";
	}

    if (!empty($more_button)) {
        $excerpt = "{$excerpt} {$more_button}";
    }
    
    
	return $excerpt;
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
    array_push($vars, "property_id", "search_hash");
    
    return $vars;
});

add_filter("rewrite_rules_array", function($rules) { 
    $newrules['properties/search/([0-9A-Fa-f]{8})'] = 'index.php?pagename=properties&search_hash=$matches[1]';
	$newrules['properties/([0-9]{1,10})'] = 'index.php?pagename=properties&property_id=$matches[1]';
    //$newrules['compare'] = 'index.php?pagename=compare';
    // $newrules['rets/'] = 'index.php?pagename=rets';
    
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
});



// Ajax hanlers
add_action("wp_ajax_search_properties", ["\Vividcrestrealestate\Core\Ajax", "searchProperties"]);
add_action("wp_ajax_nopriv_search_properties", ["\Vividcrestrealestate\Core\Ajax", "searchProperties"]);
