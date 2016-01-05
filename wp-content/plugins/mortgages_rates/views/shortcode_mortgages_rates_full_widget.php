<table cellspacing="0" class="mortgages_rates_full">
	<thead>
		<tr>
			<th>Mortgage Term</th>
			<th>Posted Rates</th>
			<th>Our Rates</th>
			<th>Date fo change</th>
		</tr>
	</thead>
	
	<tbody>
		<? foreach ($rates as $i=>$rate) { ?>
			<tr>
				<td><?= $rate->term ?> year<?= $i!=1 ? "s" : "" ?></td>
				<td><?= number_format($rate->posted_rate, 2) ?>%</td>
				<td><?= number_format($rate->rate, 2) ?>%</td>
				<td><?= strtoupper(date("M d\T\H, Y", strtotime($rate->creation_date))) ?></td>
			</tr>
		<? } ?>		
	</tbody>	
</table>
