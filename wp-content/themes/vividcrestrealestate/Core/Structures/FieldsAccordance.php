<?php
namespace Vividcrestrealestate\Core\Structures;

class FieldsAccordance extends \Vividcrestrealestate\Core\Libs\Data 
{
	public $table = "fields_accordance";
    
	public $fields = [
		'id' => [
			'type' => "%d",
			'default' => null,
			'editable_fl' => false
		],
        'class' => [
			'type' => "%s",
			'default' => "",
			'editable_fl' => true
		],
        'field_name' => [
			'type' => "%s",
			'default' => "",
			'editable_fl' => true
		],
        'field_title' => [
			'type' => "%s",
			'default' => "",
			'editable_fl' => true
		],
        'source' => [
			'type' => "%s",
			'default' => "VALUE",
			'editable_fl' => true
		]
	];
}
