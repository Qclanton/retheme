<?php
namespace Vividcrestrealestate\Core\Structures;

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
        'publish_date' => [
			'type' => "%s",
			'default' => "",
			'editable_fl' => true,
            'date_fl' => true
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
        'sublocality' => [
			'type' => "%s",
			'default' => "",
			'editable_fl' => true
		],
        'neighborhood' => [
			'type' => "%s",
			'default' => "",
			'editable_fl' => true
		],
        'postal_code' => [
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
			'type' => "%s",
			'default' => "buy",
			'editable_fl' => true
		],
        'price' => [
			'type' => "%f",
			'default' => 0,
			'editable_fl' => true
		],
        'size' => [
			'type' => "%s",
			'default' => "0",
			'editable_fl' => true
		],
        'description' => [
			'type' => "%s",
			'default' => "",
			'editable_fl' => true
		],
        'main_image' => [
			'type' => "%s",
			'default' => "",
			'editable_fl' => true
		]
	];
    
    
       
    public function getDetailed($id)
    {
        // Get the property
        $property = $this->get($id);
        
        
        
        // Init additional section
        $PropertyInfo = new PropertyInfo();
        $property->additional = new \stdClass();
        
        
        
        // Get additional info
        $info = $PropertyInfo->get([
            'confines' => [
                "`property_id`='{$property->id}'",
                "`title`!=''"
            ]
        ]);
        
        
        
        // Attach additional info to the property
        foreach ($info as $param) {
            $property->additional->{$param->key} = (object)[
                'title' => $param->title,
                'value' => $param->value
            ];
        }   
        
        
        
        return $property;  
    }
    
    public function getImages($property_id) 
    {
        $property = $this->get($property_id);
        $credentials = \Vividcrestrealestate\Core\Administration\Connection::getStoredOptions();
        $PropertyInfo = new PropertyInfo();        
        $Rets = new \Vividcrestrealestate\Core\Libs\Rets($credentials->url, $credentials->login, $credentials->password);      

        if ($Rets->login()) {
            $images_ids_data = $PropertyInfo->get([
                'confines' => [
                    "`property_id`='{$property->id}'",
                    "`key`='images_ids'"
                ]
            ]);
            
            if (!empty($images_ids_data[0])) {
                $images_ids = explode(",", $images_ids_data[0]->value);
                
                foreach ($images_ids as $image_id) {
                    $image = $Rets->getCachedImage($image_id, $property->mls_id);
                    
                    if (!empty($image)) {
                        $images[] = $image;
                    }
                }
            }
        }
        
        if (empty($images)) {
            $images = [$property->main_image];
        }
        
        return $images;
    }
    
    
    protected function setOne($property)
    {
        // Normalize vars
        $property = (object)$property;
        $class = $property->type; // Need to change
        
        
        // Recognize address
        $address = "{$property->Addr} {$property->Zip} Canada";
        $recognized = \Vividcrestrealestate\Core\Libs\Address::recognize($address);
        
        
        // Save main data
        $property_id = parent::setOne((object)[
            'mls_id' => $property->Ml_num,
            'creation_date' => date("Y-m-d H:i:s"),
            'publish_date' => date("Y-m-d H:i:s", strtotime($property->Timestamp_sql)),
            'country' => $recognized->country,
            'city' => $recognized->city,
            'sublocality' => $recognized->sublocality,
            'neighborhood' => $recognized->neighborhood,
            'postal_code' => $recognized->postal_code,
            'address' => $recognized->address,
            'latitude' => $recognized->latitude,
            'longitude' => $recognized->longitude,
            'bedrooms' => $property->Br,
            'bathrooms' => $property->Bath_tot,
            'type' => $class,
            'deal_type' => "buy",
            'price' => $property->Lp_dol,
            'size' => (!empty($property->Sqft) ? $property->Sqft : "0"),
            'description' => $property->Ad_text,
            'main_image' => (!empty($property->main_image) ? $property->main_image : get_template_directory_uri() . "/images/property.jpg")
        ]);
        
        
        // Save additional data
        if (!empty($property_id)) {
            $PropertInfo = new PropertyInfo();
            $fields_accordance = (new FieldsAccordance())->get(["`class`='{$class}'"]);
            
            foreach ($fields_accordance as $accordance) {
                $value = $property->{$accordance->field_name};
                
                if (!empty($value)) {
                    $PropertInfo->set((object)[
                        'property_id' => $property_id,
                        'title' => $accordance->field_title,
                        'key' => $accordance->field_name,
                        'value' => $value
                    ]);
                }
            }
        }
        
        return $property_id;
    }
}
