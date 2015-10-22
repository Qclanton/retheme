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


<section class="universal-wrapper universal-wrapper--transparent">
	<div class="universal-wrapper--inner clearfix two_cols">
		
		<div class="col--right">
			<ul>
				<li class="current">
					<a>
						<i class="fa fa-th"></i> Gallery
					</a>
				</li>
				<li>
					<a href="/map">
						<i class="fa fa-map-marker"></i> 
						Map
					</a>
				</li>
			</ul>
		</div>
	</div>
</section>


<div id="map" class="map--wide" style=" "></div>
