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
    'post_type' => 'houzez_agent',
    'paged'           => $paged
);
$tax_query = array();
if(isset($_GET['city']) && $_GET['city']!="") {
    $tax_query[] = array(
        'taxonomy' => 'agent_city',
        'field' => 'slug',
        'terms' => sanitize_text_field($_GET['city'])
    );
}
if(isset($_GET['category']) && $_GET['category']!="") {
    $tax_query[] = array(
        'taxonomy' => 'agent_category',
        'field' => 'slug',
        'terms' => sanitize_text_field($_GET['category'])
    );
}

$tax_count = count($tax_query);


$tax_query['relation'] = 'AND';


if( $tax_count > 0 ) {
    $args['tax_query']  = $tax_query;
}

/* Keyword Based Search */
if( isset ( $_GET['agent_name'] ) ) {
    $keyword = trim( $_GET['agent_name'] );
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

                        get_template_part('template-parts/realtors/agent/list');

                    endwhile;
                    
                    else:
                        get_template_part('template-parts/realtors/agent/none');
                    endif;
                    ?>
                </div>
                
                <?php houzez_pagination( $wp_query->max_num_pages, $range = 2 ); wp_reset_query(); ?>

            </div><!-- bt-content-wrap -->
            <div class="col-lg-4 col-md-12 bt-sidebar-wrap left-bt-sidebar-wrap <?php if( $sticky_sidebar['agent_sidebar'] != 0 ){ echo 'houzez_sticky'; }?>">
                <?php get_sidebar('houzez_agents'); ?>
            </div><!-- bt-sidebar-wrap -->
        </div><!-- row -->
    </div><!-- container -->
</section><!-- listing-wrap -->

<?php get_footer(); ?>