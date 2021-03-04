<?php 
$button_class = '';
if( !houzez_option('disable_date', 1) && !houzez_option('disable_agent', 1)) {
	$button_class = 'item-no-footer';
}

if(houzez_option('disable_detail_btn', 1)) { ?>
<a class="btn btn-primary btn-item <?php echo esc_attr($button_class); ?>" href="<?php echo esc_url(get_permalink()); ?>">
	<?php echo houzez_option('glc_detail_btn', 'Details'); ?>
</a><!-- btn-item -->
<?php } ?>