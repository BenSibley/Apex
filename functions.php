<?php

/*
 * Reviewer note:
 * ct in function prefix = Compete Themes. Added to lessen chance of conflict.
 */

// Load the core theme framework.
require_once( trailingslashit( get_template_directory() ) . 'library/hybrid.php' );
new Hybrid();

// theme setup
if( ! function_exists( ( 'ct_apex_theme_setup' ) ) ) {
	function ct_apex_theme_setup() {

		/* Get action/filter hook prefix. */
		$prefix = hybrid_get_prefix();

		// add Hybrid core functionality
		add_theme_support( 'hybrid-core-template-hierarchy' );
		add_theme_support( 'loop-pagination' );
		add_theme_support( 'cleaner-gallery' );

		// add functionality from WordPress core
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );

		// load theme options page
		require_once( trailingslashit( get_template_directory() ) . 'theme-options.php' );

		// add inc folder files
		foreach ( glob( trailingslashit( get_template_directory() ) . 'inc/*' ) as $filename ) {
			include $filename;
		}

		// load text domain
		load_theme_textdomain( 'apex', get_template_directory() . '/languages' );

		// register Primary menu
		register_nav_menus( array(
			'primary' => __( 'Primary', 'apex' )
		) );
	}
}
add_action( 'after_setup_theme', 'ct_apex_theme_setup', 10 );

// remove filters adding partial micro-data due to validation issues
function apex_remove_hybrid_filters() {
    remove_filter( 'the_author_posts_link', 'hybrid_the_author_posts_link', 5 );
    remove_filter( 'get_comment_author_link', 'hybrid_get_comment_author_link', 5 );
    remove_filter( 'get_comment_author_url_link', 'hybrid_get_comment_author_url_link', 5 );
    remove_filter( 'comment_reply_link', 'hybrid_comment_reply_link_filter', 5 );
    remove_filter( 'get_avatar', 'hybrid_get_avatar', 5 );
    remove_filter( 'post_thumbnail_html', 'hybrid_post_thumbnail_html', 5 );
    remove_filter( 'comments_popup_link_attributes', 'hybrid_comments_popup_link_attributes', 5 );
}
add_action('after_setup_theme', 'apex_remove_hybrid_filters');

// turn off cleaner gallery if Jetpack gallery functions being used
function ct_apex_remove_cleaner_gallery() {

	if( class_exists( 'Jetpack' ) && ( Jetpack::is_module_active( 'carousel' ) || Jetpack::is_module_active( 'tiled-gallery' ) ) ) {
		remove_theme_support( 'cleaner-gallery' );
	}
}
add_action( 'after_setup_theme', 'ct_apex_remove_cleaner_gallery', 11 );

// register widget areas
function ct_apex_register_widget_areas(){

    /* register after post content widget area */
    hybrid_register_sidebar( array(
        'name'         => __( 'Primary Sidebar', 'apex' ),
        'id'           => 'primary',
        'description'  => __( 'Widgets in this area will be shown in the sidebar next to the main post content', 'apex' )
    ) );
}
add_action('widgets_init','ct_apex_register_widget_areas');

/* added to customize the comments. Same as default except -> added use of gravatar images for comment authors */
if( ! function_exists( ( 'ct_apex_customize_comments' ) ) ) {
	function ct_apex_customize_comments( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		global $post;
		?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
			<article id="comment-<?php comment_ID(); ?>" class="comment">
				<div class="comment-author">
					<?php
						echo get_avatar( get_comment_author_email(), 48, '', get_comment_author() );
					?>
					<span class="author-name"><?php comment_author_link(); ?></span>
				</div>
				<div class="comment-content">
					<?php if ( $comment->comment_approved == '0' ) : ?>
						<em><?php _e( 'Your comment is awaiting moderation.', 'apex' ) ?></em>
						<br/>
					<?php endif; ?>
					<?php comment_text(); ?>
				</div>
				<div class="comment-footer">
					<span class="comment-date"><?php comment_date(); ?></span>
					<?php comment_reply_link( array_merge( $args, array(
						'reply_text' => __( 'Reply', 'apex' ),
						'depth'      => $depth,
						'max_depth'  => $args['max_depth']
					) ) ); ?>
					<?php edit_comment_link( __('Edit', 'apex' ) ); ?>
				</div>
			</article>
	<?php
	}
}

