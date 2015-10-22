<?php
namespace Vividcrestrealestate\Core\Administration;

class Exchange extends \Vividcrestrealestate\Core\Libs\Administration 
{   
    public static $positive_messages;
    public static $negative_messages;
    
    
    
    
    public static function getOptionsPrefix()
    {
        return "rets_exchange_";
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
    
    
    
    
    public static function show()
    {
        $ProcessingProperties = new \Vividcrestrealestate\Core\Structures\ProcessingProperties();
        
        $number = $ProcessingProperties->getNumberOfUnprocessed();
        self::$positive_messages[] = "There is {$number} unprocessed propertires";
        
        parent::show();
    }
    
    public static function fetchRawData()
    {
        if (empty($_POST['start']) || empty($_POST['end']) || empty($_POST['class'])) {
            self::$negative_messages[] = "Invalid params";
            return false;
        }
        
        $start = $_POST['start'];
        $end = $_POST['end'];
        $class = $_POST['class'];           
        $credentials = Connection::getStoredOptions();
        
        $Rets = new \Vividcrestrealestate\Core\Libs\Rets($credentials->url, $credentials->login, $credentials->password);
        
        if (!$Rets->login()) { 
            self::$negative_messages[] = "Can't connect to RETS server";
            return false;
        }   
                

        $fetched = $Rets->fetchProperties($class, $start, $end);
        
        self::$positive_messages[] = "Saved {$fetched} properties";
    }
    
    public static function processData()
    {
        if (empty($_POST['batch_size'])) {
            self::$negative_messages[] = "Invalid params";
            return false;
        }
        
        $start = new \Datetime();
        $batch_size = $_POST['batch_size'];       
        $credentials = Connection::getStoredOptions();
        
        $Rets = new \Vividcrestrealestate\Core\Libs\Rets($credentials->url, $credentials->login, $credentials->password);
        
        if (!$Rets->login()) { 
            self::$negative_messages[] = "Can't connect to RETS server";
            return false;
        }   
        
        
        
        $Rets->processProperties($batch_size);
        $end = new \Datetime();
        $interval = $start->diff($end);
        $spent_seconds = $interval->format("%s");
        
        self::$positive_messages = [
            "There is " . (new \Vividcrestrealestate\Core\Structures\ProcessingProperties())->getNumberOfUnprocessed() . " unprocessed propertires",
            "{$batch_size} properties has been processed for the {$spent_seconds} seconds"
        ];
    }    
}
