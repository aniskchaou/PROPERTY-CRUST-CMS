<?php
$agent_array = houzez20_property_contact_form();
$agent_name = isset($agent_array['agent_name']) ? $agent_array['agent_name'] : '';
$agent_mobile_call = isset($agent_array['agent_mobile_call']) ? $agent_array['agent_mobile_call'] : '';
$agent_whatsapp_call = isset($agent_array['agent_whatsapp_call']) ? $agent_array['agent_whatsapp_call'] : '';
$agent_display = houzez_get_listing_data('agent_display_option');

$agent_number_call = isset($agent_array['agent_mobile_call']) ? $agent_array['agent_mobile_call'] : '';
if( empty($agent_number_call) ) {
	$agent_number_call = isset($agent_array['agent_phone_call']) ? $agent_array['agent_phone_call'] : '';
}

if ($agent_display != 'none') { ?>
<div class="mobile-property-contact visible-on-mobile">
	<div class="d-flex justify-content-between">
		<div class="agent-details flex-grow-1">
			<div class="d-flex align-items-center">
				<div class="agent-image">
					<img class="rounded" src="<?php echo esc_url($agent_array['picture']); ?>" width="50" height="50" alt="<?php echo esc_attr($agent_name); ?>">
				</div>
				<ul class="agent-information list-unstyled">
					<li class="agent-name">
						<?php echo esc_attr($agent_name); ?>
					</li>
				</ul>
			</div><!-- d-flex -->
		</div><!-- agent-details -->
		<button class="btn btn-secondary" data-toggle="modal" data-target="#mobile-property-form">
			<i class="houzez-icon icon-messages-bubble"></i>
		</button>

		<?php if( !empty( $agent_whatsapp_call ) && houzez_option('agent_whatsapp_num', 1) ) { ?>
		<a href="https://api.whatsapp.com/send?phone=<?php echo esc_attr( $agent_whatsapp_call ); ?>&text=<?php echo houzez_option('spl_con_interested', "Hello, I am interested in").' ['.get_the_title().'] '.get_permalink(); ?> " class="btn btn-secondary-outlined"><i class="houzez-icon icon-messaging-whatsapp mr-1"></i></a>
		<?php } ?>
		
		<?php if( ! empty($agent_number_call) && houzez_option('agent_mobile_num', 1) ) { ?>
		<a class="btn btn-secondary-outlined" href="tel:<?php echo esc_attr($agent_number_call); ?>">
	         <i class="houzez-icon icon-phone"></i>
	     </a>
	 	<?php } ?>
		
	</div><!-- d-flex -->
</div><!-- mobile-property-contact -->

<div class="modal fade mobile-property-form" id="mobile-property-form">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<div class="modal-body">
				<?php get_template_part('property-details/agent-form'); ?>
			</div>
		</div>
	</div>
</div>
<?php } ?>