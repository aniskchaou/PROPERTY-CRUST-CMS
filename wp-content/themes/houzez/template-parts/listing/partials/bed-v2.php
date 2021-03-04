<?php
$prop_bed  = houzez_get_listing_data('property_bedrooms');
$prop_bed_label = ($prop_bed > 1 ) ? houzez_option('glc_bedrooms', 'Bedrooms') : houzez_option('glc_bedroom', 'Bedroom');

$output = '';
if( $prop_bed != '' ) { 
	$output .= '<li class="h-beds">';
		$output .= '<span class="hz-figure">'.$prop_bed.' ';
		
		if(houzez_option('icons_type') == 'font-awesome') {
			$output .= '<i class="'.houzez_option('fa_bed').' ml-1"></i>';

		} elseif (houzez_option('icons_type') == 'custom') {
			$cus_icon = houzez_option('bed');
			if(!empty($cus_icon['url'])) {

				$alt = isset($cus_icon['title']) ? $cus_icon['title'] : '';
				$output .= '<img class="img-fluid ml-1" src="'.esc_url($cus_icon['url']).'" width="16" height="16" alt="'.esc_attr($alt).'">';
			}
		} else {
			$output .= '<i class="houzez-icon icon-hotel-double-bed-1 ml-1"></i>';
		}

		$output .= '</span>';
		$output .= ' '.$prop_bed_label;
	$output .= '</li>';
}
echo $output;