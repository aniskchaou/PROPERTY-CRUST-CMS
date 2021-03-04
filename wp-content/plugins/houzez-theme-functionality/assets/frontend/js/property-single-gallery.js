( function( $ ) {
    'use strict';

    
    window.houzezSingleTopGalleryElementor = function(galleryID) {

        var houzez_rtl = houzez_vars.houzez_rtl;

        if( houzez_rtl == 'yes' ) {
            houzez_rtl = true;
        } else {
            houzez_rtl = false;
        }

        jQuery('#'+galleryID).lightSlider({
            rtl: houzez_rtl,
            gallery:true,
            item:1,
            thumbItem:8,
            slideMargin: 0,
            speed:500,
            adaptiveHeight: true,
            auto:false,
            loop:true,
            prevHtml: '<button type="button" class="slick-prev slick-arrow"></button>',
            nextHtml: '<button type="button" class="slick-next slick-arrow"></button>',
            onSliderLoad: function() {
                jQuery('#'+galleryID).removeClass('cS-hidden');
            }  
        });
        
    }
    


} )( jQuery );