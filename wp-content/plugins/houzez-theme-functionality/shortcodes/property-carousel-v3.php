<?php
/*-----------------------------------------------------------------------------------*/
/*	Property Carousel v2
/*-----------------------------------------------------------------------------------*/
if( !function_exists('houzez_prop_carousel_v3') ) {
	function houzez_prop_carousel_v3($atts, $content = null)
	{
		extract(shortcode_atts(array(
			'property_type' => '',
			'property_status' => '',
			'property_country' => '',
			'property_state' => '',
			'property_city' => '',
			'property_area' => '',
			'property_label' => '',
			'featured_prop' => '',
			'property_ids' => '',
			'posts_limit' => '',
			'sort_by' => '',
			'offset' => '',
			'all_btn' => '',
			'all_url' => '',
			'slides_to_show' => '',
			'slides_to_scroll' => '',
			'slide_auto' => '',
			'slide_infinite' => '',
			'auto_speed' => '',
			'navigation' => '',
			'slide_dots' => '',
			'thumb_size' => '',
			'min_price' => '',
			'max_price' => '',
			'properties_by_agents' => ''
		), $atts));

		ob_start();
		global $post, $ele_thumbnail_size;

		$ele_thumbnail_size = $thumb_size;

		$minify_js = houzez_option('minify_js');
		$js_minify_prefix = '';
		if( $minify_js != 0 ) {
			$js_minify_prefix = '.min';
		}

		//do the query
		$the_query = houzez_data_source::get_wp_query($atts); //by ref  do the query

		$token = wp_generate_password(5, false, false);
		wp_register_script('houzez_prop_caoursel', get_theme_file_uri('/js/property-carousels'.$js_minify_prefix.'.js'), array('jquery'), HOUZEZ_THEME_VERSION, true);
		$local_args = array(
			'slide_auto' => $slide_auto,
			'auto_speed' => $auto_speed,
			'navigation' => $navigation,
			'slide_dots' => $slide_dots,
			'slide_infinite' => $slide_infinite,
			'slides_to_show' => $slides_to_show,
			'slides_to_scroll' => $slides_to_scroll,
		);
		wp_localize_script('houzez_prop_caoursel', 'houzez_prop_caoursel_' . $token, $local_args);
		wp_enqueue_script('houzez_prop_caoursel');
		?>

		<div class="property-carousel-module houzez-carousel-arrows-<?php echo esc_attr($token); ?> houzez-carousel-cols-<?php echo esc_attr($slides_to_show); ?> property-carousel-module-v1-<?php echo esc_attr($slides_to_show); ?>cols">

			<div class="property-carousel-buttons-wrap">
				<?php if($navigation != "false") { ?>
				<button type="button" class="slick-prev-js-<?php echo esc_attr($token); ?> slick-prev btn-primary-outlined"><?php esc_html_e('Prev', 'houzez'); ?></button>
				<button type="button" class="slick-next-js-<?php echo esc_attr($token); ?> slick-next btn-primary-outlined"><?php esc_html_e('Next', 'houzez'); ?></button>
				<?php } ?>
				<?php if($all_url != '') { ?>
				<a href="<?php echo esc_url($all_url); ?>" class="btn btn-primary-outlined btn-view-all"><?php echo esc_attr($all_btn); ?></a>
				<?php } ?>
			</div><!-- property-carousel-buttons-wrap -->

			<div class="listing-view grid-view">
				<div id="houzez-properties-carousel-<?php echo esc_attr($token); ?>" data-token="<?php echo esc_attr($token); ?>" class="houzez-properties-carousel-js houzez-all-slider-wrap card-deck">
					<?php
					if ($the_query->have_posts()) : 
						while ($the_query->have_posts()) : $the_query->the_post();
							get_template_part('template-parts/listing/carousel-item', 'v3');
						endwhile; 
					endif;
					wp_reset_postdata();
					?>
				</div><!-- testimonials-slider -->
			</div><!-- listing-view grid-view -->
		</div><!-- testimonials-module -->

		<?php
		$result = ob_get_contents();
		ob_end_clean();
		return $result;

	}

	add_shortcode('houzez-prop-carousel', 'houzez_prop_carousel_v3');
}
?>