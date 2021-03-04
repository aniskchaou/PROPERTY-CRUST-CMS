<?php
/**
 * Template Name: Blog Masonry Template
 * Created by PhpStorm.
 * User: waqasriaz
 * Date: 25/01/16
 * Time: 9:12 PM
 */
get_header();
global $houzez_local, $wp_query, $paged;
if ( is_front_page()  ) {
    $paged = (get_query_var('page')) ? get_query_var('page') : 1;
}

$number_of_posts = houzez_option('masorny_num_posts');
if (!$number_of_posts) {
    $number_of_posts = '12';
}

$wp_query_args = array(
'post_type' => 'post',
'posts_per_page' => $number_of_posts,
'paged' => $paged,
'post_status' => 'publish'
);
$the_query = New WP_Query($wp_query_args);
?>

<section class="blog-wrap">
    <div class="container">
        <div class="page-title-wrap">
            <?php get_template_part('template-parts/page/breadcrumb'); ?> 
            <div class="d-flex align-items-center">
                <?php get_template_part('template-parts/page/page-title'); ?> 
            </div><!-- d-flex -->  
        </div><!-- page-title-wrap -->
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="masonry">

                    <?php 
                    if( $the_query->have_posts() ): 
                        while( $the_query->have_posts() ): $the_query->the_post(); ?>

                            <div class="masonry-brick">
                                <div class="masonry-content">
                                    <?php get_template_part('template-parts/blog/masonry-post'); ?>     
                                </div>
                            </div>

                    <?php endwhile; endif; ?>
                    <?php wp_reset_postdata(); ?>
                    
                </div><!-- masonry -->

                <?php houzez_pagination( $the_query->max_num_pages, $range = 2 ); ?>

            </div><!-- bt-content-wrap -->
        </div><!-- row -->
    </div><!-- container -->
</section><!-- listing-wrap -->
<?php get_footer(); ?>