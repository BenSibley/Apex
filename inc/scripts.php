<?php

// Front-end scripts
function ct_apex_load_scripts_styles() {

	$font_args = array(
		'family'  => urlencode( 'Open Sans:400,700|Satisfy' ),
		'subset'  => urlencode( 'latin,latin-ext' ),
		'display' => 'swap'
	);
	$fonts_url = add_query_arg( $font_args, '//fonts.googleapis.com/css' );
	
	wp_enqueue_style( 'ct-apex-google-fonts', $fonts_url );

	wp_enqueue_script( 'ct-apex-js', get_template_directory_uri() . '/js/build/production.min.js', array( 'jquery' ), '', true );
	wp_localize_script( 'ct-apex-js', 'ct_apex_objectL10n', array(
		'openMenu'       => esc_html_x( 'open menu', 'verb: open the menu', 'apex' ),
		'closeMenu'      => esc_html_x( 'close menu', 'verb: close the menu', 'apex' ),
		'openChildMenu'  => esc_html_x( 'open dropdown menu', 'verb: open the dropdown menu', 'apex' ),
		'closeChildMenu' => esc_html_x( 'close dropdown menu', 'verb: close the  dropdown menu', 'apex' )
	) );

	wp_enqueue_style( 'ct-apex-font-awesome', get_template_directory_uri() . '/assets/font-awesome/css/all.min.css' );

	wp_enqueue_style( 'ct-apex-style', get_stylesheet_uri() );

	// enqueue comment-reply script only on posts & pages with comments open ( included in WP core )
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	/* Load Polyfills */

	wp_enqueue_script( 'ct-apex-html5-shiv', get_template_directory_uri() . '/js/build/html5shiv.min.js' );

	wp_enqueue_script( 'ct-apex-respond', get_template_directory_uri() . '/js/build/respond.min.js', '', '', true );

	// prevent fatal error on < WP 4.2 (load files unconditionally instead)
	if ( function_exists( 'wp_script_add_data' ) ) {
		wp_script_add_data( 'ct-apex-html5-shiv', 'conditional', 'IE 8' );
		wp_script_add_data( 'ct-apex-respond', 'conditional', 'IE 8' );
	}
}
add_action( 'wp_enqueue_scripts', 'ct_apex_load_scripts_styles' );

// Back-end scripts
function ct_apex_enqueue_admin_styles( $hook ) {

	if ( $hook == 'appearance_page_apex-options' ) {
		wp_enqueue_style( 'ct-apex-admin-styles', get_template_directory_uri() . '/styles/admin.min.css' );
	}
	if ( $hook == 'post.php' || $hook == 'post-new.php' ) {

		$font_args = array(
			'family' => urlencode( 'Open Sans:400,700|Satisfy' ),
			'subset' => urlencode( 'latin,latin-ext' )
		);
		$fonts_url = add_query_arg( $font_args, '//fonts.googleapis.com/css' );
	
		wp_enqueue_style( 'ct-apex-google-fonts', $fonts_url );
	}
}
add_action( 'admin_enqueue_scripts', 'ct_apex_enqueue_admin_styles' );

// Customizer scripts
function ct_apex_enqueue_customizer_scripts() {
	wp_enqueue_style( 'ct-apex-customizer-styles', get_template_directory_uri() . '/styles/customizer.min.css' );
}
add_action( 'customize_controls_enqueue_scripts', 'ct_apex_enqueue_customizer_scripts' );

/*
 * Script for live updating with customizer options. Has to be loaded separately on customize_preview_init hook
 * transport => postMessage
 */
function ct_apex_enqueue_customizer_post_message_scripts() {
	wp_enqueue_script( 'ct-apex-customizer-post-message-js', get_template_directory_uri() . '/js/build/postMessage.min.js', array( 'jquery' ), '', true );
}
add_action( 'customize_preview_init', 'ct_apex_enqueue_customizer_post_message_scripts' );