<?php
/**
 * Plugin rewrite functions.
 *
 * @package    Houzez
 * @subpackage houzez theme functionality
 * @author     Waqas Riaz <waqas@favethemes.com>
 * @copyright  Copyright (c) 2016, Waqas Riaz
 * @link       http://favethemes.com
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Returns the property rewrite slug used for single projects.
 *
 * @since  1.0.8
 * @access public
 * @return string
 */
function houzez_get_property_rewrite_slug() {
	$property_base   = houzez_get_property_rewrite_base();

	$slug = $property_base;

	return apply_filters( 'houzez_get_property_rewrite_slug', $slug );
}

/**
 * Returns the agent rewrite slug used for single agents.
 *
 * @since  1.0.8
 * @access public
 * @return string
 */
function houzez_get_agent_rewrite_slug() {
	$agent_base   = houzez_get_agent_rewrite_base();

	$slug = $agent_base;

	return apply_filters( 'houzez_get_agent_rewrite_slug', $slug );
}

/**
 * Returns the agency rewrite slug used for single agencys.
 *
 * @since  1.0.8
 * @access public
 * @return string
 */
function houzez_get_agency_rewrite_slug() {
	$agency_base   = houzez_get_agency_rewrite_base();

	$slug = $agency_base;

	return apply_filters( 'houzez_get_agency_rewrite_slug', $slug );
}


/**
 * Returns the property type rewrite slug used for property type taxonomy.
 *
 * @since  1.0.8
 * @access public
 * @return string
 */
function houzez_get_property_type_rewrite_slug() {
	$property_type_base = houzez_get_property_type_rewrite_base();

	$slug = $property_type_base;

	return apply_filters( 'houzez_get_property_type_rewrite_slug', $slug );
}


/**
 * Returns the property feature rewrite slug used for property type feature.
 *
 * @since  1.0.8
 * @access public
 * @return string
 */
function houzez_get_property_feature_rewrite_slug() {
	$property_feature_base = houzez_get_property_feature_rewrite_base();

	$slug = $property_feature_base;

	return apply_filters( 'houzez_get_property_feature_rewrite_slug', $slug );
}


/**
 * Returns the property status rewrite slug used for property status taxonomy.
 *
 * @since  1.0.8
 * @access public
 * @return string
 */
function houzez_get_property_status_rewrite_slug() {
	$property_status_base = houzez_get_property_status_rewrite_base();

	$slug = $property_status_base;

	return apply_filters( 'houzez_get_property_status_rewrite_slug', $slug );
}


/**
 * Returns the property city rewrite slug used for property city taxonomy.
 *
 * @since  1.0.8
 * @access public
 * @return string
 */
function houzez_get_property_city_rewrite_slug() {
	$property_city_base = houzez_get_property_city_rewrite_base();

	$slug = $property_city_base;

	return apply_filters( 'houzez_get_property_city_rewrite_slug', $slug );
}

/**
 * Returns the property state rewrite slug used for property state taxonomy.
 *
 * @since  1.0.8
 * @access public
 * @return string
 */
function houzez_get_property_state_rewrite_slug() {
	$property_state_base = houzez_get_property_state_rewrite_base();

	$slug = $property_state_base;

	return apply_filters( 'houzez_get_property_state_rewrite_slug', $slug );
}

/**
 * Returns the property country rewrite slug used for property country taxonomy.
 *
 * @since  1.0.8
 * @access public
 * @return string
 */
function houzez_get_property_country_rewrite_slug() {
	$property_country_base = houzez_get_property_country_rewrite_base();

	$slug = $property_country_base;

	return apply_filters( 'houzez_get_property_country_rewrite_slug', $slug );
}


/**
 * Returns the property area rewrite slug used for property area taxonomy.
 *
 * @since  1.0.8
 * @access public
 * @return string
 */
function houzez_get_property_area_rewrite_slug() {
	$property_area_base = houzez_get_property_area_rewrite_base();

	$slug = $property_area_base;

	return apply_filters( 'houzez_get_property_area_rewrite_slug', $slug );
}

/**
 * Returns the property label rewrite slug used for property label taxonomy.
 *
 * @since  2.0.6
 * @access public
 * @return string
 */
function houzez_get_property_label_rewrite_slug() {
	$property_label_base = houzez_get_property_label_rewrite_base();

	$slug = $property_label_base;

	return apply_filters( 'houzez_get_property_label_rewrite_slug', $slug );
}

