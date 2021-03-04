<?php
$checked = true;
$radius_unit = houzez_option('radius_unit');
$enable_radius_search = houzez_option('enable_radius_search_halfmap');

$default_radius = isset($_GET['radius']) ? $_GET['radius'] : houzez_option('houzez_default_radius', 30);

?>
<div class="d-flex geolocation-width">
	<div class="flex-search">
		<label class="control control--checkbox">
			<input name="use_radius" id="use_radius" <?php checked( true, $checked ); ?> type="checkbox"><?php echo houzez_option('srh_radius', 'Radius'); ?> <strong><span id="radius-range-text">0</span> <?php echo esc_attr($radius_unit); ?></strong>
			<span class="control__indicator"></span>
		</label>
	</div><!-- flex-search -->
	<div class="flex-search flex-grow-1">
		<div class="distance-range-wrap">
			<div id="radius-range-slider" class="distance-range"></div><!-- price-range -->
			<input type="hidden" data-default="<?php echo esc_attr($default_radius); ?>" name="radius" id="radius-range-value">
		</div><!-- price-range-wrap -->
	</div><!-- flex-search -->
</div><!-- d-flex -->