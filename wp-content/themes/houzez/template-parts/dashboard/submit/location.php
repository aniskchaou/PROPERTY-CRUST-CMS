<?php
global $is_multi_steps, $hide_prop_fields;
$houzez_map_system = houzez_get_map_system();
$default_lat = houzez_option('map_default_lat', 25.686540);
$default_long = houzez_option('map_default_long', -80.431345);
if (houzez_edit_property()) {
    $lat_lng = houzez_get_field_meta('property_location');
    $lat_lng = explode(",", $lat_lng);

    if(!empty($lat_lng[0])) {
    	$default_lat = $lat_lng[0];
    	$default_long = $lat_lng[1];
    }
    
}
?>
<div id="location" class="dashboard-content-block-wrap <?php echo esc_attr($is_multi_steps);?>">
	<h2><?php echo houzez_option('cls_location', 'Location'); ?></h2>
	<div class="dashboard-content-block">
		<div class="row">

			<?php if( $hide_prop_fields['map_address'] != 1 ) { ?>
			<div class="col-md-6 col-sm-12">
				<?php get_template_part('template-parts/dashboard/submit/form-fields/address'); ?>
			</div>
			<?php } ?>

			<?php if( taxonomy_exists('property_country') && $hide_prop_fields['country'] != 1 ) { ?>
			<div class="col-md-6 col-sm-12">
				<?php get_template_part('template-parts/dashboard/submit/form-fields/country'); ?>
			</div>
			<?php } ?>

			<?php if( taxonomy_exists('property_state') && $hide_prop_fields['state'] != 1 ) { ?>
			<div class="col-md-6 col-sm-12">
				<?php get_template_part('template-parts/dashboard/submit/form-fields/state'); ?>
			</div>
			<?php } ?>

			<?php if( taxonomy_exists('property_city') && $hide_prop_fields['city'] != 1 ) { ?>
			<div class="col-md-6 col-sm-12">
				<?php get_template_part('template-parts/dashboard/submit/form-fields/city'); ?>
			</div>
			<?php } ?>

			<?php if( taxonomy_exists('property_area') && $hide_prop_fields['neighborhood'] != 1 ) { ?>
			<div class="col-md-6 col-sm-12">
				<?php get_template_part('template-parts/dashboard/submit/form-fields/area'); ?>
			</div>
			<?php } ?>

			<?php if ($hide_prop_fields['postal_code'] != 1) { ?>
			<div class="col-md-6 col-sm-12">
				<?php get_template_part('template-parts/dashboard/submit/form-fields/zip'); ?>
			</div>
			<?php } ?>
		</div><!-- row -->			
	</div><!-- dashboard-content-block -->

	<?php if( $hide_prop_fields['map'] != 1 ) { ?>
	<h2><?php echo houzez_option('cls_map', 'Map'); ?></h2>
	<div class="dashboard-content-block">
		<div class="row">
			<div class="col-md-6 col-sm-12">
				<div class="form-group dashboard-map-field">
					<label><?php echo houzez_option('cl_drag_drop_text', 'Drag and drop the pin on map to find exact location'); ?></label>

					<div class="map-wrap">
						<div class="map_canvas" id="map_canvas" data-add-lat="<?php echo esc_attr($default_lat); ?>" data-add-long="<?php echo esc_attr($default_long); ?>">
	                    </div>
	                </div>
				</div>
				<button id="find_coordinates" type="button" class="btn btn-primary btn-full-width"><?php echo houzez_option('cl_ppbtn', 'Place the pin in address above'); ?></button>
				<a id="reset" href="#" style="display:none;"><?php esc_html_e('Reset Marker', 'houzez');?></a>
			</div><!-- col-md-6 col-sm-12 -->
			
			<div class="col-md-6 col-sm-12">
				<?php get_template_part('template-parts/dashboard/submit/form-fields/latitude'); ?>
				
				<?php get_template_part('template-parts/dashboard/submit/form-fields/longitude'); ?>
				
				<?php 
				if($houzez_map_system == 'google') { 
					get_template_part('template-parts/dashboard/submit/form-fields/street-view'); 
				}
				?>
			</div>

		</div><!-- row -->			
	</div><!-- dashboard-content-block -->
	<?php } ?>
</div><!-- dashboard-content-block-wrap -->

