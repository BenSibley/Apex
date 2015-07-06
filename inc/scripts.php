<?php

/*
 * Front-end scripts
 */
function ct_apex_load_scripts_styles() {

	wp_register_style( 'ct-apex-google-fonts', '//fonts.googleapis.com/css?family=Open+Sans:400,700|Satisfy');

	// main JS file
	wp_enqueue_script('ct-apex-js', get_template_directory_uri() . '/js/build/production.min.js', array('jquery'),'', true);
	wp_localize_script( 'ct-apex-js', 'objectL10n', array(
		'openMenu'       => __( 'open menu', 'apex' ),
		'closeMenu'      => __( 'close menu', 'apex' ),
		'openChildMenu'  => __( 'open dropdown menu', 'apex' ),
		'closeChildMenu' => __( 'close dropdown menu', 'apex' )
	) );

	// Google Fonts
	wp_enqueue_style('ct-apex-google-fonts');

	// Font Awesome
	wp_enqueue_style('font-awesome', get_template_directory_uri() . '/assets/font-awesome/css/font-awesome.min.css');

	// Stylesheet
	if( is_rtl() ) {
		wp_enqueue_style('ct-apex-style-rtl', get_template_directory_uri() . '/styles/rtl.min.css');
	} else {
		wp_enqueue_style('ct-apex-style', get_stylesheet_uri() );
	}

	// enqueue comment-reply script only on posts & pages with comments open ( included in WP core )
	if( is_singular() && comments_open() && get_option('thread_comments') ) {
		wp_enqueue_script( 'comment-reply' );
	}

	/* Load Polyfills */

	// HTML5 shiv
	wp_enqueue_script('ct-apex-html5-shiv', get_template_directory_uri() . '/js/build/html5shiv.min.js');
	wp_script_add_data( 'ct-apex-html5-shiv', 'conditional', 'IE 8' );

	// respond.js - media query support
	wp_enqueue_script('ct-apex-respond', get_template_directory_uri() . '/js/build/respond.min.js', '', '', true);
	wp_script_add_data( 'ct-apex-respond', 'conditional', 'IE 8' );
}
add_action('wp_enqueue_scripts', 'ct_apex_load_scripts_styles' );

/*
 * Back-end scripts
 */
function ct_apex_enqueue_admin_styles($hook){

	// if is user profile page
	if('profile.php' == $hook || 'user-edit.php' == $hook ){

		// Enqueues all scripts, styles, settings, and templates necessary to use all media JavaScript APIs.
		wp_enqueue_media();

		// enqueue the JS needed to utilize media uploader on profile image upload
		wp_enqueue_script('ct-apex-profile-image-uploader', get_template_directory_uri() . '/js/build/profile-image-uploader.min.js');
	}
	// if theme options page
	if( 'appearance_page_apex-options' == $hook ) {

		// Admin styles
		wp_enqueue_style('ct-apex-admin-styles', get_template_directory_uri() . '/styles/admin.min.css');
	}
}
add_action('admin_enqueue_scripts',	'ct_apex_enqueue_admin_styles' );

/*
 * Customizer scripts
 */
function ct_apex_enqueue_customizer_scripts(){

	// stylesheet for customizer
	wp_enqueue_style('ct-apex-customizer-styles', get_template_directory_uri() . '/styles/customizer.min.css');

}
add_action('customize_controls_enqueue_scripts','ct_apex_enqueue_customizer_scripts');

/*
 * Script for live updating with customizer options. Has to be loaded separately on customize_preview_init hook
 * transport => postMessage
 */
function apex_enqueue_customizer_post_message_scripts(){

	// JS for live updating with customizer input
	wp_enqueue_script('ct-apex-customizer-post-message-js', get_template_directory_uri() . '/js/build/postMessage.min.js',array('jquery'),'',true);

}
add_action('customize_preview_init','apex_enqueue_customizer_post_message_scripts');