/*
 Theme Name: houzez
 Description: houzez
 Author: Favethemes
 Version: 1.0
 */
(function ($) {
    "use strict";

    /* ------------------------------------------------------------------------ */
    /*  global variables
    /* ------------------------------------------------------------------------ */
    var $win = $(window);
    var popupSliderLoaded = false;
    var houzezStickyTop = 0;
    var adminBarHeight = 0;
    var ajaxurl = houzez_vars.admin_url+ 'admin-ajax.php';
    var compare_url = houzez_vars.compare_url;
    var houzez_rtl = houzez_vars.houzez_rtl;
    var userID = houzez_vars.user_id;
    var wp_is_mobile = houzez_vars.wp_is_mobile;
    var houzez_is_splash = houzez_vars.houzez_is_splash;
    var prop_detail_nav = houzez_vars.prop_detail_nav;
    var search_position = houzez_vars.search_position;
    var is_singular_property = houzez_vars.is_singular_property;
    var transparent_logo = houzez_vars.transparent_logo;
    var is_transparent = houzez_vars.is_transparent;
    var is_top_header = houzez_vars.is_top_header;
    var houzez_date_language = houzez_vars.houzez_date_language;
    var compare_add_icon = houzez_vars.compare_add_icon;
    var add_compare_text = houzez_vars.add_compare_text;
    var compare_remove_icon = houzez_vars.compare_remove_icon;
    var remove_compare_text = houzez_vars.remove_compare_text;
    var compare_limit = houzez_vars.compare_limit;
    var compare_page_not_found = houzez_vars.compare_page_not_found;
    var g_recaptha_version = houzez_vars.g_recaptha_version;
    var for_rent = houzez_vars.for_rent;
    var for_rent_price_slider = houzez_vars.for_rent_price_slider;
    var search_price_range_min = parseInt( houzez_vars.search_min_price_range );
    var search_price_range_max = parseInt( houzez_vars.search_max_price_range );
    var search_price_range_min_rent = parseInt( houzez_vars.search_min_price_range_for_rent );
    var search_price_range_max_rent = parseInt( houzez_vars.search_max_price_range_for_rent );
    var get_min_price = parseInt( houzez_vars.get_min_price );
    var get_max_price = parseInt( houzez_vars.get_max_price );
    var currency_position = houzez_vars.currency_position;
    var decimals = houzez_vars.decimals;
    var decimal_point_separator = houzez_vars.decimal_point_separator;
    var thousands_separator = houzez_vars.thousands_separator;
    var currency_symb = houzez_vars.currency_symbol;
    var is_halfmap = parseInt(houzez_vars.is_halfmap);
    var houzez_reCaptcha = parseInt(houzez_vars.houzez_reCaptcha);
    var prev_text = houzez_vars.prev_text
    var next_text = houzez_vars.next_text
    var keyword_search_field = houzez_vars.keyword_search_field;
    var keyword_autocomplete = houzez_vars.keyword_autocomplete;
    var autosearch_text = houzez_vars.autosearch_text;
    var login_redirect_type = houzez_vars.redirect_type
    var login_redirect = houzez_vars.login_redirect
    var login_loading = houzez_vars.login_loading
    var paypal_connecting = houzez_vars.paypal_connecting;
    var processing_text = houzez_vars.processing_text;
    var is_edit_property = houzez_vars.is_edit_property;

    var simple_logo = houzez_vars.simple_logo;
    var retina_logo = houzez_vars.retina_logo;
    var mobile_logo = houzez_vars.mobile_logo;
    var retina_logo_mobile = houzez_vars.retina_logo_mobile;
    var retina_logo_mobile_splash = houzez_vars.retina_logo_mobile_splash;
    var custom_logo_splash = houzez_vars.custom_logo_splash;
    var retina_logo_splash = houzez_vars.retina_logo_splash;
    var calDoughnutChart;
    var is_listing_gallery_slider = false;

    var top_banner_wrap_height = 0;
    var top_banner_wrap  = $('.top-banner-wrap ');

    var header_area = $('.header-main-wrap');
    var advanced_search_nav = $('.advanced-search-nav');
    var desktop_header_search_enabled = advanced_search_nav.data('sticky');

    var elementor_location_header = $('.elementor-location-header');
    var header_area_height = header_area.innerHeight();
    var elementor_location_header_height = elementor_location_header.innerHeight();
    var advanced_search_nav_height = advanced_search_nav.innerHeight();

    var header_nav = $('#header-section');
    var houzez_nav_sticky_height = header_nav.innerHeight();
    var only_nav_sticky = header_nav.data('sticky');
    
    var houzez_is_mobile = /ipad|iphone|ipod|android|blackberry|webos|iemobile|windows phone/i.test(navigator.userAgent.toLowerCase());

    if( prop_detail_nav == 'yes' && is_singular_property) {
        only_nav_sticky = 0;
    }

    if(elementor_location_header_height == null) {
        elementor_location_header_height = 0;
    }

    if(header_area_height == null) {
        header_area_height = 0;
    }

    if(advanced_search_nav_height == null) {
        advanced_search_nav_height = 0;
    }

    if( houzez_rtl == 'yes' ) {
        houzez_rtl = true;
    } else {
        houzez_rtl = false;
    }

    if(only_nav_sticky === 1) {
        houzezStickyTop = houzez_nav_sticky_height;
        if( !wp_is_mobile ) {
            desktop_header_search_enabled = 0;
        }
    }

    var make_search_sticky_position = header_area_height + advanced_search_nav_height;
    var searchStickyPlus = 100;
    var search_under_navigation = true;
    if( wp_is_mobile ) {
        make_search_sticky_position = make_search_sticky_position + 40;
    } 

    $(document).ready(function() {
       top_banner_wrap_height  = top_banner_wrap.innerHeight();

       if(search_position == 'under_banner') {
            make_search_sticky_position = header_area_height + top_banner_wrap_height;
            searchStickyPlus = 0;
            if( wp_is_mobile ) {
                searchStickyPlus = 60;
            }
            if( is_transparent ) {
                searchStickyPlus = 60;
            }
            search_under_navigation = false;
        }

       adminBarHeight = $('#wpadminbar').innerHeight();
       if(adminBarHeight != null) {
            houzezStickyTop = houzezStickyTop + adminBarHeight;
       }

    });


    /* ------------------------------------------------------------------------ */
    /*  lazy load
    /* ------------------------------------------------------------------------ */
    document.addEventListener("DOMContentLoaded", function() {
      var lazyImages = [].slice.call(document.querySelectorAll(".houzez-lazyload"));

      if ("IntersectionObserver" in window) {
        let lazyImageObserver = new IntersectionObserver(function(entries, observer) {
          entries.forEach(function(entry) {
            if (entry.isIntersecting) {
              let lazyImage = entry.target;
              lazyImage.src = lazyImage.dataset.src;
              if(lazyImage.dataset.srcset) {
                  lazyImage.srcset = lazyImage.dataset.srcset;
              }
              lazyImage.classList.remove("houzez-lazyload");
              lazyImageObserver.unobserve(lazyImage);
            }
          });
        });

        lazyImages.forEach(function(lazyImage) {
          lazyImageObserver.observe(lazyImage);
        });
      } else {
        // Possibly fall back to a more compatible method here
      }
    });

    
    /* ------------------------------------------------------------------------ */
    /*  Retina logo
    /* ------------------------------------------------------------------------ */
    if ( retina_logo !== '' || retina_logo_splash != '' || retina_logo_mobile != '' || retina_logo_mobile_splash != '' ) { 
        if (window.devicePixelRatio == 2) {

            if( retina_logo != '' ) {
                $(".logo-desktop img").attr("src", retina_logo);
            }

            if( retina_logo_splash != '' ) {
                $(".logo-splash img").attr("src", retina_logo_splash);
            } 

            if( retina_logo_mobile != '' ) {
                $(".logo-mobile img").attr("src", retina_logo_mobile);
            } 
        }
    }


    $('.all-reviews').on('click', function(e) { 
        $('.hz-review-tab').trigger('click');
    });

    /* ------------------------------------------------------------------------ */
    /*  Listing item gallery
    /* ------------------------------------------------------------------------ */

    /*$('.hz-item-gallery-js').on('mouseenter', function() {

        if ( !$(this).hasClass('houzez-gallery-loaded') && $(this).data('images') ) {
            var $this = $(this);
            var href = $(this).find('a.listing-featured-thumb').attr('href')
            var images = $(this).data('images');

            var html = '<div class="listing-gallery-wrap"><div class="houzez-listing-carousel">';
            images.forEach(function(img_url, index){
                html += '<div class="item"><a href="'+ href +'"><img src="'+img_url+'" class="img-fluid"></a></div>';
            });
            html += '</div></div>';
            $(this).find('.listing-image-wrap .listing-thumb').append(html);

            var listing_slider = $this.find('.houzez-listing-carousel');

            listing_slider.slick({
                rtl: houzez_rtl,
                autoplay: false,
                lazyLoad: 'ondemand',
                infinite: false,
                speed: 300,
                slidesToShow: 1,
                arrows: true,
                prevArrow: '<button type="button" class="slick-prev slick-arrow"></button>',
                nextArrow: '<button type="button" class="slick-next slick-arrow"></button>',
                adaptiveHeight: false
            });

            is_listing_gallery_slider = true;
            
            $(this).addClass('houzez-gallery-loaded');
        }

    });*/

    /*$(window).on('load', function() {

        $('.hz-item-gallery-js').each( function() {

            if ( !$(this).hasClass('houzez-gallery-loaded') && $(this).data('images') ) {
                var $this = $(this);
                var href = $(this).find('a.listing-featured-thumb').attr('href')
                var images = $(this).data('images');

                var html = '<div class="listing-gallery-wrap"><div class="houzez-listing-carousel">';
                images.forEach(function(img_url, index){
                    html += '<div class="item"><a href="'+ href +'"><img src="'+img_url+'" class="img-fluid"></a></div>';
                });
                html += '</div></div>';
                $(this).find('.listing-image-wrap .listing-thumb').append(html);

                var listing_slider = $this.find('.houzez-listing-carousel');

                listing_slider.slick({
                    rtl: houzez_rtl,
                    autoplay: false,
                    lazyLoad: 'ondemand',
                    infinite: false,
                    speed: 300,
                    slidesToShow: 1,
                    arrows: true,
                    prevArrow: '<button type="button" class="slick-prev slick-arrow"></button>',
                    nextArrow: '<button type="button" class="slick-next slick-arrow"></button>',
                    adaptiveHeight: false
                });

                is_listing_gallery_slider = true;
                
                $(this).addClass('houzez-gallery-loaded');
            }

        });

    });
    

    $('.switch-btn').on('click', function() {
        if( is_listing_gallery_slider ) {
            $('.houzez-listing-carousel').slick('refresh');
        }
    });*/

    

    /* ------------------------------------------------------------------------ */
    /*  Inifinite Load
    /* ------------------------------------------------------------------------ */
    /*$('.houzez-infinite-load').on('click', function(e) {
        e.preventDefault();

        var $nextPageLink = $('.btn-load-more').attr('href');
        var nextPageUrl = $nextPageLink;

        if (nextPageUrl) {
            window.history.pushState({HouzezTheme: true}, '', nextPageUrl);


            self.filterAjax = $.ajax({
                url: nextPageUrl,
                data: {
                    load_type: 'items'
                },
                dataType: 'html',
                cache: false,
                headers: {'cache-control': 'no-cache'},
                method: 'GET',
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    console.log('Houzez: AJAX error - houzezAjaxPagination() - ' + errorThrown);
                },
                complete: function() {
                    
                },
                success: function(response) {
                    var $response = $('<div>' + response + '</div>'); // Wrap the returned HTML string in a dummy 'div' element we can get the elements
                        

                        console.log($response);
                    // Get the 'next page' URL
                    nextPageUrl = $response.find('.fave-pagination-loadmore').children('a').attr('href');
                    
                    if (nextPageUrl) {
                        $nextPageLink.attr('href', nextPageUrl);
                    } else {
                        
                    }
                    
                    
                }
            });
        }

    });*/


    /* ------------------------------------------------------------------------ */
    /*  STICKY HEADER
    /* ------------------------------------------------------------------------ */
    if (window.devicePixelRatio == 2) {

        if(transparent_logo) {
            if(retina_logo_splash != '') {
                custom_logo_splash = retina_logo_splash;
            }
            if(retina_logo != '') {
                simple_logo = retina_logo;
            }
        } 
    }


    if( only_nav_sticky && !wp_is_mobile ) {
        houzez_sticky_nav();
    }

    function houzez_sticky_nav() {
        $(window).scroll(function() {
            var scroll = $(window).scrollTop();
            var admin_nav = $('#wpadminbar').height();
            var top_banner_margin = 0;
            var thisHeight = header_nav.outerHeight();
            top_banner_margin = thisHeight;

            if(is_top_header) {
                var top_bar_wrap = $('.top-bar-wrap').height();
                top_banner_margin = top_banner_margin + top_bar_wrap;
            }

            if(only_nav_sticky === 0) {
                return;
            }

            if(transparent_logo) {
                $('.logo-splash img').attr('src', simple_logo);
            }

            if( admin_nav == 'null' ) { admin_nav = 0; }

            if (scroll > header_area_height ) { 
                header_nav.addClass('sticky-nav-area');
                header_nav.css('top', admin_nav);
                if(transparent_logo){
                    header_area.removeClass('header-transparent-wrap');
                    $('.top-banner-wrap').css('margin-top', "-"+top_banner_margin+"px");
                    $('body.houzez-header-elementor .content-wrap').css('margin-top', "-"+top_banner_margin+"px");
                }

                if (scroll >= header_area_height + 20 ) { 
                    header_nav.addClass('houzez-in-view');
                    $('#main-wrap').css('margin-top', thisHeight);
                }

            } else { 
                header_nav.removeClass('sticky-nav-area');
                header_nav.removeAttr("style");
                if(transparent_logo){
                    header_area.addClass('header-transparent-wrap');
                    $('.top-banner-wrap').css('margin-top', 0);
                    $('body.houzez-header-elementor .content-wrap').css('margin-top', 0);
                    $('.logo-splash img').attr('src', custom_logo_splash);
                }

                if (scroll <= header_area_height + 20 ) { 
                    header_nav.removeClass('houzez-in-view');
                }
                $('#main-wrap').css('margin-top', 0);
            }
        });
    }

    /* ------------------------------------------------------------------------ */
    /*  STICKY Header Search
    /* ------------------------------------------------------------------------ */
    if( desktop_header_search_enabled ) {
        houzez_sticky_search();
    }

    function houzez_sticky_search() {
        $(window).scroll(function() {
            var scroll = $(window).scrollTop();
            var admin_nav = $('#wpadminbar').height();
            var thisHeight = advanced_search_nav.outerHeight();
            var hidden_data = advanced_search_nav.data('hidden');

            if( admin_nav == 'null' ) { admin_nav = 0; }

            if (scroll  >= make_search_sticky_position ) { 

                advanced_search_nav.addClass('sticky-search-area');
                if(hidden_data) {
                    advanced_search_nav.removeClass('search-hidden');
                }

                if( !wp_is_mobile ) {
                    advanced_search_nav.css('top', admin_nav);
                }

                if (scroll >= make_search_sticky_position + searchStickyPlus ) { 
                    advanced_search_nav.addClass('houzez-in-view');
                    
                    if( !hidden_data ) {
                        $('#main-wrap').css('padding-top',thisHeight);
                    }
    
                }
            } else { 
                advanced_search_nav.removeClass('sticky-search-area');
                advanced_search_nav.removeAttr("style");
                if (scroll <= make_search_sticky_position + 20 ) { 
                    advanced_search_nav.removeClass('houzez-in-view');
                }
                if(hidden_data) {
                    advanced_search_nav.addClass('search-hidden');
                }
                if( !hidden_data ) {
                    $('#main-wrap').css('padding-top', 0);
                }
    
            }
        });
    }

    /*var header_mobile = $('#header-mobile');
    var mobile_sticky_nav = header_mobile.data('sticky');
    if( mobile_sticky_nav && wp_is_mobile ) {
        houzez_mobile_sticky_nav();
    }*/
    function houzez_mobile_sticky_nav() {
        $(window).scroll(function() {
            var scroll = $(window).scrollTop();
            var admin_nav = 0;//$('#wpadminbar').height();
            var top_banner_margin = 0;
            var thisHeight = header_mobile.outerHeight();
            top_banner_margin = thisHeight;

            if(is_top_header) {
                var top_bar_wrap = $('.top-bar-wrap').height();
                top_banner_margin = top_banner_margin + top_bar_wrap;
            }

            if(mobile_sticky_nav === 0) {
                return;
            }


            if( admin_nav == 'null' ) { admin_nav = 0; }

            if (scroll > header_area_height ) { 
                header_mobile.addClass('sticky-nav-area');
                //header_mobile.css('top', admin_nav);
                
                if (scroll >= header_area_height + 20 ) { 
                    header_mobile.addClass('houzez-in-view');
                    $('#main-wrap').css('margin-top', thisHeight);
                }

            } else { 
                header_mobile.removeClass('sticky-nav-area');
                header_mobile.removeAttr("style");

                if (scroll <= header_area_height + 20 ) { 
                    header_mobile.removeClass('houzez-in-view');
                }
                $('#main-wrap').css('margin-top', 0);
            }
        });
    }

    /* ------------------------------------------------------------------------ */
    /*  Add Comma to value
    /* ------------------------------------------------------------------------ */
    var addCommas = function (nStr) {
        nStr += '';
        var x = nStr.split('.');
        var x1 = x[0];
        var x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }

    var thousandSeparator = (n) => {
        if (typeof n === 'number') {
            n += '';
            var x = n.split('.');
            var x1 = x[0];
            var x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + thousands_separator + '$2');
            }
            return x1 + x2;
        } else {
            return n;
        }
    }

    /* ------------------------------------------------------------------------ */
    /*  Number format
     /* ------------------------------------------------------------------------ */
    function number_format( number ) {

        var decimals, dec_point, thousands_sep;

        dec_point = decimal_point_separator;
        thousands_sep = thousands_separator;

        var i, j, kw, kd, km;

        // input sanitation & defaults
        if( isNaN( decimals = Math.abs( decimals ) ) ) {
            decimals = 2;
        }

        dec_point = dec_point || ",";
        thousands_sep = thousands_sep || ".";

        i = parseInt(number = (+number || 0).toFixed(decimals)) + "";
        j = ( j = i.length ) > 3 ? j % 3 : 0;

        km = (j ? i.substr(0, j) + thousands_sep : "");
        kw = i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands_sep);
        
        kd = (decimals ? dec_point + Math.abs(number - i).toFixed(decimals).replace(/-/, 0).slice(2) : "");

        return km + kw + kd;
    }

    if( $('#calculate_loan').length > 0 ) {

        $('#calculate_loan').on('click', function(e) {
            e.preventDefault();

            var total_amount = $('#total_amount').val();
            var down_payment = $('#down_payment').val();
            var interest_rate = $('#interest_rate').val();
            var loan_term = $('#loan_term').val();
            var property_tax = $('#property_tax').val();
            var home_insurance = $('#home_insurance').val();
            var pmi = $('#pmi').val();

            mortgage_calucaltion_section(total_amount, down_payment, interest_rate, loan_term, property_tax, home_insurance, pmi);

        });

        $(document).ready(function() {
            var total_amount = $('#total_amount').val();
            var down_payment = $('#down_payment').val();
            var interest_rate = $('#interest_rate').val();
            var loan_term = $('#loan_term').val();
            var property_tax = $('#property_tax').val();
            var home_insurance = $('#home_insurance').val();
            var pmi = $('#pmi').val();

            mortgage_calucaltion_section(total_amount, down_payment, interest_rate, loan_term, property_tax, home_insurance, pmi);
        })
    }

    function currencyFormate(price_value) {

        var value;

        if( currency_position == '' || currency_symb == '' ) {
            return price_value;
        }

        value = 'after' === currency_position ? price_value + '' + currency_symb : currency_symb + '' + price_value;
        return value;
        
    }

    function mortgage_calucaltion_section(total_amount, down_payment, interest_rate, loan_term, property_tax, home_insurance, pmi) {
        
        if( isNaN( down_payment = Math.abs( down_payment ) ) ) {
            down_payment = 0;
        }

        if( isNaN( interest_rate = Math.abs( interest_rate ) ) ) {
            interest_rate = 0;
        }

        if( isNaN( loan_term = Math.abs( loan_term ) ) ) {
            loan_term = 0;
        }

        if( isNaN( property_tax = Math.abs( property_tax ) ) ) {
            property_tax = 0;
        }

        if( isNaN( home_insurance = Math.abs( home_insurance ) ) ) {
            home_insurance = 0;
        }

        if( isNaN( pmi = Math.abs( pmi ) ) ) {
            pmi = 0;
        }

        var load_amount = total_amount - down_payment;
        var qty_payments = loan_term * 12;
        var rate = interest_rate / 100 / 12;

        //Present value interest factor.
        var pvif = Math.pow( 1 + rate, qty_payments );
        var pmt = Math.round( rate / ( pvif - 1 ) * - ( load_amount * pvif ) );

        var interest_in_absolute = -pmt;
        var home_insurance = Math.round( home_insurance / 12 * 100 ) / 100;
        var property_tax = Math.round( property_tax / 12 * 100 ) / 100;
        var payment_total = interest_in_absolute + property_tax + home_insurance + parseInt(pmi);


        var interest_in_absolute2 = number_format(interest_in_absolute);
        interest_in_absolute2 = currencyFormate(interest_in_absolute2);

        var property_tax2 = number_format(property_tax);
        property_tax2 = currencyFormate(property_tax2);

        var home_insurance2 = number_format(home_insurance);
        home_insurance2 = currencyFormate(home_insurance2);

        var pmi2 = number_format(pmi);
        pmi2 = currencyFormate(pmi2);

        var payment_total2 = number_format(payment_total);
        payment_total2 = currencyFormate(payment_total2);
        
        $('#principal_interest_val').html(interest_in_absolute2);
        $('#property_tax_val').html(property_tax2);
        $('#home_insurance_val').html(home_insurance2);
        $('#pmi_val').html(pmi2);
        $('#m_monthly_val').html(payment_total2);

        var ctx = document.getElementById('mortgage-calculator-chart').getContext('2d');

        if (typeof calDoughnutChart !== 'undefined') {
            calDoughnutChart.destroy();
        }

        calDoughnutChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [interest_in_absolute, property_tax, home_insurance, pmi],
                    backgroundColor: [
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 206, 86, 0.5)',
                    'rgba(75, 192, 192, 0.5)'
                    ],
                    borderColor: [
                    'rgba(255 ,99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                cutoutPercentage: 85,
                responsive: false,
                tooltips: false,
            }
        });
    }

    /* ------------------------------------------------------------------------ */
    /*  Listing Preview
     /* ------------------------------------------------------------------------ */ 
    houzez_listing_lightbox(ajaxurl, processing_text, houzez_rtl, userID);


    /* ------------------------------------------------------------------------ */
    /*  Cities chart for agent and agency
     /* ------------------------------------------------------------------------ */
    if( $('#stats-property-cities').length > 0 ) { 
        var chartData = $('#stats-property-cities').data('chart');
        var ctx = document.getElementById('stats-property-cities').getContext('2d');
        var myDoughnutChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: chartData,
                    backgroundColor: [
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 206, 86, 0.5)',
                    'rgba(75, 192, 192, 0.5)'
                    ],
                    borderColor: [
                    'rgba(255 ,99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                cutoutPercentage: 60,
                responsive: false,
                tooltips: false,
            }
        });
    }

    /* ------------------------------------------------------------------------ */
    /*  Status chart for agent and agency
     /* ------------------------------------------------------------------------ */
    if( $('#stats-property-status').length > 0 ) { 
        var chartData = $('#stats-property-status').data('chart');
        var ctx = document.getElementById('stats-property-status').getContext('2d');
        var myDoughnutChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: chartData,
                    backgroundColor: [
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 206, 86, 0.5)',
                    'rgba(75, 192, 192, 0.5)'
                    ],
                    borderColor: [
                    'rgba(255 ,99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                cutoutPercentage: 60,
                responsive: false,
                tooltips: false,
            }
        });
    }

    /* ------------------------------------------------------------------------ */
    /*  Types chart for agent and agency
     /* ------------------------------------------------------------------------ */
    if( $('#stats-property-types').length > 0 ) { 
        var chartData = $('#stats-property-types').data('chart');
        var ctx = document.getElementById('stats-property-types').getContext('2d');
        var myDoughnutChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: chartData,
                    backgroundColor: [
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 206, 86, 0.5)',
                    'rgba(75, 192, 192, 0.5)'
                    ],
                    borderColor: [
                    'rgba(255 ,99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                cutoutPercentage: 60,
                responsive: false,
                tooltips: false,
            }
        });
    }


    /* ------------------------------------------------------------------------ */
    /*  Fave login and regsiter
     /* ------------------------------------------------------------------------ */
    var houzez_login_modal = function() {
        jQuery('#login-register-form').modal('show');
        jQuery('.login-form-tab').addClass('active show');
        jQuery('.modal-toggle-1.nav-link').addClass('active');
    }

    $('#houzez-login-btn').on('click', function(e){
        e.preventDefault();
        var currnt = $(this);
        houzez_login( currnt );
    });

    $('#houzez-register-btn').on('click', function(e){
        e.preventDefault();
        var currnt = $(this);
        houzez_register( currnt );
    });

    var houzez_login = function( currnt ) {
        var $form = currnt.parents('form');
        var $messages = $('#hz-login-messages');

        $.ajax({
            type: 'post',
            url: ajaxurl,
            dataType: 'json',
            data: $form.serialize(),
            beforeSend: function( ) {
                currnt.find('.houzez-loader-js').addClass('loader-show');
            },
            complete: function(){
                currnt.find('.houzez-loader-js').removeClass('loader-show');
            },
            success: function( response ) {
                if( response.success ) {
                    $messages.empty().append('<div class="alert alert-success" role="alert"><i class="houzez-icon icon-check-circle-1 mr-1"></i>'+ response.msg +'</div>');
                    
                    window.location.replace( response.redirect_to );

                } else {
                    $messages.empty().append('<div class="alert alert-danger" role="alert"><i class="houzez-icon icon-check-circle-1 mr-1"></i>'+ response.msg +'</div>');
                }

                currnt.find('.houzez-loader-js').removeClass('loader-show');

                if(houzez_reCaptcha == 1) {
                    $form.find('.g-recaptcha-response').remove();
                    if( g_recaptha_version == 'v3' ) {
                        houzezReCaptchaLoad();
                    } else {
                        houzezReCaptchaReset();
                    }
                }
            },
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                console.log(err.Message);
            }
        })

    } // end houzez_login

    var houzez_register = function ( currnt ) {

        var $form = currnt.parents('form');
        var $messages = $('#hz-register-messages');

        $.ajax({
            type: 'post',
            url: ajaxurl,
            dataType: 'json',
            data: $form.serialize(),
            beforeSend: function( ) {
                currnt.find('.houzez-loader-js').addClass('loader-show');
            },
            complete: function(){
                currnt.find('.houzez-loader-js').removeClass('loader-show');
            },
            success: function( response ) {
                if( response.success ) {
                    $messages.empty().append('<div class="alert alert-success" role="alert"><i class="houzez-icon icon-check-circle-1 mr-1"></i>'+ response.msg +'</div>');
                } else {
                    $messages.empty().append('<div class="alert alert-danger" role="alert"><i class="houzez-icon icon-check-circle-1 mr-1"></i>'+ response.msg +'</div>');
                }

                currnt.find('.houzez-loader-js').removeClass('loader-show');
                if(houzez_reCaptcha == 1) {
                    $form.find('.g-recaptcha-response').remove();
                    if( g_recaptha_version == 'v3' ) {
                        houzezReCaptchaLoad();
                    } else {
                        houzezReCaptchaReset();
                    }
                }
            },
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                console.log(err.Message);
            }
        });
    }


    $( '#houzez_forgetpass').on('click', function(){
        var user_login = $('#user_login_forgot').val(),
            security    = $('#fave_resetpassword_security').val();

        var $this = $(this);
        var $messages = $('#reset_pass_msg');

        $.ajax({
            type: 'post',
            url: ajaxurl,
            dataType: 'json',
            data: {
                'action': 'houzez_reset_password',
                'user_login': user_login,
                'security': security
            },
            beforeSend: function( ) {
                $this.find('.houzez-loader-js').addClass('loader-show');
            },
            complete: function(){
                $this.find('.houzez-loader-js').removeClass('loader-show');
            },
            success: function( response ) {
                if( response.success ) {
                    $messages.empty().append('<div class="alert alert-success" role="alert"><i class="houzez-icon icon-check-circle-1 mr-1"></i>'+ response.msg +'</div>');
                } else {
                    $messages.empty().append('<div class="alert alert-danger" role="alert"><i class="houzez-icon icon-check-circle-1 mr-1"></i>'+ response.msg +'</div>');
                }
            },
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                console.log(err.Message);
            }
        });

    });


    if( $('#houzez_reset_password').length > 0 ) {
        $('#houzez_reset_password').click( function(e) {
            e.preventDefault();

            var $this = $(this);
            var rg_login = $('input[name="rp_login"]').val();
            var rp_key = $('input[name="rp_key"]').val();
            var pass1 = $('input[name="pass1"]').val();
            var pass2 = $('input[name="pass2"]').val();
            var security = $('input[name="fave_resetpassword_security"]').val();
            var $messages = $('#reset_pass_msg_2');

            $.ajax({
                type: 'post',
                url: ajaxurl,
                dataType: 'json',
                data: {
                    'action': 'houzez_reset_password_2',
                    'rq_login': rg_login,
                    'password': pass1,
                    'confirm_pass': pass2,
                    'rp_key': rp_key,
                    'security': security
                },
                beforeSend: function( ) {
                    $this.find('.houzez-loader-js').addClass('loader-show');
                },
                complete: function(){
                    $this.find('.houzez-loader-js').removeClass('loader-show');
                },
                success: function(response) {
                    if( response.success ) {
                        $messages.empty().append('<div class="alert alert-success" role="alert"><i class="houzez-icon icon-check-circle-1 mr-1"></i>'+ response.msg +'</div>');
                        jQuery('#oldpass, #newpass, #confirmpass').val('');
                    } else {
                        $messages.empty().append('<div class="alert alert-danger" role="alert"><i class="houzez-icon icon-check-circle-1 mr-1"></i>'+ response.msg +'</div>');
                    }
                },
                error: function(errorThrown) {

                }

            });

        } );
    }


    $('.hz-facebook-login').on('click', function () {
        var current = $(this);
        houzez_login_via_facebook( current );
    });

    var houzez_login_via_facebook = function ( current ) {
        var $messages = $('.hz-social-messages');

        $.ajax({
            type: 'POST',
            url: ajaxurl,
            dataType: 'json',
            data: {
                'action' : 'houzez_facebook_login_oauth'
            },
            beforeSend: function( ) {
                $messages.empty().append('<div class="alert alert-success" role="alert"><i class="houzez-icon icon-check-circle-1 mr-1"></i>'+ login_loading +'</div>');
                current.find('.houzez-loader-js').addClass('loader-show');
            },
            complete: function(){
                current.find('.houzez-loader-js').removeClass('loader-show');
            },
            success: function (response) { 
                if(response.success) {
                    window.location.replace( response.url );
                } else {
                    $messages.empty().append('<div class="alert alert-danger" role="alert"><i class="houzez-icon icon-check-circle-1 mr-1"></i>'+ response.message +'</div>');
                }
                
            },
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                console.log(err.Message);
            }
        });
    }

    $('.hz-google-login').on('click', function () {
        var current = $(this);
        houzez_login_via_google( current );
    });

    var houzez_login_via_google = function ( current ) {
        var $form = current.parents('form');
        var $messages = $('#hz-login-messages');

        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                'action' : 'houzez_google_login_oauth'
            },
            beforeSend: function( ) {
                $messages.empty().append('<div class="alert alert-success" role="alert"><i class="houzez-icon icon-check-circle-1 mr-1"></i>'+ login_loading +'</div>');
                current.find('.houzez-loader-js').addClass('loader-show');
            },
            complete: function(){
                current.find('.houzez-loader-js').removeClass('loader-show');
            },
            success: function (data) { 
                window.location.replace( data );
            },
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                console.log(err.Message);
            }
        });
    }

    /*--------------------------------------------------------------------------
     *  Property Module Ajax Pagination
     * -------------------------------------------------------------------------*/
    var properties_module_section = $('#properties_module_section');
    if( properties_module_section.length > 0 ) {

        $("body").on('click', '.fave-load-more a', function(e) {
            e.preventDefault();
            var $this = $(this);
            var $wrap = $this.closest('#properties_module_section').find('#module_properties');
            var prop_limit = $this.data('prop-limit');
            var paged = $this.data('paged');
            var card_version = $this.data('card');
            var type = $this.data('type');
            var status = $this.data('status');
            var state = $this.data('state');
            var city = $this.data('city');
            var country = $this.data('country');
            var area = $this.data('area');
            var label = $this.data('label');
            var user_role = $this.data('user-role');
            var featured_prop = $this.data('featured-prop');
            var offset = $this.data('offset');
            var sortby = $this.data('sortby');

            $.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    'action': 'houzez_loadmore_properties',
                    'prop_limit': prop_limit,
                    'paged': paged,
                    'card_version': card_version,
                    'type': type,
                    'status': status,
                    'state': state,
                    'city': city,
                    'country': country,
                    'area': area,
                    'label': label,
                    'user_role': user_role,
                    'featured_prop': featured_prop,
                    'sort_by': sortby,
                    'offset': offset
                },
                beforeSend: function( ) {
                    $this.find('.houzez-loader-js').addClass('loader-show');
                },
                complete: function(){
                    $this.find('.houzez-loader-js').removeClass('loader-show');
                },
                success: function (data) { 
                    if(data == 'no_result') {
                         $this.closest('#properties_module_section').find('.fave-load-more').fadeOut('fast').remove();
                         return;
                    }
                    var $wrap = $this.closest('#properties_module_section').find('#module_properties');
                    $wrap.append(data);
                    $this.data("paged", paged+1);
                    $this.find('i').remove();

                    houzez_init_add_favorite(ajaxurl, userID);
                    houzez_init_remove_favorite(ajaxurl, userID);
                    houzez_listing_lightbox(ajaxurl, processing_text, houzez_rtl, userID);
                    compare_for_ajax();
                    $('[data-toggle="tooltip"]').tooltip();

                },
                error: function (xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    console.log(err.Message);
                }

            });

        }); 

    }

    /*--------------------------------------------------------------------------
     *  Change search price on status change
     * -------------------------------------------------------------------------*/
    var property_status_changed = function(prop_status, $form) {
        
        if( prop_status === for_rent ) {
            $form.find('.prices-for-all').addClass('hide');
            $form.find('.prices-for-all select').attr('disabled','disabled');
            $form.find('.prices-only-for-rent').removeClass('hide');
            $form.find('.prices-only-for-rent select').removeAttr('disabled','disabled');
            $form.find('.prices-only-for-rent select').selectpicker('refresh');
        } else { 
            $form.find('.prices-only-for-rent').addClass('hide');
            $form.find('.prices-only-for-rent select').attr('disabled','disabled');
            $form.find('.prices-for-all').removeClass('hide');
            $form.find('.prices-for-all select').removeAttr('disabled','disabled');
            $form.find('.prices-for-all select').selectpicker('refresh');
        }
    }
    $('.status-js').on('change', function(e){
        var selected_status = $(this).val();
        var $form = $(this).parents('form');
        property_status_changed(selected_status, $form);
    });

    $('.status-tab-js').on('click', function() {
        var tab_selected_status = $(this).data('val');
        var $form = $(this).parents('form');
        property_status_changed(tab_selected_status, $form);
    });



    /* On page load*/
    var selected_status = $('.status-js').val();
    if( selected_status == for_rent ) {
        var $form = $('.houzez-search-form-js');
        property_status_changed(selected_status, $form);
    } else {
        var $form = $('.houzez-search-form-js');
        property_status_changed('dummy', $form);
    }

    /* ------------------------------------------------------------------------ */
    /*  Price Range Slider
     /* ------------------------------------------------------------------------ */
    var price_range_search = function( min_price, max_price ) {
        $(".price-range").slider({
            range: true,
            min: min_price,
            max: max_price,
            values: [min_price, max_price],
            slide: function (event, ui) {
                if( currency_position == 'after' ) {
                    var min_price_range = thousandSeparator(ui.values[0]) + currency_symb;
                    var max_price_range = thousandSeparator(ui.values[1]) + currency_symb;
                } else {
                    var min_price_range = currency_symb + thousandSeparator(ui.values[0]);
                    var max_price_range = currency_symb + thousandSeparator(ui.values[1]);
                }
                $(".min-price-range-hidden").val( ui.values[0] );
                $(".max-price-range-hidden").val( ui.values[1] );

                $(".min-price-range").text( min_price_range );
                $(".max-price-range").text( max_price_range );
            },
            stop: function( event, ui ) {
                
            },
            change: function( event, ui ) {  }
        });

        if( currency_position == 'after' ) {
            var min_price_range = thousandSeparator($(".price-range").slider("values", 0)) + currency_symb;
            var max_price_range = thousandSeparator($(".price-range").slider("values", 1)) + currency_symb;
        } else {
            var min_price_range = currency_symb + thousandSeparator($(".price-range").slider("values", 0));
            var max_price_range = currency_symb + thousandSeparator($(".price-range").slider("values", 1));
        }

        $(".min-price-range").text(min_price_range);
        $(".max-price-range").text(max_price_range);
        $(".min-price-range-hidden").val($(".price-range").slider("values", 0));
        $(".max-price-range-hidden").val($(".price-range").slider("values", 1));
        
    }

    if($( ".price-range").length > 0 && is_halfmap != 1) {
        var selected_status_adv_search = $('.status-js').val();
        if( selected_status_adv_search == for_rent_price_slider ){
            price_range_search(search_price_range_min_rent, search_price_range_max_rent);
        } else {
            price_range_search( search_price_range_min, search_price_range_max );
        }

        $('.status-js').on('change', function(){
            var search_status = $(this).val();
            if( search_status == for_rent_price_slider ) {
                price_range_search(search_price_range_min_rent, search_price_range_max_rent);
            } else { 
                price_range_search( search_price_range_min, search_price_range_max );
            }
        });

        $('.status-tab-js').on('click', function() {
            var tab_status = $(this).data('val');
            if( tab_status == for_rent_price_slider ) {
                price_range_search(search_price_range_min_rent, search_price_range_max_rent);
            } else { 
                price_range_search( search_price_range_min, search_price_range_max );
            }
        });
    }

    /*-----------------------------------------------------------------------------------*/
    /* Search Status tabs
    /*-----------------------------------------------------------------------------------*/
    $('.houzez-status-tabs li a').on('click', function(e) {
        e.preventDefault();
        var $this = $(this);
        var status = $this.data('val');

        $('#search-tabs').val(status);

        var $form = $('.houzez-search-form-js');
        property_status_changed(status, $form);

    });


    /*-----------------------------------------------------------------------------------*/
    /* PROPERTIES SORTING
    /*-----------------------------------------------------------------------------------*/
    function insertParam(key, value) {
        key = encodeURI(key);
        value = encodeURI(value);

        // get querystring , remove (?) and covernt into array
        var qrp = document.location.search.substr(1).split('&');

        // get qrp array length
        var i = qrp.length;
        var j;
        while (i--) {
            //covert query strings into array for check key and value
            j = qrp[i].split('=');

            // if find key and value then join
            if (j[0] == key) {
                j[1] = value;
                qrp[i] = j.join('=');
                break;
            }
        }

        if (i < 0) {
            qrp[qrp.length] = [key, value].join('=');
        }
        // reload the page
        document.location.search = qrp.join('&');

    }

    $('#sort_properties').on('change', function() {
        var key = 'sortby';
        var value = $(this).val();
        insertParam( key, value );
    });

    $('#insights_filter').on('change', function() {
        var key = 'listing_id';
        var value = $(this).val();
        insertParam( key, value );
    });

    $('#houzez-gmap-full').on('click', function() {
        var $this = $(this);
        if($this.hasClass('active')) {
            $this.removeClass('active');
            $this.parents('.map-wrap').removeClass('houzez-fullscreen-map');
        } else {
            $this.parents('.map-wrap').addClass('houzez-fullscreen-map');
            $this.addClass('active');
        }
        
    });

    /*--------------------------------------------------------------------------
     *  Property Agent Contact Form
     * -------------------------------------------------------------------------*/
    $( '.houzez_agent_property_form').on('click', function(e) {
        e.preventDefault();

        var $result;
        var $this = $(this);
        var $form = $this.parents( 'form' );
        var $form_wrap = $this.parents( '.property-form-wrap' );
        $result = $form_wrap.find('.form_messages');
        var $is_bottom = $('.is_bottom').val();
        if($is_bottom == 'bottom') {
            $result = $form.find('.form_messages');
        }
        $result.empty();

        $.ajax({
            url: ajaxurl,
            data: $form.serialize(),
            method: $form.attr('method'),
            dataType: "JSON",

            beforeSend: function( ) {
                $this.find('.houzez-loader-js').addClass('loader-show');
            },
            success: function(response) {
                if( response.success ) {
                    
                    $form.find('input[name="name"], input[name="mobile"], input[name="email"]').val('');
                    $form.find('textarea').val('');
                    if($is_bottom == 'bottom') {
                        $result.empty().append('<div class="alert alert-success alert-dismissible fade show" role="alert">'+response.msg+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    } else {
                        $result.empty().append('<p class="success text-success"><i class="fa fa-check"></i> '+ response.msg +'</p>');
                    }
                } else {
                    if($is_bottom == 'bottom') {
                        $result.empty().append('<div class="alert alert-danger alert-dismissible fade show" role="alert">'+response.msg+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    } else {
                        $result.empty().append('<p class="error text-danger"><i class="fas fa-times"></i> '+ response.msg +'</p>');
                    }
                }

                $this.find('.houzez-loader-js').removeClass('loader-show');
                
                if(houzez_reCaptcha == 1) {
                    $form.find('.g-recaptcha-response').remove();
                    if( g_recaptha_version == 'v3' ) {
                        houzezReCaptchaLoad();
                    } else {
                        houzezReCaptchaReset();
                    }
                }
                
                if( houzez_vars.agent_redirection != '' && response.success ) {
                    setTimeout(function(){
                        window.location.replace(houzez_vars.agent_redirection);
                    }, 500);
                }

            },
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                console.log(err.Message);
            },
            complete: function(){
                $this.find('.houzez-loader-js').removeClass('loader-show');
            }
        });
    });

    /*--------------------------------------------------------------------------
     *  Direct message
     * -------------------------------------------------------------------------*/
    $('.msg-login-required').on('click', function() {
        $('.modal-toggle-1').addClass("active");
        jQuery('.login-form-tab').addClass('active show');
    });

    $( '.houzez-send-message').on('click', function(e) {
        e.preventDefault();

        var $result;
        var $this = $(this);
        var $form = $this.parents( 'form' );
        var $form_wrap = $this.parents( '.property-form-wrap' );
        $result = $form_wrap.find('.form_messages');
        var $is_bottom = $('.is_bottom').val();
        if($is_bottom == 'bottom') {
            $result = $form.find('.form_messages');
        }
        $result.empty();

        var property_id = $('input[name="listing_id"]').val();
        var message = $form.find('.hz-form-message').val();
        var security = $('input[name="property_agent_contact_security"]').val();

        $.ajax({
            url: ajaxurl,
            data: {
                'action' : 'houzez_start_thread',
                'property_id' : property_id,
                'message' : message,
                'start_thread_form_ajax' : security,
            },
            method: $form.attr('method'),
            dataType: "JSON",

            beforeSend: function( ) {
                $this.find('.houzez-loader-js').addClass('loader-show');
            },
            success: function(response) {
                if( response.success ) {
                    
                    $form.find('input[name="name"], input[name="mobile"], input[name="email"]').val('');
                    $form.find('textarea').val('');
                    if($is_bottom == 'bottom') {
                        $result.empty().append('<div class="alert alert-success alert-dismissible fade show" role="alert">'+response.msg+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    } else {
                        $result.empty().append('<p class="success text-success"><i class="fa fa-check"></i> '+ response.msg +'</p>');
                    }
                } else {
                    if($is_bottom == 'bottom') {
                        $result.empty().append('<div class="alert alert-danger alert-dismissible fade show" role="alert">'+response.msg+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    } else {
                        $result.empty().append('<p class="error text-danger"><i class="fas fa-times"></i> '+ response.msg +'</p>');
                    }
                }

                $this.find('.houzez-loader-js').removeClass('loader-show');
                
                if(houzez_reCaptcha == 1) {
                    $form.find('.g-recaptcha-response').remove();
                    if( g_recaptha_version == 'v3' ) {
                        houzezReCaptchaLoad();
                    } else {
                        houzezReCaptchaReset();
                    }
                }
                
                if( houzez_vars.agent_redirection != '' ) {
                    setTimeout(function(){
                        window.location.replace(houzez_vars.agent_redirection);
                    }, 500);
                }

            },
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                console.log(err.Message);
            },
            complete: function(){
                $this.find('.houzez-loader-js').removeClass('loader-show');
            }
        });
    });


    /*
     * Property Thread Message Form
     * -----------------------------*/
    $( '.start_thread_message_form').on('click', function(e) {

        e.preventDefault();

        var $this = $(this);
        var $form = $this.parents( 'form' );
        var $result = $form.find('.form_messages');

        $.ajax({
            url: ajaxurl,
            data: $form.serialize(),
            method: $form.attr('method'),
            dataType: "JSON",

            beforeSend: function( ) {
                $this.find('.houzez-loader-js').addClass('loader-show');
            },
            success: function( response ) {
                $this.find('.houzez-loader-js').removeClass('loader-show');
                window.location.replace( response.url );
            },
            complete: function(){
                $this.find('.houzez-loader-js').removeClass('loader-show');
            }
        });

    });

    /*--------------------------------------------------------------------------
     *   Contact agent form on agent detail page
     * -------------------------------------------------------------------------*/
    $('#contact_realtor_btn').on('click', function(e) {
        e.preventDefault();
        var current_element = $(this);
        var $this = $(this);
        var $form = $this.parents( 'form' );

        jQuery.ajax({
            type: 'post',
            url: ajaxurl,
            data: $form.serialize(),
            method: $form.attr('method'),
            dataType: "JSON",

            beforeSend: function( ) {
                $this.find('.houzez-loader-js').addClass('loader-show');
            },
            success: function( res ) {
                if( res.success ) {
                    $('.form_messages').empty().append('<div class="alert alert-success alert-dismissible fade show" role="alert">'+res.msg+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                } else {
                    $('.form_messages').empty().append('<div class="alert alert-danger alert-dismissible fade show" role="alert">'+res.msg+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                }

                $this.find('.houzez-loader-js').removeClass('loader-show');
                if(houzez_reCaptcha == 1) {
                    $form.find('.g-recaptcha-response').remove();
                    if( g_recaptha_version == 'v3' ) {
                        houzezReCaptchaLoad();
                    } else {
                        houzezReCaptchaReset();
                    }
                }
            },
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                console.log(err.Message);
            },
            complete: function(){
                $this.find('.houzez-loader-js').removeClass('loader-show');
            }

        });
    });


    /*--------------------------------------------------------------------------
     *  Invoice Filter
     * -------------------------------------------------------------------------*/
    $('#invoice_status, #invoice_type').change(function() {
        houzez_invoices_filter();
    });

    $('#startDate, #endDate').focusout(function() {
        houzez_invoices_filter();
    })

    var houzez_invoices_filter = function() {
        var inv_status = $('#invoice_status').val(),
            inv_type   = $('#invoice_type').val(),
            startDate  = $('#startDate').val(),
            endDate  = $('#endDate').val();

        $.ajax({
            url: ajaxurl,
            dataType: 'json',
            type: 'POST',
            data: {
                'action': 'houzez_invoices_ajax_search',
                'invoice_status': inv_status,
                'invoice_type'  : inv_type,
                'startDate'     : startDate,
                'endDate'       : endDate
            },
            success: function(res) { 
                if(res.success) {
                    $('#invoices_content').empty().append( res.result );
                }
            },
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                console.log(err.Message);
            }
        });
    }

    /*--------------------------------------------------------------------------
     *  AutoComplete Search
     * -------------------------------------------------------------------------*/
    if( keyword_autocomplete != 0 ) {
        var houzezAutoComplete = function () {

            var ajaxCount = 0;
            var auto_complete_container = $('.auto-complete');
            var lastLenght = 0;

            $('.houzez-keyword-autocomplete').keyup(function() {

                var $this = $( this );
                var $dataType = $this.data('type');
                var $form = $this.parents( 'form');
                
                if( $dataType == 'banner' ) {
                    var auto_complete_container = $( '#houzez-auto-complete-banner' );
                } else {
                    var auto_complete_container = $form.find( '.auto-complete' );
                }

                var keyword = $( this ).val();
                
                keyword = $.trim( keyword );
                var currentLenght = keyword.length;

                if ( currentLenght >= 2 && currentLenght != lastLenght ) {

                    lastLenght = currentLenght;
                    auto_complete_container.fadeIn();

                    $.ajax({
                        type: 'POST',
                        url: ajaxurl,
                        data: {
                            'action': 'houzez_get_auto_complete_search',
                            'key': keyword,
                        },
                        beforeSend: function( ) {
                            ajaxCount++;
                            if ( ajaxCount == 1 ) {
                                auto_complete_container.html('<ul class="list-group"><li class="list-group-item"><i class="fa fa-spinner fa-spin fa-fw"></i> '+autosearch_text+ '</li></ul>');
                            }
                        },
                        success: function(data) {
                            ajaxCount--;
                            if ( ajaxCount == 0 ) {
                                auto_complete_container.show();
                                if( data != '' ) {
                                    auto_complete_container.empty().html(data).bind();
                                }
                            }
                        },
                        error: function(errorThrown) {
                            ajaxCount--;
                            if ( ajaxCount == 0 ) {
                                auto_complete_container.html('<ul class="list-group"><li class="list-group-item"><i class="fa fa-spinner fa-spin fa-fw"></i> '+autosearch_text+ '</li></ul>');
                            }
                        }
                    });

                } else {
                    if ( currentLenght != lastLenght ) {
                        auto_complete_container.fadeOut();
                    }
                }

            });
            auto_complete_container.on( 'click', 'li', function (){
                $('.houzez-keyword-autocomplete').val( $( this ).data( 'text' ) );
                auto_complete_container.fadeOut();
            }).bind();
        }
        houzezAutoComplete();
    }

    /*--------------------------------------------------------------------------
     *  Save Search
     * -------------------------------------------------------------------------*/
    $("#save_search_click").on('click', function(e) {
        e.preventDefault();

        var $this = $(this);

        var search_args = $('input[name="search_args"]').val();
        var security = $('input[name="houzez_save_search_ajax"]').val();
        var search_URI = $('input[name="search_URI"]').val();

        if( parseInt( userID, 10 ) === 0 ) {
                houzez_login_modal();
        } else {
            $.ajax({
                url: ajaxurl,
                data: {
                    'action': 'houzez_save_search',
                    'search_args': search_args,
                    'search_URI': search_URI,
                    'houzez_save_search_ajax': security,
                },
                method: 'POST',
                dataType: 'JSON',

                beforeSend: function () {
                    $this.find('.houzez-loader-js').addClass('loader-show');
                },
                success: function (response) {
                    if (response.success) {
                        $('#save_search_click').attr('disabled', true);
                    }
                },
                error: function (xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    console.log(err.Message);
                },
                complete: function () {
                    $this.find('.houzez-loader-js').removeClass('loader-show');
                }
            });
        }

    });


    /*--------------------------------------------------------------------------
     *  Property Schedule Contact Form
     * -------------------------------------------------------------------------*/
    $( '.schedule_contact_form').on('click', function(e) {
        e.preventDefault();

        var $this = $(this);
        var $form = $this.parents( 'form' );
        var $result = $form.find('.form_messages');

        $.ajax({
            url: ajaxurl,
            data: $form.serialize(),
            method: $form.attr('method'),
            dataType: "JSON",

            beforeSend: function( ) {
                $this.find('.houzez-loader-js').addClass('loader-show');
            },
            success: function(response) {
                if( response.success ) {
                    $form.find('input[name="name"], input[name="phone"], input[name="email"]').val('');
                    $form.find('textarea').val('');
                    $result.empty().append('<div class="alert alert-success alert-dismissible fade show" role="alert">'+response.msg+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                } else {
                    $result.empty().append('<div class="alert alert-danger alert-dismissible fade show" role="alert">'+response.msg+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                }
            },
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                console.log(err.Message);
            },
            complete: function(){
                $this.find('.houzez-loader-js').removeClass('loader-show');
            }
        });

    });

    /* ------------------------------------------------------------------------ */
    /*  autocomplete result position
    /* ------------------------------------------------------------------------ */
    function setAutoCompleteResultPosition() {
        var parallax_banner_inner_height = $('.top-banner-wrap').innerHeight();
        var banner_caption_inner_height = $('.banner-caption').innerHeight();
        var autocomplete_search_position = (parallax_banner_inner_height - (parallax_banner_inner_height - banner_caption_inner_height) / 2);

        $('#houzez-auto-complete-banner').css('top', autocomplete_search_position);
    }

    $(window).on('load', function(){
        setAutoCompleteResultPosition();
    });
    
    $win.on('resize', function () {
        setAutoCompleteResultPosition();
    });

    /*-----------------------------------------------------------------------------------*/
    /* Print Property
    /*-----------------------------------------------------------------------------------*/
    if( $('.houzez-print').length > 0 ) {
        $('.houzez-print').on('click', function (e) {
            e.preventDefault();
            var propID, printWindow;

            propID = $(this).attr('data-propid');

            printWindow = window.open('', 'Print Me', 'width=800 ,height=842');
            $.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    'action': 'houzez_create_print',
                    'propid': propID,
                },
                success: function (data) {
                    printWindow.document.write(data);
                    printWindow.document.close();
                    printWindow.focus();
                },
                error: function (xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    console.log(err.Message);
                }

            });
        });
    }

    /*-----------------------------------------------------------------------------------*/
    /* Reviews like dislike 
    /*-----------------------------------------------------------------------------------*/
    var review_likes = function() {
        $('.hz-like-dislike-js').on('click', function(e) {
            e.preventDefault();
            var $this = jQuery(this);
            var $parent = $this.parents('.likes-container-js');

            if($this.hasClass('already-voted')){
                $parent.find( '.vote-msg' ).text($this.data('msg')).show();
                var hideMessage = function(){
                    $parent.find( '.vote-msg' ).hide();
                };
                setTimeout(hideMessage, 3000);
            
            } else {

                var review_id = $this.data('id');
                var type = $this.data('type');

                $.ajax({
                    type: 'post',
                    url: ajaxurl,
                    dataType: "JSON",
                    data: {
                        'action': 'reviews_likes_dislikes',
                        'type': type,
                        'review_id': review_id,
                    },
                    beforeSend: function( ) {
                        $parent.find('.vote-msg').empty();
                        $parent.find('.houzez-loader-js').addClass('loader-show');

                        if(type == 'likes') {
                            $('.review-dislike-button a').removeClass('already-voted');
                        } else if(type == 'dislikes') {
                            $('.review-like-button a').removeClass('already-voted');
                        }
                    },
                    success: function(res) {
                        if(res.success) {
                            $parent.find('.likes-count').text(res.likes);
                            $parent.find('.dislikes-count').text(res.dislikes);
                            $parent.find('.vote-msg').text(res.msg).show();
                        } else {
                            $parent.find('.vote-msg').text(res.msg).show();
                        }

                        var hideMessage = function(){
                            $parent.find( '.vote-msg' ).hide();
                        };
                        setTimeout(hideMessage, 3000);
                        $this.addClass('already-voted');
                    },
                    error: function(xhr, status, error) {
                        var err = eval("(" + xhr.responseText + ")");
                        console.log(err.Message);
                    },
                    complete: function(){
                        $parent.find('.houzez-loader-js').removeClass('loader-show');
                    }

                });
            }

        });
    }
    review_likes();
    

    /*-----------------------------------------------------------------------------------*/
    /* Reviews 
    /*-----------------------------------------------------------------------------------*/
    $('#submit-review').on('click', function(e) {
        e.preventDefault();

        var $this = $(this);
        var $form = $this.parents( 'form' );
        var $result = $form.find('.form_messages');

        $.ajax({
            url: ajaxurl,
            data: $form.serialize(),
            method: $form.attr('method'),
            dataType: "JSON",

            beforeSend: function( ) {
                $this.find('.houzez-loader-js').addClass('loader-show');
            },
            success: function(response) {
                if( response.success ) {
                    $result.empty().append('<div class="alert alert-success alert-dismissible fade show" role="alert">'+response.msg+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    window.location.replace( response.review_link );
                } else {
                    $result.empty().append('<div class="alert alert-danger alert-dismissible fade show" role="alert">'+response.msg+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                }
            },
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                console.log(err.Message);
            },
            complete: function() {
                $this.find('.houzez-loader-js').removeClass('loader-show');
            }
        });
    });

    var listing_review_ajax = function(sortby, listing_id, paged) {
        var review_container = $('#houzez_reviews_container');
        var review_post_type = $('input[name="review_post_type"]').val();
        
        $.ajax({
            type: 'post',
            url: ajaxurl,
            data: {
                'action': 'houzez_ajax_review',
                'sortby': sortby,
                'listing_id': listing_id,
                'review_post_type': review_post_type,
                'paged': paged
            },
            beforeSend: function( ) {
                
                review_container.empty().append(''
                    +'<div id="houzez-map-loading">'
                    +'<div class="mapPlaceholder">'
                    +'<div class="loader-ripple spinner">'
                    +'<div class="bounce1"></div>'
                    +'<div class="bounce2"></div>'
                    +'<div class="bounce3"></div>'
                    +'</div>'
                    +'</div>'
                    +'</div>'
                );

                $('html, body').animate({
                    scrollTop: $("#property-review-wrap").offset().top-50
                }, 'slow');
            },
            success: function(data) {
                review_container.empty();
                review_container.html(data);
                review_likes();
                
            },
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                console.log(err.Message);
            },
            complete: function(){
                
            }

        });
    }

    if($('#sort_review').length > 0) {
        $('#sort_review').on('change', function() {
            var sortby = $(this).val();
            var listing_id = $('input[name="listing_id"]').val();
            var paged = 1;
            $('#review_paged').val(paged);
            $('#review_prev').attr('disabled', true);
            $('#review_next').attr('disabled', false);
            listing_review_ajax(sortby, listing_id, paged);
            return;
        }); 
    }

    if($('#review_next').length > 0) {
        $('#review_next').on('click', function(e) {
            e.preventDefault();
            $('#review_prev').removeAttr('disabled');
            var sortby = $('#sort_review').val();
            var total_pages = $('#total_pages').val();
            var listing_id = $('input[name="listing_id"]').val();
            var paged = $('#review_paged').val();
            paged = Number(paged)+1;
            $('#review_paged').val(paged);

            if(paged == total_pages) {
                $(this).attr('disabled', true);
            }
            listing_review_ajax(sortby, listing_id, paged);
            return;
        }); 
    }

    if($('#review_prev').length > 0) {
        $('#review_prev').on('click', function(e) {
            e.preventDefault();
            $('#review_next').removeAttr('disabled');
            var sortby = $('#sort_review').val();
            var listing_id = $('input[name="listing_id"]').val();
            var paged = $('#review_paged').val();
            paged = Number(paged)-1;
            $('#review_paged').val(paged);
            if(paged <= 1) {
                $(this).attr('disabled', true);
            }
            listing_review_ajax(sortby, listing_id, paged);
            return;
        }); 
    }

    /* ------------------------------------------------------------------------ */
    /*  Houzez Select Filter
    /* ------------------------------------------------------------------------ */
    function houzezSelectFilter($this, $dataRef, $list_num = '', is_on_load = '') {
        var e = $this.data("target"),
            i = $this.find(":selected").data("ref");

        if( is_on_load == 'yes' ) {
            e = $list_num;
            i = $dataRef;
        }

        $("select." + e).val(""),
            null == i
                ? $("select." + e)
                      .find("option")
                      .each(function () {
                          console.log("inside undefined"), $(this).removeAttr("disabled hidden");
                      })
                : $("select." + e)
                      .find("option")
                      .each(function () {
                          var e = $(this).data("belong"),
                              t = $(this).val();

                            i != e && t != '' ? ($(this).prop("disabled", !0), $(this).prop("hidden", !0)) : ($(this).prop("disabled", !1), $(this).prop("hidden", !1));
                            //i != e && -1 != t ? ($(this).prop("disabled", !0), $(this).prop("hidden", !0)) : ($(this).prop("disabled", !1), $(this).prop("hidden", !1));
                      });
                      $("select." + e).selectpicker('refresh');
    }

    $(".houzezSelectFilter").on("change", function () {
        var $this = $(this);
        houzezSelectFilter($this);
    });

    if( $('.houzez-search-form-js').length > 0 || $('#location').length > 0 ) {

        var countryRef, stateRef, cityRef, areasRef;
        if( is_edit_property ) {
            countryRef = $('#country').data("country");
            stateRef = $('#countyState').data("state");
            cityRef = $('#city').data("city");
            areasRef = $('#neighborhood').data("area");
        } else {
            countryRef = houzez_vars.s_country;
            stateRef = houzez_vars.s_state;
            cityRef = houzez_vars.s_city;
            areasRef = houzez_vars.s_areas;
        }

        if( ( $('.houzez-country-js').length > 0 || $('#country').length > 0 ) && countryRef != "" ) {
            var countryFilter = $('.houzezCountryFilter');
            houzezSelectFilter(countryFilter, countryRef, 'houzezSecondList', 'yes');

            $( window ).load(function() {
                $('.houzezSecondList').val(stateRef);
                $("select.houzezSecondList").selectpicker('refresh');
            });
        }

        if( ( $('.houzez-state-js').length > 0 || $('#countyState').length > 0 ) && stateRef != "" ) {
            var stateFilter = $('.houzezStateFilter');
            houzezSelectFilter(stateFilter, stateRef, 'houzezThirdList', 'yes');

            $( window ).load(function() {
                $('.houzezThirdList').val(cityRef);
                $("select.houzezThirdList").selectpicker('refresh');
            });
        }

        if( ( $('.houzez-city-js').length > 0 || $('#city').length > 0 ) && cityRef != "" ) {
            var cityFilter = $('.houzezCityFilter');
            houzezSelectFilter(cityFilter, cityRef, 'houzezFourthList', 'yes');

            $( window ).load(function() {
                $('.houzezFourthList').val(areasRef);
                $("select.houzezFourthList").selectpicker('refresh');
            });
        }
    }

    

    /*-----------------------------------------------------------------------------------*/
    /* mortgage calculate by waqas
    /*-----------------------------------------------------------------------------------*/
    if( $('#houzez_mortgage_calculate').length > 0 ) {
        $('#houzez_mortgage_calculate').click(function(e) {
            e.preventDefault();

            var monthly_payment = houzez_vars.monthly_payment;
            var weekly_payment = houzez_vars.weekly_payment;
            var bi_weekly_payment = houzez_vars.bi_weekly_payment;
            var currency_symb = houzez_vars.currency_symbol;

            var totalPrice  = 0;
            var down_payment = 0;
            var term_years  = 0;
            var interest_rate = 0;
            var amount_financed  = 0;
            var monthInterest = 0;
            var intVal = 0;
            var mortgage_pay = 0;
            var annualCost = 0;
            var payment_period;
            var mortgage_pay_text;


            var total_years = $('#mc_term_years').val();
            payment_period = $('#mc_payment_period').val();

            totalPrice = $('#mc_total_amount').val().replace(/,/g, '');
            down_payment = $('#mc_down_payment').val().replace(/,/g, '');
            amount_financed = totalPrice - down_payment;
            term_years =  parseInt ($('#mc_term_years').val(),10) * payment_period;
            interest_rate = parseFloat ($('#mc_interest_rate').val(),10);
            monthInterest = interest_rate / (payment_period * 100);
            intVal = Math.pow( 1 + monthInterest, -term_years );
            mortgage_pay = amount_financed * (monthInterest / (1 - intVal));
            annualCost = mortgage_pay * payment_period;
            
            if( $('#mc_term_years').val() == '' || $('#mc_total_amount') == '' || $('#mc_down_payment') == '' || $('#mc_interest_rate') == '' ) {
                return;
            }

            var total_mortgage_with_interest = mortgage_pay * total_years * payment_period;

            var total_with_down_payment = total_mortgage_with_interest + parseInt(down_payment);

            if( payment_period == '12' ) {
                mortgage_pay_text = monthly_payment;

            } else if ( payment_period == '26' ) {
                mortgage_pay_text = bi_weekly_payment;

            } else if ( payment_period == '52' ) {
                mortgage_pay_text = weekly_payment;

            }


            if(currency_position == 'after') {
                $('#mortgage_mwbi').html("<strong>"+mortgage_pay_text+ "</strong>: <span>"+(Math.round(mortgage_pay * 100)) / 100 + currency_symb + "</span>");
                $('#amount_financed').html(((Math.round(amount_financed * 100)) / 100)+currency_symb);
                $('#mortgage_pay').html(((Math.round(mortgage_pay * 100)) / 100)+currency_symb);
                $('#annual_cost').html(( (Math.round(annualCost * 100)) / 100)+currency_symb);
                $('#balance_payable_with_interest').html(( (Math.round(total_mortgage_with_interest * 100)) / 100)+currency_symb);
                $('#total_with_down_payment').html(( (Math.round(total_with_down_payment * 100)) / 100)+currency_symb);
            } else {
                $('#mortgage_mwbi').html("<strong>"+mortgage_pay_text+ "</strong>: <span>" +currency_symb+ (Math.round(mortgage_pay * 100)) / 100 + "</span>");
                $('#amount_financed').html(currency_symb+(Math.round(amount_financed * 100)) / 100);
                $('#mortgage_pay').html(currency_symb+(Math.round(mortgage_pay * 100)) / 100);
                $('#annual_cost').html(currency_symb+(Math.round(annualCost * 100)) / 100);
                $('#balance_payable_with_interest').html(currency_symb+(Math.round(total_mortgage_with_interest * 100)) / 100);
                $('#total_with_down_payment').html(currency_symb+(Math.round(total_with_down_payment * 100)) / 100);
            }

            $('#cal_years').html(total_years);
            $('.mortgage-details').show();
        });
    }

    /* ------------------------------------------------------------------------ */
    /* Beds and baths
    /* ------------------------------------------------------------------------ */
    var beds_baths = function(btn_action, btn_count, btn_val) {
        $('.'+btn_action).on('click', function(e) {
            e.preventDefault();
            var current_val = parseInt($('.'+btn_val).val()) || 0;

            if(btn_action == 'btn_count_plus' || btn_action == 'btn_beds_plus') {
                current_val++;

            } else { 
                if(current_val == 0)
                return;
                current_val--;
            }
            
            $('.'+btn_count).text(current_val);
            $('.'+btn_val).val(current_val);
        });

    }
    beds_baths('btn_count_plus', 'baths_count', 'bathrooms');
    beds_baths('btn_count_minus', 'baths_count', 'bathrooms');

    beds_baths('btn_beds_plus', 'beds_count', 'bedrooms');
    beds_baths('btn_beds_minus', 'beds_count', 'bedrooms');

    $('.btn-apply').on('click', function(e) {
        e.preventDefault();
        $('.advanced-search-v3 .btn-group .dropdown-menu').removeClass('show');
    });

    $('.clear-baths').on('click', function(e) {
        e.preventDefault();
        $('.baths_count').text('0');
        $('.bathrooms').val('');
    });

    $('.clear-beds').on('click', function(e) {
        e.preventDefault();
        $('.beds_count').text('0');
        $('.bedrooms').val('');
    });

    $('.clear-checkboxes').on('click', function(e) {
        e.preventDefault();
        $(this).parents('.btn-group').find('input[type="checkbox"]').attr('checked', false);
    });

    /* ------------------------------------------------------------------------ */
    /*  PAYPAL & Stripe OPTIONS
     /* ------------------------------------------------------------------------ */
    $('.method-select input').on('change',function () {
        if($(this).is(':checked')) {
            $('.recurring-payment-wrap').slideUp();
            $(this).parents('.payment-method-block').next('.recurring-payment-wrap').slideDown();
        }else{
            $('.recurring-payment-wrap').slideUp();
        }
    });
    function paypal_option(ele){
        if($(ele).attr('checked')) {
            $(ele).parents('.payment-method-block').next('.recurring-payment-wrap').slideDown();
        }else{
            $(ele).parents('.payment-method-block').next('.recurring-payment-wrap').slideUp();
        }
    }

    paypal_option('.paypal-method');
    paypal_option('.stripe-method');

    $('button.stripe-button-el span').prepend('<i class="fa fa-credit-card"></i>');
    $('#stripe_package_recurring').click(function () {
        if( $(this).attr('checked') ) {
            $('.houzez_payment_form').append('<input type="hidden" name="houzez_stripe_recurring" id="houzez_stripe_recurring" value="1">');
        }else{
            $('#houzez_stripe_recurring').remove();
        }
    });

    /* ------------------------------------------------------------------------ */
    /*  Change listing fee for featured
     /* ------------------------------------------------------------------------ */
    $('.prop_featured').on('change', function() {

        var currency_symbol = houzez_vars.currency_symbol;
        var currency_position = houzez_vars.currency_position;
        var total_price, total_price_with_currency, price_regular_with_currency;
        var price_regular  = parseFloat( $('#submission_price').text() );
        var price_featured = parseFloat( $('#submission_featured_price').text() );

        total_price = price_regular+price_featured;

        if ( currency_position === 'after'){
            price_regular_with_currency = price_regular +''+currency_symbol;
            total_price_with_currency = total_price +''+currency_symbol;
        }else{
            price_regular_with_currency = currency_symbol +''+price_regular;
            total_price_with_currency = currency_symbol+''+total_price;
        }

        if( $(this).is(':checked') ) {
            $('#submission_total_price').text(total_price_with_currency);
            $('#featured_pay').val(1);
            $('input[name="pay_ammout"]').val(total_price * 100);
            $('#houzez_listing_price').val(total_price);
        } else {
            $('#submission_total_price').text(price_regular_with_currency);
            $('#featured_pay').val(0);
            $('input[name="pay_ammout"]').val(price_regular * 100);
            $('#houzez_listing_price').val(price_regular);
        }
        return false;
    });

    /* ------------------------------------------------------------------------ */
    /*  Paypal single listing payment
     /* ------------------------------------------------------------------------ */
    $('#houzez_complete_order').on('click', function(e) {
        e.preventDefault();
        var hform, payment_gateway, houzez_listing_price, property_id, is_prop_featured, is_prop_upgrade;

        payment_gateway = $("input[name='houzez_payment_type']:checked").val();
        is_prop_featured = $("input[name='featured_pay']").val();
        is_prop_upgrade = $("input[name='is_upgrade']").val();

        property_id = $('#houzez_property_id').val();
        houzez_listing_price = $('#houzez_listing_price').val();

        if( payment_gateway == 'paypal' ) {
            fave_processing_modal( paypal_connecting );
            paypal_per_listing_payment( property_id, is_prop_featured, is_prop_upgrade);

        } else if ( payment_gateway == 'stripe' ) {
            hform = $(this).parents('form');
            if( is_prop_featured === '1' ) {
                hform.find('.houzez_stripe_simple_featured button').trigger( "click" );
            } else {
                hform.find('.houzez_stripe_simple button').trigger("click");
            }
        } else if ( payment_gateway == 'direct_pay' ) {
            fave_processing_modal( processing_text );
            bank_transfer_per_listing(property_id, houzez_listing_price);
        }
        return;

    });

    /* ------------------------------------------------------------------------ */
    /*  Paypal payment for per listing
     /* ------------------------------------------------------------------------ */
    var paypal_per_listing_payment = function( property_id, is_prop_featured, is_prop_upgrade ) {

        $.ajax({
            type: 'post',
            url: ajaxurl,
            data: {
                'action': 'houzez_property_paypal_payment',
                'prop_id': property_id,
                'is_prop_featured': is_prop_featured,
                'is_prop_upgrade': is_prop_upgrade,
            },
            success: function( response ) {
                window.location.href = response;
            },
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                console.log(err.Message);
            }
        });
    }

    /* ------------------------------------------------------------------------ */
    /*  Wire Transfer per listing payment
     /* ------------------------------------------------------------------------ */
    var bank_transfer_per_listing = function( prop_id, listing_price ) {
        var is_featured = $('input[name="featured_pay"]').val();
        var is_upgrade = $('input[name="is_upgrade"]').val();

        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                'action'        : 'houzez_direct_pay_per_listing',
                'prop_id'       : prop_id,
                'is_featured'   : is_featured,
                'is_upgrade'    : is_upgrade
            },
            success: function (data) {
                window.location.href = data;
            },
            error: function (errorThrown) {}
        });

    }

    /* ------------------------------------------------------------------------ */
    /*  Select Membership payment
     /* ------------------------------------------------------------------------ */
     var houzez_paypal_package_payment = function( houzez_package_price, houzez_package_name, houzez_package_id ) {

        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                'action'    : 'houzez_paypal_package_payment',
                'houzez_package_price' : houzez_package_price,
                'houzez_package_name'  : houzez_package_name,
                'houzez_package_id'  : houzez_package_id
            },
            success: function (data) {
                window.location.href = data;
            },
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                console.log(err.Message);
            }
        });
    }

    var houzez_recuring_paypal_package_payment = function(  houzez_package_price, houzez_package_name, houzez_package_id  ) {

        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                'action'               : 'houzez_recuring_paypal_package_payment',
                'houzez_package_name'  : houzez_package_name,
                'houzez_package_id'    : houzez_package_id,
                'houzez_package_price' : houzez_package_price
            },
            success: function (data) {
                window.location.href = data;
            },
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                console.log(err.Message);
            }
        });
    }

    var direct_bank_transfer_package = function( houzez_package_id, houzez_package_price, houzez_package_name ) {

        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                'action'           : 'houzez_direct_pay_package',
                'selected_package' : houzez_package_id,
            },
            success: function (data) {
                window.location.href = data;

            },
            error: function (errorThrown) {}
        });
    }

    var houzez_free_membership_package = function ( houzez_package_id ) {
        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                'action'           : 'houzez_free_membership_package',
                'selected_package' : houzez_package_id,
            },
            success: function (data) {
                window.location.href = data;

            },
            error: function (errorThrown) {}
        });
    }

    var houzez_membership_data = function(currnt) {
        var payment_gateway = $("input[name='houzez_payment_type']:checked").val();
        var houzez_package_price = $("input[name='houzez_package_price']").val();
        var houzez_package_id    = $("input[name='houzez_package_id']").val();
        var houzez_package_name  = $("#houzez_package_name").text();

        if( payment_gateway == 'paypal' ) {
            fave_processing_modal( paypal_connecting );
            if ($('#paypal_package_recurring').is(':checked')) {
                houzez_recuring_paypal_package_payment( houzez_package_price, houzez_package_name, houzez_package_id );
            } else {
                houzez_paypal_package_payment( houzez_package_price, houzez_package_name, houzez_package_id );
            }

        } else if ( payment_gateway == 'stripe' ) {
            var hform = currnt.parents('form');
            hform.find('.houzez_stripe_membership button').trigger( "click" );

        } else if ( payment_gateway == 'direct_pay' ) {
            fave_processing_modal( processing_text );
            direct_bank_transfer_package( houzez_package_id, houzez_package_price, houzez_package_name );

        } else {
            fave_processing_modal( processing_text );
            houzez_free_membership_package(  houzez_package_id );
        }

        return false;
    }

    var houzez_register_user_with_membership = function ( currnt ) {

        var $form = currnt.parents('form');
        var $messages = $('#packmem-msgs');

        $.ajax({
            type: 'post',
            url: ajaxurl,
            dataType: 'json',
            data: $form.serialize(),
            beforeSend: function( ) {
                currnt.find('.houzez-loader-js').addClass('loader-show');
            },
            complete: function(){
                currnt.find('.houzez-loader-js').removeClass('loader-show');
            },
            success: function( response ) {
                if( response.success ) {
                    houzez_membership_data(currnt);
                } else {
                    $('html, body').animate({
                        scrollTop: $(".frontend-submission-page").offset().top
                    }, 'slow');
                    $messages.empty().append('<div class="alert alert-danger alert-dismissible fade show" role="alert">'+response.msg+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                }
            },
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                console.log(err.Message);
            }
        });
    }

    $('#houzez_complete_membership').on('click', function(e) {
        e.preventDefault();
        var currnt = $(this);
        if( parseInt( userID, 10 ) === 0 || userID == undefined) {
            houzez_register_user_with_membership( currnt );
            return;
        }
        houzez_membership_data(currnt);
    } );


    /*--------------------------------------------------------------------------
     *  Area Switcher
     * -------------------------------------------------------------------------*/
    var areaSwitcherList = $('#area-switcher-list-js');
    if( areaSwitcherList.length > 0 ) {

        $('#area-switcher-list-js > li').on('click', function(e) {
            //e.stopPropagation();
            
            var selectedAreaCode = $(this).data( 'area-code' );
            if ( selectedAreaCode ) {

                $('#houzez-switch-to-area').val( selectedAreaCode );
                var houzez_switch_to_area = $('#houzez-switch-to-area').val();
                fave_processing_modal(processing_text);

                $.ajax({
                    url: ajaxurl,
                    dataType: 'JSON',
                    method: 'POST',
                    data: {
                        'action' : 'houzez_switch_area',
                        'switch_to_area' : houzez_switch_to_area,
                    },
                    success: function (res) {
                        if( res.success ) {
                            window.location.reload( true );
                        } else {
                            console.log( res );
                        }
                    },
                    error: function (xhr, status, error) {
                        var err = eval("(" + xhr.responseText + ")");
                        console.log(err.Message);
                    }
                });

            }

        });
    }

    /*--------------------------------------------------------------------------
     *  Currency Switcher
     * -------------------------------------------------------------------------*/
    var currencySwitcherList = $('#hz-currency-switcher-list');
    if( currencySwitcherList.length > 0 ) {

        $('#hz-currency-switcher-list > li').on('click', function(e) {
        
            var selectedCurrencyCode = $(this).data( 'currency-code' );

            if ( selectedCurrencyCode ) {

                $('#houzez-switch-to-currency').val( selectedCurrencyCode );
                var houzez_switch_to_currency = $('#houzez-switch-to-currency').val();
                fave_processing_modal(processing_text);

                $.ajax({
                    url: ajaxurl,
                    dataType: 'JSON',
                    method: 'POST',
                    data: {
                        'action' : 'houzez_currency_converter',
                        'currency_converter' : selectedCurrencyCode
                    },
                    success: function (res) {
                        if( res.success ) {
                            window.location.reload( true );
                        } else {
                            console.log( res );
                        }
                    },
                    error: function (xhr, status, error) {
                        var err = eval("(" + xhr.responseText + ")");
                        console.log(err.Message);
                    }
                });

            }

        });
    }

    /* ------------------------------------------------------------------------ */
    /* tooltip
    /* ------------------------------------------------------------------------ */
    $('[data-toggle="tooltip"]').tooltip()

    /* ------------------------------------------------------------------------ */
    /* prevent advanced search dropdowns from closing on clicks
    /* ------------------------------------------------------------------------ */
    $('.advanced-search-dropdown').on('click', function (e) {
        e.stopPropagation();
    });

    /* ------------------------------------------------------------------------ */
    /* agent phone number
    /* ------------------------------------------------------------------------ */
    $('.agent-show-onClick').on('click', function (e) {
        $(this).toggleClass('agent-phone-hidden');
    });

    /* ------------------------------------------------------------------------ */
    /*  drop down menus
    /* ------------------------------------------------------------------------ */
    $('.dropdown-menu span.dropdown-toggle').on('click', function(e) {
      if (!$(this).next().hasClass('show')) {
            $(this).parents('.dropdown-menu').first().find('.show').removeClass('show');
        }
        var $subMenu = $(this).next('.dropdown-menu');
        $subMenu.toggleClass('show');


        $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
            $('.dropdown-submenu .show').removeClass('show');
        });


        return false;
    });

    /* ------------------------------------------------------------------------ */
    /*  avoid zoom when double click on mobile devices
    /* ------------------------------------------------------------------------ */
    $.fn.nodoubletapzoom = function () {
        $(this).bind('touchstart', function preventZoom(e) {
            var t2 = e.timeStamp,
                t1 = $(this).data('lastTouch') || t2,
                dt = t2 - t1,
                fingers = e.originalEvent.touches.length;
            $(this).data('lastTouch', t2);
            if (!dt || dt > 500 || fingers > 1) return;

            e.preventDefault();
            $(this).trigger('click').trigger('click');
        });
    };


    /* ------------------------------------------------------------------------ */
    /*  mobile menu
    /* ------------------------------------------------------------------------ */
    // disable touch
    if($('.nav-mobile').length > 0 ) {
        var slideout_left = new Slideout({
            'panel': document.getElementById('main-wrap'),
            'menu': document.getElementById('nav-mobile'),
            'padding': 256,
            'tolerance': 70,
            'side': 'left',
            'easing': 'cubic-bezier(.32,2,.55,.27)'
        });
        slideout_left.disableTouch();
    }

    if($('#main-wrap').length > 0 ) {
        var slideout_right = new Slideout({
            'panel': document.getElementById('main-wrap'),
            'menu': document.getElementById('navi-user'),
            'padding': 256,
            'tolerance': 70,
            'side': 'right',
            'easing': 'cubic-bezier(.32,2,.55,.27)'
        });
        slideout_right.disableTouch();
    }

    // Toggle button
    $('.toggle-button-left, #nav-mobile .nav-link:not(.dropdown-toggle)').on('click', function () {
        slideout_left.toggle();
        $('.slideout-menu-left').toggleClass('open');
    });
    $('.toggle-button-right').on('click', function () {
        slideout_right.toggle();
        $('.slideout-menu-right').toggleClass('open');
    });

    /* ---------------------------------------------------- */
    /*  Fixed mobile header 
     /* ---------------------------------------------------- */
     /*var fixed = document.querySelector('.fixed-header');

    slideout_left.on('translate', function(translated) {
      fixed.style.transform = 'translateX(' + translated + 'px)';
    });

    slideout_left.on('beforeopen', function () {
      fixed.style.transition = 'transform 300ms ease';
      fixed.style.transform = 'translateX(256px)';
    });

    slideout_left.on('beforeclose', function () {
      fixed.style.transition = 'transform 300ms ease';
      fixed.style.transform = 'translateX(0px)';
    });

    slideout_left.on('open', function () {
      fixed.style.transition = '';
    });

    slideout_left.on('close', function () {
      fixed.style.transition = '';
    });*/


     /* ---------------------------------------------------- */
    /*  Close Menu when click outside
     /* ---------------------------------------------------- */
    $(document).on('mouseup', function (e) { 
        var mobileNavcontainer = $(".nav-mobile");
        var toggleBtnCloseW = $(".toggle-button-left");
        var mobileMenuDiv = $('#nav-mobile');
        

        var toggleBtnCloseL = $(".toggle-button-right");
        var mobileMenuDivL = $('#navi-user');

        if (!mobileNavcontainer.is(e.target) && mobileNavcontainer.has(e.target).length === 0 && mobileMenuDiv.hasClass('open') && !toggleBtnCloseW.is(e.target) && toggleBtnCloseW.has(e.target).length === 0 ) {
            slideout_left.toggle();
            $('.slideout-menu-left').toggleClass('open');
        }

        if (!mobileNavcontainer.is(e.target) && mobileNavcontainer.has(e.target).length === 0 && mobileMenuDivL.hasClass('open') && !toggleBtnCloseL.is(e.target) && toggleBtnCloseL.has(e.target).length === 0 ) {
            slideout_right.toggle();
            $('.slideout-menu-right').toggleClass('open');
        }
    });

    /* ------------------------------------------------------------------------ */
    /*  search distance slider
    /* ------------------------------------------------------------------------ */
    $(function () {
        if($('.distance-range').length > 0) {
            $(".distance-range").slider();
        }
    });
    /* ------------------------------------------------------------------------ */
    /*  parallax
    /* ------------------------------------------------------------------------ */
    var header_parallax = $('.parallax');
    if( header_parallax.length > 0 ) {
        header_parallax.parallaxBackground({
            parallaxBgPosition: "center center",
            parallaxBgRepeat: "no-repeat",
            parallaxBgSize: "cover",
            parallaxSpeed: "0.25",
        });
    }

    /* ------------------------------------------------------------------------ */
    /* mobile search form overlay
    /* ------------------------------------------------------------------------ */
    $(document).ready(function () {
        $(".mobile-search-nav").click(function () {
            $("#overlay-search-advanced-module").toggleClass("open");
        });
    });
    $(document).ready(function () {
        $(".overlay-search-module-close, .overly_is_halfmap .half-map-search-js-btn").click(function () {
            $("#overlay-search-advanced-module").toggleClass("open");
        });
    });

    /* ------------------------------------------------------------------------ */
    /*  half map elements size
    /* ------------------------------------------------------------------------ */
    function setSectionHeight() {
        var window_height = $(window).innerHeight();
        var sections_height = window_height - header_area_height;
        sections_height = sections_height - advanced_search_nav_height;
        sections_height = sections_height - elementor_location_header_height;

        if ($(window).width() >= 767) { 
            $('.half-map-left-wrap, .half-map-right-wrap').css('height', sections_height);
        } else { 
            $('.map-on-right .half-map-right-wrap').css('height', sections_height);
            $('.map-on-right .half-map-left-wrap').css('height', '100vh');
            $('.map-on-left .half-map-right-wrap').css('height', sections_height);
            $('.map-on-left .half-map-left-wrap').css('height', '100vh');
        }
    }
    setSectionHeight();
    $win.on('resize', function () {
        setSectionHeight();
    });

    /* ------------------------------------------------------------------------ */
    /*  listing switch view
    /* ------------------------------------------------------------------------ */
    $('.switch-btn').on("click", function () {
        $('.switch-btn').removeClass('active');
        $(this).addClass('active');
        if ($(this).hasClass('btn-list')) {
            $('.listing-view').removeClass('grid-view').addClass('list-view');
        } else if ($(this).hasClass('btn-grid')) {
            $('.listing-view').removeClass('list-view').addClass('grid-view');
        }
    });
    /* ------------------------------------------------------------------------ */
    /* compare properties
    /* ------------------------------------------------------------------------ */
    $(document).ready(function () {
        $('.show-compare-panel').click(function () {
            $(this).toggleClass('active');
            $('.compare-property-active').addClass('compare-property-active-push-toleft');
            $('#compare-property-panel').addClass('compare-property-panel-open');
            //disableOther( 'show-compare-panel' );
        });
        $('.close-compare-panel').click(function () {
            $(this).toggleClass('active');
            $('.compare-property-active').removeClass('compare-property-active-push-toleft');
            $('#compare-property-panel').removeClass('compare-property-panel-open');
            //disableOther( 'show-compare-panel' );
        });
    });
    /* ------------------------------------------------------------------------ */
    /*  property slider
    /* ------------------------------------------------------------------------ */
    var property_banner_slider = $('.property-slider');
    if( property_banner_slider.length > 0 ) {
        
        var autoplay = property_banner_slider.data('autoplay');
        var slider_loop = property_banner_slider.data('loop');
        var slider_speed = property_banner_slider.data('speed');

        var s_loop = false;
        if(slider_loop == 1) {
            s_loop = true;
        }

        property_banner_slider.slick({
            rtl: houzez_rtl,
            autoplay: autoplay,
            autoplaySpeed: slider_speed,
            lazyLoad: 'ondemand',
            infinite: s_loop,
            speed: 300,
            slidesToShow: 1,
            arrows: true,
            adaptiveHeight: true
        });
    }

    var property_detail_gallery = $('#property-gallery-js');
    if( property_detail_gallery.length > 0 ) { 
        property_detail_gallery.lightSlider({
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
                property_detail_gallery.removeClass('cS-hidden');
            }  
        });
    }

    var lightbox_slider_js = $('#lightbox-slider-js');
    if( lightbox_slider_js.length > 0 ) {
        
        lightbox_slider_js.slick({
            rtl: houzez_rtl,
            lazyLoad: 'ondemand',
            infinite: true,
            speed: 300,
            slidesToShow: 1,
            arrows: true,
            adaptiveHeight: true,
        });

        $('.houzez-trigger-popup-slider-js').on('click', function (e) {
            e.preventDefault();
                
            var slider_num = parseInt( $(this).data('slider-no') );
            setTimeout(function(){ 
                lightbox_slider_js.slick('slickGoTo', slider_num - 1);
            }, 200);
        });

    }

    
    var listing_slider_variable_width = $('.listing-slider-variable-width');
    if( listing_slider_variable_width.length > 0 ) {
        listing_slider_variable_width.slick({
            rtl: houzez_rtl,
            lazyLoad: 'ondemand',
            infinite: true,
            speed: 300,
            slidesToShow: 1,
            centerMode: true,
            variableWidth: true,
            arrows: true,
            adaptiveHeight: true
        });  

        $('.property-detail-v5 #pills-gallery-tab').on('click', function() {
            
            if( !listing_slider_variable_width.hasClass('hz-slick-refreshed') ) {
                listing_slider_variable_width.slick('setPosition');
                listing_slider_variable_width.slick('refresh');
                listing_slider_variable_width.addClass('hz-slick-refreshed');
            }
        });
    }



    /* ------------------------------------------------------------------------ */
    /*  testimonial slider
    /* ------------------------------------------------------------------------ */
    var testimonials_slider_v1 = $('.testimonials-slider-wrap-v1');
    if( testimonials_slider_v1.length > 0 ) {
        
        testimonials_slider_v1.slick({
            rtl: houzez_rtl,
            lazyLoad: 'ondemand',
            infinite: true,
            autoplay: true,
            speed: 300,
            slidesToShow: 1,
            arrows: true,
            adaptiveHeight: true,
            dots: true,
            appendArrows: '.testimonials-module-slider-v1',
            prevArrow: '<button type="button" class="slick-prev btn-primary-outlined">'+prev_text+'</button>',
            nextArrow: '<button type="button" class="slick-next btn-primary-outlined">'+next_text+'</button>',
        });
    }

    var testimonials_slider_v2 = $('.testimonials-slider-wrap-v2');
    if( testimonials_slider_v2.length > 0 ) {
        testimonials_slider_v2.slick({
            rtl: houzez_rtl,
            lazyLoad: 'ondemand',
            infinite: true,
            autoplay: true,
            speed: 300,
            slidesToShow: 3,
            arrows: true,
            adaptiveHeight: true,
            dots: true,
            appendArrows: '.testimonials-module-slider-v2',
            prevArrow: '<button type="button" class="slick-prev btn-primary-outlined">'+prev_text+'</button>',
            nextArrow: '<button type="button" class="slick-next btn-primary-outlined">'+next_text+'</button>',
            responsive: [{
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 769,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });
    }
    
    /* ------------------------------------------------------------------------ */
    /*  partners slider
    /* ------------------------------------------------------------------------ */
    var partners_carousel = $('.partners-slider-wrap');
    if( partners_carousel.length > 0 ) {
        partners_carousel.slick({
            rtl: houzez_rtl,
            lazyLoad: 'ondemand',
            infinite: true,
            speed: 300,
            slidesToShow: 4,
            arrows: true,
            adaptiveHeight: true,
            dots: true,
            appendArrows: '.partners-module-slider',
            prevArrow: $('.partner-prev-js'),
            nextArrow: $('.partner-next-js'),
            responsive: [{
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 769,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });
    }
    
    /* ------------------------------------------------------------------------ */
    /*  featured property widget
    /* ------------------------------------------------------------------------ */
    var widget_featured_carousel = $('.widget-featured-property-slider');
    if( widget_featured_carousel.length > 0 ) {
        widget_featured_carousel.slick({
            rtl: houzez_rtl,
            speed: 300,
            slidesToShow: 1,
            arrows: true,
            adaptiveHeight: true,
            dots: true,
            responsive: [{
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 769,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });
    }


    /* ------------------------------------------------------------------------ */
    /*  half maps listing layout 
    /* ------------------------------------------------------------------------ */
    function homy_half_map_switch_listing_layout() {
        if ($(window).width() < 1200) {
            $('.half-map-wrap .listing-view').removeClass('list-view').addClass('grid-view');
        } else if ($(window).width() > 1200) {
            $('.half-map-wrap .listing-view').removeClass('grid-view').addClass('list-view');
        }
    }
    if(houzez_vars.halfmap_layout == 'list-view') {
        homy_half_map_switch_listing_layout();
        $win.on('resize', function () {
            homy_half_map_switch_listing_layout();
        });
        $win.bind('load', function () {
            homy_half_map_switch_listing_layout();
        });
    }

    /* ------------------------------------------------------------------------ */
    /*  property lightbox
    /* ------------------------------------------------------------------------ */
    $(document).ready(function () {
        $('.btn-expand').click(function () {
            $('.lightbox-gallery-wrap').toggleClass("lightbox-gallery-full-wrap");
            $('#lightbox-slider-js').slick('refresh');
        });
        $('.btn-email').click(function () {
            $('.lightbox-form-wrap').toggleClass("lightbox-form-wrap-show");
        });
    });

    /* ------------------------------------------------------------------------ */
    /*  property navigation
    /* ------------------------------------------------------------------------ */
    var houzez_listing_nav = $('.property-navigation-wrap');
    
    if( houzez_listing_nav.length > 0 ) {
        $(document).scroll(function() {
            var y = $(this).scrollTop();

            houzez_listing_nav.css('top', houzezStickyTop);
            if (y > 300) {
                houzez_listing_nav.fadeIn(250);
            } else {
                houzez_listing_nav.fadeOut(0);
            }
        });

        $(".property-navigation-item a.target").click(function (event) {
            event.preventDefault();
            $("html, body").animate({
                scrollTop: $($(this).attr("href")).offset().top - 84
            }, 500);
        });

        $(window).on('scroll', function () {
            $('.property-section-wrap').each(function () {
                if ($(window).scrollTop() >= $(this).offset().top - 86) {
                    var id = $(this).attr('id');
                    $('.target').removeClass('active');
                    $('.target[href="#' + id + '"]').addClass('active');
                } else if ($(window).scrollTop() <= 0) {
                    $('.target').removeClass('active');
                }
            });
        });
    }

    /* ------------------------------------------------------------------------ */
    /*  availability calendar cells height
    /* ------------------------------------------------------------------------ */
    function setCalendarCellHeight() {
        var calendarCellWidth = $('.block-availability-calendars .search-calendar li').innerWidth();
        $('.block-availability-calendars .search-calendar li').css('height', calendarCellWidth);
        $('.block-availability-calendars .search-calendar li').css('line-height', calendarCellWidth + 'px');
    }
    setCalendarCellHeight();
    $win.on('resize', function () {
        setCalendarCellHeight();
    });

    /* ------------------------------------------------------------------------ */
    /* login and register links
    /* ------------------------------------------------------------------------ */
    $('.login-link a').on('click', function () {
        $('.modal-toggle-1').addClass("active");
        $('.modal-toggle-2').removeClass("active");
        $('.register-form-tab').removeClass("active").removeClass("show");
        $('.login-form-tab').addClass("active").addClass("show");
    });
    $('.register-link a').click(function () {
        $('.modal-toggle-2').addClass("active");
        $('.modal-toggle-1').removeClass("active");
        $('.register-form-tab').addClass("active").addClass("show");
        $('.login-form-tab').removeClass("active").removeClass("show");
    });
    
    /* ------------------------------------------------------------------------ */
    /* datepicker
    /* ------------------------------------------------------------------------ */
    if($('.db_input_date').length > 0) { 
        $('.db_input_date').datepicker({
            format : "yyyy-mm-dd",
            clearBtn: true,
            autoclose: true,
            language: houzez_date_language
        });
    }

    
    /* ------------------------------------------------------------------------ */
    /* custom scroll bars
    /* ------------------------------------------------------------------------ */
    if (houzez_is_mobile) {
        //console.log('You are using a mobile device!');
    } else {

        if( $('.deals-table-wrap').length > 0 ) {
            $('.deals-table-wrap').overlayScrollbars({
                overflowBehavior: {
                    x: "scroll",
                    y: "scroll"
                },
            });
        }

    }

    /* ------------------------------------------------------------------------ */
    /*  sticky search bar
    /* ------------------------------------------------------------------------ */
    var listing_nav_area_height = $('.property-navigation-wrap').innerHeight();
    if( listing_nav_area_height == null ) {
        listing_nav_area_height = 0;
    }
    if( $('.houzez_sticky').length > 0 ) {
        $('.houzez_sticky').theiaStickySidebar({
            additionalMarginTop: houzezStickyTop + advanced_search_nav_height + listing_nav_area_height,
            minWidth: 768,
            updateSidebarHeight: false
        });
    }
    

    /* ------------------------------------------------------------------------ */
    /* masonry blog
    /* ------------------------------------------------------------------------ */
    
    /**
     * Set appropriate spanning to any masonry item
     *
     * Get different properties we already set for the masonry, calculate 
     * height or spanning for any cell of the masonry grid based on its 
     * content-wrapper's height, the (row) gap of the grid, and the size 
     * of the implicit row tracks.
     *
     * @param item Object A brick/tile/cell inside the masonry
     */
    function resizeMasonryItem(item) {
        /* Get the grid object, its row-gap, and the size of its implicit rows */
        var grid = document.getElementsByClassName('masonry')[0],
            rowGap = parseInt(window.getComputedStyle(grid).getPropertyValue('grid-row-gap')),
            rowHeight = parseInt(window.getComputedStyle(grid).getPropertyValue('grid-auto-rows'));

        /*
         * Spanning for any brick = S
         * Grid's row-gap = G
         * Size of grid's implicitly create row-track = R
         * Height of item content = H
         * Net height of the item = H1 = H + G
         * Net height of the implicit row-track = T = G + R
         * S = H1 / T
         */
        var rowSpan = Math.ceil((item.querySelector('.masonry-content').getBoundingClientRect().height + rowGap) / (rowHeight + rowGap));

        /* Set the spanning as calculated above (S) */
        item.style.gridRowEnd = 'span ' + rowSpan;
    }

    /**
     * Apply spanning to all the masonry items
     *
     * Loop through all the items and apply the spanning to them using 
     * `resizeMasonryItem()` function.
     *
     * @uses resizeMasonryItem
     */
    function resizeAllMasonryItems() {
        // Get all item class objects in one list
        var allItems = document.getElementsByClassName('masonry-brick');

        /*
         * Loop through the above list and execute the spanning function to
         * each list-item (i.e. each masonry item)
         */
        for (var i = 0; i > allItems.length; i++) {
            resizeMasonryItem(allItems[i]);
        }
    }

    /**
     * Resize the items when all the images inside the masonry grid 
     * finish loading. This will ensure that all the content inside our
     * masonry items is visible.
     *
     * @uses ImagesLoaded
     * @uses resizeMasonryItem
     */

    if( $('.page-template-blog-masonry').length > 0 ) { 
        var waitForImages = function() {
            var allItems = document.getElementsByClassName('masonry-brick');
            for (var i = 0; i < allItems.length; i++) {
                imagesLoaded(allItems[i], function (instance) {
                    var item = instance.elements[0];
                    resizeMasonryItem(item);
                });
            }
        }

        /* Resize all the grid items on the load and resize events */
        var masonryEvents = ['load', 'resize'];
        masonryEvents.forEach(function (event) {
            window.addEventListener(event, resizeAllMasonryItems);
        });

        /* Do a resize once more when all the images finish loading */
        waitForImages();
    }

    /* ------------------------------------------------------------------------ */
    /*  splash page slider 
    /* ------------------------------------------------------------------------ */
    var splash_slider_wrap = $('.splash-slider-wrap');
    if(splash_slider_wrap.length > 0) {
        splash_slider_wrap.slick({
            rtl: houzez_rtl,
            lazyLoad: 'ondemand',
            adaptiveHeight: true,
            autoplay: true,
            infinite: true,
            speed: 300,
            fade: true,
            slidesToShow: 1,
            arrows: false,
        });
    }

    /*--------------------------------------------------------------------------
     *   Add or remove favorites
     * -------------------------------------------------------------------------*/
    houzez_init_add_favorite(ajaxurl, userID);
    houzez_init_remove_favorite(ajaxurl, userID);

    /* ------------------------------------------------------------------------ */
    /*  GET WINDOWS WIDTH HEIGHT
     /* ------------------------------------------------------------------------ */
    function getWindowWidth() {
        return Math.max( $(window).width(), window.innerWidth);
    }

    function getWindowHeight() {
        return Math.max( $(window).height(), window.innerHeight);
    }

    /* ------------------------------------------------------------------------ */
    /* WooCommerce Pay
    /* ------------------------------------------------------------------------ */
    $('.houzez-woocommerce-pay').on('click', function(e) {
        e.preventDefault();

        let listID = $(this).data('listid');
        let is_featured = $(this).data('featured');

        fave_processing_modal( processing_text );

        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                'action': 'houzez_perlist_woo_pay',
                'listing_id': listID,
                'is_featured': is_featured,
            },
            success: function(data) { 
                if ( data.success != false ) {
                    window.location.href= houzez_vars.woo_checkout_url;
                } else {
                    jQuery('#fave_modal').modal('hide');
                }
            },
            error: function(errorThrown) {

            }
        }); // $.ajax

    });

    /* ------------------------------------------------------------------------ */
    /* WooCommerce Pay Package
    /* ------------------------------------------------------------------------ */
    $('.houzez-woocommerce-package').on('click', function(e) {
        e.preventDefault();

        if( parseInt( userID, 10 ) === 0 || userID == undefined) {
            
            jQuery('#login-register-form').modal('show');
            jQuery('.login-form-tab').addClass('active show');
            jQuery('.modal-toggle-1.nav-link').addClass('active');

        } else {
            let packid = $(this).data('packid');

            fave_processing_modal( processing_text );

            $.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    'action': 'houzez_woo_pay_package',
                    'package_id': packid
                },
                success: function(data) { 
                    if ( data.success != false ) {
                        window.location.href= houzez_vars.woo_checkout_url;
                    } else {
                        jQuery('#fave_modal').modal('hide');
                    }
                },
                error: function(errorThrown) {

                }
            }); // $.ajax

        } // login

    });

    /* ------------------------------------------------------------------------ */
    /* Top Banner Full Screen
    /* ------------------------------------------------------------------------ */
    var setTopBannerFullScreen = function() {
        var totalTopBarsHeight = 0;
        var searchH = 0;
        var topBarH = 0;
        var totalBannerHeight = 0;
        var window_height = $(window).innerHeight();
        var admin_bar = $('#wpadminbar');
        var topBarB = $('.top-bar-wrap');
        var admin_bar_height = admin_bar.outerHeight();
        searchH = (window_height-header_area_height);  

        if( header_area.hasClass('header-transparent-wrap') ) {
            if( topBarB.length ) {
                topBarH = topBarB.outerHeight();
            }
            totalBannerHeight =  getWindowHeight() - (topBarH + admin_bar_height);

        } else {

            if( header_area.length && advanced_search_nav.length && !advanced_search_nav.hasClass('search-hidden')) {
                totalTopBarsHeight = parseInt(header_area_height) + parseInt(advanced_search_nav_height);

            } else if(header_area.length) {
                totalTopBarsHeight = parseInt(header_area_height);

            }
            totalBannerHeight =  getWindowHeight() - (totalTopBarsHeight + admin_bar_height);
        }

        $('.top-banner-wrap-fullscreen').css( 'height', totalBannerHeight );
    }

    if( !houzez_is_splash && $('.top-banner-wrap-fullscreen').length > 0 ) {
        $(document).ready(function() {
            setTopBannerFullScreen();
        });

        $(window).on('resize', function () {
            setTopBannerFullScreen();
        });
    }


    /* ------------------------------------------------------------------------ */
    /* compare Listings
    /* ------------------------------------------------------------------------ */
    $(document).ready(function() {    
        $('.compare-property-label').on('click', function() {
            $(this).toggleClass('active');
            $('.compare-property-active').addClass('compare-property-active-push-toleft' );
            $('#compare-property-panel').addClass('compare-property-panel-open');
        });
        $('.close-compare-panel').on('click', function() {
            $(this).toggleClass('active');
            $('.compare-property-active').removeClass('compare-property-active-push-toleft' );
            $('#compare-property-panel').removeClass('compare-property-panel-open');
        });
        var listings_compare = houzezGetCookie('houzez_compare_listings');

        var limit_item_compare = 4;
        add_to_compare(compare_url, compare_add_icon, compare_remove_icon, add_compare_text, remove_compare_text, compare_limit, listings_compare, limit_item_compare );
        remove_from_compare(listings_compare, compare_add_icon, compare_remove_icon, add_compare_text, remove_compare_text);

    });

    /*--------------------------------------------------------------------------
     *   Compare for ajax
     * -------------------------------------------------------------------------*/
    function compare_for_ajax() {
        var listings_compare = houzezGetCookie('houzez_compare_listings');
        var limit_item_compare = 4;
        add_to_compare(compare_url, compare_add_icon, compare_remove_icon, add_compare_text, remove_compare_text, compare_limit, listings_compare, limit_item_compare );
        remove_from_compare(listings_compare, compare_add_icon, compare_remove_icon, add_compare_text, remove_compare_text);
    }

})(jQuery);

