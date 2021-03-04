<?php
global $post, $current_user, $ele_settings;
$return_array = houzez20_property_contact_form(false);
if(empty($return_array)) {
	return;
}
$hide_form_fields = houzez_option('hide_prop_contact_form_fields');
$terms_page_id = houzez_option('terms_condition');
$agent_display = houzez_get_listing_data('agent_display_option');
$property_id = houzez_get_listing_data('property_id');

$user_name = $user_email = '';
if(!houzez_is_admin()) {
	$user_name =  $current_user->display_name;
	$user_email =  $current_user->user_email;
}
$agent_email = is_email( $return_array['agent_email'] );


$action_class = "houzez-send-message";
$login_class = '';
$dataModel = '';
if( !is_user_logged_in() ) {
	$action_class = '';
	$login_class = 'msg-login-required';
	$dataModel = 'data-toggle="modal" data-target="#login-register-form"';
}

//Elementor settings
$section_header = isset($ele_settings['section_header']) ? $ele_settings['section_header'] : true;
$section_title = isset($ele_settings['section_title']) && !empty($ele_settings['section_title']) ? $ele_settings['section_title'] : houzez_option('sps_contact_info', 'Contact Information');

if($agent_display != 'none') {
?>
<div class="property-contact-agent-wrap property-section-wrap" id="property-contact-agent-wrap">
	<div class="block-wrap">

		<?php if( $section_header ) {?>
		<div class="block-title-wrap d-flex justify-content-between align-items-center">
			<h2><?php echo esc_attr($section_title ); ?></h2>

			<?php if ( $return_array['is_single_agent'] == true && houzez_option('agent_view_listing') ) : ?>
			<a class="btn btn-primary btn-slim" href="<?php echo esc_url($return_array['link']); ?>" target="_blank"><?php echo houzez_option('spl_con_view_listings', 'View listings'); ?></a>
			<?php endif; ?>
		</div><!-- block-title-wrap -->
		<?php } ?>

		<div class="block-content-wrap">
			
			<?php 
			if(houzez_form_type()) {

				echo $return_array['agent_data']; ?>

				<div class="block-title-wrap">
					<h3><?php echo houzez_option('sps_propperty_enqry', 'Inquire About This Property'); ?></h3>
				</div>

				<?php
				if(!empty(houzez_option('contact_form_agent_bottom'))) {
					echo do_shortcode(houzez_option('contact_form_agent_bottom'));
				}
			} else { ?>

			<form method="post" action="#">

				<?php echo $return_array['agent_data']; ?>

				<div class="block-title-wrap">
					<h3><?php echo houzez_option('sps_propperty_enqry', 'Inquire About This Property'); ?></h3>
				</div>
			
				<div class="form_messages"></div>

				<div class="row">

					<?php if( $hide_form_fields['name'] != 1 ) { ?>
					<div class="col-md-6 col-sm-12">
						<div class="form-group">
							<label><?php echo houzez_option('spl_con_name', 'Name'); ?></label>
							<input class="form-control" name="name" placeholder="<?php echo houzez_option('spl_con_name_plac', 'Enter your name'); ?>" type="text">
						</div>
					</div><!-- col-md-6 col-sm-12 -->
					<?php } ?>

					<?php if( $hide_form_fields['phone'] != 1 ) { ?>
					<div class="col-md-6 col-sm-12">
						<div class="form-group">
							<label><?php echo houzez_option('spl_con_phone', 'Phone'); ?></label>
							<input class="form-control" name="mobile" placeholder="<?php echo houzez_option('spl_con_phone_plac', 'Enter your phone number'); ?>" type="text">
						</div>
					</div><!-- col-md-6 col-sm-12 -->
					<?php } ?>

					<div class="col-md-6 col-sm-12">
						<div class="form-group">
							<label><?php echo houzez_option('spl_con_email', 'Email'); ?></label>
							<input class="form-control" name="email" placeholder="<?php echo houzez_option('spl_con_email_plac', 'Enter your email address'); ?>" type="email">
						</div>
					</div><!-- col-md-6 col-sm-12 -->

					<?php if( $hide_form_fields['usertype'] != 1 ) { ?>	
					<div class="col-md-6 col-sm-12">
						<div class="form-group">
							<label><?php echo houzez_option('spl_con_usertype', "I'm a"); ?></label>
							<select name="user_type" class="selectpicker form-control bs-select-hidden" title="<?php echo houzez_option('spl_con_select', 'Select'); ?>">
								<?php if( houzez_option('spl_con_buyer') != "" ) { ?>
								<option value="buyer"><?php echo houzez_option('spl_con_buyer', "I'm a buyer"); ?></option>
								<?php } ?>

								<?php if( houzez_option('spl_con_tennant') != "" ) { ?>
								<option value="tennant"><?php echo houzez_option('spl_con_tennant', "I'm a tennant"); ?></option>
								<?php } ?>

								<?php if( houzez_option('spl_con_agent') != "" ) { ?>
								<option value="agent"><?php echo houzez_option('spl_con_agent', "I'm an agent"); ?></option>
								<?php } ?>

								<?php if( houzez_option('spl_con_other') != "" ) { ?>
								<option value="other"><?php echo houzez_option('spl_con_other', 'Other'); ?></option>
								<?php } ?>
							</select><!-- selectpicker -->
						</div>
					</div><!-- col-md-6 col-sm-12 -->
					<?php } ?>

					<?php if( $hide_form_fields['message'] != 1 ) { ?>	
					<div class="col-sm-12 col-xs-12">
						<div class="form-group form-group-textarea">
							<label><?php echo houzez_option('spl_con_message', 'Message'); ?></label>
							<textarea class="form-control hz-form-message" name="message" rows="5" placeholder="<?php echo houzez_option('spl_con_message_plac', 'Message'); ?>"><?php echo houzez_option('spl_con_interested', "Hello, I am interested in"); ?> [<?php echo get_the_title(); ?>]</textarea>
						</div>
					</div><!-- col-sm-12 col-xs-12 -->
					<?php } ?>

					<?php if( houzez_option('gdpr_and_terms_checkbox', 1) ) { ?>
					<div class="col-sm-12 col-xs-12">
						<div class="form-group">
							<label class="control control--checkbox m-0 hz-terms-of-use">
								<input type="checkbox" name="privacy_policy"><?php echo houzez_option('spl_sub_agree', 'By submitting this form I agree to'); ?> <a target="_blank" href="<?php echo esc_url(get_permalink($terms_page_id)); ?>"><?php echo houzez_option('spl_term', 'Terms of Use'); ?></a>
								<span class="control__indicator"></span>
							</label>
						</div><!-- form-group -->
					</div>
					<?php } ?>

					<div class="col-sm-12 col-xs-12">
						<?php if ( $return_array['is_single_agent'] == true ) : ?>
				            <input type="hidden" name="target_email" value="<?php echo antispambot($agent_email); ?>">
				        <?php endif; ?>
				        <input type="hidden" name="property_agent_contact_security" value="<?php echo wp_create_nonce('property_agent_contact_nonce'); ?>"/>
				        <input type="hidden" name="property_permalink" value="<?php echo esc_url(get_permalink($post->ID)); ?>"/>
				        <input type="hidden" name="property_title" value="<?php echo esc_attr(get_the_title($post->ID)); ?>"/>
				        <input type="hidden" name="property_id" value="<?php echo esc_attr($property_id); ?>"/>
				        <input type="hidden" name="action" value="houzez_property_agent_contact">
				        <input type="hidden" class="is_bottom" value="bottom">
				        <input type="hidden" name="listing_id" value="<?php echo intval($post->ID)?>">
				        <input type="hidden" name="is_listing_form" value="yes">
				        <input type="hidden" name="agent_id" value="<?php echo intval($return_array['agent_id'])?>">
				        <input type="hidden" name="agent_type" value="<?php echo esc_attr($return_array['agent_type'])?>">

				        <?php get_template_part('template-parts/google', 'reCaptcha'); ?>

						<button class="houzez_agent_property_form btn btn-secondary btn-sm-full-width">
							<?php get_template_part('template-parts/loader'); ?>
							<?php echo houzez_option('spl_btn_request_info', 'Request Information'); ?>		
						</button>

						<?php if( $return_array['is_single_agent'] == true && houzez_option('agent_direct_messages', 0) ) { ?>
						<button type="button" <?php echo $dataModel; ?> class="<?php echo esc_attr($action_class).' '.esc_attr($login_class); ?> btn btn-secondary-outlined btn-sm-full-width">
							<?php get_template_part('template-parts/loader'); ?>
							<?php echo houzez_option('spl_btn_message', 'Send Message'); ?>		
						</button>
						<?php } ?>
						
					</div><!-- col-sm-12 col-xs-12 -->
				</div><!-- row -->
			</form>
			<?php } ?>
			
		</div><!-- block-content-wrap -->
	</div><!-- block-wrap -->
</div><!-- property-schedule-tour-wrap -->
<?php } ?>