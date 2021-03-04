<tr>
	<td class="property-table-thumbnail" data-label="<?php echo esc_html__('Thumbnail', 'houzez'); ?>">
		<div class="table-property-thumb">
			
			<a href="<?php echo esc_url(get_permalink()); ?>">
			<?php
			if( has_post_thumbnail() && get_the_post_thumbnail(get_the_ID()) != '') {
                the_post_thumbnail(array('100', '75'));
            } else {
                echo '<img src="http://via.placeholder.com/100x75">';
            }
			?>
			</a>	
		</div>
	</td>
	
	<td class="property-table-address" data-label="<?php echo esc_html__('Title', 'houzez'); ?>">
		<a href="<?php echo esc_url(get_permalink()); ?>"><strong><?php the_title(); ?></strong></a><br>
		<?php echo houzez_get_listing_data('property_map_address'); ?>
	</td>

	<td class="property-table-type" data-label="<?php echo esc_html__('Type', 'houzez'); ?>">
		<?php echo houzez_taxonomy_simple('property_type'); ?>		
	</td>

	<td class="property-table-status" data-label="<?php echo esc_html__('Status', 'houzez'); ?>">
		<?php echo houzez_taxonomy_simple('property_status'); ?>
	</td>

	<td class="property-table-price" data-label="<?php echo esc_html__('Price', 'houzez'); ?>">
		<?php houzez_property_price_admin(); ?>
	</td>
	
	<td class="property-table-actions" data-label="<?php echo esc_html__('Actions', 'houzez'); ?>">
		<div class="dropdown property-action-menu">
			<button class="btn btn-primary-outlined dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<?php echo esc_html__('Actions', 'houzez'); ?>
			</button>
			<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
				<a class="dropdown-item" target="_blank" href="<?php echo esc_url(get_permalink()); ?>"><?php esc_html_e('View', 'houzez'); ?></a>
				<a class="remove_fav dropdown-item" data-listid="<?php echo intval(get_the_ID())?>" href="#"><?php esc_html_e('Delete', 'houzez'); ?></a>
			</div>
		</div>
	</td>
</tr>