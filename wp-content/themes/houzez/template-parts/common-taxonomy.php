<?php
global $post, $taxonomy_name, $listing_view, $houzez_local;

// Title
$current_term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
$taxonomy_title = $current_term->name;
$taxonomy_name = get_query_var( 'taxonomy' );

$is_sticky = '';
$sticky_sidebar = houzez_option('sticky_sidebar');
if( $sticky_sidebar['property_listings'] != 0 ) { 
    $is_sticky = 'houzez_sticky'; 
}

$listing_view = houzez_option('taxonomy_posts_layout', 'list-view-v1');
$taxonomy_layout = houzez_option('taxonomy_layout');

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

} else {
    $wrap_class = 'listing-v1';
    $item_layout = 'v1';
    $view_class = 'grid-view';
}

if($view_class == 'grid-view' && $taxonomy_layout == 'no-sidebar') {
    $cols_in_row = 'grid-view-3-cols';
}


if( $taxonomy_layout == 'no-sidebar' ) {
    $content_classes = 'col-lg-12 col-md-12';
} else if( $taxonomy_layout == 'left-sidebar' ) {
    $content_classes = 'col-lg-8 col-md-12 bt-content-wrap wrap-order-first';
} else if( $taxonomy_layout == 'right-sidebar' ) {
    $content_classes = 'col-lg-8 col-md-12 bt-content-wrap';
} else {
    $content_classes = 'col-lg-8 col-md-12 bt-content-wrap';
}


$taxonomy_content_position = houzez_option('taxonomy_content_position', 'above');

$sort_args = array('post_status' => 'publish');
$sort_args = houzez_prop_sort($sort_args);
global $wp_query;
$args = array_merge( $wp_query->query_vars, $sort_args );

$wp_query = new WP_Query( $args );

$total_listing_found = $wp_query->found_posts;
$property_label = houzez_option('cl_property', 'Property');
if( $total_listing_found > 1 ) {
   $property_label = houzez_option('cl_properties', 'Properties'); 
}
?>

<section class="listing-wrap <?php echo esc_attr($wrap_class); ?>">
    <div class="container">

        <div class="page-title-wrap">

            <?php get_template_part('template-parts/page/breadcrumb'); ?> 
            <div class="d-flex align-items-center">
                <div class="page-title flex-grow-1">
                    <h1><?php echo esc_html($taxonomy_title); ?></h1>
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
                if ( $taxonomy_content_position == 'above' ) { ?>
                    <article>
                        <?php echo term_description(); ?>
                    </article>
                <?php
                }?>

                <div class="listing-tools-wrap">
                    <div class="d-flex align-items-center mb-2">
                        <div class="listing-tabs flex-grow-1"><?php echo esc_attr($total_listing_found).' '.$property_label; ?></div>  
                        <?php get_template_part('template-parts/listing/listing-sort-by'); ?>    
                    </div><!-- d-flex -->
                </div><!-- listing-tools-wrap -->

                <div class="listing-view <?php echo esc_attr($view_class).' '.esc_attr($cols_in_row); ?> card-deck">
                    <?php
                    if ( $wp_query->have_posts() ) :
                        while ( $wp_query->have_posts() ) : $wp_query->the_post();

                            get_template_part('template-parts/listing/item', $item_layout);

                        endwhile;
                    else:
                        get_template_part('template-parts/listing/item', 'none');
                    endif;
                    wp_reset_postdata();
                    ?> 
                </div><!-- listing-view -->

                <?php houzez_pagination( $wp_query->max_num_pages, $range = 2 ); ?>

            </div><!-- bt-content-wrap -->

            <?php if( $taxonomy_layout != 'no-sidebar' ) { ?>
            <div class="col-lg-4 col-md-12 bt-sidebar-wrap <?php echo esc_attr($is_sticky); ?>">
                <?php get_sidebar('property'); ?>
            </div><!-- bt-sidebar-wrap -->
            <?php } ?>

        </div><!-- row -->

        <?php
        if ( $taxonomy_content_position == 'bottom' ) { ?>
            <article>
                <?php echo term_description(); ?>
            </article>
        <?php
        }?>

    </div><!-- container -->
</section><!-- listing-wrap -->