<link rel="stylesheet" href="<?= content_url() ?>/plugins/mortgages_rates/views/css/manage.css">
<script src="<?= content_url() ?>/plugins/mortgages_rates/views/js/manage.js"></script>
	
	
<br clear="all" />

<h3>Rates</h3>
<form id="manage-rates" action="" method="post">
	<input type="hidden" name="action" value="set"></input>
	<input type="hidden" name="element_id" value="0"></input>

	
	<input 
			type="radio" 
			name="subaction" 
			value="add"
		>		
	</input>
	Add New
	
	<input 
			type="radio" 
			name="subaction" 
			value="edit"
			checked="checked"
		>		
	</input>
	View List
	
	<br />	
	 

	<input 
			type="checkbox" 
			name="show_deleted"
		>
	</input>
	Show deleted
	
	<input 
			type="checkbox" 
			name="show_not_last"
			<?= in_array("not_last", $includes) ?  "checked='checked'" : "" ?>
		>
	</input>
	Show Not Last
	
	<br />	
	

	<table class="widefat">
		<thead>
				<tr>
					<th>Creation Date</th>
					<th>Term</th>
					<th>Rate</th>
					<th>Posted Rate</th>
					<th>Behaviour</th>
				</tr>
		</thead>
		
		<tbody>
			<? foreach ($elements as $i=>$rate) { ?>									
				<tr class="<?= (($i%2 == 0) ? 'alternate' : ''); ?> <?= (empty($rate->id) ? "add" : "edit"); ?>  <?= ($rate->deleted_fl == "YES" ? "deleted" : ""); ?>">
					<input type="hidden" name="rates[<?= $i ?>][id]" value="<?= $rate->id ?>"></input>
					<input type="hidden" name="rates[<?= $i ?>][creation_date]" value="<?= $rate->creation_date ?>"></input>
					<input type="hidden" name="rates[<?= $i ?>][deleted_fl]" value="<?= $rate->deleted_fl ?>"></input>					
					
					<td>
						<?= $rate->creation_date ?>
						<br /><br />
						<? $button_action = ($rate->deleted_fl == "NO" ? "delete" : "restore"); ?>
						<? $button_title = ($rate->deleted_fl == "NO" ? "Delete" : "Restore"); ?>
						<button class="button life-button <?= $button_action ?>-button" id="element--<?= $rate->id ?>"><?= $button_title ?></button>
						
						<? if ($rate->deleted_fl == "YES") { ?>
							<button class="button life-button constatly_delete-button" id="element--<?= $rate->id ?>">Delete permanently</button>
						<? } ?>	
					</td>
					
					<td>
						<select class="editable" name="rates[<?= $i ?>][term]">
							<? for ($y=1; $y<100; $y++) { ?>
								<option 
										<?= $y == $rate->term ? "selected='selected'": "" ?>
										value="<?= $y ?>"
									 >									 
									<?= $y ?> year<?= $y!=1 ? "s" : "" ?>
								</option>
							<? } ?>
						</select>
					</td>
					
					<td>
						<input 
								class="editable" 								
								type="text" 
								name="rates[<?= $i ?>][rate]"
								value="<?= $rate->rate ?>"
							>
						</input>
					</td>
					
					<td>
						<input 
								class="editable" 								
								type="text" 
								name="rates[<?= $i ?>][posted_rate]"
								value="<?= $rate->posted_rate ?>"
							>
						</input>
					</td>						
					
					<td>
						<?= $rate->behaviour ?>
					</td>
				</tr>				
			<? } ?>
		</tbody>
	</table>
	
	<div class="tablenav bottom">
		<button class="button button-primary">Save</button>
	</div>
</form>

<script>
(function($){ $(function() {
	$('input[name="show_not_last"]').on('change', function() { 
		$('form#manage-rates').submit();
	});
}); })(jQuery);
</script>
