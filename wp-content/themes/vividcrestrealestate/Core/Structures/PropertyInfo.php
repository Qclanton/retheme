<?php
namespace Vividcrestrealestate\Core\Structures;

class PropertyInfo extends \Vividcrestrealestate\Core\Libs\Data 
{
	public $table = "property_info";
    
	public $fields = [
		'id' => [
			'type' => "%d",
			'default' => null,
			'editable_fl' => false
		],
        'property_id' => [
			'type' => "%d",
			'default' => "",
			'editable_fl' => true
		],
        'key' => [
			'type' => "%s",
			'default' => "",
			'editable_fl' => true
		],
        'value' => [
			'type' => "%s",
			'default' => "",
			'editable_fl' => true
		],
	];
}