/* added HTML5 placeholders for each default field and aria-required to required */
if( ! function_exists( 'apex_update_fields' ) ) {
    function apex_update_fields( $fields ) {

        // get commenter object
        $commenter = wp_get_current_commenter();

        // are name and email required?
        $req = get_option( 'require_name_email' );

        // required or optional label to be added
        if ( $req == 1 ) {
            $label = '*';
        } else {
            $label = ' ' . __("optional", "apex");
        }

        // adds aria required tag if required
        $aria_req = ( $req ? " aria-required='true'" : '' );

        $fields['author'] =
            '<p class="comment-form-author">
	            <label>' . __( "Name", "apex" ) . $label . '</label>
	            <input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
            '" size="30" ' . $aria_req . ' />
	        </p>';

        $fields['email'] =
            '<p class="comment-form-email">
	            <label>' . __( "Email", "apex" ) . $label . '</label>
	            <input id="email" name="email" type="email" value="' . esc_attr( $commenter['comment_author_email'] ) .
            '" size="30" ' . $aria_req . ' />
	        </p>';

        $fields['url'] =
            '<p class="comment-form-url">
	            <label>' . __( "Website", "apex" ) . '</label>
	            <input id="url" name="url" type="url" value="' . esc_attr( $commenter['comment_author_url'] ) .
            '" size="30" />
	            </p>';

        return $fields;
    }
}
add_filter('comment_form_default_fields','apex_update_fields');

if( ! function_exists( 'apex_update_comment_field' ) ) {
    function apex_update_comment_field( $comment_field ) {

        $comment_field =
            '<p class="comment-form-comment">
	            <label>' . __( "Comment", "apex" ) . '</label>
	            <textarea required id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea>
	        </p>';

        return $comment_field;
    }
}
add_filter('comment_form_field_comment','apex_update_comment_field');

// remove allowed tags text after comment form
if( ! function_exists( 'ct_apex_remove_comments_notes_after' ) ) {
	function ct_apex_remove_comments_notes_after( $defaults ) {

		$defaults['comment_notes_after'] = '';

		return $defaults;
	}
}
add_action('comment_form_defaults', 'ct_apex_remove_comments_notes_after');

// excerpt handling
if( ! function_exists( 'ct_apex_excerpt' ) ) {
	function ct_apex_excerpt() {

		// make post variable available
		global $post;

		// check for the more tag
		$ismore = strpos( $post->post_content, '<!--more-->' );

		// get the show full post setting
		$show_full_post = get_theme_mod( 'full_post' );

		// if show full post is on and not on a search results page
		if ( ( $show_full_post == 'yes' ) && ! is_search() ) {

			// use the read more link if present
			if ( $ismore ) {
				the_content( __( 'Continue reading', 'apex' ) . " <span class='screen-reader-text'>" . get_the_title() . "</span>" );
			} else {
				the_content();
			}
		} // use the read more link if present
		elseif ( $ismore ) {
			the_content( __( 'Continue reading', 'apex' ) . " <span class='screen-reader-text'>" . get_the_title() . "</span>" );
		} // otherwise the excerpt is automatic, so output it
		else {
			the_excerpt();
		}
	}
}

// filter the link on excerpts
if( ! function_exists( 'ct_apex_excerpt_read_more_link' ) ) {
	function ct_apex_excerpt_read_more_link( $output ) {
		global $post;

		return $output . "<p><a class='more-link' href='" . get_permalink() . "'>" . __( 'Continue reading', 'apex' ) . " <span class='screen-reader-text'>" . get_the_title() . "</span></a></p>";
	}
}
add_filter('the_excerpt', 'ct_apex_excerpt_read_more_link');

// change the length of the excerpts
if( ! function_exists( 'apex_custom_excerpt_length' ) ) {
	function apex_custom_excerpt_length( $length ) {

		$new_excerpt_length = get_theme_mod('excerpt_length');

		// if there is a new length set and it's not 15, change it
		if( ! empty( $new_excerpt_length ) && $new_excerpt_length != 25 ){
			return $new_excerpt_length;
		} else {
			return 25;
		}
	}
}
add_filter( 'excerpt_length', 'apex_custom_excerpt_length', 99 );

// switch [...] to ellipsis on automatic excerpt
if( ! function_exists( 'ct_apex_new_excerpt_more' ) ) {
	function ct_apex_new_excerpt_more( $more ) {
		return '&#8230;';
	}
}
add_filter('excerpt_more', 'ct_apex_new_excerpt_more');

// turns of the automatic scrolling to the read more link
if( ! function_exists( 'ct_apex_remove_more_link_scroll' ) ) {
	function ct_apex_remove_more_link_scroll( $link ) {
		$link = preg_replace( '|#more-[0-9]+|', '', $link );

		return $link;
	}
}
add_filter( 'the_content_more_link', 'ct_apex_remove_more_link_scroll' );

