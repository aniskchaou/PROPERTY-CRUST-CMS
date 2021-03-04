<?php
$property_type = houzez_taxonomy_simple('property_type');

if(!empty($property_type)) {
	echo '<ul class="list-unstyled flex-fill">
			<li class="property-overview-item"><strong>'.esc_attr( $property_type ).'</strong></li>
			<li class="hz-meta-label property-overview-type">'.houzez_option('spl_prop_type', 'Property Type').'</li>
			
		</ul>';
}