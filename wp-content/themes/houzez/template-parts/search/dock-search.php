<?php
$keep_search_opened = houzez_option('keep_adv_search_live');
$search_show = '';
if($keep_search_opened == 1) {
	$search_show = 'show';
}

$search_builder = houzez_option('dock_search_builder');
$layout = $search_builder['enabled'];
if(empty($layout)) {
	$layout = array();
}

if(!taxonomy_exists('property_country')) {
    unset($layout['country']);
}

if(!taxonomy_exists('property_state')) {
    unset($layout['state']);
}

if(!taxonomy_exists('property_city')) {
    unset($layout['city']);
}

if(!taxonomy_exists('property_area')) {
    unset($layout['areas']);
}

unset($layout['placebo']);

if( houzez_option('dock_radius_search') != 1 ) {
	unset($layout['geolocation']);
}
unset($layout['price']);

$is_geolocation = '';
if(array_key_exists('geolocation', $layout)) {
	$is_geolocation = 'advanced-search-v1-geolocation';
}
$both_keyword_location = $width_needed = false;
if(!array_key_exists('geolocation', $layout) && !array_key_exists('keyword', $layout)) {
	$both_keyword_location = true;
	$is_geolocation = 'advanced-search-v1-geolocation';

} else if(array_key_exists('geolocation', $layout) || array_key_exists('keyword', $layout)) {
	$width_needed = true;
}
?>
<div class="advanced-search search-expandable-wrap">
	<div class="container">
		<div class="search-expandable-label" data-toggle="collapse" href="#search-expandable-collapse">
			<?php echo houzez_option('srh_dock_title', 'Advanced Search'); ?> <i class="houzez-icon icon-arrow-down-1 float-right"></i>
		</div><!-- search-expandable-label -->
	</div><!-- container -->
	<div class="container">
		<div id="search-expandable-collapse" class="search-expandable collapse <?php echo esc_attr($search_show); ?>">
			<form class="houzez-search-form-js" method="get" autocomplete="off" action="<?php echo esc_url( houzez_get_search_template_link() ); ?>">
				<div class="search-expandable-inner-wrap">
					<div class="row">
						<div class="col-lg-9 col-md-12">
							<div class="advanced-search-v1 <?php echo esc_attr($is_geolocation); ?>">
								<div class="d-flex">
									<?php
									$i = 0;
									if ($layout) {
										foreach ($layout as $key=>$value) { $i ++;
											$class_flex_grow = '';
											$common_class = "flex-search";
											if($key == 'keyword') {
												$class_flex_grow = 'flex-grow-1';

											} elseif($key == 'geolocation') {
												$class_flex_grow = 'flex-fill';
												$common_class = '';

											} elseif($both_keyword_location) {
												$common_class = 'flex-fill fields-width';

											} elseif($width_needed) {
												$common_class .= ' fields-width';
											}

											if(in_array($key, houzez_search_builtIn_fields())) {
												

												if($key == 'geolocation') {

													echo '<div class="'.$common_class.' '.$class_flex_grow.'">';
														get_template_part('template-parts/search/fields/geolocation-dock');
													echo '</div>';
													echo '<div class="flex-search">';
														get_template_part('template-parts/search/fields/distance');
													echo '</div>';

												} else {

													echo '<div class="'.$common_class.' '.$class_flex_grow.'">';
														get_template_part('template-parts/search/fields/'.$key);
													echo '</div>';
												}
											} else {

												echo '<div class="'.$common_class.' '.$class_flex_grow.'">';
													houzez_get_custom_search_field($key);
												echo '</div>';
												
											}

											if(wp_is_mobile()) {

												if($i == 1)
													break;

											} else {
												if($i == houzez_option('dock_search_top_row_fields'))
													break;
											}
										}
									}
									?>	
								</div>
								<div id="advanced-dock-search-filters">
									<?php get_template_part('template-parts/search/filters-dock'); ?>
								</div><!-- advanced-search-filters -->						
							</div><!-- advanced-search-v1 -->
						</div>	
						<div class="col-lg-3 col-md-12">
							<div class="flex-search search-expandable-search-button">
								<?php get_template_part('template-parts/search/fields/submit-button'); ?>
							</div><!-- flex-search -->
							<?php if( houzez_option('dock_search_other_features') ) { ?>
							<div class="flex-search search-expandable-search-button">					
								<button class="btn advanced-search-btn btn-full-width" type="button" data-toggle="collapse" href="#features-list">
									<i class="houzez-icon icon-cog mr-1"></i> <?php echo houzez_option('srh_btn_more', 'More Options'); ?> 
								</button>
							</div><!-- flex-search -->
							<?php } ?>
						</div>
					</div><!-- search-expandable-inner-wrap -->	
				</div><!-- row -->
			</form>
		</div><!-- search-expandable -->
	</div><!-- container -->
</div><!-- advanced-search -->