// for displaying featured images
if( ! function_exists( 'ct_apex_featured_image' ) ) {
	function ct_apex_featured_image() {

		// get post object
		global $post;

		// default to no featured image
		$has_image = false;

		// establish featured image var
		$featured_image = '';

		// if post has an image
		if ( has_post_thumbnail( $post->ID ) ) {

			// get the featured image ID
			$image_id = get_post_thumbnail_id( $post->ID );

			// get the image's alt text
			$image_alt_text = get_post_meta($image_id, '_wp_attachment_image_alt', true);

			// get the full-size version of the image
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );

			// set $image = the url
			$image     = $image[0];

			// if alt text is empty, nothing else equal to title string
			$title = empty($image_alt_text) ? '' : "title='$image_alt_text'";

			// set to true
			$has_image = true;
		}
		if ( $has_image == true ) {

			// on posts/pages display the featured image
			if ( is_singular() ) {
				$featured_image = "<div class='featured-image' style=\"background-image: url('" . $image . "')\" $title></div>";
			} // on blog/archives display with a link
			else {
				$featured_image = "
                <div class='featured-image' style=\"background-image: url('" . $image . "')\" $title>
                    <a href='" . get_permalink() . "'>" . get_the_title() . "</a>
                </div>
                ";
			}
		}

		// allow videos to be added
		$featured_image = apply_filters( 'ct_apex_featured_image', $featured_image );

		if( $featured_image ) {
			echo $featured_image;
		}
	}
}

// fix for bug with Disqus saying comments are closed
if ( function_exists( 'dsq_options' ) ) {
    remove_filter( 'comments_template', 'dsq_comments_template' );
    add_filter( 'comments_template', 'dsq_comments_template', 99 ); // You can use any priority higher than '10'
}

// associative array of social media sites
function ct_apex_social_array() {

	$social_sites = array(
		'twitter'       => 'apex_twitter_profile',
		'facebook'      => 'apex_facebook_profile',
		'google-plus'   => 'apex_googleplus_profile',
		'pinterest'     => 'apex_pinterest_profile',
		'linkedin'      => 'apex_linkedin_profile',
		'youtube'       => 'apex_youtube_profile',
		'vimeo'         => 'apex_vimeo_profile',
		'tumblr'        => 'apex_tumblr_profile',
		'instagram'     => 'apex_instagram_profile',
		'flickr'        => 'apex_flickr_profile',
		'dribbble'      => 'apex_dribbble_profile',
		'rss'           => 'apex_rss_profile',
		'reddit'        => 'apex_reddit_profile',
		'soundcloud'    => 'apex_soundcloud_profile',
		'spotify'       => 'apex_spotify_profile',
		'vine'          => 'apex_vine_profile',
		'yahoo'         => 'apex_yahoo_profile',
		'behance'       => 'apex_behance_profile',
		'codepen'       => 'apex_codepen_profile',
		'delicious'     => 'apex_delicious_profile',
		'stumbleupon'   => 'apex_stumbleupon_profile',
		'deviantart'    => 'apex_deviantart_profile',
		'digg'          => 'apex_digg_profile',
		'git'           => 'apex_git_profile',
		'hacker-news'   => 'apex_hacker-news_profile',
		'steam'         => 'apex_steam_profile',
		'vk'            => 'apex_vk_profile',
		'weibo'         => 'apex_weibo_profile',
		'tencent-weibo' => 'apex_tencent_weibo_profile',
		'email'         => 'apex_email_profile'
	);

	return $social_sites;
}

// used in ct_apex_social_icons_output to return urls
function ct_apex_get_social_url($source, $site){

    if( $source == 'header' ) {
        return get_theme_mod($site);
    } elseif( $source == 'author' ) {
        return get_the_author_meta($site);
    }
}

// output social icons
if( ! function_exists('ct_apex_social_icons_output') ) {
    function ct_apex_social_icons_output($source) {

        // get social sites array
        $social_sites = ct_apex_social_array();

        // store the site name and url
        foreach ( $social_sites as $social_site => $profile ) {

            if( $source == 'header') {

                if ( strlen( get_theme_mod( $social_site ) ) > 0 ) {
                    $active_sites[$social_site] = $social_site;
                }
            }
            elseif( $source == 'author' ) {

                if ( strlen( get_the_author_meta( $profile ) ) > 0 ) {
                    $active_sites[$profile] = $social_site;
                }
            }
        }

        // for each active social site, add it as a list item
        if ( ! empty( $active_sites ) ) {

            echo "<ul class='social-media-icons'>";

            foreach ( $active_sites as $key => $active_site ) {

                if ( $active_site == 'email' ) {
                    ?>
                    <li>
                        <a class="email" target="_blank" href="mailto:<?php echo antispambot( is_email( ct_apex_get_social_url( $source, $key ) ) ); ?>">
                            <i class="fa fa-envelope" title="<?php _e('email icon', 'apex'); ?>"></i>
                        </a>
                    </li>
                <?php } else { ?>
                    <li>
                        <a class="<?php echo $active_site; ?>" target="_blank" href="<?php echo esc_url( ct_apex_get_social_url( $source, $key ) ); ?>">
                            <i class="fa fa-<?php echo esc_attr( $active_site ); ?>" title="<?php printf( __('%s icon', 'apex'), $active_site ); ?>"></i>
                        </a>
                    </li>
                <?php
                }
            }
            echo "</ul>";
        }
    }
}

