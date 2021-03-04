<?php
/**
 * Template Name: Thank You & Payment Process complete
 * Created by PhpStorm.
 * User: waqasriaz
 * Date: 06/09/16
 * Time: 5:50 PM
 */
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

if ( !is_user_logged_in() ) {
    wp_redirect( home_url() );
}
global $houzez_local, $current_user;
wp_get_current_user();
$userID = $current_user->ID;
$is_paypal_live  =   houzez_option('paypal_api');

$user_email = $current_user->user_email;
$admin_email      =  get_bloginfo('admin_email');

$allowed_html   =   array();
$listings_admin_approved = houzez_option('listings_admin_approved');
$enable_paid_submission = houzez_option('enable_paid_submission');
$dash_properties_link = houzez_get_template_link('template/user_dashboard_properties.php');

if( $enable_paid_submission == 'per_listing' || $enable_paid_submission == 'free_paid_listing' ) {

    $price_per_submission = houzez_option('price_listing_submission');
    $price_featured_submission = houzez_option('price_featured_listing_submission');
    $currency = houzez_option('currency_paid_submission');

    $is_paypal_live  =   houzez_option('paypal_api');
    $host            =   'https://api.sandbox.paypal.com';

    if( $is_paypal_live == 'live' ){
        $host = 'https://api.paypal.com';
    }

    $return_link            =   houzez_get_template_link('template/template-thankyou.php');
    $clientId               =   houzez_option('paypal_client_id');
    $clientSecret           =   houzez_option('paypal_client_secret_key');
    $price_per_submission   =   floatval( $price_per_submission );
    $price_per_submission   =   number_format($price_per_submission, 2, '.', '');
    $submission_curency     =   esc_html( $currency );
    $headers                =   'From: My Name <myname@example.com>' . "\r\n";


    if ( isset($_GET['token']) && isset($_GET['PayerID']) ){
        $token    = wp_kses ( $_GET['token'], $allowed_html );
        $payerID  = wp_kses ( $_GET['PayerID'] ,$allowed_html);

        /* Get saved data in database during execution
         -----------------------------------------------*/
        $transfered_data     = get_option('houzez_paypal_transfer');
        $prop_id             = $transfered_data[ $userID ]['property_id'];
        $payment_execute_url = $transfered_data[ $userID ]['payment_execute_url'];
        $token               = $transfered_data[ $userID ]['paypal_token'];
        $is_prop_featured    = $transfered_data[ $userID ]['is_prop_featured'];
        $is_prop_upgrade     = $transfered_data[ $userID ]['is_prop_upgrade'];

        $payment_execute = array(
            'payer_id' => $payerID
        );

        $json           = json_encode( $payment_execute );
        $json_response  = houzez_execute_paypal_request( $payment_execute_url, $json, $token );

        $transfered_data[$current_user->ID ]  =   array();
        update_option ('houzez_paypal_transfer',$transfered_data);
        $paymentMethod = 'Paypal';

        //print_r($json_response);
        if( $json_response['state']=='approved' ) {

            $time = time();
            $date = date( 'Y-m-d H:i:s', $time );

            if( $is_prop_upgrade == 1 ) {

                $invoiceID = houzez_generate_invoice( 'Upgrade to Featured','one_time', $prop_id, $date, $userID, 0, 1, '', $paymentMethod );
                update_post_meta( $invoiceID, 'invoice_payment_status', 1 );
                update_post_meta( $prop_id, 'fave_featured', 1 );
                //houzez_email_to_admin('email_upgrade');

                $args = array(
                    'listing_title'  =>  get_the_title($prop_id),
                    'listing_id'     =>  $prop_id,
                    'invoice_no' =>  $invoiceID,
                    'listing_url'    =>  get_permalink($prop_id),
                );

                /*
                 * Send email
                 * */
                houzez_email_type( $user_email, 'featured_submission_listing', $args);
                houzez_email_type( $admin_email, 'admin_featured_submission_listing', $args);

            } else {

                update_post_meta( $prop_id, 'fave_payment_status', 'paid' );

                if( $listings_admin_approved != 'yes' ){
                    $post = array(
                        'ID'            => $prop_id,
                        'post_status'   => 'publish'
                    );
                    $post_id =  wp_update_post($post );
                }  else {
                    $post = array(
                        'ID'            => $prop_id,
                        'post_status'   => 'pending'
                    );
                    $post_id =  wp_update_post($post );
                }

                if( $is_prop_featured == 1 ) {
                    update_post_meta( $prop_id, 'fave_featured', 1 );
                    $invoiceID = houzez_generate_invoice( 'Listing with Featured','one_time', $prop_id, $date, $userID, 1, 0, '', $paymentMethod );
                } else {
                    $invoiceID = houzez_generate_invoice( 'Listing','one_time', $prop_id, $date, $userID, 0, 0, '', $paymentMethod );
                }

                update_post_meta( $invoiceID, 'invoice_payment_status', 1 );

                $args = array(
                    'listing_title'  =>  get_the_title($prop_id),
                    'listing_id'     =>  $prop_id,
                    'invoice_no'     =>  $invoiceID,
                    'listing_url'    =>  get_permalink($prop_id),
                );

                /*
                 * Send email
                 * */
                houzez_email_type( $user_email, 'paid_submission_listing', $args);
                houzez_email_type( $admin_email, 'admin_paid_submission_listing', $args);
            }

        }
    }

}  // end perlisting

