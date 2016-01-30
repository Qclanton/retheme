<section class="universal-wrapper breadcrumbs-block-wrapper">
	<div class="universal-wrapper--inner">
        <?= \Vividcrestrealestate\Core\Template::renderBreadcrumbs(); ?>			
	</div>
</section>

<section class="universal-wrapper block-wrapper--light-grey">
	<div class="universal-wrapper--inner search_form--wide">
        <?= \Vividcrestrealestate\Core\Template::renderPart("search_form_horizontal", ['action'=>"/properties", 'search'=>$search]); ?>		
	</div>
</section>

<section class="universal-wrapper content-block-wrapper">
	<div class="universal-wrapper--inner clearfix two_cols">
		<div class="col--left">
			<div class="universal_line-wrapper">
				<div class="universal_cell-wrapper">
					<select name=" ">
						<option selected="selected" value="0">Items per page</option>
						<option value="15">15</option>
						<option value="25">25</option>
						<option value="35">55</option>
					</select>
				</div>
				<div class="universal_cell-wrapper">
					<select name="properties-sorting">
                        <option selected="selected" style="display:none">Sorting</option>
                        
                        <optgroup label="Ascending">						
                            <option value="price|asc|number">Price</option>
                            <option value="publish_date|asc">Date</option>
                        </optgroup>
                        
                        <optgroup label="Descending">						
                            <option value="price|desc|number">Price</option>
                            <option value="publish_date|desc">Date</option>
                        </optgroup>
					</select>
				</div>
			</div>
		</div>
		<div class="col--right">
			<ul>
				<li class="current">
					<a href="/properties" class="view-toggle">
						<i class="fa fa-th"></i> Gallery
					</a>
				</li>
				<li>
					<a href="/map" class="view-toggle" >
						<i class="fa fa-map-marker"></i> 
						Map
					</a>
				</li>
			</ul>
		</div>
	</div>
    
    <!-- Top Pagination  -->
    <?= \Vividcrestrealestate\Core\Template::renderPart("pagination", ['pagination'=>$pagination]); ?>
	
    <div class="universal-wrapper--inner clearfix ">		
		<div class="universal_line-wrapper four__cols properties-list">
			<?php foreach ($properties as $i=>$property) { ?>
                <?php $page = ceil(($i+1)/8); ?>

				<div data-page="<?=$page ?>" <?=$page != 1 ? "style='display:none'" : "" ?> class="universal__cell property">
					<div class="property__image">
						<a class="property-link" data-property-id="<?=$property->id ?>" href="<?= site_url(); ?>/properties/<?=$property->id ?>">
							<span class="label__icon--small icon--green">Open House</span>						
							<img src="<?=$property->main_image ?> " />
						</a>
						<div class="carousel-arrows--small">
							<div class="carousel-arrow--prev"></div>
							<div class="carousel-arrow--next"></div>
						</div>
					</div>
					<div class="property__info-line">
						<a href="<?= site_url(); ?>/properties/<?=$property->id ?>">
							<p class="property__price">
								$<?= number_format(ceil($property->price)) ?>
							</p>
						</a>		
					</div>
					<div class="property__description">
						<a href="<?= site_url(); ?>/properties/<?=$property->id ?>">
							<ul>
								<li><?=$property->bedrooms ?> beds </li>
								<li><?=$property->bathrooms ?> baths</li>
								<? if (!empty($property->size)) { ?>
									<li><?=$property->size ?> sq.ft.</li>
								<? } else { ?>
									<li>N/A sq.ft.</li>
								<? } ?>
							</ul>

							<p class="property__description-city">
								<strong><?=$property->address ?></strong>
							</p>
							<p>
								<?=generate_excerpt($property->description, "", 100) ?>
							</p>
						</a>
					</div>
				</div>
			<? } ?>
		</div>
	</div>
    
    <!-- Bottom Pagination -->
    <?= \Vividcrestrealestate\Core\Template::renderPart("pagination", ['pagination'=>$pagination]); ?>	
</section>
