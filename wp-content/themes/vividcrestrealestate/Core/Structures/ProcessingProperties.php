<?php
namespace Vividcrestrealestate\Core\Structures;

class ProcessingProperties extends \Vividcrestrealestate\Core\Libs\Data 
{
	public $table = "processing_properties";
    
	public $fields = [
		'id' => [
			'type' => "%d",
			'default' => null,
			'editable_fl' => false
		],
        'external_id' => [
			'type' => "%s",
			'default' => "",
			'editable_fl' => true
		],
        'creation_date' => [
			'type' => "%s",
			'default' => "",
			'editable_fl' => true,
            'date_fl' => true
		],
        'processing_date' => [
			'type' => "%s",
			'default' => "",
			'editable_fl' => true,
            'date_fl' => true
		],
        'class' => [
			'type' => "%s",
			'default' => "",
			'editable_fl' => true
		],
        'data' => [
			'type' => "%s",
			'default' => "",
			'editable_fl' => true
		],
        'status' => [
			'type' => "%s",
			'default' => "NEW",
			'editable_fl' => true
		]
	];
    
    
    
        
    protected function setAll($properties)
    {        
        foreach ($properties as $property) {
            $property = (object)$property;
            
            $this->setOne((object)[
                'external_id' => $property->Ml_num,
                'creation_date' => date("Y-m-d H:i:s"),
                'processing_date' => date("Y-m-d H:i:s"),
                'class' => "ResidentialProperty", // <-BAD
                'data' => json_encode($property),
                'status' => "NEW"
            ]);
        }
        
        return $this;
    }
    
    public function getNumberOfUnprocessed()
    {
        $query = "SELECT COUNT(`id`) FROM {$this->Db->prefix}{$this->table} WHERE `status`='NEW'";
        
        return $this->Db->get_var($query);
    }
}
