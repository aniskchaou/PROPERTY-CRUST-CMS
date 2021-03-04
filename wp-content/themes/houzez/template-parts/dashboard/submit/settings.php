<?php 
global $is_multi_steps, $prop_meta_data; 
$is_featured = isset($prop_meta_data['fave_featured']) ? $prop_meta_data['fave_featured'][0] : 0;
$loggedintoview = isset($prop_meta_data['fave_loggedintoview']) ? $prop_meta_data['fave_loggedintoview'][0] : 0;
?>
<div id="settings" class="dashboard-content-block-wrap <?php echo esc_attr($is_multi_steps);?>">
	<h2><?php echo houzez_option('cls_settings', 'Property Settings'); ?></h2>
	<div class="dashboard-content-block dashboard-content-block-property-settings">
		<div class="form-group border-bottom">
			<div class="d-flex justify-content-between">
				<label><?php echo houzez_option('cl_make_featured', 'Do you want to mark this property as featured?'); ?></label>
				<div class="form-control-wrap d-flex">
					<label class="control control--radio mr-3">
						<input type="radio" name="prop_featured" <?php checked($is_featured, 1, true); ?> value="1"><?php echo houzez_option('cl_yes', 'Yes '); ?>
						<span class="control__indicator"></span>
					</label>
					<label class="control control--radio">
						<input type="radio" name="prop_featured" <?php checked($is_featured, 0, true); ?> value="0"><?php echo houzez_option('cl_no', 'No '); ?>
						<span class="control__indicator"></span>
					</label>
				</div>
			</div>
		</div>
		<div class="form-group border-bottom">
			<div class="d-flex justify-content-between">
				<label><?php echo houzez_option('cl_login_view', 'The user must be logged in to view this property'); ?></label>
				<div class="form-control-wrap d-flex">
					<label class="control control--radio mr-3">
						<input type="radio" name="login-required" value="1" <?php checked($loggedintoview, 1, true); ?>><?php echo houzez_option('cl_yes', 'Yes '); ?>
						<span class="control__indicator"></span>
					</label>
					<label class="control control--radio">
						<input type="radio" name="login-required" value="0" <?php checked($loggedintoview, 0, true); ?>><?php echo houzez_option('cl_no', 'No '); ?>
						<span class="control__indicator"></span>
					</label>
				</div>
			</div>
		</div>

		<div class="form-group">
			<label for="property_disclaimer">
				<?php echo houzez_option('cl_disclaimer', 'Disclaimer'); ?>		
			</label>
			<textarea class="form-control" id="property_disclaimer" name="property_disclaimer" rows="3" placeholder=""><?php
		    if (houzez_edit_property()) {
		        houzez_field_meta('property_disclaimer');
		    }
		    ?></textarea>
		</div>

	</div><!-- dashboard-content-block -->
</div><!-- dashboard-content-block-wrap -->


