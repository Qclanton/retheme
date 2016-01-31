<?php
// Load Wordpress core
require_once( __DIR__ . "/../../../../../wp-load.php" );



// Set system params
date_default_timezone_set(get_option("timezone_string"));



// Fetch DB connection
global $wpdb;



// Process
foreach (["buy", "rent"] as $deal_type) {
    $period = get_option("rets_expiration_period_for_{$deal_type}", "3 month");
    $batch_size = get_option("rets_expiration_batch_size_for_{$deal_type}", "100");
    
    // Fetch the ids
    $batch = $wpdb->get_results("
        SELECT `id`, `mls_id`
        FROM {$wpdb->prefix}properties
        WHERE 
            {$wpdb->prefix}properties.`publish_date` < DATE_SUB(CURDATE(), INTERVAL {$period})
            AND {$wpdb->prefix}properties.`deal_type`='{$deal_type}'
        LIMIT {$batch_size}
    ");
    
    
    
    // Make prepared strings
    $properties_ids_string = "'";
    $mls_ids_string = "'";
    
    foreach ($batch as $i=>$ids) { 
        $properties_ids_string .= $ids->id . "'";
        $mls_ids_string .= $ids->mls_id . "'";
        
        if ($i != count($batch)-1) {
            $properties_ids_string .= ", '";
            $mls_ids_string .= ", '";
        }
    }
    
    
    
    // Remove from table "processing_properties"
    $wpdb->query("DELETE FROM {$wpdb->prefix}processing_properties WHERE `external_id` IN ({$mls_ids_string})");    
    
    // Remove from table "featured_properties"
    $wpdb->query("DELETE FROM {$wpdb->prefix}featured_properties WHERE `mls_id` IN ({$mls_ids_string})");
    
    // Remove from table "property_info"
    $wpdb->query("DELETE FROM {$wpdb->prefix}property_info WHERE `property_id` IN ({$properties_ids_string})");
    
    // Remove from table "properties"
    $wpdb->query("DELETE FROM {$wpdb->prefix}properties WHERE `id` IN ({$properties_ids_string})");
    
    // Remove directories with photo
    foreach ($batch as $ids) { 
        \Vividcrestrealestate\Core\Libs\Ancillary::removeDirectory(get_template_directory() . "/images/rets/{$ids->mls_id}");
        \Vividcrestrealestate\Core\Libs\Ancillary::removeDirectory(get_template_directory() . "/images/rets_cached/{$ids->mls_id}");
    }    
    
    
    
    // Add message
    $messages[] = "Removed " . count($batch) . " properties with deal type \"{$deal_type}\". MLS #: " . str_replace("'", "", $mls_ids_string);
}
    


// Show messages
echo date("Y-m-d H:i:s"). " | " . implode(PHP_EOL . date("Y-m-d H:i:s") . " | ", $messages) . PHP_EOL;
