/*
* Show properties for header map and half map 
*/
jQuery( function($) {
	'use strict';

	if ( typeof houzez_map_properties !== "undefined" ) {
        

		if($("#houzez-properties-map").length > 0 ) {

            var is_mapbox = houzez_vars.is_mapbox;
            var api_mapbox = houzez_vars.api_mapbox;

            var houzezMap;
            var markerClusterer = null;
            var osm_markers_cluster;
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
            var houzez_rtl = houzez_vars.houzez_rtl;
            var processing_text = houzez_vars.processing_text;
            var not_found = houzez_vars.not_found;
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

                
            }

            if(is_mapbox == 'mapbox' && api_mapbox != '') {

                /*var tileLayer = L.tileLayer( 'https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token='+api_mapbox, {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                    maxZoom: 18,
                    id: 'mapbox.streets',
                    accessToken: 'your.mapbox.access.token'
                    } 
                );*/

                var tileLayer = L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token='+api_mapbox, {
                    attribution: '© <a href="https://www.mapbox.com/about/maps/">Mapbox</a> © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> <strong><a href="https://www.mapbox.com/map-feedback/" target="_blank">Improve this map</a></strong>',
                    tileSize: 512,
                    maxZoom: 18,
                    zoomOffset: -1,
                    id: 'mapbox/streets-v11',
                    accessToken: 'YOUR_MAPBOX_ACCESS_TOKEN'
                });

            } else {
                var tileLayer = L.tileLayer( 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution : '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                } );
            }

            var addCommas = (nStr) => {
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
                if( hMap.getZoom() < 15 ){
                    hMap.setZoom(15);
                }
                
                hMap.setView(markers[current_marker - 1].getLatLng());   
                if (! markers[current_marker - 1]._icon) {
                    markers[current_marker - 1].__parent.spiderfy();
                }

                hMap.setZoom(20);
           
                if( (current_marker - 1)==0 || (current_marker - 1)==markers.length ){
                    setTimeout(function(){  markers[current_marker - 1].fire('click');  }, 500); 
                }else{
                    markers[current_marker - 1].fire('click');
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
                if( hMap.getZoom() < 15 ){
                    hMap.setZoom(15);
                }
               
                hMap.setView(markers[current_marker - 1].getLatLng());   
                if (! markers[current_marker - 1]._icon) {
                    markers[current_marker - 1].__parent.spiderfy();
                }

                hMap.setZoom(20);
               
                if( (current_marker - 1)==0 || (current_marker )==markers.length ){
                    setTimeout(function(){  markers[current_marker - 1].fire('click');  }, 500); 
                }else{
                    markers[current_marker - 1].fire('click');
                }
            }

            $('#houzez-gmap-next').on('click', function(){
                houzez_map_next(houzezMap);
            });

            $('#houzez-gmap-prev').on('click', function(){           
                houzez_map_prev(houzezMap);
            });


            var houzez_map_zoomin = function(hMap) {
                $('#listing-mapzoomin').on('click', function() {
                    var current= parseInt( hMap.getZoom(),10);
                    console.log(current);
                    current++;
                    if(current > 20){
                        current = 20;
                    }
                    console.log('=='+current+' ++ ');
                    hMap.setZoom(current);
                });
            }

            var houzez_map_zoomout = function(hMap) {
                $('#listing-mapzoomout').on('click', function() {
                    var current= parseInt( hMap.getZoom(),10);
                    console.log(current);
                    current--;
                    if(current < 0){
                        current = 0;
                    }
                    console.log('=='+current+' -- ');
                    hMap.setZoom(current);
                });
            }

            var reloadOSMMarkers = function() {
                // Loop through markers and set map to null for each
                for (var i=0; i<markers.length; i++) {

                    //markers[i].setMap(null);
                    houzezMap.removeLayer(markers[i]);
                }
                // Reset the markers array
                markers = [];
                if (osm_markers_cluster) {
                    houzezMap.removeLayer(osm_markers_cluster);
                }
            }

            var getMapBounds = function(mapDataProperties) {
                // get map bounds
                var mapBounds = [];
                for( var i = 0; i < mapDataProperties.length; i++ ) {
                    if ( mapDataProperties[i].lat && mapDataProperties[i].lng ) {
                        mapBounds.push( [ mapDataProperties[i].lat, mapDataProperties[i].lng ] );
                    }
                }

                return mapBounds;
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
                var propertyMarker;

                var mBounds = getMapBounds(map_properties);

                if ( 1 < mBounds.length ) {
                    houzezMap.fitBounds( mBounds );
                }

                if(map_cluster_enable == 1) {
                    osm_markers_cluster = new L.MarkerClusterGroup({ 
                        iconCreateFunction: function (cluster) {
                            var markers1 = cluster.getAllChildMarkers();
                            var html = '<div class="houzez-osm-cluster">' + markers1.length + '</div>';
                            return L.divIcon({ html: html, className: 'mycluster', iconSize: L.point(47, 47) });
                        },
                        spiderfyOnMaxZoom: true, showCoverageOnHover: true, zoomToBoundsOnClick: true 
                    });
                }

                for( var i = 0; i < map_properties.length; i++ ) {

                    if ( map_properties[i].lat && map_properties[i].lng ) {

                        var mapData = map_properties[i];

                        var mapCenter = L.latLng( mapData.lat, mapData.lng );

                         var markerOptions = {
                            riseOnHover: true
                        };


                        if ( mapData.title ) {
                            markerOptions.title = mapData.title;
                        }

                        if( markerPricePins == 'yes' ) {
                            var pricePin = '<div data-id="'+map_properties[i].property_id+'" class="gm-marker gm-marker-color-'+map_properties[i].term_id+'"><div class="gm-marker-price">'+map_properties[i].pricePin+'</div></div>';

                            var myIcon = L.divIcon({ 
                                className:'someclass',
                                iconSize: new L.Point(0, 0), 
                                html: pricePin
                            });

                            if(map_cluster_enable == 1) {
                                propertyMarker = new L.Marker(mapCenter, {icon: myIcon});
                            } else {
                                propertyMarker = L.marker( mapCenter,{icon: myIcon} ).addTo( houzezMap );
                            }

                        } else {
                            // Marker icon
                            if ( mapData.marker ) {

                                var iconOptions = {
                                    iconUrl: mapData.marker,
                                    iconSize: [44, 56],
                                    iconAnchor: [20, 57],
                                    popupAnchor: [1, -57]
                                };
                                if ( mapData.retinaMarker ) {
                                    iconOptions.iconRetinaUrl = mapData.retinaMarker;
                                }
                                markerOptions.icon = L.icon( iconOptions );
                            }

                            if(map_cluster_enable == 1) {
                                propertyMarker = new L.Marker(mapCenter, markerOptions);
                            } else {
                                propertyMarker = L.marker( mapCenter, markerOptions ).addTo( houzezMap );
                            }
                        }

                        if(map_cluster_enable == 1) {
                            osm_markers_cluster.addLayer(propertyMarker);
                        }

                        var mainContent = document.createElement( "div" );
                        mainContent.className = 'map-info-window';
                        var innerHTML = "";

                        innerHTML += '<div class="item-wrap">';

                            innerHTML += '<div class="item-header">';
                
                                if( map_properties[i].thumbnail ) {
                                    innerHTML += '<a href="' + map_properties[i].url + '">' + '<img class="img-fluid" src="' + map_properties[i].thumbnail + '" alt="' + map_properties[i].title + '"/>' + '</a>';
                                } else {
                                    innerHTML += '<a href="' + map_properties[i].url + '">' + '<img class="img-fluid" src="' + infoWindowPlac + '" alt="' + map_properties[i].title + '"/>' + '</a>';
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

                        markers.push(propertyMarker);
                        propertyMarker.bindPopup( mainContent );


                    } // end if lat lng

                } // end for loop 

                if(map_cluster_enable == 1) {
                    houzezMap.addLayer(osm_markers_cluster);
                }
                
            } //end houzezAddMarkers

            if ( houzez_map_properties.length > 0 ) {
                
                var mapBounds = getMapBounds(houzez_map_properties);
                // Basic map
                var mapCenter = L.latLng( default_lat, default_long ); 
                if ( 1 == mapBounds.length ) {
                    mapCenter = L.latLng( mapBounds[0] );
                }
                var mapDragging = true;
                var mapOptions = {
                    dragging: mapDragging,
                    center: mapCenter,
                    zoom: 10,
                    tap: true
                };
                houzezMap = L.map( 'houzez-properties-map', mapOptions );

                houzezMap.scrollWheelZoom.disable();

                if ( 1 < mapBounds.length ) {
                    houzezMap.fitBounds( mapBounds ); 
                }

                houzezMap.addLayer( tileLayer );


                if( document.getElementById('listing-mapzoomin') ) {
                    houzez_map_zoomin(houzezMap);
                }
                if( document.getElementById('listing-mapzoomout') ) {
                    houzez_map_zoomout(houzezMap);
                }

                houzezAddMarkers(houzez_map_properties, houzezMap);

            } else {
                
                var fallbackMapOptions = {
                    center : [default_lat, default_long],
                    zoom : 10
                };

                houzezMap = L.map( 'houzez-properties-map', fallbackMapOptions );
                houzezMap.addLayer( tileLayer );
                houzezMap.scrollWheelZoom.disable();

            }

            /*----------------------------------------------------------
            * Half Map Ajax Search
            *----------------------------------------------------------*/
            var houzez_half_map_listings = function(current_page) {
                var ajax_container = $('#houzez_ajax_container');
                var ajax_map_wrap = $('.map-wrap');
                var total_results = $('#half-map-listing-area .page-title span');
                var current_form = $('.houzez-search-form-js');
                var sortby = $('#ajax_sort_properties').val();
                var item_layout = $('.listing-view').data('layout');

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
                        ajax_map_wrap.append(''
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
                    success: function(data) { 
            
                        if ( data.query != '' ) {
                            $( 'input[name="search_args"]' ).val( data.query );
                        }
                        $('.map-notfound').remove();
                        $('.search-no-results-found').remove();

                        $('.houzez-map-loading').hide();

                        if(data.getProperties === true) {

                           reloadOSMMarkers();
                           houzezAddMarkers( data.properties, houzezMap );
                           
                           ajax_container.empty().html(data.propHtml);
                           total_results.empty().html(data.total_results);
                           map_ajax_pagination();

                           houzez_init_add_favorite(ajaxurl, userID);
                           houzez_init_remove_favorite(ajaxurl, userID);
                           houzez_listing_lightbox(ajaxurl, processing_text, houzez_rtl, userID);
                           compare_for_ajax_map();
                           $('[data-toggle="tooltip"]').tooltip();

                        } else { 
                            reloadOSMMarkers();
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
                reloadOSMMarkers();
                //houzez_set_url(); 
                houzez_half_map_listings(current_page);
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

            $('select.houzez_search_ajax, input.houzez_search_ajax').on('change', function() {
                current_page = 0;
                houzez_search_on_change(current_page);
            });

            $('.btn-apply, .half-map-search-js-btn, #auto_complete_ajax').on('click', function(e) {
                e.preventDefault();
                current_page = 0;
                houzez_search_on_change(current_page);
            })

        } // #houzez-properties-map").length


        $('#houzez-gmap-full-osm').on('click', function() {
            var $this = $(this);
            if($this.hasClass('active')) {
                $this.removeClass('active');
                $this.parents('.map-wrap').removeClass('houzez-fullscreen-map');
            } else {
                $this.parents('.map-wrap').addClass('houzez-fullscreen-map');
                $this.addClass('active');
            }
            houzezMap.invalidateSize();
            houzezMap.panTo( houzezMap.getCenter() );
            
        });

        $('#houzez-btn-map-view').on('click', function(e) {
            e.preventDefault();
            $('#half-map-listing-area, .listing-wrap').hide();
            $('#map-view-wrap').show();
            houzezMap.invalidateSize();
            houzezMap.panTo( houzezMap.getCenter() );
            var mBounds = getMapBounds(houzez_map_properties);

            if ( 1 < mBounds.length ) {
                houzezMap.fitBounds( mBounds );
            }

        });

        $('#houzez-btn-listing-view').on('click', function(e) {
            e.preventDefault();
            $('#map-view-wrap').hide();
            $('#half-map-listing-area, .listing-wrap').show();

        });

        /*-----------------------------------------------------------------------------------------
        * Auto Complete 
        *-----------------------------------------------------------------------------------------*/
        if( $("input.search_location_js").length > 0 ) {
            jQuery('input.search_location_js').autocomplete( {
                                 
                source: function ( request, response ) {
                        jQuery.get( 'https://nominatim.openstreetmap.org/search', {
                                format: 'json',
                                q: request.term,//was q
                                //addressdetails:'1',
                        }, function( result ) {
                           
                                if ( !result.length ) {
                                    response( [ {
                                        value: '',
                                        label: 'there are no results'
                                    } ] );
                                    return;
                                }
                                response( result.map( function ( place ) {
                                        return {
                                                label: place.display_name,
                                                latitude: place.lat,
                                                longitude: place.lon,
                                                value: place.display_name,

                                        };
                                } ) );
                        }, 'json' );
                },
                select: function ( event, ui ) {
                    
                    $('input[name="lat"]').val(ui.item.latitude);
                    $('input[name="lng"]').val(ui.item.longitude);

                    if(is_halfmap) {
                        var current_page = 0;
                        houzez_search_on_change(current_page);
                    }

                }
            });
        } // Auto complete

	} // end typeof

} );