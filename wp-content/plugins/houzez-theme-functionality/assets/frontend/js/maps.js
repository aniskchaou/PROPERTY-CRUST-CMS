( function( $ ) {
    'use strict';

    window.houzezGoogleMapElementor = function(mapID , propertiesData , mapOptions ) {

        if ( typeof propertiesData !== "undefined" ) {

            if (0 < propertiesData.length) {

                var houzezMap;
                var mapBounds;
                var hideInfoWindows;
                var markerClusterer = null;
                var markers = new Array();
                var checkOpenedWindows = new Array();
                var closeIcon = "";
                var marker_spiderfier = 0;
                var current_marker = 0;
                var current_page = 0;
                var lastClickedMarker;
                var markerPricePins = 'no';
    
                var zoom_control = mapOptions.zoomControl;
                var mapTypeControl = mapOptions.mapTypeControl;
                var streetViewControl = mapOptions.streetViewControl;
                var fullscreenControl = mapOptions.fullscreenControl;
                var infoWindowPlac = mapOptions.infoWindowPlac;
                var clusterIcon = mapOptions.clusterIcon;
                var clusterer_zoom = mapOptions.clusterer_zoom;
                var mapType = mapOptions.map_type;
                var googlemap_style = mapOptions.map_style;

                var hGet_boolean = function(data) {
                    if(data == 'yes') {
                        return true;
                    }
                    return false;
                }

                var map_cluster_enable = hGet_boolean(mapOptions.mapCluster);

                var mapOptions = {
                    zoom : 12,
                    maxZoom: 16,
                    scrollwheel : false,
                    zoomControl : hGet_boolean(zoom_control),
                    mapTypeControl : hGet_boolean(mapTypeControl),
                    streetViewControl : hGet_boolean(streetViewControl),
                    fullscreenControl : hGet_boolean(fullscreenControl),
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


                if (undefined !== googlemap_style && googlemap_style != '') {
                    mapOptions.styles = JSON.parse(googlemap_style);
                }

                houzezMap = new google.maps.Map( document.getElementById( mapID ), mapOptions );
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

                // Fit Bounds
                var houzez_map_bounds = function() {
                    houzezMap.fitBounds( markers.reduce(function(bounds, marker ) {
                        return bounds.extend( marker.getPosition() );
                    }, new google.maps.LatLngBounds()));
                }

                /*--------------------------------------------------------------------
                * Add Marker
                *--------------------------------------------------------------------*/
                var houzezAddMarkers = function(map_properties, houzezMap) {

                    /*if(marker_spiderfier != 0) {
                        var oms = new OverlappingMarkerSpiderfier( houzezMap, {
                            markersWontMove : true,
                            markersWontHide : true,
                            keepSpiderfied : true,
                            circleSpiralSwitchover : Infinity,
                            nearbyDistance : 50
                        });
                    }*/

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
                                        innerHTML += '<a class="hover-effect" href="' + map_properties[i].url + '">' + '<img class="img-fluid listing-thumbnail 11" src="' + infoWindowPlac + '" data-src="' + map_properties[i].thumbnail + '" alt="' + map_properties[i].title + '"/>' + '</a>';
                                    } else {
                                        innerHTML += '<a class="hover-effect" href="' + map_properties[i].url + '">' + '<img class="img-fluid listing-thumbnail 222" src="' + infoWindowPlac + '" alt="' + map_properties[i].title + '"/>' + '</a>';
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


                if ( propertiesData.length > 0 ) {

                    houzezAddMarkers(propertiesData, houzezMap);

                } else {
                    
                    var defaultLocation = new google.maps.LatLng(25.686540,-80.431345);
                    var mapOptions = {
                        center: defaultLocation,
                        zoom : 10,
                        maxZoom : 16,
                        disableDefaultUI: true,
                        scrollwheel : false
                    };
                    var defaultMap = new google.maps.Map( document.getElementById( mapID ), mapOptions );

                }


            }
        }
    }


} )( jQuery );