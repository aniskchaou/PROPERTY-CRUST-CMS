<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $hcrm_settings;

$enquiry_settings	= apply_filters( 'hcrm_enquiry_settings', array(
	
	array(
		'id'      => 'enquiry_type',
		'type'    => 'textarea',
		'name'    => esc_html__('Enquiry Type', 'houzez-crm'),
		'desc'    => esc_html__( 'Provide comma separated values e.g (Purchase, Rent, Sell, Miss, Evaluation, Mortgage).', 'houzez-crm' ),
		'default' => 'Purchase, Rent, Sell, Miss, Evaluation, Mortgage',
	)

) );

if ( ! empty( $enquiry_settings ) && is_array( $enquiry_settings ) ) {
	foreach ( $enquiry_settings as $setting ) {
		$hcrm_settings->add_field( 'hcrm_enquiry_settings', $setting );
	}
}
