<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
if(!class_exists('Fave_Visits')) {

    class Fave_Visits {

        public function __construct() {
           
            // Count listing visits.
            add_action( 'template_redirect', array($this, 'add_visit') );
            add_filter('get_user_listing_time_query', array($this, 'get_user_listing_time_query'), 10, 2);

        }

        //Add visits data
        public function add_visit() { 
            if ( ! is_singular( 'property' ) ) {
                return;
            }
            global $wpdb, $post;

            $table_name        = $wpdb->prefix . 'favethemes_insights';

            $ip_address        = Fave_Visitor::get_ip();
            $unique_identifier = Fave_Visitor::unique_identifier();
            $get_referrer      = Fave_Visitor::get_referrer();
            $referral_url      = $get_referrer ? $get_referrer['url'] : null;
            $referral_domain   = $get_referrer ? $get_referrer['domain'] : null;
            $get_platform      = Fave_Visitor::get_platform();
            $platform          = isset($get_platform['platform']) ? $get_platform['platform'] : null;
            $device            = isset($get_platform['device']) ? $get_platform['device'] : null;
            $get_language      = Fave_Visitor::get_language();
            $get_browser       = Fave_Visitor::get_browser();
            $get_user_agent    = Fave_Visitor::get_user_agent();
            $get_location      = Fave_Visitor::get_location();
            $location          = explode(',', $get_location);
            $city              = isset($location[0]) ? $location[0] : null;
            $country           = isset($location[1]) ? $location[1] : null;
            $country_code      = isset($location[2]) ? $location[2] : null;

            //wp_die($unique_identifier);

            $data = array(
                'listing_id'        => $post->ID,
                'time'              => gmdate('Y-m-d H:i:s'),
                'ip_address'        => $ip_address,
                'unique_identifier' => $unique_identifier,
                'referral_url'      => $referral_url,
                'referral_domain'   => $referral_domain,
                'platform'          => $platform,
                'device'            => $device,
                'browser'           => $get_browser,
                'http_user_agent'   => $get_user_agent,
                'language'          => $get_language,
                'country_code'      => $country_code,
                'country'           => $country,
                'city'              => $city,
            );

            $format = array(
                '%d',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
            );

            $wpdb->insert($table_name, $data, $format);
        }

        
        /**
         * Get country data.
         *
         * @access public
         * @return array
         */
        public function get_countries( $args = array() ) {
            $countries = array();
            $results = $this->count_column_data( 'country', $args );
            
            foreach ( $results as $result ) {
                
                $countries[] = [
                    'name' => $result->country,
                    'count' => $result->country_count,
                ];
            }

            return $countries;
        }

        /**
         * Get browsers data.
         *
         * @access public
         * @return array
         */
        public function get_browsers_data( $args = array() ) {
            $column = 'browser';
            $browsers = array();

            $results = $this->count_column_data( $column, $args );

            foreach ( $results as $result ) {
                
                $browsers[] = [
                    'name' => $result->browser,
                    'count' => $result->browser_count,
                ];
            }

            return $browsers;
        }


        /**
         * Get platforms data.
         *
         * @access public
         * @return array
         */
        public function get_platforms( $args = array() ) {
            $platforms = array();
            $results = $this->count_column_data( 'platform', $args );
        
            foreach ( $results as $result ) {
            
                $platforms[] = [
                    'name' => $result->platform,
                    'count' => $result->platform_count,
                ];
            }

            return $platforms;
        }

        /**
         * Get devices data.
         *
         * @access public
         * @return array
         */
        public function get_devices( $args = array() ) {
            $devices = array();
            $results = $this->count_column_data( 'device', $args );
    
            foreach ( $results as $result ) {
                
                $devices[] = [
                    'name' => $result->device,
                    'count' => $result->device_count,
                ];
            }

            return $devices;
        }

        public static function get_referrers( $args = array() ) {
            global $wpdb;
            $referrers = array();
            $table_name = $wpdb->prefix . 'favethemes_insights';
            $query = array();

            $args = wp_parse_args( $args, [
                'listing_id' => false,
                'user_id' => false,
                'time' => false,
            ] );

            
            $query[] = "SELECT {$table_name}.referral_domain AS referral_domain,
                    COUNT( {$table_name}.referral_domain ) AS referral_domain_count
                    FROM {$table_name}
                    INNER JOIN {$wpdb->posts} ON ( {$wpdb->posts}.ID = {$table_name}.listing_id )
                    WHERE {$wpdb->posts}.post_status = 'publish'
                    AND {$table_name}.referral_domain IS NOT NULL
                    AND {$table_name}.referral_url IS NOT NULL
            ";

            //apply fiter for user_id. listing_id and time
            $query   = apply_filters('get_user_listing_time_query', $query, $args);

            $query[] = "GROUP BY referral_domain";
            $query[] = "ORDER BY referral_domain_count DESC";
            $query[] = "LIMIT 15";

            $query = join( "\n", $query );
            $results = $wpdb->get_results( $query, OBJECT );

            if ( ! is_array( $results ) || empty( $results ) ) {
                return $referrers;
            }

            foreach ( $results as $result ) {
                $domain = $result->referral_domain;

                $referrers[] = [
                    'domain' => $domain,
                    'count' => $result->referral_domain_count,
                    'subrefs' => self::get_domain_referrers( $domain, $args, $table_name ),
                ];
            }

            return $referrers;
        }

        public static function get_domain_referrers( $domain, $args = array(), $table_name ) {
            global $wpdb;
            $query = array();
            $referrals = array();

            if ( empty( $domain ) ) {
                return $referrals;
            }

            $args = wp_parse_args( $args, [
                'listing_id' => false,
                'user_id' => false,
                'time' => false,
            ] );

            $query[] = "SELECT {$table_name}.referral_url AS referral_url,
                    COUNT( {$table_name}.referral_url ) AS referral_url_count
                    FROM {$table_name}
                    INNER JOIN {$wpdb->posts} ON ( {$wpdb->posts}.ID = {$table_name}.listing_id )
                    WHERE {$wpdb->posts}.post_status = 'publish'
                    AND {$table_name}.referral_domain = %s
                    AND {$table_name}.referral_url IS NOT NULL
            ";

            //apply fiter for user_id. listing_id and time
            $query   = apply_filters('get_user_listing_time_query', $query, $args);

            $query[] = "GROUP BY referral_url";
            $query[] = "ORDER BY referral_url_count DESC";
            $query[] = "LIMIT 10";

            $query = join( "\n", $query );
            $results = $wpdb->get_results( $wpdb->prepare( $query, $domain ), OBJECT );

            if ( ! is_array( $results ) || empty( $results ) ) {
                return $referrals;
            }

            foreach ( $results as $result ) {
                
                $referrals[] = [
                    'url' => $result->referral_url,
                    'count' => $result->referral_url_count,
                ];
            }

            return $referrals;
        }

        /**
         * count given column data
         *
         * @access public
         * @return object|null
         */
        public function count_column_data( $column, $args = array() ) {
            global $wpdb;
            $query = array();
            $empty = array();
            $table_name = $wpdb->prefix . 'favethemes_insights';

            $args = wp_parse_args( $args, array(
                'user_id'    => false,
                'listing_id' => false,
                'time'       => false,
            ));

            
            $query[] = "SELECT {$table_name}.{$column} AS {$column},
                    COUNT( {$table_name}.{$column} ) AS {$column}_count
                    FROM {$table_name}
                    INNER JOIN {$wpdb->posts} ON ( {$wpdb->posts}.ID = {$table_name}.listing_id )
                    WHERE {$wpdb->posts}.post_status = 'publish'
                    AND {$table_name}.{$column} IS NOT NULL
            ";

            //apply fiter for user_id. listing_id and time
            $query   = apply_filters('get_user_listing_time_query', $query, $args);

            $query[] = "GROUP BY {$column}";
            $query[] = "ORDER BY {$column}_count DESC";
            $query[] = "LIMIT 15";

            $query = join( "\n", $query );

            $result = $wpdb->get_results( $query, OBJECT );

            if ( ! is_array( $result ) || empty( $result ) ) {
                return $empty;
            }

            return $result;
        }

        /**
         * Get query for single user, single listing and time frame
         *
         * @access public
         * @return array
         */
        public function get_user_listing_time_query( $query, $args ) {
            global $wpdb;
            $table_name = $wpdb->prefix . 'favethemes_insights';

            $DateTimeZone = wp_timezone();//new DateTimeZone( '+02:30' );
            $DateTime = new DateTime('now', $DateTimeZone);

            if ( !empty( $args['user_id'] ) ) {
                $query[] = sprintf( " AND {$wpdb->posts}.post_author = %d ", $args['user_id'] );
            }

            if ( !empty( $args['listing_id'] ) ) {
                $query[] = sprintf( " AND {$table_name}.listing_id = %d ", $args['listing_id'] );
            }

            if ( !empty( $args['time'] ) && in_array( $args['time'], ['lastday', 'lasttwo', 'lastweek', 'last2week', 'lastmonth', 'last2month', 'lasthalfyear', 'lastyear'] ) ) {

                $time_token = [ 'lastday' => '-1 day', 'lasttwo' => '-2 day', 'lastweek' => '-7 days', 'last2week' => '-14 days', 'lastmonth' => '-30 days', 'last2month' => '-60 days', 'lasthalfyear' => '-182 days', 'lastyear' => '-365 days' ];

                $modifiedTime = $DateTime->modify( $time_token[ $args['time'] ] )->format('Y-m-d H:i:s');

                $query[] = sprintf(
                    " AND {$table_name}.time >= '%s' ", $modifiedTime
                );
            }
            return $query;
        }



    } // end class

    new Fave_Visits();
} // End !exist