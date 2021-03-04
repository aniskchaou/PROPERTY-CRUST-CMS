<?php
if ( ! class_exists( 'Houzez_Leads' ) ) {

	class Houzez_Leads {

		
		public function __construct() {
			add_action( 'wp_ajax_houzez_crm_add_lead', array( $this, 'add_lead' ) );
			add_action( 'wp_ajax_get_single_lead', array( $this, 'get_single_lead' ) );
			add_action( 'wp_ajax_houzez_delete_lead', array( $this, 'delete_lead') );
		}

		public function add_lead() {

			$lead_id = $this->lead_exist();
			$email = sanitize_email( $_POST['email'] );
			$prefix = sanitize_text_field( $_POST['prefix'] );
			$first_name = sanitize_text_field( $_POST['first_name'] );
			$name = sanitize_text_field( $_POST['name'] );

			if(empty($prefix)) {
				echo json_encode( array( 'success' => false, 'msg' => esc_html__('Please select title!', 'houzez-crm') ) );
	            wp_die();
			}

			if(empty($name)) {
				echo json_encode( array( 'success' => false, 'msg' => esc_html__('Please enter your full name!', 'houzez-crm') ) );
	            wp_die();
			}

			if( !is_email( $email ) ) {
	            echo json_encode( array( 'success' => false, 'msg' => esc_html__('Invalid email address.', 'houzez-crm') ) );
	            wp_die();
	        }

	        if(isset($_POST['lead_id']) && !empty($_POST['lead_id'])) {
	        	$lead_id = intval($_POST['lead_id']);
	        	$lead_id = $this->update_lead($lead_id);

				echo json_encode( array(
	                'success' => true,
	                'msg' => esc_html__("Lead Successfully updated!", 'houzez-crm')
	            ));
	            wp_die();

	        } else {

	        	//if( empty($lead_id) ) {
					$lead_id = $this->save_lead();

					echo json_encode( array(
		                'success' => true,
		                'msg' => esc_html__("Lead Successfully added!", 'houzez-crm')
		            ));

				/*} else {
					echo json_encode( array(
		                'success' => false,
		                'msg' => esc_html__("Email already exist, try different email address", 'houzez-crm')
		            ));
				}*/
	        }
            wp_die();
		}

		public function lead_exist() {
			global $wpdb;
            $table_name = $wpdb->prefix . 'houzez_crm_leads';
            
            $email = '';
			if ( isset( $_POST['email'] ) ) {
				$email = sanitize_email( $_POST['email'] );
			}

			if(empty($email)) {
				return false;
			}

            $sql = "SELECT * FROM {$table_name} WHERE email = '{$email}'";

            $result = $wpdb->get_row( $sql, OBJECT );

            if( is_object( $result ) && ! empty( $result ) ) {
            	return $result->lead_id;
            }
            return '';
		}

		public function get_single_lead() {
			global $wpdb;
            $table_name = $wpdb->prefix . 'houzez_crm_leads';
            
            $lead_id = '';
			if ( isset( $_POST['lead_id'] ) ) {
				$lead_id = intval( $_POST['lead_id'] );
			}

			if(empty($lead_id)) {
				echo json_encode( 
					array( 
						'success' => false, 
						'msg' => esc_html__('Something went wrong!', 'houzez-crm') 
					) 
				);
	            wp_die();
			}

            $sql = "SELECT * FROM {$table_name} WHERE lead_id = {$lead_id}";

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

		public function save_lead() {

			global $wpdb;
			$user_id = $message = '';

			$lead_title = '';
			if ( isset( $_POST['name'] ) ) {
				$lead_title = sanitize_text_field( $_POST['name'] );
			}

			$first_name = '';
			if ( isset( $_POST['first_name'] ) ) {
				$first_name = sanitize_text_field( $_POST['first_name'] );
			}

			$prefix = '';
			if ( isset( $_POST['prefix'] ) ) {
				$prefix = sanitize_text_field( $_POST['prefix'] );
			}

			$last_name = '';
			if ( isset( $_POST['last_name'] ) ) {
				$last_name = sanitize_text_field( $_POST['last_name'] );
			}

			if(empty($lead_title)) {
				$lead_title = $first_name.' '.$last_name;
			}

			$mobile = '';
			if ( isset( $_POST['mobile'] ) ) {
				$mobile = sanitize_text_field( $_POST['mobile'] );
			}

			if( isset($_POST['is_schedule_form']) && $_POST['is_schedule_form'] == 'yes') {
				$mobile = sanitize_text_field( $_POST['phone'] );
			}

			$home_phone = '';
			if ( isset( $_POST['home_phone'] ) ) {
				$home_phone = sanitize_text_field( $_POST['home_phone'] );
			}


			$work_phone = '';
			if ( isset( $_POST['work_phone'] ) ) {
				$work_phone = sanitize_text_field( $_POST['work_phone'] );
			}

			$user_type = '';
			if ( isset( $_POST['user_type'] ) ) {
				$user_type = sanitize_text_field( $_POST['user_type'] );
				$user_type = houzez_crm_get_form_user_type($user_type);
			}

			$email = '';
			if ( isset( $_POST['email'] ) ) {
				$email = sanitize_email( $_POST['email'] );
			}

			$address = '';
			if ( isset( $_POST['address'] ) ) {
				$address = sanitize_text_field( $_POST['address'] );
			}

			$country = '';
			if ( isset( $_POST['country'] ) ) {
				$country = sanitize_text_field( $_POST['country'] );
			}

			$city = '';
			if ( isset( $_POST['city'] ) ) {
				$city = sanitize_text_field( $_POST['city'] );
			}

			$state = '';
			if ( isset( $_POST['state'] ) ) {
				$state = sanitize_text_field( $_POST['state'] );
			}

			$zip = '';
			if ( isset( $_POST['zip'] ) ) {
				$zip = sanitize_text_field( $_POST['zip'] );
			}

			$source = '';
			if ( isset( $_POST['source'] ) ) {
				$source = sanitize_text_field( $_POST['source'] );
			}

			$source_link = '';
			if ( isset( $_POST['source_link'] ) ) {
				$source_link = esc_url( $_POST['source_link'] );
			}

			if( isset($_POST['property_permalink']) ) {
				$source_link = esc_url($_POST['property_permalink']);
			}

			$agent_id = '';
			if ( isset( $_POST['agent_id'] ) ) {
				$agent_id = sanitize_text_field( $_POST['agent_id'] );
			}

			$agent_type = '';
			if ( isset( $_POST['agent_type'] ) ) {
				$agent_type = sanitize_text_field( $_POST['agent_type'] );
			}

			$facebook = '';
			if ( isset( $_POST['facebook'] ) ) {
				$facebook = sanitize_text_field( $_POST['facebook'] );
			}

			$twitter = '';
			if ( isset( $_POST['twitter'] ) ) {
				$twitter = sanitize_text_field( $_POST['twitter'] );
			}

			$linkedin = '';
			if ( isset( $_POST['linkedin'] ) ) {
				$linkedin = sanitize_text_field( $_POST['linkedin'] );
			}

			$private_note = '';
			if ( isset( $_POST['private_note'] ) ) {
				$private_note = sanitize_textarea_field( $_POST['private_note'] );
			}

			$listing_id = '';
			if ( isset( $_POST['listing_id'] ) ) {
				$listing_id = intval( $_POST['listing_id'] );
			}

			if(!empty($listing_id)) {
				$user_id = get_post_field( 'post_author', $listing_id );
			}

			if(isset($_POST['realtor_page']) && $_POST['realtor_page'] == 'yes') {
				if($agent_type == 'author_info') {
					$user_id = $agent_id;
				} else {
					$user_id = get_post_meta( $agent_id, 'houzez_user_meta_id', true );
				}
			} 

			$message = isset( $_POST['message'] ) ? sanitize_textarea_field($_POST['message']) : '';

			if( (isset($_POST['houzez_contact_form']) && $_POST['houzez_contact_form'] == 'yes') || (isset($_POST['is_estimation']) && $_POST['is_estimation'] == 'yes') || empty($user_id) ) {

				$adminData = get_user_by( 'email', get_option( 'admin_email' ) );
				$user_id = $adminData->ID;
			}

			if( isset($_POST['dashboard_lead']) && $_POST['dashboard_lead'] == 'yes' ) {
				$user_id = get_current_user_id();
			}

            $leads_table        = $wpdb->prefix . 'houzez_crm_leads';
	        $data = array(
	        	'user_id'       => $user_id,
                'prefix'        => $prefix,
                'display_name'  => $lead_title,
                'first_name'    => $first_name,
                'last_name'     => $last_name,
                'email'         => $email,
                'mobile'        => $mobile,
                'home_phone'    => $home_phone,
                'work_phone'    => $work_phone,
                'address'       => $address,
                'city'          => $city,
                'state'         => $state,
                'country'       => $country,
                'zipcode'       => $zip,
                'type'          => $user_type,
                'status'        => '',
                'source'        => $source,
                'source_link'        => $source_link,
                'enquiry_to'        => $agent_id,
                'enquiry_user_type' => $agent_type,
                'twitter_url'   => $twitter,
                'linkedin_url'  => $linkedin,
                'facebook_url'  => $facebook,
                'private_note'  => $private_note,
                'message'  => $message
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
                '%s',
                '%s',
                '%s',
                '%s',
                '%d',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
            );

            $wpdb->insert($leads_table, $data, $format);
            $inserted_id = $wpdb->insert_id;
            return $inserted_id;

		}

		public function update_lead($lead_id) {

			global $wpdb;

			$lead_title = '';
			if ( isset( $_POST['name'] ) ) {
				$lead_title = sanitize_text_field( $_POST['name'] );
			}

			$first_name = '';
			if ( isset( $_POST['first_name'] ) ) {
				$first_name = sanitize_text_field( $_POST['first_name'] );
			}

			$prefix = '';
			if ( isset( $_POST['prefix'] ) ) {
				$prefix = sanitize_text_field( $_POST['prefix'] );
			}

			$last_name = '';
			if ( isset( $_POST['last_name'] ) ) {
				$last_name = sanitize_text_field( $_POST['last_name'] );
			}

			if(empty($lead_title)) {
				$lead_title = $first_name.' '.$last_name;
			}

			$mobile = '';
			if ( isset( $_POST['mobile'] ) ) {
				$mobile = sanitize_text_field( $_POST['mobile'] );
			}

			$home_phone = '';
			if ( isset( $_POST['home_phone'] ) ) {
				$home_phone = sanitize_text_field( $_POST['home_phone'] );
			}

			$work_phone = '';
			if ( isset( $_POST['work_phone'] ) ) {
				$work_phone = sanitize_text_field( $_POST['work_phone'] );
			}

			$user_type = '';
			if ( isset( $_POST['user_type'] ) ) {
				$user_type = sanitize_text_field( $_POST['user_type'] );
			}

			$email = '';
			if ( isset( $_POST['email'] ) ) {
				$email = sanitize_email( $_POST['email'] );
			}

			$address = '';
			if ( isset( $_POST['address'] ) ) {
				$address = sanitize_text_field( $_POST['address'] );
			}

			$country = '';
			if ( isset( $_POST['country'] ) ) {
				$country = sanitize_text_field( $_POST['country'] );
			}

			$city = '';
			if ( isset( $_POST['city'] ) ) {
				$city = sanitize_text_field( $_POST['city'] );
			}

			$state = '';
			if ( isset( $_POST['state'] ) ) {
				$state = sanitize_text_field( $_POST['state'] );
			}

			$zip = '';
			if ( isset( $_POST['zip'] ) ) {
				$zip = sanitize_text_field( $_POST['zip'] );
			}

			$source = '';
			if ( isset( $_POST['source'] ) ) {
				$source = sanitize_text_field( $_POST['source'] );
			}

			/*$source_link = '';
			if ( isset( $_POST['source_link'] ) ) {
				$source_link = esc_url( $_POST['source_link'] );
			}*/

			$agent_id = '';
			if ( isset( $_POST['agent_id'] ) ) {
				$agent_id = sanitize_text_field( $_POST['agent_id'] );
			}

			$agent_type = '';
			if ( isset( $_POST['agent_type'] ) ) {
				$agent_type = sanitize_text_field( $_POST['agent_type'] );
			}

			$facebook = '';
			if ( isset( $_POST['facebook'] ) ) {
				$facebook = sanitize_text_field( $_POST['facebook'] );
			}

			$twitter = '';
			if ( isset( $_POST['twitter'] ) ) {
				$twitter = sanitize_text_field( $_POST['twitter'] );
			}

			$linkedin = '';
			if ( isset( $_POST['linkedin'] ) ) {
				$linkedin = sanitize_text_field( $_POST['linkedin'] );
			}

			$private_note = '';
			if ( isset( $_POST['private_note'] ) ) {
				$private_note = sanitize_textarea_field( $_POST['private_note'] );
			}

            $leads_table        = $wpdb->prefix . 'houzez_crm_leads';
	        $data = array(
                'prefix'        => $prefix,
                'display_name'  => $lead_title,
                'first_name'    => $first_name,
                'last_name'     => $last_name,
                'email'         => $email,
                'mobile'        => $mobile,
                'home_phone'    => $home_phone,
                'work_phone'    => $work_phone,
                'address'       => $address,
                'city'          => $city,
                'state'         => $state,
                'country'       => $country,
                'zipcode'       => $zip,
                'type'          => $user_type,
                'status'        => '',
                'source'        => $source,
                'enquiry_to'        => $agent_id,
                'enquiry_user_type' => $agent_type,
                'twitter_url'   => $twitter,
                'linkedin_url'  => $linkedin,
                'facebook_url'  => $facebook,
                'private_note'  => $private_note
            );

            $format = array(
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
                '%s',
                '%s',
                '%s',
                '%d',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s'
            );

            $where = array(
            	'lead_id' => $lead_id
            );

            $where_format = array(
            	'%d'
            );

            $updated = $wpdb->update( $leads_table, $data, $where, $format, $where_format );

            if ( false === $updated ) {
			    return false;
			} else {
			    return true;
			}

		}

		public static function get_leads() {
			global $wpdb;
            $table_name = $wpdb->prefix . 'houzez_crm_leads';
            
            $items_per_page = isset($_GET['records']) ? $_GET['records'] : 10;
			$page = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
			$offset = ( $page * $items_per_page ) - $items_per_page;
			$query = 'SELECT * FROM '.$table_name.' WHERE user_id= '.get_current_user_id();
			$total_query = "SELECT COUNT(1) FROM (${query}) AS combined_table";
			$total = $wpdb->get_var( $total_query );
			$results = $wpdb->get_results( $query.' ORDER BY lead_id DESC LIMIT '. $offset.', '. $items_per_page, OBJECT );

			$return_array['data'] = array(
				'results' => $results,
				'total_records' => $total,
				'items_per_page' => $items_per_page,
				'page' => $page,
			);

			return $return_array;
		}


		public static function get_all_leads() {
			global $wpdb;
            $table_name = $wpdb->prefix . 'houzez_crm_leads';

            $sql = "SELECT * FROM $table_name WHERE user_id= ".get_current_user_id();
			$results = $wpdb->get_results( $sql , OBJECT );

			return $results;
		}

		public static function get_lead($lead_id) {
			global $wpdb;
            $table_name = $wpdb->prefix . 'houzez_crm_leads';

            $sql = "SELECT * FROM $table_name WHERE lead_id=".$lead_id;
			
			$result = $wpdb->get_row( $sql, OBJECT );

            if( is_object( $result ) && ! empty( $result ) ) {
            	return $result;
            }

			return '';
		}

		public static function get_lead_viewed_listings() {
			global $wpdb;

            $lead_id = isset($_GET['lead-id']) ? $_GET['lead-id'] : '';

            if(empty($lead_id)) {
                return '';
            }

            $lead = self::get_lead($lead_id);

            $email = $lead->email;


            if(empty($email)) {
            	return '';
            }

            $user = get_user_by( 'email', $email );

            if(empty($user)) {
            	return '';
            }

            $user_id = $user->ID;

            $table_name = $wpdb->prefix . 'houzez_crm_viewed_listings';

            $items_per_page = isset($_GET['records']) ? $_GET['records'] : 10;
			$page = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
			$offset = ( $page * $items_per_page ) - $items_per_page;
			$query = 'SELECT * FROM '.$table_name.' WHERE user_id ='.$user_id;
			$total_query = "SELECT COUNT(1) FROM (${query}) AS combined_table";
			$total = $wpdb->get_var( $total_query );
			$results = $wpdb->get_results( $query.' ORDER BY id DESC LIMIT '. $offset.', '. $items_per_page, OBJECT );

			$return_array['data'] = array(
				'results' => $results,
				'total_records' => $total,
				'items_per_page' => $items_per_page,
				'page' => $page,
			);

			return $return_array;
         
        }

        public static function get_lead_saved_searches() {
			global $wpdb;

            $lead_id = isset($_GET['lead-id']) ? $_GET['lead-id'] : '';

            if(empty($lead_id)) {
                return '';
            }

            $lead = self::get_lead($lead_id);

            $email = $lead->email;


            if(empty($email)) {
            	return '';
            }

            $user = get_user_by( 'email', $email );

            if(empty($user)) {
            	return '';
            }

            $user_id = $user->ID;

            $table_name = $wpdb->prefix . 'houzez_search';

            $items_per_page = isset($_GET['records']) ? $_GET['records'] : 10;
			$page = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
			$offset = ( $page * $items_per_page ) - $items_per_page;
			$query = 'SELECT * FROM '.$table_name.' WHERE auther_id ='.$user_id;
			$total_query = "SELECT COUNT(1) FROM (${query}) AS combined_table";
			$total = $wpdb->get_var( $total_query );
			$results = $wpdb->get_results( $query.' ORDER BY id DESC LIMIT '. $offset.', '. $items_per_page, OBJECT );

			$return_array['data'] = array(
				'results' => $results,
				'total_records' => $total,
				'items_per_page' => $items_per_page,
				'page' => $page,
			);

			return $return_array;
         
        }

		public function delete_lead() {
			global $wpdb;
            $table_name = $wpdb->prefix . 'houzez_crm_leads';

			$nonce = $_REQUEST['security'];
	        if ( ! wp_verify_nonce( $nonce, 'delete_lead_nonce' ) ) {
	            $ajax_response = array( 'success' => false , 'reason' => esc_html__( 'Security check failed!', 'houzez-crm' ) );
	            echo json_encode( $ajax_response );
	            die;
	        }

	        if ( !isset( $_REQUEST['lead_id'] ) ) {
	            $ajax_response = array( 'success' => false , 'reason' => esc_html__( 'No lead id found', 'houzez-crm' ) );
	            echo json_encode( $ajax_response );
	            die;
	        }
	        $lead_id = $_REQUEST['lead_id'];

	        $where = array(
            	'lead_id' => $lead_id
            );

            $where_format = array(
            	'%d'
            );

	        
	        $wpdb->query( 
				$wpdb->prepare( 
					"DELETE FROM {$table_name}
					 WHERE lead_id = %d
					",
				        $lead_id
			        )
			);
	        $ajax_response = array( 'success' => true , 'reason' => '' );
            echo json_encode( $ajax_response );
            die;
		}

		public static function get_leads_stats() {

            $stats = array();
            $args = array('user_id' => get_current_user_id());

            $stats['leads_count'] = self::get_leads_Count($args);
            

            return $stats;
        }

		public static function get_leads_Count( $args = array() ) {
            $return = array();
            $user_id = isset( $args['user_id'] ) ? $args['user_id'] : false;
            
            $return['lastday'] = self::get_leads_insights( [ 'user_id' => $user_id, 'time' => 'lastday' ] );
            $return['lasttwo'] = self::get_leads_insights( [ 'user_id' => $user_id, 'time' => 'lasttwo' ] );
            $return['lastweek'] = self::get_leads_insights( [ 'user_id' => $user_id, 'time' => 'lastweek' ] );
            $return['last2week'] = self::get_leads_insights( [ 'user_id' => $user_id, 'time' => 'last2week' ] );
            $return['lastmonth'] = self::get_leads_insights( [ 'user_id' => $user_id, 'time' => 'lastmonth' ] );
            $return['last2month'] = self::get_leads_insights( [ 'user_id' => $user_id, 'time' => 'last2month' ] );
            
            return $return;
        }

		public static function get_leads_insights( $args = array() ) {
            global $wpdb;
            $table_name = $wpdb->prefix . 'houzez_crm_leads';
            $query = array();

            $DateTimeZone = wp_timezone();//new DateTimeZone( '+02:30' );
            $DateTime = new DateTime('now', $DateTimeZone);

            $args = wp_parse_args( $args, [
                'user_id' => false,
                'time' => false,
            ] );

            $query[] = "SELECT COUNT( {$table_name}.lead_id ) AS count";

            $query[] = "FROM {$table_name}";
            $query[] = "WHERE user_id =".$args['user_id'];

            if ( !empty( $args['time'] ) && in_array( $args['time'], ['lastday', 'lasttwo', 'lastweek', 'last2week', 'lastmonth', 'last2month', 'lasthalfyear', 'lastyear'] ) ) {

                $time_token = [ 'lastday' => '-1 day', 'lasttwo' => '-2 day', 'lastweek' => '-7 days', 'last2week' => '-14 days', 'lastmonth' => '-30 days', 'last2month' => '-60 days', 'lasthalfyear' => '-182 days', 'lastyear' => '-365 days' ];

                $modifiedTime = $DateTime->modify( $time_token[ $args['time'] ] )->format('Y-m-d H:i:s');

                $query[] = sprintf(
                    " AND {$table_name}.time >= '%s' ", $modifiedTime
                );
            }

            $query = join( "\n", $query );

            $results = $wpdb->get_row( $query, OBJECT );

            return is_object( $results ) && ! empty( $results->count ) ? (int) $results->count : 0;
        }

	} // end Houzez_Leads

	new Houzez_Leads();
}