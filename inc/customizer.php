<?php

add_action( 'customize_register', 'ct_apex_add_customizer_content' );

function ct_apex_add_customizer_content( $wp_customize ) {

	/***** Reorder default sections *****/

	$wp_customize->get_section( 'title_tagline' )->priority = 1;

	// check if exists in case user has no pages
	if ( is_object( $wp_customize->get_section( 'static_front_page' ) ) ) {
		$wp_customize->get_section( 'static_front_page' )->priority = 5;
		$wp_customize->get_section( 'static_front_page' )->title    = __( 'Front Page', 'apex' );
	}

	/***** Add PostMessage Support *****/

	// Add postMessage support for site title and description.
	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	/***** Add Custom Controls *****/
	/* Ad Controls */

	class apex_description_control extends WP_Customize_Control {

		public function render_content() {
			echo $this->description;
		}
	}

	/***** Logo Upload *****/

	// section
	$wp_customize->add_section( 'ct_apex_logo_upload', array(
		'title'    => __( 'Logo', 'apex' ),
		'priority' => 30
	) );
	// setting
	$wp_customize->add_setting( 'logo_upload', array(
		'sanitize_callback' => 'esc_url_raw',
		'transport'         => 'postMessage'
	) );
	// control
	$wp_customize->add_control( new WP_Customize_Image_Control(
		$wp_customize, 'logo_image', array(
			'label'    => __( 'Upload custom logo.', 'apex' ),
			'section'  => 'ct_apex_logo_upload',
			'settings' => 'logo_upload'
		)
	) );

	/***** Social Media Icons *****/

	// get the social sites array
	$social_sites = ct_apex_social_array();

	// set a priority used to order the social sites
	$priority = 5;

	// section
	$wp_customize->add_section( 'ct_apex_social_media_icons', array(
		'title'       => __( 'Social Media Icons', 'apex' ),
		'priority'    => 35,
		'description' => __( 'Add the URL for each of your social profiles.', 'apex' )
	) );

	// create a setting and control for each social site
	foreach ( $social_sites as $social_site => $value ) {
		// if email icon
		if ( $social_site == 'email' ) {
			// setting
			$wp_customize->add_setting( $social_site, array(
				'sanitize_callback' => 'ct_apex_sanitize_email',
				'transport'         => 'postMessage'
			) );
			// control
			$wp_customize->add_control( $social_site, array(
				'label'    => __( 'Email Address', 'apex' ),
				'section'  => 'ct_apex_social_media_icons',
				'priority' => $priority,
			) );
		} else {

			$label = ucfirst( $social_site );

			if ( $social_site == 'google-plus' ) {
				$label = 'Google Plus';
			} elseif ( $social_site == 'rss' ) {
				$label = 'RSS';
			} elseif ( $social_site == 'soundcloud' ) {
				$label = 'SoundCloud';
			} elseif ( $social_site == 'slideshare' ) {
				$label = 'SlideShare';
			} elseif ( $social_site == 'codepen' ) {
				$label = 'CodePen';
			} elseif ( $social_site == 'stumbleupon' ) {
				$label = 'StumbleUpon';
			} elseif ( $social_site == 'deviantart' ) {
				$label = 'DeviantArt';
			} elseif ( $social_site == 'hacker-news' ) {
				$label = 'Hacker News';
			} elseif ( $social_site == 'whatsapp' ) {
				$label = 'WhatsApp';
			} elseif ( $social_site == 'qq' ) {
				$label = 'QQ';
			} elseif ( $social_site == 'vk' ) {
				$label = 'VK';
			} elseif ( $social_site == 'wechat' ) {
				$label = 'WeChat';
			} elseif ( $social_site == 'tencent-weibo' ) {
				$label = 'Tencent Weibo';
			} elseif ( $social_site == 'paypal' ) {
				$label = 'PayPal';
			}

			// setting
			$wp_customize->add_setting( $social_site, array(
				'sanitize_callback' => 'esc_url_raw',
				'transport'         => 'postMessage'
			) );
			// control
			$wp_customize->add_control( $social_site, array(
				'type'     => 'url',
				'label'    => $label,
				'section'  => 'ct_apex_social_media_icons',
				'priority' => $priority
			) );
		}
		// increment the priority for next site
		$priority = $priority + 5;
	}

	/***** Search Bar *****/

	// section
	$wp_customize->add_section( 'apex_search_bar', array(
		'title'    => __( 'Search Bar', 'apex' ),
		'priority' => 37
	) );
	// setting
	$wp_customize->add_setting( 'search_bar', array(
		'default'           => 'hide',
		'sanitize_callback' => 'ct_apex_sanitize_all_show_hide_settings'
	) );
	// control
	$wp_customize->add_control( 'search_bar', array(
		'type'    => 'radio',
		'label'   => __( 'Show search bar at top of site?', 'apex' ),
		'section' => 'apex_search_bar',
		'setting' => 'search_bar',
		'choices' => array(
			'show' => __( 'Show', 'apex' ),
			'hide' => __( 'Hide', 'apex' )
		),
	) );

	/***** Blog *****/

	// section
	$wp_customize->add_section( 'apex_blog', array(
		'title'    => __( 'Blog', 'apex' ),
		'priority' => 45
	) );
	// setting
	$wp_customize->add_setting( 'full_post', array(
		'default'           => 'no',
		'sanitize_callback' => 'ct_apex_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'full_post', array(
		'label'    => __( 'Show full posts on blog?', 'apex' ),
		'section'  => 'apex_blog',
		'settings' => 'full_post',
		'type'     => 'radio',
		'choices'  => array(
			'yes' => __( 'Yes', 'apex' ),
			'no'  => __( 'No', 'apex' )
		)
	) );
	// setting
	$wp_customize->add_setting( 'excerpt_length', array(
		'default'           => '25',
		'sanitize_callback' => 'absint'
	) );
	// control
	$wp_customize->add_control( 'excerpt_length', array(
		'label'    => __( 'Excerpt word count', 'apex' ),
		'section'  => 'apex_blog',
		'settings' => 'excerpt_length',
		'type'     => 'number'
	) );
	// Read More text - setting
	$wp_customize->add_setting( 'read_more_text', array(
		'default'           => __( 'Continue reading', 'apex' ),
		'sanitize_callback' => 'ct_apex_sanitize_text'
	) );
	// Read More text - control
	$wp_customize->add_control( 'read_more_text', array(
		'label'    => __( 'Read More button text', 'apex' ),
		'section'  => 'apex_blog',
		'settings' => 'read_more_text',
		'type'     => 'text'
	) );

	/***** Additional Options *****/

	// section
	$wp_customize->add_section( 'apex_additional', array(
		'title'    => __( 'Additional Options', 'apex' ),
		'priority' => 70
	) );
	// author byline - setting
	$wp_customize->add_setting( 'author_byline', array(
		'default'           => 'no',
		'sanitize_callback' => 'ct_apex_sanitize_yes_no_settings'
	) );
	// author byline - control
	$wp_customize->add_control( 'author_byline', array(
		'label'    => __( 'Display post author name in byline?', 'apex' ),
		'section'  => 'apex_additional',
		'settings' => 'author_byline',
		'type'     => 'radio',
		'choices'  => array(
			'yes' => __( 'Yes', 'apex' ),
			'no'  => __( 'No', 'apex' )
		)
	) );

	/***** Custom CSS *****/

	// section
	$wp_customize->add_section( 'apex_custom_css', array(
		'title'    => __( 'Custom CSS', 'apex' ),
		'priority' => 75
	) );
	// setting
	$wp_customize->add_setting( 'custom_css', array(
		'sanitize_callback' => 'ct_apex_sanitize_css',
		'transport'         => 'postMessage'
	) );
	// control
	$wp_customize->add_control( 'custom_css', array(
		'type'     => 'textarea',
		'label'    => __( 'Add Custom CSS Here:', 'apex' ),
		'section'  => 'apex_custom_css',
		'settings' => 'custom_css'
	) );

	/*
	 * PRO only sections
	 */

	/***** Header Image *****/

	// section
	$wp_customize->add_section( 'apex_header_image', array(
		'title'    => __( 'Header Image', 'apex' ),
		'priority' => 35
	) );
	// setting
	$wp_customize->add_setting( 'header_image_ad', array(
		'sanitize_callback' => 'absint'
	) );
	// control
	$wp_customize->add_control( new apex_description_control(
		$wp_customize, 'header_image_ad', array(
			'section'     => 'apex_header_image',
			'settings'    => 'header_image_ad',
			'description' => sprintf( __( 'Activate the <a target="_blank" href="%s">Apex Pro Plugin</a> for advanced header image functionality.', 'apex' ), 'https://www.competethemes.com/apex-pro/' )
		)
	) );

	/***** Colors *****/

	// section
	$wp_customize->add_section( 'apex_colors', array(
		'title'    => __( 'Colors', 'apex' ),
		'priority' => 50
	) );
	// setting
	$wp_customize->add_setting( 'colors_ad', array(
		'sanitize_callback' => 'absint'
	) );
	// control
	$wp_customize->add_control( new apex_description_control(
		$wp_customize, 'colors_ad', array(
			'section'     => 'apex_colors',
			'settings'    => 'colors_ad',
			'description' => sprintf( __( 'Activate the <a target="_blank" href="%s">Apex Pro Plugin</a> to change your colors.', 'apex' ), 'https://www.competethemes.com/apex-pro/' )
		)
	) );

	/***** Fonts *****/

	// section
	$wp_customize->add_section( 'apex_font', array(
		'title'    => __( 'Font', 'apex' ),
		'priority' => 40
	) );
	// setting
	$wp_customize->add_setting( 'font_ad', array(
		'sanitize_callback' => 'absint'
	) );
	// control
	$wp_customize->add_control( new apex_description_control(
		$wp_customize, 'font_ad', array(
			'section'     => 'apex_font',
			'settings'    => 'font_ad',
			'description' => sprintf( __( 'Activate the <a target="_blank" href="%s">Apex Pro Plugin</a> to change your font.', 'apex' ), 'https://www.competethemes.com/apex-pro/' )
		)
	) );

	/***** Display Control *****/

	// section
	$wp_customize->add_section( 'apex_display_control', array(
		'title'    => __( 'Display Controls', 'apex' ),
		'priority' => 70
	) );
	// setting
	$wp_customize->add_setting( 'display_control_ad', array(
		'sanitize_callback' => 'absint'
	) );
	// control
	$wp_customize->add_control( new apex_description_control(
		$wp_customize, 'display_control_ad', array(
			'section'     => 'apex_display_control',
			'settings'    => 'display_control_ad',
			'description' => sprintf( __( 'Activate the <a target="_blank" href="%s">Apex Pro Plugin</a> to get hide/show controls.', 'apex' ), 'https://www.competethemes.com/apex-pro/' )
		)
	) );

	/***** Footer Text *****/

	// section
	$wp_customize->add_section( 'apex_footer_text', array(
		'title'    => __( 'Footer Text', 'apex' ),
		'priority' => 85
	) );
	// setting
	$wp_customize->add_setting( 'footer_text_ad', array(
		'sanitize_callback' => 'absint'
	) );
	// control
	$wp_customize->add_control( new apex_description_control(
		$wp_customize, 'footer_text_ad', array(
			'section'     => 'apex_footer_text',
			'settings'    => 'footer_text_ad',
			'description' => sprintf( __( 'Activate the <a target="_blank" href="%s">Apex Pro Plugin</a> to customize the footer text.', 'apex' ), 'https://www.competethemes.com/apex-pro/' )
		)
	) );

	/***** Layout *****/

	// section
	$wp_customize->add_section( 'apex_layout', array(
		'title'    => __( 'Layout', 'apex' ),
		'priority' => 47
	) );
	// setting
	$wp_customize->add_setting( 'layout_text_ad', array(
		'sanitize_callback' => 'absint'
	) );
	// control
	$wp_customize->add_control( new apex_description_control(
		$wp_customize, 'layout_ad', array(
			'section'     => 'apex_layout',
			'settings'    => 'layout_text_ad',
			'description' => sprintf( __( 'Activate the <a target="_blank" href="%s">Apex Pro Plugin</a> to change your layout.', 'apex' ), 'https://www.competethemes.com/apex-pro/' )
		)
	) );
}

