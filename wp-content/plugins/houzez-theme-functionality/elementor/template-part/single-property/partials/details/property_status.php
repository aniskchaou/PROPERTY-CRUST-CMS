<?php
global $settings;
$property_status = houzez_taxonomy_simple('property_status');
if( !empty( $property_status ) ) {
    echo '<li>
            <strong>'.esc_attr($settings['status_title']).'</strong> 
            <span>'.esc_attr($property_status).'</span>
        </li>';
}