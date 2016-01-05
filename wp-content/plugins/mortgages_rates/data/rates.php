<?
namespace MortgagesRates;

class Rates extends Data {
	public $table = "mortgages_rates";
	public $fields = [
		'id' => [
			'type' => "%d",
			'default' => null,
			'editable_fl' => false
		],
		'creation_date' => [
			'type' => "%s",
			'default' => "current date",
			'editable_fl' => true
		],
		'term' => [
			'type' => "%d",
			'default' => 1,
			'editable_fl' => true
		],
		'rate' => [
			'type' => "%f",
			'default' => 0,
			'editable_fl' => true
		],
		'posted_rate' => [
			'type' => "%f",
			'default' => 0,
			'editable_fl' => true
		],
		'deleted_fl' => [
			'type' => "%s",
			'default' => "NO",
			'editable_fl' => true
		]		
	];
	
	public function __construct($wpdb) {
		parent::__construct($wpdb);

		$this->default_exemplar->creation_date = date("Y-m-d H:i:s");
		$this->default_exemplar->behaviour = "NONE";
		$this->default_exemplar->last_fl = "YES";
	}
	
	public function getRates($include = []) {
		$inner_clause = in_array("without_deleted", $include) ? "mortgages_rates.`deleted_fl` = 'NO'" : "1";
		$outer_clause = !in_array("not_last", $include) ? "rates.`last_fl` = 'YES'" : "1";
		
		$query = "
			SELECT 
				rates.`id`,
				rates.`creation_date`,
				rates.`term`,
				rates.`rate`,
				rates.`posted_rate`,				
				rates.`behaviour`,
				rates.`last_fl`,
				rates.`deleted_fl`
			FROM (
				SELECT 
					*,
						@previous_rate := (SELECT previous_mortgages_rates.`rate`
						FROM `{$this->Db->prefix}{$this->table}` previous_mortgages_rates 
						WHERE 
							previous_mortgages_rates.`term` = mortgages_rates.`term` AND
							previous_mortgages_rates.`creation_date` < mortgages_rates.`creation_date` AND
							previous_mortgages_rates.`deleted_fl` = 'NO'
						ORDER BY mortgages_rates.`creation_date` DESC
						LIMIT 1) AS
					'previous_rate',		
						CASE 
							WHEN (@previous_rate < `rate`) THEN 'GROW'
							WHEN (@previous_rate > `rate`) THEN 'FALL'
							ELSE 'NONE'
						END AS 
					'behaviour',
						@last_creation_date := (SELECT MAX(`creation_date`) 
						FROM `{$this->Db->prefix}{$this->table}` last_mortgages_rates
						WHERE last_mortgages_rates.`term` = mortgages_rates.`term`) AS 
					'last_creation_date',
						CASE 
							WHEN @last_creation_date = mortgages_rates.`creation_date` THEN 'YES'
							ELSE 'NO'
						END AS
					'last_fl'
				FROM `{$this->Db->prefix}{$this->table}` mortgages_rates
				WHERE {$inner_clause}
				) AS rates
			WHERE {$outer_clause}
			ORDER BY 
				`term` ASC, 
				`creation_date` DESC
		";
	
		return $this->Db->get_results($query);
	}
}
?>
