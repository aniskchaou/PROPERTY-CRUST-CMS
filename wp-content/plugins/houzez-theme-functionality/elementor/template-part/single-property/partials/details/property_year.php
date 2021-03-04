<?php
global $settings;
$property_year = houzez_get_listing_data('property_year');
if( !empty( $property_year ) ) {
    echo '<li>
            <strong>'.esc_attr($settings['year_title']).'</strong> 
            <span>'.esc_attr($property_year).'</span>
        </li>';
}