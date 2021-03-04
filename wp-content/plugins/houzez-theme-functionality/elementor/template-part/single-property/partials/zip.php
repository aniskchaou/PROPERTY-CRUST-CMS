<?php
global $settings;
$zipcode = houzez_get_listing_data('property_zip');

echo '<li class="detail-zip"><strong>'.esc_attr($settings['zip_title']).'</strong> <span>'.esc_attr( $zipcode ).'</span></li>';