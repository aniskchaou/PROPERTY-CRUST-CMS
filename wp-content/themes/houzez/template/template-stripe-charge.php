<?php
/**
 * Template Name: Stripe Charge Page
 * Created by PhpStorm.
 * User: waqasriaz
 * Date: 27/06/16
 * Time: 5:18 AM
 */

require_once( get_template_directory() . '/framework/stripe-php/init.php' );
$allowed_html = array();

$current_user = wp_get_current_user();
$userID       =   $current_user->ID;
$user_email   =   $current_user->user_email;
$admin_email  =  get_bloginfo('admin_email');
$username     =   $current_user->user_login;
$submission_currency = houzez_option('currency_paid_submission');
$thankyou_page_link = houzez_get_template_link('template/template-thankyou.php');
$paymentMethod = 'Stripe';
$time = time();
$date = date('Y-m-d H:i:s',$time);

$stripe_secret_key = houzez_option('stripe_secret_key');
$stripe_publishable_key = houzez_option('stripe_publishable_key');
$stripe = array(
    "secret_key"      => $stripe_secret_key,
    "publishable_key" => $stripe_publishable_key
);
\Stripe\Stripe::setApiKey($stripe['secret_key']);

/*--------------------------------------------------------------
* Webhook Start
---------------------------------------------------------------*/

$input      = @file_get_contents( "php://input" );
$event_json = json_decode( $input );
 
if( $event_json != '') {

    // Get stripe customer id.
    $customer_stripe_id = $event_json->data->object->customer;


    if( $event_json->type == 'invoice.payment_failed'){   
        $args=array('meta_key'    => 'fave_stripe_user_profile', 
                    'meta_value'  => $customer_stripe_id
                );
        $customers=get_users( $args ); 
        foreach ( $customers as $user ) {
            update_user_meta( $user->ID, 'fave_stripe_user_profile', '' );
        }       
    }
    
    
    // Charge Recurring
    if( $event_json->type =='payment_intent.succeeded') {
        $args = array('meta_key'      => 'fave_stripe_user_profile', 
                    'meta_value'    => $customer_stripe_id
        );
        
        $update_user_id =   0;
        $customers=get_users( $args ); 
        foreach ( $customers as $user ) {
            $update_user_id = $user->ID;
        } 
        $pack_id = intval (get_user_meta($update_user_id, 'package_id',true));

        if($update_user_id!=0 && $pack_id!=0){
            houzez_save_user_packages_record($update_user_id);
            if( houzez_check_user_existing_package_status($update_user_id, $pack_id) ){
                houzez_downgrade_package( $update_user_id, $pack_id );
                houzez_update_membership_package($update_user_id, $pack_id);
            }else{
                houzez_update_membership_package($update_user_id, $pack_id);
            }    
        
        }else{
           // echo 'no user exist';           
        } 
        
        $args = array(
            'recurring_package_name' => get_the_title($pack_id),
            'merchant'               => 'Stripe'
        );
        houzez_email_type( $user->user_email, 'recurring_payment', $args );
           
    }
    
    http_response_code(200); 
    exit();
}

/*---------------------------
* End webhook
---------------------------------------------------------------------*/


if( is_email($_POST['stripeEmail']) ) {  // done
    $stripeEmail=  wp_kses ( esc_html($_POST['stripeEmail']) ,$allowed_html );
} else {
    wp_die('None Mail');
}

if( isset($_POST['userID']) && !is_numeric( $_POST['userID'] ) ) { //done
    die();
}

if( isset($_POST['propID']) && !is_numeric( $_POST['propID'] ) ) { //done
    die();
}

if( isset($_POST['submission_pay']) && !is_numeric( $_POST['submission_pay'] ) ) { //done
    die();
}

if( isset($_POST['pack_id']) && !is_numeric( $_POST['pack_id'] ) ){
    die();
}

if( isset($_POST['pay_ammout']) && !is_numeric( $_POST['pay_ammout'] ) ) { //done
    die();
}

if( isset($_POST['featured_pay']) && !is_numeric( $_POST['featured_pay'] ) ){
    die();
}

if( isset($_POST['is_upgrade']) && !is_numeric( $_POST['is_upgrade'] ) ){
    die();
}

if( isset($_POST['houzez_stripe_recurring']) && !is_numeric( $_POST['houzez_stripe_recurring'] ) ){
    die();
}

