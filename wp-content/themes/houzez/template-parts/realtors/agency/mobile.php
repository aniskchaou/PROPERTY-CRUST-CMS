<?php 
global $houzez_local;
$agency_mobile = get_post_meta( get_the_ID(), 'fave_agency_mobile', true );
$agency_mobile_call = str_replace(array('(',')',' ','-'),'', $agency_mobile);
if( !empty( $agency_mobile ) ) { ?>
	<li>
		<strong><?php echo $houzez_local['mobile_colon']; ?></strong> 
		<a href="tel:<?php echo esc_attr($agency_mobile_call); ?>">
			<span class="agent-phone <?php houzez_show_phone(); ?>"><?php echo esc_attr( $agency_mobile ); ?></span>
		</a>
	</li>
<?php } ?>