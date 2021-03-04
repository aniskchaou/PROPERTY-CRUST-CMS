<?php
global $post;
$search_style = houzez_option('halfmap_search_layout', 'v1');
$search_builder = houzez_search_builder();
$layout = $search_builder['enabled'];

if(empty($layout)) {
	$layout = array();
}
unset($layout['placebo']);

if(houzez_is_radius_search() != 1) {
	unset($layout['geolocation']);
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

if(houzez_option('price_range_halfmap')) {
	unset($layout['min-price'], $layout['max-price']);
}

if($search_style != 'v3') {
	unset($layout['price']);
}
$advanced_fields = array_slice($layout, houzez_search_builder_first_row());
?>
<section class="advanced-search advanced-search-half-map">
	<div class="container">
		<form class="houzez-search-form-js houzez-search-filters-js" method="get" autocomplete="off" action="<?php echo esc_url( houzez_get_search_template_link() ); ?>">

		<?php do_action('houzez_search_hidden_fields'); ?>

		<div class="d-flex">
			<?php
			if ($layout) {
				$i = 0;
				foreach ($layout as $key=>$value) { $i++;
					$class_flex_grow = '';
					$common_class = "flex-search";
					if($key == 'keyword' && $i == 1 ) {
						$class_flex_grow = 'full-width';

					} elseif($key == 'geolocation' && $i == 1 ) {
						$class_flex_grow = 'geolocation-width';
					} else if($key == 'geolocation') {
						$class_flex_grow = 'flex-grow-1';
					}

					if(in_array($key, houzez_search_builtIn_fields())) {

						if($key == 'price' || ($key == 'min-price')) {
						
							get_template_part('template-parts/search/fields/currency');
							
						}
						echo '<div class="'.$common_class.' '.$class_flex_grow.'">';
							get_template_part('template-parts/search/fields/'.$key);
						echo '</div>';

						if($key == 'geolocation') {
							
							get_template_part('template-parts/search/fields/distance-range');
							
						}
					} else {

						echo '<div class="'.$common_class.' '.$class_flex_grow.'">';
							houzez_get_custom_search_field($key);
						echo '</div>';
						
					}
				}
			}
			if(houzez_option('price_range_halfmap')) { 
				get_template_part('template-parts/search/fields/currency');
			}
			?>
		</div>

		<?php if(houzez_option('price_range_halfmap')) { ?>
		<div class="d-flex">
			<div class="flex-search-half">
				<?php get_template_part('template-parts/search/fields/price-range'); ?>
			</div>
		</div>
		<?php } ?>

		<div class="half-map-features-list-wrap">
			<?php 
			if(houzez_option('search_other_features_halfmap')) {
				get_template_part('template-parts/search/other-features');
			}
			?>
		</div><!-- half-map-features-list-wrap -->
		
		<div class="d-flex half-map-buttons-wrap">
			<button type="submit" class="btn btn-search half-map-search-js-btn btn-secondary btn-full-width"><?php echo houzez_option('srh_btn_search', 'Search'); ?></button>
			<?php get_template_part('template-parts/search/save-search-btn'); ?>
		</div>
	</form>
	</div><!-- container -->
</section><!-- advanced-search -->