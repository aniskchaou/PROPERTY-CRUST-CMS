<?php 
/**
 * The template for displaying all pages
 *
 * @package Houzez
 * @since 	Houzez 1.0
 * @author  Waqas Riaz
**/
global $post, $page_bg;
$sticky_sidebar = houzez_option('sticky_sidebar');
$sidebar_meta = houzez_get_sidebar_meta($post->ID);
$page_bg = 'page-content-wrap';
?>

<?php get_header(); ?>
	
	<section class="page-wrap">
        <div class="container">
            <div class="page-title-wrap">
                <?php get_template_part('template-parts/page/breadcrumb');  ?> 
                <div class="d-flex align-items-center">
                    <?php get_template_part('template-parts/page/page-title');  ?> 
                </div><!-- d-flex -->  
            </div><!-- page-title-wrap -->
            <div class="row">
                <div class="col-lg-8 col-md-12 bt-content-wrap">                      
                    <div class="article-wrap">
                        <?php
						// Start the loop.
						while ( have_posts() ) : the_post();

							// Include the page content template.
							get_template_part( 'content', 'page' );

							// If comments are open or we have at least one comment, load up the comment template.
							if ( comments_open() || get_comments_number() ) :
								comments_template();
							endif;

							// End the loop.
						endwhile;
						?>
                    </div>
                </div><!-- bt-content-wrap -->
                <div class="col-lg-4 col-md-12 bt-sidebar-wrap <?php if( $sticky_sidebar['page_sidebar'] != 0 ){ echo 'houzez_sticky'; }?>">
                    <div class="theiaStickySidebar">
                        <?php
						if( $sidebar_meta['specific_sidebar'] == 'yes' ) {
							if( is_active_sidebar( $sidebar_meta['selected_sidebar'] ) ) {
								dynamic_sidebar( $sidebar_meta['selected_sidebar'] );
							}
						} else {
							if( is_active_sidebar( 'page-sidebar' ) ) {
								dynamic_sidebar( 'page-sidebar' );
							}
						}
						?>
                    </div><!-- theiaStickySidebar -->
                </div><!-- bt-sidebar-wrap -->
            </div><!-- row -->
        </div><!-- container -->
    </section><!-- listing-wrap -->

<?php get_footer(); ?>