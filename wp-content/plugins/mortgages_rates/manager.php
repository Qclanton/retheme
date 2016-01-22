<?php
namespace MortgagesRates;

class Manager {
	public static function manage() {
		$layout = "rates";	
		$action = (isset($_REQUEST['action']) ? $_REQUEST['action'] : "show");
		$subaction = (isset($_REQUEST['subaction']) ? $_REQUEST['subaction'] : "");		
		$Data = Helpers::loadData($layout );
		
		
		// Do the action
		$elements = (isset($_POST[$layout]) ? $_POST[$layout] : null );
		if ($action != "show") {
			if ($subaction != "add") { unset($elements[0]); } // Remove default element
			if (in_array($action, ["delete", "delete_constatly", "restore"])) { $elements = $_POST['element_id']; }
				
			$result = $Data->{$action}($elements);
		}		
		
		$vars['includes'] = [
			!empty($_REQUEST['show_not_last']) ? "not_last" : ""
		];

		// Show
		self::show($Data, $layout, $vars);
	}
	
	public static function show($Data, $layout, $params = []) {
		$default_element = $Data->get("default");
		$vars['elements'] = array_merge([$default_element], $Data->getRates($params['includes']));
		$vars = array_merge($vars, $params);	
		
		$html = Helpers::render(__DIR__ . "/views/manage_{$layout}.php", $vars);
		echo $html;	
	}
	
	
	
	
	public static function addMenuItem() {
		add_menu_page("Mortgages Rates", "Mortgages Rates", "edit_posts", "mortgages_rates", ["\MortgagesRates\Manager", "manage"], null, "6.1");
	}
	
	public static function install() {
		global $wpdb;
	
		$charset_collate = '';
		if (!empty($wpdb->charset)) {
		  $charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset}";
		}
		if (!empty($wpdb->collate)) {
		  $charset_collate .= " COLLATE {$wpdb->collate}";
		}
		
		$sql = "
			CREATE TABLE `{$wpdb->prefix}mortgages_rates` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`creation_date` datetime NOT NULL,
				`term` int(11) NOT NULL,
				`rate` double(11,4) NOT NULL,
				`posted_rate` double(11,4) NOT NULL,
				`deleted_fl` enum('YES','NO') NOT NULL DEFAULT 'NO',
				
				PRIMARY KEY (`id`),
				UNIQUE KEY `current_term` (`creation_date`,`term`,`deleted_fl`)
			) {$charset_collate}; 
		";
			
		require_once(ABSPATH . "wp-admin/includes/upgrade.php");
		dbDelta($sql);
	}
	
	public static function uninstall() {
		global $wpdb;
		$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}mortgages_rates");
	}
}
