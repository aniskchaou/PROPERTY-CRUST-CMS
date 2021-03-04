<?php
global $settings;
$property_bathrooms = houzez_get_listing_data('property_bathrooms');
$bathrooms_label = ($property_bathrooms > 1 ) ? $settings['bathrooms_title'] : $settings['bathroom_title'];

if( !empty( $property_bathrooms ) ) {
    echo '<li>
            <strong>'.esc_attr($bathrooms_label).'</strong> 
            <span>'.esc_attr( $property_bathrooms ).'</span>
        </li>';
}