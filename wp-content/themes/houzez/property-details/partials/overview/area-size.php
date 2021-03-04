<?php
$prop_size = houzez_get_listing_data('property_size');

if(!empty( $prop_size )) {

	$output_size = "";
	$output_size .= '<ul class="list-unstyled flex-fill">';
		$output_size .= '<li class="property-overview-item">';
			
			if(houzez_option('icons_type') == 'font-awesome') {
				$output_size .= '<i class="'.houzez_option('fa_area-size').' mr-1"></i> ';

			} elseif (houzez_option('icons_type') == 'custom') {
				$cus_icon = houzez_option('area-size');
				if(!empty($cus_icon['url'])) {

					$alt_title = isset($cus_icon['title']) ? $cus_icon['title'] : '';
					$output_size .= '<img class="img-fluid mr-1" src="'.esc_url($cus_icon['url']).'" width="16" height="16" alt="'.esc_attr($alt_title).'"> ';
				}
			} else {
				$output_size .= '<i class="houzez-icon icon-real-estate-dimensions-plan-1 mr-1"></i> ';
			}
			
			$output_size .= '<strong>'.houzez_get_listing_area_size( get_the_ID() ).'</strong>';
		$output_size .= '</li>';
		$output_size .= '<li class="hz-meta-label h-area">'.houzez_get_listing_size_unit( get_the_ID() ).'</li>';
	$output_size .= '</ul>';

	echo $output_size;
}