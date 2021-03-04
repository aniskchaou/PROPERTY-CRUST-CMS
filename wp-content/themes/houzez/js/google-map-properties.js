/*
* Show properties for header map and half map 
*/
jQuery( function($) {
    'use strict';

    if ( typeof houzez_map_properties !== "undefined" ) {

        if($("#houzez-properties-map").length > 0 ) {
            var houzezMap;
            var mapBounds;
            var hideInfoWindows;
            var markerClusterer = null;
            var markers = new Array();
            var checkOpenedWindows = new Array();
            var clusterIcon = "";
            var map_cluster_enable = 1;
            var clusterer_zoom = 12;
            var closeIcon = "";
            var infoWindowPlac = "";
            var marker_spiderfier = 0;
            var current_marker = 0;
            var current_page = 0;
            var lastClickedMarker;
            var markerPricePins = 'no';
            var googlemap_style = '';
            var mapType = 'roadmap';
            var ajaxurl = houzez_vars.admin_url+ 'admin-ajax.php';
            var userID = houzez_vars.user_id;
            var not_found = houzez_vars.not_found;
            var houzez_rtl = houzez_vars.houzez_rtl;
            var processing_text = houzez_vars.processing_text;
            var compare_url = houzez_vars.compare_url;
            var compare_add_icon = houzez_vars.compare_add_icon;
            var add_compare_text = houzez_vars.add_compare_text;
            var compare_remove_icon = houzez_vars.compare_remove_icon;
            var remove_compare_text = houzez_vars.remove_compare_text;
            var compare_limit = houzez_vars.compare_limit;
            var compare_page_not_found = houzez_vars.compare_page_not_found;
            var for_rent_price_slider = houzez_vars.for_rent_price_slider;
            var search_price_range_min = parseInt( houzez_vars.search_min_price_range );
            var search_price_range_max = parseInt( houzez_vars.search_max_price_range );
            var search_price_range_min_rent = parseInt( houzez_vars.search_min_price_range_for_rent );
            var search_price_range_max_rent = parseInt( houzez_vars.search_max_price_range_for_rent );
            var get_min_price = parseInt( houzez_vars.get_min_price );
            var get_max_price = parseInt( houzez_vars.get_max_price );
            var currency_position = houzez_vars.currency_position;
            var currency_symb = houzez_vars.currency_symbol;
            var thousands_separator = houzez_vars.thousands_separator;
            var is_halfmap = parseInt(houzez_vars.is_halfmap);
            var default_lat = parseFloat(houzez_vars.default_lat);
            var default_long = parseFloat(houzez_vars.default_long);
            var houzez_default_radius = parseInt(houzez_vars.houzez_default_radius);

            var houzez_is_mobile = /ipad|iphone|ipod|android|blackberry|webos|iemobile|windows phone/i.test(navigator.userAgent.toLowerCase());

            if( houzez_rtl == 'yes' ) {
                houzez_rtl = true;
            } else {
                houzez_rtl = false;
            }

            if ( ( typeof houzez_map_options !== "undefined" ) ) {
                clusterIcon = houzez_map_options.clusterIcon;
                map_cluster_enable = houzez_map_options.map_cluster_enable;
                clusterer_zoom = houzez_map_options.clusterer_zoom;
                closeIcon = houzez_map_options.closeIcon;
                infoWindowPlac = houzez_map_options.infoWindowPlac;
                marker_spiderfier = houzez_map_options.marker_spiderfier;
                markerPricePins = houzez_map_options.markerPricePins;
                mapType = houzez_map_options.map_type;
                googlemap_style = houzez_map_options.googlemap_style;

                if(googlemap_style!='') {
                    googlemap_style = JSON.parse ( googlemap_style );
                }
            }

            var mapOptions = {
                zoom : 12,
                maxZoom: 16,
                disableDefaultUI: true,
                scrollwheel : false,
                styles : googlemap_style,
                
            };

            var special_chars = {
                '&amp;': '&',
                '&quot;': '"',
                '&#039;': "'",
                '&#8217;': "’",
                '&#038;': "&",
                '&lt;': '<',
                '&gt;': '>',
                '&#8216;': "‘",
                '&#8230;': "…",
                '&#8221;': '”',
                '&#8211;': "–",
                '&#8212;': "—"
            };

            switch (mapType) {
                case 'hybrid':
                    mapOptions.mapTypeId = google.maps.MapTypeId.HYBRID;
                    break;
                case 'terrain':
                    mapOptions.mapTypeId = google.maps.MapTypeId.TERRAIN;
                    break;
                case 'satellite':
                    mapOptions.mapTypeId = google.maps.MapTypeId.SATELLITE;
                    break;
                default:
                    mapOptions.mapTypeId = google.maps.MapTypeId.ROADMAP;
            }

            houzezMap = new google.maps.Map( document.getElementById( "houzez-properties-map" ), mapOptions );
            mapBounds = new google.maps.LatLngBounds();

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
            
            var houzez_map_next = function(hMap) {
                current_marker++;
                if ( current_marker > markers.length ){
                    current_marker = 1;
                }
                while( markers[current_marker-1].visible===false ){
                    current_marker++;
                    if ( current_marker > markers.length ){
                        current_marker = 1;
                    }
                }
                
                if( markers[current_marker] ) {
                    if ( ! markers[current_marker].getMap() && map_cluster_enable != 0 ){
                        markerClusterer.setMaxZoom(1);
                        markerClusterer.repaint();
                    }
                }
                
                google.maps.event.trigger( markers[current_marker-1], 'click' );

                if(markers[current_marker-1].getPosition() != null) {
                    hMap.panTo(markers[current_marker-1].getPosition());
                }
                

            }

            var houzez_map_prev = function(hMap) {
                current_marker--;
                if (current_marker < 1){
                    current_marker = markers.length;
                }
                while( markers[current_marker-1].visible===false ){
                    current_marker--;
                    if ( current_marker > markers.length ){
                        current_marker = 1;
                    }
                }
                
                if( markers[current_marker] ) {
                    if ( ! markers[current_marker].getMap() && map_cluster_enable != 0 ){
                        markerClusterer.setMaxZoom(1);
                        markerClusterer.repaint();
                    }
                }
               
                google.maps.event.trigger( markers[current_marker-1], 'click');

                if(markers[current_marker-1].getPosition() != null) {
                    hMap.panTo(markers[current_marker-1].getPosition());
                }
            }

            var houzez_map_zoomin = function(hMap) {
                google.maps.event.addDomListener(document.getElementById('listing-mapzoomin'), 'click', function () {
                    var current= parseInt( hMap.getZoom(),10);
                    console.log(current);
                    current++;
                    if(current > 20){
                        current = 20;
                    }
                    hMap.setZoom(current);
                });
            }

            var houzez_map_zoomout = function(hMap) {
                google.maps.event.addDomListener(document.getElementById('listing-mapzoomout'), 'click', function () {
                    var current= parseInt( hMap.getZoom(),10);
                    console.log(current);
                    current--;
                    if(current < 0){
                        current = 0;
                    }
                    hMap.setZoom(current);
                });
            }

            var houzez_change_map_type = function(map_type){

                if(map_type==='roadmap'){
                    houzezMap.setMapTypeId(google.maps.MapTypeId.ROADMAP);
                }else if(map_type==='satellite'){
                    houzezMap.setMapTypeId(google.maps.MapTypeId.SATELLITE);
                }else if(map_type==='hybrid'){
                    houzezMap.setMapTypeId(google.maps.MapTypeId.HYBRID);
                }else if(map_type==='terrain'){
                    houzezMap.setMapTypeId(google.maps.MapTypeId.TERRAIN);
                }
                return false;
            }

            $('.houzezMapType').on('click', function(e){
                e.preventDefault();
                var maptype = $(this).data('maptype');
                houzez_change_map_type(maptype);
            });

            if( document.getElementById('listing-mapzoomin') ) {
                houzez_map_zoomin(houzezMap);
            }
            if( document.getElementById('listing-mapzoomout') ) {
                houzez_map_zoomout(houzezMap);
            }

            $('#houzez-gmap-next').on('click', function(){
                houzez_map_next(houzezMap);
            });

            $('#houzez-gmap-prev').on('click', function(){           
                houzez_map_prev(houzezMap);
            });

            var remove_map_loader = function() { 
                google.maps.event.addListener(houzezMap, 'tilesloaded', function() {
                    jQuery('.houzez-map-loading').hide();
                });
            }
            remove_map_loader();

            var clearClusterer = function() {
                if( map_cluster_enable != 0 && markerClusterer != null) {
                    markerClusterer.clearMarkers();
                }
            }

            var reloadMarkers = function() {
                for (var i=0; i<markers.length; i++) {

                    markers[i].setMap(null);
                }
                // Reset the markers array
                markers = [];
            }

            // Fit Bounds
            var houzez_map_bounds = function() {
                houzezMap.fitBounds( markers.reduce(function(bounds, marker ) {
                    return bounds.extend( marker.getPosition() );
                }, new google.maps.LatLngBounds()));
            }

            // Compare for ajax
            var compare_for_ajax_map = function() {
                var listings_compare = houzezGetCookie('houzez_compare_listings');
                var limit_item_compare = 4;
                add_to_compare(compare_url, compare_add_icon, compare_remove_icon, add_compare_text, remove_compare_text, compare_limit, listings_compare, limit_item_compare );
                remove_from_compare(listings_compare, compare_add_icon, compare_remove_icon, add_compare_text, remove_compare_text);
            }

            /*--------------------------------------------------------------------
            * Add Marker
            *--------------------------------------------------------------------*/
            var houzezAddMarkers = function(map_properties, houzezMap) {

                if(marker_spiderfier != 0) {
                    var oms = new OverlappingMarkerSpiderfier( houzezMap, {
                        markersWontMove : true,
                        markersWontHide : true,
                        keepSpiderfied : true,
                        circleSpiralSwitchover : Infinity,
                        nearbyDistance : 50
                    });
                }

                hideInfoWindows = function() {
                    while( checkOpenedWindows.length > 0 ) {
                        var closeWindow = checkOpenedWindows.pop();
                        closeWindow.close();
                    }
                };

                var houzezMarkerInfoWindow = function ( map, marker, infowindow ) {
                    google.maps.event.addListener( marker, 'click', function() {
                        hideInfoWindows();
                        infowindow.open( map, marker );
                        checkOpenedWindows.push( infowindow );

                        // Add lazy load for info window
                        var infoWindowImage = infowindow.getContent().getElementsByClassName('listing-thumbnail');
                        if ( infoWindowImage.length ) {
                            if ( infoWindowImage[0].dataset.src ) {
                                infoWindowImage[0].src = infoWindowImage[0].dataset.src;
                            }
                        }

                    } );
                };

                for( var i = 0; i < map_properties.length; i++ ) {

                    if ( map_properties[i].lat && map_properties[i].lng ) {

                        if( markerPricePins == 'yes' ) {
                            var pricePin = '<div data-id="'+map_properties[i].property_id+'" class="gm-marker gm-marker-color-'+map_properties[i].term_id+'"><div class="gm-marker-price">'+map_properties[i].pricePin+'</div></div>';
                    
                            var marker = new RichMarker({
                              map: houzezMap,
                              position: new google.maps.LatLng( map_properties[i].lat, map_properties[i].lng ),
                              draggable: false,
                              flat: true,
                              anchor: RichMarkerPosition.MIDDLE,
                              content: pricePin
                            });

                        } else {

                            var marker_url = map_properties[i].marker;
                            var marker_size = new google.maps.Size( 44, 56 );
                            if( window.devicePixelRatio > 1.5 ) {
                                if( map_properties[i].retinaMarker ) {
                                    marker_url = map_properties[i].retinaMarker;
                                    marker_size = new google.maps.Size( 44, 56 );
                                }
                            }

                            var marker_icon = {
                                url : marker_url,
                                size : marker_size,
                                scaledSize: new google.maps.Size( 44, 56 ),
                            };

                            var marker = new google.maps.Marker( {
                                position : new google.maps.LatLng( map_properties[i].lat, map_properties[i].lng ),
                                map : houzezMap,
                                icon : marker_icon,
                                title : map_properties[i].title.replace(/\&[\w\d\#]{2,5}\;/g, function(s) { return special_chars[s]; }),
                                animation : google.maps.Animation.DROP,
                                visible : true
                            } );
                        }

                        //Bounds
                        mapBounds.extend( marker.getPosition() );

                        var mainContent = document.createElement( "div" );
                        mainContent.className = 'map-info-window';
                        var innerHTML = "";

                        innerHTML += '<div class="item-wrap">';

                            innerHTML += '<div class="item-header">';
                
                                if( map_properties[i].thumbnail ) {
                                    innerHTML += '<a class="hover-effect" href="' + map_properties[i].url + '">' + '<img class="img-fluid listing-thumbnail" src="' + infoWindowPlac + '" data-src="' + map_properties[i].thumbnail + '" alt="' + map_properties[i].title + '"/>' + '</a>';
                                } else {
                                    innerHTML += '<a class="hover-effect" href="' + map_properties[i].url + '">' + '<img class="img-fluid listing-thumbnail" src="' + infoWindowPlac + '" alt="' + map_properties[i].title + '"/>' + '</a>';
                                }
                            innerHTML += '</div>';

                            innerHTML += '<div class="item-body flex-grow-1">';
                                innerHTML += '<h2 class="item-title">';
                                    innerHTML += '<a href="' + map_properties[i].url + '">'+map_properties[i].title+'</a>';
                                innerHTML += '</h2>';

                                innerHTML += '<ul class="list-unstyled item-info">';

                                if(map_properties[i].price) {
                                    innerHTML += '<li class="item-price">'+map_properties[i].price+'</li>';
                                }

                                if(map_properties[i].property_type) {
                                    innerHTML += '<li class="item-type">'+map_properties[i].property_type+'</li>';
                                }
                                
                                innerHTML += '</ul>';

                            innerHTML += '</div>';

                        innerHTML += '</div>';

                        mainContent.innerHTML = innerHTML;

                        var infowindow = new google.maps.InfoWindow({
                            content: mainContent
                        });

                        // set infowindow fpr marker
                        houzezMarkerInfoWindow( houzezMap, marker, infowindow );

                        //Add marker spiderfier to markers
                        if(marker_spiderfier != 0) {
                            oms.addMarker( marker );
                        }

                        markers.push(marker);

                    } // end if lat lng

                } // end for loop

                // Map bounds according to markes
                houzezMap.fitBounds( mapBounds );

                // Markers clusters
                if(map_cluster_enable != 0) {
                    var clustererOptions = {
                            ignoreHidden : true, 
                            maxZoom : parseInt(clusterer_zoom), 
                            styles : [{
                                url : clusterIcon,
                                height : 48,
                                width : 48,
                                textColor : '#ffffff',
                            }]
                    };

                    markerClusterer = new MarkerClusterer( houzezMap, markers, clustererOptions );

                } 
                
            } //end houzezAddMarkers


            if ( houzez_map_properties.length > 0 ) {

                houzezAddMarkers(houzez_map_properties, houzezMap);

            } else {

                var defaultLocation = new google.maps.LatLng(default_lat,default_long);
                var mapOptions = {
                    center: defaultLocation,
                    zoom : 10,
                    maxZoom : 16,
                    styles : googlemap_style,
                    disableDefaultUI: true,
                    scrollwheel : false
                };
                houzezMap = new google.maps.Map( document.getElementById( "houzez-properties-map" ), mapOptions );
                jQuery('.houzez-map-loading').hide();

            }

            var InfoboxTrigger = function() {

                $('#half-map-listing-area .item-wrap').each(function(i) {
                    $(this).on('mouseenter', function() {
                        if(houzezMap) {
    
                            if ( ! markers[i].getMap() && map_cluster_enable != 0 ){
                                markerClusterer.setMaxZoom(1);
                                markerClusterer.repaint();
                            }
                            
                            google.maps.event.trigger(markers[i], 'click');
                        }
                    });
                });

                $('#half-map-listing-area .item-wrap').on('mouseleave', function() {
                    hideInfoWindows();
                    if( map_cluster_enable != 0 ) {
                        markerClusterer.setMaxZoom(13);
                        markerClusterer.repaint();
                    }
                    
                });
                return false;
            };

            if( !houzez_is_mobile ) {
                InfoboxTrigger();
            }
            

            /*----------------------------------------------------------
            * Half Map Ajax Search
            *----------------------------------------------------------*/
            var houzez_half_map_listings = function(current_page) {
                var ajax_container = $('#houzez_ajax_container');
                var total_results = $('#half-map-listing-area .page-title span');
                var current_form = $('.houzez-search-form-js');
                var sortby = $('#ajax_sort_properties').val();
                var item_layout = $('.listing-view').data('layout');

                //alert( $('.houzez-keyword-autocomplete').val() );

                $(this).parents('.houzez-search-form-js').addClass('sdfsdfsdffs');

                $.ajax({
                    type: 'GET',
                    dataType: 'json',
                    url: ajaxurl,
                    data: current_form.serialize() + "&action=houzez_half_map_listings&paged="+current_page+"&sortby="+sortby+"&item_layout="+item_layout,
                    beforeSend: function() {
                        $('.houzez-map-loading').show();
                        ajax_container.empty().append(''
                            +'<div id="houzez-map-loading" class="houzez-map-loading">'
                            +'<div class="mapPlaceholder">'
                            +'<div class="loader-ripple spinner">'
                            +'<div class="bounce1"></div>'
                            +'<div class="bounce2"></div>'
                            +'<div class="bounce3"></div>'
                            +'</div>'
                            +'</div>'
                            +'</div>'
                        );
                    },
                    success: function(data) { //alert(JSON.stringify(data.query)); return; 
            
                        if ( data.query != '' ) {
                            $( 'input[name="search_args"]' ).val( data.query );
                        }
                        $('.map-notfound').remove();
                        $('.search-no-results-found').remove();

                        $('.houzez-map-loading').hide();

                        if(data.getProperties === true) {

                           clearClusterer();
                           reloadMarkers();
                           houzezAddMarkers( data.properties, houzezMap );
                           houzez_map_bounds();
                           
                           ajax_container.empty().html(data.propHtml);
                           total_results.empty().html(data.total_results);
                           map_ajax_pagination();

                           houzez_init_add_favorite(ajaxurl, userID);
                           houzez_init_remove_favorite(ajaxurl, userID);
                           houzez_listing_lightbox(ajaxurl, processing_text, houzez_rtl, userID);
                           compare_for_ajax_map();

                           if( !houzez_is_mobile ) {
                                InfoboxTrigger();
                            }

                           $('[data-toggle="tooltip"]').tooltip();

                        } else { 
                            clearClusterer();
                            reloadMarkers();
                            $('#houzez-properties-map').append('<div class="map-notfound">'+not_found+'</div>');
                            ajax_container.empty().html('<div class="search-no-results-found">'+not_found+'</div>');
                            total_results.empty().html(data.total_results);
                        }
                        return false;
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        console.log(xhr.status);
                        console.log(xhr.responseText);
                        console.log(thrownError);
                    }
                });
                return false;
            }

            var houzezSetPushState = (pageUrl) => {
                window.history.pushState({houzezTheme: true}, '', pageUrl);
            }

            var houzez_set_url = () => { 

                var $this = $('form.houzez-search-filters-js');
                var url = $this.attr('action');

                var formData = $this.find(":input").filter(function(index, element) { 

                    if( $(element).val() != '' && $(element).attr('name') != 'search_geolocation' && $(element).attr('name') != 'search_URI' && $(element).attr('name') != 'search_args' && $(element).attr('name') != 'houzez_save_search_ajax' ) {
                        return true;
                    }

                }).serialize();

                if( url.indexOf('?') != -1 ) {
                    url = url + '&' + formData;
                } else{
                    url = url + '?' + formData;
                }

                houzezSetPushState(url);
            }

            var houzez_search_on_change = function(current_page){
                clearClusterer();
                //houzez_set_url(); 
                houzez_half_map_listings(current_page);
            }

            var map_ajax_pagination = function() {
                $('.houzez_ajax_pagination a').on('click', function(e){
                    e.preventDefault();
                    current_page = $(this).data('houzepagi');
                    houzez_search_on_change(current_page);
                })
                return false;
            }
            map_ajax_pagination();

            var map_sorting = function() {
                $('#ajax_sort_properties').on('change', function() {
                    current_page = 0;
                    houzez_search_on_change(current_page);
                });
            }
            map_sorting();

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
                        current_page = 0;
                        houzez_search_on_change(current_page);
                    }
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

            if($( ".price-range").length > 0 && is_halfmap == 1) {
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
            }

            var radius_search_slider = function(default_radius) {
                $("#radius-range-slider").slider(
                    {
                        value: default_radius,
                        min: 0,
                        max: 100,
                        step: 1,
                        value: $('#radius-range-value').data('default'),
                        slide: function (event, ui) {
                            $("#radius-range-text").html(ui.value);
                            $("#radius-range-value").val(ui.value);
                        },
                        stop: function( event, ui ) {

                            if($("#houzez-properties-map").length > 0 ) {
                                current_page = 0;
                                houzez_search_on_change(current_page);
                            }
                        }
                    }
                );

                $("#radius-range-text").html($('#radius-range-slider').slider('value'));
                $("#radius-range-value").val($('#radius-range-slider').slider('value'));
            }

            if($( "#radius-range-slider").length >0) {
                radius_search_slider(houzez_default_radius);
            }


        

            $('select.houzez_search_ajax, input.houzez_search_ajax').on('change', function() {
                current_page = 0;
                houzez_search_on_change(current_page);
            });

            if( $('.half-map-wrap').length > 0 ) {
                $('.btn-apply, .half-map-search-js-btn, #auto_complete_ajax').on('click', function(e) {
                    e.preventDefault();
                    current_page = 0;
                    houzez_search_on_change(current_page);
                })
            }


        }

        $('#houzez-btn-map-view').on('click', function(e) {
            e.preventDefault();
            $('#half-map-listing-area, .listing-wrap').hide();
            $('#map-view-wrap').show();
            google.maps.event.trigger(houzezMap, "resize");
            houzez_map_bounds();
            
        });

        $('#houzez-btn-listing-view').on('click', function(e) {
            e.preventDefault();
            $('#map-view-wrap').hide();
            $('#half-map-listing-area, .listing-wrap').show();

        });


        /*-----------------------------------------------------------------------------------------
        * Auto Complete 
        *-----------------------------------------------------------------------------------------*/
        
        if($( '.hz-map-field-js' ).length > 0) {
            var geo_country_limit = houzez_vars.geo_country_limit;
            var geocomplete_country = houzez_vars.geocomplete_country;
            // Use function construction to store map & DOM elements separately for each instance
            var MapField = function ( $container ) {
                this.$container = $container;
            };

            // Use prototype for better performance
            MapField.prototype = {
                // Initialize everything
                init: function () {
                    this.initDomElements();
                    this.autocomplete();
                },
                // Initialize DOM elements
                initDomElements: function () {
                    this.addressField = this.$container.data( 'address-field' );
                },

                // Autocomplete address
                autocomplete: function () {
                    var that = this,
                        $address = this.addressField;

                    if ( null === $address ) {
                        return;
                    }

                    var options = {
                        types: ["geocode", "establishment"]
                    };

                    var inputField = (document.getElementById($address));
                    var autocomplete = new google.maps.places.Autocomplete(inputField, options);

                    if(geo_country_limit != 0 && geocomplete_country != '') {
                        if(geocomplete_country == 'UAE') {
                            geocomplete_country = "AE";
                        }
                        autocomplete.setComponentRestrictions(
                        {'country': [geocomplete_country]});
                    }

                    google.maps.event.addListener(autocomplete, 'place_changed', function () {
                        var place = autocomplete.getPlace();   
                        var latLng = new google.maps.LatLng( place.geometry.location.lat(), place.geometry.location.lng() );
                        that.updateCoordinate( latLng );

                        if(is_halfmap) {
                            var current_page = 0;
                            houzez_search_on_change(current_page);
                        }
                    });

                },

                // Update coordinate to input field
                updateCoordinate: function ( latLng ) {
                    $('input[name="lat"]').val(latLng.lat());
                    $('input[name="lng"]').val(latLng.lng());
                },

            };

            var initMap = function() { 
                var $this = $( this );
                var controller;

                controller = new MapField( $this );
                controller.init();
            }

            var init = function( e ) {
               $( '.hz-map-field-js' ).each( initMap );
            }
            init();
        } // end auto complete


    } // end typeof

} );