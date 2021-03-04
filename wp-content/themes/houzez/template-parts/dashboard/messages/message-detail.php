<?php
/**
 * Created by PhpStorm.
 * User: waqasriaz
 * Date: 08/12/16
 * Time: 8:13 PM
 */

global $wpdb, $current_user;

wp_get_current_user();
$current_user_id =  $current_user->ID;
$tabel = $wpdb->prefix . 'houzez_threads';
$thread_id = $_REQUEST['thread_id'];

$user_status = '<span class="text-danger"><i class="houzez-icon icon-single-neutral-circle mr-1"></i>'.esc_html__('Offline', 'houzez').'</span>';

if ( isset( $_GET['seen'] ) && $_GET['seen'] == 1 ) {
	houzez_update_message_status( $current_user_id, $thread_id );
}

$houzez_thread = $wpdb->get_row(
	"
	SELECT * 
	FROM $tabel
	WHERE id = $thread_id
	"
);

$tabel = $wpdb->prefix . 'houzez_thread_messages';
$houzez_messages = $wpdb->get_results(
	"
	SELECT * 
	FROM $tabel
	WHERE thread_id = $thread_id
	ORDER BY id DESC
	"
);

$thread_author = $houzez_thread->sender_id;

if ( $thread_author == $current_user_id ) {
	$thread_author = $houzez_thread->receiver_id;
} 

$thread_author_first_name  =  get_the_author_meta( 'first_name', $thread_author );
$thread_author_last_name  =  get_the_author_meta( 'last_name', $thread_author );
$thread_author_display_name = get_the_author_meta( 'display_name', $thread_author );
if( !empty($thread_author_first_name) && !empty($thread_author_last_name) ) {
	$thread_author_display_name = $thread_author_first_name.' '.$thread_author_last_name;
}

$user_custom_picture =  get_the_author_meta( 'fave_author_custom_picture' , $thread_author );

if ( empty( $user_custom_picture )) {
	$user_custom_picture = get_template_directory_uri().'/img/profile-avatar.png';
}

if ( houzez_is_user_online( $thread_author ) ) {
	$user_status = '<span class="text-success ml-2"><i class="houzez-icon icon-single-neutral-circle mr-1"></i>'.esc_html__('Online', 'houzez').'</span>';
}
?>

<?php if ( isset( $_GET['success'] ) && $_GET['success'] == true ) { ?>
<div class="alert alert-success alert-dismissible" role="alert">
	<button type="button" class="close" data-hide="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
	<?php esc_html_e( 'The message has been sent.', 'houzez' ); ?>
</div>
<?php } ?>

<?php if ( isset( $_GET['success'] ) && $_GET['success'] == false ) { ?>
<div class="alert alert-error alert-dismissible" role="alert">
	<button type="button" class="close" data-hide="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
	<?php esc_html_e( 'Oopps some thing getting wrong, please try again!', 'houzez' ); ?>
</div>
<?php } ?>

<div class="dashboard-content-block">
    <div class="message-top-wrap">
        <div class="d-flex">
            <div class="message-reply-user mr-3">
                <img class="rounded-circle mt-1" src="<?php echo esc_url( $user_custom_picture ); ?>" alt="<?php echo $thread_author_display_name; ?>" width="40" height="40">
            </div><!-- message-reply-user -->
            <div class="message-reply-user">
                <span class="mr-2"><?php echo ucfirst( $thread_author_display_name ); ?> 
                    <?php echo $user_status; ?>
                    <br>
                    <strong><?php echo get_the_title( $houzez_thread->property_id ); ?></strong>
                </span>
            </div><!-- message-reply-user -->
        </div><!-- d-flex -->
    </div><!-- message-top-wrap -->
</div><!-- dashboard-content-block -->

<div class="dashboard-content-block">
    
    <div class="message-reply-wrap">
        <div class="d-flex">
            
            <div class="message-reply-user mr-3">
                <?php
				$current_user_picture =  get_the_author_meta( 'fave_author_custom_picture' , $current_user_id );

				if ( empty( $current_user_picture )) {
					$current_user_picture = get_template_directory_uri().'/img/profile-avatar.png';
				}
				?>
				<img src="<?php echo $current_user_picture; ?>" width="40" height="40" class="rounded-circle mt-1" alt="<?php the_author_meta( 'display_name', $current_user_id ) ?>">
            </div><!-- message-reply-user -->

            <div class="message-reply-message flex-grow-1">
                <form class="form-msg" method="post">
                	<input type="hidden" name="start_thread_message_form_ajax"
					   value="<?php echo wp_create_nonce('start-thread-message-form-nonce'); ?>"/>
					<input type="hidden" name="thread_id" value="<?php echo intval($thread_id); ?>"/>
					<input type="hidden" name="action" value="houzez_thread_message">

	                <div class="form-group">
	                    <label><?php esc_html_e( 'Reply Message', 'houzez' ); ?></label>
	                    <textarea class="form-control" name="message" rows="5" placeholder="<?php esc_html_e( 'Type your message here...', 'houzez' ); ?>"></textarea>
	                </div>

	                <button class="start_thread_message_form btn btn-primary">
	                	<?php get_template_part('template-parts/loader'); ?>
	                	<?php esc_html_e('Send Message', 'houzez'); ?>		
	                </button>
	                
	                <!-- <button class="btn btn-light-grey-outlined pull-right"><i class="houzez-icon icon-attachment mr-2"></i> <?php esc_html_e('Attachment', 'houzez'); ?></button> -->

	            </form>
            </div><!-- message-reply-message -->

        </div>
    </div><!-- message-reply-wrap -->

    <div class="message-list-wrap">
        <ul class="list-unstyled message-list">
            
        	<?php foreach ( $houzez_messages AS $message ) { 

			$message_class = 'msg-me';
			$message_author = $message->created_by;
			$message_author_name = ucfirst( $thread_author_display_name );
			$message_author_picture =  get_the_author_meta( 'fave_author_custom_picture' , $message_author );

			if ( $message_author == $current_user_id ) {
				$message_author_name = esc_html__( 'Me', 'houzez' );
				$message_class = '';
			}

			if ( empty( $message_author_picture )) {
				$message_author_picture = get_template_directory_uri().'/img/profile-avatar.png';
			}

			?>
            <li class="message-list-item <?php echo esc_attr($message_class); ?>">
                <div class="d-flex">
                    <div class="message-reply-user mr-3">
                        <img class="rounded-circle mt-1" src="<?php echo esc_url($message_author_picture); ?>" width="40" height="40" alt="<?php echo esc_attr($message_author_name); ?>">
                    </div><!-- message-reply-user -->
                    <div class="message-reply-message flex-grow-1">
                        <p><strong><?php echo esc_attr($message_author_name); ?></strong><br>
                            <time><span class="mr-3"><i class="houzez-icon icon-time-clock-circle mr-1"></i>  <?php echo date_i18n( get_option('time_format'), strtotime( $message->time ) ); ?> <i class="houzez-icon icon-attachment ml-3 mr-1"></i> <?php echo date_i18n( get_option('date_format'), strtotime( $message->time ) ); ?> </span></time>
                        </p>
                        
                        <?php echo $message->message; ?>
                    </div><!-- message-reply-message -->
                </div>
            </li>
            
            <?php } ?>
        </ul>

    </div><!-- message-reply-wrap -->
</div><!-- dashboard-content-block -->