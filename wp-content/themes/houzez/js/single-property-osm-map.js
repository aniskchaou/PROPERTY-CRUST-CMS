/*
* Show map on single property 
*/
jQuery( function($) {
	'use strict';

	if ( typeof houzez_single_property_map !== "undefined" ) {
        var is_mapbox = houzez_vars.is_mapbox;
        var api_mapbox = houzez_vars.api_mapbox;

		if($('#houzez-single-listing-map').length <= 0) {
            return;
        }
		var houzezMap;
		var mapBounds;
        var streetCount = 0;
        var mapZoom = 15;
        var panorama = null;
        var google_map_style = '';
        var showCircle = false;
		var closeIcon = "";
        var map_pin_type = 'marker';
		var infoWindowPlac = "";
		var markerPricePins = 'no';
		var mapType = 'roadmap';
        var propertyMarker;
    
        if ( ( typeof houzez_map_options !== "undefined" ) ) {
			closeIcon = houzez_map_options.closeIcon;
			infoWindowPlac = houzez_map_options.infoWindowPlac;
			markerPricePins = houzez_map_options.markerPricePins;
			mapType = houzez_map_options.map_type;
            map_pin_type = houzez_map_options.map_pin_type;
            google_map_style = houzez_map_options.googlemap_stype;

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

        if ( houzez_single_property_map.lat && houzez_single_property_map.lng ) {

            var mapData = houzez_single_property_map;
            
            if(is_mapbox == 'mapbox' && api_mapbox != '') {

                var tileLayer = L.tileLayer( 'https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token='+api_mapbox, {
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

            var mapCenter = L.latLng( mapData.lat, mapData.lng );

            var mapDragging = true;
            var mapOptions = {
                dragging: mapDragging,
                center: mapCenter,
                zoom: mapZoom,
                zoomControl: true,
                tap: false
            };

            houzezMap = L.map( 'houzez-single-listing-map', mapOptions );
            houzezMap.scrollWheelZoom.disable();
            houzezMap.addLayer( tileLayer );

            var markerOptions = {
                riseOnHover: true
            };

            if ( mapData.title ) {
                markerOptions.title = mapData.title;
            }

            if( showCircle ) {
                var houzezCircle = function(houzezMap) {

                    var Circle = L.circle(mapCenter, 200).addTo(houzezMap);
                }

                houzezCircle(houzezMap);
            }


            if( !showCircle ) {
                if( markerPricePins == 'yes' ) {
                    var pricePin = '<div data-id="'+mapData.property_id+'" class="gm-marker gm-marker-color-'+mapData.term_id+'"><div class="gm-marker-price">'+mapData.pricePin+'</div></div>';

                    var myIcon = L.divIcon({ 
                        className:'someclass',
                        iconSize: new L.Point(0, 0), 
                        html: pricePin
                    });

                    propertyMarker = L.marker( mapCenter,{icon: myIcon} ).addTo( houzezMap );
                    

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

                    propertyMarker = L.marker( mapCenter, markerOptions ).addTo( houzezMap );
                }
            }

            $('a[href="#pills-map"], a[href="#property-address"]').on('shown.bs.tab', function () {
                houzezMap.invalidateSize();
                houzezMap.panTo( houzezMap.getCenter() );
            });

        } // End lat and lng if 

        

	} // end typeof

} );