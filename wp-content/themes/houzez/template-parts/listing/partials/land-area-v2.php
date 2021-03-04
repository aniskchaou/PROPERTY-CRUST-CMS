<?php
$propID = get_the_ID();
$prop_size = houzez_get_listing_data('property_land');
$listing_area_size = houzez_get_land_area_size( $propID );
$listing_size_unit = houzez_get_land_size_unit( $propID );

$output = '';
if( !empty( $listing_area_size ) ) {
	$output .= '<li class="h-area">';
		$output .= '<span>'.$listing_area_size.' ';
		if(houzez_option('icons_type') == 'font-awesome') {
			$output .= '<i class="'.houzez_option('fa_land-area').' ml-1"></i>';

		} elseif (houzez_option('icons_type') == 'custom') {
			$cus_icon = houzez_option('land-area');
			if(!empty($cus_icon['url'])) {

				$alt = isset($cus_icon['title']) ? $cus_icon['title'] : '';
				$output .= '<img class="img-fluid ml-1" src="'.esc_url($cus_icon['url']).'" width="16" height="16" alt="'.esc_attr($alt).'">';
			}
		} else {
			$output .= '<i class="houzez-icon icon-ruler-triangle mr-1"></i>';
		}
		$output .= '</span>';
		$output .= $listing_size_unit;
	$output .= '</li>';
}
echo $output;