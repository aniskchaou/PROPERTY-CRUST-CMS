<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $hcrm_settings;

$deals_settings	= apply_filters( 'hcrm_deals_settings', array(
	
	array(
		'id'      => 'status',
		'type'    => 'textarea',
		'name'    => esc_html__('Status', 'houzez-crm'),
		'desc'    => __( 'Provide comma separated values e.g (New Lead, Meeting Scheduled, Qualified, Proposal Sent, Called, Negotiation, Email Sent). First value will be considered default.', 'houzez-crm' ),
		'default' => 'New Lead, Meeting Scheduled, Qualified, Proposal Sent, Called, Negotiation, Email Sent',
	),

	array(
		'id'      => 'next_action',
		'type'    => 'textarea',
		'name'    => esc_html__('Next Action', 'houzez-crm'),
		'desc'    => __( 'Provide comma separated values e.g (Qualification, Demo, Call, Send a Proposal, Send an Email, Follow Up, Meeting). First value will be considered default.', 'houzez-crm' ),
		'default' => 'Qualification, Demo, Call, Send a Proposal, Send an Email, Follow Up, Meeting',
	),

) );

if ( ! empty( $deals_settings ) && is_array( $deals_settings ) ) {
	foreach ( $deals_settings as $setting ) {
		$hcrm_settings->add_field( 'hcrm_deals_settings', $setting );
	}
}
