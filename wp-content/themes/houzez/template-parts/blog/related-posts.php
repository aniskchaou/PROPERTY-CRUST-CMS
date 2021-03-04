<?php
global $post, $related_posts;
$categories = get_the_category( $post->ID );
if ($categories):
    $cat_ids = array();
    foreach($categories as $individual_cat) $cat_ids[] = $individual_cat->term_id;
    $args=array(
        'category__in' => $cat_ids,
        'post__not_in' => array( $post->ID ),
        'posts_per_page' => '3'
    );
    $related_posts = get_posts( $args );
endif;

if( $related_posts ) {
?>
<div class="related-posts-wrap">
	<h2><?php esc_html_e( 'Related posts', 'houzez' ); ?></h2>
	<div class="row">
		<?php foreach( $related_posts as $post ): setup_postdata( $post ); ?>
        <div class="col-md-4">
            <?php get_template_part('content-grid-1'); ?>
        </div>
    	<?php endforeach; ?>
	</div>
</div><!-- related-posts-wrap -->
<?php } ?>
<?php wp_reset_postdata(); ?>