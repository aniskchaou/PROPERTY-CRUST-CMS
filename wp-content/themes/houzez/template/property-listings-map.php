<?php
/**
 * Template Name: Property Listing Half Map
 * Created by PhpStorm.
 * User: waqasriaz
 * Date: 11/06/16
 * Time: 11:00 PM
 */
get_header();
global $search_style, $paged;

$listing_view = houzez_option('halfmap_posts_layout', 'list-view-v1');
$enable_save_search = houzez_option('enable_disable_save_search');

$have_switcher = true;

$wrap_class = $item_layout = $view_class = $cols_in_row = '';
if($listing_view == 'list-view-v1') {
    $wrap_class = 'listing-v1';
    $item_layout = 'v1';
    $view_class = 'list-view';

} elseif($listing_view == 'grid-view-v1') {
    $wrap_class = 'listing-v1';
    $item_layout = 'v1';
    $view_class = 'grid-view';

} elseif($listing_view == 'list-view-v2') {
    $wrap_class = 'listing-v2';
    $item_layout = 'v2';
    $view_class = 'list-view';

} elseif($listing_view == 'grid-view-v2') {
    $wrap_class = 'listing-v2';
    $item_layout = 'v2';
    $view_class = 'grid-view';

} elseif($listing_view == 'grid-view-v3') {
    $wrap_class = 'listing-v3';
    $item_layout = 'v3';
    $view_class = 'grid-view';
    $have_switcher = false;

} elseif($listing_view == 'grid-view-v4') {
    $wrap_class = 'listing-v4';
    $item_layout = 'v4';
    $view_class = 'grid-view';
    $have_switcher = false;

} elseif($listing_view == 'list-view-v5') {
    $wrap_class = 'listing-v5';
    $item_layout = 'v5';
    $view_class = 'list-view';

} elseif($listing_view == 'grid-view-v5') {
    $wrap_class = 'listing-v5';
    $item_layout = 'v5';
    $view_class = 'grid-view';

} elseif($listing_view == 'grid-view-v6') {
    $wrap_class = 'listing-v6';
    $item_layout = 'v6';
    $view_class = 'grid-view';
    $have_switcher = false;

} 

$page_content_position = houzez_get_listing_data('listing_page_content_area');

if ( is_front_page()  ) {
    $paged = (get_query_var('page')) ? get_query_var('page') : 1;
}
$listing_args = array(
    'post_type' => 'property',
    'post_status' => 'publish'
);

$listing_qry = apply_filters( 'houzez20_property_filter', $listing_args );
$listing_qry = houzez_prop_sort ( $listing_qry );
$search_query = new WP_Query( $listing_qry );  
$total_properties = $search_query->found_posts; 

$enable_search = houzez_option('enable_halfmap_search', 1);
$search_style = houzez_option('halfmap_search_layout', 'v4');

if( isset($_GET['halfmap_search']) && $_GET['halfmap_search'] != '' ) {
    $search_style = $_GET['halfmap_search'];
}

if( wp_is_mobile() ) {
    $search_style = 'v1';
}

if($enable_search != 0 && $search_style != 'v4') {
    get_template_part('template-parts/search/search-half-map-header');
}
?>
<section class="half-map-wrap map-on-left clearfix">
    <div id="map-view-wrap" class="half-map-left-wrap">
        <div class="map-wrap">
            <?php get_template_part('template-parts/map-buttons'); ?>
            
            <div id="houzez-properties-map"></div> 

            <?php if(houzez_get_map_system() == 'google') { ?>
            <div id="houzez-map-loading" class="houzez-map-loading">
                <div class="mapPlaceholder">
                    <div class="loader-ripple spinner">
                        <div class="bounce1"></div>
                        <div class="bounce2"></div>
                        <div class="bounce3"></div>
                    </div>
                </div>
            </div>
            <?php } ?>

        </div>
    </div>

    <div id="half-map-listing-area" class="half-map-right-wrap <?php echo esc_attr($wrap_class); ?>">

        <?php 
        if($enable_search != 0 && $search_style == 'v4') {
            get_template_part('template-parts/search/search-half-map');
        }
        ?>

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

        <div class="page-title-wrap">
            <div class="d-flex align-items-center">
                <div class="page-title flex-grow-1">
                    <span><?php echo esc_attr($total_properties); ?></span> <?php esc_html_e('Results Found', 'houzez');?>
                </div>

                <?php get_template_part('template-parts/listing/listing-sort-by'); ?>  
                <?php 
                if($have_switcher) {
                    get_template_part('template-parts/listing/listing-switch-view'); 
                }?> 
            </div>  
        </div>

        <div class="listing-view <?php echo esc_attr($view_class); ?>" data-layout="<?php echo esc_attr($item_layout); ?>">
            
            <div id="houzez_ajax_container">
                <div class="card-deck">
                <?php
                if ( $search_query->have_posts() ) :
                    while ( $search_query->have_posts() ) : $search_query->the_post();

                        get_template_part('template-parts/listing/item', $item_layout);

                    endwhile;
                else:
                    
                    echo '<div class="search-no-results-found">';
                        esc_html_e('No results found', 'houzez');
                    echo '</div>';
                    
                endif;
                wp_reset_postdata();
                ?> 
                </div>

                <div class="clearfix"></div>
                <?php houzez_ajax_pagination( $search_query->max_num_pages, $paged, $range = 2 ); ?>
            </div>
            
        </div><!-- listing-view -->

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
        ?>
        
    </div>
</section>
<?php get_footer(); ?>