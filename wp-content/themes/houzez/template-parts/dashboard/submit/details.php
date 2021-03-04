<?php
global $prop_meta_data, $hide_prop_fields, $required_fields, $is_multi_steps, $area_prefix_default, $area_prefix_changeable;
$area_prefix_default = houzez_option('area_prefix_default');
$area_prefix_changeable = houzez_option('area_prefix_changeable');
$auto_property_id = houzez_option('auto_property_id');

if( $area_prefix_default == 'SqFt' ) {
    $area_prefix_default = houzez_option('measurement_unit_sqft_text');
} elseif( $area_prefix_default == 'm²' ) {
    $area_prefix_default = houzez_option('measurement_unit_square_meter_text');
}

$adp_details_fields = houzez_option('adp_details_fields');
$fields_builder = $adp_details_fields['enabled'];
unset($fields_builder['placebo']);
?>
<div id="details" class="dashboard-content-block-wrap <?php echo esc_attr($is_multi_steps);?>">
	<h2><?php echo houzez_option('cls_details', 'Details'); ?></h2>
	<div class="dashboard-content-block">
		
		<div class="row">
			<?php
			if ($fields_builder) {
				foreach ($fields_builder as $key => $value) {

					if(in_array($key, houzez_details_section_fields())) { 

						if( $key == 'property-id' ) {

							if( $auto_property_id != 1 ) {
								echo '<div class="col-md-6 col-sm-12">';
									get_template_part('template-parts/dashboard/submit/form-fields/'.$key); 
								echo '</div>';
							}

						} else {
							echo '<div class="col-md-6 col-sm-12">';
								get_template_part('template-parts/dashboard/submit/form-fields/'.$key); 
							echo '</div>';
						}
						

					} else {

						echo '<div class="col-md-6 col-sm-12">';
							houzez_get_custom_add_listing_field($key);
						echo '</div>';
					}
				}
			}
			?>
			
			
		</div><!-- row -->
	</div><!-- dashboard-content-block -->

	<?php if( $hide_prop_fields['additional_details'] != 1 ) { ?>
	<h2><?php echo houzez_option('cls_additional_details', 'Additional details'); ?></h2>
	<div class="dashboard-content-block">
		<?php get_template_part('template-parts/dashboard/submit/form-fields/additional-details'); ?>
	</div><!-- dashboard-content-block -->
	<?php } ?>
</div><!-- dashboard-content-block-wrap -->
