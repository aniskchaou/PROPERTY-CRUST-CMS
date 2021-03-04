<?php
$property_type = houzez_taxonomy_simple('property_type');

$output = '';
if(!empty($property_type)) {
	$output .= '<li class="h-type">';
		$output .= '<span>'.esc_attr($property_type).'</span>';
	$output .= '</li>';
}

if(houzez_option('disable_type', 1)) {
	echo $output;
}