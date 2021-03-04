<?php
get_header();
global $post, $houzez_local, $paged, $agent_total_listings, $agent_listing_ids;

$is_sticky = '';
$sticky_sidebar = houzez_option('sticky_sidebar');
if( $sticky_sidebar['agent_sidebar'] != 0 ) { 
    $is_sticky = 'houzez_sticky'; 
}
$listing_view = houzez_option('agent_listings_layout');
$agent_company_logo = get_post_meta( get_the_ID(), 'fave_agent_logo', true );

$agent_number = get_post_meta( get_the_ID(), 'fave_agent_mobile', true );
$agent_number_call = str_replace(array('(',')',' ','-'),'', $agent_number);
if( empty($agent_number) ) {
    $agent_number = get_post_meta( get_the_ID(), 'fave_agent_office_num', true );
    $agent_number_call = str_replace(array('(',')',' ','-'),'', $agent_number);
}


$item_layout = $view_class = $cols_in_row = '';
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

} elseif($listing_view == 'grid-view-v4') {
    $wrap_class = 'listing-v4';
    $item_layout = 'v4';
    $view_class = 'grid-view';

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
} 

$active_reviews_tab = '';
$active_reviews_content = '';
if( houzez_option( 'agent_listings', 0 ) != 1 && houzez_option( 'agent_review', 0 ) != 0 ) {
    $active_reviews_tab = 'active';
    $active_reviews_content = 'show active';

} else {
    $active_listings_tab = 'active';
    $active_listings_content = 'show active';
}

if(isset($_GET['tab']) || $paged > 0) {

    if(isset($_GET['tab']) && $_GET['tab'] == 'reviews') {
        $active_reviews_tab = 'active';
        $active_reviews_content = 'show active';
        $active_listings_tab = '';
        $active_listings_content = '';
    }
    ?>
    <script>
        jQuery(document).ready(function ($) {
            $('html, body').animate({
                scrollTop: $(".agent-nav-wrap").offset().top
            }, 'slow');
        });
    </script>
    <?php
}

$the_query = Houzez_Query::loop_agent_properties();
$agent_total_listings = Houzez_Query::agent_properties_count();
$agent_listing_ids = Houzez_Query::loop_get_agent_properties_ids(get_the_ID());

$content_classes = 'col-lg-8 col-md-12 bt-content-wrap';
if( houzez_option( 'agent_sidebar', 0 ) == 0 ) { 
    $content_classes = 'col-lg-12 col-md-12';
}
?>

