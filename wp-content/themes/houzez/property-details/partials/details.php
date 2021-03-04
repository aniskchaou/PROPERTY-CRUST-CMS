<?php
global $hide_fields;
$prop_id = houzez_get_listing_data('property_id');
$prop_price = houzez_get_listing_data('property_price');
$prop_size = houzez_get_listing_data('property_size');
$land_area = houzez_get_listing_data('property_land');
$bedrooms = houzez_get_listing_data('property_bedrooms');
$rooms = houzez_get_listing_data('property_rooms');
$bathrooms = houzez_get_listing_data('property_bathrooms');
$year_built = houzez_get_listing_data('property_year');
$garage = houzez_get_listing_data('property_garage');
$property_status = houzez_taxonomy_simple('property_status');
$property_type = houzez_taxonomy_simple('property_type');
$garage_size = houzez_get_listing_data('property_garage_size');
$additional_features = get_post_meta( get_the_ID(), 'additional_features', true);
?>
<div class="detail-wrap">
	<ul class="<?php echo houzez_option('prop_details_cols', 'list-2-cols'); ?> list-unstyled">
		<?php
        if( !empty( $prop_id ) && $hide_fields['prop_id'] != 1 ) {
            echo '<li>
	                <strong>'.houzez_option('spl_prop_id', 'Property ID').':</strong> 
	                <span>'.houzez_propperty_id_prefix($prop_id).'</span>
                </li>';
        }

        if( !empty( $prop_price ) && $hide_fields['sale_rent_price'] != 1 ) {
            echo '<li>
	                <strong>'.houzez_option('spl_price', 'Price'). ':</strong> 
	                <span>'.houzez_listing_price().'</span>
                </li>';
        }

        if( !empty( $prop_size ) && $hide_fields['area_size'] != 1 ) {
            echo '<li>
	                <strong>'.houzez_option('spl_prop_size', 'Property Size'). ':</strong> 
	                <span>'.houzez_property_size( 'after' ).'</span>
                </li>';
        }

        if( !empty( $land_area ) && $hide_fields['land_area'] != 1 ) {
            echo '<li>
	                <strong>'.houzez_option('spl_land', 'Land Area'). ':</strong> 
	                <span>'.houzez_property_land_area( 'after' ).'</span>
                </li>';
        }
        if( !empty( $bedrooms ) && $hide_fields['bedrooms'] != 1 ) {
            $bedrooms_label = ($bedrooms > 1 ) ? houzez_option('spl_bedrooms', 'Bedrooms') : houzez_option('spl_bedroom', 'Bedroom');

            echo '<li>
	                <strong>'.esc_attr($bedrooms_label).':</strong> 
	                <span>'.esc_attr( $bedrooms ).'</span>
                </li>';
        }
        if( !empty( $rooms ) && $hide_fields['rooms'] != 1 ) {
            $rooms_label = ($rooms > 1 ) ? houzez_option('spl_rooms', 'Rooms') : houzez_option('spl_room', 'Room');

            echo '<li>
                    <strong>'.esc_attr($rooms_label).':</strong> 
                    <span>'.esc_attr( $rooms ).'</span>
                </li>';
        }
        if( !empty( $bathrooms ) && $hide_fields['bathrooms'] != 1 ) {

            $bath_label = ($bathrooms > 1 ) ? houzez_option('spl_bathrooms', 'Bathrooms') : houzez_option('spl_bathroom', 'Bathroom');
            echo '<li>
	                <strong>'.esc_attr($bath_label).':</strong> 
	                <span>'.esc_attr( $bathrooms ).'</span>
                </li>';
        }
        if( $garage != "" && $hide_fields['garages'] != 1 ) {

            $garage_label = ($garage > 1 ) ? houzez_option('spl_garages', 'Garages') : houzez_option('spl_garage', 'Garage');
            echo '<li>
	                <strong>'.esc_attr($garage_label).':</strong> 
	                <span>'.esc_attr( $garage ).'</span>
                </li>';
        }
        if( !empty( $garage_size ) && $hide_fields['garages'] != 1 ) {
            echo '<li>
	                <strong>'.houzez_option('spl_garage_size', 'Garage Size').':</strong> 
	                <span>'.esc_attr( $garage_size ).'</span>
                </li>';
        }
        if( !empty( $year_built ) && $hide_fields['year_built'] != 1 ) {
            echo '<li>
	                <strong>'.houzez_option('spl_year_built', 'Year Built').':</strong> 
	                <span>'.esc_attr( $year_built ).'</span>
                </li>';
        }
        if( !empty( $property_type ) && ($hide_fields['prop_type']) != 1 ) {
            echo '<li class="prop_type">
	                <strong>'.houzez_option('spl_prop_type', 'Property Type').':</strong> 
	                <span>'.esc_attr( $property_type ).'</span>
                </li>';
        }
        if( !empty( $property_status ) && ($hide_fields['prop_status']) != 1 ) {
            echo '<li class="prop_status">
	                <strong>'.houzez_option('spl_prop_status', 'Property Status').':</strong> 
	                <span>'.esc_attr( $property_status ).'</span>
                </li>';
        }

        //Custom Fields
        if(class_exists('Houzez_Fields_Builder')) {
        $fields_array = Houzez_Fields_Builder::get_form_fields(); 

            if(!empty($fields_array)) {
                foreach ( $fields_array as $value ) {

                    $field_type = $value->type;
                    $meta_type = true;

                    if( $field_type == 'checkbox_list' || $field_type == 'multiselect' ) {
                        $meta_type = false;
                    }

                    $data_value = get_post_meta( get_the_ID(), 'fave_'.$value->field_id, $meta_type );
                    $field_title = $value->label;
                    $field_id = houzez_clean_20($value->field_id);
                    
                    $field_title = houzez_wpml_translate_single_string($field_title);

                    if( $meta_type == true ) {
                        $data_value = houzez_wpml_translate_single_string($data_value);
                    } else {
                        $data_value = houzez_array_to_comma($data_value);
                    }

                    if(!empty($data_value) && $hide_fields[$field_id] != 1) {
                        echo '<li class="'.esc_attr($field_id).'"><strong>'.esc_attr($field_title).':</strong> <span>'.esc_attr( $data_value ).'</span></li>';
                    }
                }
            }
        }
        ?>
	</ul>
</div>

<?php if( !empty( $additional_features[0]['fave_additional_feature_title'] ) && $hide_fields['additional_details'] != 1 ) { ?>
	<div class="block-title-wrap">
		<h3><?php echo houzez_option('sps_additional_details', 'Additional details'); ?></h3>
	</div><!-- block-title-wrap -->
	<ul class="list-2-cols list-unstyled">
		<?php
        foreach( $additional_features as $ad_del ):
            echo '<li><strong>'.esc_attr( $ad_del['fave_additional_feature_title'] ).':</strong> <span>'.esc_attr( $ad_del['fave_additional_feature_value'] ).'</span></li>';
        endforeach;
        ?>
	</ul>	
<?php } ?>