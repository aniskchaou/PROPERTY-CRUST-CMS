<?php 
global $houzez_local;
$languages = get_post_meta( get_the_ID(), 'fave_agency_language', true );

if( !empty( $languages ) ) { ?>
	<p>
		<i class="houzez-icon icon-messages-bubble mr-1"></i>
		<strong><?php echo $houzez_local['languages']; ?>:</strong> 
		<?php echo esc_attr( $languages ); ?>
	</p>
<?php } ?>