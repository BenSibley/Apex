<?php

add_action( 'customize_register', 'ct_apex_add_customizer_content' );

function ct_apex_add_customizer_content( $wp_customize ) {

	/***** Reorder default sections *****/

	$wp_customize->get_section( 'title_tagline' )->priority = 2;

	// check if exists in case user has no pages
	if ( is_object( $wp_customize->get_section( 'static_front_page' ) ) ) {
		$wp_customize->get_section( 'static_front_page' )->priority = 5;
		$wp_customize->get_section( 'static_front_page' )->title    = __( 'Front Page', 'apex' );
	}

	/***** Add PostMessage Support *****/

	// Add postMessage support for site title and description.
	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	/***** Apex Pro Control *****/

	class ct_apex_pro_ad extends WP_Customize_Control {
		public function render_content() {
			$link = 'https://www.competethemes.com/apex-pro/';
			echo "<a href='" . $link . "' target='_blank'><img src='" . get_template_directory_uri() . "/assets/images/apex-pro.gif' /></a>";
			echo "<p class='bold'>" . sprintf( __('<a target="_blank" href="%1$s">%2$s Pro</a> is the plugin that makes advanced customization simple - and fun too!', 'apex'), $link, wp_get_theme( get_template() ) ) . "</p>";
			echo "<p>" . sprintf( __('%1$s Pro adds the following features to %1$s:', 'apex'), wp_get_theme( get_template() ) ) . "</p>";
			echo "<ul>
					<li>" . __('Custom Colors', 'apex') . "</li>
					<li>" . __('7 New layouts', 'apex') . "</li>
					<li>" . __('Featured Videos', 'apex') . "</li>
					<li>" . __('+ 7 more features', 'apex') . "</li>
				  </ul>";
			echo "<p class='button-wrapper'><a target=\"_blank\" class='apex-pro-button' href='" . $link . "'>" . sprintf( __('View %s Pro', 'apex'), wp_get_theme( get_template() ) ) . "</a></p>";
		}
	}

	/***** Apex Pro Section *****/

	// don't add if Apex Pro is active
	if ( !function_exists( 'ct_apex_pro_init' ) ) {
		// section
		$wp_customize->add_section( 'ct_apex_pro', array(
			'title'    => sprintf( __( '%s Pro', 'apex' ), wp_get_theme( get_template() ) ),
			'priority' => 1
		) );
		// Upload - setting
		$wp_customize->add_setting( 'apex_pro', array(
			'sanitize_callback' => 'absint'
		) );
		// Upload - control
		$wp_customize->add_control( new ct_apex_pro_ad(
			$wp_customize, 'apex_pro', array(
				'section'  => 'ct_apex_pro',
				'settings' => 'apex_pro'
			)
		) );
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
			} elseif ( $social_site == 'google-wallet' ) {
				$label = 'Google Wallet';
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
			} elseif ( $social_site == 'email-form' ) {
				$label = 'Contact Form';
			}

			if ( $social_site == 'skype' ) {
				// setting
				$wp_customize->add_setting( $social_site, array(
					'sanitize_callback' => 'ct_apex_sanitize_skype',
					'transport'         => 'postMessage'
				) );
				// control
				$wp_customize->add_control( $social_site, array(
					'type'        => 'url',
					'label'       => $label,
					'description' => sprintf( __( 'Accepts Skype link protocol (<a href="%s" target="_blank">learn more</a>)', 'apex' ), 'https://www.competethemes.com/blog/skype-links-wordpress/' ),
					'section'     => 'ct_apex_social_media_icons',
					'priority'    => $priority
				) );
			} else {
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
		'title'    => _x( 'Blog', 'noun: the blog section', 'apex' ),
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
	// comments link - setting
	$wp_customize->add_setting( 'comments_link', array(
		'default'           => 'yes',
		'sanitize_callback' => 'ct_apex_sanitize_yes_no_settings'
	) );
	// comments link - control
	$wp_customize->add_control( 'comments_link', array(
		'label'    => __( 'Display comments link after posts?', 'apex' ),
		'section'  => 'apex_additional',
		'settings' => 'comments_link',
		'type'     => 'radio',
		'choices'  => array(
			'yes' => __( 'Yes', 'apex' ),
			'no'  => __( 'No', 'apex' )
		)
	) );

	/***** Custom CSS *****/

	if ( function_exists( 'wp_update_custom_css_post' ) ) {
		// Migrate any existing theme CSS to the core option added in WordPress 4.7.
		$css = get_theme_mod( 'custom_css' );
		if ( $css ) {
			$core_css = wp_get_custom_css(); // Preserve any CSS already added to the core option.
			$return = wp_update_custom_css_post( $core_css . $css );
			if ( ! is_wp_error( $return ) ) {
				// Remove the old theme_mod, so that the CSS is stored in only one place moving forward.
				remove_theme_mod( 'custom_css' );
			}
		}
	} else {
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
	}
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

function ct_apex_sanitize_skype( $input ) {
	return esc_url_raw( $input, array( 'http', 'https', 'skype' ) );
}

function ct_apex_sanitize_css( $css ) {
	$css = wp_kses( $css, array( '\'', '\"' ) );
	$css = str_replace( '&gt;', '>', $css );

	return $css;
}