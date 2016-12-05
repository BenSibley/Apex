( function( $ ) {

    /*
     * Following functions are for utilizing the postMessage transport setting
     */

    var panel = $('html', window.parent.document);
    var body = $('body');
    var siteTitle = $('#site-title');
    var tagline = $( '.tagline' );
    var inlineStyles = $('#ct-apex-style-inline-css');

    // Site title
    wp.customize( 'blogname', function( value ) {
        value.bind( function( to ) {
            // if there is a logo, don't replace it
            if( siteTitle.find('img').length == 0 ) {
                siteTitle.children('a').text( to );
            }
        } );
    } );

    // Tagline
    wp.customize( 'blogdescription', function( value ) {
        value.bind( function( to ) {
            var tagline = $('.tagline');
            if( tagline.length == 0 ) {
                $('#title-container').append('<p class="tagline"></p>');
            }
            tagline.text( to );
        } );
    } );

    // Logo
    wp.customize( 'logo_upload', function( value ) {
        value.bind( function( to ) {
            var link = siteTitle.children('a');
            if ( to != '' ) {
                link.html('<img class="logo" src="' + to + '" />');
            } else {
                link.html( panel.find('#customize-control-blogname').find('input').val() );
            }
        } );
    } );

    // Custom CSS

    // get current Custom CSS
    var customCSS = panel.find('#customize-control-custom_css').find('textarea').val();

    // get the CSS in the inline element
    var allCSS = inlineStyles.text();

    // remove the Custom CSS from the other CSS
    allCSS = allCSS.replace(customCSS, '');

    // update the CSS in the inline element w/o the custom css
    inlineStyles.text(allCSS);

    // add custom CSS to its own style element
    body.append('<style id="style-inline-custom-css" type="text/css">' + customCSS + '</style>');

    var setting = 'custom_css';
    if ( panel.find('#sub-accordion-section-custom_css').length ) {
        setting = 'custom_css[apex]';
    }
    // Custom CSS
    wp.customize( setting, function( value ) {
        value.bind( function( to ) {
            $('#style-inline-custom-css').remove();
            if ( to != '' ) {
                to = '<style id="style-inline-custom-css" type="text/css">' + to + '</style>';
                body.append( to );
            }
        } );
    } );

    // Social Media Icons

    // get all controls for social sites
    var socialSites = panel.find('#sub-accordion-section-ct_apex_social_media_icons').find('.customize-control-title');
    var WPVersion = 4.7;
    if ( socialSites.length == false ) {
        socialSites = panel.find('#accordion-section-ct_apex_social_media_icons').find('.customize-control-title');
        WPVersion = 4.6;
    }

    // instantiate array
    var socialSitesArray = [];

    // icons that should use a special square icon
    var squareIcons = ['linkedin', 'twitter', 'vimeo', 'youtube', 'pinterest', 'rss', 'reddit', 'tumblr', 'steam', 'xing', 'github', 'google-plus', 'behance', 'facebook'];

    // create array from social site controls
    socialSites.each( function() {
        socialSitesArray.push( $(this).text() );
    });

    // for each social site
    $.each( socialSitesArray, function(index, name) {

        // replace spaces with hyphens, and convert to lowercase
        var site = name.replace(/\s+/g, '-').toLowerCase();

        // convert email-address to email
        if ( site === 'email-address') site = 'email';
        if ( site === 'contact-form') site = 'email-form';

        // when a social site value is updated
        wp.customize( site, function (value) {
            value.bind(function (to) {

                // relocate the social media icons list
                var socialMediaIcons = $('.social-media-icons');

                // if it doesn't exist, add it
                if( !socialMediaIcons.length ) {
                    $('#menu-primary-container').append('<ul class="social-media-icons"></ul>');
                    var socialMediaIcons = $('.social-media-icons');
                }

                // empty the social icons list
                socialMediaIcons.empty();

                // replace all at once to preserve order
                var selector = panel.find('#sub-accordion-section-ct_apex_social_media_icons').find('input');
                if ( WPVersion != 4.7 ) {
                    selector = panel.find('#accordion-section-ct_apex_social_media_icons').find('input')
                }
                selector.each(function() {

                    // if the icon has a URL
                    if( $(this).val().length > 0 ) {

                        // get the name of the site
                        var siteName = $(this).attr('data-customize-setting-link');

                        // get class based on presence in squareicons list
                        if ( $.inArray( siteName, squareIcons ) > -1 ) {
                            var siteClass = 'fa fa-' + siteName + '-square';
                        } else {
                            var siteClass = 'fa fa-' + siteName;
                        }
                        if ( siteName == 'email-form' ) {
                            siteClass = 'fa fa-envelope-o';
                        }

                        // output the content for the icon
                        if( siteName == 'email' ) {
                            socialMediaIcons.append( '<li><a target="_blank" href="mailto:' + $(this).val() + '"><i class="fa fa-envelope"></i></a></li>' );
                        }
                        else {
                            socialMediaIcons.append('<li><a class="' + siteName + '" target="_blank" href="' + $(this).val() + '"><i class="' + siteClass + '"></i></a></li>');
                        }
                    }
                });
            });
        });
    });

} )( jQuery );