<section class="universal-wrapper breadcrumbs-block-wrapper">
	<div class="universal-wrapper--inner">
        <?= \Vividcrestrealestate\Core\Template::renderBreadcrumbs(); ?>			
	</div>
</section>


<section class="universal-wrapper content-block-wrapper content-block--inner">
	<div class="universal-wrapper--inner clearfix two_cols">
		
		<div class="layout__col layout__col--wide">
			<form role="search" method="get" id="searchform" class="searchform" action="<?= site_url() ?>">
				<div class="universal_line-wrapper">
					<input type="text" name="s" value="<?= $search_query ?>" />
					<input class="universal-button" type="submit" value="Search" />
				</div>
			</form>
			<?php if (count($posts) == 0) { ?>
				<p>Sorry but search result is empty. Please, try again</p>
			<?php } else { ?>			
                <?php foreach ($posts as $post) { ?>
                    <div class="search__result-wrapper">
                        <a href="<?= get_permalink($post->ID) ?>">
                            <h4><?= $post->post_title ?></h4>
                            <p>
                                    <?= generate_excerpt(wp_strip_all_tags($post->post_content), "...", 500) ?>
                            </p>
                        </a>
                    </div>
                 <?php } ?>    
            <?php } ?> 
		</div>		
		<?= \Vividcrestrealestate\Core\Template::renderPart("aside"); ?>
	</div>
</section>




