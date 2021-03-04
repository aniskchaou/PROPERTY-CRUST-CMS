<?php
$search_builder = houzez_option('dock_search_builder');
$layout = $search_builder['enabled'];
unset($layout['placebo']);

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


$enable_radius_search = houzez_option('dock_radius_search');
if($enable_radius_search != 1) {
	unset($layout['geolocation']);
}

if( houzez_option('dock_price_range') ) {
	unset($layout['min-price'], $layout['max-price']);
}

if(wp_is_mobile()) { 
	$advanced_fields = array_slice($layout, 1);
} else {
	$advanced_fields = array_slice($layout, houzez_option('dock_search_top_row_fields'));
}

?>

<div class="advanced-search-filters search-v1-v2">
	<div class="d-flex">
		<?php
		if ($advanced_fields) {
			foreach ($advanced_fields as $key=>$value) {
				if(in_array($key, houzez_search_builtIn_fields())) {
					if($key == 'price' || ($key == 'min-price')) {
						
						get_template_part('template-parts/search/fields/currency');
						
					}
					echo '<div class="flex-search">';
						get_template_part('template-parts/search/fields/'.$key);
					echo '</div>';
					
				} else {

					echo '<div class="flex-search">';
						houzez_get_custom_search_field($key);
					echo '</div>';
					
				}
			}
		}
		
		if( houzez_option('dock_price_range') ) { 
			get_template_part('template-parts/search/fields/currency');
		}
		?>

	</div>

	<?php if( houzez_option('dock_price_range') ) { ?>
	<div class="d-flex">
		<div class="flex-search-half">
			<?php get_template_part('template-parts/search/fields/price-range'); ?>
		</div>
	</div>
	<?php } ?>
</div>

<?php 
if( houzez_option('dock_search_other_features') ) {
	get_template_part('template-parts/search/other-features');
}