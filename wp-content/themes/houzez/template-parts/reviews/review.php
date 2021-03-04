<?php 
$review_likes = get_post_meta(get_the_ID(), 'review_likes', true); 
$review_dislikes = get_post_meta(get_the_ID(), 'review_dislikes', true);
if(empty($review_likes)) {
	$review_likes = 0;
}
if(empty($review_dislikes)) {
	$review_dislikes = 0;
}
?>
<li id="review-<?php the_ID(); ?>" class="property-review">
	<div class="d-flex">
		<div class="review-image flex-grow-1">
			<img class="rounded-circle" src="<?php echo esc_url( houzez_get_profile_pic() );?>" width="64" height="64" alt="thumb">
		</div>
		<div class="review-message">
			<div class="d-flex align-items-center">
				<h4 class="review-title"><?php the_title(); ?></h4>
				<div class="rating-score-wrap flex-grow-1">
					<?php echo houzez_get_stars(get_post_meta(get_the_ID(), 'review_stars', true), false); ?>
				</div>
			</div><!-- d-flex -->
			<time class="review-date"><i class="houzez-icon icon-attachment mr-1"></i> <?php printf( esc_html__( '%s ago', 'houzez' ), human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) ); ?></time>

			<?php the_content(); ?>

			<div class="review-like mt-2">
				<ul class="likes-container-js list-inline">
					
					<li class="list-inline-item"><span class="vote-msg"></span></li>
					<?php get_template_part('template-parts/loader'); ?>
					<li class="list-inline-item review-like-button">
						<a class="hz-like-dislike-js" data-id="<?php echo intval(get_the_ID()); ?>" data-type="likes" data-msg="<?php esc_html_e('You have already voted', 'houzez'); ?>">
							<i class="houzez-icon icon-like mr-1"></i>
						</a> 
						<span class="likes-count"><?php echo esc_attr($review_likes); ?></span>
					</li>
					<li class="list-inline-item review-dislike-button">
						<a class="hz-like-dislike-js" data-id="<?php echo intval(get_the_ID()); ?>" data-type="dislikes" data-msg="<?php esc_html_e('You have already voted', 'houzez'); ?>">
							<i class="houzez-icon icon-dislike mr-1"></i>
						</a> 
						<span class="dislikes-count"><?php echo esc_attr($review_dislikes); ?></span>
					</li>
					
				</ul>
			</div>
		</div><!-- review-message -->
	</div><!-- d-flex -->
</li><!-- property-review -->