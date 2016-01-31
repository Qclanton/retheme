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
    
    
    
    public function set($data, $class=null) {
        return (is_object($data) ? $this->setOne($data) : $this->setAll($data, $class));
    }
        
    protected function setAll($properties, $class=null)
    {        
        foreach ($properties as $property) {
            $property = (object)$property;
            $existed = $this->getOne($property->Ml_num, false, "external_id");
            
            // Set data only for new properties
            if (empty($existed)) {
                $this->setOne((object)[
                    'external_id' => $property->Ml_num,
                    'creation_date' => date("Y-m-d H:i:s"),
                    'processing_date' => date("Y-m-d H:i:s"),
                    'class' => $class,
                    'data' => json_encode($property),
                    'status' => "NEW"
                ]);
            }
        }
        
        return $this;
    }
    
    public function getNumberOfUnprocessed()
    {
        $query = "SELECT COUNT(`id`) FROM {$this->Db->prefix}{$this->table} WHERE `status`='NEW'";
        
        return $this->Db->get_var($query);
    }
    
    public function getNumberOfFetched($start, $end=null)
    {
        $start = (new \Datetime($start))->format("Y-m-d H:i:s");
        $end = (!empty($end) 
            ? (new \Datetime($end))->format("Y-m-d H:i:s")
            : (new \Datetime($start))->modify("+1 day")->format("Y-m-d H:i:s")
        );
        
        $query = "SELECT COUNT(`id`) FROM {$this->Db->prefix}{$this->table} WHERE `creation_date`>='{$start}' AND `creation_date`<'{$end}'";

        return $this->Db->get_var($query);
    }
    
    public function getNumberOfProcessed($start, $end=null)
    {
        $start = (new \Datetime($start))->format("Y-m-d H:i:s");
        $end = (!empty($end) 
            ? (new \Datetime($end))->format("Y-m-d H:i:s")
            : (new \Datetime($start))->modify("+1 day")->format("Y-m-d H:i:s")
        );
        
        $query = "SELECT COUNT(`id`) FROM {$this->Db->prefix}{$this->table} WHERE `status`!='NEW' AND `creation_date`>='{$start}' AND `creation_date`<'{$end}'";

        return $this->Db->get_var($query);
    }
}
