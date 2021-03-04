<?php
$property_title_limit = houzez_option('property_title_limit');
$enable_title_limit = houzez_option('enable_title_limit', 0);

$length = '';
$is_limit = false;
if( $enable_title_limit == 1 && $property_title_limit != '' ) {
	$is_limit = true;
	$length = 'maxlength="'.esc_attr($property_title_limit).'"';
}
?>
<div class="form-group">
	<label for="prop_title"><?php echo houzez_option('cl_prop_title', 'Property Title').houzez_required_field('title'); ?></label>

	<?php if( $is_limit ) { ?>
	<div class="title-counter"><span id="rchars">0</span><span> / <?php echo esc_attr($property_title_limit); ?></span></div>
	<?php } ?>
	

	<input class="form-control" <?php houzez_required_field_2('title'); ?> name="prop_title" id="prop_title" value="<?php
    if (houzez_edit_property()) {
        global $property_data;
        echo esc_attr($property_data->post_title);
    }
    ?>" placeholder="<?php echo houzez_option('cl_prop_title_plac', 'Enter your property title'); ?>" <?php echo $length; ?> type="text">
</div>