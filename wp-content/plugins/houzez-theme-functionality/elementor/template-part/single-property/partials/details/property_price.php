<?php
global $settings;
$prop_price = houzez_get_listing_data('property_price');
if( !empty( $prop_price ) ) {
    echo '<li>
            <strong>'.esc_attr($settings['price_title']). '</strong> 
            <span>'.houzez_listing_price().'</span>
        </li>';}