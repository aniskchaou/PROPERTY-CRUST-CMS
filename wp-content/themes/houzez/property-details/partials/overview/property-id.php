<?php
$prop_id = houzez_get_listing_data('property_id');

if(!empty($prop_id)) {
	echo '<ul class="list-unstyled flex-fill">
			<li class="property-overview-item">
				<strong>'.houzez_propperty_id_prefix($prop_id).'</strong> 
			</li>
			<li class="hz-meta-label h-prop-id">'.houzez_option('spl_prop_id', 'Property ID').'</li>
		</ul>';
}