<section class="content-wrap">
    <div class="container">

        <div class="agent-profile-wrap">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="agent-image">
                        <?php if( !empty( $agent_company_logo ) ) {
                        $logo_url = wp_get_attachment_url( $agent_company_logo );
                        if( !empty($logo_url) ) {
                        ?>
                        <div class="agent-company-logo">
                            <img class="img-fluid" src="<?php echo esc_url( $logo_url ); ?>" alt="">
                        </div>
                        <?php }
                        } ?>
                        <?php get_template_part('template-parts/realtors/agent/image'); ?>
                    </div><!-- agent-image -->
                </div><!-- col-lg-4 col-md-4 col-sm-12 -->

                <div class="col-lg-8 col-md-8 col-sm-12">
                    <div class="agent-profile-top-wrap">
                        <div class="agent-profile-header">
                            <h1><?php the_title(); ?></h1>
                            
                            <?php 
                            if( houzez_option( 'agent_review', 0 ) != 0 ) {
                                get_template_part('template-parts/realtors/rating'); 
                            }?>

                        </div><!-- agent-profile-content -->
                        <?php get_template_part('template-parts/realtors/agent/position'); ?>
                    </div><!-- agent-profile-header -->

                    <div class="agent-profile-content">
                        <ul class="list-unstyled">
                            
                            <?php get_template_part('template-parts/realtors/agent/license'); ?>

                            <?php get_template_part('template-parts/realtors/agent/tax-number'); ?>

                            <?php get_template_part('template-parts/realtors/agent/service-area'); ?>

                            <?php get_template_part('template-parts/realtors/agent/specialties'); ?>

                        </ul>
                    </div><!-- agent-profile-content -->

                    <div class="agent-profile-buttons">
                        
                        <?php if( houzez_option('agent_form_agent_page', 1) ) { ?>
                        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#realtor-form">
                            <?php echo esc_html__('Send Email', 'houzez'); ?>  
                        </button>
                        <?php } ?>
                        
                        <?php if(!empty($agent_number)) { ?>
                        <a href="tel:<?php echo esc_attr($agent_number_call); ?>">
                            <button type="button" class="btn btn-call">
                                <span class="hide-on-click"><?php echo esc_html__('Call', 'houzez'); ?></span>
                                <span class="show-on-click"><?php echo esc_attr($agent_number); ?></span>
                            </button>
                        </a>
                        <?php } ?>


                    </div><!-- agent-profile-buttons -->
                </div><!-- col-lg-8 col-md-8 col-sm-12 -->
            </div><!-- row -->
        </div><!-- agent-profile-wrap -->

        <?php if( !empty($agent_listing_ids) && houzez_option('agent_stats', 0) != 0 ) { ?>
        <div class="agent-stats-wrap">
            <div class="row">
                <div class="col-lg-4 col-md-12 col-sm-12">
                    <?php get_template_part('template-parts/realtors/agent/stats-property-types'); ?> 
                </div>
                <div class="col-lg-4 col-md-12 col-sm-12">
                    <?php get_template_part('template-parts/realtors/agent/stats-property-status'); ?> 
                </div>

                <?php if(taxonomy_exists('property_city')) { ?>
                <div class="col-lg-4 col-md-12 col-sm-12">
                    <?php get_template_part('template-parts/realtors/agent/stats-property-cities'); ?> 
                </div>
                <?php } ?>
            </div>
        </div>
        <?php } ?>

        <div class="row">
            <div class="<?php echo esc_attr($content_classes); ?>">

                <?php if( houzez_option('agent_bio', 0) != 0 ) { ?>
                <div class="agent-bio-wrap">
                    <h2><?php echo esc_html__('About', 'houzez'); ?> <?php the_title(); ?></h2>
                    <?php the_content(); ?>

                    <?php get_template_part('template-parts/realtors/agent/languages'); ?> 
                </div><!-- agent-bio-wrap --> 
                <?php } ?>
                
                <?php if( houzez_option( 'agent_listings', 0 ) != 0 || houzez_option( 'agent_review', 0 ) != 0 ) { ?>
                <div id="review-scroll" class="agent-nav-wrap">
                    <ul class="nav nav-pills nav-justified">
                        
                        <?php if( houzez_option( 'agent_listings', 0 ) != 0 ) { ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo esc_attr($active_listings_tab); ?>" href="#tab-properties" data-toggle="pill" role="tab">
                                <?php esc_html_e('Listings', 'houzez'); ?> (<?php echo esc_attr($agent_total_listings); ?>)
                            </a>
                        </li>
                        <?php } ?>

                        <?php if( houzez_option( 'agent_review', 0 ) != 0 ) { ?>
                        <li class="nav-item">
                            <a class="nav-link hz-review-tab <?php echo esc_attr($active_reviews_tab); ?>" href="#tab-reviews" data-toggle="pill" role="tab">
                                <?php esc_html_e('Reviews', 'houzez'); ?> (<?php echo houzez_reviews_count('review_agent_id'); ?>)
                            </a>
                        </li>
                        <?php } ?>
                    </ul>
                </div><!-- agent-nav-wrap -->
                
                <div class="tab-content" id="tab-content">
                    
                    <?php if( houzez_option( 'agent_listings', 0 ) != 0 ) { ?>
                    <div class="tab-pane fade <?php echo esc_attr($active_listings_content); ?>" id="tab-properties">
                        <div class="listing-tools-wrap">
                            <div class="d-flex align-items-center">
                                <div class="listing-tabs flex-grow-1">
                                    <?php get_template_part('template-parts/realtors/agent/listing-tabs'); ?> 
                                </div>
                                <?php get_template_part('template-parts/listing/listing-sort-by'); ?>  
                            </div><!-- d-flex -->
                        </div><!-- listing-tools-wrap -->

                        <section class="listing-wrap <?php echo esc_attr($wrap_class); ?>">
                            <div class="listing-view <?php echo esc_attr($view_class); ?> card-deck">
                                <?php
                                if ( $the_query->have_posts() ) :
                                    while ( $the_query->have_posts() ) : $the_query->the_post();

                                        get_template_part('template-parts/listing/item', $item_layout);

                                    endwhile;
                                    wp_reset_postdata();
                                else:
                                    get_template_part('template-parts/listing/item', 'none');
                                endif;
                                ?> 
                            </div><!-- listing-view -->

                            <?php houzez_pagination( $the_query->max_num_pages, $range = 2 ); ?>
                        </section>
                    </div><!-- tab-pane -->
                    <?php } ?>

                    <?php if( houzez_option( 'agent_review', 0 ) != 0 ) { ?>
                    <div class="tab-pane fade <?php echo esc_attr($active_reviews_content); ?>" id="tab-reviews">
                        <?php get_template_part('template-parts/reviews/main'); ?> 
                    </div><!-- tab-pane -->
                    <?php } ?>
                </div><!-- tab-content -->
                <?php } ?>

            </div><!-- bt-content-wrap -->

            <?php if( houzez_option( 'agent_sidebar', 0 ) != 0 ) { ?>
            <div class="col-lg-4 col-md-12 bt-sidebar-wrap <?php echo esc_attr($is_sticky); ?>">
                <aside class="sidebar-wrap">
                    <?php get_template_part('template-parts/realtors/agent/agent-contacts') ;?> 
                    <?php 
                    if (is_active_sidebar('agent-sidebar')) {
                        dynamic_sidebar('agent-sidebar');
                    }
                    ?>
                </aside>
            </div><!-- bt-sidebar-wrap -->
            <?php } ?>
        </div><!-- row -->
    </div><!-- container -->
</section><!-- listing-wrap -->

<?php get_footer(); ?>
