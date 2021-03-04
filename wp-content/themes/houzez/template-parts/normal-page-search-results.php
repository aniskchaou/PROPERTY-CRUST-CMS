<?php
global $post, $paged, $listing_founds, $search_qry;

$is_sticky = '';
$sticky_sidebar = houzez_option('sticky_sidebar');
if( $sticky_sidebar['search_sidebar'] != 0 ) { 
    $is_sticky = 'houzez_sticky'; 
}

$listing_view = houzez_option('search_result_posts_layout', 'list-view-v1');
$search_result_layout = houzez_option('search_result_layout');
$search_num_posts = houzez_option('search_num_posts');
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

if($view_class == 'grid-view' && $search_result_layout == 'no-sidebar') {
    $cols_in_row = 'grid-view-3-cols';
}

$page_content_position = houzez_get_listing_data('listing_page_content_area');


if( $search_result_layout == 'no-sidebar' ) {
    $content_classes = 'col-lg-12 col-md-12';
} else if( $search_result_layout == 'left-sidebar' ) {
    $content_classes = 'col-lg-8 col-md-12 bt-content-wrap wrap-order-first';
} else if( $search_result_layout == 'right-sidebar' ) {
    $content_classes = 'col-lg-8 col-md-12 bt-content-wrap';
} else {
    $content_classes = 'col-lg-8 col-md-12 bt-content-wrap';
}

$number_of_prop = $search_num_posts;
if(!$number_of_prop){
    $number_of_prop = 9;
}

if ( is_front_page()  ) {
    $paged = (get_query_var('page')) ? get_query_var('page') : 1;
}
$search_qry = array(
    'post_type' => 'property',
    'posts_per_page' => $number_of_prop,
    'paged' => $paged,
    'post_status' => 'publish'
);

$search_qry = apply_filters( 'houzez20_search_filters', $search_qry );
$search_qry = houzez_prop_sort ( $search_qry );
$search_query = new WP_Query( $search_qry );

$total_records = $search_query->found_posts;

$record_found_text = esc_html__('Result Found', 'houzez');
if( $total_records > 1 ) {
    $record_found_text = esc_html__('Results Found', 'houzez');
}

?>
<section class="listing-wrap <?php echo esc_attr($wrap_class); ?>">
    <div class="container">

        <div class="page-title-wrap">

            <?php get_template_part('template-parts/page/breadcrumb'); ?> 
            <div class="d-flex align-items-center">
                <div class="page-title flex-grow-1">
                    <h1><?php the_title(); ?></h1>
                </div><!-- page-title -->
                <?php 
                if($have_switcher) {
                    get_template_part('template-parts/listing/listing-switch-view'); 
                }?> 
            </div><!-- d-flex -->  

        </div><!-- page-title-wrap -->

        <div class="row">
            <div class="<?php echo esc_attr($content_classes); ?>">

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
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-grow-1">
                            <strong><?php echo esc_attr($total_records); ?> <?php echo esc_attr($record_found_text); ?></strong>
                        </div>
                        <?php get_template_part('template-parts/listing/listing-sort-by'); ?>   
                        <?php
                        if( $enable_save_search != 0 ) {
                            get_template_part('template-parts/search/save-search-btn');
                        }?> 
                    </div><!-- d-flex -->
                    
                    

                </div><!-- listing-tools-wrap -->

                <div class="listing-view <?php echo esc_attr($view_class).' '.esc_attr($cols_in_row); ?> card-deck">
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
                </div><!-- listing-view -->

                <?php houzez_pagination( $search_query->max_num_pages, $range = 2 ); ?>

            </div><!-- bt-content-wrap -->

            <?php if( $search_result_layout != 'no-sidebar' ) { ?>
            <div class="col-lg-4 col-md-12 bt-sidebar-wrap <?php echo esc_attr($is_sticky); ?>">
                <aside class="sidebar-wrap">
                    <?php
                    if( is_active_sidebar( 'search-sidebar' ) ) {
                        dynamic_sidebar( 'search-sidebar' );
                    }
                    ?>
                </aside>
            </div><!-- bt-sidebar-wrap -->
            <?php } ?>

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
?>