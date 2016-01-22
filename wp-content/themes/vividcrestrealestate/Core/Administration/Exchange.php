<?php
namespace Vividcrestrealestate\Core\Administration;

use \Vividcrestrealestate\Core\Libs;
use \Vividcrestrealestate\Core\Structures;

class Exchange extends \Vividcrestrealestate\Core\Libs\Administration 
{   
    public static $positive_messages;
    public static $negative_messages;
    
    
    
    
    
    public static function getOptionsPrefix()
    {
        return "rets_exchange_";
    }
    
    public static function getOptionsList()
    {
        return ["last_fetch_date", "is_processing_in_progress"];
    }    
    
    public static function getAllowedActions()
    {
        return ["set", "show", "fetchRawData", "processData"];
    }
    
    public static function getView()
    {
        return "admin/rets/exchange";
    }
    
    public static function getPositiveMessages()
    {
        return self::$positive_messages;
    }
    
    public static function getNegativeMessages()
    {
        return self::$negative_messages;
    }
    
    
    
    
    
    public static function show($params=null)
    {
        // Init libs
        $ProcessingProperties = new Structures\ProcessingProperties();
        
        
        
        // Add info about unprocessed properties
        $unprocessed_qty = $ProcessingProperties->getNumberOfUnprocessed();
        
        if ($unprocessed_qty > 0) {
            self::$positive_messages[] = "There is {$unprocessed_qty} unprocessed properties";
        }
        
        
        
        // Add info about fetched today properties
        $fetched_today_qty = $ProcessingProperties->getNumberOfFetched(date("Y-m-d"));
        
        if ($fetched_today_qty > 0) {
            self::$positive_messages[] = "There is {$fetched_today_qty} fetched properties today";
        }
        
        
        
        // Add info about processed today properties
        $processed_today_qty = $ProcessingProperties->getNumberOfProcessed(date("Y-m-d"));
        
        if ($processed_today_qty > 0) {
            self::$positive_messages[] = "There is {$processed_today_qty} processed properties today";
        }
        
        
        
        // Do the regular action 
        parent::show();
    }
    
    public static function mergeWithDefaultValues($name, $value)
    {  
        // Define default values
        $default = [
            'last_fetch_date' => "2000-01-01 00:00:00",
            'is_processing_in_progress' => false
        ];
        
        
        
        // Set default values against of undefnid options
        if (array_key_exists($name, $default)) {  
            $value = (is_array($default[$name])
                ? array_replace_recursive($default[$name], (array)$value)
                : (empty($value) ? $default[$name] : $value)
            );            
        }   
        
        
        
        // Return result       
        return $value;
    }
    
    
    
    
    
    public static function fetchRawData($class=null)
    {
        // Check params
        if (empty($class) && empty($_POST['class'])) {
            self::$negative_messages[] = "Class is not defined";
            return false;
        }
        
        
        
        // Define vars
        $ignore_daily_restrictions = (!empty($_POST['ignore_daily_restrictions'])); 
        $start = (!empty($_POST['start']) ? $_POST['start'] : date("Y-m-d\T00:00:00", strtotime("-3 days")));
        $end = (!empty($_POST['end']) ? $_POST['end'] : date("Y-m-d\T00:00:00", strtotime("-1 day")));
        $class = (!empty($class) ? $class : $_POST['class']);        
        $credentials = Connection::getStoredOptions();
        
        
        
        // Check the neceessity of fetch properties
        if (!$ignore_daily_restrictions) {
            $options = self::getStoredOptions();
            
            $current_date = new \Datetime();
            $last_fetch_date = new \Datetime($options->last_fetch_date);            
            $interval = $current_date->diff($last_fetch_date);
            
            if ($interval->format("%d") == 0) {
                self::$negative_messages[] = "Properties has been already fetched today";
                return;
            } else {
                self::storeOptions(['last_fetch_date'=>date("Y-m-d H:i:s")]);
            } 
        }        
        
        
        
        // Init Libs
        $Rets = new Libs\Rets($credentials->url, $credentials->login, $credentials->password);
        
        if (!$Rets->login()) { 
            self::$negative_messages[] = "Can't connect to RETS server";
            return false;
        }   
                


        // Fetch the properties
        $fetched_qty = $Rets->fetchProperties($class, $start, $end);
        
        
        
        // Add message info about fetched properties  
        self::$positive_messages[] = "Saved {$fetched_qty} properties";
    }
    
    public static function processData($batch_size=null)
    {
        // Check params
        if (empty($batch_size) && empty($_POST['batch_size'])) {
            self::$negative_messages[] = "Batch size is not defined";
            return false;
        }
        
        
        
        // Pin the time of start
        $start = new \Datetime();
        
        
        
        // Define vars
        $options = self::getStoredOptions();
        $batch_size = (!empty($batch_size) ? $batch_size : $_POST['batch_size']);        
        $credentials = Connection::getStoredOptions();
        
        
        
        // Define processing progress status
        if ($options->is_processing_in_progress) {
            self::$negative_messages[] = "Properties is already processing";
            return;
        } else {
            self::storeOptions(['is_processing_in_progress'=>true]);
        }      
        
        

        // Init Libs
        $ProcessingProperties = new Structures\ProcessingProperties();
        
        
        
        // Define quantity of processing properties
        $unprocecced_qty = $ProcessingProperties->getNumberOfUnprocessed();
        $processed_qty = ($batch_size >= $unprocecced_qty ? $batch_size : $unprocecced_qty);  
        $processed_today_qty = $ProcessingProperties->getNumberOfProcessed(date("Y-m-d"));    
           
            
            
        // Define necessity of processing
        if ($unprocecced_qty == 0 || $processed_today_qty >= 2000) {
            // Inform if nothing to do
            self::$negative_messages[] = ($unprocecced_qty == 0 
                ? "There is no unprocessed properties"
                : "Daily limit for processing properties is exceeded (limit: 2000, processed: {$processed_today_qty})"
            );
            
            // Remove processing lock
            self::storeOptions(['is_processing_in_progress'=>false]);
            
            // Stop working
            return;
        }
        
        
        
        // Process properties 
        try {    
            $Rets = new Libs\Rets($credentials->url, $credentials->login, $credentials->password);
            
            if (!$Rets->login()) { 
                self::$negative_messages[] = "Can't connect to RETS server";
                return false;
            }   
                
            $Rets->processProperties($batch_size);
        } catch (\Exception $e) {
            self::$negative_messages[] = "Error due processing properties: {$e->getMessage()}";
            $processed_qty = 0;
        }                
        
               
        
        // Change processing progress status
        self::storeOptions(['is_processing_in_progress'=>false]);
        
        
        
        // Fetch time info
        $end = new \Datetime();
        $interval = $start->diff($end);
        $spent_seconds = $interval->format("%s");
        
        
        
        // Add message info about processed properties        
        self::$positive_messages[] = "{$batch_size} properties has been processed for the {$spent_seconds} seconds";
        
        
        
        // Edit info about number of unprocessed properties
        $remaining_qty = $ProcessingProperties->getNumberOfUnprocessed();
        
        array_walk(self::$positive_messages, function(&$message) use ($remaining_qty) { 
            $message = preg_replace(
                "/^There is (\d*) unprocessed properties$/", 
                "There is {$remaining_qty} unprocessed properties",
                 $message
            );
        });
    }    
}
