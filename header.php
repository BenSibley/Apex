<!DOCTYPE html>

<!--[if IE 8 ]><html class="ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 9 ]><html class="ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html <?php language_attributes(); ?>> <!--<![endif]-->

<head>

	<!--[if IE 8 ]>
	<script src="<?php echo trailingslashit( get_template_directory_uri() ) . 'js/build/html5shiv.min.js'; ?>"></script>
	<![endif]-->

    <?php wp_head(); ?>

</head>

<body id="<?php print get_stylesheet(); ?>" <?php body_class(); ?>>

<!--skip to content link-->
<a class="skip-content" href="#main"><?php _e('Skip to content', 'unlimited'); ?></a>

<div id="overflow-container" class="overflow-container">
	<div id="max-width" class="max-width">
		<header class="site-header" id="site-header" role="banner">

			<?php ct_unlimited_social_icons_output('header'); ?>
			<?php get_template_part('content/search-bar'); ?>

			<div id="title-container" class="title-container">
				<?php get_template_part('logo')  ?>
				<?php if ( get_bloginfo( 'description' ) ) {
					echo '<p class="site-description">' . get_bloginfo( 'description' ) .'</p>';
				} ?>
			</div>

			<button id="toggle-navigation" class="toggle-navigation">
				<i class="fa fa-bars"></i>
			</button>

			<?php get_template_part( 'menu', 'primary' ); ?>

		</header>
		<section id="main" class="main" role="main">