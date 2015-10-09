<?php
namespace Vividcrestrealestate\Core;

class Ajax 
{   
    public static function searchProperties()
    {
        return json_encode(Router::loadData("properties"));
    }
}
