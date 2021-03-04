<?php $total = isset($_GET['records']) ? $_GET['records'] : 10; ?>
<label class="mr-2"><?php esc_html_e('Items per page', 'houzez'); ?></label>
<select id="crm-records-per-page" class="selectpicker form-control bs-select-hidden table-select-auto" title="10" data-live-search="false" data-dropdown-align-right="auto">
    <option <?php selected( $total, 10, true ); ?> value="10">10</option>
    <option <?php selected( $total, 20, true ); ?> value="20">20</option>
    <option <?php selected( $total, 30, true ); ?> value="30">30</option>
    <option <?php selected( $total, 40, true ); ?> value="40">40</option>
    <option <?php selected( $total, 50, true ); ?> value="50">50</option>
</select><!-- selectpicker -->