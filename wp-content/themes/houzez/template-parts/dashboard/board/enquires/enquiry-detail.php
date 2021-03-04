<?php
global $enquiry, $matched_query, $lead;
$enquiry = Houzez_Enquiry::get_enquiry($_GET['enquiry']);
$matched_query = matched_listings($enquiry->enquiry_meta);
$belong_to = isset($_GET['enquiry']) ? $_GET['enquiry'] : '';

$lead = Houzez_Leads::get_lead($enquiry->lead_id);

$total_matched_listings = '0';
if(!empty($matched_query)) {
    $total_matched_listings = $matched_query->found_posts;
}

$enquiry_notes = Houzez_CRM_Notes::get_notes($belong_to, 'enquiry');
$back_link = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
?>
<header class="header-main-wrap dashboard-header-main-wrap">
    <div class="dashboard-header-wrap">
        <div class="d-flex align-items-center">
            <div class="dashboard-header-left flex-grow-1">
                <h1><?php esc_html_e('Details', 'houzez'); ?></h1>         
            </div><!-- dashboard-header-left -->
            <div class="dashboard-header-right">

            </div><!-- dashboard-header-right -->
        </div><!-- d-flex -->
    </div><!-- dashboard-header-wrap -->
</header><!-- .header-main-wrap -->
<section class="dashboard-content-wrap">
    <div class="dashboard-content-inner-wrap">
        <div class="dashboard-content-block-wrap">
            <div class="row">
                <div class="col-md-4 col-sm-12">
                    <div class="dashboard-content-block">
                        <?php get_template_part('template-parts/dashboard/board/enquires/enquiry-info'); ?>
                    </div><!-- dashboard-content-block -->       
                </div><!-- col-md-4 col-sm-12 -->
                <div class="col-md-8 col-sm-12">
                    <ul class="nav nav-pills lead-nav-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="pill" href="#matching-listings" role="tab"><?php esc_html_e('Matching Listings', 'houzez'); ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="pill" href="#notes" role="tab"><?php esc_html_e('Notes', 'houzez'); ?></a>
                        </li>
                        <li class="nav-item ml-auto">
                            <a class="nav-link text-primary" href="<?php echo esc_url($back_link); ?>">
                                <?php esc_html_e('Back', 'houzez'); ?>
                            </a>
                        </li>
                    </ul>
                    <div class="dashboard-content-block tab-content">

                        <div class="email_messages"></div>

                        <div class="tab-pane fade show active" id="matching-listings" role="tabpanel">
                            <div class="d-flex justify-content-between mb-3">
                                <div><?php echo esc_attr($total_matched_listings); ?> <?php esc_html_e('Listings found', 'houzez'); ?></div> 
                                <div>
                                    <a href="#" id="inquiry-send-email" class="btn btn-primary btn-slim"><i class="houzez-icon icon-envelope mr-1"></i> <?php esc_html_e('Send Via Email', 'houzez'); ?></a>
                                </div>    
                            </div>
                            <?php get_template_part('template-parts/dashboard/board/match', 'listings'); ?>
                        </div>
                        <div class="tab-pane fade" id="notes" role="tabpanel">
                            <div class="form-group">
                                <textarea class="form-control" id="note" rows="5" placeholder="<?php esc_html_e('Type your note here...', 'houzez'); ?>"></textarea>
                                <input type="hidden" id="belong_to" value="<?php echo intval($belong_to); ?>">
                                <input type="hidden" id="note_type" value="enquiry">
                                <input type="hidden" id="lead_email" value="<?php echo esc_attr($lead->email); ?>">
                                <input type="hidden" id="note_security" value="<?php echo wp_create_nonce('note_add_nonce') ?>">
                            </div>
                            <button id="enquiry_note" class="btn btn-primary">
                                <?php get_template_part('template-parts/loader'); ?>
                                <?php esc_html_e('Add Note', 'houzez'); ?>
                            </button>

                            <div id="notes-main-wrap">
                            <?php
                            if(!empty($enquiry_notes)) {
                                foreach ($enquiry_notes as $data) { $datetime = strtotime($data->time);?>

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
                        </div>
                    </div><!-- dashboard-content-block -->
                </div><!-- col-md-8 col-sm-12 -->
            </div>
        </div><!-- dashboard-content-block-wrap -->
    </div><!-- dashboard-content-inner-wrap -->
</section><!-- dashboard-content-wrap -->
<section class="dashboard-side-wrap">
    <?php get_template_part('template-parts/dashboard/side-wrap'); ?>
</section>