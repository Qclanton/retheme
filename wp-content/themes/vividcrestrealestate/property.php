<section class="universal-wrapper breadcrumbs-block-wrapper">
	<div class="universal-wrapper--inner">
        <?= \Vividcrestrealestate\Core\Template::renderBreadcrumbs(); ?>			
	</div>
</section>

<section class="universal-wrapper content-block-wrapper">
	<div class="universal-wrapper--inner clearfix two_cols">
		<div class="layout__col layout__col-half">
			
			
			<div class="property__visual-wrapper slidered-property" data-property-id="<?=$property->id ?>">
<!--
				<ul class="tabs">
					<li id="tab1" class="current">
						Photos
					<li id="tab2">
						Map
					</li>
					<li>Street View</li>
				</ul>
-->
				<div class="box visible">		
					<img src="<?=$property->main_image ?> " />
				</div>
				<div class="box">
					Map
				</div>
				<div class="box">
					Street
				</div>
				
				<div class="property__visual-tools--wrapper clearfix">
<!--					<span>10 photos </span>-->
					<p class="property__mls-number">MLS# <?=$property->mls_id ?> </p>
				</div>
				
			</div>
			
			<div class="property__contact-form property__blocks">
				<h2 class="title--colored">Sale Quick</h2>
				<div class="property__blocks--inner clearfix">
					<div class="clearfix">
						<div class="agent__contact-image">
							<img src="<?= get_template_directory_uri(); ?>/images/logo.png" />
						</div>
						<div class="agent__contact-info">
							<h2 class="title--underlined">Velev Group Inc.</h2>
							<p>10 Walsh Avenue,</p>
							<p>Toronto, ON, M9M 1B6a</p>
							<p>Mobile: 416-939-6376 </p>
							<p>Fax: 416-747-9855 </p>
							<p>Email: salequick.ca@gmail.com</p>
						</div>
					</div>
					<div class="agent__contact-form">
						<a class="button--small grey universal-button" data-action="request-information" href="#">Request information</a>
						<a class="button--small blue_button universal-button" data-action="request-showing" href="#">Request showing</a>
						<form id="agent__contact" class="form" data-property-id="<?= $property->id ?>">
                            <input type="hidden" value="INFO" name="contact[type]">
                        
							<h2 class="title--underlined title--small">Request More Information about <strong> <?=$property->address ?></strong></h2>
							<div class="universal_line-wrapper">
								<span>Your Name</span>
								<input type="text" placeholder="Name" value="" title="Your Name" name="contact[name]" required>
							</div>
							<div class="universal_line-wrapper">
								<div class="universal_cell-wrapper">
									<span>Your Phone</span>
									<input type="tel" placeholder="Phone" pattern="\+1[0-9]{10}" value="" title="+14165852626" name="contact[phone]" required>
								</div>
								<div class="universal_cell-wrapper">
									<span>Your Email</span>
									<input type="email" placeholder="Email" value="" title="Your Email" name="contact[email]" required>
								</div>
							</div>
							<div class="universal_line-wrapper">
								<span>Your Message</span>
								<textarea placeholder="Message" rows="8" cols="45" name="contact[message]"></textarea>
							</div>
							<div class="universal_line-wrapper">
								<input class="agent__contact-submit universal-button" type="submit" name="submit" value="Send">
							</div>
						</form>
						<form id="agent__contact-appointment" class="form" data-property-id="<?= $property->id ?>"> 
                            <input type="hidden" value="SHOW" name="contact[type]">
                            
							<h2 class="title--underlined title--small">Request Showing <strong> <?=$property->address ?></strong></h2>
							<div class="universal_line-wrapper">
								<span>Your Name</span>
								<input type="text" required="" placeholder="Name" value="" title="Your Name" name="contact[name]">
							</div>
							<div class="universal_line-wrapper">
								<div class="universal_cell-wrapper">
									<span>Your Phone</span>
									<input type="tel" required="" placeholder="Phone" pattern="\+1[0-9]{10}" value="" title="+14165852626" name="contact[phone]">
								</div>
								<div class="universal_cell-wrapper">
									<span>Your Email</span>
									<input type="email" required="" placeholder="Email" value="" title="Your Email" name="contact[email]">
								</div>
							</div>
							<div class="universal_line-wrapper">
								<div class="universal_cell-wrapper">
									<span>1st Preferred Date</span>
									<input type="text" class="date" required placeholder="First Preferred Date" value="" title="Preferred Date" name="contact[first_referred_date]">
								</div>
								<div class="universal_cell-wrapper">
									<span>2nd Preffered Date</span>
									<input type="text" class="date" required placeholder="Second Preferred Date" value="" title="Preferred Date " name="contact[second_preferred_date]">
								</div>
							</div>
							<div class="universal_line-wrapper">
								<span>Your Message</span>
								<textarea placeholder="Message" rows="8" cols="45" name="contact[message]"></textarea>
							</div>
							<div class="universal_line-wrapper">
								<input class="agent__contact-submit universal-button" type="submit" name="submit" value="Send">
							</div>
						</form>					
					</div>					
				</div>
			</div>
			
			
            <!-- Mortgage calculator -->
            <?= get_mortgage_calculator(['amount'=>ceil($property->price), 'template'=>"property_mortgage_calculator.php"]) ?>
		</div>
        
		<div class="layout__col layout__col-half layout__col_half--second">
			<h2 class="property__price">$<?=number_format(ceil($property->price)) ?> </h2>
			<p class="property__placed">Placed <?=$property->publish_date ?></p> 
			<div class="property__description property__description--big">
				<ul>
					<li><?=$property->bedrooms ?> beds </li>
					<li><?=$property->bathrooms ?> baths</li>
					<li><?=$property->size ?> sq.ft.</li>
					<? if(!empty($property->additional->Yr_built)) { ?>
						<li>built <?=$property->additional->Yr_built->value ?></li>
					<? } ?>
				</ul>
			</div>
			
			<? if (!empty($property->description)) { ?>
				<div class="property__description--inner">
					<p>
						<?=$property->description ?>
					</p>
				</div>
			<? } ?>
			<div class="property__main-information">
				<h2 class="title--underlined">Property Details</h2>
				<div class="property__details-line">
                    <?php foreach ($property->additional as $param) { ?>
                        <div class="property__details-line-wrapper">                        
                            <div class="property__details-title property__details-cell"><?=$param->title ?>:</div>
                            <div class="property__details-info property__details-cell"><?=$param->value ?></div>                        
                        </div>
                    <?php } ?>
				</div>				
			</div>					
		</div>	
	</div>
