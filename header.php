<!DOCTYPE html>

<html <?php language_attributes(); ?>>

<head>
	<?php wp_head(); ?>
</head>

<body id="<?php print get_stylesheet(); ?>" <?php body_class(); ?>>
	<?php do_action( 'body_top' ); ?>
	<?php 
	if ( function_exists( 'wp_body_open' ) ) {
				wp_body_open();
		} else {
				do_action( 'wp_body_open' );
	} ?>
	<a class="skip-content" href="#main"><?php esc_html_e( 'Skip to content', 'apex' ); ?></a>
	<div id="overflow-container" class="overflow-container">
		<div id="max-width" class="max-width">
			<?php do_action( 'before_header' ); ?>
			<?php
			// Elementor `header` location
			if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'header' ) ) :
			?>
			<header class="site-header" id="site-header" role="banner">
				<div id="menu-primary-container" class="menu-primary-container">
					<?php get_template_part( 'menu', 'primary' ); ?>
					<?php get_template_part( 'content/search-bar' ); ?>
					<?php ct_apex_social_icons_output( 'header' ); ?>
				</div>
				<button id="toggle-navigation" class="toggle-navigation">
					<span class="screen-reader-text"><?php _ex( 'open menu', 'verb: open the menu', 'apex' ); ?></span>
					<?php echo ct_apex_svg_output( 'toggle-navigation' ); ?>
				</button>
				<div id="title-container" class="title-container">
					<?php get_template_part( 'logo' ) ?>
					<?php if ( get_bloginfo( 'description' ) ) {
						echo '<p class="tagline">' . esc_html( get_bloginfo( 'description' ) ) . '</p>';
					} ?>
				</div>
			</header>
			<?php endif; ?>
			<?php do_action( 'after_header' ); ?>
			<section id="main" class="main" role="main">
				<?php do_action( 'main_top' );
				if ( function_exists( 'yoast_breadcrumb' ) ) {
					yoast_breadcrumb( '<p id="breadcrumbs">', '</p>' );
				}