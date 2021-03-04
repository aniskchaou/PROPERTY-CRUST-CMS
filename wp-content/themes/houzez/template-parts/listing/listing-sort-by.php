<?php
global $post;

$sortby = '';
if( isset( $_GET['sortby'] ) ) {
    $sortby = $_GET['sortby'];
}
$sort_id = 'sort_properties';
if(houzez_is_half_map()) {
	$sort_id = 'ajax_sort_properties';
}
?>
<div class="sort-by">
	<div class="d-flex align-items-center">
		<div class="sort-by-title">
			<?php esc_html_e( 'Sort by:', 'houzez' ); ?>
		</div><!-- sort-by-title -->  
		<select id="<?php echo esc_attr($sort_id); ?>" class="selectpicker form-control bs-select-hidden" title="<?php esc_html_e( 'Default Order', 'houzez' ); ?>" data-live-search="false" data-dropdown-align-right="auto">
			<option value=""><?php esc_html_e( 'Default Order', 'houzez' ); ?></option>
			<option <?php selected($sortby, 'a_price'); ?> value="a_price"><?php esc_html_e('Price - Low to High', 'houzez'); ?></option>
            <option <?php selected($sortby, 'd_price'); ?> value="d_price"><?php esc_html_e('Price - High to Low', 'houzez'); ?></option>
            
            <option <?php selected($sortby, 'featured_first'); ?> value="featured_first"><?php esc_html_e('Featured Listings First', 'houzez'); ?></option>
            
            <option <?php selected($sortby, 'a_date'); ?> value="a_date"><?php esc_html_e('Date - Old to New', 'houzez' ); ?></option>
            <option <?php selected($sortby, 'd_date'); ?> value="d_date"><?php esc_html_e('Date - New to Old', 'houzez' ); ?></option>
		</select><!-- selectpicker -->
	</div><!-- d-flex -->
</div><!-- sort-by -->