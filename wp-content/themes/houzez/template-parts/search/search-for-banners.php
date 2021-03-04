<?php
$splash_v1_dropdown = houzez_option('splash_v1_dropdown');
$banner_search = get_post_meta( $post->ID, 'fave_page_header_search', true );
$radius_unit = houzez_option('radius_unit');
$enable_radius_search = houzez_option('banner_radius_search', 0);
$selected_radius = houzez_option('houzez_default_radius');
$checked = true;

$search_tabs = houzez_option('banner_search_tabs', 0);
if(isset($_GET['banner_search_tabs'])) {
	$search_tabs = $_GET['banner_search_tabs'];
}

if(houzez_is_splash()) {
	$banner_search = houzez_option('splash_search');
}

if( $splash_v1_dropdown == 'property_status' ) {
    $field_name = 'status';
} else if ( $splash_v1_dropdown == 'property_type' ) {
    $field_name = 'type';
} else if ( $splash_v1_dropdown == 'property_area' ) {
    $field_name = 'areas';
} else if ( $splash_v1_dropdown == 'property_state' ) {
    $field_name = 'state';
} else if ( $splash_v1_dropdown == 'property_country' ) {
    $field_name = 'country';
} else {
    $field_name = 'city';
}

if($banner_search) { ?>
<form class="houzez-search-form-js" method="get" autocomplete="off" action="<?php echo esc_url( houzez_get_search_template_link() ); ?>">
	
	<?php 
	if( $search_tabs != 0 ) {
		get_template_part('template-parts/search/fields/status-tabs');
	}
	?>

	<div class="search-banner-wrap">
		
		<div class="d-flex flex-sm-max-column">
			
			<div class="flex-search">
				<?php get_template_part('template-parts/search/fields/'.$field_name); ?>
			</div>	

			<?php if($enable_radius_search) { ?>
				<div class="flex-grow-1 flex-search">
					<?php get_template_part('template-parts/search/fields/geolocation', 'banner'); ?>
				</div>
				<div class="flex-search">
					<?php get_template_part('template-parts/search/fields/distance'); ?>
				</div>
			<?php } else { ?>
				<div class="flex-grow-1 flex-search">
					<?php get_template_part('template-parts/search/fields/keyword', 'banner'); ?>
				</div>
			<?php } ?>

			
			<div class="flex-search">
				<?php get_template_part('template-parts/search/fields/submit-button'); ?>
			</div>
		</div>
		
	</div>
</form>
<?php } ?>