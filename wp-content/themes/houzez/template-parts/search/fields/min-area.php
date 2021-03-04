<?php
$min_area = isset ( $_GET['min-area'] ) ? esc_attr($_GET['min-area']) : '';
$area_plac = houzez_option('srh_min_area', 'Min. Area');
$area_unit = houzez_area_unit_label();
if(!empty($area_unit)) {
	$area_unit = '('.$area_unit.')';
}
?>
<div class="form-group">
	<input name="min-area" type="text" class="form-control <?php houzez_ajax_search(); ?>" value="<?php echo esc_attr($min_area); ?>" placeholder="<?php echo $area_plac.' '.$area_unit; ?>">
</div><!-- form-group -->