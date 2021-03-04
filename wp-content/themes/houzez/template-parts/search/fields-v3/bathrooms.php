<?php 
$bathrooms = isset($_GET['bathrooms']) ? $_GET['bathrooms'] : '';
$baths_count = 0;
if( !empty($bathrooms) ) {
	$baths_count = $bathrooms;
}
?>
<div class="btn-group">
	<button type="button" class="btn btn-light-grey-outlined" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		<i class="houzez-icon icon-bathroom-shower-1 mr-1"></i> <?php echo houzez_option('srh_baths', 'Baths'); ?>
	</button>
	<div class="dropdown-menu dropdown-menu-small dropdown-menu-right advanced-search-dropdown clearfix">

		<div class="size-calculator">
			<span class="quantity-calculator baths_count"><?php echo esc_attr($baths_count); ?></span>
			<span class="calculator-label"><?php echo houzez_option('srh_bathrooms', 'Bathrooms'); ?></span>
			<button class="btn btn-primary-outlined btn_count_plus <?php houzez_ajax_search(); ?>" type="button">+</button>
			<button class="btn btn-primary-outlined btn_count_minus <?php houzez_ajax_search(); ?>" type="button">-</button>
			<input type="hidden" name="bathrooms" class="bathrooms" value="<?php echo esc_attr($bathrooms); ?>">
		</div>

		<button class="btn btn-clear clear-baths"><?php echo houzez_option('srh_clear', 'Clear'); ?></button> 
		<button class="btn btn-apply"><?php echo houzez_option('srh_apply', 'Apply'); ?></button>
	</div><!-- advanced-search-dropdown -->
</div><!-- btn-group -->