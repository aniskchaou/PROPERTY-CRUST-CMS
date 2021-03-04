<?php
global $enquiry, $lead;
$temp_array = array();
$first_name = $last_name = '';
if(isset($_GET['enquiry'])) {
	$dashboard_crm = houzez_get_template_link_2('template/user_dashboard_crm.php');

	$meta = maybe_unserialize($enquiry->enquiry_meta);
	$message = $enquiry->message;
	$private_note = $enquiry->private_note;

	$display_name = $lead->display_name;
	$first_name = $lead->first_name;
	$last_name = $lead->last_name;

	if(empty($display_name)) {
		$display_name = $first_name.' '.$last_name;
	}

	$lead_link = add_query_arg(
        array(
            'hpage' => 'lead-detail',
            'lead-id' => $enquiry->lead_id,
            'tab' => 'enquires',
        ), $dashboard_crm
    );
	
} 

if( !empty($enquiry) ) :
?>
<div class="lead-detail-wrap">
	<h2><?php esc_html_e('Inquiry Detail', 'houzez'); ?></h2>
	<a class="edit_enquiry_js label primary-label edit-lead-detail open-close-slide-panel" href="#" data-id="<?php echo intval($enquiry->enquiry_id);?>">
		<?php esc_html_e('Edit', 'houzez'); ?>
	</a>
	<ul class="list-unstyled mb-5">
		<li>
			<strong><?php esc_html_e('Contact', 'houzez'); ?></strong><br>
			<a href="<?php echo esc_url($lead_link); ?>"><strong><?php echo esc_attr($display_name); ?></strong></a>
		</li>
		<li>
			<strong><?php esc_html_e('Inquiry Type', 'houzez'); ?></strong><br>
			<?php 
			if( !empty($enquiry->enquiry_type) ) {
				echo esc_attr($enquiry->enquiry_type);
			} else {
				echo '-'; 
			} ?>
		</li>
		<li>
			<strong><?php esc_html_e('Property Type', 'houzez'); ?></strong><br>
			<?php 
            if(isset($meta['property_type']['name'])) {
                echo esc_attr($meta['property_type']['name']); 
            }?>
		</li>
		<li>
			<strong><?php esc_html_e('Price', 'houzez'); ?></strong><br>
			<?php 
            if(isset($meta['min_price'])) {
                echo esc_attr($meta['min_price']); 
            }

            if(isset($meta['max_price'])) {
                echo ' - '.esc_attr($meta['max_price']); 
            }?>
		</li>
		<li>
			<strong><?php esc_html_e('Bedrooms', 'houzez'); ?></strong><br>
			<?php 
            if(isset($meta['min_beds'])) {
                echo esc_attr($meta['min_beds']); 
            }

            if(isset($meta['max_beds'])) {
                echo ' - '.esc_attr($meta['max_beds']); 
            }?>
		</li>
		<li>
			<strong><?php esc_html_e('Bathrooms', 'houzez'); ?></strong><br>
			<?php 
            if(isset($meta['min_baths'])) {
                echo esc_attr($meta['min_baths']); 
            }

            if(isset($meta['max_baths'])) {
                echo ' - '.esc_attr($meta['max_baths']); 
            }?>
		</li>
		<li>
			<strong><?php esc_html_e('Area', 'houzez'); ?></strong><br>
			<?php 
            if(isset($meta['min_area'])) {
                echo esc_attr($meta['min_area']); 
            }

            if(isset($meta['max_area'])) {
                echo ' - '.esc_attr($meta['max_area']); 
            }?>
		</li>
		<li>
			<strong><?php esc_html_e('Location', 'houzez'); ?></strong><br>
			<?php
			if(isset($meta['country']['name'])) {
                $temp_array[] = esc_attr($meta['country']['name']); 
            }

            if(isset($meta['state']['name'])) {
                $temp_array[] = esc_attr($meta['state']['name']); 
            }

            if(isset($meta['city']['name'])) {
                $temp_array[] = esc_attr($meta['city']['name']); 
            }

            if(isset($meta['area']['name'])) {
                $temp_array[] = esc_attr($meta['area']['name']); 
            }

            if(isset($meta['zipcode'])) {
               $temp_array[] = esc_attr($meta['zipcode']); 
            }

            $location = join( ", ", $temp_array );
            echo esc_attr($location);
			?>
		</li>

		<?php if(!empty($message)) { ?>
		<li>
			<strong><?php esc_html_e('Message', 'houzez'); ?></strong><br>
			<?php echo esc_attr($message); ?>
		</li>
		<?php } ?>

		<?php if(!empty($private_note)) { ?>
		<li>
			<strong><?php esc_html_e('Private Note', 'houzez'); ?></strong><br>
			<?php echo esc_attr($private_note); ?>
		</li>
		<?php } ?>

	</ul>
	
</div><!-- lead-detail-wrap -->
<?php endif; ?>