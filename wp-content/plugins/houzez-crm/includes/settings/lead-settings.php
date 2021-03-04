<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $hcrm_settings;

$lead_settings	= apply_filters( 'hcrm_lead_settings', array(
	
	array(
		'id'      => 'prefix',
		'type'    => 'text',
		'name'    => esc_html__('Lead Prefix', 'houzez-crm'),
		'desc'    => esc_html__( 'Provide comma separated values e.g (Mr, Mrs, Ms, Miss, Dr, Prof, Mr & Mrs).', 'houzez-crm' ),
		'default' => 'Mr, Mrs, Ms, Miss, Dr, Prof, Mr & Mrs',
	),
	array(
		'id'      => 'source',
		'type'    => 'textarea',
		'name'    => esc_html__('Source', 'houzez-crm'),
		'desc'    => esc_html__( 'Provide comma separated values e.g (Website, Newspaper, Friend, Google, Facebook).', 'houzez-crm' ),
		'default' => 'Website, Newspaper, Friend, Google, Facebook',
	),

) );

if ( ! empty( $lead_settings ) && is_array( $lead_settings ) ) {
	foreach ( $lead_settings as $setting ) {
		$hcrm_settings->add_field( 'hcrm_lead_settings', $setting );
	}
}
