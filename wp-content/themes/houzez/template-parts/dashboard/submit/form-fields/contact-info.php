<?php 
global $houzez_local, $prop_meta_data; 
$agents_posts = get_posts(array('post_type' => 'houzez_agent', 'posts_per_page' => -1, 'suppress_filters' => 0));
$agency_posts = get_posts(array('post_type' => 'houzez_agency', 'posts_per_page' => -1, 'suppress_filters' => 0));
$agent_display_option = houzez_get_field_meta('agent_display_option');
$agents_array = isset($prop_meta_data['fave_agents']) ? $prop_meta_data['fave_agents'] : array();
$agencies_array = isset($prop_meta_data['fave_property_agency']) ? $prop_meta_data['fave_property_agency'] : array();

$agent_hidden_class = $agency_hidden_class = 'houzez-hidden';
if($agent_display_option == 'agent_info') {
	$agent_hidden_class = '';

} else if($agent_display_option == 'agency_info') {
	$agency_hidden_class = '';
}

if(empty($agent_display_option)) {
	$agent_display_option = 'author_info';
	if(houzez_is_agency()) {
		$agent_display_option = 'agency_info';
	}
}

$agency_info_text = houzez_option('cl_agency_info', 'Agency Info (Choose agency from the list below)');
if(houzez_is_agency()) {
	$agency_info_text = houzez_option('cl_agency_info2', 'Agency Info');
}

?>
<div class="form-group">

	<?php if ( ! houzez_is_agency() ) { ?>
	<label class="control control--checkbox ">
		<input <?php checked($agent_display_option, 'author_info', true); ?> type="radio" name="fave_agent_display_option" value="author_info"> <?php echo houzez_option('cl_author_info', 'Author Info'); ?>
		<span class="control__indicator"></span>
	</label>
	<?php  } ?>

	<label class="control control--checkbox">
		<input <?php checked($agent_display_option, 'agent_info', true); ?> type="radio" value="agent_info" name="fave_agent_display_option"> <?php echo houzez_option('cl_agent_info', 'Agent Info (Choose agent from the list below)'); ?>
		<span class="control__indicator"></span>
	</label>

	<div class="agents-dropdown <?php echo esc_attr($agent_hidden_class); ?> form-group ml-2 form-group col-sm-12 col-md-5">
		<select name="fave_agents[]" class="selectpicker form-control bs-select-hidden" title="<?php echo houzez_option('cl_agent_info_plac', 'Select an Agent'); ?>" data-live-search="true" data-selected-text-format="count > 2"  data-actions-box="false" multiple>
			<?php

			if ( houzez_is_agency() ) {
	            if (!empty($agents_posts)) {
	            	$i = 0;
	            	$output = '';
	            	$agency_id = get_user_meta(get_current_user_id(), 'fave_author_agency_id', true);
	                foreach ($agents_posts as $agent_post) {
	          	
	          			if( $agency_id == get_post_meta($agent_post->ID, 'fave_agent_agencies', true) ) {
		                    $output .= '<option ';

		                    if(houzez_edit_property()) {
		                    	if( in_array($agent_post->ID, $agents_array) ) {
		                    		$output .= ' selected';
		                    	}
		                    }

		                    $output .= ' value="'.$agent_post->ID.'">'.$agent_post->post_title.'</option>';
		                }

	                    $i++;
	                }

	                echo $output;
	            }
	        } else {

	        	if (!empty($agents_posts)) {
	            	$i = 0;
	            	$output = '';
	                foreach ($agents_posts as $agent_post) {
	          
	                    $output .= '<option ';

	                    if(houzez_edit_property()) {
	                    	if( in_array($agent_post->ID, $agents_array) ) {
	                    		$output .= ' selected';
	                    	}
	                    }

	                    $output .= ' value="'.$agent_post->ID.'">'.$agent_post->post_title.'</option>';

	                    $i++;
	                }

	                echo $output;
	            }

	        }
            ?>
		</select>
	</div>

	<label class="control control--checkbox">
		<input <?php checked($agent_display_option, 'agency_info', true); ?> type="radio" value="agency_info" name="fave_agent_display_option"> <?php echo $agency_info_text; ?>
		<span class="control__indicator"></span>
	</label>

	<?php if ( ! houzez_is_agency() ) { ?>
	<div class="agencies-dropdown <?php echo esc_attr($agency_hidden_class); ?> listform-group ml-2 form-group col-sm-12 col-md-5">
		<select name="fave_property_agency[]" class="selectpicker form-control bs-select-hidden" title="<?php echo houzez_option('cl_agency_info_plac', 'Select an Agency'); ?>" data-live-search="true" data-selected-text-format="count > 2"  data-actions-box="false" multiple>
            <?php
            if (!empty($agency_posts)) {
            	$i = 0;
            	$output = '';
                foreach ($agency_posts as $agency) {
          
                    $output .= '<option ';

                    if(houzez_edit_property()) {
                    	if( in_array($agency->ID, $agencies_array) ) {
                    		$output .= ' selected';
                    	}
                    }

                    $output .= ' value="'.$agency->ID.'">'.$agency->post_title.'</option>';

                    $i++;
                }

                echo $output;
            }
            ?>
		</select>
	</div>
	<?php } ?>

	<label class="control control--checkbox">
		<input <?php checked($agent_display_option, 'none', true); ?> type="radio" value="none" name="fave_agent_display_option"> <?php echo houzez_option('cl_not_display', 'Do not display'); ?>
		<span class="control__indicator"></span>
	</label>

</div>