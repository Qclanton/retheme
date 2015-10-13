<?php
namespace Vividcrestrealestate\Core\Libs;

abstract class Data {
	public $Db;
	public $table;
	public $fields;
	public $default_exemplar;
	public $values_types;
	public $editable_fields;
	public $deleted_marker_column = false;
	public $primary_field = "id";
	public $primary_field_type = "%d";
	public $date_fields = [];
	
    
    
    
	
	protected function defineDefaultExemplar() 
    {
		$exemplar = [];
		
		foreach ($this->fields as $name=>$field) {
			$exemplar[$name] = $field['default'];
		}
		
		$this->default_exemplar = (object)$exemplar;
	}
	
	protected function defineValuesTypes() 
    {
		$types = [];
		
		foreach ($this->fields as $name=>$field) {
			$types[] = $field['type'];
		}
		
		$this->values_types = $types;
	}
	
	protected function defineEditableFields() 
    {
		$editable_fields = [];	
				
		foreach ($this->fields as $name=>$field) {
			if ($field['editable_fl'] == true) {
				$editable_fields[] = "`" . $name . "`=" . $field['type'];
			}
		}
		
		$this->editable_fields = $editable_fields;
	}
	
	protected function defineDeletedMarkerColumn() 
    {
		if (!$this->deleted_marker_column) {
			if (isset($this->fields['deleted_fl'])) {
				$this->deleted_marker_column = "deleted_fl";
			}
		}
	}
	
	protected function definePrimaryField() 
    {		
		foreach ($this->fields as $name=>$field) {
			if (isset($field['primary_fl']) && $field['primary_fl'] == true) {
				$this->primary_field = $name;
				$this->primary_field_type = $field['type'];
			}
		}	
	}
	
	protected function defineDateFields() 
    {		
		foreach ($this->fields as $name=>$field) {
			if (isset($field['date_fl']) && $field['date_fl'] == true) {
				$this->date_fields[$name] = $field;
			}
		}
	}		
	
	public function __construct() 
    {	
        global $wpdb;	
		$this->Db = $wpdb;
		
		$this->defineDefaultExemplar();
		$this->defineValuesTypes();
		$this->defineEditableFields();
		$this->defineDeletedMarkerColumn();
		$this->definePrimaryField();
		$this->defineDateFields();
	}
	
	
	
	
	
	public function set($data) 
    {
		$result = (is_object($data) ? $this->setOne($data) : $this->setAll($data));
		
		return $result;
	}
	
	protected function setOne($exemplar) 
    { 
		if (empty($exemplar->{$this->primary_field})) { 
            $exemplar->{$this->primary_field} = null; 
        }		
		
		if (!empty($this->date_fields)) {
			foreach ($this->date_fields as $name=>$field) {
				if ($exemplar->{$name} == $field['default']) {
					$exemplar->{$name} = date("Y-m-d H:i:s");
				}
			}
		}
		
        
        
		$query = "INSERT INTO " . $this->Db->prefix . $this->table . " VALUES (" . implode(',', $this->values_types) . ")";
        
        if (!empty($this->editable_field))	{
            $query .= " ON DUPLICATE KEY UPDATE 1=1, " . implode(",", $this->editable_fields);
        }



		$params = [$query];
        
		foreach ($this->fields as $name=>$field) { 
            $params[] = $exemplar->{$name}; 
        }
        
		foreach ($this->fields as $name=>$field) { 
            if ($field['editable_fl'] == true) { 
                $params[] = $exemplar->{$name}; 
            } 
        }
		
        
        
		return $this->Db->query(call_user_func_array([$this->Db, "prepare"], $params));
	}
	
	protected function setAll($exemplars) 
    {
		$result = false;
		
		foreach ($exemplars as $exemplar) {
			$exemplar = (object)$exemplar;
            
			if (!isset($exemplar->{$this->primary_field})) { 
                $exemplar->{$this->primary_field} = null; 
            }

			$existed_exemplar = $this->get($exemplar->{$this->primary_field});
			$exemplar = (object)array_merge((array)$existed_exemplar, (array)$exemplar);
			
			$result = $this->setOne($exemplar); 
		}
		
		return $result;
	}
	
	
	
	
	
	public function get($criterion=false) 
    {
		$result = (is_array($criterion) || is_object($criterion) || !$criterion ? $this->getAll($criterion) : $this->getOne($criterion));
		
		return $result;		
	}
	
	protected function getOne($primary) 
    {
		$query = "SELECT * FROM " . $this->Db->prefix . $this->table . " WHERE `" . $this->primary_field . "`=" . $this->primary_field_type;
		$exemplar = $this->Db->get_row($this->Db->prepare($query, $primary));
		
		if (empty($exemplar)) { 
            $exemplar = $this->default_exemplar; 
        }
		
		return $exemplar;
	}
	
	protected function getAll($criterion=null) 
    {
		$query = "SELECT * FROM " . $this->Db->prefix . $this->table;
        
		if (!empty($criterion)) {
			if (isset($criterion[0]) && count($criterion) == 1) {
                $criterion['custom'] = $criterion[0];
            }
            
			if (isset($criterion['custom'])) {
				$query .= " WHERE " . $criterion['custom'];
			}
			
            
            
            if (isset($criterion['confines'])) {
                $query .= " WHERE 1=1";
                
                foreach ($criterion['confines'] as $confine) {
                    $query .= " AND {$confine}";
                }
            }
			
			
            
			if (isset($criterion['orderby'])) {
				$query .= " ORDER BY `" . $criterion['orderby'] . "`";
				
				if (isset($criterion['order'])) {
					$query .= " " . $criterion['order'];
				}
			}
			
			if (isset($criterion['limit'])) {
				$query .= " LIMIT " . $criterion['limit'];
			}
		}
        
		$exemplars = $this->Db->get_results($query);
		
        
		return $exemplars;
	}
	
    
    
	
	
	public function delete_constatly($id) 
    {
		$this->delete($id, true);
	}
    
	public function delete($id, $constatly = false) 
    {
		return (($constatly || $this->deleted_marker_column == false) ? $this->remove($id) : $this->markAsDeleted($id));
	}
	
	protected function markAsDeleted($id) 
    {
		$query = "UPDATE " . $this->Db->prefix . $this->table . " SET `" . $this->deleted_marker_column . "`='YES' WHERE `id`=%d";
		$result = $this->Db->query($this->Db->prepare($query, $id));
		
		return $result;
	}
    
	protected function remove($id) 
    {
		$query = "DELETE FROM " . $this->Db->prefix . $this->table . " WHERE `id`=%d";		
		$result = $this->Db->query($this->Db->prepare($query, $id));
		
		return $result;
	}	
	
	public function restore($id) 
    {
		$query = "UPDATE " . $this->Db->prefix . $this->table . " SET `" . $this->deleted_marker_column . "`='NO' WHERE `id`=%d";
		$result = $this->Db->query($this->Db->prepare($query, $id));
		
		return $result;	
	}
	
    
	
	
	
	public function simplify($object_list, $value, $key=null, $type="object") 
    {
		$simplified = [];
		
		foreach ($object_list as $object) {
			$object = (object)$object;
			
			if (empty($key)) {
				$simplified[] = $object->{$value};
			} else {
				$simplified[$object->{$key}] = $object->{$value};
			}	
		}
		
		if ($type == "object") { 
            $simplified = (object)$simplified; 
        }
		
		return $simplified;
	}
}
?>
