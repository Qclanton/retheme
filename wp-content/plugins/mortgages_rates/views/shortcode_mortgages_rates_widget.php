<link rel="stylesheet" href="<?= content_url() ?>/plugins/mortgages_rates/views/css/mortgages_rates_widget.css">
<table class="mort_rates_table" cellspacing="0">
	<thead>
		<tr>
			<th>Mortgage Term</th>
			<th>Rate</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<? foreach ($rates as $i=>$rate) { ?>
			<tr>
				<td><?= $rate->term ?> year<?= $i!=1 ? "s" : "" ?></td>
				<td><?= number_format($rate->rate, 2) ?>%</td>
				<td class="<?= $rate->classes ?>"></td>
			</tr>
		<? } ?>		
	</tbody>	
</table>
