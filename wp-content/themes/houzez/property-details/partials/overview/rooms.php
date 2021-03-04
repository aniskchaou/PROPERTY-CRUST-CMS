<?php
$rooms = houzez_get_listing_data('property_rooms');

if(!empty($rooms)) {

	$rooms_label = ($rooms > 1 ) ? houzez_option('spl_rooms', 'Rooms') : houzez_option('spl_room', 'Room');

	$output_rooms = "";
	$output_rooms .='<ul class="list-unstyled flex-fill">';
			$output_rooms .='<li class="property-overview-item">';
				
				if(houzez_option('icons_type') == 'font-awesome') {
					$output_rooms .= '<i class="'.houzez_option('fa_room').' mr-1"></i> ';

				} elseif (houzez_option('icons_type') == 'custom') {
					$cus_icon = houzez_option('room');
					if(!empty($cus_icon['url'])) {

						$alt_title = isset($cus_icon['title']) ? $cus_icon['title'] : '';
						$output_rooms .= '<img class="img-fluid mr-1" src="'.esc_url($cus_icon['url']).'" width="16" height="16" alt="'.esc_attr($alt_title).'"> ';
					}
				} else {
					$output_rooms .= '<i class="houzez-icon real-estate-dimensions-block mr-1"></i> ';
				}

				$output_rooms .='<strong>'.esc_attr( $rooms ).'</strong> ';
			$output_rooms .='</li>';
			$output_rooms .='<li class="hz-meta-label h-rooms">'.esc_attr($rooms_label).'</li>';
	$output_rooms .='</ul>';

	echo $output_rooms;	
}