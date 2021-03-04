<?php
$year_built = isset ( $_GET['year-built'] ) ? esc_attr($_GET['year-built']) : '';
$year_built_plac = houzez_option('srh_year_built', 'Year Built');
?>
<div class="form-group">
	<input name="year-built" type="number" class="form-control <?php houzez_ajax_search(); ?>" value="<?php echo esc_attr($year_built); ?>" placeholder="<?php echo esc_attr($year_built_plac); ?>">
</div><!-- form-group -->