<?php
/**
 * Template Name: User Dashboard Insight
 * Author: Waqas Riaz.
 */
if ( !is_user_logged_in() ) {
    wp_redirect(  home_url() );
}
get_header(); 

if( !class_exists('Fave_Insights')) {
    $msg = esc_html__('Please install and activate Favethemes Insights plugin.', 'houzez');
    wp_die($msg);
}

$user_id = get_current_user_id();
$insights = new Fave_Insights();

$listing_id = isset($_GET['listing_id']) ? $_GET['listing_id'] : '';

if(!empty($listing_id)) {
    $insights_stats = $insights->fave_listing_stats($_GET['listing_id']);
} else {
    $insights_stats = $insights->fave_user_stats($user_id);
}
?>

<header class="header-main-wrap dashboard-header-main-wrap">
    <div class="dashboard-header-wrap">
        <div class="d-flex align-items-center">
            <div class="dashboard-header-left flex-grow-1">
                <h1><?php echo houzez_option('dsh_insight', 'Insight'); ?></h1>         
            </div><!-- dashboard-header-left -->
            <div class="dashboard-header-right">

            </div><!-- dashboard-header-right -->
        </div><!-- d-flex -->
    </div><!-- dashboard-header-wrap -->
</header><!-- .header-main-wrap -->
<section class="dashboard-content-wrap">
    <div class="dashboard-content-inner-wrap">
        <div class="dashboard-content-block-wrap">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <?php get_template_part('template-parts/dashboard/statistics/filter'); ?>
                </div><!-- col-md-6 col-sm-12 -->
            </div><!-- row -->
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <?php get_template_part('template-parts/dashboard/statistics/views'); ?>
                </div><!-- col-md-6 col-sm-12 -->
                <div class="col-md-6 col-sm-12">
                    <?php get_template_part('template-parts/dashboard/statistics/unique-views'); ?>
                </div><!-- col-md-6 col-sm-12 -->
                <div class="col-md-12 col-sm-12">
                    <?php get_template_part('template-parts/dashboard/statistics/chart'); ?>
                </div><!-- col-md-6 col-sm-12 -->
                <div class="col-md-6 col-sm-12">
                    <?php get_template_part('template-parts/dashboard/statistics/devices'); ?>
                </div><!-- col-md-6 col-sm-12 -->
                <div class="col-md-6 col-sm-12">
                    <?php get_template_part('template-parts/dashboard/statistics/top-countries'); ?>
                </div><!-- col-md-6 col-sm-12 -->
                <div class="col-md-6 col-sm-12">
                    <?php get_template_part('template-parts/dashboard/statistics/top-platforms'); ?>
                </div><!-- col-md-6 col-sm-12 -->
                <div class="col-md-6 col-sm-12">
                    <?php get_template_part('template-parts/dashboard/statistics/top-browsers'); ?>
                </div><!-- col-md-6 col-sm-12 -->
                <div class="col-md-12 col-sm-12">
                    <?php get_template_part('template-parts/dashboard/statistics/referrals'); ?>
                </div><!-- col-md-6 col-sm-12 -->
            </div><!-- row -->
        </div><!-- dashboard-content-block-wrap -->
    </div><!-- dashboard-content-inner-wrap -->
</section><!-- dashboard-content-wrap -->

<section class="dashboard-side-wrap">
    <?php get_template_part('template-parts/dashboard/side-wrap'); ?>
</section>

<?php get_footer(); ?>