<?php
global $post, $settings;
$similer_criteria = $settings['listing_from'];
$listing_view = $settings['listing_layout'];
$similer_count = $settings['no_of_posts'];
$sort_by = $settings['orderby'];
$layout_columns = $settings['layout_columns'];

$wrap_class = $item_layout = $view_class = $cols_in_row = '';
if($listing_view == 'list-view-v1') {
    $wrap_class = 'listing-v1';
    $item_layout = 'v1';
    $view_class = 'list-view';

} elseif($listing_view == 'grid-view-v1') {
    $wrap_class = 'listing-v1';
    $item_layout = 'v1';
    $view_class = 'grid-view';

} elseif($listing_view == 'list-view-v2') {
    $wrap_class = 'listing-v2';
    $item_layout = 'v2';
    $view_class = 'list-view';

} elseif($listing_view == 'grid-view-v2') {
    $wrap_class = 'listing-v2';
    $item_layout = 'v2';
    $view_class = 'grid-view';

} elseif($listing_view == 'grid-view-v3') {
    $wrap_class = 'listing-v3';
    $item_layout = 'v3';
    $view_class = 'grid-view';
    $have_switcher = false;

} elseif($listing_view == 'grid-view-v4') {
    $wrap_class = 'listing-v4';
    $item_layout = 'v4';
    $view_class = 'grid-view';
    $have_switcher = false;

} elseif($listing_view == 'list-view-v5') {
    $wrap_class = 'listing-v5';
    $item_layout = 'v5';
    $view_class = 'list-view';

} elseif($listing_view == 'grid-view-v5') {
    $wrap_class = 'listing-v5';
    $item_layout = 'v5';
    $view_class = 'grid-view';

} elseif($listing_view == 'grid-view-v6') {
    $wrap_class = 'listing-v6';
    $item_layout = 'v6';
    $view_class = 'grid-view';
    $have_switcher = false;

} else {
    $wrap_class = 'listing-v1';
    $item_layout = 'v1';
    $view_class = 'grid-view';
}

if( $view_class == 'list-view' ) {
    $layout_columns = '';
}


$properties_args = array(
	'post_type'           => 'property',
	'posts_per_page'      => intval( $similer_count ),
	'post__not_in'        => array( $post->ID ),
	'post_parent__not_in' => array( $post->ID ),
);

if ( ! empty( $similer_criteria ) && is_array( $similer_criteria ) ) {

	$similar_taxonomies_count = count( $similer_criteria );
	$tax_query                = array();

	for ( $i = 0; $i < $similar_taxonomies_count; $i ++ ) {
		
		$similar_terms = get_the_terms( $post->ID, $similer_criteria[ $i ] );
		if ( ! empty( $similar_terms ) && is_array( $similar_terms ) ) {
			$terms_array = array();
			foreach ( $similar_terms as $property_term ) {
				$terms_array[] = $property_term->term_id;
			}
			$tax_query[] = array(
				'taxonomy' => $similer_criteria[ $i ],
				'field'    => 'id',
				'terms'    => $terms_array,
			);
		}
	}

	$tax_count = count( $tax_query );  
	if ( $tax_count > 1 ) {
		$tax_query['relation'] = 'AND'; 
	}
	if ( $tax_count > 0 ) {
		$properties_args['tax_query'] = $tax_query; 
	}

}

if ( $sort_by == 'a_price' ) {
    $properties_args['orderby'] = 'meta_value_num';
    $properties_args['meta_key'] = 'fave_property_price';
    $properties_args['order'] = 'ASC';
} else if ( $sort_by == 'd_price' ) {
    $properties_args['orderby'] = 'meta_value_num';
    $properties_args['meta_key'] = 'fave_property_price';
    $properties_args['order'] = 'DESC';
} else if ( $sort_by == 'a_date' ) {
    $properties_args['orderby'] = 'date';
    $properties_args['order'] = 'ASC';
} else if ( $sort_by == 'd_date' ) {
    $properties_args['orderby'] = 'date';
    $properties_args['order'] = 'DESC';
} else if ( $sort_by == 'featured_first' ) {
    $properties_args['orderby'] = 'meta_value date';
    $properties_args['meta_key'] = 'fave_featured';
} else if ( $sort_by == 'random' ) {
    $properties_args['orderby'] = 'rand date';
}

$wp_query = new WP_Query($properties_args);

$section_title = isset($settings['section_title']) && !empty($settings['section_title']) ? $settings['section_title'] : houzez_option('sps_similar_listings', 'Similar Listings');

if ($wp_query->have_posts()) : ?>
	<div id="similar-listings-wrap" class="similar-property-wrap <?php echo esc_attr($wrap_class); ?>">
		
        <?php if( $settings['section_header'] ) { ?>
        <div class="block-title-wrap">
			<h2><?php echo esc_attr($section_title); ?></h2>
		</div><!-- block-title-wrap -->
        <?php } ?>

		<div class="listing-view <?php echo esc_attr($view_class).' '.esc_attr($layout_columns); ?> card-deck">
			<?php
			while ($wp_query->have_posts()) : $wp_query->the_post();

				get_template_part('template-parts/listing/item', $item_layout);

			endwhile;
			?> 
		</div><!-- listing-view -->
	</div><!-- similar-property-wrap -->
<?php
endif;
wp_reset_query();?>