<?php
$overview_data_composer = houzez_option('overview_data_composer');
$overview_data = $overview_data_composer['enabled'];

$i = 0;
if ($overview_data) {
	unset($overview_data['placebo']);
	foreach ($overview_data as $key => $value) { $i ++;
		if(in_array($key, houzez_overview_composer_fields())) {

			get_template_part('property-details/partials/overview/'.$key);

		} else {
			
			$meta_type = false;
			$custom_field_value = get_post_meta( get_the_ID(), 'fave_'.$key, $meta_type );

			$field_title = houzez_wpml_translate_single_string($value);
            if( is_array($custom_field_value) ) {
            	$custom_field_value = houzez_array_to_comma($custom_field_value);
            } else {
                $custom_field_value = houzez_wpml_translate_single_string($custom_field_value);
            }

			$output = '';
			$output .= '<ul class="list-unstyled flex-fill">';
				$output .= '<li class="property-overview-item">';
					
					if(houzez_option('icons_type') == 'font-awesome') {
						$output .= '<i class="'.houzez_option('fa_'.$key).' mr-1"></i>';

					} elseif (houzez_option('icons_type') == 'custom') {
						$cus_icon = houzez_option($key);
						if(!empty($cus_icon['url'])) {

							$alt = isset($cus_icon['title']) ? $cus_icon['title'] : '';
							$output .= '<img class="img-fluid mr-1" src="'.esc_url($cus_icon['url']).'" width="16" height="16" alt="'.esc_attr($alt).'">';
						}
					}

					$output .= '<strong>'.esc_attr($custom_field_value).'</strong>';
					
				$output .= '</li>';
				$output .= '<li>'.esc_attr($field_title).'</li>';
			$output .= '</ul>';

			echo $output;

		}
	}
}
