<?php
global $settings;
$address = houzez_get_listing_data('property_address');

echo '<li class="detail-address"><strong>'.esc_attr($settings['address_title']).'</strong> <span>'.esc_attr( $address ).'</span></li>';