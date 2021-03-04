<?php
/*-----------------------------------------------------------------------------------*/
/*	Module 1
/*-----------------------------------------------------------------------------------*/
if( !function_exists('houzez_grids') ) {
	function houzez_grids($atts, $content = null)
	{
		extract(shortcode_atts(array(
			'houzez_grid_type' => '',
			'houzez_grid_from' => '',
			'houzez_show_child' => '',
			'houzez_hide_count' => '',
			'orderby' 			=> '',
			'order' 			=> '',
			'houzez_hide_empty' => '',
			'no_of_terms' 		=> '',
			'property_type' => '',
			'property_status' => '',
			'property_area' => '',
			'property_state' => '',
			'property_country' => '',
			'get_lazyload' => '',
			'property_city' => '',
			'property_label' => ''
		), $atts));

		ob_start();
		$module_type = '';
		
		$slugs = '';

		if( $houzez_grid_from == 'property_city' ) {
			$slugs = $property_city;

		} else if ( $houzez_grid_from == 'property_area' ) {
			$slugs = $property_area;

		} else if ( $houzez_grid_from == 'property_label' ) {
			$slugs = $property_label;

		} else if ( $houzez_grid_from == 'property_country' ) {
			$slugs = $property_country;

		} else if ( $houzez_grid_from == 'property_state' ) {
			$slugs = $property_state;

		} else if ( $houzez_grid_from == 'property_status' ) {
			$slugs = $property_status;

		} else {
			$slugs = $property_type;
		}

		if ($houzez_show_child == 1) {
			$houzez_show_child = '';
		}
		if ($houzez_grid_type == 'grid_v2') {
			$module_type = 'location-module-v2';
		}

		if( $houzez_grid_from == 'property_type' ) {
			$custom_link_for = 'fave_prop_type_custom_link';
		} else {
			$custom_link_for = 'fave_prop_taxonomy_custom_link';
		}
		?>
		<div class="taxonomy-grids-module taxonomy-grids-module-v1">
    		<div class="row">
				<?php
				$tax_name = $houzez_grid_from;
				$taxonomy = get_terms(array(
					'hide_empty' => $houzez_hide_empty,
					'parent' => $houzez_show_child,
					'slug' => houzez_traverse_comma_string($slugs),
					'number' => $no_of_terms,
					'orderby' => $orderby,
					'order' => $order,
					'taxonomy' => $tax_name,
				));
				$i = 0;
				$j = 0;
				if ( !is_wp_error( $taxonomy ) ) {
				
					foreach ($taxonomy as $term) {

						$i++;
						$j++;

						if ($houzez_grid_type == 'grid_v1') {
							if ($i == 1 || $i == 4) {
								$col = 'col-md-4 col-sm-12';
								$item_class = 'taxonomy-item-square';
							} else {
								$col = 'col-md-8 col-sm-12';
								$item_class = 'taxonomy-item-rectangle';
							}
							if ($i == 4) {
								$i = 0;
							}
						} elseif ($houzez_grid_type == 'grid_v2') {
							$col = 'col-md-4 col-sm-6';
							$item_class = 'taxonomy-item-square';

						} elseif ($houzez_grid_type == 'grid_v3') {
							$col = 'col-lg-3 col-md-6';
							$item_class = 'taxonomy-item-square';

						} elseif ($houzez_grid_type == 'grid_v4') {
							if ($i == 1 || $i == 6) {
								$col = 'col-lg-6 col-md-12';
								$item_class = 'taxonomy-item-rectangle';
							} else {
								$col = 'col-lg-3 col-md-6 col-sm-6';
								$item_class = 'taxonomy-item-square';
							}
							if ($i == 6) {
								$i = 0;
							}
						} 

						$term_img_id = get_term_meta($term->term_id, 'fave_taxonomy_img', true);
						$taxonomy_custom_link = get_term_meta($term->term_id, 'fave_prop_taxonomy_custom_link', true);

						$img_url = wp_get_attachment_url( $term_img_id );

						if( !empty($taxonomy_custom_link) ) {
							$term_link = $taxonomy_custom_link;
						} else {
							$term_link = get_term_link($term, $tax_name);
						}

						?>
						<div class="<?php echo esc_attr($col); ?>">
            				<div class="<?php echo esc_attr($item_class); ?>">
								<div class="taxonomy-item <?php echo $get_lazyload; ?>" style="background-image: url(<?php echo esc_url($img_url); ?>);">
									<a class="taxonomy-link hover-effect-flat" href="<?php echo esc_url($term_link); ?>">
										<div class="taxonomy-text-wrap">
											<div class="taxonomy-title"><?php echo esc_attr($term->name); ?></div>
											
											<?php if( $houzez_hide_count != 1 ) { ?>
											<div class="taxonomy-subtitle">
												<?php echo esc_attr($term->count); ?> 
												<?php
												if ($term->count < 2) {
													echo houzez_option('cl_property', 'Property');
												} else {
													echo houzez_option('cl_properties', 'Properties');
												}
												?>
											</div>
											<?php } ?>
										</div><!-- taxonomy-text-wrap -->
									</a>
								</div>
							</div>
						</div>

						<?php
					}
				}
				?>
			</div>
		</div>
		<?php
		$result = ob_get_contents();
		ob_end_clean();
		return $result;

	}

	add_shortcode('hz-grids', 'houzez_grids');
}
?>