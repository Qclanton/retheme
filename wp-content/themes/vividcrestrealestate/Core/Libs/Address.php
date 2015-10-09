<?php
namespace Vividcrestrealestate\Core\Libs;

class Address 
{   
    public static function recognize($addrress_string) 
    {
        // Set default data
        $default_info = (object)[
            'address' => $addrress_string,
            'country' => "Unknown",
            'city' => "Unknown",
            'latitude' => 0,
            'longitude' => 0            
        ];
        
        
        
        // Send request to api
        $api_url = "https://maps.googleapis.com/maps/api/geocode/json?address=";
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
            }  
        }
        
        
        
        // Return collected information
        return $info;
    }
}
