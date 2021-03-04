<?php
$belong_to = isset($_GET['lead-id']) ? $_GET['lead-id'] : '';
$notes = Houzez_CRM_Notes::get_notes($belong_to, 'lead');
?>
<div class="form-group">
    <textarea class="form-control" id="note" rows="5" placeholder="<?php esc_html_e('Type your note here...', 'houzez'); ?>"></textarea>
    <input type="hidden" id="belong_to" value="<?php echo intval($belong_to); ?>">
    <input type="hidden" id="note_type" value="lead">
    <input type="hidden" id="note_security" value="<?php echo wp_create_nonce('note_add_nonce') ?>">
</div>
<button id="enquiry_note" class="btn btn-primary">
    <?php get_template_part('template-parts/loader'); ?>
    <?php esc_html_e('Add Note', 'houzez'); ?>
</button>

<div id="notes-main-wrap">
<?php
if(!empty($notes)) {
    foreach ($notes as $data) { $datetime = strtotime($data->time);?>

        <div class="private-note-wrap">
            <p class="activity-time">
            <?php printf( __( '%s ago', 'houzez' ), human_time_diff( $datetime, current_time( 'timestamp' ) ) ); ?>
            </p>
            <p><?php echo esc_attr($data->note); ?></p>
            <div class="text-right">
                <a class="delete_note" data-id="<?php echo intval($data->note_id); ?>" href="#" class="ml-3">
                    <i class="houzez-icon icon-remove-circle mr-1"></i> 
                    <strong><?php esc_html_e('Delete', 'houzez'); ?></strong>
                </a>
            </div>
        </div>

<?php
    }
}
?>
</div>