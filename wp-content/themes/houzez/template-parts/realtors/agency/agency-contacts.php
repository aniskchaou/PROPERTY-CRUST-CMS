<div class="agent-contacts-wrap">
	<h3 class="widget-title"><?php esc_html_e('Contact', 'houzez'); ?></h3>
	<div class="agent-map">
		<?php get_template_part('template-parts/realtors/agency/image'); ?>
		<?php 
		if( houzez_option('agency_address', 1) ) {
			get_template_part('template-parts/realtors/agency/address'); 
		}?>
	</div>
	<ul class="list-unstyled">

		<?php 
		if( houzez_option('agency_phone', 1) ) {
			get_template_part('template-parts/realtors/agency/office-phone');
		} 

		if( houzez_option('agency_mobile', 1) ) {
			get_template_part('template-parts/realtors/agency/mobile'); 
		}

		if( houzez_option('agency_fax', 1) ) {
			get_template_part('template-parts/realtors/agency/fax');
		} 

		if( houzez_option('agency_email', 1) ) {
			get_template_part('template-parts/realtors/agency/email'); 
		}
		if( houzez_option('agent_website', 1) ) {
			get_template_part('template-parts/realtors/agency/website'); 
		}?>
	</ul>

	<?php if( houzez_option('agency_social', 1) ) { ?>
	<p><?php printf( esc_html__( 'Find %s on', 'houzez' ) , get_the_title() ); ?>:</p>
	<div class="agent-social-media">
		<?php get_template_part('template-parts/realtors/agency/social'); ?>
	</div><!-- agent-social-media -->
	<?php } ?>

</div><!-- agent-bio-wrap -->