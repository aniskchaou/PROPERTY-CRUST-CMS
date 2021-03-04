<?php 
global $houzez_local;
$agency_fax = get_post_meta( get_the_ID(), 'fave_agency_fax', true );
$agency_fax_call = str_replace(array('(',')',' ','-'),'', $agency_fax);

if( !empty( $agency_fax ) ) { ?>
	<li>
		<strong><?php echo $houzez_local['fax_colon']; ?></strong> 
		<a href="fax:<?php echo esc_attr($agency_fax_call); ?>">
			<span><?php echo esc_attr( $agency_fax ); ?></span>
		</a>
	</li>
<?php } ?>