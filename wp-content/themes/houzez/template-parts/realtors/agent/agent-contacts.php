<?php
$agent_address = get_post_meta( get_the_ID(), 'fave_agent_address', true );
?>
<div class="agent-contacts-wrap">
	<h3 class="widget-title"><?php esc_html_e('Contact', 'houzez'); ?></h3>
	<div class="agent-map">
		<?php get_template_part('template-parts/realtors/agent/image'); ?>
		<?php get_template_part('template-parts/realtors/agent/address'); ?>
	</div>
	<ul class="list-unstyled">
		<?php 
		if( houzez_option('agent_phone', 1) ) {
			get_template_part('template-parts/realtors/agent/office-phone'); 
		} 

		if( houzez_option('agent_mobile', 1) ) {
			get_template_part('template-parts/realtors/agent/mobile'); 
		}

		if( houzez_option('agent_fax', 1) ) {
			get_template_part('template-parts/realtors/agent/fax'); 
		} 

		if( houzez_option('agent_email', 1) ) {
			get_template_part('template-parts/realtors/agent/email'); 
		}

		if( houzez_option('agent_website', 1) ) {
		 	get_template_part('template-parts/realtors/agent/website'); 
		}
		?>
	</ul>

	<?php if( houzez_option('agent_social', 1) ) { ?>
	<p><?php printf( esc_html__( 'Find %s on', 'houzez' ) , get_the_title() ); ?>:</p>
	<div class="agent-social-media">
		<?php get_template_part('template-parts/realtors/agent/social'); ?>
	</div><!-- agent-social-media -->
	<?php } ?>
</div><!-- agent-bio-wrap -->