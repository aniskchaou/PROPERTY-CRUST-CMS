<?php
/**
 * Template Name: Template all agents
 * Created by PhpStorm.
 * User: waqasriaz
 * Date: 09/02/16
 * Time: 4:03 PM
 */
get_header();
global $houzez_local, $paged;
$sticky_sidebar = houzez_option('sticky_sidebar');
$page_id = get_the_ID();
$page_content_position = houzez_get_listing_data('listing_page_content_area');

if ( is_front_page()  ) {
    $paged = (get_query_var('page')) ? get_query_var('page') : 1;
}

$number_of_agents = houzez_option('num_of_agents');
if(!$number_of_agents){
    $number_of_agents = 9;
}
$tax_query = array();
$meta_query = array();
$qry_args = array(
    'post_type' => 'houzez_agent',
    'posts_per_page' => $number_of_agents,
    'paged' => $paged,
    'post_status' => 'publish',
    'meta_query' => array(
        'relation' => 'OR',
            array(
             'key' => 'fave_agent_visible',
             'compare' => 'NOT EXISTS', // works!
             'value' => '' // This is ignored, but is necessary...
            ),
            array(
             'key' => 'fave_agent_visible',
             'value' => 1,
             'type' => 'NUMERIC',
             'compare' => '!=',
            )
    )
);

$agent_cats = get_post_meta( $page_id, 'fave_agent_category', false );
$agent_cities = get_post_meta( $page_id, 'fave_agent_city', false );
$order = get_post_meta( $page_id, 'fave_agent_order', true );
$orderby = get_post_meta( $page_id, 'fave_agent_orderby', true );


if ( ! empty( $agent_cats ) && is_array( $agent_cats ) ) {
    $tax_query[] = array(
        'taxonomy' => 'agent_category',
        'field' => 'slug',
        'terms' => $agent_cats
    );
}

if ( ! empty( $agent_cities ) && is_array( $agent_cities ) ) {
    $tax_query[] = array(
        'taxonomy' => 'agent_city',
        'field' => 'slug',
        'terms' => $agent_cities
    );
}

$tax_count = count( $tax_query );

if( $tax_count > 1 ) {
    $tax_query['relation'] = 'AND';
}
if( $tax_count > 0 ){
    $qry_args['tax_query'] = $tax_query;
}

if( !empty( $orderby ) && $orderby != 'none' ) {
    $qry_args['orderby'] = $orderby;
}
if( !empty( $order ) ) {
    $qry_args['order'] = $order;
}


$agents_query = new WP_Query( $qry_args );
?>

<section class="listing-wrap">
    <div class="container">
        
        <div class="page-title-wrap">
            <?php get_template_part('template-parts/page/breadcrumb'); ?> 
            <div class="d-flex align-items-center">
                <?php get_template_part('template-parts/page/page-title'); ?> 
            </div><!-- d-flex -->  
        </div><!-- page-title-wrap -->

        <div class="row">
            <div class="col-lg-8 col-md-12 bt-content-wrap right-bt-content-wrap">

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

                <div class="agents-list-view">
                    <?php
                    if ( $agents_query->have_posts() ) :
                    while ( $agents_query->have_posts() ) : $agents_query->the_post();

                        get_template_part('template-parts/realtors/agent/list');

                    endwhile;
                    
                    else:
                        get_template_part('template-parts/realtors/agent/none');
                    endif;
                    ?>
                </div>
                
                <?php houzez_pagination( $agents_query->max_num_pages, $range = 2 ); wp_reset_query(); ?>

            </div><!-- bt-content-wrap -->
            <div class="col-lg-4 col-md-12 bt-sidebar-wrap left-bt-sidebar-wrap <?php if( $sticky_sidebar['agent_sidebar'] != 0 ){ echo 'houzez_sticky'; }?>">
                <?php get_sidebar('houzez_agents'); ?>
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
?>

<?php get_footer(); ?>
