<?php
get_header();

$is_sticky = '';
$sticky_sidebar = houzez_option('sticky_sidebar');
if( $sticky_sidebar['default_sidebar'] != 0 ) { 
    $is_sticky = 'houzez_sticky'; 
}
if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'archive' ) ) { ?>
<section class="blog-wrap houzez-blog-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-12 bt-content-wrap">
                    <?php
                    if ( have_posts() ) :

                        while ( have_posts() ) : the_post();

                            get_template_part('template-parts/blog/blog-post');

                        endwhile;

                    else :
                        // If no content, include the "No posts found" template.
                        get_template_part( 'content', 'none' );

                    endif;
                    ?>
                    
                    <!--start pagination-->
                    <?php houzez_pagination( $wp_query->max_num_pages ); ?>
                    <!--end pagination-->

                </div><!-- bt-content-wrap -->
                <div class="col-lg-4 col-md-12 bt-sidebar-wrap <?php echo esc_attr($is_sticky); ?>">
                    <?php get_sidebar(); ?>
                </div><!-- bt-sidebar-wrap -->
            </div><!-- row -->
        </div><!-- container -->
    </section><!-- listing-wrap -->

<?php
}
get_footer();
