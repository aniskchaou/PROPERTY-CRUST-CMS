<?php 
global $sorting_settings, $settings; 
$section_title = isset($settings['section_title']) && !empty($settings['section_title']) ? $settings['section_title'] : houzez_option('sps_details', 'Details');
$additional_section_title = isset($settings['additional_section_title']) && !empty($settings['additional_section_title']) ? $settings['additional_section_title'] : houzez_option('sps_additional_details', 'Additional details');

$default_fields = array(
		'property_id',
		'property_price',
		'property_size',
		'property_land',
		'property_bedrooms',
		'property_bathrooms',
		'property_garage',
		'property_garage_size',
		'property_year',
		'property_status',
		'property_type',
		
	);

?>
<div class="property-detail-wrap property-section-wrap" id="property-detail-wrap">
	<div class="block-wrap">
		
		<?php if( $settings['section_header'] ) { ?>
		<div class="block-title-wrap d-flex justify-content-between align-items-center">
			<h2><?php echo $section_title; ?></h2>
		</div><!-- block-title-wrap -->
		<?php } ?>

		<div class="block-content-wrap">
			<?php
			if( !empty($sorting_settings) ) {
                $details_data = explode(',', $sorting_settings);  

                echo '<div class="detail-wrap">';
                echo '<ul class="'.esc_attr($settings['data_columns']).' list-unstyled">';

                foreach ( $details_data as $data ) {

                	if( in_array( $data, $default_fields ) ) {
	                	htf_get_template_part('elementor/template-part/single-property/partials/details/'. $data);

	                } else {

	                	$custom_field = Houzez_Fields_Builder::get_field_title_type_by_slug($data);
	                	$field_type = $custom_field['type'];
	                	$meta_type = true;

	                    if( $field_type == 'checkbox_list' || $field_type == 'multiselect' ) {
	                        $meta_type = false;
	                    }

	                	$data_value = get_post_meta( get_the_ID(), 'fave_'.$data, $meta_type );

	                	if( $meta_type == true ) {
	                        $data_value = houzez_wpml_translate_single_string($data_value);
	                    } else {
	                        $data_value = houzez_array_to_comma($data_value);
	                    }

	                	 
	                	$field_title = $custom_field['label'];
	                	$field_title = houzez_wpml_translate_single_string($field_title);

	                	if( !empty($data_value) && !empty($field_title) ) {
	                        echo '<li><strong>'.esc_attr($field_title).'</strong> <span>'.esc_attr( $data_value ).'</span></li>';
	                    }
	                }
	                
	            }

                echo '</ul>';
                echo '</div>';

            } else {

            	echo '<div class="detail-wrap">';
                echo '<ul class="'.esc_attr($settings['data_columns']).' list-unstyled">';

                foreach ( $default_fields as $data) {

                	htf_get_template_part('elementor/template-part/single-property/partials/details/'. $data);
	                
	            }

                echo '</ul>';
                echo '</div>';

            }
			?>

			<?php 

			$additional_features = get_post_meta( get_the_ID(), 'additional_features', true);
			if( !empty( $additional_features[0]['fave_additional_feature_title'] ) && $settings['show_additional_details'] ) { ?>
				
				<?php if( $settings['additional_section_header'] ) { ?>
				<div class="block-title-wrap">
					<h3><?php echo esc_attr($additional_section_title); ?></h3>
				</div><!-- block-title-wrap -->
				<?php } ?>

				<ul class="<?php echo esc_attr($settings['additional_data_columns']); ?> additional-details-ul list-unstyled">
					<?php
			        foreach( $additional_features as $ad_del ):
			            echo '<li><strong>'.esc_attr( $ad_del['fave_additional_feature_title'] ).'</strong> <span>'.esc_attr( $ad_del['fave_additional_feature_value'] ).'</span></li>';
			        endforeach;
			        ?>
				</ul>	
			<?php } ?>
			
		</div><!-- block-content-wrap -->
	</div><!-- block-wrap -->
</div><!-- property-detail-wrap -->

