<?php
get_header();
$is_sticky = '';
$sticky_sidebar = houzez_option('sticky_sidebar');
if( $sticky_sidebar['default_sidebar'] != 0 ) { 
    $is_sticky = 'houzez_sticky'; 
}

if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'archive' ) ) { ?>
<section class="blog-wrap">
        <div class="container">

            <div class="page-title-wrap">
                <?php get_template_part('template-parts/page/breadcrumb'); ?>
                <div class="d-flex align-items-center">
                    <div class="page-title flex-grow-1">
                        <h1>
                            <?php
                            if (is_category()) {
                                single_cat_title();

                            } elseif(is_tag()) {
                                single_tag_title();

                            } elseif ( is_post_type_archive( 'houzez_agent' ) || is_post_type_archive( 'houzez_agency' ) ) {
                                
                            } elseif (is_day()) {

                                printf( esc_html__( '%s', 'houzez' ), get_the_date() );

                            } elseif (is_month()) {
                                printf( esc_html__( '%s', 'houzez' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'houzez' ) ) );

                            } elseif (is_year()) {
                                printf( esc_html__( '%s', 'houzez' ), get_the_date( _x( 'Y', 'yearly archives date format', 'houzez' ) ) );

                            } elseif ( get_post_format() ) {
                                echo get_post_format();

                            }
                            ?>
                        </h1>
                    </div><!-- page-title -->
                </div><!-- d-flex -->  
            </div><!-- page-title-wrap -->

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
