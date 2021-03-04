<?php
if ( ! class_exists( 'Houzez_Deals' ) ) {

	class Houzez_Deals {

		public function __construct() {
			add_action( 'wp_ajax_houzez_crm_add_deal', array( $this, 'add_new_deal' ) );
			add_action( 'wp_ajax_crm_set_deal_status', array( $this, 'update_status' ) );
			add_action( 'wp_ajax_crm_set_deal_next_action', array( $this, 'update_next_action' ) );
			add_action( 'wp_ajax_crm_set_action_due', array( $this, 'set_action_due_date' ) );
			add_action( 'wp_ajax_crm_set_last_contact_date', array( $this, 'set_last_contact_date' ) );
			add_action( 'wp_ajax_get_single_deal', array( $this, 'get_single_deal' ) );
			add_action( 'wp_ajax_houzez_delete_deal', array( $this, 'delete_deal' ) );
		}

		public function delete_deal() {
			global $wpdb;
            $table_name = $wpdb->prefix . 'houzez_crm_deals';

			$nonce = $_REQUEST['security'];
	        if ( ! wp_verify_nonce( $nonce, 'delete_deal_nonce' ) ) {
	            $ajax_response = array( 'success' => false , 'reason' => esc_html__( 'Security check failed!', 'houzez-crm' ) );
	            echo json_encode( $ajax_response );
	            die;
	        }

	        if ( !isset( $_REQUEST['deal_id'] ) ) {
	            $ajax_response = array( 'success' => false , 'reason' => esc_html__( 'No lead id found', 'houzez-crm' ) );
	            echo json_encode( $ajax_response );
	            die;
	        }
	        $deal_id = $_REQUEST['deal_id'];

	        $where = array(
            	'deal_id' => $deal_id
            );

            $where_format = array(
            	'%d'
            );

	        
	        $wpdb->query( 
				$wpdb->prepare( 
					"DELETE FROM {$table_name}
					 WHERE deal_id = %d
					",
				        $deal_id
			        )
			);
	        $ajax_response = array( 'success' => true , 'reason' => '' );
            echo json_encode( $ajax_response );
            die;
		}

		public function get_single_deal() {
			global $wpdb;
            $table_name = $wpdb->prefix . 'houzez_crm_deals';
            
            $deal_id = '';
			if ( isset( $_POST['deal_id'] ) ) {
				$deal_id = intval( $_POST['deal_id'] );
			}

			if(empty($deal_id)) {
				echo json_encode( 
					array( 
						'success' => false, 
						'msg' => esc_html__('Something went wrong!', 'houzez-crm') 
					) 
				);
	            wp_die();
			}

            $sql = "SELECT * FROM {$table_name} WHERE deal_id = {$deal_id}";

            $result = $wpdb->get_row( $sql, OBJECT );

            if( is_object( $result ) && ! empty( $result ) ) {
            	echo json_encode( 
					array( 
						'success' => true, 
						'data' => $result 
					) 
				);
	            wp_die();
            }
            return '';
		}

		public function set_action_due_date() {
			global $wpdb;
			$deal_id = intval($_POST['deal_id']);
			$deal_date = sanitize_text_field($_POST['deal_data']);
			//$deal_date = date('Y-m-d H:i:s', strtotime($deal_date));

			if(empty($deal_id)) {
				return; 
			}

			$data_table        = $wpdb->prefix . 'houzez_crm_deals';
	        $data = array(
                'action_due_date' => $deal_date
            );

            $format = array(
                '%s'
            );

            $where = array(
            	'deal_id' => $deal_id
            );

            $where_format = array(
            	'%d'
            );

            $updated = $wpdb->update( $data_table, $data, $where, $format, $where_format );

            if ( false === $updated ) {
			    echo json_encode(array(
	                'success' => false,
	                'msg' => esc_html__('Not updated, there is error', 'houzez-crm')
	            ));
	            wp_die();
			} else {
			    echo json_encode(array(
	                'success' => true,
	                'msg' => esc_html__('Successfully updated', 'houzez-crm')
	            ));
	            wp_die();
			}

		}

		public function set_last_contact_date() {
			global $wpdb;
			$deal_id = intval($_POST['deal_id']);
			$deal_date = sanitize_text_field($_POST['deal_data']);
			//$deal_date = date('Y-m-d H:i:s', strtotime($deal_date));

			if(empty($deal_id)) {
				return; 
			}

			$data_table        = $wpdb->prefix . 'houzez_crm_deals';
	        $data = array(
                'last_contact_date' => $deal_date
            );

            $format = array(
                '%s'
            );

            $where = array(
            	'deal_id' => $deal_id
            );

            $where_format = array(
            	'%d'
            );

            $updated = $wpdb->update( $data_table, $data, $where, $format, $where_format );

            if ( false === $updated ) {
			    echo json_encode(array(
	                'success' => false,
	                'msg' => esc_html__('Not updated, there is error', 'houzez-crm')
	            ));
	            wp_die();
			} else {
			    echo json_encode(array(
	                'success' => true,
	                'msg' => esc_html__('Successfully updated', 'houzez-crm')
	            ));
	            wp_die();
			}

		}

		public function update_status() {
			global $wpdb;

			$deal_id = intval($_POST['deal_id']);
			$deal_status = sanitize_text_field($_POST['deal_data']);

			if(empty($deal_id)) {
				return; 
			}

			$data_table        = $wpdb->prefix . 'houzez_crm_deals';
	        $data = array(
                'status'        => $deal_status
            );

            $format = array(
                '%s'
            );

            $where = array(
            	'deal_id' => $deal_id
            );

            $where_format = array(
            	'%d'
            );

            $updated = $wpdb->update( $data_table, $data, $where, $format, $where_format );

            if ( false === $updated ) {
			    echo json_encode(array(
	                'success' => false,
	                'msg' => esc_html__('Not updated, there is error', 'houzez-crm')
	            ));
	            wp_die();
			} else {
			    echo json_encode(array(
	                'success' => true,
	                'msg' => esc_html__('Successfully updated', 'houzez-crm')
	            ));
	            wp_die();
			}
		}

		public function update_next_action() {
			global $wpdb;

			$deal_id = intval($_POST['deal_id']);
			$deal_action = sanitize_text_field($_POST['deal_data']);

			if(empty($deal_id)) {
				return; 
			}

			$data_table        = $wpdb->prefix . 'houzez_crm_deals';
	        $data = array(
                'next_action'        => $deal_action
            );

            $format = array(
                '%s'
            );

            $where = array(
            	'deal_id' => $deal_id
            );

            $where_format = array(
            	'%d'
            );

            $updated = $wpdb->update( $data_table, $data, $where, $format, $where_format );

            if ( false === $updated ) {
			    echo json_encode(array(
	                'success' => false,
	                'msg' => esc_html__('Not updated, there is error', 'houzez-crm')
	            ));
	            wp_die();
			} else {
			    echo json_encode(array(
	                'success' => true,
	                'msg' => esc_html__('Successfully updated', 'houzez-crm')
	            ));
	            wp_die();
			}
		}
		
		public function add_new_deal() {
			global $wpdb;

			$deal_group = sanitize_text_field( $_POST['deal_group'] );
			$deal_title = sanitize_text_field( $_POST['deal_title'] );
			$deal_contact = sanitize_text_field( $_POST['deal_contact'] );
			$deal_value = sanitize_text_field( $_POST['deal_value'] );

			if ( empty($deal_title) ) {
				echo json_encode(array(
	                'success' => false,
	                'msg' => esc_html__('Title is empty', 'houzez-crm')
	            ));
	            wp_die();
			}

			if ( empty($deal_contact) ) {
				echo json_encode(array(
	                'success' => false,
	                'msg' => esc_html__('Select contact name', 'houzez-crm')
	            ));
	            wp_die();
			}

			if ( empty($deal_value) ) {
				echo json_encode(array(
	                'success' => false,
	                'msg' => esc_html__('Enter deal value', 'houzez-crm')
	            ));
	            wp_die();
			}


			if(isset($_POST['deal_id']) && !empty($_POST['deal_id'])) {
	        	$deal_id = $this->update_deal($_POST['deal_id']);

				echo json_encode( array(
	                'success' => true,
	                'msg' => esc_html__("Deal Successfully updated!", 'houzez-crm')
	            ));
	            wp_die();

	        } else {

	        	$save_deal = $this->save_deal();

	        	if($save_deal) {
	 				echo json_encode( array(
		                'success' => true,
		                'msg' => esc_html__("Deal Successfully added!", 'houzez-crm')
		            ));
	 			} else {
	 				echo json_encode( array(
		                'success' => false,
		                'msg' => esc_html__("Deal not added!", 'houzez-crm')
		            ));
	 			}
	        }
            wp_die();

			

		}

		public function save_deal() {

			global $wpdb;

			$deal_group = sanitize_text_field( $_POST['deal_group'] );
			$deal_title = sanitize_text_field( $_POST['deal_title'] );
			$deal_contact = sanitize_text_field( $_POST['deal_contact'] );
			$deal_value = sanitize_text_field( $_POST['deal_value'] );

			$listing_id = 0;
			if ( isset( $_POST['listing_id'] ) ) {
				$listing_id = sanitize_text_field( $_POST['listing_id'] );
			}

			$deal_agent = '';
			if ( isset( $_POST['deal_agent'] ) ) {
				$deal_agent = sanitize_text_field( $_POST['deal_agent'] );
			}

			$status = $next_action = $action_due_date = $last_contact_date = $private_note = $agent_type = '';
            $table_name = $wpdb->prefix . 'houzez_crm_deals';

	        $data = array(
                'user_id'           => get_current_user_id(),
                'deal_group'        => $deal_group,
                'title'        		=> $deal_title,
                'listing_id'        => $listing_id,
                'lead_id'        	=> $deal_contact,
                'agent_id'        	=> $deal_agent,
                'agent_type'        => $agent_type,
                'status'        	=> $status,
                'next_action'       => $next_action,
                'action_due_date'   => $action_due_date,
                'deal_value'        => $deal_value,
                'last_contact_date' => $last_contact_date,
                'private_note'      => $private_note,
                'time'          	=> gmdate('Y-m-d H:i:s'),
            );

            $format = array(
                '%d',
                '%s',
                '%s',
                '%d',
                '%d',
                '%d',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                
            );

            $inserted = $wpdb->insert($table_name, $data, $format);
            
            if($inserted) {
            	return true;
	            
            } else {
            	return false;
            }
		}

		public function update_deal($deal_id) {

			global $wpdb;

			$deal_group = sanitize_text_field( $_POST['deal_group'] );
			$deal_title = sanitize_text_field( $_POST['deal_title'] );
			$deal_contact = sanitize_text_field( $_POST['deal_contact'] );
			$deal_value = sanitize_text_field( $_POST['deal_value'] );

			$listing_id = 0;
			if ( isset( $_POST['listing_id'] ) ) {
				$listing_id = sanitize_text_field( $_POST['listing_id'] );
			}

			$deal_agent = '';
			if ( isset( $_POST['deal_agent'] ) ) {
				$deal_agent = sanitize_text_field( $_POST['deal_agent'] );
			}

			$status = $next_action = $action_due_date = $last_contact_date = $private_note = $agent_type = '';
            $table_name = $wpdb->prefix . 'houzez_crm_deals';

	        $data = array(
                'deal_group'        => $deal_group,
                'title'        		=> $deal_title,
                'listing_id'        => $listing_id,
                'lead_id'        	=> $deal_contact,
                'agent_id'        	=> $deal_agent,
                'agent_type'        => $agent_type,
                'status'        	=> $status,
                'next_action'       => $next_action,
                'action_due_date'   => $action_due_date,
                'deal_value'        => $deal_value,
                'last_contact_date' => $last_contact_date,
                'private_note'      => $private_note,
                'time'          	=> gmdate('Y-m-d H:i:s'),
            );

            $format = array(
                '%s',
                '%s',
                '%d',
                '%d',
                '%d',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                
            );

            $where = array(
            	'deal_id' => $deal_id
            );

            $where_format = array(
            	'%d'
            );

            $updated = $wpdb->update( $table_name, $data, $where, $format, $where_format );

            if ( false === $updated ) {
			    return false;
			} else {
			    return true;
			}
		}

		public static function get_deals() {
			global $wpdb;
            $table_name = $wpdb->prefix . 'houzez_crm_deals';

            $deal_group = isset($_GET['tab']) ? $_GET['tab'] : 'active';
            
            $items_per_page = isset($_GET['records']) ? $_GET['records'] : 10;
			$page = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
			$offset = ( $page * $items_per_page ) - $items_per_page;
			$query = 'SELECT * FROM '.$table_name.' WHERE user_id= '.get_current_user_id().' AND deal_group = '."'$deal_group'";

			$total_query = "SELECT COUNT(1) FROM (${query}) AS combined_table";
			$total = $wpdb->get_var( $total_query );
			$results = $wpdb->get_results( $query.' ORDER BY deal_id DESC LIMIT '. $offset.', '. $items_per_page, OBJECT );

			$return_array['data'] = array(
				'results' => $results,
				'total_records' => $total,
				'items_per_page' => $items_per_page,
				'page' => $page,
			);

			return $return_array;
		}

		public static function get_total_deals_by_group($group) {
			global $wpdb;
            $table_name = $wpdb->prefix . 'houzez_crm_deals';

            $deal_group = $group;
            
			$total_query = 'SELECT COUNT(*) FROM '.$table_name.' WHERE user_id= '.get_current_user_id().' AND deal_group = '."'$deal_group'";
			$total = $wpdb->get_var( $total_query );
			
			$total_records = $total;
			return $total_records;
		}


	}
	new Houzez_Deals();
}