<?php
$prop_bath  = houzez_get_listing_data('property_bathrooms');
$prop_bath_label = ($prop_bath > 1 ) ? houzez_option('glc_baths', 'Baths') : houzez_option('glc_bath', 'Bath');

$output = '';
if( $prop_bath != '' ) {
	$output .= '<li class="h-baths">';
		if(houzez_option('icons_type') == 'font-awesome') {
			$output .= '<i class="'.houzez_option('fa_bath').' mr-1"></i>';

		} elseif (houzez_option('icons_type') == 'custom') {
			$cus_icon = houzez_option('bath');
			if(!empty($cus_icon['url'])) {

				$alt = isset($cus_icon['title']) ? $cus_icon['title'] : '';
				$output .= '<img class="img-fluid mr-1" src="'.esc_url($cus_icon['url']).'" width="16" height="16" alt="'.esc_attr($alt).'">';
			}
		} else {
			$output .= '<i class="houzez-icon icon-bathroom-shower-1 mr-1"></i>';
		}
		$output .= '<span class="item-amenities-text">'.esc_attr($prop_bath_label).':</span> <span class="hz-figure">'.esc_attr($prop_bath).'</span>';
	$output .= '</li>';
}
echo $output;