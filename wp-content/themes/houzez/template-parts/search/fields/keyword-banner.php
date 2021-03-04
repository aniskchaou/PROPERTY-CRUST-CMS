<?php 
$keyword_field = houzez_option('keyword_field');
if( $keyword_field == 'prop_title' ) {
    $keyword_placeholder = houzez_option('srh_keyword', 'Enter Keyword...');

} else if( $keyword_field == 'prop_city_state_county' ) {
    $keyword_placeholder = houzez_option('srh_csa', 'Search City, State or Area');

} else if( $keyword_field == 'prop_address' ) {
    $keyword_placeholder = houzez_option('srh_address', 'Enter an address, town, street, zip or property ID');

} else {
    $keyword_placeholder = houzez_option('srh_keyword', 'Enter Keyword...');
}

$keyword = isset ( $_GET['keyword'] ) ? $_GET['keyword'] : ''; ?>
<div class="form-group">
	<div class="search-icon">
		<input name="keyword" type="text" data-type="banner" class="houzez-keyword-autocomplete form-control" value="<?php echo esc_attr($keyword); ?>" placeholder="<?php echo esc_attr($keyword_placeholder); ?>">
	</div><!-- search-icon -->
</div><!-- form-group -->