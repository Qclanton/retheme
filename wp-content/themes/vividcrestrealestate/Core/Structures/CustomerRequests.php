<?php
namespace Vividcrestrealestate\Core\Structures;

class CustomerRequests extends \Vividcrestrealestate\Core\Libs\Data 
{
	public $table = "customer_requests";
    
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
        'creation_date' => [
			'type' => "%s",
			'default' => "",
			'editable_fl' => true,
            'date_fl' => true
		],
        'type' => [
			'type' => "%s",
			'default' => "",
			'editable_fl' => true
		],
        'name' => [
			'type' => "%s",
			'default' => "",
			'editable_fl' => true
		],
        'phone' => [
			'type' => "%s",
			'default' => "",
			'editable_fl' => true
		],
        'email' => [
			'type' => "%s",
			'default' => "",
			'editable_fl' => true
		],
        'message' => [
			'type' => "%s",
			'default' => "",
			'editable_fl' => true
		],
        'first_preferred_date' => [
			'type' => "%s",
			'default' => "",
			'editable_fl' => true
		],
        'second_preferred_date' => [
			'type' => "%s",
			'default' => "",
			'editable_fl' => true
		]
	];
}
