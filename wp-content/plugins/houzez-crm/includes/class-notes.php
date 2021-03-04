<?php
if ( ! class_exists( 'Houzez_CRM_Notes' ) ) {

	class Houzez_CRM_Notes {

		
		public function __construct() {
			add_action( 'wp_ajax_houzez_crm_add_note', array( $this, 'add_note' ) );
			add_action( 'wp_ajax_houzez_delete_note', array( $this, 'delete_note') );
		}

		public function add_note() {
			global $wpdb;

			$note = sanitize_textarea_field( $_POST['note'] );
			$note_type = sanitize_text_field( $_POST['note_type'] );
			$belong_to = sanitize_text_field( $_POST['belong_to'] );
			
			$nonce = $_REQUEST['security'];
	        if ( ! wp_verify_nonce( $nonce, 'note_add_nonce' ) ) {
	            $ajax_response = array( 'success' => false , 'msg' => esc_html__( 'Security check failed!', 'houzez-crm' ) );
	            echo json_encode( $ajax_response );
	            die;
	        }

	        if ( empty($note) ) {
	            $ajax_response = array( 'success' => false , 'msg' => esc_html__( 'Please enter note!', 'houzez-crm' ) );
	            echo json_encode( $ajax_response );
	            die;
	        }

			$table_name  = $wpdb->prefix . 'houzez_crm_notes';

	        $data = array(
	        	'user_id'   => get_current_user_id(),
                'belong_to' => $belong_to,
                'note'  	=> $note,
                'type'  	=> $note_type,
                
            );

            $format = array(
                '%d',
                '%d',
                '%s',
                '%s',
            );

            $added = $wpdb->insert($table_name, $data, $format);


            if($added) {
            	$inserted_id = $wpdb->insert_id;

            	$single_note = self::get_single_note($inserted_id);

            	$ajax_response = array( 'success' => true , 'noteHtml' => $single_note, 'note_id' => $inserted_id, 'msg' => esc_html__( 'Add successfully', 'houzez-crm' ) );
	            echo json_encode( $ajax_response );
	            die;
            }	
            
            wp_die();
		}

	
		public static function get_single_note($note_id) {
			global $wpdb;
            $table_name = $wpdb->prefix . 'houzez_crm_notes';

            $sql = "SELECT * FROM $table_name WHERE note_id = {$note_id}";

			$result = $wpdb->get_row( $sql, OBJECT );

			

            if( is_object( $result ) && ! empty( $result ) ) {

            	$datetime = strtotime($result->time);
            	ob_start(); ?>

            	<div id="note-<?php echo intval($note_id); ?>" class="private-note-wrap" style="display: none;">
	                <p class="activity-time">
	                <?php printf( __( '%s ago', 'houzez-crm' ), human_time_diff( $datetime, current_time( 'timestamp' ) ) ); ?>
	                </p>
	                <p><?php echo esc_attr($result->note); ?></p>
	                <div class="text-right">
	                    <a class="delete_note" data-id="<?php echo intval($result->note_id); ?>" href="#" class="ml-3">
	                        <i class="houzez-icon icon-remove-circle mr-1"></i> 
	                        <strong><?php esc_html_e('Delete', 'houzez-crm'); ?></strong>
	                    </a>
	                </div>
	            </div>


            <?php
            	$output = ob_get_contents();
		        ob_end_clean();
		        return $output;
            }
            return '';
		}

		public static function get_notes($belong_to, $type) {
			global $wpdb;
            $table_name = $wpdb->prefix . 'houzez_crm_notes';
            $user_id = get_current_user_id();

            $sql = "SELECT * FROM $table_name WHERE type = '{$type}' AND belong_to = {$belong_to} AND user_id = {$user_id} ORDER BY note_id DESC";

			$results = $wpdb->get_results( $sql , OBJECT );

			return $results;
		}

		public function delete_note() {
			global $wpdb;
            $table_name = $wpdb->prefix . 'houzez_crm_notes';
			
	        $note_id = $_REQUEST['note_id'];

	        $where = array(
            	'note_id' => $note_id
            );

            $where_format = array(
            	'%d'
            );

	        $wpdb->query( $wpdb->prepare( "DELETE FROM {$table_name} WHERE note_id = %d", $note_id ));
	        
	        $ajax_response = array( 'success' => true , 'reason' => '' );
            echo json_encode( $ajax_response );
            die;
		}


	} // end Houzez_CRM_Notes

	new Houzez_CRM_Notes();
}