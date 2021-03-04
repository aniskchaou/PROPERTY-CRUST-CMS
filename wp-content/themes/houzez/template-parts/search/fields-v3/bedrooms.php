<?php 
$bedrooms = isset($_GET['bedrooms']) ? $_GET['bedrooms'] : '';
$beds_count = 0;
if( !empty($bedrooms) ) {
	$beds_count = $bedrooms;
}
?>
<div class="btn-group">
	<button type="button" class="btn btn-light-grey-outlined" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		<i class="houzez-icon icon-hotel-double-bed-1 mr-1"></i> <?php echo houzez_option('srh_beds', 'Beds'); ?>
	</button>
	<div class="dropdown-menu dropdown-menu-small dropdown-menu-right advanced-search-dropdown clearfix">

		<div class="size-calculator">
			<span class="quantity-calculator beds_count"><?php echo esc_attr($beds_count); ?></span>
			<span class="calculator-label"><?php echo houzez_option('srh_bedrooms', 'Bedrooms'); ?></span>
			<button class="btn btn-primary-outlined btn_beds_plus" type="button">+</button>
			<button class="btn btn-primary-outlined btn_beds_minus" type="button">-</button>
			<input type="hidden" name="bedrooms" class="bedrooms <?php houzez_ajax_search(); ?>" value="<?php echo esc_attr($bedrooms); ?>">
		</div>

		<button class="btn btn-clear clear-beds"><?php echo houzez_option('srh_clear', 'Clear'); ?></button> 
		<button class="btn btn-apply"><?php echo houzez_option('srh_apply', 'Apply'); ?></button>
	</div><!-- advanced-search-dropdown -->
</div><!-- btn-group -->