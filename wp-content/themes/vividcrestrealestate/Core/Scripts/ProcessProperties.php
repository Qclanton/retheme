<?php
// Load Wordpress core
require_once( __DIR__ . "/../../../../../wp-load.php" );



// Set system params
date_default_timezone_set(get_option("timezone_string"));



// Set params
$classes = ["ResidentialProperty"];



// Init Lib
$Exchange = new \Vividcrestrealestate\Core\Administration\Exchange();



// Fetch properties for all classes if it necessary
$current_date = new \Datetime();
$last_fetch_date = new \Datetime(get_option("rets_exchange_last_fetch_date", "2000-01-01"));            
$interval = $current_date->diff($last_fetch_date);

if ($interval->format("%d") > 0) {
    foreach ($classes as $class) {
        $Exchange->fetchRawData($class);
    }
}


// Process properties
$Exchange->processData(200);



// Get the messages
$messages = array_merge((array)$Exchange->getPositiveMessages(), (array)$Exchange->getNegativeMessages());



// Show messages
echo date("Y-m-d H:i:s"). " | " . implode(PHP_EOL . date("Y-m-d H:i:s") . " | ", $messages) . PHP_EOL;
