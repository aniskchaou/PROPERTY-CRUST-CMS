<div class="dashboard-slide-panel-wrap enquiry-panel-js">
	<h2><?php esc_html_e('Add New Inquiry', 'houzez'); ?></h2>
	<button type="button" class="btn open-close-slide-panel open-close-enquiry-js">
		<span aria-hidden="true">&times;</span>
	</button>
	<form id="enquiry-form">
	<div class="lined-block">
		<div class="row">
			<div class="col-sm-12">
				<div class="form-group">
					<label><?php esc_html_e('Contact*', 'houzez'); ?></label>
					<select name="lead_id" id="lead_id" class="selectpicker form-control bs-select-hidden" data-live-search="true">
						<option value=""><?php esc_html_e('Select', 'houzez'); ?></option>
						<?php
						$contacts = Houzez_Leads::get_all_leads();
						foreach ($contacts as $contact) {
							echo '<option value="'.esc_attr($contact->lead_id).'">'.esc_attr($contact->display_name).'</option>';
						}
						?>
					</select>
				</div>
			</div>
		</div>
	</div>
	<div class="lined-block">
		<h3><?php esc_html_e('Information', 'houzez'); ?></h3>
		<div class="row">
			<div class="col-md-12 col-sm-12">
				<div class="form-group">
					<label><?php esc_html_e('Inquiry Type*', 'houzez'); ?></label>
					<select id="enquiry_type" name="enquiry_type" class="selectpicker form-control bs-select-hidden" title="<?php esc_html_e('Select', 'houzez'); ?>" data-live-search="false">
						<option value=""><?php esc_html_e('Select', 'houzez'); ?></option>
						<?php
						$enquiry_type = hcrm_get_option('enquiry_type', 'hcrm_enquiry_settings', esc_html__('Purchase, Rent, Sell, Miss, Evaluation, Mortgage', 'houzez'));
						if(!empty($enquiry_type)) {

							$enquiry_type = explode(',', $enquiry_type);
							foreach( $enquiry_type as $en_type ) {
								echo '<option value="'.trim($en_type).'">'.esc_attr($en_type).'</value>';
							}
						}
						?>
					</select><!-- selectpicker -->
				</div><!-- form-group -->
			</div><!-- col-md-6 col-sm-12 -->
			<div class="col-md-12 col-sm-12">
				<div class="form-group">
					<label><?php esc_html_e('Property Type*', 'houzez'); ?></label>
					<select id="property_type" name="e_meta[property_type]" class="selectpicker form-control bs-select-hidden" title="<?php esc_html_e('Select', 'houzez'); ?>" data-live-search="true">
						<?php
                        // All Option
                        echo '<option value="">'.esc_html__('Select', 'houzez').'</option>';

                        $prop_type = get_terms (
                            array(
                                "property_type"
                            ),
                            array(
                                'orderby' => 'name',
                                'order' => 'ASC',
                                'hide_empty' => false,
                                'parent' => 0
                            )
                        );
                        hcrm_get_taxonomy('property_type', $prop_type);
                        ?>
					</select><!-- selectpicker -->
				</div>
			</div><!-- col-md-6 col-sm-12 -->
			<div class="col-md-6 col-sm-12">
				<div class="form-group">
					<label><?php esc_html_e('Price', 'houzez'); ?></label>
					<input class="form-control" name="e_meta[min-price]" id="min-price" placeholder="<?php esc_html_e('From', 'houzez'); ?>" type="text">
				</div>
			</div><!-- col-md-6 col-sm-12 -->
			<div class="col-md-6 col-sm-12">
				<div class="form-group">
					<label>&nbsp;</label>
					<input class="form-control" name="e_meta[max-price]" id="max-price" placeholder="<?php esc_html_e('To', 'houzez'); ?>" type="text">
				</div>
			</div><!-- col-md-6 col-sm-12 -->
			<div class="col-md-6 col-sm-12">
				<div class="form-group">
					<label><?php esc_html_e('Bedrooms', 'houzez'); ?></label>
					<input class="form-control" name="e_meta[min-beds]" id="min-beds" placeholder="<?php esc_html_e('Min', 'houzez'); ?>" type="text">
				</div>
			</div><!-- col-md-6 col-sm-12 -->
			<div class="col-md-6 col-sm-12">
				<div class="form-group">
					<label>&nbsp;</label>
					<input class="form-control" name="e_meta[max-beds]" id="max-beds" placeholder="<?php esc_html_e('Max', 'houzez'); ?>" type="text">
				</div>
			</div><!-- col-md-6 col-sm-12 -->
			<div class="col-md-6 col-sm-12">
				<div class="form-group">
					<label><?php esc_html_e('Bathrooms', 'houzez'); ?></label>
					<input class="form-control" name="e_meta[min-baths]" id="min-baths" placeholder="<?php esc_html_e('Min', 'houzez'); ?>" type="text">
				</div>
			</div><!-- col-md-6 col-sm-12 -->
			<div class="col-md-6 col-sm-12">
				<div class="form-group">
					<label>&nbsp;</label>
					<input class="form-control" name="e_meta[max-baths]" id="max-baths" placeholder="<?php esc_html_e('Max', 'houzez'); ?>" type="text">
				</div>
			</div><!-- col-md-6 col-sm-12 -->
			<div class="col-md-6 col-sm-12">
				<div class="form-group">
					<label><?php esc_html_e('Area Size', 'houzez'); ?></label>
					<input class="form-control" name="e_meta[min-area]" id="min-area" placeholder="<?php esc_html_e('Min', 'houzez'); ?>" type="text">
				</div>
			</div><!-- col-md-6 col-sm-12 -->
			<div class="col-md-6 col-sm-12">
				<div class="form-group">
					<label>&nbsp;</label>
					<input class="form-control" name="e_meta[max-area]" id="max-area" placeholder="<?php esc_html_e('Max', 'houzez'); ?>" type="text">
				</div>
			</div><!-- col-md-6 col-sm-12 -->
		</div>
	</div>
	<div class="lined-block">
		<h3><?php esc_html_e('Address', 'houzez'); ?></h3>
		<div class="row">

			<?php if( taxonomy_exists('property_country') ) { ?>
			<div class="col-md-12 col-sm-12">
				<div class="form-group">
					<label><?php esc_html_e('Country', 'houzez'); ?></label>
					<select name="e_meta[country]" id="country" class="houzezSelectFilter houzezCountryFilter houzezFirstList houzez-country-js selectpicker form-control bs-select-hidden" title="<?php esc_html_e('Country', 'houzez'); ?>" data-live-search="true" data-target="houzezSecondList" data-size="5">
						<?php
                        // All Option
                        echo '<option value="">'.esc_html__('Select', 'houzez').'</option>';

                        $prop_country = get_terms (
                            array(
                                "property_country"
                            ),
                            array(
                                'orderby' => 'name',
                                'order' => 'ASC',
                                'hide_empty' => false,
                                'parent' => 0
                            )
                        );
                        hcrm_get_taxonomy('property_country', $prop_country);
                        ?>
					</select><!-- selectpicker -->
				</div>
			</div><!-- col-md-12 col-sm-12 -->
			<?php } ?>
			
			<?php if( taxonomy_exists('property_state') ) { ?>
			<div class="col-md-12 col-sm-12">
				<div class="form-group">
					<label><?php esc_html_e('State', 'houzez'); ?></label>
					
					<select name="e_meta[state]" id="state" class="houzezSelectFilter houzezStateFilter houzezSecondList houzez-state-js selectpicker form-control bs-select-hidden" title="<?php esc_html_e('State', 'houzez'); ?>" data-live-search="true" data-target="houzezThirdList" data-size="5">
						<?php
	                    // All Option
	                    echo '<option value="">'.esc_html__('Select', 'houzez').'</option>';

	                    $prop_state = get_terms (
	                        array(
	                            "property_state"
	                        ),
	                        array(
	                            'orderby' => 'name',
	                            'order' => 'ASC',
	                            'hide_empty' => false,
	                            'parent' => 0
	                        )
	                    );
	                    hcrm_get_taxonomy('property_state', $prop_state);
	                    ?>
                    </select>
				</div>
			</div><!-- col-md-12 col-sm-12 -->
			<?php } ?>


			<?php if( taxonomy_exists('property_city') ) { ?>
			<div class="col-md-12 col-sm-12">
				<div class="form-group">
					<label><?php esc_html_e('City', 'houzez'); ?></label>
					<select name="e_meta[city]" id="city" class="houzezSelectFilter houzezCityFilter houzezThirdList houzez-city-js selectpicker form-control bs-select-hidden" title="<?php esc_html_e('City', 'houzez'); ?>" data-live-search="true" data-target="houzezFourthList" data-size="5">
						<?php
	                    // All Option
	                    echo '<option value="">'.esc_html__('Select', 'houzez').'</option>';

	                    $prop_city = get_terms (
	                        array(
	                            "property_city"
	                        ),
	                        array(
	                            'orderby' => 'name',
	                            'order' => 'ASC',
	                            'hide_empty' => false,
	                            'parent' => 0
	                        )
	                    );
	                    hcrm_get_taxonomy('property_city', $prop_city);
	                    ?>
                    </select>
				</div>
			</div><!-- col-md-12 col-sm-12 -->
			<?php } ?>

			<?php if( taxonomy_exists('property_area') ) { ?>
			<div class="col-md-12 col-sm-12">
				<div class="form-group">
					<label><?php esc_html_e('Area', 'houzez'); ?></label>
					<select name="e_meta[area]" id="area" class="houzezSelectFilter houzezFourthList selectpicker form-control bs-select-hidden" title="<?php esc_html_e('Area', 'houzez'); ?>" data-live-search="true" data-size="5">
						<?php
	                    // All Option
	                    echo '<option value="">'.esc_html__('Select', 'houzez').'</option>';

	                    $prop_area = get_terms (
	                        array(
	                            "property_area"
	                        ),
	                        array(
	                            'orderby' => 'name',
	                            'order' => 'ASC',
	                            'hide_empty' => false,
	                            'parent' => 0
	                        )
	                    );
	                    hcrm_get_taxonomy('property_area', $prop_area);
	                    ?>
                    </select>
				</div>
			</div><!-- col-md-12 col-sm-12 -->
			<?php } ?>

			<div class="col-md-12 col-sm-12">
				<div class="form-group">
					<label><?php esc_html_e('Postal Code / Zip', 'houzez'); ?></label>
					<input class="form-control" name="e_meta[zipcode]" id="zipcode" placeholder="<?php esc_html_e('Enter the zip code', 'houzez'); ?>" type="text">
				</div>
			</div><!-- col-md-12 col-sm-12 -->
		</div>
	</div>
	<div class="lined-block">
		<h3><?php esc_html_e('Notes', 'houzez'); ?></h3>
		<div class="row">
			<div class="col-md-12 col-sm-12">
				<div class="form-group">
					<textarea name="private_note" id="private_note" class="form-control" rows="5"></textarea>
				</div>
			</div>
		</div>
	</div>
	<input type="hidden" name="action" value="crm_add_new_enquiry">
	<div id="enquiry-msgs"></div>

	<button id="add_new_enquiry" type="button" class="btn btn-primary btn-full-width mt-2">
		<?php get_template_part('template-parts/loader'); ?>
		<?php esc_html_e('Save', 'houzez'); ?>
	</button>
	
	<?php get_template_part('template-parts/overlay-loader'); ?>
	
	</form>
</div><!-- dashboard-slide-panel-wrap -->