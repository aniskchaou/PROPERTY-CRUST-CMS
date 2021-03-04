<?php
/**
 * Template Name: Paypal Webhook ( Recurring Payment )
 * Created by PhpStorm.
 * User: waqasriaz
 * Date: 11/09/16
 * Time: 3:30 PM
 */
$token = '';
define('DEBUG',0);

$headers = 'From: noreply  <noreply@'.$_SERVER['HTTP_HOST'].'>' . "\r\n".
    'Reply-To: noreply@'.$_SERVER['HTTP_HOST']. "\r\n" .
    'X-Mailer: PHP/' . phpversion();

$webhook_data = file_get_contents('php://input');

$webhook_data = json_decode($webhook_data);

$resource_type = $webhook_data->resource_type;
$event_type = $webhook_data->event_type;
$state = $webhook_data->resource->state;
$amount = $webhook_data->resource->amount->total;
$profile_id = $webhook_data->resource->billing_agreement_id;

$paymentMethod = 'Paypal';


if( $resource_type == "sale" && $event_type == "PAYMENT.SALE.COMPLETED" && $state == "completed" ) {
      $time = time();
      $date = date( 'Y-m-d H:i:s', $time );
      
      $user_id = houzez_retrive_user_by_profile($profile_id);
       
      // No User Exist
      if( $user_id == 0 ) {
          exit();
      }

      $pack_id  =  get_user_meta( $user_id, 'package_id',true );
      $price    =  get_post_meta( $pack_id, 'fave_package_price', true );

      // Received payment diffrent than pack value
      if( $amount != $price){
          exit();
      }

      $txn_id = '';

      houzez_save_user_packages_record($user_id);
      houzez_update_membership_package($user_id, $pack_id);


      $args  =array(
          'recurring_package_name' => get_the_title($pack_id),
          'merchant'               => 'Paypal'
      );
      houzez_email_type( $receiver_email, 'recurring_payment', $args );

} else {

  exit('invalid');
}