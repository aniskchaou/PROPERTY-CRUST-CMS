<?php
/**
 * Template Name1: Template listings Infinite
 * Created by PhpStorm.
 * User: waqasriaz
 * Date: 16/12/15
 * Time: 3:27 PM
 */

if( houzez_is_ajax_request() ) {

    echo "this is test";

} else {
get_header();

global $post, $listings_tabs, $total_listing_found;

$is_sticky = '';
$sticky_sidebar = houzez_option('sticky_sidebar');
if( $sticky_sidebar['property_listings'] != 0 ) { 
    $is_sticky = 'houzez_sticky'; 
}

$page_content_position = houzez_get_listing_data('listing_page_content_area');

$listing_args = array(
    'post_type' => 'property',
    'post_status' => 'publish'
);

$listing_args = apply_filters( 'houzez20_property_filter', $listing_args );
$listing_args = houzez_prop_sort ( $listing_args );

$listings_query = new WP_Query( $listing_args );
$total_listing_found = $listings_query->found_posts;

$listings_tabs = get_post_meta( $post->ID, 'fave_listings_tabs', true );
$mb = '';
if( $listings_tabs != 'enable' ) {
    $mb = 'mb-2';
}
?>
<section class="listing-wrap listing-v1">
    <div class="container">
        
        <div class="page-title-wrap">

            <?php get_template_part('template-parts/listing/listing-page-title'); ?>

        </div><!-- page-title-wrap -->

        <div class="row">
            <div class="col-lg-8 col-md-12 bt-content-wrap <?php echo houzez_option('template_sidebar_pos', ''); ?>"> 

                <?php
                if ( $page_content_position !== '1' ) {
                    if ( have_posts() ) {
                        while ( have_posts() ) {
                            the_post();
                            ?>
                            <article <?php post_class(); ?>>
                                <?php the_content(); ?>
                            </article>
                            <?php
                        }
                    } 
                }?>

                <div class="listing-tools-wrap">
                    <div class="d-flex align-items-center <?php echo esc_attr($mb); ?>">
                        <?php get_template_part('template-parts/listing/listing-tabs'); ?>    
                        <?php get_template_part('template-parts/listing/listing-sort-by'); ?>      
                    </div><!-- d-flex -->
                </div><!-- listing-tools-wrap --> 

                <div class="listing-view grid-view card-deck">
                    <?php
                    if ( $listings_query->have_posts() ) :
                        while ( $listings_query->have_posts() ) : $listings_query->the_post();

                            get_template_part('template-parts/listing/item', 'v1');

                        endwhile;
                        wp_reset_postdata();
                    else:
                        get_template_part('template-parts/listing/item', 'none');
                    endif;
                    ?>   
                </div><!-- listing-view -->

                <?php $next_link = get_next_posts_page_link( $listings_query->max_num_pages ); ?>

                <?php if( $next_link ) { ?>
                <div id="fave-pagination-loadmore" class="load-more-wrap houzez-infinite-load">
                    <a class="btn btn-primary-outlined btn-load-more" href="<?php echo esc_url($next_link); ?>">
                        <span class="btn-loader houzez-loader-js"></span> Load More       
                    </a>               
                </div>
                <?php } ?>

                <?php //houzez_pagination( $listings_query->max_num_pages, $range = 2 ); ?>

            </div><!-- bt-content-wrap -->
            <div class="col-lg-4 col-md-12 bt-sidebar-wrap <?php echo esc_attr($is_sticky); ?>">
                <?php get_sidebar('property'); ?>
            </div><!-- bt-sidebar-wrap -->
        </div><!-- row -->
    </div><!-- container -->
</section><!-- listing-wrap -->

<?php
if ('1' === $page_content_position ) {
    if ( have_posts() ) {
        while ( have_posts() ) {
            the_post();
            ?>
            <section class="content-wrap">
                <?php the_content(); ?>
            </section>
            <?php
        }
    }
}
get_footer(); 
}?>