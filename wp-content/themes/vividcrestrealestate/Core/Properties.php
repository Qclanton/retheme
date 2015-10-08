<?php
namespace Vividcrestrealestate\Core;

class Properties extends \Vividcrestrealestate\Core\Libs\Data 
{
	public $table = "properties";
    
	public $fields = [
		'id' => [
			'type' => "%d",
			'default' => null,
			'editable_fl' => false
		],
        'mls_id' => [
			'type' => "%d",
			'default' => "",
			'editable_fl' => true
		],
        'country' => [
			'type' => "%s",
			'default' => "",
			'editable_fl' => true
		],
        'city' => [
			'type' => "%s",
			'default' => "",
			'editable_fl' => true
		],
        'address' => [
			'type' => "%s",
			'default' => "",
			'editable_fl' => true
		],
        'latitude' => [
			'type' => "%f",
			'default' => 0,
			'editable_fl' => true
		],
        'longitude' => [
			'type' => "%f",
			'default' => 0,
			'editable_fl' => true
		],
        'bedrooms' => [
			'type' => "%d",
			'default' => 0,
			'editable_fl' => true
		],
        'bathrooms' => [
			'type' => "%d",
			'default' => 0,
			'editable_fl' => true
		],
        'type' => [
			'type' => "%s",
			'default' => "House",
			'editable_fl' => true
		],
        'deal_type' => [
			'type' => "%d",
			'default' => "buy",
			'editable_fl' => true
		],
        'price' => [
			'type' => "%f",
			'default' => 0,
			'editable_fl' => true
		],
        'size' => [
			'type' => "%d",
			'default' => 0,
			'editable_fl' => true
		]
	];
    
    
    
    protected function getOne($primary) 
    {
        $property = parent::getOne($primary);
        $property->info = (new PropertyInfo)->get(["`property_id`='{$property->id}'"]);
        
        return $property;
    }
}
