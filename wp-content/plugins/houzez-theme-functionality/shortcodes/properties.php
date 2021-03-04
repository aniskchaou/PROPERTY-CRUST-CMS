<?php
/*-----------------------------------------------------------------------------------*/
/*	Properties
/*-----------------------------------------------------------------------------------*/
if( !function_exists('houzez_properties') ) {
	function houzez_properties($atts, $content = null)
	{
		extract(shortcode_atts(array(
			'prop_grid_style' => '',
			'module_type' => '',
			'property_type' => '',
			'property_status' => '',
			'property_state' => '',
			'property_city' => '',
			'property_country' => '',
			'property_area' => '',
			'property_label' => '',
			'houzez_user_role' => '',
			'featured_prop' => '',
			'posts_limit' => '',
			'sort_by' => '',
			'offset' => '',
			'pagination_type' => '',
			'min_price' => '',
			'max_price' => '',
			'properties_by_agents' => ''
		), $atts));

		ob_start();
		global $paged;
		if (is_front_page()) {
			$paged = (get_query_var('page')) ? get_query_var('page') : 1;
		}
		
		if( $prop_grid_style == "v_2" ) {
			$css_classes = "property-cards-module-v2";
			$item_version = "item-v2";
		} else {
			$css_classes = "property-cards-module-v1";
			$item_version = "item-v1";
		}

		$cols_class = '';
		$view_class = "grid-view card-deck";

		if( $module_type == "grid_3_cols" ) {
			$cols_class = "property-cards-module-3-cols";
			$cols_class_2 = "grid-view-3-cols";

		} elseif( $module_type == "grid_2_cols" ) {
			$cols_class = "property-cards-module-2-cols";

		} elseif( $module_type == "list" ) {
			$view_class = "list-view card-deck";
		} else {
			$cols_class = "property-cards-module-3-cols";
			$cols_class_2 = "grid-view-3-cols";
		}

		//do the query
		$the_query = houzez_data_source::get_wp_query($atts, $paged); //by ref  do the query
		?>
		
		<div id="properties_module_section" class="property-cards-module <?php echo esc_attr($css_classes).' '.esc_attr($cols_class); ?>">
			<div id="module_properties" class="listing-view <?php echo esc_attr($view_class).' '.esc_attr($cols_class_2); ?>">
				<?php
                if ( $the_query->have_posts() ) :
                    while ( $the_query->have_posts() ) : $the_query->the_post();

                    	if( $prop_grid_style == "v_2" ) {
                    		get_template_part('template-parts/listing/item', 'v2');
                    	} else {
                    		get_template_part('template-parts/listing/item', 'v1');
                    	}
                        

                    endwhile;
                else:
                    get_template_part('template-parts/listing/item', 'none');
                endif;
                wp_reset_postdata();
                ?>

			</div><!-- listing-view -->

			<?php 
			if($pagination_type == 'number') { 
				houzez_pagination( $the_query->max_num_pages, $range = 2 );

			} elseif( $pagination_type == 'loadmore' ) { ?>
				<div id="fave-pagination-loadmore" class="load-more-wrap fave-load-more">
                    <a class="btn btn-primary-outlined btn-load-more"  
                    data-paged="2" 
                    data-prop-limit="<?php esc_attr_e($posts_limit); ?>" 
                    data-card="<?php echo esc_attr($item_version); ?>" 
                    data-type="<?php esc_attr_e($property_type); ?>" 
                    data-status="<?php esc_attr_e($property_status); ?>" 
                    data-state="<?php esc_attr_e($property_state); ?>" 
                    data-city="<?php esc_attr_e($property_city); ?>" 
                    data-country="<?php esc_attr_e($property_country); ?>" 
                    data-area="<?php esc_attr_e($property_area); ?>" 
                    data-label="<?php esc_attr_e($property_label); ?>" 
                    data-user-role="<?php esc_attr_e($houzez_user_role); ?>" 
                    data-featured-prop="<?php esc_attr_e($featured_prop); ?>" 
                    data-offset="<?php esc_attr_e($offset); ?>"
                    data-sortby="<?php esc_attr_e($sort_by); ?>"
                    href="#">
                    	<?php get_template_part('template-parts/loader'); ?>
                    	<?php esc_html_e('Load More', 'houzez'); ?>		
                    </a>               
				</div><!-- load-more-wrap -->
			<?php } ?>
		</div><!-- property-grid-module -->

		<?php
		$result = ob_get_contents();
		ob_end_clean();
		return $result;

	}

	add_shortcode('houzez-properties', 'houzez_properties');
}
?>