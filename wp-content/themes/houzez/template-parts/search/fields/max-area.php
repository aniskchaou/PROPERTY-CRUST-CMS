<?php
$max_area = isset ( $_GET['max-area'] ) ? esc_attr($_GET['max-area']) : '';
$area_plac = houzez_option('srh_max_area', 'Max. Area');
$area_unit = houzez_area_unit_label();
if(!empty($area_unit)) {
	$area_unit = '('.$area_unit.')';
}
?>
<div class="form-group">
	<input name="max-area" type="text" class="form-control <?php houzez_ajax_search(); ?>" value="<?php echo esc_attr($max_area); ?>" placeholder="<?php echo $area_plac.' '.$area_unit; ?>">
</div><!-- form-group -->