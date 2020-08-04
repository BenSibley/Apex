jQuery(document).ready(function($){

    var body = $('body');
    var main = $('#main');
    var siteHeader = $('#site-header');
    var titleContainer = $('#title-container');
    var toggleNavigation = $('#toggle-navigation');
    var menuPrimaryContainer = $('#menu-primary-container');
    var menuPrimary = $('#menu-primary');
    var menuPrimaryItems = $('#menu-primary-items');
    var toggleDropdown = $('.toggle-dropdown');
    var socialMediaIcons = siteHeader.find('.social-media-icons');
    var menuLink = $('.menu-item').children('a');

    removeToggleDropdownKeyboard();
    objectFitAdjustment();

    toggleNavigation.on('click', openPrimaryMenu);
    toggleDropdown.on('click', openDropdownMenu);
    body.on('click', '#search-icon', openSearchBar);

    $(window).on( 'resize', function(){
        removeToggleDropdownKeyboard();
        objectFitAdjustment();
    });

    $('.post-content').fitVids({
        customSelector: 'iframe[src*="dailymotion.com"], iframe[src*="slideshare.net"], iframe[src*="animoto.com"], iframe[src*="blip.tv"], iframe[src*="funnyordie.com"], iframe[src*="hulu.com"], iframe[src*="ted.com"], iframe[src*="wordpress.tv"]'
    });

    // Jetpack infinite scroll event that reloads posts.
    $( document.body ).on( 'post-load', function () {
        objectFitAdjustment();
    } );

    function openPrimaryMenu() {

        if( menuPrimaryContainer.hasClass('open') ) {
            menuPrimaryContainer.removeClass('open');
            $(this).removeClass('open');

            menuPrimaryContainer.css('max-height', '');

            // scroll back up
            $('html, body').animate({scrollTop: '0'}, 200);

            // change screen reader text
            $(this).children('span').text(ct_apex_objectL10n.openMenu);

            // change aria text
            $(this).attr('aria-expanded', 'false');

        } else {
            menuPrimaryContainer.addClass('open');
            $(this).addClass('open');

            var menuHeight = menuPrimary.outerHeight(true) + socialMediaIcons.outerHeight();

            menuPrimaryContainer.css('max-height', menuHeight);

            // change screen reader text
            $(this).children('span').text(ct_apex_objectL10n.closeMenu);

            // change aria text
            $(this).attr('aria-expanded', 'true');
        }
    }

    // display the dropdown menus
    function openDropdownMenu() {
        
        // get the buttons parent (li)
        var menuItem = $(this).parent();

        // if already opened
        if (menuItem.hasClass('open')) {

            // remove open class
            menuItem.removeClass('open');

            $(this).siblings('ul').css('max-height', 0);

            // change screen reader text
            $(this).children('span').text(ct_apex_objectL10n.openChildMenu);

            // change aria text
            $(this).attr('aria-expanded', 'false');
        } else {

            // add class to open the menu
            menuItem.addClass('open');

            var ulHeight = 0;

            $(this).siblings('ul').find('li').each(function () {
                ulHeight = ulHeight + $(this).height() + ( $(this).height() * 1.5 );
            });

            $(this).siblings('ul').css('max-height', ulHeight);

            // expand entire menu for dropdowns
            // doesn't need to be precise. Just needs to allow the menu to get taller
            menuPrimaryContainer.css('max-height', 9999);

            // change screen reader text
            $(this).children('span').text(ct_apex_objectL10n.closeChildMenu);

            // change aria text
            $(this).attr('aria-expanded', 'true');
        }
    }

    function removeToggleDropdownKeyboard() {

        if( window.innerWidth > 799 ) {
            toggleDropdown.attr('tabindex', -1);
        } else {
            toggleDropdown.attr('tabindex', '');
        }
    }

    /* allow keyboard access/visibility for dropdown menu items */
    menuLink.on('focus', function(){
        $(this).parents('ul').addClass('focused');
    });
    menuLink.on( 'focusout', function(){
        $(this).parents('ul').removeClass('focused');
    });

    // mimic cover positioning without using cover
    function objectFitAdjustment() {

        // if the object-fit property is not supported
        if( !('object-fit' in document.body.style) ) {

            $('.featured-image').each(function () {

                if ( !$(this).parent().parent('.entry').hasClass('ratio-natural') ) {

                    var image = $(this).children('img').add($(this).children('a').children('img'));

                    // don't process images twice (relevant when using infinite scroll)
                    if ( image.hasClass('no-object-fit') ) {
                        return;
                    }

                    image.addClass('no-object-fit');

                    // if the image is not wide enough to fill the space
                    if (image.outerWidth() < $(this).outerWidth()) {

                        image.css({
                            'width': '100%',
                            'min-width': '100%',
                            'max-width': '100%',
                            'height': 'auto',
                            'min-height': '100%',
                            'max-height': 'none'
                        });
                    }
                    // if the image is not tall enough to fill the space
                    if (image.outerHeight() < $(this).outerHeight()) {

                        image.css({
                            'height': '100%',
                            'min-height': '100%',
                            'max-height': '100%',
                            'width': 'auto',
                            'min-width': '100%',
                            'max-width': 'none'
                        });
                    }
                }
            });
        }
    }

    function openSearchBar(){

        if( $(this).hasClass('open') ) {

            $(this).removeClass('open');
            socialMediaIcons.removeClass('fade');

            // make search input inaccessible to keyboards
            siteHeader.find('.search-field').attr('tabindex', -1);

            // handle mobile width search bar sizing
            if( window.innerWidth < 900 ) {
                siteHeader.find('.search-form').attr('style', '');
            }
        } else {

            $(this).addClass('open');
            socialMediaIcons.addClass('fade');

            // make search input keyboard accessible
            siteHeader.find('.search-field').attr('tabindex', 0);

            // handle mobile width search bar sizing
            if( window.innerWidth < 800 ) {

                // distance to other side (35px is width of icon space)
                var leftDistance = window.innerWidth * 0.83332 - 35;

                siteHeader.find('.search-form').css('left', -leftDistance + 'px')
            }
        }
    }

    // ===== Scroll to Top ==== //

    if ( $('#scroll-to-top').length !== 0 ) {
        $(window).on( 'scroll', function() {
            if ($(this).scrollTop() >= 200) {        // If page is scrolled more than 50px
                $('#scroll-to-top').addClass('visible');    // Fade in the arrow
            } else {
                $('#scroll-to-top').removeClass('visible');   // Else fade out the arrow
            }
        });
        $('#scroll-to-top').click(function(e) {      // When arrow is clicked
            $('body,html').animate({
                scrollTop : 0                       // Scroll to top of body
            }, 600);
            $(this).blur();
        });
    }
});

/* fix for skip-to-content link bug in Chrome & IE9 */
window.addEventListener("hashchange", function(event) {

    var element = document.getElementById(location.hash.substring(1));

    if (element) {

        if (!/^(?:a|select|input|button|textarea)$/i.test(element.tagName)) {
            element.tabIndex = -1;
        }

        element.focus();
    }

}, false);