/* ------------------------------------------------------------------------ */
/*  houzez Cookie
/* ------------------------------------------------------------------------ */
function houzezSetCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
};

function houzezGetCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
};

function fave_processing_modal( msg ) {
    var process_modal ='<div class="modal fade" id="fave_modal" tabindex="-1" role="dialog" aria-labelledby="faveModalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-body houzez_messages_modal">'+msg+'</div></div></div></div></div>';
    jQuery('body').append(process_modal);
    jQuery('#fave_modal').modal();
}

function fave_processing_modal_close( ) {
    jQuery('#fave_modal').modal('hide');
}

/*--------------------------------------------------------------------------
*   Listing Preview
* -------------------------------------------------------------------------*/
function houzez_listing_lightbox(ajaxurl, processing_text, houzez_rtl, userID) {
        
    jQuery('.hz-show-lightbox-js').on('click', function() {

        var listing_id = jQuery(this).data('listid');
        var $parents = jQuery(this).parents('.item-wrap');
        var preview_loader = $parents.find('.preview_loader');

        jQuery.ajax({
            type: 'post',
            url: ajaxurl,
            data: {
                'action': 'load_lightbox_content',
                'listing_id': listing_id
            },
            beforeSend: function( ) {
                preview_loader.empty().append(''
                    +'<div class="houzez-overlay-loading">'
                    +'<div class="overlay-placeholder">'
                    +'<div class="loader-ripple spinner">'
                    +'<div class="bounce1"></div>'
                    +'<div class="bounce2"></div>'
                    +'<div class="bounce3"></div>'
                    +'</div>'
                    +'</div>'
                    +'</div>'
                );
            },
            complete: function(){
                preview_loader.empty();
            },
            success: function( response ) {
                
                jQuery('#hz-listing-model-content').html(response);

                jQuery('#houzez-listing-lightbox').modal('show'); 

                jQuery('.lightbox-slider').not('.slick-initialized').slick({
                    rtl: houzez_rtl,
                    lazyLoad: 'ondemand',
                    infinite: true,
                    speed: 300,
                    slidesToShow: 1,
                    arrows: true,
                    adaptiveHeight: true,
                });

                jQuery('#houzez-listing-lightbox').on('shown.bs.modal', function (e) {
                    jQuery('.lightbox-slider').slick('setPosition');
                    jQuery('.lightbox-slider').slick('refresh');
                });
                

                jQuery('.btn-expand').on('click', function () {
                    jQuery('.lightbox-gallery-wrap').toggleClass("lightbox-gallery-full-wrap");
                    jQuery('.lightbox-slider').slick('setPosition');
                    
                });

                jQuery('.btn-email').on('click', function () {
                    jQuery('.lightbox-form-wrap').toggleClass("lightbox-form-wrap-show");
                });

                houzez_init_add_favorite(ajaxurl, userID);
                houzez_init_remove_favorite(ajaxurl, userID);

            },
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                console.log(err.Message);
            }
        })

    });
}

