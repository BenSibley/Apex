<!DOCTYPE html>

<html <?php language_attributes(); ?>>

<head>

    <?php wp_head(); ?>

</head>

<body id="<?php print get_stylesheet(); ?>" <?php body_class(); ?>>

	<?php hybrid_do_atomic( 'body_top' ); ?>

	<!--skip to content link-->
	<a class="skip-content" href="#main"><?php _e('Skip to content', 'apex'); ?></a>

	<div id="overflow-container" class="overflow-container">
		<div id="max-width" class="max-width">
			<?php hybrid_do_atomic( 'before_header' ); ?>
			<header class="site-header" id="site-header" role="banner">

				<div id="menu-primary-container" class="menu-primary-container">

					<!-- Primary Menu -->
					<?php get_template_part( 'menu', 'primary' ); ?>

					<!-- Social Icons -->
					<?php ct_apex_social_icons_output('header'); ?>

				</div>

				<button id="toggle-navigation" class="toggle-navigation">
					<span class="screen-reader-text"><?php _e('open menu', 'apex'); ?></span>
					<?php echo ct_apex_svg_output( 'toggle-navigation' ); ?>
				</button>

				<div id="title-container" class="title-container">
					<?php get_template_part('logo')  ?>
					<?php if ( get_bloginfo( 'description' ) ) {
						echo '<p class="tagline">' . get_bloginfo( 'description' ) .'</p>';
					} ?>
				</div>
			</header>
			<?php hybrid_do_atomic( 'after_header' ); ?>
			<section id="main" class="main" role="main">
				<?php hybrid_do_atomic( 'main_top' ); ?>