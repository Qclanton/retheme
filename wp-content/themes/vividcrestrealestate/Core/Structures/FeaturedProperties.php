<?php
namespace Vividcrestrealestate\Core\Structures;

class FeaturedProperties extends \Vividcrestrealestate\Core\Libs\Data 
{
	public $table = "featured_properties";
    
	public $fields = [
        'mls_id' => [
            'type' => "%s",
            'default' => null,
            'editable_fl' => false,
            'primary_fl' => true
		],
        'property_id' => [
            'type' => "%d",
            'default' => "",
            'editable_fl' => false
		]
	];
    
    
    
    
    public function getDetailed($criterion=null) 
    {
        $Properties = new Properties();
        
        $featured_properties = $this->get($criterion);
        
        foreach ($featured_properties as &$featured_property) {
            $featured_property = $Properties->get($featured_property->property_id);
        }
        
        return $featured_properties;
    }
}
