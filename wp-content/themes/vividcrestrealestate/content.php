<section class="universal-wrapper breadcrumbs-block-wrapper">
	<div class="universal-wrapper--inner">
        <?= \Vividcrestrealestate\Core\Template::renderBreadcrumbs(); ?>			
	</div>
</section>


<section class="universal-wrapper content-block-wrapper content-block--inner">
	<div class="universal-wrapper--inner clearfix two_cols">
		
		<div class="layout__col layout__col--wide">
			<article>
			<div class="title__border-bottom">
				<h1><?= $post->post_title ?></h1>
			</div>
				<?= $post->post_content ?>	
			</article>
		</div>
		
		<?= \Vividcrestrealestate\Core\Template::renderPart("aside"); ?>
		
	</div>
</section>