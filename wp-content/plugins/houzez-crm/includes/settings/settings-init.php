<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( file_exists( HOUZEZ_CRM_DIR . 'includes/settings/class-crm-settings-api.php' ) ) {
    include_once( HOUZEZ_CRM_DIR . 'includes/settings/class-crm-settings-api.php' );
}

if ( class_exists( 'WP_OSA' ) ) {

	global $hcrm_settings;
	$hcrm_settings = new WP_OSA();

	do_action( 'hcrm_before_settings_loaded', $hcrm_settings );

	/**
	 * Adding sections.
	 */
    $hcrm_sections_array	= apply_filters( 'hcrm_settings_sections', array(
    	array(
			'id'    => 'hcrm_lead_settings',
			'title' => __( 'Leads Settings', 'houzez-crm' )
		),
		array(
			'id'    => 'hcrm_enquiry_settings',
			'title' => __( 'Enquiries Settings', 'houzez-crm' )
		),
		array(
			'id'    => 'hcrm_deals_settings',
			'title' => __( 'Deals Settings', 'houzez-crm' )
		)
    ) );

    if ( ! empty( $hcrm_sections_array ) && is_array( $hcrm_sections_array ) ) {
        foreach ( $hcrm_sections_array as $section ) {
    		$hcrm_settings->add_section( $section );
    	}
    }

	/**
	 * Lead settings file.
	 *
	 * @since 1.0.0
	 */
	if ( file_exists( HOUZEZ_CRM_DIR . 'includes/settings/lead-settings.php' ) ) {
	    include_once( HOUZEZ_CRM_DIR . 'includes/settings/lead-settings.php' );
	}

	/**
	 * Enquiry settings file.
	 *
	 * @since 1.0.0
	 */
	if ( file_exists( HOUZEZ_CRM_DIR . 'includes/settings/enquiry-settings.php' ) ) {
	    include_once( HOUZEZ_CRM_DIR . 'includes/settings/enquiry-settings.php' );
	}

	/**
	 * Deals settings file.
	 *
	 * @since 1.0.0
	 */
	if ( file_exists( HOUZEZ_CRM_DIR . 'includes/settings/deals-settings.php' ) ) {
	    include_once( HOUZEZ_CRM_DIR . 'includes/settings/deals-settings.php' );
	}


	do_action( 'hcrm_after_settings_loaded', $hcrm_settings );
}