/*--------------------------------------------------------------------------
*   Add or remove favorites
* -------------------------------------------------------------------------*/
function houzez_init_add_favorite(ajaxurl, userID) {
    jQuery(".add-favorite-js").on('click', function (e) {
        e.preventDefault();
        var curnt = jQuery(this);
        var listID = jQuery(this).attr('data-listid');
        add_to_favorite( ajaxurl, listID, curnt, userID );
        return false;
    });
}

function houzez_init_remove_favorite(ajaxurl, userID) {
    jQuery(".remove_fav").on('click', function () {
        var curnt = jQuery(this);
        var listID = jQuery(this).attr('data-listid');
        add_to_favorite( ajaxurl, listID, curnt, userID );
        var itemWrap = curnt.parents('tr').remove();
    });
}

function add_to_favorite( ajaxurl, listID, curnt, userID ) {
    if( parseInt( userID, 10 ) === 0 || userID == undefined) {
        jQuery('#login-register-form').modal('show');
        jQuery('.login-form-tab').addClass('active show');
        jQuery('.modal-toggle-1.nav-link').addClass('active');
    } else {

        var $parents = curnt.parents('.item-wrap');
        var preview_loader = $parents.find('.preview_loader');

        jQuery.ajax({
            type: 'post',
            url: ajaxurl,
            dataType: 'json',
            data: {
                'action': 'houzez_add_to_favorite',
                'listing_id': listID
            },
            beforeSend: function( ) {
                preview_loader.empty().append(''
                    +'<div class="houzez-overlay-loading">'
                    +'<div class="overlay-placeholder">'
                    +'<div class="loader-ripple spinner">'
                    +'<div class="bounce1"></div>'
                    +'<div class="bounce2"></div>'
                    +'<div class="bounce3"></div>'
                    +'</div>'
                    +'</div>'
                    +'</div>'
                );
            },
            complete: function(){
                preview_loader.empty();
            },
            success: function( data ) {
                if( data.added ) {
                    curnt.children('i').addClass('text-danger');
                } else {
                    curnt.children('i').removeClass('text-danger');
                }
                preview_loader.empty();
            },
            complete: function(){

            },
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                console.log(err.Message);
            }
        });
    } // End else
}


