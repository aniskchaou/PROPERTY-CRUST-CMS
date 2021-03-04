( function( $ ) {
    'use strict';

    
    window.houzezOpenStreetMapElementor = function(mapID , propertiesData , mapOptions ) {

        if ( typeof propertiesData !== "undefined" ) {

            if (0 < propertiesData.length) {

                var houzezMap;
                var mapBounds;
                var hideInfoWindows;
                var osm_markers_cluster;
                var markerClusterer = null;
                var markers = new Array();
                var checkOpenedWindows = new Array();
                var closeIcon = "";
                var marker_spiderfier = 0;
                var current_marker = 0;
                var current_page = 0;
                var lastClickedMarker;
                var markerPricePins = 'no';
    
                var mapbox_api_key = mapOptions.mapbox_api_key;
                var zoom_control = mapOptions.zoomControl;
                var infoWindowPlac = mapOptions.infoWindowPlac;
                var clusterIcon = mapOptions.clusterIcon;
                var clusterer_zoom = mapOptions.clusterer_zoom;

                var hGet_boolean = function(data) {
                    if(data == 'yes') {
                        return true;
                    }
                    return false;
                }

                var map_cluster_enable = hGet_boolean(mapOptions.mapCluster);


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

                if( mapbox_api_key != '' ) {

                    var tileLayer = L.tileLayer( 'https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token='+mapbox_api_key, {
                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                        maxZoom: 18,
                        id: 'mapbox.streets',
                        accessToken: 'your.mapbox.access.token'
                        } 
                    );

                } else {
                    var tileLayer = L.tileLayer( 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution : '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                    } );
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
                

                /*--------------------------------------------------------------------
                * Add Marker
                *--------------------------------------------------------------------*/
                var houzezAddMarkers = function(map_properties, houzezMap) {
                    var propertyMarker;

                    var mBounds = getMapBounds(map_properties);

                    if ( 1 < mBounds.length ) {
                        houzezMap.fitBounds( mBounds );
                    }

                    if( map_cluster_enable ) {
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

                if ( propertiesData.length > 0 ) {
                    
                    var mapBounds = getMapBounds(propertiesData);
                    // Basic map
                    var mapCenter = L.latLng( 25.686540,-80.431345 ); 
                    if ( 1 == mapBounds.length ) {
                        mapCenter = L.latLng( mapBounds[0] );
                    }
                    var mapDragging = true;
                    var mapOptions = {
                        dragging: mapDragging,
                        center: mapCenter,
                        zoomControl: hGet_boolean(zoom_control),
                        zoom: 10,
                        tap: true
                    };
                    houzezMap = L.map( document.getElementById( mapID ), mapOptions );

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

                    houzezAddMarkers(propertiesData, houzezMap);

                } else {
                    
                    var fallbackMapOptions = {
                        center : [25.686540,-80.431345],
                        zoom : 10
                    };

                    houzezMap = L.map( document.getElementById( mapID ), fallbackMapOptions );
                    houzezMap.addLayer( tileLayer );
                    houzezMap.scrollWheelZoom.disable();

                }
                


            }
        }
    }
    
} )( jQuery );