<?php

add_action( 'customize_register', 'ct_apex_add_customizer_content' );

function ct_apex_add_customizer_content( $wp_customize ) {

	/***** Reorder default sections *****/

	$wp_customize->get_section( 'title_tagline' )->priority = 2;

	// check if exists in case user has no pages
	if ( is_object( $wp_customize->get_section( 'static_front_page' ) ) ) {
		$wp_customize->get_section( 'static_front_page' )->priority = 5;
	}

	/***** Add PostMessage Support *****/

	// Add postMessage support for site title and description.
	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

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
		} else if ( $social_site == 'phone' ) {
			// setting
			$wp_customize->add_setting( $social_site, array(
				'sanitize_callback' => 'ct_apex_sanitize_phone',
				'transport'         => 'postMessage'
			) );
			// control
			$wp_customize->add_control( $social_site, array(
				'label'    => __( 'Phone', 'apex' ),
				'section'     => 'ct_apex_social_media_icons',
				'priority'    => $priority,
				'type'        => 'text'
			) );
		} else {

			$label = ucfirst( $social_site );

			if ( $social_site == 'rss' ) {
				$label = __('RSS', 'apex');
			} elseif ( $social_site == 'diaspora' ) {
				$label = __('diaspora*', 'apex');
			} elseif ( $social_site == 'imdb' ) {
				$label = __('IMDB', 'apex');
			} elseif ( $social_site == 'researchgate' ) {
				$label = __('ResearchGate', 'apex');
			} elseif ( $social_site == 'soundcloud' ) {
				$label = __('SoundCloud', 'apex');
			} elseif ( $social_site == 'slideshare' ) {
				$label = __('SlideShare', 'apex');
			} elseif ( $social_site == 'codepen' ) {
				$label = __('CodePen', 'apex');
			} elseif ( $social_site == 'stumbleupon' ) {
				$label = __('StumbleUpon', 'apex');
			} elseif ( $social_site == 'deviantart' ) {
				$label = __('DeviantArt', 'apex');
			} elseif ( $social_site == 'google-wallet' ) {
				$label = __('Google Wallet', 'apex');
			} elseif ( $social_site == 'hacker-news' ) {
				$label = __('Hacker News', 'apex');
			} elseif ( $social_site == 'whatsapp' ) {
				$label = __('WhatsApp', 'apex');
			} elseif ( $social_site == 'qq' ) {
				$label = __('QQ', 'apex');
			} elseif ( $social_site == 'vk' ) {
				$label =__('VK', 'apex');
			} elseif ( $social_site == 'ok-ru' ) {
				$label = __('OK.ru', 'apex');
			} elseif ( $social_site == 'wechat' ) {
				$label = __('WeChat', 'apex');
			} elseif ( $social_site == 'tencent-weibo' ) {
				$label = __('Tencent Weibo', 'apex');
			} elseif ( $social_site == 'paypal' ) {
				$label = __('PayPal', 'apex');
			} elseif ( $social_site == 'stack-overflow' ) {
				$label = __('Stack Overflow', 'apex');
			} elseif ( $social_site == 'email-form' ) {
				$label = __('Contact Form', 'apex');
			} elseif ( $social_site == 'twitter' ) {
				$label = __('X (Twitter)', 'apex');
			}

			if ( $social_site == 'skype' ) {
				// setting
				$wp_customize->add_setting( $social_site, array(
					'sanitize_callback' => 'ct_apex_sanitize_skype'
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
					'sanitize_callback' => 'esc_url_raw'
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

	// Custom icon 1
	$wp_customize->add_setting( 'social_icon_custom_1_name', array(
		'sanitize_callback' => 'ct_apex_sanitize_text'
	) );
	$wp_customize->add_control( 'social_icon_custom_1_name', array(
		'label'    => __('Custom icon 1 Name', 'apex'),
		'section'  => 'ct_apex_social_media_icons',
		'settings' => 'social_icon_custom_1_name',
		'type'     => 'text',
		'priority' => $priority + 5
	) );
	$wp_customize->add_setting( 'social_icon_custom_1', array(
		'sanitize_callback' => 'esc_url_raw'
	) );
	$wp_customize->add_control( 'social_icon_custom_1', array(
		'label'    => __('Custom icon 1 URL', 'apex'),
		'section'  => 'ct_apex_social_media_icons',
		'settings' => 'social_icon_custom_1',
		'type'     => 'url',
		'priority' => $priority + 6
	) );
	$wp_customize->add_setting( 'social_icon_custom_1_image', array(
		'sanitize_callback' => 'esc_url_raw'
	) );
	$wp_customize->add_control(new WP_Customize_Image_Control( $wp_customize, 'social_icon_custom_1_image', array(
		'label'    => __( 'Custom icon 1 image', 'apex' ),
		'section'  => 'ct_apex_social_media_icons',
		'settings' => 'social_icon_custom_1_image',
		'priority' => $priority + 7
	)));
	$wp_customize->add_setting( 'social_icon_custom_1_size', array(
		'default'			=> '20',
		'sanitize_callback' => 'absint'
	) );
	$wp_customize->add_control( 'social_icon_custom_1_size', array(
		'label'    => __('Custom icon 1 size (px)', 'apex'),
		'section'  => 'ct_apex_social_media_icons',
		'settings' => 'social_icon_custom_1_size',
		'type'     => 'number',
		'priority' => $priority + 8
	) );
	// Custom icon 2
	$wp_customize->add_setting( 'social_icon_custom_2_name', array(
		'sanitize_callback' => 'ct_apex_sanitize_text'
	) );
	$wp_customize->add_control( 'social_icon_custom_2_name', array(
		'label'    => __('Custom icon 2 Name', 'apex'),
		'section'  => 'ct_apex_social_media_icons',
		'settings' => 'social_icon_custom_2_name',
		'type'     => 'text',
		'priority' => $priority + 9
	) );
	$wp_customize->add_setting( 'social_icon_custom_2', array(
		'sanitize_callback' => 'esc_url_raw'
	) );
	$wp_customize->add_control( 'social_icon_custom_2', array(
		'label'    => __('Custom icon 2 URL', 'apex'),
		'section'  => 'ct_apex_social_media_icons',
		'settings' => 'social_icon_custom_2',
		'type'     => 'url',
		'priority' => $priority + 10
	) );
	$wp_customize->add_setting( 'social_icon_custom_2_image', array(
		'sanitize_callback' => 'esc_url_raw'
	) );
	$wp_customize->add_control(new WP_Customize_Image_Control( $wp_customize, 'social_icon_custom_2_image', array(
		'label'    => __( 'Custom icon 2 image', 'apex' ),
		'section'  => 'ct_apex_social_media_icons',
		'settings' => 'social_icon_custom_2_image',
		'priority' => $priority + 11
	)));
	$wp_customize->add_setting( 'social_icon_custom_2_size', array(
		'default'			=> '20',
		'sanitize_callback' => 'absint'
	) );
	$wp_customize->add_control( 'social_icon_custom_2_size', array(
		'label'    => __('Custom icon 2 size (px)', 'apex'),
		'section'  => 'ct_apex_social_media_icons',
		'settings' => 'social_icon_custom_2_size',
		'type'     => 'number',
		'priority' => $priority + 12
	) );
	// Custom icon 3
	$wp_customize->add_setting( 'social_icon_custom_3_name', array(
		'sanitize_callback' => 'ct_apex_sanitize_text'
	) );
	$wp_customize->add_control( 'social_icon_custom_3_name', array(
		'label'    => __('Custom icon 3 Name', 'apex'),
		'section'  => 'ct_apex_social_media_icons',
		'settings' => 'social_icon_custom_3_name',
		'type'     => 'text',
		'priority' => $priority + 13
	) );
	$wp_customize->add_setting( 'social_icon_custom_3', array(
		'sanitize_callback' => 'esc_url_raw'
	) );
	$wp_customize->add_control( 'social_icon_custom_3', array(
		'label'    => __('Custom icon 3 URL', 'apex'),
		'section'  => 'ct_apex_social_media_icons',
		'settings' => 'social_icon_custom_3',
		'type'     => 'url',
		'priority' => $priority + 14
	) );
	$wp_customize->add_setting( 'social_icon_custom_3_image', array(
		'sanitize_callback' => 'esc_url_raw'
	) );
	$wp_customize->add_control(new WP_Customize_Image_Control( $wp_customize, 'social_icon_custom_3_image', array(
		'label'    => __( 'Custom icon 3 image', 'apex' ),
		'section'  => 'ct_apex_social_media_icons',
		'settings' => 'social_icon_custom_3_image',
		'priority' => $priority + 15
	)));
	$wp_customize->add_setting( 'social_icon_custom_3_size', array(
		'default'			=> '20',
		'sanitize_callback' => 'absint'
	) );
	$wp_customize->add_control( 'social_icon_custom_3_size', array(
		'label'    => __('Custom icon 3 size (px)', 'apex'),
		'section'  => 'ct_apex_social_media_icons',
		'settings' => 'social_icon_custom_3_size',
		'type'     => 'number',
		'priority' => $priority + 16
	) );

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
	// setting - scroll-to-top arrow
	$wp_customize->add_setting( 'scroll_to_top', array(
		'default'           => 'no',
		'sanitize_callback' => 'ct_apex_sanitize_yes_no_settings'
	) );
	// control - scroll-to-top arrow
	$wp_customize->add_control( 'scroll_to_top', array(
		'label'    => __( 'Display Scroll-to-top arrow?', 'apex' ),
		'section'  => 'apex_additional',
		'settings' => 'scroll_to_top',
		'type'     => 'radio',
		'choices'  => array(
			'yes' => __( 'Yes', 'apex' ),
			'no'  => __( 'No', 'apex' )
		)
	) );
	// setting - last updated
	$wp_customize->add_setting( 'last_updated', array(
		'default'           => 'no',
		'sanitize_callback' => 'ct_apex_sanitize_yes_no_settings'
	) );
	// control - last updated
	$wp_customize->add_control( 'last_updated', array(
		'label'    => __( 'Display the date each post was last updated?', 'apex' ),
		'section'  => 'apex_additional',
		'settings' => 'last_updated',
		'type'     => 'radio',
		'choices'  => array(
			'yes' => __( 'Yes', 'apex' ),
			'no'  => __( 'No', 'apex' )
		)
	) );
	// setting - featured image captions
	$wp_customize->add_setting( 'featured_image_captions', array(
		'default'           => 'no',
		'sanitize_callback' => 'ct_apex_sanitize_yes_no_settings'
	) );
	// control - featured image captions
	$wp_customize->add_control( 'featured_image_captions', array(
		'label'    => __( 'Show the Featured Image caption on the post page?', 'apex' ),
		'section'  => 'apex_additional',
		'settings' => 'featured_image_captions',
		'type'     => 'radio',
		'choices' => array(
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

function ct_apex_sanitize_phone( $input ) {
	if ( $input != '' ) {
		return esc_url_raw( 'tel:' . $input, array( 'tel' ) );
	} else {
		return '';
	}
}

function ct_apex_customize_preview_js() {
	if ( !function_exists( 'ct_apex_pro_init' ) && !(isset($_GET['mailoptin_optin_campaign_id']) || isset($_GET['mailoptin_email_campaign_id'])) ) {
		$url = 'https://www.competethemes.com/apex-pro/?utm_source=wp-dashboard&utm_medium=Customizer&utm_campaign=Apex%20Pro%20-%20Customizer';
		$content = "<script>jQuery('#customize-info').prepend('<div class=\"upgrades-ad\"><a href=\"". $url ."\" target=\"_blank\">Customize Colors with Apex Pro <span>&rarr;</span></a></div>')</script>";
		echo apply_filters('ct_apex_customizer_ad', $content);
	}
}
add_action('customize_controls_print_footer_scripts', 'ct_apex_customize_preview_js');