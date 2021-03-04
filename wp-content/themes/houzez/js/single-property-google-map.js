/*
* Show map on single property 
*/
jQuery( function($) {
	'use strict';

	if ( typeof houzez_single_property_map !== "undefined" ) {

		if($('#houzez-single-listing-map').length <= 0) {
            return;
        }
		var houzezMap;
		var mapBounds;
        var streetCount = 0;
        var show_map = 0;
        var mapZoom = 15;
        var panorama = null;
        var google_map_style = '';
        var showCircle = false;
		var closeIcon = "";
        var map_pin_type = 'marker';
		var infoWindowPlac = "";
		var markerPricePins = 'no';
		var mapType = 'roadmap';
    

        if ( ( typeof houzez_map_options !== "undefined" ) ) {
			closeIcon = houzez_map_options.closeIcon;
			infoWindowPlac = houzez_map_options.infoWindowPlac;
			markerPricePins = houzez_map_options.markerPricePins;
			mapType = houzez_map_options.map_type;
            map_pin_type = houzez_map_options.map_pin_type;
            google_map_style = houzez_map_options.googlemap_stype;
            show_map = houzez_map_options.show_map;

            if(show_map == 0) {
                return;
            }

            if(map_pin_type == 'circle') {
                showCircle = true; 
            }

            if( houzez_map_options.single_map_zoom > 0 ) {
                mapZoom = parseInt(houzez_map_options.single_map_zoom);
            }

            if(google_map_style!='') {
                google_map_style = JSON.parse ( google_map_style );
            }
            
		}

        var propertyLatLng = new google.maps.LatLng( houzez_single_property_map.lat, houzez_single_property_map.lng );
		var mapOptions = {
            center: propertyLatLng,
			zoom : mapZoom,
            disableDefaultUI: false,
            scrollwheel : false
        };
        
        var panoramaOptions = {
            position: propertyLatLng,
            pov: {
                heading: 34,
                pitch: 10
            }
        };

        houzezMap = new google.maps.Map( document.getElementById( "houzez-single-listing-map" ), mapOptions );

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

        var houzezMapCircle = function(houzezMap) {
            var Circle = new google.maps.Circle({
                strokeColor: '#4f5962',
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: '#4f5962',
                fillOpacity: 0.35,
                map: houzezMap,
                center: propertyLatLng,
                radius: 0.3 * 1000
            });
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

        var remove_map_loader = function() {
            google.maps.event.addListener(houzezMap, 'tilesloaded', function() {
                jQuery('.houzez-map-loading').hide();
            });
        }
        remove_map_loader();

        $('a[href="#pills-street-view"]').on('shown.bs.tab', function () {
            streetCount += 1;
            if(streetCount <= 1) {
                panorama = new google.maps.StreetViewPanorama(document.getElementById('pills-street-view'), panoramaOptions);
            }
        });

        if(showCircle) {
            houzezMapCircle(houzezMap);
        }

        if(!showCircle) {
            if( markerPricePins == 'yes' ) {
                var pricePin = '<div data-id="'+houzez_single_property_map.property_id+'" class="gm-marker gm-marker-color-'+houzez_single_property_map.term_id+'"><div class="gm-marker-price">'+houzez_single_property_map.pricePin+'</div></div>';
        
                var marker = new RichMarker({
                  map: houzezMap,
                  position: propertyLatLng,
                  draggable: false,
                  flat: true,
                  anchor: RichMarkerPosition.MIDDLE,
                  content: pricePin
                });

            } else {

                var marker_url = houzez_single_property_map.marker;
                var marker_size = new google.maps.Size( 44, 56 );
                if( window.devicePixelRatio > 1.5 ) {
                    if( houzez_single_property_map.retinaMarker ) {
                        marker_url = houzez_single_property_map.retinaMarker;
                        marker_size = new google.maps.Size( 44, 56 );
                    }
                }

                var marker_icon = {
                    url : marker_url,
                    size : marker_size,
                    scaledSize: new google.maps.Size( 44, 56 ),
                };

                var marker = new google.maps.Marker( {
                    position : propertyLatLng,
                    map : houzezMap,
                    icon : marker_icon,
                    animation : google.maps.Animation.DROP,
                } );
            }
        

            var mainContent = document.createElement( "div" );
            mainContent.className = 'map-info-window';
            var innerHTML = "";

            innerHTML += '<div class="item-wrap">';

                innerHTML += '<div class="item-header">';
    
                    if( houzez_single_property_map.thumbnail ) {
                        innerHTML += '<a class="hover-effect">' + '<img class="img-fluid listing-thumbnail" src="' + infoWindowPlac + '" data-src="' + houzez_single_property_map.thumbnail + '" alt="' + houzez_single_property_map.title + '"/>' + '</a>';
                    } else {
                        innerHTML += '<a class="hover-effect">' + '<img class="img-fluid listing-thumbnail" src="' + infoWindowPlac + '" alt="' + houzez_single_property_map.title + '"/>' + '</a>';
                    }
                innerHTML += '</div>';

                innerHTML += '<div class="item-body flex-grow-1">';
                    innerHTML += '<h2 class="item-title">';
                        innerHTML += '<a>'+houzez_single_property_map.title+'</a>';
                    innerHTML += '</h2>';

                    innerHTML += '<ul class="list-unstyled item-info">';

                    if(houzez_single_property_map.price) {
                        innerHTML += '<li class="item-price">'+houzez_single_property_map.price+'</li>';
                    }

                    if(houzez_single_property_map.property_type) {
                        innerHTML += '<li class="item-type">'+houzez_single_property_map.property_type+'</li>';
                    }
                    
                    innerHTML += '</ul>';

                innerHTML += '</div>';

            innerHTML += '</div>';

            mainContent.innerHTML = innerHTML;

            var infowindow = new google.maps.InfoWindow({
                content: mainContent
            });

            // set infowindow fpr marker
            var houzezMarkerInfoWindow = function ( map, marker, infowindow ) {
                google.maps.event.addListener( marker, 'click', function() {
                    infowindow.open( map, marker );

                    // Add lazy load for info window
                    var infoWindowImage = infowindow.getContent().getElementsByClassName('listing-thumbnail');
                    if ( infoWindowImage.length ) {
                        if ( infoWindowImage[0].dataset.src ) {
                            infoWindowImage[0].src = infoWindowImage[0].dataset.src;
                        }
                    }
                } );
            };
            houzezMarkerInfoWindow( houzezMap, marker, infowindow );
        }

	} // end typeof

} );