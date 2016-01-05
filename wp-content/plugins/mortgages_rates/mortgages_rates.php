<?
/*
Plugin Name: Motgages Rates
Description: Widget for current mortages rates
Version: 103
Author: Vividcrest
*/

// Autoload
spl_autoload_register(function($name) {
	$splitted_name = explode("\\", $name);
	$class = end($splitted_name); 
	$file = __DIR__ . "/libs/" . strtolower(preg_replace("/([a-z])([A-Z])/", "$1_$2", $class)) . ".php";
	
    if(file_exists($file)) { 
        require_once $file; 
    }
});
include "manager.php";

// Install
register_activation_hook(__FILE__, ["\MortgagesRates\Manager", "install"]);
register_uninstall_hook(__FILE__, ["\MortgagesRates\Manager", "uninstall"]);

// Menu
add_action("admin_menu", ["\MortgagesRates\Manager", "addMenuItem"]);



// Shortcodes
add_shortcode("mortgages_rates_widget" , "get_mortgages_rates");
function get_mortgages_rates() {
	$Rates = \MortgagesRates\Helpers::loadData("rates");
	$rates = $Rates->getRates(["without_deleted"]);
	$template = \MortgagesRates\Helpers::chooseTemplate("shortcode_mortgages_rates_widget.php");
    
	foreach ($rates as $rate) {
		switch ($rate->behaviour) {
			case "GROW": $rate->classes = "rates_up"; break;
			case "FALL"	: $rate->classes = "rates_down"; break;	
			case "NONE"	: $rate->classes = "rates_same"; break;	
		}
	}
    
    
	echo \MortgagesRates\Helpers::render($template, ['rates'=>$rates]);
}

add_shortcode("mortgages_rates_full_widget" , "get_mortgages_rates_full");
function get_mortgages_rates_full() {
	$Rates = \MortgagesRates\Helpers::loadData("rates");
	$rates = $Rates->getRates(["without_deleted"]);
    $template = \MortgagesRates\Helpers::chooseTemplate("shortcode_mortgages_rates_full_widget.php");
	
	foreach ($rates as $rate) {
		switch ($rate->behaviour) {
			case "GROW": $rate->classes = "rates_up"; break;
			case "FALL"	: $rate->classes = "rates_down"; break;	
			case "NONE"	: $rate->classes = "rates_same"; break;	
		}
	}
	
	echo \MortgagesRates\Helpers::render($template, ['rates'=>$rates]);
}

add_shortcode("mortgage_calculator" , "get_mortgage_calculator");
function get_mortgage_calculator(array $params=[]) {
	$Rates = \MortgagesRates\Helpers::loadData("rates");
	$rates = $Rates->getRates(["without_deleted"]);
    $template_name = (isset($params['template']) ? $params['template'] : "shortcode_mortgage_calculator_widget.php");
    $template = \MortgagesRates\Helpers::chooseTemplate($template_name);
	
    // Default values
	$period = 25;
	$year_rate = end($rates)->rate;
	
	$vars = [
        'amount' => (isset($params['amount']) ? $params['amount'] : ""),
		'rates' => $rates, 
		'default_period' => $period,
		'default_rate' => $year_rate,
	];
	
	echo \MortgagesRates\Helpers::render($template, $vars);
}
?>
