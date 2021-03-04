<div class="agent-list-wrap">
	<div class="d-flex">
		<div class="agent-list-image">
			<a href="<?php the_permalink(); ?>">
				<?php get_template_part('template-parts/realtors/agency/image'); ?>
			</a>
		</div>

		<div class="agent-list-content flex-grow-1">
			<div class="d-flex xxs-column">
				<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				
				<?php 
                if( houzez_option( 'agency_review', 0 ) != 0 ) {
                    get_template_part('template-parts/realtors/rating'); 
                }?>
			</div>
			
			<?php 
			if( houzez_option('agency_address', 1) ) {
				get_template_part('template-parts/realtors/agency/address'); 
			}?>

			<ul class="agent-list-contact list-unstyled">
				
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
				?>
			</ul>

			<div class="d-flex sm-column">
				<div class="agent-social-media flex-grow-1">
					<?php 
					if( houzez_option('agency_social', 1) ) {
						get_template_part('template-parts/realtors/agency/social'); 
					}?>
				</div>
				<a class="agent-list-link" href="<?php the_permalink(); ?>"><strong><?php esc_html_e('View Listings', 'houzez'); ?></strong></a>
			</div>

		</div>
	</div>
</div>