if ( isset ($_POST['submission_pay'])  && $_POST['submission_pay'] == 1  ) {
    try {
        $token  = wp_kses ( $_POST['stripeToken'] ,$allowed_html);

        $customer = \Stripe\Customer::create(array(
            "email" => $stripeEmail,
            "source" => $token // obtained with Stripe.js
        ));

        $userId      = intval( $_POST['userID'] );
        $listing_id  = intval( $_POST['propID'] );
        $pay_ammout  = intval( $_POST['pay_ammout'] );
        $is_featured = 0;
        $is_upgrade  = 0;

        if ( isset($_POST['featured_pay']) && $_POST['featured_pay']==1 ){
            $is_featured    =   intval($_POST['featured_pay']);
        }

        if ( isset($_POST['is_upgrade']) && $_POST['is_upgrade']==1 ){
            $is_upgrade = intval($_POST['is_upgrade']);
        }

        $charge = \Stripe\Charge::create(array(
            "amount" => $pay_ammout,
            'customer' => $customer->id,
            "currency" => $submission_currency,
            //"source" => "tok_18Qks9IwlqUqVdUMkzqkPsbV", // obtained with Stripe.js
            //"description" => ""
        ));

        if( $is_upgrade == 1 ) {
            update_post_meta( $listing_id, 'fave_featured', 1 );
            $invoice_id = houzez_generate_invoice( 'Upgrade to Featured', 'one_time', $listing_id, $date, $userID, 0, 1, '', $paymentMethod );
            update_post_meta( $invoice_id, 'invoice_payment_status', 1 );

            $args = array(
                'listing_title'  =>  get_the_title($listing_id),
                'listing_id'     =>  $listing_id,
                'invoice_no'     =>  $invoice_id,
                'listing_url'    =>  get_permalink($listing_id),
            );

            /*
             * Send email
             * */
            houzez_email_type( $user_email, 'featured_submission_listing', $args);
            houzez_email_type( $admin_email, 'admin_featured_submission_listing', $args);

        } else {
            update_post_meta( $listing_id, 'fave_payment_status', 'paid' );

            $paid_submission_status    = houzez_option('enable_paid_submission');
            $listings_admin_approved = houzez_option('listings_admin_approved');

            if( $listings_admin_approved != 'yes'  && $paid_submission_status == 'per_listing' ){
                $post = array(
                    'ID'            => $listing_id,
                    'post_status'   => 'publish'
                );
                $post_id =  wp_update_post($post );
            } else {
                $post = array(
                    'ID'            => $listing_id,
                    'post_status'   => 'pending'
                );
                $post_id =  wp_update_post($post );
            }


            if( $is_featured == 1 ) {
                update_post_meta( $listing_id, 'fave_featured', 1 );
                $invoice_id = houzez_generate_invoice( 'Publish Listing with Featured', 'one_time', $listing_id, $date, $userID, 1, 0, '', $paymentMethod );
            } else {
                $invoice_id = houzez_generate_invoice( 'Listing', 'one_time', $listing_id, $date, $userID, 0, 0, '', $paymentMethod );
            }
            update_post_meta( $invoice_id, 'invoice_payment_status', 1 );

            $args = array(
                'listing_title'  =>  get_the_title($listing_id),
                'listing_id'     =>  $listing_id,
                'invoice_no'     =>  $invoice_id,
                'listing_url'    =>  get_permalink($listing_id),
            );

            /*
             * Send email
             * */
            houzez_email_type( $user_email, 'paid_submission_listing', $args);
            houzez_email_type( $admin_email, 'admin_paid_submission_listing', $args);
        }

        wp_redirect( $thankyou_page_link ); exit;

    }
    catch (Exception $e) {
        $error = '<div class="alert alert-danger">
                <strong>Error!</strong> '.$e->getMessage().'
                </div>';
        print $error;
    }

} else if ( isset ($_POST['houzez_stripe_recurring'] ) && $_POST['houzez_stripe_recurring'] == 1 ) {
    /*----------------------------------------------------------------------------------------
    * Payment for Stripe package recuring
    *-----------------------------------------------------------------------------------------*/
    try {
        $token          =   wp_kses ( esc_html($_POST['stripeToken']) ,$allowed_html);
        $pack_id        =   intval($_POST['pack_id']);
        $stripe_plan    =   esc_html(get_post_meta($pack_id, 'fave_package_stripe_id', true));

        $customer_args = apply_filters(
            'houzez_stripe_customer_args',
            array(
                'email'  => $stripeEmail,
                'source' => $token,
            )
        );

        $customer = \Stripe\Customer::create( $customer_args );

        $stripe_customer_id = $customer->id;
 
        $subscription_args = apply_filters(
            'houzez_stripe_subscription_args',
            array(
                'customer' => $stripe_customer_id,
                'plan'     => $stripe_plan,
            )
        );

        $subscription = \Stripe\Subscription::create( $subscription_args );


        houzez_save_user_packages_record($userID);
        if( houzez_check_user_existing_package_status($current_user->ID, $pack_id) ){
            houzez_downgrade_package( $current_user->ID, $pack_id );
            houzez_update_membership_package($userID, $pack_id);
        }else{
            houzez_update_membership_package($userID, $pack_id);
        }

        $invoiceID = houzez_generate_invoice( 'package', 'recurring', $pack_id, $date, $userID, 0, 0, '', $paymentMethod, 1 );
        update_post_meta( $invoiceID, 'invoice_payment_status', 1 );

        $current_stripe_customer_id =  get_user_meta( $current_user->ID, 'fave_stripe_user_profile', true );
        $is_stripe_recurring        =   get_user_meta( $current_user->ID, 'houzez_has_stripe_recurring',true );
        if ($current_stripe_customer_id !=='' && $is_stripe_recurring == 1 ) {
            if( $current_stripe_customer_id !== $stripe_customer_id ){
                houzez_stripe_cancel_subscription();
            }
        }


        update_user_meta( $current_user->ID, 'fave_stripe_user_profile', $stripe_customer_id );
        update_user_meta( $current_user->ID, 'houzez_stripe_subscription_id', $subscription->id );
        update_user_meta( $current_user->ID, 'houzez_stripe_subscription_due', $subscription->current_period_end );
        update_user_meta( $current_user->ID, 'houzez_has_stripe_recurring', 1 );

        $args = array();
        houzez_email_type( $user_email,'purchase_activated_pack', $args );

        wp_redirect( $thankyou_page_link ); exit;

    }
    catch (Exception $e) {
        $error = '<div class="alert alert-danger">
                  <strong>Error!</strong> '.$e->getMessage().'
                  </div>';
        print $error;
    }
} else {

    /*----------------------------------------------------------------------------------------
    * Payment for Stripe package
    *-----------------------------------------------------------------------------------------*/
    try {

        $token  = wp_kses (esc_html($_POST['stripeToken']),$allowed_html);
        $customer = \Stripe\Customer::create(array(
            "email" => $stripeEmail,
            "source" => $token // obtained with Stripe.js
        ));

        $dash_profile_link = houzez_get_dashboard_profile_link();
        $userId     =   intval($_POST['userID']);
        $pay_ammout =   intval($_POST['pay_ammout']);
        $pack_id    =   intval($_POST['pack_id']);

        $charge = \Stripe\Charge::create(array(
            "amount" => $pay_ammout,
            'customer' => $customer->id,
            "currency" => $submission_currency,
            //"source" => "tok_18Qks9IwlqUqVdUMkzqkPsbV", // obtained with Stripe.js
            //"description" => ""
        ));

        houzez_save_user_packages_record($userID);
        if( houzez_check_user_existing_package_status($current_user->ID,$pack_id) ){
            houzez_downgrade_package( $current_user->ID, $pack_id );
            houzez_update_membership_package($userID, $pack_id);
        }else{
            houzez_update_membership_package($userID, $pack_id);
        }

        $invoiceID = houzez_generate_invoice( 'package', 'one_time', $pack_id, $date, $userID, 0, 0, '', $paymentMethod, 1 );
        update_post_meta( $invoiceID, 'invoice_payment_status', 1 );


        update_user_meta( $current_user->ID, 'houzez_has_stripe_recurring', 0 );

        $args = array();
        houzez_email_type( $user_email,'purchase_activated_pack', $args );

        wp_redirect( $thankyou_page_link ); exit;

    }
    catch (Exception $e) {
        $error = '<div class="alert alert-danger">
                  <strong>Error!</strong> '.$e->getMessage().'
                  </div>';
        print $error;
    }
}
?>