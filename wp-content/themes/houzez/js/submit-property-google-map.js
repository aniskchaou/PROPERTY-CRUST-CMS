/**
 * Open street map for submit property
 */
jQuery(document).ready( function($) {
    "use strict";

    var geo_country_limit = houzez_vars.geo_country_limit;
    var geocomplete_country = houzez_vars.geocomplete_country;
    var is_edit_property = houzez_vars.is_edit_property;
    var map;
    var marker;

    var componentForm_listing = {
        locality: 'long_name',
        administrative_area_level_1: 'long_name',
        country: 'long_name',
        postal_code: 'short_name',
        neighborhood: 'long_name',
        sublocality_level_1: 'long_name',
        political: 'long_name'
    };

    if (document.getElementById('geocomplete')) {
        var inputField, defaultBounds, autocomplete;
        inputField = (document.getElementById('geocomplete'));
        defaultBounds = new google.maps.LatLngBounds(
            new google.maps.LatLng(-90, -180),
            new google.maps.LatLng(90, 180)
        );

        var options = {
            bounds: defaultBounds,
            types: ["geocode", "establishment"],
        };

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
        
        map = new google.maps.Map(document.getElementById('map_canvas'), {
          center: {lat: maplat, lng: maplong},
          streetViewControl: 0,
          mapTypeId: window.google.maps.MapTypeId.ROADMAP
        });

        if (is_edit_property) {
            var latlng = {lat: parseFloat(maplat), lng: parseFloat(maplong)};
            marker = new google.maps.Marker({
                position: latlng,
                map: map,
                draggable: true
            });
            map.setZoom(16);
        } else {
            marker = new google.maps.Marker({
              map: map,
              draggable: true,
              anchorPoint: new google.maps.Point(0, -29)
            });
            map.setZoom(13); 
        }

        autocomplete = new google.maps.places.Autocomplete(inputField, options);

        if(geo_country_limit != 0 && geocomplete_country != '') {
            if(geocomplete_country == 'UAE') {
                geocomplete_country = "AE";
            }
            autocomplete.setComponentRestrictions(
            {'country': [geocomplete_country]});
        }

        autocomplete.bindTo('bounds', map);

        var geocoder = new google.maps.Geocoder();

        //drag marker
        window.google.maps.event.addListener(marker, 'drag', function(marker){
            var latLng = marker.latLng; 
            var currentLatitude = latLng.lat();
            var currentLongitude = latLng.lng();
            $("#latitude").val(currentLatitude);
            $("#longitude").val(currentLongitude);
         }); 


        google.maps.event.addListener(autocomplete, 'place_changed', function () {
            var place = autocomplete.getPlace();  
            fillInAddress_for_form(place);

            marker.setVisible(false);
            //var place = autocomplete.getPlace();
            if (!place.geometry) {
                // User entered the name of a Place that was not suggested and
                // pressed the Enter key, or the Place Details request failed.
                window.alert("No details available for input: '" + place.name + "'");
                return;
            }

            // If the place has a geometry, then present it on a map.
            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(17);  // Why 17? Because it looks good.
            }
            marker.setPosition(place.geometry.location);
            marker.setVisible(true);

            console.log(place);
        
        });
    }

    function homey_geocodeAddress(geocoder, resultsMap, marker) {
        var lat = document.getElementById('latitude').value;
        var lng = document.getElementById('longitude').value;
        var latlng = {lat: parseFloat(lat), lng: parseFloat(lng)};

        geocoder.geocode({'location': latlng}, function(results, status) {
          if (status === 'OK') {
            var i, has_city, addressType, val;
    
            has_city = 0;

            $('#city').val('');
            $('#countyState').val('');
            $('#zip').val('');
            $('#neighborhood').val('');
            $('#country').val('');

            document.getElementById('latitude').value = results[0].geometry.location.lat();
            document.getElementById('longitude').value = results[0].geometry.location.lng();
            document.getElementById('geocomplete').value = results[0].formatted_address;

            // Get each component of the address from the result details
            // and fill the corresponding field on the form.
            for (i = 0; i < results[0].address_components.length; i++) {
                addressType = results[0].address_components[i].types[0];
                val = results[0].address_components[i][componentForm_listing[addressType]];
                 
                if (addressType === 'neighborhood') {
                    $('#neighborhood').val(val);

                } else if (addressType === 'political' || addressType === 'locality' || addressType === 'sublocality_level_1') {
            
                    $('#city').val(val);
                    if(val !== '') {
                        has_city = 1;
                    }
                } else if(addressType === 'country') {
                    $('#country').val(val);

                } else if(addressType === 'postal_code') {
                    $('#zip').val(val);

                } else if(addressType === 'administrative_area_level_1') {
                    $('#countyState').val(val);
                }
            }

            if(has_city === 0) {
                get_new_city_2('city', results[0].adr_address);
            }

            // If the place has a geometry, then present it on a map.
            if (results[0].geometry.viewport) {
                resultsMap.fitBounds(results[0].geometry.viewport);
            } else {
                resultsMap.setCenter(results[0].geometry.location);
                resultsMap.setZoom(17);  // Why 17? Because it looks good.
            }
            marker.setPosition(results[0].geometry.location);
            marker.setVisible(true);
            console.log(results);

          } else {
            alert(geo_coding_msg +': '+ status);
          }
        });
    }


    function fillInAddress_for_form(place) {
        var i, has_city, addressType, val;
    
        has_city = 0;
    
        $('#city').val('');
        $('#countyState').val('');
        $('#zip').val('');
        $('#neighborhood').val('');
        $('#country').val('');

        $('#city, #countyState, #neighborhood, #country').selectpicker('refresh');

        document.getElementById('latitude').value = place.geometry.location.lat();
        document.getElementById('longitude').value = place.geometry.location.lng();
        
        // Get each component of the address from the place details
        // and fill the corresponding field on the form.
        for (i = 0; i < place.address_components.length; i++) {
            addressType = place.address_components[i].types[0];
            val = place.address_components[i][componentForm_listing[addressType]];

             
            if (addressType === 'neighborhood') {
                $('#neighborhood').val(val);

            } else if (addressType === 'locality') {
        
                $('#city').val(val);
                if(val !== '') {
                    has_city = 1;
                }
            } else if(addressType === 'country') {
                $('#country').val(val);

            } else if(addressType === 'postal_code') {
                $('#zip').val(val);

            } else if(addressType === 'administrative_area_level_1') {
                $('#countyState').val(val);
            }
        }

        $('#address-place').html(place.adr_address);
        
        if(has_city === 0) {
            get_new_city_2('city', place.adr_address);
        }
    }

    function get_new_city_2(stringplace, adr_address) {
        var new_city;
        new_city = $(adr_address).filter('span.locality').html() ;
        $('#'+stringplace).val(new_city);
    }


    jQuery('#find_coordinates').on('click', function(e) {
        e.preventDefault();

        var address = document.getElementById('geocomplete').value;
        var city    =  jQuery("#city").val();

        var full_addr= address+','+city;
        if(document.getElementById('countyState')) {
            var state = document.getElementById('countyState').value;
            if(state) {
                full_addr = full_addr +','+state;
            }
        }

        if(document.getElementById('country')) {
            var country  = document.getElementById('country').value;
            if(country) {
                full_addr = full_addr +','+country;
            }
        }   


        geocoder.geocode( { 'address': full_addr}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                    marker.setVisible(false);
                    map.setCenter(results[0].geometry.location);
                    marker.setPosition(results[0].geometry.location);
                    marker.setVisible(true);

                    
                    document.getElementById("latitude").value=results[0].geometry.location.lat();
                    document.getElementById("longitude").value=results[0].geometry.location.lng();
            } else {
                    //alert(status);
            }
        });

    });  

    

});