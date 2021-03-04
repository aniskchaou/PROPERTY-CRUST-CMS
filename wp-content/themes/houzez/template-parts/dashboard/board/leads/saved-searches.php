<?php
global $houzez_search_data;
$searches = Houzez_Leads::get_lead_saved_searches();
if(!empty($searches['data']['results'])) { ?>

<div class="d-flex justify-content-between mb-3">
    <div><?php echo esc_attr($searches['data']['total_records']); ?> <?php esc_html_e('Records Found', 'houzez'); ?></div>   
</div>
<table class="dashboard-table table-lined table-hover responsive-table">
    <thead>
        <tr>
            <th><?php esc_html_e('Search Parameters', 'houzez'); ?></th>
            <th></th>
            <th><?php esc_html_e('Date', 'houzez'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($searches['data']['results'] as $houzez_search_data) {
            
            get_template_part( 'template-parts/dashboard/board/leads/saved-search-item' );
        }?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3">
                <?php get_template_part('template-parts/dashboard/board/records-html'); ?>
            </td>
            <td class="text-right no-wrap">
                <div class="crm-pagination">
                    <?php
                    echo paginate_links( array(
                        'base' => add_query_arg( 'cpage', '%#%' ),
                        'format' => '',
                        'prev_text' => __('&laquo;'),
                        'next_text' => __('&raquo;'),
                        'total' => ceil($searches['data']['total_records'] / $searches['data']['items_per_page']),
                        'current' => $searches['data']['page']
                    ));
                    ?>
                </div>
            </td>
        </tr>
    </tfoot>
</table><!-- dashboard-table -->
<?php
} else {?>
    <div class="d-flex justify-content-between">
        <div><?php esc_html_e('No record found.', 'houzez'); ?></div>    
    </div>
<?php } ?>