<?php
// Load js
add_action("wp_enqueue_scripts", function() {
    wp_enqueue_script("free-form-sender", get_template_directory_uri() . "/js/tabs.js", ["jquery"]);   
});





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
    // $newrules['rets/'] = 'index.php?pagename=rets';
    
	return $newrules + $rules;
});

add_action("wp_loaded", function() { 	
	global $wp_rewrite;
    
	$wp_rewrite->flush_rules();
});	




// Ajax hanlers
add_action("wp_ajax_search_properties", ["\Vividcrestrealestate\Core\Ajax", "searchProperties"]);
add_action("wp_ajax_nopriv_search_properties", ["\Vividcrestrealestate\Core\Ajax", "searchProperties"]);
