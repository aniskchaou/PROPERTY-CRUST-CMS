<?php
/**
 * The Template for displaying all single posts
 * @since Houzez 1.0
 */

get_header();
$is_sticky = '';
$sticky_sidebar = houzez_option('sticky_sidebar');
if( $sticky_sidebar['default_sidebar'] != 0 ) { 
    $is_sticky = 'houzez_sticky'; 
}
$blog_author_box = houzez_option('blog_author_box');


if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'single' ) ) { ?>
<section class="blog-wrap">
    <div class="container">
        <div class="page-title-wrap">
            <?php get_template_part('template-parts/page/breadcrumb'); ?> 
        </div><!-- page-title-wrap -->
        <div class="row">
            <div class="col-lg-8 col-md-12 bt-content-wrap">                      

                <div class="article-wrap single-article-wrap">

                    <?php
                    // Start the Loop.
                    while ( have_posts() ) : the_post(); ?>

                        <article class="post-wrap">
                            
                            <div class="post-header-wrap">
                                <div class="post-title-wrap">
                                    <h1><?php the_title(); ?></h1>
                                </div><!-- post-title-wrap -->

                                <?php get_template_part('template-parts/blog/meta'); ?>

                            </div><!-- post-header-wrap -->

                            <div class="post-thumbnail-wrap">
                                <?php the_post_thumbnail('full', array('class' => 'img-fluid')); ?>
                            </div><!-- post-thumbnail-wrap -->

                            <div class="post-content-wrap">
                                <?php the_content(); ?>

                                <?php
                                $args = array(
                                    'before'           => '<div class="pagination-main"><ul class="pagination">' . esc_html__('Pages:','houzez'),
                                    'after'            => '</ul></div>',
                                    'link_before'      => '<span>',
                                    'link_after'       => '</span>',
                                    'next_or_number'   => 'next',
                                    'nextpagelink'     => '<span aria-hidden="true"><i class="fa fa-angle-right"></i></span>',
                                    'previouspagelink' => '<span aria-hidden="true"><i class="fa fa-angle-left"></i></span>',
                                    'pagelink'         => '%',
                                    'echo'             => 1
                                );
                                wp_link_pages( $args );
                                ?>
                                
                            </div><!-- post-content-wrap -->
                            

                            <?php 
                            if(houzez_option('blog_tags')) {
                                get_template_part( 'template-parts/blog/tags' ); 
                            }
                            ?>
                            

                        </article><!-- post-wrap -->

                        <?php 
                        if(houzez_option('blog_next_prev')) { 
                            get_template_part( 'template-parts/blog/next-prev-post' ); 
                        }

                        get_template_part( 'template-parts/blog/post-author' );

                        if(houzez_option('blog_related_posts')) {
                            get_template_part( 'template-parts/blog/related-posts' ); 
                        }
                        ?> 
                        
                        
                        <?php 
                        // If comments are open or we have at least one comment, load up the comment template.
                        if ( comments_open() || get_comments_number() ) {
                            comments_template();
                        }
                    endwhile; ?>
                </div><!-- article-wrap -->
            </div><!-- bt-content-wrap -->
            <div class="col-lg-4 col-md-12 bt-sidebar-wrap <?php echo esc_attr($is_sticky); ?>">
                <?php get_sidebar(); ?>
            </div><!-- bt-sidebar-wrap -->
        </div><!-- row -->
    </div><!-- container -->
</section><!-- blog-wrap -->

<?php
}
get_footer();
