<?php
/**
 * Created by PhpStorm.
 * User: waqasriaz
 * Date: 08/12/16
 * Time: 8:11 PM
 */

global $wpdb, $userID;
$tabel = $wpdb->prefix . 'houzez_threads';
$message_query = "SELECT * FROM $tabel WHERE sender_id = $userID OR receiver_id = $userID ORDER BY seen ASC";


$houzez_threads = $wpdb->get_results( $message_query );
?>

<?php if ( sizeof( $houzez_threads ) != 0 ) { ?>
<table class="dashboard-table table-lined responsive-table">
    <thead>
        <tr>
            <th><?php esc_html_e( 'From', 'houzez' ); ?></th>
			<th><?php esc_html_e( 'Property', 'houzez' ); ?></th>
			<th><?php esc_html_e( 'Last Message', 'houzez' ); ?></th>
			<th><?php esc_html_e( 'Date', 'houzez' ); ?></th>
			<th class="action-col"><?php esc_html_e( 'Actions', 'houzez' ); ?></th>
        </tr>
    </thead>
    <tbody>
        
    <?php 
	foreach ( $houzez_threads as $thread ) { 

		$sender_id = $thread->sender_id;
		$receiver_id = $thread->receiver_id;

		if($userID == $sender_id) {
			$delete = $thread->sender_delete;
		} elseif($userID == $receiver_id) {
			$delete = $thread->receiver_delete;
		}

	if($delete != 1) {

	$thread_class = 'msg-unread table-new';
	$tabel = $wpdb->prefix . 'houzez_thread_messages';
	$sender_id = $thread->sender_id;
	$thread_id = $thread->id;

	$last_message = $wpdb->get_row(
		"SELECT *
			FROM $tabel
			WHERE thread_id = $thread_id
			ORDER BY id DESC"
	);

	$user_custom_picture =  get_the_author_meta( 'fave_author_custom_picture' , $sender_id );
	$url_query = array( 'thread_id' => $thread_id, 'seen' => true );

	if ( $last_message->created_by == $userID || $thread->seen ) {
		$thread_class = '';
		unset( $url_query['seen'] );
	}

	if ( empty( $user_custom_picture )) {
		$user_custom_picture = get_template_directory_uri().'/img/profile-avatar.png';
	}

	$thread_link = houzez_get_template_link_2('template/user_dashboard_messages.php');
	$thread_link = add_query_arg( $url_query, $thread_link );

	$sender_first_name  =  get_the_author_meta( 'first_name', $sender_id );
	$sender_last_name  =  get_the_author_meta( 'last_name', $sender_id );
	$sender_display_name = get_the_author_meta( 'display_name', $sender_id );
	if( !empty($sender_first_name) && !empty($sender_last_name) ) {
		$sender_display_name = $sender_first_name.' '.$sender_last_name;
	}

	$last_sender_first_name  =  get_the_author_meta( 'first_name', $last_message->created_by );
	$last_sender_last_name  =  get_the_author_meta( 'last_name', $last_message->created_by );
	$last_sender_display_name = get_the_author_meta( 'display_name', $last_message->created_by );
	if( !empty($last_sender_first_name) && !empty($last_sender_last_name) ) {
		$last_sender_display_name = $last_sender_first_name.' '.$last_sender_last_name;
	}

	?>
	<tr class="<?php echo $thread_class; ?>">
		<td data-label="<?php esc_html_e( 'From', 'houzez' ); ?>" class="table-nowrap">
			<img class="rounded-circle" src="<?php echo esc_url( $user_custom_picture ); ?>" width="40" height="40" alt="Image">
			<span class="ml-2"><?php echo ucfirst( $sender_display_name ); ?></span>
		</td>
		<td data-label="<?php esc_html_e( 'Property', 'houzez' ); ?>" class="table-nowrap">
			<a><strong><?php echo get_the_title( $thread->property_id ); ?></strong></a>
		</td>
		<!-- <td class="property-table-id" data-label="ID">HZ-001</td> -->
		<td data-label="<?php esc_html_e( 'Last Message', 'houzez' ); ?>"><?php echo ucfirst( $last_sender_display_name ).': '; ?><?php echo $last_message->message; ?></td>
		
		<td data-label="<?php esc_html_e( 'Date', 'houzez' ); ?>" class="table-nowrap">
			<?php echo date_i18n( get_option('date_format').' '.get_option('time_format'), strtotime( $last_message->time ) ); ?>
		</td>
		<td data-label="<?php esc_html_e( 'Actions', 'houzez' ); ?>">
			<div class="dropdown property-action-menu">
				<button class="btn btn-primary-outlined dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<?php esc_attr_e('Actions', 'houzez'); ?>
				</button>
				<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
					<a class="dropdown-item" href="<?php echo esc_url( $thread_link ).'#message-'.intval($last_message->id); ?>"><?php esc_attr_e('Reply', 'houzez');?></a>
					<a class="houzez_delete_msg_thread dropdown-item" href="#" data-thread-id="<?php echo intval($thread_id); ?>" data-sender-id="<?php echo intval($sender_id); ?>" data-receiver-id="<?php echo intval($receiver_id); ?>"><?php esc_attr_e('Delete', 'houzez'); ?></a>
				</div>
			</div>
		</td>
	</tr>

	<?php } }?>
    </tbody>
</table><!-- dashboard-table -->
<?php } else { ?> 
<div class="dashboard-content-block">
    <?php echo esc_html__("You don't have any message.", 'houzez'); ?>
</div><!-- dashboard-content-block -->
<?php } ?>
<?php //include 'inc/listing/pagination.php';?>	