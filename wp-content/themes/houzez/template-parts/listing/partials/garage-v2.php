<?php
$prop_garage = houzez_get_listing_data('property_garage');
$prop_garage_label = ($prop_garage > 1 ) ? houzez_option('glc_garages', 'Garages') : houzez_option('glc_garage', 'Garage');

$output = '';
if($prop_garage != '') {
	$output .= '<li class="h-cars">';
		$output .= '<span class="hz-figure">'.$prop_garage.' ';
		
		if(houzez_option('icons_type') == 'font-awesome') {
			$output .= '<i class="'.houzez_option('fa_garage').' ml-1"></i>';

		} elseif (houzez_option('icons_type') == 'custom') {
			$cus_icon = houzez_option('garage');
			if(!empty($cus_icon['url'])) {

				$alt = isset($cus_icon['title']) ? $cus_icon['title'] : '';
				$output .= '<img class="img-fluid ml-1" src="'.esc_url($cus_icon['url']).'" width="16" height="16" alt="'.esc_attr($alt).'">';
			}
		} else {
			$output .= '<i class="houzez-icon icon-car-1 mr-1"></i>';
		}

		$output .='</span>';
		$output .= $prop_garage_label;
	$output .= '</li>';
}
echo $output;