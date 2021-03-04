<?php 
global $post, $hide_fields, $top_area, $property_layout, $map_street_view;

$single_top_area = get_post_meta( get_the_ID(), 'fave_single_top_area', true );
$single_content_area = get_post_meta( get_the_ID(), 'fave_single_content_area', true );
$map_street_view = get_post_meta( get_the_ID(), 'fave_property_map_street_view', true );
$loggedin_to_view = get_post_meta( get_the_ID(), 'fave_loggedintoview', true );
$property_live_status = get_post_status();
$hide_fields = houzez_option('hide_detail_prop_fields');
houzez_count_property_views( $post->ID );

$enable_disclaimer = houzez_option('enable_disclaimer', 1);
$global_disclaimer = houzez_option('property_disclaimer');
$property_disclaimer = get_post_meta( get_the_ID(), 'fave_property_disclaimer', true );

if( !empty(  $property_disclaimer ) ) {
    $global_disclaimer = $property_disclaimer;
}

if( ( $property_live_status == 'on_hold' ) && ( $post->post_author != get_current_user_id() ) ) {
    wp_redirect(  home_url() );
}

$is_sticky = '';
$sticky_sidebar = houzez_option('sticky_sidebar');
if( $sticky_sidebar['single_property'] != 0 ) { 
    $is_sticky = 'houzez_sticky'; 
}

$is_full_width = houzez_option('is_full_width');
$top_area = houzez_option('prop-top-area');
$property_layout = houzez_option('prop-content-layout');

if(isset($_GET['is_full_width'])) {
    $is_full_width = 1;
}

if($is_full_width == 1) {
    $content_classes = 'col-lg-12 col-md-12 bt-full-width-content-wrap';
} else {
    $content_classes = 'col-lg-8 col-md-12 bt-content-wrap';
}

if( !empty( $single_top_area ) && $single_top_area != 'global' ) {
    $top_area = $single_top_area;
}

if( !empty( $single_content_area ) && $single_content_area != 'global' ) {
    $property_layout = $single_content_area;
}

/* For demo purpose only */
if( isset( $_GET['s_top'] ) ) {
    $top_area = $_GET['s_top'];
}
if( isset( $_GET['s_layout'] ) ) {
    $property_layout = $_GET['s_layout'];
}

get_header();

if( houzez_check_is_elementor() && ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'single' ) ) ) {

    while ( have_posts() ) : the_post();

        the_content();

    endwhile;

} else {

 
if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'single' ) ) { 

    if( have_posts() ): while( have_posts() ): the_post(); ?>
        
        <section class="content-wrap property-wrap property-detail-<?php echo esc_attr($top_area); ?>">
            <?php 
            get_template_part('property-details/navigation'); 

            if($top_area != 'v5' && $top_area != 'v2') {
                get_template_part('property-details/property-title'); 
            }


            if($top_area == 'v1') {
                get_template_part('property-details/top-area-v1');

            } elseif($top_area == 'v2') {
                get_template_part('property-details/top-area-v2');

            } elseif( ($top_area == 'v3' || $top_area == 'v4') && $property_layout == 'v2' ) {
                echo '<div class="container">';
                get_template_part('property-details/top-area-v3-4');
                echo '</div>';

            } elseif($top_area == 'v5') {
                get_template_part('property-details/top-area-v5');

            } elseif($top_area == 'v6') {
                get_template_part('property-details/top-area-v6');

            }

            if( $loggedin_to_view == 1 && !is_user_logged_in()) {

                get_template_part( 'property-details/partials/login_required');

            } else if( get_post_status($post->ID) == 'expired' ) {

                get_template_part( 'property-details/partials/expired');

            } else {
                
                if( $property_layout == 'v2' ) { ?>
                
                <div class="property-view full-width-property-view">
                    <?php get_template_part('property-details/mobile-view'); ?>
                    <?php get_template_part( 'property-details/single-property-luxury-homes'); ?>
                </div>

                <?php if( !empty($global_disclaimer) && $enable_disclaimer ) { ?>
                <div class="property-disclaimer">
                    <?php echo $global_disclaimer; ?>
                </div>
                <?php } ?>

            <?php } else { ?>

            <div class="container">
                <?php
                if($top_area == 'v4') {
                    get_template_part('property-details/top-area-v3-4');
                } 
                ?>
                <div class="row">
                    <div class="<?php echo esc_attr($content_classes); ?>">
                        <?php
                        if($top_area == 'v3') {
                            get_template_part('property-details/top-area-v3-4');
                        } 
                        ?>                   
                        <div class="property-view">

                            <?php get_template_part('property-details/mobile-view'); ?>

                            <?php
                            if( $property_layout == 'tabs' ) {
                                get_template_part( 'property-details/single-property', 'tabs');
                            } else if( $property_layout == 'tabs-vertical' ) {
                                get_template_part( 'property-details/single-property', 'tabs-vertical');
                            } else {
                                get_template_part( 'property-details/single-property', 'simple');
                            }

                            if( houzez_option('enable_next_prev_prop') ) {
                                get_template_part('property-details/next-prev');
                            }
                            ?>
                            
                        </div><!-- property-view -->
                    </div><!-- bt-content-wrap -->

                    <?php if($is_full_width != 1) { ?>
                    <div class="col-lg-4 col-md-12 bt-sidebar-wrap <?php echo esc_attr($is_sticky); ?>">
                        <?php get_sidebar('property'); ?>
                    </div><!-- bt-sidebar-wrap -->
                    <?php } ?>
                </div><!-- row -->

                <?php if( !empty($global_disclaimer) && $enable_disclaimer ) { ?>
                <div class="property-disclaimer">
                    <?php echo $global_disclaimer; ?>
                </div>
                <?php } ?>

            </div><!-- container -->

                <?php } 
            } // end loggedIN?>

        </section><!-- listing-wrap -->    

    <?php endwhile; endif; 
 } // <!-- end elementor location -->
} ?> <!-- end houzez_check_is_elementor -->

<?php get_footer(); ?>