<?php
/**
 * Template Name: Payment Page
 * Created by PhpStorm.
 * User: waqasriaz
 * Date: 06/09/16
 * Time: 3:27 PM
 */
$selected_package_id = isset( $_GET['selected_package'] ) ? $_GET['selected_package'] : '';
$property_id = isset( $_GET['prop-id'] ) ? $_GET['prop-id'] : '';
$upgrade_id = isset( $_GET['upgrade_id'] ) ? $_GET['upgrade_id'] : '';
if( empty( $selected_package_id ) && empty( $property_id ) && empty( $upgrade_id ) ) {
    wp_redirect( home_url() );
}
set_time_limit (600);

$houzez_need_register = false;
if ( !is_user_logged_in() ) {
    $houzez_need_register = true;
}

get_header();
global $houzez_local;

$user_id                 = get_current_user_id();
$user_pack_id            = get_the_author_meta( 'package_id' , $user_id );
$user_package_activation = get_the_author_meta( 'package_activation' , $user_id );
$user_registered         = get_the_author_meta( 'user_registered' , $user_id );
$package_price = get_post_meta( $selected_package_id, 'fave_package_price', true );

$is_membership = 0;
$paid_submission_type = esc_html ( houzez_option('enable_paid_submission','') );
$membership_currency = houzez_option( 'currency_paid_submission' );
$currency_symbol = houzez_option( 'currency_symbol' );
$where_currency = houzez_option( 'currency_position' );
$enable_wireTransfer = houzez_option('enable_wireTransfer');
$enable_paypal = houzez_option('enable_paypal');
$enable_stripe = houzez_option('enable_stripe');
$user_show_roles = houzez_option('user_show_roles');
$show_hide_roles = houzez_option('show_hide_roles');
$enable_paid_submission = houzez_option('enable_paid_submission');
$packages_page_link = houzez_get_template_link('template/template-packages.php');
$stripe_processor_link = houzez_get_template_link('template/template-stripe-charge.php');

$panel_class = '';
$houzez_loggedin = false;
if ( is_user_logged_in() ) {
    
    $houzez_loggedin = true;
    
} else {
    
}
?>

<section class="frontend-submission-page">
    
    <div class="container">
         <div id="packmem-msgs"></div>

         <div class="d-flex display-block-on-tablet">
            <div class="order-2">
                <?php
                if( $enable_paid_submission == 'membership' ) {
                    get_template_part('template-parts/membership/price');
                } else if ( $enable_paid_submission == 'per_listing' || $enable_paid_submission == 'free_paid_listing' ) {
                    get_template_part('template-parts/membership/per-listing/price');
                }
                ?>
            </div><!-- order-2 -->
            <div class="order-1 flex-grow-1">
                <form name="houzez_checkout" method="post" class="houzez_payment_form" action="<?php echo $stripe_processor_link; ?>">
                    <?php if ( $houzez_need_register ) { ?>
                    <div class="dashboard-content-block-wrap">
                        <h2><?php esc_html_e('Account Information', 'houzez'); ?></h2>
                        <div class="dashboard-content-block">
                            <?php get_template_part('template-parts/membership/create-account-form'); ?>    
                        </div>
                    </div>
                    <?php } ?>

                    <div class="dashboard-content-block-wrap">
                        <?php if( $package_price > 0 || $enable_paid_submission == 'per_listing' || $enable_paid_submission == 'free_paid_listing') { ?>
                        <h2><?php echo $houzez_local['payment_method']; ?></h2>
                        <?php } ?>

                        <div class="dashboard-content-block">

                            <?php
                            if( $enable_paid_submission == 'membership' ) {
                                get_template_part('template-parts/membership/payment-method');

                            } elseif($enable_paid_submission == 'per_listing' || $enable_paid_submission == 'free_paid_listing') {
                                
                                get_template_part('template-parts/membership/per-listing/payment-method');
                            }
                            ?>
                        </div><!-- dashboard-content-block -->
                    </div><!-- dashboard-content-block-wrap -->
                
                </form>
            </div><!-- order-1 -->
        </div><!-- d-flex -->
    
    </div><!-- container -->
</section><!-- frontend-submission-page -->

<?php get_footer(); ?>