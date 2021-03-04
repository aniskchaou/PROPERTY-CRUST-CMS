<div class="property-nav-wrap">
	<div class="d-flex justify-content-between">
		
		 <?php
	    $prevPost = get_previous_post(false);
	    if($prevPost) {
	    $args = array(
	        'post_type' => 'property',
	        'posts_per_page' => 1,
	        'include' => $prevPost->ID
	    );
	    $prevPost = get_posts($args);
	    foreach ($prevPost as $post) {
	    setup_postdata($post);
	    ?>
		<div class="prev-property d-flex align-items-center">
			<a href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail(array(60, 60), array('class' => 'img-fluid')); ?>
			</a>
			<div>
				<a class="property-nav-link" href="<?php the_permalink(); ?>">
					<?php echo esc_html__('Prev', 'houzez'); ?>
				</a>	
			</div>
		</div><!-- prev-property -->
		<?php
        wp_reset_postdata();
	    } //end foreach
	    } // end if
		
		$nextPost = get_next_post(false);
	    if($nextPost) {
	    $args = array(
	        'post_type' => 'property',
	        'posts_per_page' => 1,
	        'include' => $nextPost->ID
	    );
	    $nextPost = get_posts($args);
	    foreach ($nextPost as $post) {
	    setup_postdata($post);
	    ?>
		<div class="next-property d-flex align-items-center">
			<div>
				<a class="property-nav-link" href="<?php the_permalink(); ?>">
					<?php echo esc_html__('Next', 'houzez'); ?>
				</a>	
			</div>
			<a href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail(array(60, 60), array('class' => 'img-fluid')); ?>
			</a>
		</div><!-- next-property -->
		<?php
        wp_reset_postdata();
	    } //end foreach
	    } // end if
	    ?>

	</div><!-- d-flex -->
</div><!-- property-nav-wrap -->