<section class="universal-wrapper breadcrumbs-block-wrapper">
	<div class="universal-wrapper--inner">
        <?= \Vividcrestrealestate\Core\Template::renderBreadcrumbs(); ?>			
	</div>
</section>



<section class="universal-wrapper content-block-wrapper compare-block">
	<div class="universal-wrapper--inner">
		<div class="title__border-bottom">
			<h1>Compare Properties</h1>
		</div>
		
		<div class="unversal__row-wrapper">
            <div class="universal_line-wrapper five__cols">
                <div class="universal__cell compare-page"></div>
                
                <?php foreach ($properties as $property) { ?>
                    <div class="universal__cell compare-page">
                        <a href="/properties/<?=$property->id ?>">
                            <img src="<?=$property->main_image ?>"/>
                        </a>				
                    </div>
                <?php } ?>
            </div>
            
            <div class="universal_line-wrapper five__cols main__row">
                <div class="universal__cell compare-page"><span></span></div>
                
                <?php foreach ($properties as $property) { ?>
                    <div class="universal__cell compare-page">
                        <p class="property__price">$<?=number_format(ceil($property->price)) ?> </p>
                        <p class="property__description-location">
                            <strong><?=$property->address ?></strong>
                        </p>
                    </div>
                <?php } ?>
            </div>		
    
        
        <?php foreach ($compare_fields as $field=>$title) { ?>
            <div class="universal_line-wrapper five__cols">
                    <div class="universal__cell compare-page">
                        <span>
                            <strong>
                                <?=$title ?>
                            </strong>
                        </span>
                    </div> 
                
                <?php foreach ($properties as $property) { ?>
                    <?php $value = (isset($property->{$field}) ? $property->{$field} : (isset($property->additional->{$field}) ? $property->additional->{$field}->value : "")); ?>
                    
                    <div class="universal__cell compare-page">
                        <span>
                            <?=$value ?>
                        </span>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
                        	
        </div>
    </div>
</section>