/***** Custom Sanitization Functions *****/

/*
 * Sanitize settings with show/hide as options
 * Used in: search bar
 */
function ct_apex_sanitize_all_show_hide_settings( $input ) {

	$valid = array(
		'show' => __( 'Show', 'apex' ),
		'hide' => __( 'Hide', 'apex' )
	);

	return array_key_exists( $input, $valid ) ? $input : '';
}

/*
 * sanitize email address
 * Used in: Social Media Icons
 */
function ct_apex_sanitize_email( $input ) {
	return sanitize_email( $input );
}

function ct_apex_sanitize_yes_no_settings( $input ) {

	$valid = array(
		'yes' => __( 'Yes', 'apex' ),
		'no'  => __( 'No', 'apex' )
	);

	return array_key_exists( $input, $valid ) ? $input : '';
}

function ct_apex_sanitize_text( $input ) {
	return wp_kses_post( force_balance_tags( $input ) );
}

function ct_apex_sanitize_css( $css ) {
	$css = wp_kses( $css, array( '\'', '\"' ) );
	$css = str_replace( '&gt;', '>', $css );

	return $css;
}

/***** Helper Functions *****/

function ct_apex_customize_preview_js() {

	$content = "<script>jQuery('#customize-info').prepend('<div class=\"upgrades-ad\"><a href=\"https://www.competethemes.com/apex-pro/\" target=\"_blank\">" . __( 'View the Apex Pro Plugin', 'apex' ) . " <span>&rarr;</span></a></div>')</script>";
	echo apply_filters( 'ct_apex_customizer_ad', $content );
}

add_action( 'customize_controls_print_footer_scripts', 'ct_apex_customize_preview_js' );