<?php
namespace Vividcrestrealestate\Core\Libs;

class Ancillary 
{   
    public static function toObject(array $array) 
    {
        return json_decode(json_encode($array));
    }
}
