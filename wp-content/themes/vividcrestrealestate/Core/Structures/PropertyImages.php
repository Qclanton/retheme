<?php
namespace Vividcrestrealestate\Core\Structures;

class PropertyImages extends \Vividcrestrealestate\Core\Libs\Data 
{
	public $table = "property_images";
    
	public $fields = [
		'id' => [
			'type' => "%d",
			'default' => null,
			'editable_fl' => false
		],
        'property_id' => [
			'type' => "%d",
			'default' => null,
			'editable_fl' => true
		],
        'link' => [
			'type' => "%s",
			'default' => "",
			'editable_fl' => true
		],
        'title' => [
			'type' => "%s",
			'default' => "",
			'editable_fl' => true
		]
	];
}
