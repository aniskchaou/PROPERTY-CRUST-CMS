<?php
/*-----------------------------------------------------------------------------------*/
/*	Properties
/*-----------------------------------------------------------------------------------*/
if( !function_exists('houzez_property_card_v4') ) {
	function houzez_property_card_v4($atts, $content = null)
	{
		extract(shortcode_atts(array(
			'property_type' => '',
			'property_status' => '',
			'property_country' => '',
			'property_state' => '',
			'property_city' => '',
			'property_area' => '',
			'property_label' => '',
			'houzez_user_role' => '',
			'featured_prop' => '',
			'posts_limit' => '',
			'sort_by' => '',
			'offset' => '',
			'pagination_type' => '',
			'thumb_size' => '',
			'min_price' => '',
			'max_price' => '',
			'properties_by_agents' => ''
		), $atts));

		ob_start();
		global $paged, $ele_thumbnail_size;

		$ele_thumbnail_size = $thumb_size;
		
		if (is_front_page()) {
			$paged = (get_query_var('page')) ? get_query_var('page') : 1;
		}

		//do the query
		$the_query = houzez_data_source::get_wp_query($atts, $paged); //by ref  do the query
		?>
		
		<div id="properties_module_section" class="property-cards-module property-cards-module-v1 property-cards-module-2-cols">
			<div id="module_properties" class="listing-view grid-view card-deck">
				<?php
                if ( $the_query->have_posts() ) :
                    while ( $the_query->have_posts() ) : $the_query->the_post();

                        get_template_part('template-parts/listing/item', 'v4');

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
                    data-card="item-v4" 
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

	add_shortcode('houzez_property_card_v4', 'houzez_property_card_v4');
}
?>