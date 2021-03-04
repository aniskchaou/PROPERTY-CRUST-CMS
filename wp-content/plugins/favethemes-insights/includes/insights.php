<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
if(!class_exists('Fave_Insights')) {

    class Fave_Insights {

        private $admin_stats;
        private $stats_cache;
        private $user_stats = array();
        private $single_listing_stats = array();

        public function __construct() {
           
           $this->stats_cache = apply_filters( 'fave_stats_cache', ( 1 * MINUTE_IN_SECONDS ) );

        }

        /**
         * show logged-in user stats.
         */
        public function fave_user_stats( $user_id ) {
            if ( empty( $this->user_stats[ $user_id ] ) ) {
                
                $this->user_stats[ $user_id ] = self::get_user_stats($user_id);
                
            }

            return $this->user_stats[ $user_id ];
        }


        public static function get_user_stats($user_id) {

            $stats = array();
            $args = array('user_id' => $user_id);

            $stats['views'] = self::get_views($args);
            $stats['unique_views'] = self::get_unique_views($args);
            $stats['others'] = self::get_bcpdr_data($args);
            $stats['charts'] = self::get_charts_data($args);
            

            return $stats;
        }

        /**
         * show listing stats.
         */
        public function fave_listing_stats( $listing_id ) {
            if ( empty( $this->single_listing_stats[ $listing_id ] ) ) {
                
                $this->single_listing_stats[ $listing_id ] = self::get_listing_stats($listing_id);
                
            }

            return $this->single_listing_stats[ $listing_id ];
        }

        public static function get_listing_stats($listing_id) {

            $stats = array();
            $args = array('listing_id' => $listing_id);

            $stats['views'] = self::get_views($args);
            $stats['unique_views'] = self::get_unique_views($args);
            $stats['others'] = self::get_bcpdr_data($args);
            $stats['charts'] = self::get_charts_data($args);
            

            return $stats;
        }

        public static function get_views( $args = array() ) {
            $return = array();
            $user_id = isset( $args['user_id'] ) ? $args['user_id'] : false;
            $listing_id = isset( $args['listing_id'] ) ? $args['listing_id'] : false;
            
            $return['lastday'] = self::get_insights( [ 'user_id' => $user_id, 'listing_id' => $listing_id, 'time' => 'lastday' ] );
            $return['lasttwo'] = self::get_insights( [ 'user_id' => $user_id, 'listing_id' => $listing_id, 'time' => 'lasttwo' ] );
            $return['lastweek'] = self::get_insights( [ 'user_id' => $user_id, 'listing_id' => $listing_id, 'time' => 'lastweek' ] );
            $return['last2week'] = self::get_insights( [ 'user_id' => $user_id, 'listing_id' => $listing_id, 'time' => 'last2week' ] );
            $return['lastmonth'] = self::get_insights( [ 'user_id' => $user_id, 'listing_id' => $listing_id, 'time' => 'lastmonth' ] );
            $return['last2month'] = self::get_insights( [ 'user_id' => $user_id, 'listing_id' => $listing_id, 'time' => 'last2month' ] );
            
            return $return;
        }

        public static function get_unique_views( $args = array() ) {
            $return = array();
            $user_id = isset( $args['user_id'] ) ? $args['user_id'] : false;
            $listing_id = isset( $args['listing_id'] ) ? $args['listing_id'] : false;
            
            $return['lastday'] = self::get_insights( [ 'user_id' => $user_id, 'listing_id' => $listing_id, 'time' => 'lastday', 'unique' => true ] );
            $return['lasttwo'] = self::get_insights( [ 'user_id' => $user_id, 'listing_id' => $listing_id, 'time' => 'lasttwo', 'unique' => true ] );
            $return['lastweek'] = self::get_insights( [ 'user_id' => $user_id, 'listing_id' => $listing_id, 'time' => 'lastweek', 'unique' => true ] );
            $return['last2week'] = self::get_insights( [ 'user_id' => $user_id, 'listing_id' => $listing_id, 'time' => 'last2week', 'unique' => true ] );
            $return['lastmonth'] = self::get_insights( [ 'user_id' => $user_id, 'listing_id' => $listing_id, 'time' => 'lastmonth', 'unique' => true ] );
            $return['last2month'] = self::get_insights( [ 'user_id' => $user_id, 'listing_id' => $listing_id, 'time' => 'last2month', 'unique' => true ] );
            
            return $return;
        }

        public static function get_bcpdr_data( $args = array() ) {
            $visits_obj = new Fave_Visits();

            $return = array();
            $user_id = isset( $args['user_id'] ) ? $args['user_id'] : false;
            $listing_id = isset( $args['listing_id'] ) ? $args['listing_id'] : false;
            
            $return['browsers'] = $visits_obj->get_browsers_data( [ 'user_id' => $user_id, 'listing_id' => $listing_id ] );
            $return['referrers'] = $visits_obj->get_referrers( [ 'user_id' => $user_id, 'listing_id' => $listing_id ] );
            $return['countries'] = $visits_obj->get_countries( [ 'user_id' => $user_id, 'listing_id' => $listing_id ] );
            
            $return['platforms'] = $visits_obj->get_platforms( [ 'user_id' => $user_id, 'listing_id' => $listing_id ] );
            $return['devices'] = $visits_obj->get_devices( [ 'user_id' => $user_id, 'listing_id' => $listing_id ] );

            return $return;
        }

        public static function get_charts_data( $args = array() ) {
           
            $return = array();
            $user_id = isset( $args['user_id'] ) ? $args['user_id'] : false;
            $listing_id = isset( $args['listing_id'] ) ? $args['listing_id'] : false;
            
            $return['lastday'] = self::get_chart_visits( [ 'time' => 'lastday', 'group_by' => 'hour', 'user_id' => $user_id, 'listing_id' => $listing_id ] );
            
            
            $return['lastweek'] = self::get_chart_visits( [ 'time' => 'lastweek', 'group_by' => 'day', 'user_id' => $user_id, 'listing_id' => $listing_id ] );
            
    
            $return['lastmonth'] = self::get_chart_visits( [ 'time' => 'lastmonth', 'group_by' => 'day', 'user_id' => $user_id, 'listing_id' => $listing_id ] );
            
            
            $return['lasthalfyear'] = self::get_chart_visits( [ 'time' => 'lasthalfyear', 'group_by' => 'week', 'user_id' => $user_id, 'listing_id' => $listing_id ] );
        
        
            $return['lastyear'] = self::get_chart_visits( [ 'time' => 'lastyear', 'group_by' => 'month', 'user_id' => $user_id, 'listing_id' => $listing_id ] );
            

            return $return;
        }


        public static function get_insights( $args = array() ) {
            global $wpdb;
            $table_name = $wpdb->prefix . 'favethemes_insights';
            $query = array();

            $args = wp_parse_args( $args, [
                'listing_id' => false,
                'user_id' => false,
                'time' => false,
                'unique' => false,
            ] );

            if ( $args['unique'] ) {
                $query[] = "SELECT COUNT( DISTINCT( {$table_name}.unique_identifier ) ) AS count";
            } else {
                $query[] = "SELECT COUNT( {$table_name}.id ) AS count";
            }

            $query[] = "FROM {$table_name}";
            $query[] = "INNER JOIN {$wpdb->posts} ON ( {$wpdb->posts}.ID = {$table_name}.listing_id )";
            $query[] = "WHERE {$wpdb->posts}.post_status = 'publish'";

            $query = apply_filters('get_user_listing_time_query', $query, $args);
            $query = join( "\n", $query );

            $results = $wpdb->get_row( $query, OBJECT );

            return is_object( $results ) && ! empty( $results->count ) ? (int) $results->count : 0;
        }



        public static function get_chart_visits( $args = array() ) {
            global $wpdb;
            $table_name = $wpdb->prefix . 'favethemes_insights';
            $visits = array();
            $query = array();

            $args = wp_parse_args( $args, [
                'listing_id' => false,
                'user_id' => false,
                'time' => false,
                'group_by' => 'day',
            ] );

            $groups = [
                'hour' => [
                    'query' => "DATE_FORMAT( {$table_name}.time, '%Y-%m-%d %H:00:00' )",
                    'modifier' => '-1 hour',
                    'id' => 'Y-m-d H:00:00',
                    'count' => function( $a ) { return $a * 24; },
                    'label' => function( $date ) { return $date->format( 'H:00' ); },
                ],
                'day' => [
                    'query' => "DATE( {$table_name}.time )",
                    'modifier' => '-1 day',
                    'id' => 'Y-m-d',
                    'count' => function( $b ) { return $b; },
                    'label' => function( $date ) { return $date->format( 'M j' ); },
                ],
                'week' => [
                    'query' => "DATE_FORMAT( {$table_name}.time, '%x-%v' )",
                    'modifier' => '-1 week',
                    'count' => function( $c ) { return $c / 7; },
                    'id' => 'o-W',
                    'label' => function( $date ) { return $date->format( 'M j' ); },
                ],
                'month' => [
                    'query' => "DATE_FORMAT( {$table_name}.time, '%Y-%m-01' )",
                    'modifier' => '-1 month',
                    'id' => 'Y-m-01',
                    'count' => function( $d ) { return $d / 31; },
                    'label' => function( $date ) { return $date->format( 'M' ); },
                ],
            ];

            
            $group = isset( $groups[ $args['group_by'] ] ) ? $groups[ $args['group_by'] ] : $groups['day'];

            
            $query[] = "
                SELECT
                    COUNT( {$table_name}.id ) AS views,
                    COUNT( DISTINCT( {$table_name}.unique_identifier ) ) AS unique_views,
                    {$group['query']} as date
            ";

            $query[] = "FROM {$table_name}";
            $query[] = "INNER JOIN {$wpdb->posts} ON ( {$wpdb->posts}.ID = {$table_name}.listing_id )";
            $query[] = "WHERE {$wpdb->posts}.post_status = 'publish'";

            $query = apply_filters('get_user_listing_time_query', $query, $args);

            $query[] = "GROUP BY date";
            $query = join( "\n", $query );

            $results = $wpdb->get_results( $query, OBJECT );
            if ( ! is_array( $results ) || empty( $results ) ) {
                $results = array();
            }

            //return $results;

            $DateTimeZone = wp_timezone();//new DateTimeZone( '+02:30' );
            $date = new DateTime('now', $DateTimeZone);

            $counts = [
                'lastyear' => 365,
                'lasthalfyear' => 182,
                'lastmonth' => 30,
                'lastweek' => 7,
                'lastday' => 1,
            ];

            $count = isset( $counts[ $args['time'] ] ) ? $counts[ $args['time'] ] : 1;
            $count = $group['count']( $count );

            for ( $i = 0; $i < $count; $i++ ) {
                $id = $date->format( $group['id'] );
                $visits[ $id ] = [
                    'views' => 0,
                    'unique_views' => 0,
                    'date' => $id,
                    'label' => $group['label']( $date ),
                ];
                $date->modify( $group['modifier'] );
            }

            foreach ( $results as $result ) {
                $result->views = isset( $result->views ) ? $result->views : 0;
                $result->unique_views = isset( $result->unique_views ) ? $result->unique_views : 0;
                $visits[ $result->date ]['views'] = $result->views;
                $visits[ $result->date ]['unique_views'] = $result->unique_views;
            }

            return array_reverse( $visits );
        }


    } // end class

    new Fave_Insights();
} // End !exist