<?php
$lead = $first_name = $last_name = '';
if(isset($_GET['lead-id'])) {
	$lead = Houzez_Leads::get_lead($_GET['lead-id']);

	$prefix = $lead->prefix;
	$display_name = $lead->display_name;
	$first_name = $lead->first_name;
	$last_name = $lead->last_name;
	$email = $lead->email;
	$type = $lead->type;
	$mobile = $lead->mobile;
	$work_phone = $lead->work_phone;
	$home_phone = $lead->home_phone;
	$address = $lead->address;
	$country = $lead->country;
	$state = $lead->state;
	$city = $lead->city;
	$zipcode = $lead->zipcode;
	$enquiry_to = $lead->enquiry_to;
	$source = $lead->source;
	$source_link = $lead->source_link;
	$message = $lead->message;
	$enquiry_user_type = $lead->enquiry_user_type;

	$agent_info = houzezcrm_get_assigned_agent($enquiry_user_type, $enquiry_to);
	
} 

if( !empty($lead) ) :
?>
<div class="lead-detail-wrap">
	<h2><?php if($prefix) { echo $prefix.'.'; } echo esc_attr($display_name); ?></h2>

	<ul class="list-unstyled mb-5">
		<?php if(!empty($first_name)) { ?>
		<li>
			<strong><?php esc_html_e('First Name', 'houzez'); ?></strong><br>
			<?php echo esc_attr($first_name); ?>
		</li>
		<?php } ?>

		<?php if(!empty($last_name)) { ?>
		<li>
			<strong><?php esc_html_e('Last Name', 'houzez'); ?></strong><br>
			<?php echo esc_attr($last_name); ?>
		</li>
		<?php } ?>

		<li>
			<strong><?php esc_html_e('Email', 'houzez'); ?></strong><br>
			<a href="mailto:<?php echo esc_attr($email); ?>"><strong><?php echo esc_attr($email); ?></strong></a>
		</li>

		<?php if($type) { ?>
		<li>
			<strong><?php esc_html_e('Type', 'houzez'); ?></strong><br>
			<?php 
            $type = stripslashes($type);
            $type = htmlentities($type);
            echo esc_attr($type); ?>
		</li>
		<?php } ?>

		<?php if($message) { ?>
		<li>
			<strong><?php esc_html_e('Message', 'houzez'); ?></strong><br>
			<?php echo ($message); ?>
		</li>
		<?php } ?>
	</ul>
	<h2><?php esc_html_e('Details', 'houzez'); ?></h2>
	<ul class="list-unstyled mb-5">
		
		<?php if($address) { ?>
		<li>
			<strong><?php esc_html_e('Address', 'houzez'); ?></strong><br>
			<?php echo esc_attr($address); ?>
		</li>
		<?php } ?>

		<?php if($mobile) { ?>
		<li>
			<strong><?php esc_html_e('Mobile', 'houzez'); ?></strong><br>
			<?php echo esc_attr($mobile); ?>
		</li>
		<?php } ?>

		<?php if($home_phone) { ?>
		<li>
			<strong><?php esc_html_e('Home', 'houzez'); ?></strong><br>
			<?php echo esc_attr($home_phone); ?>
		</li>
		<?php } ?>

		<?php if($work_phone) { ?>
		<li>
			<strong><?php esc_html_e('Work', 'houzez'); ?></strong><br>
			<?php echo esc_attr($work_phone); ?>
		</li>
		<?php } ?>

		<?php if($country || $city || $state) { ?>
		<li>
			<strong><?php esc_html_e('Location', 'houzez'); ?></strong><br>
			<?php 
				echo esc_attr($country);
				if($state) {
					echo ', '.$state;
				} 
				if($city) {
					echo ', '.$city;
				} 
				if($zipcode) {
					echo ', '.$zipcode;
				} 
			?>

		</li>
		<?php } ?>

		<li>
			<strong><?php esc_html_e('Source', 'houzez'); ?></strong><br>
			<?php 
			if( !empty($source) || !empty($source_link)) {

				if( !empty($source)) {
					echo esc_attr($source).'<br/>';
				}

				if(!empty($source_link)) {
					echo '<a href="'.esc_url($source_link).'">'.esc_url($source_link).'</a>';
				}
			} 
			?>
			
		</li>
	</ul>

	<h2><?php esc_html_e('Realtor', 'houzez'); ?></h2>
	<ul class="list-unstyled">
		<li>
			<strong><?php esc_html_e('Name', 'houzez'); ?></strong><br>
			<?php 
			if(!empty($agent_info['name'])) {
				echo esc_attr($agent_info['name']);
			} else {
				echo '-';
			}
			?>

		</li>
		<li>
			<strong><?php esc_html_e('Email', 'houzez'); ?></strong><br>
			<?php 
			if(!empty($agent_info['email'])) {
				echo '<a href="mailto:'.esc_attr($agent_info['email']).'"><strong>'.esc_attr($agent_info['email']).'</strong></a>';
			} else {
				echo '-';
			}
			?>
		</li>
	</ul>
</div><!-- lead-detail-wrap -->
<?php endif; ?>