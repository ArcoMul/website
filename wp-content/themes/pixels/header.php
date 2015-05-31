<!DOCTYPE html>
<html>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<title><?php
		/*
		 * Print the <title> tag based on what is being viewed.
		 */
		global $page, $paged;
	
		wp_title( '|', true, 'right' );
	
		// Add the blog name.
		bloginfo( 'name' );
	
		// Add the blog description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) )
			echo " | $site_description";
		?></title>
		<meta name="description" content="<?php echo htmlentities(get_the_excerpt()); ?>" />
		<meta name="viewport" content="width=device-width">
		<link rel="shortcut icon" href="/wp-content/themes/pixels/favicon.ico" type="image/x-icon" />
        <link href='http://fonts.googleapis.com/css?family=Gentium+Book+Basic:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,800,700,300' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
		<!--[if IE 8]>
		    <link rel="stylesheet" type="text/css" href="<?php bloginfo( 'template_url' ); ?>/ie8.css" />
		<![endif]-->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.js"></script>
		<script src="<?php bloginfo( 'template_url' ); ?>/js/jquery-ui-1.8.19.custom.min.js"></script>
		<script src="<?php bloginfo( 'template_url' ); ?>/js/jquery.waitforimages.js"></script>
		<script src="<?php bloginfo( 'template_url' ); ?>/js/jquery.scrollTo-1.4.2-min.js"></script>
		<script src="<?php bloginfo( 'template_url' ); ?>/js/main.js"></script>
		<?php wp_head(); ?>
		<script type="text/javascript">
		  var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', 'UA-21749620-1']);
		  _gaq.push(['_setDomainName', '.arcomul.nl']);
		  _gaq.push(['_trackPageview']);
		  (function() {
		    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  })();
		</script>
	</head>
	<body>
		<div id="background" style="background-position: 0px 0px;"></div>
		<div id="goToTop"></div>
		<div class="column left">
			<div class="profile-picture">
                <a href="/about">
                    <img src="/wp-content/themes/pixels/img/arco.png" />
                </a>
			</div>
            <div class="top-menu-button">Menu</div>
			<?php wp_nav_menu(array('menu' => 'main')); ?>
		</div>
		<div class="column middle">
