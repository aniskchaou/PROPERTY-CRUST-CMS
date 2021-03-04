/**
 * Open street map for submit property
 */
jQuery(document).ready( function($) {
    "use strict";

    var houzezOSM;
    var mapMarker = '';
    var is_mapbox = houzezProperty.is_mapbox;
    var api_mapbox = houzezProperty.api_mapbox;

    var houzezOSMTileLayerSubmit = function() {
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
        return tileLayer;
    }

    var houzez_osm_marker_position = function(lat, long) {
        var mapCenter       = L.latLng( lat, long );
        var markerCenter    = L.latLng(mapCenter);
          houzezOSM.removeLayer( mapMarker );

          // Marker
        var osmMarkerOptions = {
            riseOnHover: true,
            draggable: true 
        };
        mapMarker = L.marker( mapCenter, osmMarkerOptions ).addTo( houzezOSM );
    }

    var houzez_init_submit_map = function() {
      
       if( jQuery('#map_canvas').length === 0 ) {
           return;
       }
        

        var mapDiv = $('#map_canvas');
        var maplat = mapDiv.data('add-lat');
        var maplong = mapDiv.data('add-long');

        if(maplat ==='' || typeof  maplat === 'undefined') {
            maplat = 25.686540;
        }   

        if(maplong ==='' || typeof  maplong === 'undefined') {
            maplong = -80.431345;
        }

        maplat = parseFloat(maplat);
        maplong = parseFloat(maplong);
            
        var mapCenter = L.latLng( maplat, maplong );
        houzezOSM =  L.map( 'map_canvas',{
            center: mapCenter, 
            zoom: 15,
        });

        houzezOSM.scrollWheelZoom.disable();

        var tileLayer =  houzezOSMTileLayerSubmit();
        houzezOSM.addLayer( tileLayer );

        // Marker
        var osmMarkerOptions = {
            riseOnHover: true,
            draggable: true 
        };
        mapMarker = L.marker( mapCenter, osmMarkerOptions ).addTo( houzezOSM );

        mapMarker.on('drag', function(e){
            document.getElementById('latitude').value = mapMarker.getLatLng().lat;
            document.getElementById('longitude').value = mapMarker.getLatLng().lng;
        });
        
    } // End houzez_init_submit_map
    houzez_init_submit_map();

    var houzez_osm_marker_position = function(lat, long) {
        var latLng = L.latLng( lat, long );
        mapMarker.setLatLng( latLng );

        houzezOSM.invalidateSize();
        houzezOSM.panTo(new L.LatLng(lat,long)); 

        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = long;
    }

    var houzez_find_address_osm = function() {
        $('#find_coordinates').on('click', function(e) {
            event.preventDefault();
            var address = $('#geocomplete').val().replace( /\n/g, ',' ).replace( /,,/g, ',' );

            if(!address) {
                return;
            }

            $.get( 'https://nominatim.openstreetmap.org/search', {
                format: 'json',
                q: address,
                limit: 1,
            }, function( result ) {
                if ( result.length !== 1 ) {
                    return;
                }
                houzez_osm_marker_position(result[0].lat, result[0].lon);

            }, 'json' );
            
        })
    }
    houzez_find_address_osm();

    var houzez_submit_autocomplete = function() {

        jQuery('#geocomplete').autocomplete( {
            source: function ( request, response ) {
                jQuery.get( 'https://nominatim.openstreetmap.org/search', {
                    format: 'json',
                    q: request.term,
                    addressdetails:'1',
                }, function( result ) {
                    if ( !result.length ) {
                        response( [ {
                            value: '',
                            label: 'there are no results'
                        } ] );
                        return;
                    }
                    response( result.map( function ( item ) {
                       var return_obj= {
                            label: item.display_name,
                            latitude: item.lat,
                            longitude: item.lon,
                            value: item.display_name,
                        };
                        

                        if(typeof(item.address) != 'undefined') {
                            return_obj.county = item.address.county;
                        }
                        
                        if(typeof(item.address) != 'undefined') {
                            return_obj.city = item.address.city;
                        }
                        
                        if(typeof(item.address) != 'undefined') {
                            return_obj.state=item.address.state;
                        }
                        
                        if(typeof(item.address) != 'undefined') {
                            return_obj.country=item.address.country;
                        }
                        
                        if(typeof(item.address) != 'undefined') {
                            return_obj.zip=item.address.postcode;
                        }

                        if(typeof(item.address) != 'undefined') {
                            return_obj.country_short=item.address.country_code;
                        }
                        
                        return return_obj                                   
                    }));
                }, 'json' );
            },
            select: function ( event, ui ) {
                             
                var property_lat     =   ui.item.latitude;
                var property_long    =   ui.item.longitude;

                $('#zip').val( ui.item.zip );
                $('#countyState').val( ui.item.county);
                $('#city').val( ui.item.city);
                $('#country').val( ui.item.country);
                $('input[name="country_short"]').val( ui.item.country_short);
                houzez_osm_marker_position(property_lat, property_long);
                $('#city, #countyState, #neighborhood, #country').selectpicker('refresh');
            }
        } );

    } // end houzez_submit_autocomplete
    houzez_submit_autocomplete();

});