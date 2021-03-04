<?php
global $settings;
$property_garage = houzez_get_listing_data('property_garage');
$garages_label = ($property_garage > 1 ) ? $settings['garages_title'] : $settings['garage_title'];

if( !empty( $property_garage ) ) {
    echo '<li>
            <strong>'.esc_attr($garages_label).'</strong> 
            <span>'.esc_attr( $property_garage ).'</span>
        </li>';
}