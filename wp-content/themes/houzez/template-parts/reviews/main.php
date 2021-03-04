<?php
global $ele_settings, $author_id;
$num_of_review = houzez_option('num_of_review', 5);

$section_header = isset($ele_settings['section_header']) ? $ele_settings['section_header'] : true;
$section_title = isset($ele_settings['section_title']) && !empty($ele_settings['section_title']) ? $ele_settings['section_title'] : esc_html__('Leave a Review', 'houzez');

if( is_singular( 'property' ) ) {
	$meta_key = 'review_property_id';
	$meta_value = get_the_ID();

} elseif( is_singular( 'houzez_agent' ) ) {
	$meta_key = 'review_agent_id';
	$meta_value = get_the_ID();

} elseif( is_singular( 'houzez_agency' ) ) {
	$meta_key = 'review_agency_id';
	$meta_value = get_the_ID();
	
} elseif( is_author() ) {
	$meta_key = 'review_author_id';
	$meta_value = $author_id;
	
}

$args = array(
    'post_type' => 'houzez_reviews',
    'meta_key' => $meta_key,
    'meta_value' => $meta_value,
    'posts_per_page' => $num_of_review,
    'post_status' => 'publish',
);
$review_qry = new WP_Query( $args );

$total_review = $review_qry->found_posts;

$total_pages = $review_qry->max_num_pages;

if($total_review > 1) {
	$review_label = esc_html__('Reviews', 'houzez');
} else {
	$review_label = esc_html__('Review', 'houzez');
}

$total_ratings = get_post_meta(get_the_ID(), 'houzez_total_rating', true);
?>
<div class="property-review-wrap property-section-wrap" id="property-review-wrap">
	<div class="block-title-wrap review-title-wrap d-flex align-items-center">
		<h2><?php echo esc_attr($total_review); ?> <?php echo esc_attr($review_label); ?></h2>
		<div class="rating-score-wrap flex-grow-1">
			<?php echo houzez_get_stars($total_ratings, false); ?>

			<?php if(!empty($total_ratings)) { ?>
			<span class="star-text star-text-right">
	            (<span itemprop="ratingValue"><?php echo esc_attr(round($total_ratings, 2)); ?></span> <?php esc_html_e('out of', 'houzez'); ?> <span itemprop="bestRating">5</span>)
	        </span>
	    	<?php } ?>
		</div>	
		
		<?php get_template_part('template-parts/reviews/sortby'); ?>

		<a class="btn btn-primary btn-slim" href="#property-review-form"><?php esc_html_e('Leave a Review', 'houzez'); ?></a>
	</div>

	<input type="hidden" name="review_paged" id="review_paged" value="1">
	<input type="hidden" name="total_pages" id="total_pages" value="<?php echo intval($total_pages); ?>">
	
	<ul id="houzez_reviews_container" class="review-list-wrap list-unstyled">
		<?php 
        if ( $review_qry->have_posts() ) :
            while ( $review_qry->have_posts() ) : $review_qry->the_post();

                get_template_part('template-parts/reviews/review'); 

            endwhile;
        else:
            get_template_part('template-parts/listing/review', 'none');
        endif;
        wp_reset_postdata();
		

		?>
	</ul>

	<?php if($total_review > $num_of_review) { ?>
	<div class="pagination-wrap">
		<nav>
			<ul class="pagination justify-content-center">
				<li class="page-item">
					<button class="page-link" disabled id="review_prev" aria-label="<?php esc_html_e('Previous', 'houzez'); ?>">
						<i class="houzez-icon icon-arrow-left-1"></i>
					</button>
				</li>
				<li class="page-item">
					<button class="page-link" id="review_next" aria-label="<?php esc_html_e('Next', 'houzez'); ?>">
						<i class="houzez-icon icon-arrow-right-1"></i>
					</button>
				</li>
			</ul><!-- pagination -->
		</nav>
	</div>
	<?php } ?>

	<div class="block-wrap" id="property-review-form">
		<?php if( $section_header ) { ?>
		<div class="block-title-wrap">
			<h3><?php echo esc_attr($section_title); ?></h3>
		</div>
		<?php } ?>

		<?php get_template_part('template-parts/reviews/form'); ?>
	</div>
</div>