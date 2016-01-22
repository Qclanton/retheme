<?php
namespace MortgagesRates;

class Helpers {
	public static function loadData($layout) 
    {		
		global $wpdb;
		
		$file_name = self::toUnderscoreCase($layout) . ".php";
		$class_name = __NAMESPACE__ . "\\" . self::toCamelCase($layout);
		
		require_once __DIR__ . "/../data/{$file_name}";		
		$Data = new $class_name($wpdb);
		
		return $Data;
	}

    public static function chooseTemplate($name) 
    {
        $theme_template = get_template_directory() . "/widgets/{$name}";
        $plugin_template = __DIR__ . "/../views/{$name}";
        
        return (file_exists($theme_template) ? $theme_template : $plugin_template);
    }
    
	public static function render($view, $vars=[]) 
    {	
		extract($vars);
		
		ob_start();		
		require_once($view);
		$content = ob_get_contents();
		ob_end_clean();
		
		return $content;
	}
	
	public static function toCamelCase($string) 
    {
		return str_replace(" ", "", ucwords(str_replace("_", " ", $string)));		 
	}

	public static function toUnderscoreCase($string) 
    {
		return strtolower(preg_replace("/([a-z])([A-Z])/", "$1_$2", $string));
	}
	
	public static function toArray($object) 
    {
		return json_decode(json_encode($object), true);
	}
	
	public static function array_column($input = null, $columnKey = null, $indexKey = null)
    {
        // Using func_get_args() in order to check for proper number of
        // parameters and trigger errors exactly as the built-in array_column()
        // does in PHP 5.5.
        $argc = func_num_args();
        $params = func_get_args();

        if ($argc < 2) {
            trigger_error("array_column() expects at least 2 parameters, {$argc} given", E_USER_WARNING);
            return null;
        }

        if (!is_array($params[0])) {
            trigger_error('array_column() expects parameter 1 to be array, ' . gettype($params[0]) . ' given', E_USER_WARNING);
            return null;
        }

        if (!is_int($params[1])
            && !is_float($params[1])
            && !is_string($params[1])
            && $params[1] !== null
            && !(is_object($params[1]) && method_exists($params[1], '__toString'))
        ) {
            trigger_error('array_column(): The column key should be either a string or an integer', E_USER_WARNING);
            return false;
        }

        if (isset($params[2])
            && !is_int($params[2])
            && !is_float($params[2])
            && !is_string($params[2])
            && !(is_object($params[2]) && method_exists($params[2], '__toString'))
        ) {
            trigger_error('array_column(): The index key should be either a string or an integer', E_USER_WARNING);
            return false;
        }

        $paramsInput = $params[0];
        $paramsColumnKey = ($params[1] !== null) ? (string) $params[1] : null;

        $paramsIndexKey = null;
        if (isset($params[2])) {
            if (is_float($params[2]) || is_int($params[2])) {
                $paramsIndexKey = (int) $params[2];
            } else {
                $paramsIndexKey = (string) $params[2];
            }
        }

        $resultArray = array();

        foreach ($paramsInput as $row) {

            $key = $value = null;
            $keySet = $valueSet = false;

            if ($paramsIndexKey !== null && array_key_exists($paramsIndexKey, $row)) {
                $keySet = true;
                $key = (string) $row[$paramsIndexKey];
            }

            if ($paramsColumnKey === null) {
                $valueSet = true;
                $value = $row;
            } elseif (is_array($row) && array_key_exists($paramsColumnKey, $row)) {
                $valueSet = true;
                $value = $row[$paramsColumnKey];
            }

            if ($valueSet) {
                if ($keySet) {
                    $resultArray[$key] = $value;
                } else {
                    $resultArray[] = $value;
                }
            }

        }

        return $resultArray;
    }
}
