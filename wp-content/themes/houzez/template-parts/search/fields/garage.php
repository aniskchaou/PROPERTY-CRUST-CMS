<?php
$garage = isset ( $_GET['garage'] ) ? esc_attr($_GET['garage']) : '';
$garage_plac = houzez_option('srh_garage', 'Garage');
?>
<div class="form-group">
	<input name="garage" type="number" class="form-control <?php houzez_ajax_search(); ?>" value="<?php echo esc_attr($garage); ?>" placeholder="<?php echo esc_attr($garage_plac); ?>">
</div><!-- form-group -->