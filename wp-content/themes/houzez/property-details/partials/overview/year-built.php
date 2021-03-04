<?php
$year_built = houzez_get_listing_data('property_year');

if(!empty( $year_built )) {

	$output_year = '';
	$output_year .= '<ul class="list-unstyled flex-fill">';
		$output_year .= '<li class="property-overview-item">';
			
			if(houzez_option('icons_type') == 'font-awesome') {
				$output_year .= '<i class="'.houzez_option('fa_year-built').' mr-1"></i> ';

			} elseif (houzez_option('icons_type') == 'custom') {
				$cus_icon = houzez_option('year-built');
				if(!empty($cus_icon['url'])) {

					$alt_title = isset($cus_icon['title']) ? $cus_icon['title'] : '';
					$output_year .= '<img class="img-fluid mr-1" src="'.esc_url($cus_icon['url']).'" width="16" height="16" alt="'.esc_attr($alt_title).'"> ';
				}
			} else {
				$output_year .= '<i class="houzez-icon icon-calendar-3 mr-1"></i> ';
			}

			$output_year .= '<strong>'.esc_attr( $year_built ).'</strong>';
		$output_year .= '</li>';
		$output_year .= '<li class="hz-meta-label h-year-built">'.houzez_option('spl_year_built', 'Year Built').'</li>';
	$output_year .= '</ul>';

	echo $output_year;
}