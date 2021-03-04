<?php 
global $post;
$listing_agent = houzez_get_property_agent( $post->ID ); 

if(houzez_option('disable_agent', 1) && !empty($listing_agent)) { ?>
<div class="item-author">
	<i class="houzez-icon icon-single-neutral mr-1"></i>
	<?php echo implode( ', ', $listing_agent ); ?>
</div><!-- item-author -->
<?php } ?>