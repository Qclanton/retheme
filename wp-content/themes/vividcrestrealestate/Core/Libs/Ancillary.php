<?php
namespace Vividcrestrealestate\Core\Libs;

class Ancillary 
{   
    public static function toObject(array $array) 
    {
        return (object)json_decode(json_encode($array));
    }
}
