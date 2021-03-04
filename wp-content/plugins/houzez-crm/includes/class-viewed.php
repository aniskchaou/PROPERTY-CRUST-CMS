<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
if(!class_exists('Houzez_Viewed_Listings')) {

    class Houzez_Viewed_Listings {

        public function __construct() {
           
            // Count listing visits.
            add_action( 'template_redirect', array($this, 'add_views') );
            add_action( 'wp_ajax_houzez_delete_viewed_listings', array( $this, 'delete_viewed_listings') );
            

        }

        public function delete_viewed_listings() {
            global $wpdb;
            $table_name = $wpdb->prefix . 'houzez_crm_viewed_listings';

            if ( !isset( $_REQUEST['ids'] ) ) {
                $ajax_response = array( 'success' => false , 'reason' => esc_html__( 'No listing selected', 'houzez-crm' ) );
                echo json_encode( $ajax_response );
                die;
            }
            $ids = $_REQUEST['ids'];
            
            $wpdb->query("DELETE FROM {$table_name} WHERE id IN ($ids)");
            $ajax_response = array( 'success' => true , 'reason' => '' );
            echo json_encode( $ajax_response );
            die;
        }

        //Add visits data
        public function add_views() { 
            global $wpdb, $post;

            $post_id = isset($post->ID) ? $post->ID : '';

            if(empty($post_id)) {
                return;
            }

            $user_id = get_current_user_id();
            $already_exist = $this->checklisting($post->ID, $user_id);


            if ( ! is_singular( 'property' ) || empty($user_id) || $already_exist ) {
                return;
            }

            $table_name        = $wpdb->prefix . 'houzez_crm_viewed_listings';

            $data = array(
                'user_id'        => $user_id,
                'listing_id'     => $post->ID,
                
            );

            $format = array(
                '%d',
                '%d'
            );

            $wpdb->insert($table_name, $data, $format);
        }

        public function checklisting($listing_id, $user_id) {
            global $wpdb;
            $table_name = $wpdb->prefix . 'houzez_crm_viewed_listings';
            

            $sql = "SELECT * FROM {$table_name} WHERE listing_id = {$listing_id} AND user_id = {$user_id}";

            $result = $wpdb->get_row( $sql, OBJECT );
            
            if( is_object( $result ) && ! empty( $result ) ) {
                return true;
            }
            return false;
        }


    } // end class

    new Houzez_Viewed_Listings();
} // End !exist