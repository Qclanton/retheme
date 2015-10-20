<?php
$part = \Vividcrestrealestate\Core\Router::definePart();
$data = \Vividcrestrealestate\Core\Router::loadData($part);
?>

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
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/form.css" />
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/buttons.css" />
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/menus.css" />
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/cols.css" />
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/slider.css" />
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/calculator.css" />
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/jquery.arcticmodal-0.3.css" />
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/page_inner.css" />
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/property__page.css" />
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/properties.css" />
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/compare.css" />
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/jquery-ui.css" />
	<link href="<?php echo get_template_directory_uri(); ?>/css/font-awesome.min.css" rel="stylesheet">
	<link rel="icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/favicon.png" />	
	<meta name="viewport" content="width=device-width, initial-scale=0.85, maximum-scale=0.85, user-scalable=0" />
	<meta name="viewport" content="target-densitydpi=high-dpi" />
	<meta name="MobileOptimized" content="720"/>
	<meta name="HandheldFriendly" content="true"/>
    
    <script>
        var Vividcrest = {
            properties: <?= (isset($data->properties) ? "JSON.parse('" . stripcslashes(json_encode($data->properties, JSON_HEX_APOS | JSON_HEX_QUOT)) . "')" : "null") ?>,
            property: <?= (isset($data->property) ? "JSON.parse('" . stripcslashes(json_encode($data->property, JSON_HEX_APOS | JSON_HEX_QUOT)) . "')" : "null") ?>
        };
    </script>
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
    <?= \Vividcrestrealestate\Core\Template::renderPart($part, $data); ?>
    
	<section class="universal-wrapper colored__line colored__line--blue">
		<div class="universal-wrapper--inner">
			<h1>Call us today! <a href="tel:416-939-6376">416-939-6376</a></h1>
		</div>
	</section>
	
	<footer class="universal-wrapper footer-block-wrapper">
		<div class="universal-wrapper--inner">
			<div class="universal_line-wrapper three__cols">
				<div class="universal__cell footer footer--first">
					<a href="<?= site_url(); ?>">
						<img class="logo_footer" src="<?= get_template_directory_uri(); ?>/images/footer-logo.png" />		
					</a>
					<ul class="list__checked-icon">
						<li>
							<i class="fa fa-home"></i>
							<p>
								10 Walsh Avenue, Toronto, ON, M9M 1B6
							</p>
						</li>
						<li>
							<i class="fa fa-phone-square"></i>
							<p>
								<a href="tel:416-939-6376">416-939-6376</a>
							</p>
						</li>
						<li>
							<i class="fa fa-fax"></i>
							<p>
								416-747-9855
							</p>
						</li>
						<li>
							<i class="fa fa-envelope"></i>
							<p>
								<a href="mailto:salequick.ca@gmail.com">salequick.ca@gmail.com</a>
							</p>
						</li>
					</ul>
				</div>
				<div class="universal__cell footer">
					<h2>Useful Links</h2>
					<ul class="list__checked-icon">
						<li>
							<i class="fa fa-link"></i>
							<p>
								<a href="#">How to buy your property</a>
							</p>
						</li>
						<li>
							<i class="fa fa-link"></i>
							<p>
								<a href="#">How to sell your property</a>
							</p>
						</li>
					</ul>
				</div>
				
				<div class="universal__cell footer footer--last">
					<h2>Subscribe to Newsletter </h2>
				</div>
			</div>
		</div>
	</footer>
	<a id="scroller" class="btn_top" href="#" style="display: none">
		<img alt="home" src="">
	</a>
    <?php wp_footer() ?>
</body>
</html>
