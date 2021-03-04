<?php
$attachments = get_post_meta(get_the_ID(), 'fave_attachments', false);
$documents_download = houzez_option('documents_download');

$prop_id = houzez_get_listing_data('property_id');
$prop_price = houzez_get_listing_data('property_price');
$prop_size = houzez_get_listing_data('property_size');
$land_area = houzez_get_listing_data('property_land');
$bedrooms = houzez_get_listing_data('property_bedrooms');
$rooms = houzez_get_listing_data('property_rooms');
$bathrooms = houzez_get_listing_data('property_bathrooms');
$year_built = houzez_get_listing_data('property_year');
$garage = houzez_get_listing_data('property_garage');
$property_status = houzez_taxonomy_simple('property_status');
$property_type = houzez_taxonomy_simple('property_type');
$garage_size = houzez_get_listing_data('property_garage_size');
$additional_features_enable = houzez_get_listing_data('additional_features_enable');
$additional_features = get_post_meta( get_the_ID(), 'additional_features', true);

$icon_prop_id = houzez_option('icon_prop_id', false, 'url' );
$icon_bedrooms = houzez_option('icon_bedrooms', false, 'url' );
$icon_rooms = houzez_option('icon_rooms', false, 'url' );
$icon_bathrooms = houzez_option('icon_bathrooms', false, 'url' );
$icon_prop_size = houzez_option('icon_prop_size', false, 'url' );
$icon_prop_land = houzez_option('icon_prop_land', false, 'url' );
$icon_garage_size = houzez_option('icon_garage_size', false, 'url' );
$icon_garage = houzez_option('icon_garage', false, 'url' );
$icon_year = houzez_option('icon_year', false, 'url' );

$bathrooms_text = ($bathrooms > 1 ) ? houzez_option('spl_bathrooms', 'Bathrooms') : houzez_option('spl_bathroom', 'Bathroom');

$bedrooms_text = ($bedrooms > 1 ) ? houzez_option('spl_bedrooms', 'Bedrooms') : houzez_option('spl_bedroom', 'Bedroom');

$rooms_text = ($rooms > 1 ) ? houzez_option('spl_rooms', 'Rooms') : houzez_option('spl_room', 'Room');

$garage_label = ($garage > 1 ) ? houzez_option('spl_garages', 'Garages') : houzez_option('spl_garage', 'Garage');


