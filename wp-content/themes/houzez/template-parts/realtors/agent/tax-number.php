<?php 
global $houzez_local;
$agent_tax_no = get_post_meta( get_the_ID(), 'fave_agent_tax_no', true );

if( !empty( $agent_tax_no ) ) { ?>
	<li>
		<strong><?php echo $houzez_local['tax_number']; ?>:</strong> 
		<?php echo esc_attr( $agent_tax_no ); ?>
	</li>
<?php } ?>