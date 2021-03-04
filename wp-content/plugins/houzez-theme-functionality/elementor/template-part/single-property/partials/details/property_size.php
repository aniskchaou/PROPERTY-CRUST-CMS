<?php
global $settings;
$property_size = houzez_get_listing_data('property_size');
if( !empty( $property_size ) ) {
    echo '<li>
            <strong>'.esc_attr($settings['size_title']). '</strong> 
            <span>'.houzez_property_size( 'after' ).'</span>
        </li>';
}