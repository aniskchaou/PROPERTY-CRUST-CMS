<?php
if ( ! class_exists( 'Houzez_Activities' ) ) {

	class Houzez_Activities {

		public function __construct() {

			add_action( 'houzez_record_activities', array( $this, 'save_activity' ), 10, 1 );
		}

		public function save_activity($activity_meta) {
			
			global $wpdb;
            $table_name = $wpdb->prefix . 'houzez_crm_activities';

            $listing_id = '';
			if ( isset( $_POST['listing_id'] ) ) {
				$listing_id = intval( $_POST['listing_id'] );
			}

			if(!empty($listing_id)) {
				$user_id = get_post_field( 'post_author', $listing_id );
			}

			if(isset($_POST['realtor_page']) && $_POST['realtor_page'] == 'yes') {
				$agent_id = '';
				if ( isset( $_POST['agent_id'] ) ) {
					$agent_id = sanitize_text_field( $_POST['agent_id'] );
				}

				$agent_type = '';
				if ( isset( $_POST['agent_type'] ) ) {
					$agent_type = sanitize_text_field( $_POST['agent_type'] );
				}

				if($agent_type == 'author_info') {
					$user_id = $agent_id;
				} else {
					$user_id = get_post_meta( $agent_id, 'houzez_user_meta_id', true );
				}

				$activity_meta['agent_id'] = $agent_id;
				$activity_meta['agent_type'] = $agent_type;
				
			}

			if(isset($_POST['review_post_type']) && $_POST['review_post_type'] != '') {
				$review_post_type = $_POST['review_post_type'];

				if( $review_post_type == 'houzez_author') {
					$user_id = intval( $_POST['listing_id'] );
				} else {
					$user_id = $user_id;
				}
			}

			/*if(empty($user_id)) {
				$user_id = get_current_user_id();
			}*/

			if( (isset($_POST['houzez_contact_form']) && $_POST['houzez_contact_form'] == 'yes') || (isset($_POST['is_estimation']) && $_POST['is_estimation'] == 'yes') || empty($user_id) ) {

				$adminData = get_user_by( 'email', get_option( 'admin_email' ) );
				$user_id = $adminData->ID;
			}

			$activity_meta['listing_id'] = $listing_id;
			$activity_meta = maybe_serialize($activity_meta);
			
			$data = array(
	        	'user_id'       => $user_id,
	        	'meta'    		=> $activity_meta,
	        	'time'    		=> current_time( 'mysql' )
                
            );

            $format = array(
                '%d',
                '%s',           
                '%s'           
            );

            $wpdb->insert($table_name, $data, $format);
            $inserted_id = $wpdb->insert_id;
            return $inserted_id;
			
		}

		public static function get_activities() {
			global $wpdb;
            $table_name = $wpdb->prefix . 'houzez_crm_activities';
            
            $items_per_page = isset($_GET['records']) ? $_GET['records'] : 15;
			$page = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
			$offset = ( $page * $items_per_page ) - $items_per_page;
			//$query = 'SELECT * FROM '.$table_name;
			$query = 'SELECT * FROM '.$table_name.' WHERE user_id= '.get_current_user_id();
			$total_query = "SELECT COUNT(1) FROM (${query}) AS combined_table";
			$total = $wpdb->get_var( $total_query );
			$results = $wpdb->get_results( $query.' ORDER BY activity_id DESC LIMIT '. $offset.', '. $items_per_page, OBJECT );

			$return_array['data'] = array(
				'results' => $results,
				'total_records' => $total,
				'items_per_page' => $items_per_page,
				'page' => $page,
			);

			return $return_array;
		}

		

	}
	new Houzez_Activities();
}