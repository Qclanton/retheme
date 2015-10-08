<!doctype html>
<html lang=ru>
<head>
	<meta charset=utf-8>
	<title> </title>
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/style.css" />
	<link href='https://fonts.googleapis.com/css?family=PT+Sans:400,700,400italic,700italic&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=PT+Serif:400,700&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/responsive.css" />
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/buttons.css" />
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/menus.css" />
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/cols.css" />
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
	
	</header>
    
    <!-- Content -->
    Will be content

	<footer>
		<div class="page__universal-wrapper"> 
		</div>
	</footer>
	<a id="scroller" class="btn_top" href="#" style="display: none">
		<img alt="home" src="">
	</a>
    <?php wp_footer() ?>
</body>
</html>
