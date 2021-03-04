<?php 
if(houzez_option('area_switcher_enable') ) { 

	$current_area = houzez_get_current_area();
	if( $current_area == "sqft" ) {
	    $current_area_menu = esc_html__( 'Square Feet', 'houzez' );
	} else {
	    $current_area_menu = esc_html__( 'Square Meters', 'houzez' );
	}
	?>
	<div class="switcher-wrap area-switcher-wrap">
		<button class="btn dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
			<span><?php echo $current_area_menu; ?></span>
		</button>
		<ul id="area-switcher-list-js" class="dropdown-menu" aria-labelledby="dropdown">
			<li data-area-code="sqft"><?php esc_html_e( 'Square Feet', 'houzez' ); ?></li>
        	<li data-area-code="sq_meter"><?php esc_html_e( 'Square Meters', 'houzez' ); ?></li>
		</ul>
		<input type="hidden" id="houzez-switch-to-area" value="<?php echo esc_attr($current_area);?>" />
	</div>

<?php 
} ?>