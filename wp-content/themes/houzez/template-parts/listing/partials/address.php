<?php
$address = houzez_get_listing_data('property_map_address');
if(!empty($address)) {
	echo esc_attr($address);
}