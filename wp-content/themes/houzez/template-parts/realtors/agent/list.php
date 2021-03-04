<?php
global $houzez_local;
$agent_position = get_post_meta( get_the_ID(), 'fave_agent_position', true );
$agent_company = get_post_meta( get_the_ID(), 'fave_agent_company', true );
?>
<div class="agent-list-wrap">
	<div class="d-flex">
		
		<div class="agent-list-image">
			<a href="<?php the_permalink(); ?>">
				<?php get_template_part('template-parts/realtors/agent/image'); ?>
			</a>
		</div>
		
		<div class="agent-list-content flex-grow-1">
			<div class="d-flex xxs-column">
				<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				<?php 
				if( houzez_option( 'agent_review', 0 ) != 0 ) { 
					get_template_part('template-parts/realtors/rating'); 
				}?>
			</div>
			
			<?php get_template_part('template-parts/realtors/agent/position'); ?>

			<ul class="agent-list-contact list-unstyled">
				
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
				?>
			</ul>

			<div class="d-flex sm-column">
				<div class="agent-social-media flex-grow-1">
					<?php 
					if( houzez_option('agent_social', 1) ) {
						get_template_part('template-parts/realtors/agent/social'); 
					}?>
				</div>
				<a class="agent-list-link" href="<?php the_permalink(); ?>"><strong><?php echo $houzez_local['view_my_prop']; ?></strong></a>
			</div>
			
		</div>
	</div>
</div>