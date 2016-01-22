<?php
namespace Vividcrestrealestate\Core\Libs;

class Ancillary 
{   
    public static function toObject(array $array) 
    {
        return (object)json_decode(json_encode($array));
    }
    
    public static function mergeObjects($some_object, $other_object) {
        $some_object = (object)$some_object;
        $other_object = (object)$other_object;
        
        return (object)array_merge((array)$some_object, (array)$other_object);
    }
}
