<?php

/**
 * Yelp Fusion API code sample.
 *
 * This program demonstrates the capability of the Yelp Fusion API
 * by using the Business Search API to query for businesses by a 
 * search term and location, and the Business API to query additional 
 * information about the top result from the search query.
 * 
 * Please refer to http://www.yelp.com/developers/v3/documentation 
 * for the API documentation.
 */

// API key placeholders that must be filled in by users.
// You can find it on
// https://www.yelp.com/developers/v3/manage_app
$API_KEY = NULL;

// API constants, you shouldn't have to change these.
$API_HOST = "https://api.yelp.com";
$SEARCH_PATH = "/v3/businesses/search";
$BUSINESS_PATH = "/v3/businesses/";  // Business ID will come after slash.

// Defaults for our simple example.
$DEFAULT_TERM = "dinner";
$DEFAULT_LOCATION = "San Francisco, CA";
$SEARCH_LIMIT = 3;

function houzez_yelp_query_api( $term, $location ) {

    $API_KEY = houzez_option('houzez_yelp_api_key');

    $query_url = add_query_arg(
        array(
            'term'     => $term,
            'location' => $location,
            'limit'    => intval( houzez_option( 'houzez_yelp_limit', 3 ) ),
            'sort_by'  => 'distance'
        ),
        'https://api.yelp.com/v3/businesses/search'
    );

    $args = array(
        'user-agent' => '',
        'headers'    => array(
            'authorization' => 'Bearer ' . $API_KEY,
        ),
    );

    $response = wp_safe_remote_get( $query_url, $args );
    if ( is_wp_error( $response ) ) {
        return false;
    }

    if ( ! empty( $response['body'] ) && is_ssl() ) {
        $response['body'] = str_replace( 'http:', 'https:', $response['body'] );
    } elseif ( is_ssl() ) {
        $response = str_replace( 'http:', 'https:', $response );
    }
    $response = str_replace( 'http:', 'https:', $response );

    return json_decode( $response['body'] );
}

?>