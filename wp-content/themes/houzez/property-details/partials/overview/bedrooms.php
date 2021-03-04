<?php
$bedrooms 	= houzez_get_listing_data('property_bedrooms');

if(!empty($bedrooms)) {

	$bedrooms_label = ($bedrooms > 1 ) ? houzez_option('spl_bedrooms', 'Bedrooms') : houzez_option('spl_bedroom', 'Bedroom');

	$output_beds = "";
	$output_beds .='<ul class="list-unstyled flex-fill">';
			$output_beds .='<li class="property-overview-item">';
				
				if(houzez_option('icons_type') == 'font-awesome') {
					$output_beds .= '<i class="'.houzez_option('fa_bed').' mr-1"></i> ';

				} elseif (houzez_option('icons_type') == 'custom') {
					$cus_icon = houzez_option('bed');
					if(!empty($cus_icon['url'])) {

						$alt_title = isset($cus_icon['title']) ? $cus_icon['title'] : '';
						$output_beds .= '<img class="img-fluid mr-1" src="'.esc_url($cus_icon['url']).'" width="16" height="16" alt="'.esc_attr($alt_title).'"> ';
					}
				} else {
					$output_beds .= '<i class="houzez-icon icon-hotel-double-bed-1 mr-1"></i> ';
				}

				$output_beds .='<strong>'.esc_attr( $bedrooms ).'</strong> ';
			$output_beds .='</li>';
			$output_beds .='<li class="hz-meta-label h-beds">'.esc_attr($bedrooms_label).'</li>';
	$output_beds .='</ul>';

	echo $output_beds;	
}