<?php
/**
 * Template Name: Houzez Page Builder
 * User: waqasriaz
 * Date: 21/12/15
 * Time: 1:35 PM
 */
global $post;
get_header(); 
$vc_enabled = get_post_meta($post->ID, '_wpb_vc_js_status', true);
?>

<section class="content-wrap">
    <?php

    if($vc_enabled) {
    	echo '<div class="container">';
    }

	while ( have_posts() ): the_post();
	the_content();
	endwhile;

	if($vc_enabled) {
    	echo '</div>';
    }
	?>
</section>

<?php get_footer(); ?>