( function( $ ) {
    'use strict';

    $( function() {

        $('.houzez-clone').cloneya();

        $( '.houzez-fbuilder-js-on-change' ).change( function() {
            var field_type = $( this ).val();
            $('.houzez-clone').cloneya();

            if(field_type == 'select' || field_type == 'multiselect' ) {
                $.post( ajaxurl, { action: 'houzez_load_select_options', type: field_type }, function( response ) {
                    $( '.houzez_select_options_loader_js' ).html( response );
                    $('.houzez-clone').cloneya();
                } );

            } else if(field_type == 'checkbox_list' || field_type == 'radio' ) {
                $( '.houzez_multi_line_js' ).show();
                $( '.houzez_select_options_loader_js' ).html('');

            } else {
                $( '.houzez_select_options_loader_js' ).html('');
                $( '.houzez_multi_line_js' ).hide();
            }
        } );

        $(window).on('load', function() {
            var current_option = $('.houzez-fbuilder-js-on-change').attr('value');

            if( current_option == 'checkbox_list' || current_option == 'radio' ) {
                $( '.houzez_multi_line_js' ).show();
            }
        });


    } );

    function HouzezStringToSlug( str ) {
        // Trim the string
        str = str.replace( /^\s+|\s+$/g, '' );
        str = str.toLowerCase();

        // Remove accents
        var from = "àáäâèéëêìíïîòóöôùúüûñç·/_,:;",
            to = "aaaaeeeeiiiioooouuuunc------",
            i, l;

        for ( i = 0, l = from.length; i < l; i ++ ) {
            str = str.replace( new RegExp( from.charAt( i ), 'g' ), to.charAt( i ) );
        }

        str = str.replace( /[^a-z0-9 -]/g, '' ) // remove invalid chars
                  .replace( /\s+/g, '-' ) // collapse whitespace and replace by -
                  .replace( /-+/g, '-' ); // collapse dashes

        return str;
    }



} )( jQuery );