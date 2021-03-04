<?php
global $settings;
$prop_id = houzez_get_listing_data('property_id');
if( !empty( $prop_id ) ) {
    echo '<li>
            <strong>'.esc_attr($settings['id_title']).'</strong> 
            <span>'.houzez_propperty_id_prefix($prop_id).'</span>
        </li>';
}