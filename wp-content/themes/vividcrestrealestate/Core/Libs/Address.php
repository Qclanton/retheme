<?php
namespace Vividcrestrealestate\Core\Libs;

class Address 
{   
    public static function recognize($addrress_string) 
    {
        // Set default data
        $default_info = (object)[
            'address' => $addrress_string,
            'country' => "",
            'city' => "",
            'sublocality' => "",
            'neighborhood' => "",
            'postal_code' => "",
            'latitude' => 0,
            'longitude' => 0            
        ];
        
        
        
        // Send request to api
        $api_url = "https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyCVqfx4JMQmo90Oj8aM22ob-UUr6WqS6sk&signed_in=true&address=";
        $context = stream_context_create(['http'=>['timeout'=>5]]);         
        $api_data = json_decode(@file_get_contents($api_url . urlencode($addrress_string), false, $context)); 
        
        
        
        // Return default data if request failed
        if (
            json_last_error() ||
            !isset($api_data->status) || 
            $api_data->status !== "OK" || 
            !isset($api_data->results[0]->address_components) ||
            !isset($api_data->results[0]->formatted_address) ||
            !isset($api_data->results[0]->geometry->location->lat) ||
            !isset($api_data->results[0]->geometry->location->lng)            
        ) {                
            return $default_info;
        }
        
        
        
        // Extract necessary data drom API answer
        $info = $default_info;
        $result = $api_data->results[0];
        $address_components = $result->address_components;        
        $info->address = $result->formatted_address;
        $info->latitude = $result->geometry->location->lat;
        $info->longitude = $result->geometry->location->lng;
        
        foreach ($address_components as $component) {
            // Check object
            if (
                !isset($component->long_name) ||
                !isset($component->types) ||
                !is_array($component->types)                
            ) {
                continue;
            }
            
            // Try to extract data            
            if (in_array("country", $component->types)) {
                $info->country = $component->long_name;                
            } elseif (in_array("locality", $component->types)) {
                $info->city = $component->long_name;  
            } elseif (in_array("sublocality", $component->types)) {
                $info->sublocality = $component->long_name;  
            } elseif (in_array("neighborhood", $component->types)) {
                $info->neighborhood = $component->long_name;  
            } elseif (in_array("postal_code", $component->types)) {
                $info->postal_code = $component->long_name;  
            } 
        }
        
        
        
        // Return collected information
        return $info;
    }
    
    public static function defineIp()
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }


        return $ip;  
    }
    
    public static function recognizeCoordinates($ip=null)
    {
        // Define Ip
        $ip = (!empty($ip) ? $ip : self::defineIp());
        
        
        
        // Set default data
        $default_info = (object)[
            'city' => "Toronto",
            'latitude' => 43.666667, 
            'longitude' => -79.416667 
        ];
        
        
        
        // Send request to api
        $api_url = "http://ip-api.com/json/";
        $context = stream_context_create(['http'=>['timeout'=>5]]);         
        $api_data = json_decode(@file_get_contents($api_url . $ip, false, $context)); 
        
        
        
        // Return default data if request failed
        if (
            json_last_error() ||
            !isset($api_data->status) || 
            $api_data->status !== "success" || 
            !isset($api_data->city) ||
            !isset($api_data->lat) ||
            !isset($api_data->lon)      
        ) {                
            return $default_info;
        }
        
        
        
        // Return info
        return (object)[
            'city' => $api_data->city,
            'latitude' => $api_data->lat, 
            'longitude' => $api_data->lon 
        ];
    }
}
