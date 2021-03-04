<?php global $is_multi_steps; ?>
<div id="sub-properties" class="dashboard-content-block-wrap <?php echo esc_attr($is_multi_steps);?>">
	<h2><?php echo houzez_option('cls_sub_listings', 'Sub Listings'); ?></h2>
	<div class="dashboard-content-block">
		<div id="multi_units_main">
			<?php 
			$data_increment = 0;
			if(houzez_edit_property()) { 
			global $property_data;
			$multi_units = get_post_meta( $property_data->ID, 'fave_multi_units', true );
			$count = 0;
	            if( !empty($multi_units) ) {
	            foreach ($multi_units as $multi_unit):
			?>
			<div class="houzez-units-clone">
				<div class="row">
					<div class="col-md-12 col-sm-12">
						<div class="remove-subproperty-row" data-remove="<?php echo esc_attr( $count-1 ); ?>">
							<i class="houzez-icon icon-remove-circle mr-2"></i>
						</div>
						<div class="form-group">
							<label for="fave_multi_units[<?php echo intval($count); ?>][fave_mu_title]"><?php echo houzez_option('cl_subl_title', 'Title' ); ?></label>
                            <input value="<?php echo sanitize_text_field( $multi_unit['fave_mu_title'] ); ?>" name="fave_multi_units[<?php echo intval($count); ?>][fave_mu_title]" type="text" class="form-control" placeholder="<?php echo houzez_option('cl_subl_title_plac', 'Enter the title');?>">
						</div>
					</div><!-- col-md-12 col-sm-12 -->
					<div class="col-md-6 col-sm-12">
						<div class="form-group">
							<label for="fave_multi_units[<?php echo intval($count); ?>][fave_mu_beds]"><?php echo houzez_option('cl_subl_bedrooms', 'Bedrooms' ); ?></label>
                            <input value="<?php echo sanitize_text_field( $multi_unit['fave_mu_beds'] ); ?>" name="fave_multi_units[<?php echo intval($count); ?>][fave_mu_beds]" type="text" class="form-control" placeholder="<?php echo houzez_option('cl_subl_bedrooms', 'Enter the number of bedrooms');?>">
							<small class="form-text text-muted"><?php esc_html_e('Only digits', 'houzez'); ?></small>
						</div>
					</div><!-- col-md-6 col-sm-12 -->
					<div class="col-md-6 col-sm-12">
						<div class="form-group">
							<label for="fave_multi_units[<?php echo intval($count); ?>][fave_mu_baths]"><?php echo houzez_option('cl_subl_bathrooms', 'Bathrooms' ); ?></label>
                            <input value="<?php echo sanitize_text_field( $multi_unit['fave_mu_baths'] ); ?>" name="fave_multi_units[<?php echo intval($count); ?>][fave_mu_baths]" type="text" class="form-control" placeholder="<?php echo houzez_option('cl_subl_bathrooms_plac', 'Enter the number of bathrooms');?>">
							<small class="form-text text-muted"><?php esc_html_e('Only digits', 'houzez'); ?></small>
						</div>
					</div><!-- col-md-6 col-sm-12 -->
					<div class="col-md-6 col-sm-12">
						<div class="form-group">
							<label for="fave_multi_units[<?php echo intval($count); ?>][fave_mu_size]"><?php echo houzez_option('cl_subl_size', 'Property Size' ); ?></label>
                            <input value="<?php echo sanitize_text_field( $multi_unit['fave_mu_size'] ); ?>" name="fave_multi_units[<?php echo intval($count); ?>][fave_mu_size]" type="text" class="form-control" placeholder="<?php echo houzez_option('cl_subl_size', 'Enter the property size');?>">
						</div>
					</div><!-- col-md-6 col-sm-12 -->
					<div class="col-md-6 col-sm-12">
						<div class="form-group">
							<label for="fave_multi_units[<?php echo intval($count); ?>][fave_mu_size_postfix]"><?php echo houzez_option('cl_subl_size_postfix', 'Size Postfix' ); ?></label>
                            <input value="<?php echo sanitize_text_field( $multi_unit['fave_mu_size_postfix'] ); ?>" name="fave_multi_units[<?php echo intval($count); ?>][fave_mu_size_postfix]" type="text" class="form-control" placeholder="<?php echo houzez_option('cl_subl_size_postfix_plac', 'Enter the property size postfix');?>">
						</div>
					</div><!-- col-md-6 col-sm-12 -->
					
					<div class="col-md-6 col-sm-12">
						<div class="form-group">
							<label for="fave_multi_units[<?php echo intval($count); ?>][fave_mu_price]"><?php echo houzez_option('cl_subl_price', 'Price' ); ?></label>
                           	<input value="<?php echo sanitize_text_field( $multi_unit['fave_mu_price'] ); ?>" name="fave_multi_units[<?php echo intval($count); ?>][fave_mu_price]" type="text" class="form-control" placeholder="<?php echo houzez_option('cl_subl_price_plac', 'Enter the price');?>">
							
						</div>
					</div><!-- col-md-6 col-sm-12 -->
					<div class="col-md-6 col-sm-12">
						<div class="form-group">
							<label for="fave_multi_units[<?php echo intval($count); ?>][fave_mu_price_postfix]"><?php echo houzez_option('cl_subl_price_postfix', 'Price Postfix' ); ?></label>
                           	<input value="<?php echo sanitize_text_field( $multi_unit['fave_mu_price_postfix'] ); ?>" name="fave_multi_units[<?php echo intval($count); ?>][fave_mu_price_postfix]" type="text" class="form-control" placeholder="<?php echo houzez_option('cl_subl_price_postfix_plac', 'Enter the price postfix');?>">
						</div>
					</div><!-- col-md-6 col-sm-12 -->

					<div class="col-md-6 col-sm-12">
		                <div class="form-group">
		                    <label for="fave_multi_units[<?php echo intval($count); ?>][fave_mu_type]"><?php echo houzez_option('cl_subl_type', 'Property Type' ); ?></label>
                            <input value="<?php echo sanitize_text_field( $multi_unit['fave_mu_type'] ); ?>" name="fave_multi_units[<?php echo intval($count); ?>][fave_mu_type]" type="text" class="form-control" placeholder="<?php echo houzez_option('cl_subl_type_plac', 'Enter the property type');?>">
		                </div>
		            </div>
		            <div class="col-md-6 col-sm-12">
		                <label for="fave_multi_units[<?php echo intval($count); ?>][fave_mu_availability_date]"><?php echo houzez_option('cl_subl_date', 'Availability Date' ); ?></label>
                        <input value="<?php echo sanitize_text_field( $multi_unit['fave_mu_availability_date'] ); ?>" name="fave_multi_units[<?php echo intval($count); ?>][fave_mu_availability_date]" type="text" class="form-control" placeholder="<?php echo houzez_option('cl_subl_date_plac', 'Enter the availability date');?>">
		            </div>
				</div><!-- row -->
				<hr>
			</div>
			<?php 
				$count++;
				endforeach;
				$data_increment = $count - 1;
				}
			} else { ?>
			<div class="houzez-units-clone">
				<div class="row">
					<div class="col-md-12 col-sm-12">
						<div class="remove-subproperty-row" data-remove="0">
							<i class="houzez-icon icon-remove-circle mr-2"></i>
						</div>
						<div class="form-group">
							<label for="fave_multi_units[0][fave_mu_title]"><?php echo houzez_option('cl_subl_title', 'Title' ); ?></label>
		                    <input name="fave_multi_units[0][fave_mu_title]" type="text" class="form-control" placeholder="<?php echo houzez_option('cl_subl_title_plac', 'Enter the title');?>">
						</div>
					</div><!-- col-md-12 col-sm-12 -->
					<div class="col-md-6 col-sm-12">
						<div class="form-group">
							<label for="fave_multi_units[0][fave_mu_beds]"><?php echo houzez_option('cl_subl_bedrooms', 'Bedrooms' ); ?></label>
		                    <input name="fave_multi_units[0][fave_mu_beds]" type="text" class="form-control" placeholder="<?php echo houzez_option('cl_subl_bedrooms', 'Enter the number of bedrooms');?>">
						</div>
					</div><!-- col-md-6 col-sm-12 -->
					<div class="col-md-6 col-sm-12">
						<div class="form-group">
							<label for="fave_multi_units[0][fave_mu_baths]"><?php echo houzez_option('cl_subl_bathrooms', 'Bathrooms' ); ?></label>
		                    <input name="fave_multi_units[0][fave_mu_baths]" type="text" class="form-control" placeholder="<?php echo houzez_option('cl_subl_bathrooms_plac', 'Enter the number of bathrooms');?>">
						</div>
					</div><!-- col-md-6 col-sm-12 -->
					<div class="col-md-6 col-sm-12">
						<div class="form-group">
							<label for="fave_multi_units[0][fave_mu_size]"><?php echo houzez_option('cl_subl_size', 'Property Size' ); ?></label>
		                    <input name="fave_multi_units[0][fave_mu_size]" type="text" class="form-control" placeholder="<?php echo houzez_option('cl_subl_size', 'Enter the property size');?>">
						</div>
					</div><!-- col-md-6 col-sm-12 -->
					<div class="col-md-6 col-sm-12">
						<div class="form-group">
							<label for="fave_multi_units[0][fave_mu_size_postfix]"><?php echo houzez_option('cl_subl_size_postfix', 'Size Postfix' ); ?></label>
		                    <input name="fave_multi_units[0][fave_mu_size_postfix]" type="text" class="form-control" placeholder="<?php echo houzez_option('cl_subl_size_postfix_plac', 'Enter the property size postfix');?>">
						</div>
					</div><!-- col-md-6 col-sm-12 -->
					
					<div class="col-md-6 col-sm-12">
						<div class="form-group">
							<label for="fave_multi_units[0][fave_mu_price]"><?php echo houzez_option('cl_subl_price', 'Price' ); ?></label>
		                    <input name="fave_multi_units[0][fave_mu_price]" type="text" class="form-control" placeholder="<?php echo houzez_option('cl_subl_price_plac', 'Enter the price');?>">
							<small class="form-text text-muted"><?php esc_html_e('Only digits', 'houzez'); ?></small>
						</div>
					</div><!-- col-md-6 col-sm-12 -->
					<div class="col-md-6 col-sm-12">
						<div class="form-group">
							<label for="fave_multi_units[0][fave_mu_price_postfix]"><?php echo houzez_option('cl_subl_price_postfix', 'Price Postfix' ); ?></label>
		                    <input name="fave_multi_units[0][fave_mu_price_postfix]" type="text" class="form-control" placeholder="<?php echo houzez_option('cl_subl_price_postfix_plac', 'Enter the price postfix');?>">
						</div>
					</div><!-- col-md-6 col-sm-12 -->

					<div class="col-md-6 col-sm-12">
		                <div class="form-group">
		                    <label for="fave_multi_units[0][fave_mu_type]"><?php echo houzez_option('cl_subl_type', 'Property Type' ); ?></label>
		                    <input name="fave_multi_units[0][fave_mu_type]" type="text" class="form-control" placeholder="<?php echo houzez_option('cl_subl_type_plac', 'Enter the property type');?>">
		                </div>
		            </div>
		            <div class="col-md-6 col-sm-12">
		            	<div class="form-group">
			                <label for="fave_multi_units[0][fave_mu_availability_date]"><?php echo houzez_option('cl_subl_date', 'Availability Date' ); ?></label>
			                <input name="fave_multi_units[0][fave_mu_availability_date]" type="text" class="form-control" placeholder="<?php echo houzez_option('cl_subl_date_plac', 'Enter the availability date');?>">
			            </div>
		            </div>
				</div><!-- row -->
				<hr>
			</div>
			<?php } ?>
		</div>

		<button id="add-subproperty-row" data-increment="<?php echo esc_attr($data_increment); ?>" class="btn btn-primary btn-left-icon"><i class="houzez-icon icon-add-circle"></i> <?php esc_html_e('Add New', 'houzez'); ?></button>
	</div><!-- dashboard-content-block -->
</div><!-- dashboard-content-block-wrap -->

