<?php $property_id = isset ( $_GET['property_id'] ) ? $_GET['property_id'] : ''; ?>
<div class="form-group">
	<input name="property_id" type="text" class="<?php houzez_ajax_search(); ?> form-control" value="<?php echo esc_attr($property_id); ?>" placeholder="<?php echo houzez_option('srh_prop_id', 'Property ID'); ?>">
</div>