<?php
/**
 * Template Name: User Dashboard Membership Info
 */
if ( !is_user_logged_in() ) {
    wp_redirect(  home_url() );
}

global $houzez_local;
$userID         = get_current_user_id();
$dashboard_membership = houzez_get_template_link_2('template/user_dashboard_membership.php');
$packages_page_link = houzez_get_template_link('template/template-packages.php');
$package_id = houzez_get_user_package_id( $userID );

get_header(); ?>

<header class="header-main-wrap dashboard-header-main-wrap">
    <div class="dashboard-header-wrap">
        <div class="d-flex align-items-center">
            <div class="dashboard-header-left flex-grow-1">
                <h1><?php echo houzez_option('dsh_membership', 'Membership'); ?></h1>         
            </div><!-- dashboard-header-left -->
            <div class="dashboard-header-right">
                
            </div><!-- dashboard-header-right -->
        </div><!-- d-flex -->
    </div><!-- dashboard-header-wrap -->
</header><!-- .header-main-wrap -->
<section class="dashboard-content-wrap">
    <div class="dashboard-content-inner-wrap">
        <div class="dashboard-content-block-wrap">
            
            <?php
            if( !empty($package_id) ) {
                ?>

                <div class="dashboard-content-block">
                    <ul class="list-unstyled mebership-list-info">
                        <?php houzez_get_user_current_package( $userID ); ?>
                    </ul>
                </div>

                <?php
                echo '<a href="' . esc_url($packages_page_link) . '" class="btn btn-primary mb-2"> ' . esc_html__('Change Membership Plan', 'houzez') . ' </a>';
                $stripe_profile_user    =   get_user_meta($userID,'fave_stripe_user_profile',true);
                $subscription_id        =   get_user_meta( $userID, 'houzez_stripe_subscription_id', true );
                $enable_stripe_status   =   houzez_option('enable_stripe');


                if( $subscription_id != '' && $enable_stripe_status != 0 ) {
                    echo '<a id="houzez_stripe_cancel" data-message="'.esc_html__('Done: Subscription will be cancelled at the end of current period', 'houzez').'" class="btn btn-primary-outlined mb-2">'.esc_html__('Cancel Stripe Subscription', 'houzez').'</a>';
                    echo '<span id="stripe_cancel_success"></span>';
                }
            } else { ?>

                <div class="dashboard-content-block">
                    <?php esc_html_e("You don't have any membership.", 'houzez'); ?>
                </div>

                <?php
                echo '<a href="' . esc_url($packages_page_link) . '" class="btn btn-primary mb-2"> ' . esc_html__('Get Membership Plan', 'houzez') . ' </a>';
            }
            ?>                
        </div><!-- dashboard-content-block-wrap -->
    </div><!-- dashboard-content-inner-wrap -->
</section><!-- dashboard-content-wrap -->
<section class="dashboard-side-wrap">
    <?php get_template_part('template-parts/dashboard/side-wrap'); ?>
</section>

<?php get_footer(); ?>