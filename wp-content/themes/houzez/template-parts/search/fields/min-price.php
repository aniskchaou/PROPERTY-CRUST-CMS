<?php
$min_price = isset ( $_GET['min-price'] ) ? esc_attr($_GET['min-price']) : '';
if( houzez_option('price_field_type', 'select') == 'input' ) { ?>

	<div class="form-group">
		<input name="min-price" type="text" class="form-control <?php houzez_ajax_search(); ?>" value="<?php echo esc_attr($min_price); ?>" placeholder="<?php echo houzez_option('srh_min_price', 'Min. Price'); ?>">
	</div><!-- form-group -->

<?php
} else {
?>
<div class="form-group prices-for-all">
	<select name="min-price" data-size="5" class="selectpicker <?php houzez_ajax_search(); ?> form-control bs-select-hidden" title="<?php echo houzez_option('srh_min_price', 'Min. Price'); ?>" data-live-search="false">
		<option value=""><?php echo houzez_option('srh_min_price', 'Min. Price'); ?></option>
		<?php houzez_adv_searches_min_price(); ?>
	</select><!-- selectpicker -->
</div><!-- form-group -->

<div class="form-group hide prices-only-for-rent">
	<select name="min-price" data-size="5" class="selectpicker <?php houzez_ajax_search(); ?> form-control bs-select-hidden" title="<?php echo houzez_option('srh_min_price', 'Min. Price'); ?>" data-live-search="false">
		<option value=""><?php echo houzez_option('srh_min_price', 'Min. Price'); ?></option>
		<?php houzez_adv_searches_min_price_rent_only(); ?>
	</select><!-- selectpicker -->
</div><!-- form-group -->
<?php } ?>