<?php
$attachments = get_post_meta(get_the_ID(), 'fave_attachments', false);
$documents_download = houzez_option('documents_download');
?>
<div class="property-description-wrap property-section-wrap" id="property-description-wrap">
	<div class="block-wrap">
		<div class="block-title-wrap">
			<h2><?php echo houzez_option('sps_description', 'Description'); ?></h2>	
		</div>
		<div class="block-content-wrap">
			<?php the_content(); ?>

			<?php 
			if(!empty($attachments) && $attachments[0] != "" ) { ?>
				<div class="block-title-wrap block-title-property-doc">
					<h3><?php echo houzez_option('sps_documents', 'Property Documents'); ?></h3>
				</div>

				<?php 
				foreach( $attachments as $attachment_id ) {
					$attachment_meta = houzez_get_attachment_metadata($attachment_id); 

					if(!empty($attachment_meta )) {
					?>
					<div class="property-documents">
						<div class="d-flex justify-content-between">
							<div class="property-document-title">
								<i class="houzez-icon icon-task-list-plain-1 mr-1"></i> <?php echo esc_attr( $attachment_meta->post_title ); ?>
							</div>
							<div class="property-document-link login-link">
								
								<?php if( $documents_download == 1 ) {
				                    if( is_user_logged_in() ) { ?>
				                    <a href="<?php echo esc_url( $attachment_meta->guid ); ?>" target="_blank"><?php esc_html_e( 'Download', 'houzez' ); ?></a>
				                    <?php } else { ?>
				                        <a href="#" data-toggle="modal" data-target="#login-register-form"><?php esc_html_e( 'Download', 'houzez' ); ?></a>
				                    <?php } ?>
				                <?php } else { ?>
				                    <a href="<?php echo esc_url( $attachment_meta->guid ); ?>" target="_blank"><?php esc_html_e( 'Download', 'houzez' ); ?></a>
				                <?php } ?>
							</div>
						</div>
					</div>
				<?php } }?>
				
			<?php } ?>
		</div>
	</div>
</div>