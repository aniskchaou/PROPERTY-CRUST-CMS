<?php
global $settings;
$property_type = houzez_taxonomy_simple('property_type');
if( !empty( $property_type ) ) {
    echo '<li>
            <strong>'.esc_attr($settings['type_title']).'</strong> 
            <span>'.esc_attr($property_type).'</span>
        </li>';
}