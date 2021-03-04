<?php
global $post;

if(houzez_form_type()) {

    if(!empty(houzez_option('schedule_tour_shortcode'))) {
        echo do_shortcode(houzez_option('schedule_tour_shortcode'));
    }

} else {

$return_array = houzez20_property_contact_form();
if(empty($return_array)) {
    return;
}
$houzez_agent_display = get_post_meta( get_the_ID(), 'fave_agent_display_option', true );
$prop_agent_display = get_post_meta( get_the_ID(), 'fave_agents', true );
$schedule_time_slots = houzez_option('schedule_time_slots');
$is_single_agent = true;
$terms_page_id = houzez_option('terms_condition');

if( $prop_agent_display != '-1' && $houzez_agent_display == 'agent_info' ) {

    $prop_agent_ids = get_post_meta( get_the_ID(), 'fave_agents' );
    $prop_agent_ids = array_filter( $prop_agent_ids, function($hz){
        return ( $hz > 0 );
    });

    $prop_agent_ids = array_unique( $prop_agent_ids );

    $agents_count = count( $prop_agent_ids );

    if ( $agents_count > 1 ) :
        $is_single_agent = false;
    endif;

    foreach ( $prop_agent_ids as $agent ) :

        if ( 0 < intval( $agent ) ) :

            $prop_agent_id = intval( $agent );
            $prop_agent_email = get_post_meta( $prop_agent_id, 'fave_agent_email', true );

        endif;

    endforeach;

} elseif( $houzez_agent_display == 'agency_info' ) {

    $prop_agent_id = get_post_meta( get_the_ID(), 'fave_property_agency', true );
    $prop_agent_email = get_post_meta( $prop_agent_id, 'fave_agency_email', true );

} else {

    $prop_agent_email = get_the_author_meta( 'email' );
}

$agent_email = is_email($prop_agent_email);
?>
<form method="post" action="#">
    <input type="hidden" name="schedule_contact_form_ajax"
       value="<?php echo wp_create_nonce('schedule-contact-form-nonce'); ?>"/>
    <input type="hidden" name="property_permalink"
           value="<?php echo esc_url(get_permalink($post->ID)); ?>"/>
    <input type="hidden" name="property_title"
           value="<?php echo esc_attr(get_the_title($post->ID)); ?>"/>
    <input type="hidden" name="action" value="houzez_schedule_send_message">

    <input type="hidden" name="listing_id" value="<?php echo intval($post->ID)?>">
    <input type="hidden" name="is_listing_form" value="yes">
    <input type="hidden" name="is_schedule_form" value="yes">
    <input type="hidden" name="agent_id" value="<?php echo intval($return_array['agent_id'])?>">
    <input type="hidden" name="agent_type" value="<?php echo esc_attr($return_array['agent_type'])?>">

    <input type="hidden" name="target_email" value="<?php echo antispambot($agent_email); ?>">
    
    <div class="row">
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label><?php echo houzez_option('spl_con_tour_type', 'Tour Type'); ?></label>
                <select name="schedule_tour_type" class="selectpicker form-control bs-select-hidden" title="<?php echo houzez_option('spl_con_select', 'Select'); ?>" data-live-search="false">
                    <option value="<?php echo houzez_option('spl_con_in_person', 'In Person'); ?>"><?php echo houzez_option('spl_con_in_person', 'In Person'); ?></option>
                    <option value="<?php echo houzez_option('spl_con_video_chat', 'Video Chat'); ?>"><?php echo houzez_option('spl_con_video_chat', 'Video Chat'); ?></option>
                </select><!-- selectpicker -->
            </div>
        </div><!-- col-md-4 col-sm-12 -->
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label><?php echo houzez_option('spl_con_date', 'Date'); ?></label>
                <input name="schedule_date" class="form-control db_input_date" placeholder="<?php echo houzez_option('spl_con_date_plac', 'Select tour date'); ?>" type="text">
            </div>
        </div><!-- col-md-6 col-sm-12 -->
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label><?php echo houzez_option('spl_con_time', 'Time'); ?></label>
                <select name="schedule_time" class="selectpicker form-control bs-select-hidden">
                    <?php 
                    $time_slots = explode(',', $schedule_time_slots); 
                    foreach ($time_slots as $time) {
                        echo '<option value="'.trim($time).'">'.esc_attr($time).'</option>';
                    }
                    ?>    
                </select>
            </div>
        </div><!-- col-md-6 col-sm-12 -->
    </div><!-- row -->
    <div class="block-title-wrap">
        <h3><?php echo houzez_option('sps_your_info', 'Your information'); ?></h3>
    </div><!-- block-title-wrap -->
    
    <div class="row">
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label><?php echo houzez_option('spl_con_name', 'Name'); ?></label>
                <input class="form-control" name="name" placeholder="<?php echo houzez_option('spl_con_name_plac', 'Enter your name'); ?>" type="text">
            </div>
        </div><!-- col-md-4 col-sm-12 -->
        <div class="col-md-4 col-sm-12">
            <div class="form-group"> 
                <label><?php echo houzez_option('spl_con_phone', 'Phone'); ?></label>
                <input class="form-control" name="phone" placeholder="<?php echo houzez_option('spl_con_phone_plac', 'Enter your phone'); ?>" type="text">
            </div>
        </div><!-- col-md-4 col-sm-12 -->
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label><?php echo houzez_option('spl_con_email', 'Email'); ?></label>
                <input class="form-control" name="email" placeholder="<?php echo houzez_option('spl_con_email_plac', 'Enter your email address'); ?>" type="email">
            </div>
        </div><!-- col-md-4 col-sm-12 -->
        <div class="col-sm-12 col-xs-12">
            <div class="form-group form-group-textarea">
                <label><?php echo houzez_option('spl_con_message', 'Message'); ?></label>
                <textarea class="form-control" name="message" rows="5" placeholder="<?php echo houzez_option('spl_con_message_plac', 'Message'); ?>"></textarea>
            </div>
        </div><!-- col-sm-12 col-xs-12 -->

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
            <button class="schedule_contact_form btn btn-secondary btn-sm-full-width">
                <?php get_template_part('template-parts/loader'); ?>
                <?php echo houzez_option('spl_btn_tour_sch', 'Submit a Tour Request'); ?> 
            </button>
        </div><!-- col-sm-12 col-xs-12 -->
        
    </div><!-- row -->
    <div class="form_messages mt-4"></div>
</form>
<?php } ?>