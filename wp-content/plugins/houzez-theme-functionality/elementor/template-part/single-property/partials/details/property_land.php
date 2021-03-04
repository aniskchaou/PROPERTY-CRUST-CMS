<?php
global $settings;
$property_land = houzez_get_listing_data('property_land');
if( !empty( $property_land ) ) {
    echo '<li>
            <strong>'.esc_attr($settings['land_title']). '</strong> 
            <span>'.houzez_property_land_area( 'after' ).'</span>
        </li>';
}