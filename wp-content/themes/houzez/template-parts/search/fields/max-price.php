<?php
$max_price = isset ( $_GET['max-price'] ) ? esc_attr($_GET['max-price']) : '';
if( houzez_option('price_field_type', 'select') == 'input' ) { ?>

	<div class="form-group">
		<input name="max-price" type="text" class="form-control <?php houzez_ajax_search(); ?>" value="<?php echo esc_attr($max_price); ?>" placeholder="<?php echo houzez_option('srh_max_price', 'Max. Price'); ?>">
	</div><!-- form-group -->

<?php
} else {
?>
<div class="form-group prices-for-all">
	<select name="max-price" data-size="5" class="selectpicker <?php houzez_ajax_search(); ?> form-control bs-select-hidden" title="<?php echo houzez_option('srh_max_price', 'Max. Price');; ?>" data-live-search="false">
		<option value=""><?php echo houzez_option('srh_max_price', 'Max. Price'); ?></option>
		<?php houzez_adv_searches_max_price() ?>
	</select><!-- selectpicker -->
</div><!-- form-group -->

<div class="form-group hide prices-only-for-rent">
	<select name="max-price" data-size="5" class="selectpicker <?php houzez_ajax_search(); ?> form-control bs-select-hidden" title="<?php echo houzez_option('srh_max_price', 'Max. Price');; ?>" data-live-search="false">
		<option value=""><?php echo houzez_option('srh_max_price', 'Max. Price');; ?></option>
		<?php houzez_adv_searches_max_price_rent_only() ?>
	</select><!-- selectpicker -->
</div><!-- form-group -->
<?php } ?>