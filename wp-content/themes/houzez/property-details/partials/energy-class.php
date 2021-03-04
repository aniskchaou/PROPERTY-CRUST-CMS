<?php
global $energy_class, $ele_settings;

$energy_global_index = houzez_get_listing_data('energy_global_index');
$renewable_energy_index = houzez_get_listing_data('renewable_energy_global_index');
$energy_performance = houzez_get_listing_data('energy_performance');
$epc_current_rating = houzez_get_listing_data('epc_current_rating');
$epc_potential_rating = houzez_get_listing_data('epc_potential_rating');
$energy_array = houzez_option('energy_class_data', 'A+, A, B, C, D, E, F, G, H'); 
$energy_array = explode(',', $energy_array);
$total_records = count($energy_array);

$energetic_cls_title = isset($ele_settings['energetic_class_title']) && !empty($ele_settings['energetic_class_title']) ? $ele_settings['energetic_class_title'] : houzez_option('spl_energetic_cls', 'Energetic class');

$global_energy_index_title = isset($ele_settings['global_energy_index']) && !empty($ele_settings['global_energy_index']) ? $ele_settings['global_energy_index'] : houzez_option('spl_energy_index', 'Global energy performance index');

$renewable_energy_index_title = isset($ele_settings['renewable_energy_index']) && !empty($ele_settings['renewable_energy_index']) ? $ele_settings['renewable_energy_index'] : houzez_option('spl_energy_renew_index', 'Renewable energy performance index');

$energy_performance_title = isset($ele_settings['energy_performance']) && !empty($ele_settings['energy_performance']) ? $ele_settings['energy_performance'] : houzez_option('spl_energy_build_performance', 'Energy performance of the building');

$epc_current_rating_title = isset($ele_settings['epc_current_rating']) && !empty($ele_settings['epc_current_rating']) ? $ele_settings['epc_current_rating'] : houzez_option('spl_energy_ecp_rating', 'EPC Current Rating');

$epc_potential_rating_title = isset($ele_settings['epc_potential_rating']) && !empty($ele_settings['epc_potential_rating']) ? $ele_settings['epc_potential_rating'] : houzez_option('spl_energy_ecp_p', 'EPC Potential Rating');

$energy_class_title = isset($ele_settings['energy_class_title']) && !empty($ele_settings['energy_class_title']) ? $ele_settings['energy_class_title'] : houzez_option('spl_energy_cls', 'Energy class');
?>
<ul class="class-energy-list list-unstyled">
	<li>
		<strong><?php echo esc_attr($energetic_cls_title); ?>:</strong> 
		<span><?php echo esc_attr($energy_class); ?></span>
	</li>
	<li>
		<strong><?php echo esc_attr($global_energy_index_title); ?>:</strong> 
		<span><?php echo esc_attr($energy_global_index); ?></span>
	</li>

	<?php if(!empty($renewable_energy_index)) { ?>
	<li>
		<strong><?php echo esc_attr($renewable_energy_index_title); ?>:</strong> 
		<span><?php echo esc_attr($renewable_energy_index); ?></span>
	</li>
	<?php } ?>

	<?php if(!empty($energy_performance)) { ?>
	<li>
		<strong><?php echo esc_attr($energy_performance_title); ?>:</strong> 
		<span><?php echo esc_attr($energy_performance); ?></span>
	</li>
	<?php } ?>

	<?php if(!empty($epc_current_rating)) { ?>
	<li>
		<strong><?php echo esc_attr($epc_current_rating_title); ?>:</strong> 
		<span><?php echo esc_attr($epc_current_rating); ?></span>
	</li>
	<?php } ?>

	<?php if(!empty($epc_potential_rating)) { ?>
	<li>
		<strong><?php echo esc_attr($epc_potential_rating_title); ?>:</strong> 
		<span><?php echo esc_attr($epc_potential_rating); ?></span>
	</li>
	<?php } ?>
</ul>
<ul class="class-energy energy-class-<?php echo esc_attr($total_records); ?>">
	<?php 
	if( !empty($energy_array) ) {
	    foreach($energy_array as $energy) {

	    	$energy = trim($energy);
	        $indicator_energy = '';
	        if( $energy == $energy_class ) {
	            $indicator_energy = '<div class="indicator-energy" data-energyclass="'.esc_attr($energy_class).'">'.esc_attr($energy_global_index).' | '.esc_attr($energy_class_title).' '.esc_attr($energy_class).'</div>';
	        }
	        echo '<li class="class-energy-indicator">
	            '.$indicator_energy.'
	            <span class="energy-'.esc_attr($energy).'">'.esc_attr($energy).'</span>
	        </li>';
	    }
	}
    ?>
</ul>