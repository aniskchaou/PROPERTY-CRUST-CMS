<?php
global $settings;
$property_bedrooms = houzez_get_listing_data('property_bedrooms');
$bedrooms_label = ($property_bedrooms > 1 ) ? $settings['bedrooms_title'] : $settings['bedroom_title'];

if( !empty( $property_bedrooms ) ) {
    echo '<li>
            <strong>'.esc_attr($bedrooms_label).'</strong> 
            <span>'.esc_attr( $property_bedrooms ).'</span>
        </li>';
}