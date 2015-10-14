<!doctype html>
<html lang=ru>
<head>
	<meta charset=utf-8>
	<title> </title>
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/style.css" />
	<link href='https://fonts.googleapis.com/css?family=Roboto:400,300,300italic,400italic,700' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=PT+Sans:400,400italic,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/responsive.css" />
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/header.css" />
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/sections.css" />
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/content.css" />
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/search.css" />
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/buttons.css" />
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/menus.css" />
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/cols.css" />
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/slider.css" />
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/calculator.css" />
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/jquery.arcticmodal-0.3.css" />
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/page_inner.css" />
	<link rel="icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/favicon.png" />	
	<meta name="viewport" content="width=device-width, initial-scale=0.85, maximum-scale=0.85, user-scalable=0" />
	<meta name="viewport" content="target-densitydpi=high-dpi" />
	<meta name="MobileOptimized" content="720"/>
	<meta name="HandheldFriendly" content="true"/>
	<?= wp_head() ?>
	<!--[if lt IE 10]>
		<script src="<?php echo get_template_directory_uri(); ?>/js/placeholder_ie9.js"></script>
		<script src="<?php echo get_template_directory_uri(); ?>/js/required_ie9.js"></script>
	<![endif]-->
</head>
<!--[if lt IE 9]>
   <script>
      document.createElement('header');
      document.createElement('nav');
      document.createElement('section');
      document.createElement('article');
      document.createElement('aside');
      document.createElement('footer');
   </script>
<![endif]-->
<body>
	<header>
		<div class="universal-wrapper sup-header clearfix">
			<div class="universal-wrapper--inner">
				<div class="header-wrapper header-wrapper--left">
					youremail@mail.com
				</div>
				<div class="header-wrapper header-wrapper--right">
					<div class="menu-wrapper menu-wrapper--top">
					+1545445555
					</div>
				</div>
			</div>
		</div>
		<section class="universal-wrapper header clearfix">
			<div class="universal-wrapper--inner">
				<div class="logo-wrapper">
					<a href="<?= site_url(); ?>">
						<img src="<?= get_template_directory_uri(); ?>/images/logo.png" />		
					</a>
				</div>
				<div class="header-menu">
					<nav class="top-menu">
						<? wp_nav_menu(['theme_location'=>"top-menu"]); ?>
					</nav>
				</div>
			</div>
		</section>
	</header>

	
    <!-- Content -->
    <?= \Vividcrestrealestate\Core\Template::loadPart(); ?>
    
	<footer class="universal-wrapper footer-block-wrapper">
		<div class="universal-wrapper--inner">
			Will be footer
		</div>
	</footer>
	<a id="scroller" class="btn_top" href="#" style="display: none">
		<img alt="home" src="">
	</a>
    <?php wp_footer() ?>
</body>
</html>
