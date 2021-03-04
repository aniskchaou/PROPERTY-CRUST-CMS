<?php
get_header();
global $paged, $wp_query;
$sticky_sidebar = houzez_option('sticky_sidebar');

if ( get_query_var('paged') ) {
    $paged = get_query_var('paged');
} elseif ( get_query_var('page') ) {
    $paged = get_query_var('page');
} else {
    $paged = 1;
}

global $wp_query;
$args = array(
    'post_type' => 'houzez_agency',
    'paged'           => $paged
);

/* Keyword Based Search */
if( isset ( $_GET['agency_name'] ) ) {
    $keyword = trim( $_GET['agency_name'] );
    $keyword = sanitize_text_field($keyword);
    if ( ! empty( $keyword ) ) {
        $args['s'] = $keyword;
    }
}

query_posts( $args );
?>

<section class="listing-wrap">
    <div class="container">
        
        <div class="page-title-wrap">
            <?php get_template_part('template-parts/page/breadcrumb'); ?> 
            
        </div><!-- page-title-wrap -->

        <div class="row">
            <div class="col-lg-8 col-md-12 bt-content-wrap right-bt-content-wrap">

                <div class="agents-list-view">
                    <?php
                    if ( have_posts() ) :
                    while ( have_posts() ) : the_post();

                            get_template_part('template-parts/realtors/agency/list');

                    endwhile;
                    
                    else:
                        get_template_part('template-parts/realtors/agency/none');
                    endif;
                    ?>
                </div><!-- listing-view -->
                
                <?php houzez_pagination( $wp_query->max_num_pages, $range = 2 ); wp_reset_query(); ?>

            </div><!-- bt-content-wrap -->
            <div class="col-lg-4 col-md-12 bt-sidebar-wrap left-bt-sidebar-wrap <?php if( $sticky_sidebar['agency_sidebar'] != 0 ){ echo 'houzez_sticky'; }?>">
                <?php get_sidebar('agencies'); ?>
            </div><!-- bt-sidebar-wrap -->
        </div><!-- row -->
    </div><!-- container -->
</section><!-- listing-wrap -->

<?php get_footer(); ?>