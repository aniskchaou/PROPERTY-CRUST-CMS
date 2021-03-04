<?php
if ( ! class_exists( 'Houzez_Enquiry' ) ) {

	class Houzez_Enquiry {

		
		public function __construct() {
			add_action( 'wp_ajax_crm_add_new_enquiry', array( $this, 'add_enquiry' ) );
			add_action( 'wp_ajax_get_single_enquiry', array( $this, 'get_single_enquiry' ) );
			add_action( 'wp_ajax_houzez_delete_enquiry', array( $this, 'delete_enquiry') );
			add_action( 'wp_ajax_houzez_match_listing_email', array( $this, 'send_match_listing_email') );
			
		}

		public function add_enquiry() {
			$lead_id = sanitize_text_field( $_POST['lead_id'] );
			$enquiry_type = sanitize_text_field( $_POST['enquiry_type'] );
			$property_type = sanitize_text_field( $_POST['e_meta']['property_type'] );

			if(empty($lead_id)) {
				echo json_encode( array( 'success' => false, 'msg' => esc_html__('Enter a valid contact', 'houzez-crm') ) );
	            wp_die();
			}

			if(empty($property_type)) {
				echo json_encode( array( 'success' => false, 'msg' => esc_html__('Select property type', 'houzez-crm') ) );
	            wp_die();
			}

			if(isset($_POST['enquiry_id']) && !empty($_POST['enquiry_id'])) {
				$enquiry_id = intval($_POST['enquiry_id']);
	        	$enquiry_id = $this->update_enquiry($enquiry_id);

				echo json_encode( array(
	                'success' => true,
	                'msg' => esc_html__("Successfully updated!", 'houzez-crm')
	            ));
	            wp_die();

	        } else {

				$save_enquiry = $this->save_enquiry();
				if($save_enquiry) {
					echo json_encode( array( 'success' => true, 'msg' => esc_html__('Successfully added!', 'houzez-crm') ) );
			            wp_die();
				}
			}
		}

		public function save_enquiry($lead_id = "") {

			global $wpdb;

			$listing_id = 0;
			if ( isset( $_POST['listing_id'] ) ) {
				$listing_id = intval( $_POST['listing_id'] );
			}

			$negotiator = '';
			if ( isset( $_POST['negotiator'] ) ) {
				$negotiator = sanitize_text_field( $_POST['negotiator'] );
			}

			$source = '';
			if ( isset( $_POST['source'] ) ) {
				$source = sanitize_text_field( $_POST['source'] );
			}

			$status = '';
			if ( isset( $_POST['status'] ) ) {
				$status = sanitize_text_field( $_POST['status'] );
			}

			$agent_id = '';
			if ( isset( $_POST['agent_id'] ) ) {
				$agent_id = sanitize_text_field( $_POST['agent_id'] );
			}

			$agent_type = '';
			if ( isset( $_POST['agent_type'] ) ) {
				$agent_type = sanitize_text_field( $_POST['agent_type'] );
			}

			$private_note = '';
			if ( isset( $_POST['private_note'] ) ) {
				$private_note = sanitize_textarea_field( $_POST['private_note'] );
			}

			$enquiry_type = '';
			if ( isset( $_POST['enquiry_type'] ) ) {
				$enquiry_type = sanitize_text_field( $_POST['enquiry_type'] );
			}

			$message = '';
			if ( isset( $_POST['message'] ) ) {
				$message = sanitize_textarea_field( $_POST['message'] );
			}

			if(!empty($listing_id)) {
				$enquiry_meta = $this->get_property_info($listing_id);
				$enquiry_meta = maybe_serialize($enquiry_meta);

			} else if( isset($_POST['is_estimation']) && $_POST['is_estimation'] == 'yes' ) {
				$meta = isset($_POST['e_meta']) ? $_POST['e_meta'] : '';
				$enquiry_meta = $this->prepare_estimation_meta($meta);
				$enquiry_meta = maybe_serialize($enquiry_meta);

			} else {
				$lead_id = intval( $_POST['lead_id'] );
				$meta = isset($_POST['e_meta']) ? $_POST['e_meta'] : '';
				$enquiry_meta = $this->prepare_property_meta($meta);
				$enquiry_meta = maybe_serialize($enquiry_meta);
			}

			if(!empty($listing_id)) {
				$user_id = get_post_field( 'post_author', $listing_id );
			}

			if( (isset($_POST['houzez_contact_form']) && $_POST['houzez_contact_form'] == 'yes') || (isset($_POST['is_estimation']) && $_POST['is_estimation'] == 'yes') || empty($user_id) ) {

				$adminData = get_user_by( 'email', get_option( 'admin_email' ) );
				$user_id = $adminData->ID;
				$agent_id = $adminData->ID;
				$agent_type = 'author_info';
			}

			if( isset($_POST['action']) && $_POST['action'] == 'crm_add_new_enquiry' ) {
				$user_id = get_current_user_id();
			}
		

            $data_table        = $wpdb->prefix . 'houzez_crm_enquiries';
	        $data = array(
	        	'user_id'       	=> $user_id,
                'lead_id'           => $lead_id,
                'listing_id'  		=> $listing_id,
                'negotiator'    	=> $negotiator,
                'source'     		=> $source,
                'status'         	=> $status,
                'enquiry_to'        => $agent_id,
                'enquiry_user_type' => $agent_type,
                'message'    		=> $message,
                'enquiry_type'    	=> $enquiry_type,
                'enquiry_meta'    	=> $enquiry_meta,
                'private_note'    	=> $private_note
            );

            $format = array(
                '%d',
                '%d',
                '%d',
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

            $inserted_id = $wpdb->insert($data_table, $data, $format);
            return $inserted_id;

		}

		public function update_enquiry($enquiry_id) {

			global $wpdb;

			$listing_id = 0;
			if ( isset( $_POST['listing_id'] ) ) {
				$listing_id = intval( $_POST['listing_id'] );
			}

			$negotiator = '';
			if ( isset( $_POST['negotiator'] ) ) {
				$negotiator = sanitize_text_field( $_POST['negotiator'] );
			}

			$source = '';
			if ( isset( $_POST['source'] ) ) {
				$source = sanitize_text_field( $_POST['source'] );
			}

			$status = '';
			if ( isset( $_POST['status'] ) ) {
				$status = sanitize_text_field( $_POST['status'] );
			}

			$agent_id = '';
			if ( isset( $_POST['agent_id'] ) ) {
				$agent_id = sanitize_text_field( $_POST['agent_id'] );
			}

			$agent_type = '';
			if ( isset( $_POST['agent_type'] ) ) {
				$agent_type = sanitize_text_field( $_POST['agent_type'] );
			}

			$private_note = '';
			if ( isset( $_POST['private_note'] ) ) {
				$private_note = sanitize_text_field( $_POST['private_note'] );
			}

			$enquiry_type = '';
			if ( isset( $_POST['enquiry_type'] ) ) {
				$enquiry_type = sanitize_text_field( $_POST['enquiry_type'] );
			}

			$message = '';
			if ( isset( $_POST['message'] ) ) {
				$message = sanitize_textarea_field( $_POST['message'] );
			}

			if(!empty($listing_id)) {
				$enquiry_meta = $this->get_property_info($listing_id);
				$enquiry_meta = maybe_serialize($enquiry_meta);
			} else {
				$lead_id = intval( $_POST['lead_id'] );
				$meta = $_POST['e_meta'];
				$enquiry_meta = $this->prepare_property_meta($meta);
				$enquiry_meta = maybe_serialize($enquiry_meta);
			}
		

            $data_table        = $wpdb->prefix . 'houzez_crm_enquiries';
	        $data = array(
                'lead_id'           => $lead_id,
                'listing_id'  		=> $listing_id,
                'negotiator'    	=> $negotiator,
                'source'     		=> $source,
                'status'         	=> $status,
                'enquiry_to'        => $agent_id,
                'enquiry_user_type' => $agent_type,
                'message'    		=> $message,
                'enquiry_type'    	=> $enquiry_type,
                'enquiry_meta'    	=> $enquiry_meta,
                'private_note'    	=> $private_note
            );

            $format = array(
                '%d',
                '%d',
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
            	'enquiry_id' => $enquiry_id
            );

            $where_format = array(
            	'%d'
            );

            $updated = $wpdb->update( $data_table, $data, $where, $format, $where_format );

            if ( false === $updated ) {
			    return false;
			} else {
			    return true;
			}

		}

		public static function get_enquires() {
			global $wpdb;
            $table_name = $wpdb->prefix . 'houzez_crm_enquiries';

            $andwhere = '';
			if(isset($_GET['lead-id']) && !empty($_GET['lead-id'])) {
				$andwhere = 'AND lead_id="'.$_GET['lead-id'].'"';
			}
            
            $items_per_page = isset($_GET['records']) ? intval($_GET['records']) : 10;
			$page = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
			$offset = ( $page * $items_per_page ) - $items_per_page;
			$query = 'SELECT * FROM '.$table_name.' WHERE user_id= '.get_current_user_id().' '.$andwhere;
			$total_query = "SELECT COUNT(1) FROM (${query}) AS combined_table";
			$total = $wpdb->get_var( $total_query );

			$results = $wpdb->get_results( $query.' ORDER BY enquiry_id DESC LIMIT '. $offset.', '. $items_per_page, OBJECT );

			$return_array['data'] = array(
				'results' => $results,
				'total_records' => $total,
				'items_per_page' => $items_per_page,
				'page' => $page,
			);

			return $return_array;
		}

		public function get_property_info($listing_id) {
			$enquiry_meta = array();

			if(empty($listing_id)) {
				return $enquiry_meta;
			}
			$enquiry_meta['property_type'] = $this->crm_taxonomy( 'property_type', $listing_id );
			$enquiry_meta['country'] = $this->crm_taxonomy( 'property_country', $listing_id );
			$enquiry_meta['state'] = $this->crm_taxonomy( 'property_state', $listing_id );
			$enquiry_meta['city'] = $this->crm_taxonomy( 'property_city', $listing_id );
			$enquiry_meta['area'] = $this->crm_taxonomy( 'property_area', $listing_id );

			$enquiry_meta['min_beds'] = get_post_meta( $listing_id, 'fave_property_bedrooms', true );
			$enquiry_meta['max_beds'] = get_post_meta( $listing_id, 'fave_property_bedrooms', true );

			$enquiry_meta['min_baths'] = get_post_meta( $listing_id, 'fave_property_bathrooms', true );
			$enquiry_meta['max_baths'] = get_post_meta( $listing_id, 'fave_property_bathrooms', true );
			$enquiry_meta['min_price'] = get_post_meta( $listing_id, 'fave_property_price', true );
			$enquiry_meta['max_price'] = get_post_meta( $listing_id, 'fave_property_price', true );

			$enquiry_meta['min_area'] = get_post_meta( $listing_id, 'fave_property_size', true );
			$enquiry_meta['max_area'] = get_post_meta( $listing_id, 'fave_property_size', true );
			$enquiry_meta['zipcode'] = get_post_meta( $listing_id, 'fave_property_zip', true );

			return $enquiry_meta;
		}

		public function prepare_property_meta($meta) {
			$enquiry_meta = array();

			$enquiry_meta['property_type'] = hcrm_get_term_by( 'slug', sanitize_text_field($meta['property_type']), 'property_type');
			$enquiry_meta['country'] = hcrm_get_term_by( 'slug', sanitize_text_field($meta['country']), 'property_country');
			$enquiry_meta['state'] = hcrm_get_term_by( 'slug', sanitize_text_field($meta['state']), 'property_state');
			$enquiry_meta['city'] = hcrm_get_term_by( 'slug', sanitize_text_field($meta['city']), 'property_city');
			$enquiry_meta['area'] = hcrm_get_term_by( 'slug', sanitize_text_field($meta['area']), 'property_area');

			$enquiry_meta['min_beds'] = sanitize_text_field($meta['min-beds']);
			$enquiry_meta['max_beds'] = sanitize_text_field($meta['max-beds']);

			$enquiry_meta['min_baths'] = sanitize_text_field($meta['min-baths']);
			$enquiry_meta['max_baths'] = sanitize_text_field($meta['max-baths']);

			$enquiry_meta['min_price'] = sanitize_text_field($meta['min-price']);
			$enquiry_meta['max_price'] = sanitize_text_field($meta['max-price']);

			$enquiry_meta['min_area'] = sanitize_text_field($meta['min-area']);
			$enquiry_meta['max_area'] = sanitize_text_field($meta['max-area']);
			$enquiry_meta['zipcode'] = sanitize_text_field($meta['zipcode']);

			return $enquiry_meta;

		}

		public function prepare_estimation_meta($meta) {
			$enquiry_meta = array();
			$beds = isset($meta['beds']) ? $meta['beds'] : '';
			$max_beds = isset($meta['max-beds']) ? $meta['max-beds'] : '';
			$baths = isset($meta['baths']) ? $meta['baths'] : '';
			$max_baths = isset($meta['max-baths']) ? $meta['max-baths'] : '';
			$price = isset($meta['price']) ? $meta['price'] : '';
			$max_price = isset($meta['max-price']) ? $meta['max-price'] : '';
			$area_size = isset($meta['area-size']) ? $meta['area-size'] : '';
			$max_area_size = isset($meta['max-area-size']) ? $meta['max-area-size'] : '';
			$zipcode = isset($meta['zipcode']) ? $meta['zipcode'] : '';

			$property_type = isset($meta['property_type']) ? sanitize_text_field($meta['property_type']) : '';
			$country = isset($meta['country']) ? sanitize_text_field($meta['country']) : '';
			$state = isset($meta['state']) ? sanitize_text_field($meta['state']) : '';
			$city = isset($meta['city']) ? sanitize_text_field($meta['city']) : '';
			$area = isset($meta['area']) ? sanitize_text_field($meta['area']) : '';

			$enquiry_meta['property_type'] = hcrm_get_term_by( 'slug', $property_type, 'property_type');
			$enquiry_meta['country'] = hcrm_get_term_by( 'slug', $country, 'property_country');
			$enquiry_meta['state'] = hcrm_get_term_by( 'slug', $state, 'property_state');
			$enquiry_meta['city'] = hcrm_get_term_by( 'slug', $city, 'property_city');
			$enquiry_meta['area'] = hcrm_get_term_by( 'slug', $area, 'property_area');

			$enquiry_meta['min_beds'] = sanitize_text_field($beds);
			$enquiry_meta['max_beds'] = sanitize_text_field($max_beds);

			$enquiry_meta['min_baths'] = sanitize_text_field($baths);
			$enquiry_meta['max_baths'] = sanitize_text_field($max_baths);

			$enquiry_meta['min_price'] = sanitize_text_field($price);
			$enquiry_meta['max_price'] = sanitize_text_field($max_price);

			$enquiry_meta['min_area'] = sanitize_text_field($area_size);
			$enquiry_meta['max_area'] = sanitize_text_field($max_area_size);
			$enquiry_meta['zipcode'] = sanitize_text_field($zipcode);

			return $enquiry_meta;

		}

		public function crm_taxonomy( $tax_name, $propID ) {
			$data = array();
	        $terms = get_the_terms( $propID, $tax_name );
			if ( !empty( $terms ) ){
			    // get the first term
			    $term = array_shift( $terms );
			    $data['name'] = $term->name;
			    $data['slug'] = $term->slug;
			}

			return $data;
	    }

	    public static function get_enquiry($enquiry_id) {
			global $wpdb;
            $table_name = $wpdb->prefix . 'houzez_crm_enquiries';

            $sql = "SELECT * FROM $table_name WHERE enquiry_id=".$enquiry_id;
			
			$result = $wpdb->get_row( $sql, OBJECT );

            if( is_object( $result ) && ! empty( $result ) ) {
            	return $result;
            }

			return '';
		}

		public function get_single_enquiry() {
			global $wpdb;
            $table_name = $wpdb->prefix . 'houzez_crm_enquiries';
            
            $enquiry_id = '';
			if ( isset( $_POST['enquiry_id'] ) ) {
				$enquiry_id = intval( $_POST['enquiry_id'] );
			}

			if(empty($enquiry_id)) {
				echo json_encode( 
					array( 
						'success' => false, 
						'msg' => esc_html__('Something went wrong!', 'houzez-crm') 
					) 
				);
	            wp_die();
			}

            $sql = "SELECT * FROM {$table_name} WHERE enquiry_id = {$enquiry_id}";

            $result = $wpdb->get_row( $sql, OBJECT );

            $meta = maybe_unserialize($result->enquiry_meta);
            

            if( is_object( $result ) && ! empty( $result ) ) {
            	echo json_encode( 
					array( 
						'success' => true, 
						'data' => $result,
						'meta' => $meta
					) 
				);
	            wp_die();
            }
            return '';
		}
		

		public function delete_enquiry() {
			global $wpdb;
            $table_name = $wpdb->prefix . 'houzez_crm_enquiries';

	        if ( !isset( $_REQUEST['ids'] ) ) {
	            $ajax_response = array( 'success' => false , 'reason' => esc_html__( 'No enquiry selected', 'houzez-crm' ) );
	            echo json_encode( $ajax_response );
	            die;
	        }
	        $ids = $_REQUEST['ids'];
	        
	        $wpdb->query("DELETE FROM {$table_name} WHERE enquiry_id IN ($ids)");
	        $ajax_response = array( 'success' => true , 'reason' => '' );
            echo json_encode( $ajax_response );
            die;
		}


		public function send_match_listing_email() {
			$current_user = wp_get_current_user();
			$from_email = $current_user->user_email;
			$display_name = $current_user->display_name;

			$listing_ids = sanitize_text_field($_REQUEST['ids']);
			
			$target_email = $_POST['email_to'];
			$target_email = is_email($target_email);

			$subject = sprintf( esc_html__('Matched Listing Email from %s', 'houzez-crm'), get_bloginfo('name') );

	        $body = esc_html__("We found these listings against your inquiry", 'houzez-crm')." <br/>";

	        $listing_ids = explode(',', $listing_ids);

	        $i = 0;
	        foreach ($listing_ids as $id) { $i++;
	        	$body .= $i.') <a href="'.get_permalink($id).'">'.get_the_title($id).'</a>'. "<br/>";
	        }

	        
	        $headers = array();
	        $headers[] = 'From: '.$display_name.' <'.$from_email.'>';
	        $headers[] = 'Content-Type: text/html; charset=UTF-8';

			if ( wp_mail( $target_email, $subject, $body, $headers ) ) {
	            echo json_encode( array(
	                'success' => true,
	                'msg' => esc_html__("Email Sent Successfully!", 'houzez-crm')
	            ));
	        } else {
	            echo json_encode(array(
	                    'success' => false,
	                    'msg' => esc_html__("Server Error: Make sure Email function working on your server!", 'houzez-crm')
	                )
	            );
	        }
			wp_die();

		}


	} // end Houzez_Enquiry

	new Houzez_Enquiry();
}