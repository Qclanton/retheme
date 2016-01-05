<section class="universal-wrapper map-block-wrapper clearfix">
	<div id="map" class="map--wide map--main"></div>
	<div class="universal-wrapper--inner">
		<?= \Vividcrestrealestate\Core\Template::renderPart("search_form", ['search'=>$search]); ?>
	</div>
</section>
<section class="universal-wrapper content-block-wrapper">
	<div class="universal-wrapper--inner clearfix two_cols">
		<div class="title__border-bottom">
			<h1>Recent Properties</h1>
		</div>
		<div class="universal_line-wrapper four__cols">
            <?php foreach ($recent_properties as $i=>$recent_property) { ?>
                <div class="universal__cell property slidered-property <?= $i==0 ? "property--first" : "" ?>" data-property-id="<?=$recent_property->id ?>">
                    <div class="property__image">
                        <img src="<?= $recent_property->main_image ?>" />
                    </div>
                    <div class="property__info-line">
                        <a href="/properties/<?=$recent_property->id ?>">
                            <p class="property__price">
                                $<?=number_format(ceil($recent_property->price)) ?>
                            </p>
                        </a>		
                    </div>
                    <div class="property__description">
                        <a href="/properties/<?=$recent_property->id ?>">
                            <ul>
                                <li><?=$recent_property->bedrooms ?> beds </li>
                                <li><?=$recent_property->bathrooms ?> baths</li>
                                <li><?=!empty($recent_property->size) ? $recent_property->size : "N/A" ?> sq.ft.</li>
                            </ul>

                            <p>
                                 <?= generate_excerpt($recent_property->description, "...", 100) ?>
                            </p>
                        </a>
                    </div>
                </div>
			<?php } ?>
        </div>
		
		<div class="layout__col layout__col--wide">
			<div class="title__border-bottom">
				<h1>Futured Properties</h1>
			</div>

			<div class="universal_line-wrapper three__cols">
				<div class="universal__cell property property--first">
					<div class="property__image">
						<a href="">
							<span class="label__icon--small icon--green">Open House</span>						
							<img src="<?= get_template_directory_uri(); ?>/images/property.jpg" />
						</a>
					</div>
					<div class="property__info-line">
						<a href="">
							<p class="property__price">
								$850 000
							</p>
						</a>		
					</div>
					<div class="property__description">
						<a href="">
							<ul>
								<li>3 beds </li>
								<li>2 baths</li>
								<li>1500 sq.ft.</li>
							</ul>
						</a>
					</div>
				</div>
				<div class="universal__cell property">
					<div class="property__image">
						<a href="">
							<span class="label__icon--small icon--blue">New Offer</span>
							<img src="<?= get_template_directory_uri(); ?>/images/property.jpg" />
						</a>
					</div>
					<div class="property__info-line">
						<a href="">
							<p class="property__price">
								$850 000
							</p>
						</a>		
					</div>
					<div class="property__description">
						<a href="">
							<ul>
								<li>3 beds </li>
								<li>2 baths</li>
								<li>1500 sq.ft.</li>
							</ul>
						</a>
					</div>
				</div>
				<div class="universal__cell property">
					<div class="property__image">
						<a href="">
							<span class="label__icon--small icon--green">Open House</span>
							<img src="<?= get_template_directory_uri(); ?>/images/property.jpg" />
						</a>
					</div>
					<div class="property__info-line">
						<a href="">
							<p class="property__price">
								$850 000
							</p>
						</a>		
					</div>
					<div class="property__description">
						<a href="">
							<ul>
								<li>3 beds </li>
								<li>2 baths</li>
								<li>1500 sq.ft.</li>
							</ul>
						</a>
					</div>
				</div>
			</div>


			<div class="layout__col layout__col-half">
				<div class="title__border-bottom">
					<h2>Selling Your Property</h2>
				</div>
				<article>
<!--					<img src="http://wpestatetheme.org/wp-content/uploads/2013/06/photodune-317366-family-having-fun-in-countryside-xs.jpg" />-->
					<iframe src="https://player.vimeo.com/video/17882714" width="100%" height="auto" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
					<p>
						The Sale Quick team–unlike any other real estate company–invests 100 percent of our time and resources on Toronto and surrounding area properties.
					</p>
					<p>
						We have a total of 15+ years combined experience dealing exclusively with Toronto buyers and sellers. Over the past year, Sale Quick has maintained many happy and satisfied buyer and sellers. We’re the best at what we do.
					</p>
				</article>
			</div>
			<div class="layout__col layout__col-half layout__col_half--second">
				<div class="title__border-bottom">
					<h2>Our Services</h2>
				</div>
				<article>
					<ul class="list__checked-icon">
						<li>
							<i class="fa fa-check-square-o"></i>
							<p>Provide legal services to initiate and review contracts.</p>
						</li>
						<li>
							<i class="fa fa-check-square-o"></i> 
							<p>Provide in-house marketing services to produce sales materials, including photography, brochures, and websites, etc.</p>
						</li>
						<li>
							<i class="fa fa-check-square-o"></i>
							<p>Understand Privacy–not listing with MLS ensures that only our Sales Executives have access to the lockbox.</p>
						</li>
						<li>
							<i class="fa fa-check-square-o"></i>
							<p>Ensure all repairs are complete and satisfactory and provide lists of reputable repair businesses, inspectors, major lenders and private lenders.</p>
						</li>
						<li>
							<i class="fa fa-check-square-o"></i>
							<p>Provide referred legal services to initiate and review contracts.</p>
						</li>
					</ul>
					<a class="blue_button universal-button universal-button--small" href="/contact-us">Contact us today</a>
				</article>
			</div>
			<div class="testimonials-wrapper">
				<div class="title__border-bottom">
						<h1>Client Testimonials</h1>
					</div>
				<div class="testimonial-wrapper">
					
					<div class="testimonial__image" style="background-image: url(http://wpestatetheme.org/wp-content/uploads/2013/06/testimonial-11.jpg);"></div>
					<div class="testimonial__description">
						<h4>
							Susan Barkley
						</h4>
						<p>
							"The Sale Quick team did an outstanding job helping me buy my first home. The high level of service and dedication to seeing things done the right way is what I look for in an agent. The Sale Quick team delivered on that expectation and I would highly recommend them to anyone who is in the market to buy a home."
						</p>
					</div>
				</div>
				<div class="testimonial-wrapper">
					<div class="testimonial__image" style="background-image: url(http://wpestatetheme.org/wp-content/uploads/2013/05/profile-testimonial2.jpg);"></div>
					<div class="testimonial__description">
						<h4>
							Lisa Simpson
						</h4>
						<p>
							"We hired the Sale Quick team as our buyer agent because they are specifically trained in Short Sale Foreclosure transactions. All in all I have no doubt that we would have failed to close without an experienced representative such as the professionals at Sale Quick working for us, and we are very grateful for all they did."
						</p>
					</div>
				</div>
			</div>			
		</div>
		
        

		<div class="layout__col layout__col--small layout__col--second">
            <?= get_mortgage_calculator() ?>
		</div>			
	</div>
</section>
