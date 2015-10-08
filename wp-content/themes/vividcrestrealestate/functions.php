<?php
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





// Test
$Properties = new \Vividcrestrealestate\Core\Properties();
$properties = $Properties->get(1);
// echo "<pre>"; var_dump($properties); "</pre>";

