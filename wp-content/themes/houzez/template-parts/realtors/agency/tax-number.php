<?php 
global $houzez_local;
$agency_tax_no = get_post_meta( get_the_ID(), 'fave_agency_tax_no', true );

if( !empty( $agency_tax_no ) ) { ?>
	<li>
		<strong><?php echo $houzez_local['tax_number']; ?>:</strong> 
		<?php echo esc_attr( $agency_tax_no ); ?>
	</li>
<?php } ?>