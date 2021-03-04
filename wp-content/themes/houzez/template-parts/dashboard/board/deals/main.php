<?php
global $deal_data;
$deals = Houzez_Deals::get_deals();

$active_deal = $won_deal = $lost_deal = '';
$dashboard_crm = houzez_get_template_link_2('template/user_dashboard_crm.php');

$active_link = add_query_arg(
    array(
        'hpage' => 'deals',
        'tab' => 'active',
    ), $dashboard_crm
);

$won_link = add_query_arg(
    array(
        'hpage' => 'deals',
        'tab' => 'won',
    ), $dashboard_crm
);

$lost_link = add_query_arg(
    array(
        'hpage' => 'deals',
        'tab' => 'lost',
    ), $dashboard_crm
);

if( isset($_GET['tab']) && $_GET['tab'] == 'active' ) {
    $active_deal = 'active';

} else if( isset($_GET['tab']) && $_GET['tab'] == 'won' ) {
    $won_deal = 'active';

} else if( isset($_GET['tab']) && $_GET['tab'] == 'lost' ) {
    $lost_deal = 'active';

} else {
    $active_deal = 'active';
}
?>
<header class="header-main-wrap dashboard-header-main-wrap">
    <div class="dashboard-header-wrap">
        <div class="d-flex align-items-center">
            <div class="dashboard-header-left flex-grow-1">
                <h1><?php echo houzez_option('dsh_deals', 'Deals'); ?></h1>         
            </div><!-- dashboard-header-left -->
            <div class="dashboard-header-right">
                <a class="btn btn-primary open-close-deal-panel" href="#"><?php esc_html_e('Add New Deal', 'houzez'); ?></a>
            </div><!-- dashboard-header-right -->
        </div><!-- d-flex -->
    </div><!-- dashboard-header-wrap -->
</header><!-- .header-main-wrap -->
<section class="dashboard-content-wrap">
    
    <div class="deals-table-wrap">

        <ul class="nav nav-pills deals-nav-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active-deals <?php echo esc_attr($active_deal); ?>" href="<?php echo esc_url($active_link); ?>">
                    <?php esc_html_e('Active Deals', 'houzez'); ?> (<?php echo Houzez_Deals::get_total_deals_by_group('active'); ?>)
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link won-deals <?php echo esc_attr($won_deal); ?>" href="<?php echo esc_url($won_link); ?>">
                    <?php esc_html_e('Won Deals', 'houzez'); ?> (<?php echo Houzez_Deals::get_total_deals_by_group('won'); ?>)
                </a>
            </li>
            <li class="nav-item lost-deals">
                <a class="nav-link <?php echo esc_attr($lost_deal); ?>" href="<?php echo esc_url($lost_link); ?>">
                    <?php esc_html_e('Lost Deals', 'houzez'); ?> (<?php echo Houzez_Deals::get_total_deals_by_group('lost'); ?>)
                </a>
            </li>
        </ul>
        <div class="deal-content-wrap p-0">
            <table class="dashboard-table table-lined deals-table responsive-table">
                <thead>
                    <tr>
                        <th class="table-nowrap"><?php esc_html_e('Title', 'houzez'); ?></th>
                        <th class="table-nowrap"><?php esc_html_e('Contact Name', 'houzez'); ?></th>
                        <?php if( houzez_is_admin() ) { ?>
                        <th class="table-nowrap"><?php esc_html_e('Agent', 'houzez'); ?></th>
                        <?php } ?>
                        <th class="table-nowrap"><?php esc_html_e('Status', 'houzez'); ?></th>
                        <th class="table-nowrap"><?php esc_html_e('Next Action', 'houzez'); ?></th>
                        <th class="table-nowrap"><?php esc_html_e('Action Due Date', 'houzez'); ?></th>
                        <th class="table-nowrap"><?php esc_html_e('Deal Value', 'houzez'); ?></th>
                        <th class="table-nowrap"><?php esc_html_e('Last Contact Date', 'houzez'); ?></th>
                        <th class="table-nowrap"><?php esc_html_e('Phone', 'houzez'); ?></th>
                        <th class="table-nowrap"><?php esc_html_e('Email', 'houzez'); ?></th>
                        <th class="table-nowrap"><?php esc_html_e('Actions', 'houzez'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach ($deals['data']['results'] as $deal_data) { 
                        get_template_part( 'template-parts/dashboard/board/deals/deal-item' );
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="7">
                            <?php get_template_part('template-parts/dashboard/board/records-html'); ?>
                        </td>
                        
                        <td colspan="2" class="text-right no-wrap">
                            <div class="crm-pagination">
                                <?php
                                echo paginate_links( array(
                                    'base' => add_query_arg( 'cpage', '%#%' ),
                                    'format' => '',
                                    'prev_text' => __('&laquo;'),
                                    'next_text' => __('&raquo;'),
                                    'total' => ceil($deals['data']['total_records'] / $deals['data']['items_per_page']),
                                    'current' => $deals['data']['page']
                                ));
                                ?>
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table><!-- dashboard-table -->
        </div><!-- dashboard-content-block -->

    </div><!-- deals-table-wrap -->
</section><!-- dashboard-content-wrap -->
<section class="dashboard-side-wrap">
    <?php get_template_part('template-parts/dashboard/side-wrap'); ?>
</section>