else if( $enable_paid_submission == 'membership' ) {
    /*-----------------------------------------------------------------------------------*/
    // Paypal payments for membeship packages
    /*-----------------------------------------------------------------------------------*/
    if (isset($_GET['token'])) {
        $allowed_html = array();
        $token = wp_kses($_GET['token'], $allowed_html);
        $token_recursive = wp_kses($_GET['token'], $allowed_html);
        $paymentMethod = 'Paypal';
        $time = time();
        $date = date('Y-m-d H:i:s',$time);

        // get transfer data
        $save_data = get_option('houzez_paypal_package_transfer');
        $payment_execute_url = $save_data[$userID]['payment_execute_url'];
        $token = $save_data[$userID]['access_token'];
        $pack_id = $save_data[$userID]['package_id'];

        $recursive = 0;
        if (isset ($save_data[$userID]['recursive'])) {
            $recursive = $save_data[$userID]['recursive'];
        }

        if ($recursive != 1) {
            if (isset($_GET['PayerID'])) {
                $payerId = wp_kses($_GET['PayerID'], $allowed_html);

                $payment_execute = array(
                    'payer_id' => $payerId
                );
                $json = json_encode($payment_execute);
                $json_resp = houzez_execute_paypal_request($payment_execute_url, $json, $token);

                $save_data[$current_user->ID] = array();
                update_option('houzez_paypal_package_transfer', $save_data);
                update_user_meta($userID, 'houzez_paypal_package', $save_data);

                if ($json_resp['state'] == 'approved') {

                    houzez_save_user_packages_record($userID);
                    if( houzez_check_user_existing_package_status( $current_user->ID, $pack_id ) ){
                        houzez_downgrade_package( $current_user->ID, $pack_id );
                        houzez_update_membership_package( $userID, $pack_id);
                    }else{
                        houzez_update_membership_package($userID, $pack_id);
                    }

                    $invoiceID = houzez_generate_invoice( 'package', 'one_time', $pack_id, $date, $userID, 0, 0, '', $paymentMethod, 1 );
                    update_post_meta( $invoiceID, 'invoice_payment_status', 1 );

                    $args = array();

                    houzez_email_type( $user_email,'purchase_activated_pack', $args );

                }
            } //end if Get
         //end recursive if condition
        } else {

            $payment_execute = array();
            $json = json_encode($payment_execute);
            $json_resp = houzez_execute_paypal_request($payment_execute_url, $json, $token);

            if($json_resp['state']=='Active' && $json_resp['payer']['status'] == 'verified' ) {

                $profileID = $json_resp['id'];

                houzez_save_user_packages_record($userID);
                if( houzez_check_user_existing_package_status( $current_user->ID, $pack_id ) ) {
                    houzez_downgrade_package( $current_user->ID, $pack_id );
                    houzez_update_membership_package( $userID, $pack_id );
                }else{
                    houzez_update_membership_package( $userID, $pack_id );
                }

                delete_post_meta($pack_id, 'houzez_paypal_billing_plan_'.$is_paypal_live);

                $invoiceID = houzez_generate_invoice( 'package', 'recurring', $pack_id, $date, $userID, 0, 0, '', $paymentMethod, 1 );
                update_post_meta( $invoiceID, 'invoice_payment_status', 1 );

                update_user_meta( $userID, 'houzez_paypal_recurring_profile_id', $profileID );

                $args = array();

                houzez_email_type( $user_email,'purchase_activated_pack', $args );
            } 

        } // End else

    }
}
get_header(); ?>

<section class="frontend-submission-page">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="dashboard-content-block">
                    <?php 
                    if( isset( $_GET['directy_pay'] ) && $_GET['directy_pay'] != '' ) {
                        $orderID = $_GET['directy_pay'];
                        $invoice_meta = houzez_get_invoice_meta( $orderID );
                        ?>
                        <p><strong><?php echo houzez_option('thankyou_wire_title'); ?></strong></p>
                        <ul style="text-align: left;">
                            <li><?php echo $houzez_local['order_number'].':'; ?> <strong><?php echo esc_attr($orderID); ?></strong> </li>
                            <li><?php echo $houzez_local['date'].':'; ?> <strong><?php echo get_the_date('', $orderID); ?></strong> </li>
                            <li><?php echo $houzez_local['total'].':'; ?> <strong><?php echo houzez_get_invoice_price( $invoice_meta['invoice_item_price'] );?></strong> </li>
                            <li><?php echo $houzez_local['payment_method'].':'; ?>
                                <strong>
                                    <?php if( $invoice_meta['invoice_payment_method'] == 'Direct Bank Transfer' ) {
                                        echo $houzez_local['bank_transfer'];
                                    } else {
                                        echo $invoice_meta['invoice_payment_method'];
                                    } ?>
                                </strong>
                            </li>
                        </ul>
                        <p> <?php echo houzez_option('thankyou_wire_des'); ?></p>

                    <?php
                    } else { ?>

                    <p><strong><?php echo houzez_option('thankyou_title'); ?></strong></p>
                    <p><?php echo houzez_option('thankyou_des'); ?></p>
                    <?php } ?>
                    <a class="btn btn-primary-outlined" href="<?php echo esc_url( $dash_properties_link ); ?>"><?php echo $houzez_local['goto_dash']; ?></a>
                </div><!-- dashboard-content-block -->
            </div>
        </div><!-- row -->
    </div><!-- container -->
</section><!-- frontend-submission-page -->

<?php get_footer(); ?>