$hide_fields = houzez_option('hide_detail_prop_fields');
?>
<div class="fw-property-description-wrap fw-property-section-wrap" id="property-description-wrap">
	<div class="block-wrap">
		<div class="block-title-wrap">
			<h2><?php echo houzez_option('sps_description', 'Description'); ?></h2>	
		</div><!-- block-title-wrap -->
		<div class="block-content-wrap">
			<?php the_content(); ?>
			

			<?php 
			if(!empty($attachments)) { ?>
			<div class="fw-property-documents-wrap">
				<div class="block-title-wrap">
					<h3>
						<span><?php echo houzez_option('sps_documents', 'Property Documents'); ?></span>
					</h3>
				</div><!-- block-title-wrap -->
				<div class="property-documents">
					<?php 
					foreach( $attachments as $attachment_id ):
						$attachment_meta = houzez_get_attachment_metadata($attachment_id); 

						if(!empty($attachment_meta )):
						?>
						<div class="property-document-title">
							<i class="houzez-icon icon-task-list-plain-1 mr-1"></i> <?php echo esc_attr( $attachment_meta->post_title ); ?> - 
							<?php if( $documents_download == 1 ) {
			                    if( is_user_logged_in() ) { ?>
			                    <a href="<?php echo esc_url( $attachment_meta->guid ); ?>" target="_blank"><?php esc_html_e( 'Download', 'houzez' ); ?></a>
			                    <?php } else { ?>
			                        <a href="#" data-toggle="modal" data-target="#login-register-form"><?php esc_html_e( 'Download', 'houzez' ); ?></a>
			                    <?php } ?>
			                <?php } else { ?>
			                    <a href="<?php echo esc_url( $attachment_meta->guid ); ?>" target="_blank"><?php esc_html_e( 'Download', 'houzez' ); ?></a>
			                <?php } ?>
						</div>
						<?php endif; ?>
					<?php endforeach; ?>
				</div><!-- property-documents -->
			</div><!-- fw-property-documents-wraps -->
			<?php } ?>

			<div class="fw-property-details-wrap">
				<div class="block-title-wrap">
					<h3>
						<span><?php echo houzez_option('sps_details', 'Details'); ?></span>
					</h3>
				</div><!-- block-title-wrap -->
				<div class="d-flex justify-content-center fw-property-amenities-wrap clearfix">
					
					<?php
		            if( !empty( $prop_id ) && $hide_fields['prop_id'] != 1 ) { ?>
					<div class="fw-property-amenities">
						<div class="d-flex align-items-center">

							<?php if( !empty($icon_prop_id) ) { ?>
								<img class="img-fluid" src="<?php echo esc_url($icon_prop_id); ?>" alt="">
							<?php } ?>
							<div class="fw-property-amenities-data">
								<?php echo houzez_option('spl_prop_id', 'Property ID'); ?><br>
								<?php echo houzez_propperty_id_prefix( $prop_id ); ?>
							</div>
						</div>
					</div>
					<?php } ?>

					<?php if( !empty( $bedrooms ) && $hide_fields['bedrooms'] != 1 ) { ?>
					<div class="fw-property-amenities">
						<div class="d-flex align-items-center">
							<?php if( !empty($icon_bedrooms) ) { ?>
				                <img class="img-fluid" src="<?php echo esc_url($icon_bedrooms); ?>" width="50" height="50" alt="">
				            <?php } ?>
							<div class="fw-property-amenities-data">
								<?php echo $bedrooms_text; ?><br>
								<?php echo esc_attr( $bedrooms ); ?>
								
							</div>
						</div>
					</div>
					<?php } ?>

					<?php if( !empty( $rooms ) && $hide_fields['rooms'] != 1 ) { ?>
					<div class="fw-property-amenities">
						<div class="d-flex align-items-center">
							<?php if( !empty($icon_rooms) ) { ?>
				                <img class="img-fluid" src="<?php echo esc_url($icon_rooms); ?>" width="50" height="50" alt="">
				            <?php } ?>
							<div class="fw-property-amenities-data">
								<?php echo $rooms_text; ?><br>
								<?php echo esc_attr( $rooms ); ?>
								
							</div>
						</div>
					</div>
					<?php } ?>

					<?php if( !empty( $bathrooms ) && $hide_fields['bathrooms'] != 1 ) { ?>
					<div class="fw-property-amenities">
						<div class="d-flex align-items-center">
							<?php if( !empty($icon_bathrooms) ) { ?>
								<img class="img-fluid" src="<?php echo esc_url($icon_bathrooms); ?>" width="50" height="50" alt="">
							<?php } ?>
							<div class="fw-property-amenities-data">
								<?php echo $bathrooms_text; ?><br>
								<?php echo esc_attr( $bathrooms ); ?>
							</div>
						</div>
					</div>
					<?php } ?>
        	
        			<?php if( !empty( $prop_size ) && $hide_fields['area_size'] != 1 ) { ?>
        			<div class="fw-property-amenities">
						<div class="d-flex align-items-center">
							<?php if( !empty($icon_prop_size) ) { ?>
								<img class="img-fluid" src="<?php echo esc_url($icon_prop_size); ?>" width="50" height="50" alt="">
							<?php } ?>
							<div class="fw-property-amenities-data">
								<?php echo houzez_option('spl_prop_size', 'Property Size'); ?><br>
								<?php echo houzez_property_size( 'after' ); ?>
							</div>
						</div>
					</div>
					<?php } ?>


					<?php if( !empty( $land_area ) && $hide_fields['land_area'] != 1 ) { ?>
					<div class="fw-property-amenities">
						<div class="d-flex align-items-center">
							<?php if( !empty($icon_prop_land) ) { ?>
								<img class="img-fluid" src="<?php echo esc_url($icon_prop_land); ?>" width="50" height="50" alt="">
							<?php } ?>
							<div class="fw-property-amenities-data">
								<?php echo houzez_option('spl_land', 'Land Area'); ?><br>
								<?php echo houzez_property_land_area( 'after' ); ?>
							</div>
						</div>
					</div>
					<?php } ?>

					<?php if( !empty( $garage ) && $hide_fields['garages'] != 1 ) { ?>
			       
			        <?php if( !empty( $garage_size ) ) { ?>
			        <div class="fw-property-amenities">
				        <div class="d-flex align-items-center">
							<?php if( !empty($icon_garage_size) ) { ?>
								<img class="img-fluid" src="<?php echo esc_url($icon_garage_size); ?>" alt="">
							<?php } ?>

							<div class="fw-property-amenities-data">
								<?php echo houzez_option('spl_garage_size', 'Garage Size'); ?><br>
								<?php echo esc_attr( $garage_size ); ?>
							</div>
						</div>
					</div>
					<?php } ?>

					<div class="fw-property-amenities">
						<div class="d-flex align-items-center">
							<?php if( !empty($icon_garage) ) { ?>
								<img class="img-fluid" src="<?php echo esc_url($icon_garage); ?>" alt="">
							<?php } ?>
							<div class="fw-property-amenities-data">
								<?php echo $garage_label; ?><br>
								<?php echo esc_attr( $garage ); ?>
							</div>
						</div>
					</div>
			        <?php } ?>
			        
			        <?php if( !empty( $year_built ) && $hide_fields['year_built'] != 1 ) { ?>
			        <div class="fw-property-amenities">
						<div class="d-flex align-items-center">
							<?php if( !empty($icon_year) ) { ?>
								<img class="img-fluid" src="<?php echo esc_url($icon_year); ?>" alt="">
							<?php } ?>
							<div class="fw-property-amenities-data">
								<?php echo houzez_option('spl_year_built', 'Year Built'); ?><br>
								<?php echo esc_attr( $year_built ); ?>
							</div>
						</div>
					</div>
					<?php } ?>

					<?php
					//Custom Fields
			        if(class_exists('Houzez_Fields_Builder')) {
			        $fields_array = Houzez_Fields_Builder::get_form_fields(); 

			            if(!empty($fields_array)) {
			                foreach ( $fields_array as $value ) {

			                	$field_type = $value->type;
			                    $meta_type = true;

			                    if( $field_type == 'checkbox_list' || $field_type == 'multiselect' ) {
			                        $meta_type = false;
			                    }

			                	$item_out = '';
			                    $data_value = get_post_meta( get_the_ID(), 'fave_'.$value->field_id, $meta_type );
			                    $field_title = $value->label;
			                    
			                    $field_title = houzez_wpml_translate_single_string($field_title);

			                    if( $meta_type == true ) {
			                        $data_value = houzez_wpml_translate_single_string($data_value);
			                    } else {
			                        $data_value = houzez_array_to_comma($data_value);
			                    }

			                    $field_id = houzez_clean_20($value->field_id);

			                    if(!empty($data_value) && $hide_fields[$field_id] != 1) {

			                    	$custom_icon = houzez_option('c_'.$field_id, false, 'url' );

			                    	$item_out .= '<div class="fw-property-amenities">';
			                    	$item_out .= '<div class="d-flex align-items-center">';

			                    	if( !empty($custom_icon) ) {

										$item_out .= '<img class="img-fluid" src="'.esc_url($custom_icon).'" alt="">';
									}

									$item_out .= '<div class="fw-property-amenities-data">';
										$item_out .= esc_attr($field_title).'<br>';
										$item_out .= esc_attr( $data_value );
									$item_out .= '</div>';

			                    	$item_out .= '</div>';
			                    	$item_out .= '</div>';

			                    	echo $item_out;
			                    }
			                }
			            }
			        }
					?>

				</div><!-- d-flex -->
				
			</div><!-- fw-property-details-wrap -->

			<?php if( $hide_fields['updated_date'] != 1 ) { ?>
			<span class="small-text grey"><i class="houzez-icon icon-calendar-3 mr-1"></i> <?php esc_html_e( 'Updated on', 'houzez' ); ?> <?php the_modified_time('F j, Y'); ?> <?php esc_html_e( 'at', 'houzez' ); ?> <?php the_modified_time('g:i a'); ?> </span>	
			<?php } ?>

		</div><!-- fw-property-documents-wrap -->
	</div><!-- block-wrap -->
</div><!-- property-description-wrap -->