<?php
$prop_room  = houzez_get_listing_data('property_rooms');
$prop_room_label = ($prop_room > 1 ) ? houzez_option('glc_rooms', 'Rooms') : houzez_option('glc_room', 'Room');

$output = '';
if( $prop_room != '' ) { 
	$output .= '<li class="h-rooms">';
		$output .= '<span class="hz-figure">'.esc_attr($prop_room).' ';
		
		if(houzez_option('icons_type') == 'font-awesome') {
			$output .= '<i class="'.houzez_option('fa_room').' ml-1"></i>';

		} elseif (houzez_option('icons_type') == 'custom') {
			$cus_icon = houzez_option('room');
			if(!empty($cus_icon['url'])) {

				$alt = isset($cus_icon['title']) ? $cus_icon['title'] : '';
				$output .= '<img class="img-fluid ml-1" src="'.esc_url($cus_icon['url']).'" width="16" height="16" alt="'.esc_attr($alt).'">';
			}
		} else {
			$output .= '<i class="houzez-icon real-estate-dimensions-block mr-1"></i>';
		}

		$output .= '</span>';
		$output .= ' '.$prop_room_label;
	$output .= '</li>';
}
echo $output;