</section>

<section class="universal-wrapper similar-block-wrapper">
	<div class="universal-wrapper--inner">
        <h1>Similar Properties</h1>
		
		<div class="universal_line-wrapper four__cols">
            <?php foreach ($similar_properties as $i=>$similar_property) { ?>         
                <div class="universal__cell property slidered-property <?= $i==0 ? "property--first" : "" ?>" data-property-id="<?=$similar_property->id ?>">
                    <div class="property__image">	
                        <img src="<?=$similar_property->main_image ?>" />
                    </div>
                    <div class="property__info-line">
                        <a href="/properties/<?=$similar_property->id ?>">
                            <p class="property__price">
                                $<?=number_format(ceil($similar_property->price)) ?>
                            </p>
                        </a>		
                    </div>
                    <div class="property__description">
                        <a href="/properties/<?=$similar_property->id ?>">
                            <ul>
                                <li><?=$similar_property->bedrooms ?> beds </li>
                                <li><?=$similar_property->bathrooms ?> baths</li>
                                <li><?=$similar_property->size ?> sq.ft.</li>
                            </ul>
                            <p>
                                <?= generate_excerpt($similar_property->description, "...", 100) ?> 
                            </p>
                        </a>
                    </div>
                </div>
            <?php } ?>
		</div>
	</div>
</section>
