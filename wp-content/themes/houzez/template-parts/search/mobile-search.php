<?php
$search_builder = houzez_search_builder();
$search_fields = $search_builder['enabled'];

if(empty($search_fields)) {
	$search_fields = array();
}

$ajax_url_update = "";
$search_class = "";
if( houzez_is_half_map() ) {
	$search_class = 'overly_is_halfmap';
	$ajax_url_update = 'houzez-search-filters-js';
}

unset($search_fields['placebo']);
unset($search_fields['price']);
$multi_currency = houzez_option('multi_currency');

if(!taxonomy_exists('property_country')) {
    unset($search_fields['country']);
}

if(!taxonomy_exists('property_state')) {
    unset($search_fields['state']);
}

if(!taxonomy_exists('property_city')) {
    unset($search_fields['city']);
}

if(!taxonomy_exists('property_area')) {
    unset($search_fields['areas']);
}

if(houzez_is_radius_search() != 1) {
	unset($search_fields['geolocation']);
}

if(houzez_option('price_range_mobile')) {
	unset($search_fields['min-price'], $search_fields['max-price']);
}
?>
<section id="overlay-search-advanced-module" class="overlay-search-advanced-module <?php echo esc_attr($search_class); ?>">
	<div class="search-title">
		<?php esc_html_e('Search', 'houzez'); ?>
		<button type="button" class="btn overlay-search-module-close"><i class="houzez-icon icon-close"></i></button>
	</div>
	<form class="houzez-search-form-js <?php echo esc_attr($ajax_url_update); ?>" method="get" autocomplete="off" action="<?php echo esc_url( houzez_get_search_template_link() ); ?>">

		<?php do_action('houzez_search_hidden_fields'); ?>
		
	<div class="row">
		<?php
		if ($search_fields) {
			$i = 0;
			foreach ($search_fields as $key=>$value) { $i ++;

				$field_class = "col-6";
				if($i == 1) {
					$field_class = "col-12";
				}

				if($key == 'geolocation') {
					$field_class = "col-8";

				}
				if(in_array($key, houzez_search_builtIn_fields())) {

					if($key == 'min-price' && $multi_currency == 1) {
						echo '<div class="'.esc_attr($field_class).'">';
							get_template_part('template-parts/search/fields/currency');
						echo '</div>';
					}

					if($key == 'geolocation') {

						echo '<div class="'.esc_attr($field_class).'">';
							get_template_part('template-parts/search/fields/geolocation', 'mobile');
						echo '</div>';

						echo '<div class="col-4">';
							get_template_part('template-parts/search/fields/distance');
						echo '</div>';

					} else {

						echo '<div class="'.esc_attr($field_class).'">';
							get_template_part('template-parts/search/fields/'.$key);
						echo '</div>';
					}


				} else {

					echo '<div class="'.esc_attr($field_class).'">';
						houzez_get_custom_search_field($key);
					echo '</div>';
					
				}
			}
		}
		
		if(houzez_option('price_range_mobile')) { ?>
		<div class="col-12">
			<?php get_template_part('template-parts/search/fields/currency'); ?>
		</div>
		<div class="col-12">
			<?php get_template_part('template-parts/search/fields/price-range'); ?>
		</div>
		<?php } ?>

		<?php if(houzez_option('search_other_features_mobile')) { ?>
		<div class="col-12">
			<?php get_template_part('template-parts/search/other-features'); ?>
		</div>
		<?php } ?>
		
		<div class="col-12">
			<?php get_template_part('template-parts/search/fields/submit-button'); ?>
		</div>
	
	</div><!-- row -->
	</form>
</section><!-- overlay-search-advanced-module -->