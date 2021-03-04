<?php 
$website = get_post_meta( get_the_ID(), 'fave_agency_web', true );

if( !empty( $website ) ) { ?>
	<li>
		<strong><?php esc_html_e('Website', 'houzez'); ?></strong> 
		<a target="_blank" href="<?php echo esc_url($website); ?>"><?php echo esc_attr( $website ); ?></a>
	</li>
<?php } ?>