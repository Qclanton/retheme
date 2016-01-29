<?php
// Load Wordpress core
require_once( __DIR__ . "/../../../../../wp-load.php" );



// Set system params
date_default_timezone_set(get_option("timezone_string"));



// Set params
$classes = ["ResidentialProperty", "CondoProperties"];



// Init Lib
$Exchange = new \Vividcrestrealestate\Core\Administration\Exchange();



// Fetch properties for all classes if it necessary
$current_date = new \Datetime();

foreach ($classes as $class) {
    $last_fetch_date = new \Datetime(get_option("rets_exchange_last_fetch_date_{$class}", "2000-01-01"));            
    $interval = $current_date->diff($last_fetch_date);
    
    if ($interval->format("%d") > 0) {
        $Exchange->fetchRawData($class);
    } else {
        echo date("Y-m-d H:i:s"). " | There is no properties to fetch for class \"{$class}\": Last Fetch Date: " . $last_fetch_date->format("Y-m-d H:i:s")  . "; Interval: " . $interval->format("%d") . " days" . PHP_EOL;
    }
}



// Process properties
$Exchange->processData(200);



// Get the messages
$messages = array_merge((array)$Exchange->getPositiveMessages(), (array)$Exchange->getNegativeMessages());



// Show messages
echo date("Y-m-d H:i:s"). " | " . implode(PHP_EOL . date("Y-m-d H:i:s") . " | ", $messages) . PHP_EOL;
