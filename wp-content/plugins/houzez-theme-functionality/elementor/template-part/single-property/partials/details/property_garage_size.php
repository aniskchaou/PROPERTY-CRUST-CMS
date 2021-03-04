<?php
global $settings;
$property_garage_size = houzez_get_listing_data('property_garage_size');
if( !empty( $property_garage_size ) ) {
    echo '<li>
            <strong>'.esc_attr($settings['garage_size_title']).'</strong> 
            <span>'.esc_attr($property_garage_size).'</span>
        </li>';
}