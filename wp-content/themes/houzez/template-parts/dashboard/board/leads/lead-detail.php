<?php
$dashboard_crm = houzez_get_template_link_2('template/user_dashboard_crm.php');

$lead_id = isset($_GET['lead-id']) ? $_GET['lead-id'] : 0;

$enquires_link = add_query_arg(
    array(
        'hpage' => 'lead-detail',
        'lead-id' => $lead_id,
        'tab' => 'enquires',
    ), $dashboard_crm
);

$events_link = add_query_arg(
    array(
        'hpage' => 'lead-detail',
        'lead-id' => $lead_id,
        'tab' => 'events',
    ), $dashboard_crm
);

$viewed_link = add_query_arg(
    array(
        'hpage' => 'lead-detail',
        'lead-id' => $lead_id,
        'tab' => 'viewed',
    ), $dashboard_crm
);
$searches_link = add_query_arg(
    array(
        'hpage' => 'lead-detail',
        'lead-id' => $lead_id,
        'tab' => 'searches',
    ), $dashboard_crm
);

$notes_link = add_query_arg(
    array(
        'hpage' => 'lead-detail',
        'lead-id' => $lead_id,
        'tab' => 'notes',
    ), $dashboard_crm
);

$enquires = $events = $viewed = $searches = $notes = '';

if( isset($_GET['tab']) && $_GET['tab'] == 'enquires' ) {
    $enquires = 'active';

} else if( isset($_GET['tab']) && $_GET['tab'] == 'events' ) {
    $events = 'active';

} else if( isset($_GET['tab']) && $_GET['tab'] == 'viewed' ) {
    $viewed = 'active';

} else if( isset($_GET['tab']) && $_GET['tab'] == 'searches' ) {
    $searches = 'active';

} else if( isset($_GET['tab']) && $_GET['tab'] == 'notes' ) {
    $notes = 'active';

}

?>
<header class="header-main-wrap dashboard-header-main-wrap">
    <div class="dashboard-header-wrap">
        <div class="d-flex align-items-center">
            <div class="dashboard-header-left flex-grow-1">

                <?php if($enquires == 'active') { ?>
                <h1><?php esc_html_e('Inquiries', 'houzez'); ?></h1>  

                <?php } elseif($events == 'active') { ?>
                <h1><?php esc_html_e('Events', 'houzez'); ?></h1>

                <?php } elseif($viewed == 'active') { ?> 
                <h1><?php esc_html_e('Listings Viewed', 'houzez'); ?></h1> 

                <?php } elseif ($searches == 'active') { ?>
                <h1><?php esc_html_e('Saved Searches', 'houzez'); ?></h1> 
                
                <?php } elseif ($notes == 'active') { ?>
                <h1><?php esc_html_e('Notes', 'houzez'); ?></h1> 
               <?php } ?>    
            </div><!-- dashboard-header-left -->
            <div class="dashboard-header-right">
                <?php if( $enquires == 'active' ) { ?>
                <a href="#" class="btn btn-primary open-close-enquiry-panel">
                    <?php esc_html_e('Add New Inquiry', 'houzez'); ?>
                </a>
                <?php } elseif( $events == 'active' ) { ?>
                <a href="#" class="btn btn-primary open-close-event-panel">
                    <?php esc_html_e('Add New Event', 'houzez'); ?>
                </a>
                <?php } ?>
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
                        <?php get_template_part('template-parts/dashboard/board/leads/lead-info'); ?>
                    </div><!-- dashboard-content-block -->       
                </div><!-- col-md-4 col-sm-12 -->
                <div class="col-md-8 col-sm-12">
                    <ul class="nav nav-pills lead-nav-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link <?php echo esc_attr($enquires); ?>" href="<?php echo esc_url($enquires_link); ?>">
                                <?php esc_html_e('Inquiries', 'houzez'); ?>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link <?php echo esc_attr($viewed); ?>" href="<?php echo esc_url($viewed_link); ?>">
                                <?php esc_html_e('Listings Viewed', 'houzez'); ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo esc_attr($searches); ?>" href="<?php echo esc_url($searches_link); ?>">
                                <?php esc_html_e('Saved Searches', 'houzez'); ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo esc_attr($notes); ?>" href="<?php echo esc_url($notes_link); ?>">
                                <?php esc_html_e('Notes', 'houzez'); ?>
                            </a>
                        </li>
                    </ul>
                    <div class="dashboard-content-block tab-content">
                        <?php 
                        if( $enquires == 'active' ) {
                            get_template_part('template-parts/dashboard/board/enquires/enquires'); 

                        } else if( $events == 'active' ) {
                            

                        } else if( $viewed == 'active' ) {
                            get_template_part('template-parts/dashboard/board/leads/listing-viewed');

                        } else if( $searches == 'active' ) {
                            get_template_part('template-parts/dashboard/board/leads/saved-searches');

                        } else if( $notes == 'active' ) {
                            get_template_part('template-parts/dashboard/board/notes');

                        }
                        ?>
                    </div><!-- dashboard-content-block -->
                </div><!-- col-md-8 col-sm-12 -->
            </div>
        </div><!-- dashboard-content-block-wrap -->
    </div><!-- dashboard-content-inner-wrap -->
</section><!-- dashboard-content-wrap -->
<section class="dashboard-side-wrap">
    <?php get_template_part('template-parts/dashboard/side-wrap'); ?>
</section>