<?php
/**
 * Class Houzez_Query
 * Created by PhpStorm.
 * User: waqasriaz
 * Date: 28/09/16
 * Time: 11:22 PM
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
if(!class_exists('Houzez_Query')) {
    class Houzez_Query {
        /**
         * Sets agency agents into loop
         *
         * @access public
         * @param null|int $post_id
         * @param null|int $count
         * @return void
         */
        public static function loop_agency_agents( $agency_id = null, $count = null ) {
            if ( null == $agency_id ) {
                $agency_id = get_the_ID();
            }

            $args = array(
                'post_type'         => 'houzez_agent',
                'posts_per_page'    => -1,
                'orderby' => 'title',
                'order' => 'ASC',
                'post_status' => 'publish',
                'meta_query'        => array(
                    array(
                        'key'       =>  'fave_agent_agencies',
                        'value'     => $agency_id,
                        'compare'   => 'LIKE',
                    ),
                ),
            );

            if ( ! empty( $count ) ) {
                $args['posts_per_page'] = $count;
            }

            return new WP_Query( $args );
        }

        /**
         * Sets agency agents ids
         *
         * @access public
         * @param null|int $post_id
         * @param null|int $count
         * @return void
         */
        public static function loop_agency_agents_ids( $agency_id = null, $count = null ) {
            if ( null == $agency_id ) {
                $agency_id = get_the_ID();
            }
            $agent_ids_array = array();
            
            $args = array(
                'post_type'         => 'houzez_agent',
                'posts_per_page'    => -1,
                'orderby' => 'title',
                'order' => 'ASC',
                'post_status' => 'publish',
                'meta_query'        => array(
                    array(
                        'key'       =>  'fave_agent_agencies',
                        'value'     => $agency_id,
                        'compare'   => 'LIKE',
                    ),
                ),
            );

            $qry = new WP_Query( $args );
            if( $qry->have_posts() ):
                while( $qry->have_posts() ):
                    $qry->the_post();

                        $agent_ids_array[] = get_the_ID();
                endwhile;
            endif;
            Houzez_Query::loop_reset();

            return $agent_ids_array;
        }

        /**
         * Gets agency agents ids
         *
         * @access public
         * @param null|int $post_id
         * @return array
         */
        public static function get_agency_agents_ids( $agency_id = null ) {
            if ( null == $agency_id ) {
                $agency_id = get_the_ID();
            }

            $agent_ids_array = array();
            $args = array(
                'post_type'         => 'houzez_agent',
                'posts_per_page'    => -1,
                'post_status' => 'publish',
                'meta_query'        => array(
                    array(
                        'key'       => 'fave_agent_agencies',
                        'value'     => $agency_id,
                        'compare'   => '=',
                    ),
                ),
            );

            $agency_agents = new WP_Query( $args );

            if( $agency_agents->have_posts() ):
                while( $agency_agents->have_posts() ):
                    $agency_agents->the_post();

                        $agent_ids_array[] = get_the_ID();
                endwhile;
            endif;
            Houzez_Query::loop_reset();

            return $agent_ids_array;
        }

        /**
         * Gets agency agents
         *
         * @access public
         * @param null|int $post_id
         * @return WP_Query
         */
        public static function get_agency_agents( $agency_id = null ) {
            if ( null == $agency_id ) {
                $agency_id = get_the_ID();
            }

            $args = array(
                'post_type'         => 'houzez_agent',
                'posts_per_page'    => -1,
                'post_status' => 'publish',
                'meta_query'        => array(
                    array(
                        'key'       => 'fave_agent_agencies',
                        'value'     => $agency_id,
                        'compare'   => '=',
                    ),
                ),
            );

            return new WP_Query( $args );
        }

        /**
         * Gets all agents
         *
         * @access public
         * @param int $count
         * @return WP_Query
         */
        public static function get_agents( $count = -1) {
            $args = array(
                'post_type'         => 'agent',
                'posts_per_page'    => $count,
                'post_status' => 'publish'
            );

            return new WP_Query( $args );
        }

        /**
         * Sets agency agents properties into loop
         *
         * @access public
         * @param null|int $agent_ids
         * @return WP_Query
         */
        public static function loop_get_agency_agents_properties( $agent_ids = null ) {
            if ( null == $agent_ids ) {
                return;
            }

            $args = array(
                'post_type'         => 'property',
                'posts_per_page'    => -1,
                'post_status' => 'publish',
                'meta_query'        => array(
                    array(
                        'key'       =>  'fave_agents',
                        'value'     => $agent_ids,
                        'compare'   => 'IN',
                    ),
                ),
            );

            return new WP_Query( $args );
        }

        /**
         * Sets agency agents properties into loop
         *
         * @access public
         * @param null|int $agent_ids
         * @return WP_Query
         */
        public static function loop_get_agent_properties_ids( $agent_ids = null ) {
            
            $properties_ids_array = array();
            
            if ( null == $agent_ids ) {
                return $properties_ids_array;
            }

            $args = array(
                'post_type'         => 'property',
                'posts_per_page'    => -1,
                'post_status' => 'publish',
                'meta_query'        => array(
                    array(
                        'key'       =>  'fave_agents',
                        'value'     => $agent_ids,
                        'compare'   => 'IN',
                    ),
                ),
            );

            $qry = new WP_Query( $args );

            if( $qry->have_posts() ):
                while( $qry->have_posts() ):
                    $qry->the_post();

                        $properties_ids_array[] = get_the_ID();
                endwhile;
            endif;
            Houzez_Query::loop_reset();

            return $properties_ids_array;
        }

        /**
         * Sets author properties into loop
         *
         * @access public
         * @param null|int $author is
         * @return WP_Query
         */
        public static function loop_get_author_properties_ids( $author_id = null ) {
            
            $properties_ids_array = array();
            
            if ( null == $author_id ) {
                return $properties_ids_array;
            }

            $args = array(
                'post_type'         => 'property',
                'posts_per_page'    => -1,
                'post_status' => 'publish',
                'author' => $author_id,
            );

            $qry = new WP_Query( $args );

            if( $qry->have_posts() ):
                while( $qry->have_posts() ):
                    $qry->the_post();

                        $properties_ids_array[] = get_the_ID();
                endwhile;
            endif;
            Houzez_Query::loop_reset();

            return $properties_ids_array;
        }

        /**
         * Sets agency properties into loop
         *
         * @access public
         * @param null|int $post_id
         * @return void
         */
        public static function loop_agency_properties( $agency_id = null ) {
            if ( null == $agency_id ) {
                $agency_id = get_the_ID();
            }

            global $paged;
            if ( is_front_page()  ) {
                $paged = (get_query_var('page')) ? get_query_var('page') : 1;
            }

            $tax_query = array();

            if ( isset( $_GET['tab'] ) && !empty($_GET['tab']) && $_GET['tab'] != "reviews") {
                $tax_query[] = array(
                    'taxonomy' => 'property_status',
                    'field' => 'slug',
                    'terms' => $_GET['tab']
                );
            }

            $args = array(
                'post_type' => 'property',
                'posts_per_page' => houzez_option('num_of_agency_listings', 9),
                'paged' => $paged,
                'post_status' => 'publish',
                'meta_query' => array(
                    'relation' => 'AND',
                    array(
                        'key' => 'fave_property_agency',
                        'value' => $agency_id,
                        'compare' => '='
                    ),
                    array(
                        'key' => 'fave_agent_display_option',
                        'value' => 'agency_info',
                        'compare' => '='
                    ),
                )
            );

            $count = count($tax_query);
            if($count > 0 ) {
                $args['tax_query'] = $tax_query;
            }

            $args = houzez_prop_sort($args);

            $agency_qry = new WP_Query( $args );
            return $agency_qry;
        }

        /**
         * Sets agency properties into loop
         *
         * @access public
         * @param null|int $post_id
         * @return IDs
         */
        public static function loop_agency_properties_ids( $agency_id = null ) {
            if ( null == $agency_id ) {
                $agency_id = get_the_ID();
            }

            global $paged;
            if ( is_front_page()  ) {
                $paged = (get_query_var('page')) ? get_query_var('page') : 1;
            }

            $properties_ids_array = array();

            $agency_listing_args = array(
                'post_type' => 'property',
                'posts_per_page' => -1,
                'post_status' => 'publish',
                'meta_query' => array(
                    'relation' => 'AND',
                    array(
                        'key' => 'fave_property_agency',
                        'value' => $agency_id,
                        'compare' => '='
                    ),
                    array(
                        'key' => 'fave_agent_display_option',
                        'value' => 'agency_info',
                        'compare' => '='
                    ),
                )
            );

            $qry = new WP_Query( $agency_listing_args );

            if( $qry->have_posts() ):
                while( $qry->have_posts() ):
                    $qry->the_post();

                        $properties_ids_array[] = get_the_ID();
                endwhile;
            endif;
            Houzez_Query::loop_reset();

            return $properties_ids_array;
        }


        /**
         * Sets properties by ids loop
         *
         * @access public
         * @param null|int $post_id
         * @return void
         */
        public static function loop_properties_by_ids($ids) {
            
            global $paged;
            if ( is_front_page()  ) {
                $paged = (get_query_var('page')) ? get_query_var('page') : 1;
            }

            $tax_query = array();

            if ( isset( $_GET['tab'] ) && !empty($_GET['tab']) && $_GET['tab'] != "reviews") {
                $tax_query[] = array(
                    'taxonomy' => 'property_status',
                    'field' => 'slug',
                    'terms' => $_GET['tab']
                );
            }

            $args = array(
                'post_type' => 'property',
                'posts_per_page' => houzez_option('num_of_agency_listings', 9),
                'paged' => $paged,
                'post__in' => $ids,
                'post_status' => 'publish'
            );

            $count = count($tax_query);
            if($count > 0 ) {
                $args['tax_query'] = $tax_query;
            }

            $args = houzez_prop_sort($args);

            $agency_qry = new WP_Query( $args );
            return $agency_qry;
        }

        /**
         * Sets properties count by ids loop
         *
         * @access public
         * @param null|int $post_id
         * @return void
         */
        public static function loop_properties_by_ids_for_count($ids) {
            
            $args = array(
                'post_type' => 'property',
                'posts_per_page' => -1,
                'fields' => 'ids',
                'post__in' => $ids,
                'post_status' => 'publish'
            );


            $posts = get_posts($args);
            return count($posts);
        }


        /**
         * Sets agency properties count into loop
         *
         * @access public
         * @param null|int $post_id
         * @return void
         */
        public static function loop_agency_properties_count( $agency_id = null ) {
            if ( null == $agency_id ) {
                $agency_id = get_the_ID();
            }

           
            $args = array(
                'post_type' => 'property',
                'posts_per_page' => -1,
                'fields' => 'ids',
                'post_status' => 'publish',
                'meta_query' => array(
                    'relation' => 'AND',
                    array(
                        'key' => 'fave_property_agency',
                        'value' => $agency_id,
                        'compare' => '='
                    ),
                    array(
                        'key' => 'fave_agent_display_option',
                        'value' => 'agency_info',
                        'compare' => '='
                    ),
                )
            );

            $posts = get_posts($args);
            return count($posts);
        }

        /**
         * Sets agency properties count into loop
         *
         * @access public
         * @param null|int $post_id
         * @return void
         */
        public static function agency_properties_count( $agency_id = null ) {
            if ( null == $agency_id ) {
                $agency_id = get_the_ID();
            }

            $agency_listing_args = array(
                'post_type' => 'property',
                'posts_per_page' => -1,
                'post_status' => 'publish',
                'meta_query' => array(
                    array(
                        'key' => 'fave_property_agency',
                        'value' => $agency_id,
                        'compare' => '='
                    )
                )
            );

            $agency_qry = new WP_Query( $agency_listing_args );
            return $agency_qry->post_count;
        }

        /**
         * Sets agent properties count into loop
         *
         * @access public
         * @param null|int $post_id
         * @return void
         */
        public static function agent_properties_count( $agent_id = null ) {
            if ( null == $agent_id ) {
                $agent_id = get_the_ID();
            }

            $args = array(
                'post_type' => 'property',
                'posts_per_page' => -1,
                'post_status' => 'publish',
                'meta_query' => array(
                    array(
                        'key' => 'fave_agents',
                        'value' => $agent_id,
                        'compare' => '='
                    )
                )
            );

            $qry = new WP_Query( $args );
            return $qry->post_count;
        }

        /**
         * Sets agent properties count into loop
         *
         * @access public
         * @param null|int $post_id
         * @return void
         */
        public static function author_properties_count( $author_id = null ) {
            if ( null == $author_id ) {
                $author_id = get_the_ID();
            }

            $args = array(
                'post_type' => 'property',
                'posts_per_page' => -1,
                'post_status' => 'publish',
                'author' => $author_id
            );

            $qry = new WP_Query( $args );
            return $qry->post_count;
        }

        /**
         * Sets agent properties into loop
         *
         * @access public
         * @param null|int $post_id
         * @return void
         */
        public static function loop_agent_properties( $agent_id = null ) {
            global $paged;

            if ( is_front_page()  ) {
                $paged = (get_query_var('page')) ? get_query_var('page') : 1;
            }

            if ( null == $agent_id ) {
                $agent_id = get_the_ID();
            }

            $tax_query = array();

            if ( isset( $_GET['tab'] ) && !empty($_GET['tab']) && $_GET['tab'] != "reviews") {
                $tax_query[] = array(
                    'taxonomy' => 'property_status',
                    'field' => 'slug',
                    'terms' => $_GET['tab']
                );
            }

            $args = array(
                'post_type' => 'property',
                'posts_per_page' => houzez_option('num_of_agent_listings', 10),
                'post_status' => 'publish',
                'paged' => $paged,
                'meta_query' => array(
                    array(
                        'key' => 'fave_agents',
                        'value' => $agent_id,
                        'compare' => '='
                    )
                )
            );

            $count = count($tax_query);
            if($count > 0 ) {
                $args['tax_query'] = $tax_query;
            }

            $args = houzez_prop_sort($args);

            $the_query = new WP_Query( $args );
            return $the_query;
        }


        /**
         * Resets current query
         *
         * @access public
         * @return void
         */
        public static function loop_reset() {
            wp_reset_query();
        }

        /**
         * Resets current query postdata
         *
         * @access public
         * @return void
         */
        public static function loop_reset_postdata() {
            wp_reset_postdata();
        }

        /**
         * Checks if there is another post in query
         *
         * @access public
         * @return bool
         */
        public static function loop_has_next() {
            global $wp_query;

            if ( $wp_query->current_post + 1 < $wp_query->post_count ) {
                return true;
            }

            return false;
        }
    }
}