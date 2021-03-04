<ul class="houzez-status-tabs nav nav-pills justify-content-center" role="tablist" data-toggle="buttons">
	<li class="nav-item">
		<a class="nav-link active" data-val="" data-toggle="pill" href="#" role="tab" aria-selected="true">
			<?php echo houzez_option('srh_all_status', 'All Status'); ?>
		</a>
	</li>
	<?php
	$terms_status = get_terms(
        array(
            'property_status'
        ),
        array(
            'orderby'       => 'name',
            'order'         => 'ASC',
            'hide_empty'    => true,
            'parent' => 0
        )
    );
    if (!empty($terms_status)) {
        $i = 0;      
        foreach ($terms_status as $status) { 

        	if($i == houzez_option('tabs_limit')) {
        		break;
        	}
        	echo '<li class="nav-item">
					<a class="nav-link" data-val="'.esc_attr($status->slug).'" data-toggle="pill" href="#" role="tab" aria-selected="true">
						'.esc_attr($status->name).'
					</a>
				</li>';
			$i++;
        }
    }
	?>
	<input type="hidden" name="status[]" id="search-tabs">
</ul>