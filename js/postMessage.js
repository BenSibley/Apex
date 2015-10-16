( function( $ ) {

    /*
     * Following functions are for utilizing the postMessage transport setting
     */

    var panel = $('html', window.parent.document);
    var body = $('body');
    var siteTitle = $('#site-title');
    var tagline = $( '.tagline' );
    var inlineStyles = $('#ct-founder-style-inline-css');

    // Site title
    wp.customize( 'blogname', function( value ) {
        value.bind( function( to ) {
            // if there is a logo, don't replace it
            if( $('.site-title').find('img').length == 0 ) {
                $( '.site-title a' ).text( to );
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

} )( jQuery );