function add_to_compare(compare_url, compare_add_icon, compare_remove_icon, add_compare_text, remove_compare_text, compare_limit, listings_compare, limit_item_compare) {
    jQuery('a.compare-btn').attr('href', compare_url + '?ids=' + houzezGetCookie('houzez_compare_listings'));

    var listings_compare = houzezGetCookie('houzez_compare_listings');

    if (listings_compare.length > 0) {
        jQuery('.compare-property-label').fadeIn(1000);
    }

    if(listings_compare && listings_compare.length){
        listings_compare = listings_compare.split(',');
        if(listings_compare.length){
            for(var i = 0 ; i < listings_compare.length; i++){
                jQuery( '.houzez_compare[data-listing_id="'+listings_compare[i]+'"] i').removeClass('icon-add-circle').addClass('icon-subtract-circle');
                jQuery( '.houzez_compare[data-listing_id="'+listings_compare[i]+'"]').attr('title', remove_compare_text);
            }
            jQuery('.compare-property-label').find('.compare-count').html(listings_compare.length);
        }

        jQuery('.houzez_compare').tooltip('hide').attr('data-original-title', remove_compare_text);

    }else{
        listings_compare = [];
    }
    jQuery( '.houzez_compare' ).on('click', function(e) {
        e.preventDefault();

        var listings_compare = houzezGetCookie('houzez_compare_listings');

        if(listings_compare && listings_compare.length) {
            listings_compare = listings_compare.split(',');
        } else {
            listings_compare = [];
        }

        var listing_id = jQuery( this ).data( 'listing_id' );
        var index = listings_compare.indexOf( listing_id.toString() );
        var image_div = jQuery(this).parents('.item-wrap');
        var thumb_url = image_div.find('img').attr('src');

        if( index == -1 ){
            if(listings_compare.length >= limit_item_compare){
                alert(compare_limit);
            }else{ 

                jQuery('.compare-wrap').append('<div class="compare-item remove-'+listing_id+'"><a href="" class="remove-compare remove-icon" data-listing_id="'+listing_id+'"><i class="houzez-icon icon-remove-circle"></i></a><img class="img-fluid" src="'+thumb_url+'" width="200" height="150" alt="Thumb"></div>');

                jQuery(this).attr('title', remove_compare_text);
                jQuery(this).tooltip('dispose').tooltip('show');
                jQuery(this).find('i').removeClass('icon-add-circle').addClass('icon-subtract-circle');
                listings_compare.push(listing_id.toString());
                houzezSetCookie('houzez_compare_listings', listings_compare.join(','), 30);
                jQuery('.compare-property-label').find('.compare-count').html(listings_compare.length);
                jQuery('a.compare-btn').attr('href', compare_url + '?ids=' + houzezGetCookie('houzez_compare_listings'));
                jQuery('.compare-property-label').fadeIn(1000);
                jQuery(this).toggleClass('active');
                jQuery('.compare-property-active').addClass('compare-property-active-push-toleft' );
                jQuery('#compare-property-panel').addClass('compare-property-panel-open');

                remove_from_compare(listings_compare, compare_add_icon, compare_remove_icon, add_compare_text, remove_compare_text);
            }
        }else{

            jQuery('div.remove-'+listing_id).remove();
            jQuery(this).attr('title', add_compare_text);
            jQuery(this).tooltip('dispose').tooltip('show');
            jQuery(this).find('i').removeClass('icon-subtract-circle').addClass('icon-add-circle');
            listings_compare.splice(index, 1);
            houzezSetCookie('houzez_compare_listings', listings_compare.join(','), 30);
            jQuery('.compare-property-label').find('.compare-count').html(listings_compare.length);
            jQuery('a.compare-btn').attr('href', compare_url + '?ids=' + houzezGetCookie('houzez_compare_listings'));
            
            if (listings_compare.length > 0) {
                jQuery('.compare-property-label').fadeIn(1000);
                jQuery(this).toggleClass('active');
                jQuery('.compare-property-active').addClass('compare-property-active-push-toleft' );
                jQuery('#compare-property-panel').addClass('compare-property-panel-open');
            } else {
                jQuery('.compare-property-label').fadeOut(1000);
            }
        }
        return false;
        
    });
}


function remove_from_compare(listings_compare, compare_add_icon, compare_remove_icon, add_compare_text, remove_compare_text) {
    jQuery('.remove-compare').on('click', function(e){
        e.preventDefault();
        
        if(typeof listings_compare == 'object') {
    
            listings_compare = listings_compare.toString();
        }

        if(listings_compare && listings_compare.length){
            listings_compare = listings_compare.split(',');
            if(listings_compare.length){
                
                jQuery('.compare-property-label').find('.compare-count').html(listings_compare.length);
            }
        }else{
            listings_compare = [];
        }

        var listing_id = jQuery( this ).data( 'listing_id' );
        var index = listings_compare.indexOf( listing_id.toString() );
        listings_compare.splice(index, 1);
        houzezSetCookie('houzez_compare_listings', listings_compare.join(','), 30);
        jQuery('.compare-property-label').find('.compare-count').html(listings_compare.length);

        jQuery('.compare-'+listing_id).attr('title', add_compare_text);
        jQuery('.compare-'+listing_id).tooltip('hide').attr('data-original-title', add_compare_text);
        jQuery('.compare-'+listing_id).find('i').removeClass('icon-subtract-circle').addClass('icon-add-circle');
        jQuery(this).parents('.compare-item').remove();
    });
}