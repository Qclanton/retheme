<section class="universal-wrapper breadcrumbs-block-wrapper">
	<div class="universal-wrapper--inner">
        <?= \Vividcrestrealestate\Core\Template::renderBreadcrumbs(); ?>			
	</div>
</section>

<section class="universal-wrapper block-wrapper--light-grey">
	<div class="universal-wrapper--inner search_form--wide">
        <?= \Vividcrestrealestate\Core\Template::renderPart("search_form_horizontal", ['action'=>"/map", 'search'=>$search]); ?>		
	</div>
</section>

<div id="map" style="width:640px; height:480px"></div>
