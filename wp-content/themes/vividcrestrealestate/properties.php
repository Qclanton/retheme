<section class="universal-wrapper breadcrumbs-block-wrapper">
	<div class="universal-wrapper--inner">
        <?= \Vividcrestrealestate\Core\Template::renderBreadcrumbs(); ?>			
	</div>
</section>

<section class="universal-wrapper block-wrapper--light-grey">
	<div class="universal-wrapper--inner search_form--wide">
        <?= \Vividcrestrealestate\Core\Template::renderPart("search_form_horizontal", ['action'=>"/properties"]); ?>		
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
				<li class="current"><i class="fa fa-th"></i> Gallery</li>
				<li><i class="fa fa-map-marker"></i> Map</li>
			</ul>
		</div>
	</div>
	<div class="universal-wrapper--inner clearfix two_cols">
		<div class="col--left">
			<div class="universal_line-wrapper">
				1 - 8 of <?= count($properties) ?>
			</div>
		</div>
		<div class="col--right">
			<ul class="pagintaion">
                <?php $total_pages =  ceil(count($properties)/8); ?>
                    <li data-page="0" class="previous" style="display:none">«</li>
                    <li data-page="1" class="page-button current">1</li>
                    <li class="separator" style="display:none">...</li>                    
                
                <?php for ($page=2; $page<ceil(count($properties)/8); $page++) { ?>
                    <li data-page="<?=$page ?>" class="page-button" <?=$page > 3 ? "style='display:none'" : "" ?>><?=$page ?></li>
                <?php } ?>
                
                    <li class="separator">...</li>
                    <li data-page="<?=$total_pages ?>" class="page-button" <?=$total_pages < 5 ? "style='display:none'" : "" ?>><?=$total_pages ?></li>
                    <li data-page="4" class="next" <?=$total_pages < 4 ? "style='display:none'" : "" ?>>»</li>
            </ul>
		</div>
	</div>
	<div class="universal-wrapper--inner clearfix ">
		
		<div class="universal_line-wrapper four__cols properties-list">
			<?php foreach ($properties as $i=>$property) { ?>
                <?php $page = ceil(($i+1)/8); ?>

				<div data-page="<?=$page ?>" <?=$page != 1 ? "style='display:none'" : "" ?> class="universal__cell property">
					<div class="property__image">
						<i class="fa fa-star-o"></i>

						<a href="<?= site_url(); ?>/properties/<?=$property->id ?>">
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
								<?= ceil($property->price) ?>
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
</section>

<section id="compare-block" class="universal-wrapper compare-block-wrapper">
	<div class="universal-wrapper--inner">		
			<div class="block-wrapper--light-grey">
			<div class="compare__navigation">
				<i class="fa fa-minus-square-o"></i>
				<i class="fa fa-times"></i>
			</div>
			<div class="compare__title">
				<h1>Compare Up to 5 properties</h1>
			</div>
			<div class="universal_line-wrapper five__cols">
				<div class="universal__cell compare">
					<div class="property__image">
						<i class="fa fa-times"></i>
						<a href="http://retheme.qcldev.ru/properties/15">
							<img src="http://retheme.qcldev.ru/wp-content/themes/vividcrestrealestate/images/property.jpg ">
						</a>
					</div>
				</div>
				<div class="universal__cell compare">
					<div class="property__image">
						<i class="fa fa-times"></i>
						<a href="http://retheme.qcldev.ru/properties/15">
							<img src="http://retheme.qcldev.ru/wp-content/themes/vividcrestrealestate/images/property.jpg ">
						</a>
					</div>
				</div>
				<div class="universal__cell compare">
					<div class="property__image">
						<i class="fa fa-times"></i>
						<a href="http://retheme.qcldev.ru/properties/15">
							<img src="http://retheme.qcldev.ru/wp-content/themes/vividcrestrealestate/images/property.jpg ">
						</a>
					</div>
				</div>
				<div class="universal__cell compare">
					<div class="property__image">
						<i class="fa fa-times"></i>
						<a href="http://retheme.qcldev.ru/properties/15">
							<img src="http://retheme.qcldev.ru/wp-content/themes/vividcrestrealestate/images/property.jpg ">
						</a>
					</div>
				</div>
				<div class="universal__cell compare">
					<div class="property__image">
						<i class="fa fa-times"></i>
						<a href="http://retheme.qcldev.ru/properties/15">
							<img src="http://retheme.qcldev.ru/wp-content/themes/vividcrestrealestate/images/property.jpg ">
						</a>
					</div>
				</div>
				<div class="universal__cell compare">
					<a class="universal-button" href="#">
						Detailed Compare
					</a>
				</div>
			</div>
		</div>
	</div>
	<div class="universal-wrapper--inner">
		<div class="block-wrapper--light-grey block-wrapper--small">
			<a href="#">compare details</a>
		</div>
	</div>
</section>
