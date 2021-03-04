<?php
/**
 * Template Name: Page Template
 * Created by PhpStorm.
 * User: waqasriaz
 * Date: 21/12/15
 * Time: 1:35 PM
 */
global $houzez_local, $post, $page_bg;

$page_bg = 'page-content-wrap';
$content_area = $row_class = '';

$page_sidebar = get_post_meta( $post->ID, 'fave_page_sidebar', true );
$page_title = get_post_meta( $post->ID, 'fave_page_title', true );
$page_breadcrumb = get_post_meta( $post->ID, 'fave_page_breadcrumb', true );
$page_background = get_post_meta( $post->ID, 'fave_page_background', true );

$content_area = 'col-lg-8 col-md-12 bt-content-wrap';
if( $page_sidebar == 'none' ) {
	$content_area = 'col-lg-12';
} else if( $page_sidebar == 'left_sidebar' ) {

	$row_class = 'flex-row-reverse';

} else if( $page_sidebar == 'right_sidebar' ) {
	$row_class = '';
}

if( $page_background == 'none' && $page_sidebar == 'none' ) {
	$page_bg = '';
}
$sticky_sidebar = houzez_option('sticky_sidebar');
$sidebar_meta = houzez_get_sidebar_meta($post->ID);
?>

<?php get_header(); ?>
	
<section class="page-wrap">
    <div class="container">
        <div class="page-title-wrap">
            <?php 
            if($page_breadcrumb != 'hide') {
	            get_template_part('template-parts/page/breadcrumb'); 
	        }?>
            <div class="d-flex align-items-center">
                <?php 
                if($page_title != 'hide') {
	                get_template_part('template-parts/page/page-title'); 
	            }?>  
            </div><!-- d-flex -->  
        </div><!-- page-title-wrap -->
        <div class="row <?php echo esc_attr( $row_class ); ?>">
            <div class="<?php echo esc_attr( $content_area ); ?>">                      
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

            <?php if( $page_sidebar != 'none' ) { ?>
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
        	<?php } ?>

        </div><!-- row -->
    </div><!-- container -->
</section><!-- listing-wrap -->

<?php get_footer(); ?>