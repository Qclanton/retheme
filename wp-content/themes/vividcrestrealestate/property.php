


<section class="universal-wrapper breadcrumbs-block-wrapper">
	<div class="universal-wrapper--inner">
		<ul>
			<li>
				<a href="">Home</a>
			</li>
			<li>
				<a href="">Search</a>
			</li>
			<li> <?=$property->address ?></li>
		</ul>			
	</div>
</section>
<section class="universal-wrapper content-block-wrapper">
	<div class="universal-wrapper--inner clearfix two_cols">
		<div class="layout__col layout__col-half">
			
			
			<div class="property__visual-wrapper">
				<ul class="tabs">
					<li id="tab1" class="current">
						Photos
					<li id="tab2">
						Map
					</li>
					<li>Street View</li>
				</ul>
				<div class="box visible">		
					<img src="<?= get_template_directory_uri(); ?>/images/property.jpg" />
				</div>
				<div class="box">
					Map
				</div>
				<div class="box">
					Street
				</div>
				
				<div class="property__visual-tools--wrapper">
					<p class="property__mls-number">MLS# <?=$property->mls_id ?> </p>
				
				</div>
				
			</div>
			
			<div class="property__contact-form property__blocks">
				<h2 class="title--colored">Jack Richardson</h2>
				<div class="property__blocks--inner">
				
				</div>
			</div>
			
			
<!-- Mortgage calculator -->
			<div class="mortgage__calc property__blocks">
				<h2 class="title--colored">Mortgage Calculator</h2>
				<div class="mortgage__calc-line clearfix">
					<div class="mortgage__calc-cell">
						<span>Mortgage Amount</span>
						<input type="number" placeholder="Mortgage Amount" value=" " name="mortage_sum" >
					</div>
					<div class="mortgage__calc-cell">
						<span>Interest Rate</span>
						<select name="rate">
							<option value="2.7900"> 2.79% in 1 years </option>
							<option value="2.3400"> 2.34% in 2 years </option>
							<option value="2.4000"> 2.40% in 3 years </option>
							<option value="2.1000" selected="selected"> 2.10% in 5 years </option>
						</select>
					</div>
					<div class="mortgage__calc-cell">
						<span>Amortization Period</span>
						<select name="amortization_period">
							<option value="1"> 1 year </option>
							<option value="2"> 2 years </option>
							<option value="3"> 3 years </option>
							<option value="4"> 4 years </option>
							<option value="5"> 5 years </option>
							<option value="6"> 6 years </option>
						</select>
					</div>
					<div class="mortgage__calc-cell">
						<span>Payment Frequency </span>
						<select name="payment_frequency">
							<option value="weekly" selected="selected">Weekly</option>
							<option value="rapid_weekly">Rapid Weekly</option>
							<option value="biweekly">Bi-Weekly</option>
							<option value="rapid_biweekly">Rapid Bi-Weekly</option>
							<option value="monthly">Monthly</option>
						</select>
					</div>	
				</div>
				<div class="mortgage__calc-line clearfix">
					<h2 class="title--underlined">Your mortgage payment would be - <strong> 889.02$ / Weekly </strong></h2>
					<a class="blue_button universal-button" href="#" data-action="recalculate">Recalculate</a>
				</div>
			</div>
			
		</div>
		<div class="layout__col layout__col-half layout__col_half--second">
			<h2 class="property__price">$<?=$property->price ?> </h2>
			<p class="property__placed">Placed Feb, 17 2015</p>
			<div class="property__description property__description--big">
				<ul>
					<li><?=$property->bedrooms ?> beds </li>
					<li><?=$property->bathrooms ?> baths</li>
					<li><?=$property->size ?> sq.ft.</li>
					<li>built 2014</li>
				</ul>
			</div>
			
			<div class="property__description--inner">
				<p>
					Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?
				</p>
			</div>
			
			<div class="property__main-information">
				<h2 class="title--underlined">Property Details</h2>
				<div class="property__details-line">
					<div class="property__details-line-wrapper">
						<div class="property__details-title property__details-cell">Building Type: </div>
						<div class="property__details-info property__details-cell">Detached </div>
					</div>
					<div class="property__details-line-wrapper">
						<div class="property__details-title property__details-cell">Building Type: </div>
						<div class="property__details-info property__details-cell">Detached </div>
					</div>
					<div class="property__details-line-wrapper">
						<div class="property__details-title property__details-cell">Building Type: </div>
						<div class="property__details-info property__details-cell">Detached </div>
					</div>
					<div class="property__details-line-wrapper">
						<div class="property__details-title property__details-cell">Building Type: </div>
						<div class="property__details-info property__details-cell">Detached </div>
					</div>
					<div class="property__details-line-wrapper">
						<div class="property__details-title property__details-cell">Property Type: </div>
						<div class="property__details-info property__details-cell">Condo </div>
					</div>
					<div class="property__details-line-wrapper">
						<div class="property__details-title property__details-cell">Building Type: </div>
						<div class="property__details-info property__details-cell">Detached </div>
					</div>
					<div class="property__details-line-wrapper">
						<div class="property__details-title property__details-cell">Building Type: </div>
						<div class="property__details-info property__details-cell">Detached </div>
					</div>
				</div>
				
			</div>
					
		</div>	
	</div>
</section>

			<pre>
			<?php var_dump($property); ?>
			</pre>

<!--

<section class="universal-wrapper content-block-wrapper">
		<div class="universal-wrapper--inner clearfix two_cols">
			<div class="layout__col layout__col--wide">
				<h1>Property</h1>
				<?php var_dump($property); ?>
				
				
			</div>
			<div class="layout__col layout__col--small layout__col--second">
				<h4>Mortgage Calculator</h4>
			</div>			
		</div>
	</section>

-->
