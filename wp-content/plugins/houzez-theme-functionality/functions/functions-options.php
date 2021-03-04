<?php
/**
 * Plugin options functions.
 *
 * @package    Houzez
 * @subpackage Houzez Theme Functionality
 * @author     Waqas Riaz <waqas@favethemes.com>
 * @copyright  Copyright (c) 2016, Favethemes
 * @link       http://favethemes.com
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Returns the property rewrite base. Used for single properties.
 *
 * @since  1.0.8
 * @access public
 * @return string
 */
function houzez_get_property_rewrite_base() {
	return apply_filters( 'houzez_get_property_rewrite_base', houzez_get_setting( 'property_rewrite_base' ) );
}

/**
 * Returns the agent rewrite base. Used for single agent.
 *
 * @since  1.0.8
 * @access public
 * @return string
 */
function houzez_get_agent_rewrite_base() {
	return apply_filters( 'houzez_get_agent_rewrite_base', houzez_get_setting( 'agent_rewrite_base' ) );
}

/**
 * Returns the agency rewrite base. Used for single agency.
 *
 * @since  1.0.8
 * @access public
 * @return string
 */
function houzez_get_agency_rewrite_base() {
	return apply_filters( 'houzez_get_agency_rewrite_base', houzez_get_setting( 'agency_rewrite_base' ) );
}


/**
 * Returns the property type rewrite base. Used for property type taxonomy.
 *
 * @since  1.0.8
 * @access public
 * @return string
 */
function houzez_get_property_type_rewrite_base() {
	return apply_filters( 'houzez_get_property_type_rewrite_base', houzez_get_setting( 'property_type_rewrite_base' ) );
}


/**
 * Returns the property feature rewrite base. Used for property feature taxonomy.
 *
 * @since  1.0.8
 * @access public
 * @return string
 */
function houzez_get_property_feature_rewrite_base() {
	return apply_filters( 'houzez_get_property_feature_rewrite_base', houzez_get_setting( 'property_feature_rewrite_base' ) );
}


/**
 * Returns the property status rewrite base. Used for property status taxonomy.
 *
 * @since  1.0.8
 * @access public
 * @return string
 */
function houzez_get_property_status_rewrite_base() {
	return apply_filters( 'houzez_get_property_status_rewrite_base', houzez_get_setting( 'property_status_rewrite_base' ) );
}


/**
 * Returns the property area rewrite base. Used for property area taxonomy.
 *
 * @since  1.0.8
 * @access public
 * @return string
 */
function houzez_get_property_area_rewrite_base() {
	return apply_filters( 'houzez_get_property_area_rewrite_base', houzez_get_setting( 'property_area_rewrite_base' ) );
}

/**
 * Returns the property label rewrite base. Used for property label taxonomy.
 *
 * @since  1.0.8
 * @access public
 * @return string
 */
function houzez_get_property_label_rewrite_base() {
	return apply_filters( 'houzez_get_property_label_rewrite_base', houzez_get_setting( 'property_label_rewrite_base' ) );
}


/**
 * Returns the property city rewrite base. Used for property city taxonomy.
 *
 * @since  1.0.8
 * @access public
 * @return string
 */
function houzez_get_property_city_rewrite_base() {
	return apply_filters( 'houzez_get_property_city_rewrite_base', houzez_get_setting( 'property_city_rewrite_base' ) );
}


/**
 * Returns the property state rewrite base. Used for property state taxonomy.
 *
 * @since  1.0.8
 * @access public
 * @return string
 */
function houzez_get_property_state_rewrite_base() {
	return apply_filters( 'houzez_get_property_state_rewrite_base', houzez_get_setting( 'property_state_rewrite_base' ) );
}

/**
 * Returns the property country rewrite base. Used for property country taxonomy.
 *
 * @since  1.0.8
 * @access public
 * @return string
 */
function houzez_get_property_country_rewrite_base() {
	return apply_filters( 'houzez_get_property_country_rewrite_base', houzez_get_setting( 'property_country_rewrite_base' ) );
}

/**
 * Returns a plugin setting.
 *
 * @since  1.0.8
 * @access public
 * @param  string  $setting
 * @return mixed
 */
function houzez_get_setting( $setting ) {

	$defaults = houzez_get_default_settings();
	$settings = wp_parse_args( get_option('houzez_settings', $defaults ), $defaults );

	return isset( $settings[ $setting ] ) ? $settings[ $setting ] : false;
}

/**
 * Returns the default settings for the plugin.
 *
 * @since  1.0.8
 * @access public
 * @return array
 */
function houzez_get_default_settings() {

	$settings = array(
		'property_rewrite_base'   => 'property',
		'property_type_rewrite_base' => 'property-type',
		'property_feature_rewrite_base' => 'feature',
		'property_status_rewrite_base' => 'status',
		'property_area_rewrite_base' => 'area',
		'property_city_rewrite_base' => 'city',
		'property_state_rewrite_base' => 'state',
		'property_country_rewrite_base' => 'country',
		'agent_rewrite_base' => 'agent',
		'agency_rewrite_base' => 'agency',
		'city_taxonomy' => 'enabled',
		'property_label_rewrite_base'  => 'label',
	);

	return $settings;
}
