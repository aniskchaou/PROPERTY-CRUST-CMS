
<div class="btn-group">
	<button type="button" class="btn btn-light-grey-outlined" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		<?php echo houzez_option('srh_price', 'Price'); ?>
	</button>
	<div class="dropdown-menu dropdown-menu-medium dropdown-menu-right advanced-search-dropdown clearfix">
		
		<div class="range-text">
			<input type="hidden" name="min-price" class="min-price-range-hidden range-input" readonly >
    		<input type="hidden" name="max-price" class="max-price-range-hidden range-input" readonly >
			<span class="min-price-range"></span> - <span class="max-price-range"></span>
		</div><!-- range-text -->
		<div class="price-range-wrap">
			<div class="price-range"></div><!-- price-range -->
		</div><!-- price-range-wrap -->
 
		<button class="btn btn-apply"><?php echo houzez_option('srh_apply', 'Apply'); ?></button>
	</div><!-- advanced-search-dropdown -->
</div><!-- btn-group -->