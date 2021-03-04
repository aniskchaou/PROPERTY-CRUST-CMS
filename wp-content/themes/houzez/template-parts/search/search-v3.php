<?php
global $sticky_hidden, $sticky_data, $hidden_data;
$search_builder = houzez_search_builder();
$layout = $search_builder['enabled'];
if(empty($layout)) {
	$layout = array();
}

if( (isset($_GET['search_style']) && $_GET['search_style'] == 'style_3') || ( isset($_GET['halfmap_search']) && $_GET['halfmap_search'] == 'v3') ) {
	$layout = houzez_dummy_search_style_3();
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

if(houzez_is_radius_search() != 1) {
	unset($layout['geolocation']);
}

$is_geolocation = '';
if(array_key_exists('geolocation', $layout)) {
	$is_geolocation = 'advanced-search-v1-geolocation';
}
?>
<section id="desktop-header-search" class="advanced-search advanced-search-nav <?php echo esc_attr($sticky_hidden); ?>" data-hidden="<?php echo esc_attr($hidden_data); ?>" data-sticky='<?php echo esc_attr( $sticky_data ); ?>'>
	<div class="<?php echo houzez_header_search_width(); ?>">
		<form class="houzez-search-form-js <?php houzez_search_filters_class(); ?>" method="get" autocomplete="off" action="<?php echo esc_url( houzez_get_search_template_link() ); ?>">

			<?php do_action('houzez_search_hidden_fields'); ?>
			
		<div class="advanced-search-v3">
			<div class="d-flex">
				
				<?php
				$i = 0;
				
				if ($layout) {
					foreach ($layout as $key=>$value) { $i ++;
						$class_flex_grow = '';
						$directory = 'fields';
						$common_class = "flex-search";
						if($key == 'keyword' || $key == 'geolocation') {
							$class_flex_grow = 'flex-grow-1';
						} elseif($i == 1) {
							$class_flex_grow = 'flex-grow-1';
						}

						if($key == 'type' || $key == 'status' || $key == 'price' || $key == 'label' || $key == 'bedrooms' || $key == 'bathrooms') {
							$directory = "fields-v3";
						}

						if(in_array($key, houzez_search_builtIn_fields())) {
							echo '<div class="'.$common_class.' '.$class_flex_grow.'">';
								get_template_part('template-parts/search/'.$directory.'/'.$key);
							echo '</div>';

							if($key == 'geolocation') {
								echo '<div class="flex-search">';
									get_template_part('template-parts/search/'.$directory.'/distance');
								echo '</div>';
							}
							
						} else {

							echo '<div class="'.$common_class.' '.$class_flex_grow.'">';
								houzez_get_custom_search_field($key);
							echo '</div>';
							
						}
						if($i == houzez_search_builder_first_row())
							break;
					}
				}
				?>

				<?php if( ! houzez_adv_search_visible() ) { ?>
				<div class="flex-search">
					<?php get_template_part('template-parts/search/fields-v3/more-options'); ?>
				</div>
				<?php } ?>
				
				<div class="flex-search btn-no-right-padding">
					<?php get_template_part('template-parts/search/fields/submit-button'); ?>
				</div>
			</div>
		</div>

		<div id="advanced-search-filters" class="collapse <?php echo houzez_adv_visible_class(); ?>">
			<?php get_template_part('template-parts/search/filters'); ?>
		</div>
		
	</form>
	</div>
</section>