/*
 * WP will apply the ".menu-primary-items" class & id to the containing <div> instead of <ul>
 * making styling difficult and confusing. Using this wrapper to add a unique class to make styling easier.
 */
function ct_apex_wp_page_menu() {
    wp_page_menu(array(
            "menu_class" => "menu-unset",
            "depth"      => -1
        )
    );
}

function ct_apex_wp_backwards_compatibility() {

	// not using this function, simply remove it so use of "has_image_size" doesn't break < 3.9
	if( version_compare( get_bloginfo('version'), '3.9', '<') ) {
		remove_filter( 'image_size_names_choose', 'hybrid_image_size_names_choose' );
	}
}
add_action('init', 'ct_apex_wp_backwards_compatibility');

if ( ! function_exists( '_wp_render_title_tag' ) ) :
    function apex_add_title_tag() {
        ?>
        <title><?php wp_title( ' | ' ); ?></title>
    <?php
    }
    add_action( 'wp_head', 'apex_add_title_tag' );
endif;

function ct_apex_nav_dropdown_buttons( $item_output, $item, $depth, $args ) {

	if ( 'primary' == $args->theme_location) {

		if( in_array('menu-item-has-children', $item->classes ) || in_array('page_item_has_children', $item->classes ) ) {
			$item_output = str_replace( $args->link_after . '</a>', $args->link_after . '</a><button class="toggle-dropdown" aria-expanded="false" name="toggle-dropdown"><span class="screen-reader-text">' . __("open dropdown menu", "apex") . '</span></button>', $item_output );
		}
	}

	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'ct_apex_nav_dropdown_buttons', 10, 4 );

function ct_apex_sticky_post_marker() {

	// sticky_post_status only included in content-archive, so it will only show on the blog
	if( is_sticky() && !is_archive() ) {
		echo '<div class="sticky-status"><span>' . __("Featured Post", "apex") . '</span></div>';
	}
}
add_action( 'sticky_post_status', 'ct_apex_sticky_post_marker' );

function ct_apex_reset_customizer_options() {

	// validate name and value
	if( empty( $_POST['apex_reset_customizer'] ) || 'apex_reset_customizer_settings' !== $_POST['apex_reset_customizer'] )
		return;

	// validate nonce
	if( ! wp_verify_nonce( $_POST['apex_reset_customizer_nonce'], 'apex_reset_customizer_nonce' ) )
		return;

	// validate user permissions
	if( ! current_user_can( 'manage_options' ) )
		return;

	// delete customizer mods
	remove_theme_mods();

	$redirect = admin_url( 'themes.php?page=apex-options' );
	$redirect = add_query_arg( 'apex_status', 'deleted', $redirect );

	// safely redirect
	wp_safe_redirect( $redirect ); exit;
}
add_action( 'admin_init', 'ct_apex_reset_customizer_options' );

function ct_apex_delete_settings_notice() {

	if ( isset( $_GET['apex_status'] ) ) {
		?>
		<div class="updated">
			<p><?php _e( 'Customizer settings deleted', 'apex' ); ?>.</p>
		</div>
	<?php
	}
}
add_action( 'admin_notices', 'ct_apex_delete_settings_notice' );

function ct_apex_body_class( $classes ) {

	/* get full post setting */
	$full_post = get_theme_mod('full_post');

	/* if full post setting on */
	if( $full_post == 'yes' ) {
		$classes[] = 'full-post';
	}
	return $classes;
}
add_filter( 'body_class', 'ct_apex_body_class' );

function ct_apex_svg_output($type) {

	$svg = '';

	if( $type == 'toggle-navigation' ) {

		$svg = '<svg width="24px" height="18px" viewBox="0 0 24 18" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
				    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
				        <g transform="translate(-148.000000, -36.000000)" fill="#6B6B6B">
				            <g transform="translate(123.000000, 25.000000)">
				                <g transform="translate(25.000000, 11.000000)">
				                    <rect x="0" y="16" width="24" height="2"></rect>
				                    <rect x="0" y="8" width="24" height="2"></rect>
				                    <rect x="0" y="0" width="24" height="2"></rect>
				                </g>
				            </g>
				        </g>
				    </g>
				</svg>';
	}

	return $svg;
}

// custom css output
function ct_apex_custom_css_output(){

	$custom_css = get_theme_mod('custom_css');

	/* output custom css */
	if( $custom_css ) {
		wp_add_inline_style( 'ct-apex-style', $custom_css );
		wp_add_inline_style( 'ct-apex-style-rtl', $custom_css );
	}
}
add_action('wp_enqueue_scripts', 'ct_apex_custom_css_output', 20);