<?php
$term_id = '';
$term_status = wp_get_post_terms( get_the_ID(), 'property_status', array("fields" => "all"));
?>
<div class="labels-wrap labels-right"> 

	<?php 
	if( !empty($term_status) ) {
		foreach( $term_status as $status ) {
	        $status_id = $status->term_id;
	        $status_name = $status->name;
	        echo '<a href="'.get_term_link($status_id).'" class="label-status label status-color-'.intval($status_id).'">
					'.esc_attr($status_name).'
				</a>';
	    }
	}
	?>       

</div>