<?php 
$header = houzez_option('header_style'); 
if( !empty(houzez_option('hd1_4_phone')) && houzez_option('hd1_4_phone_enable', 0) && ( $header == 1 || $header == 4 ) ) { ?>
<li class="btn-phone-number">
	<a href="tel:<?php echo houzez_option('hd1_4_phone'); ?>"><i class="houzez-icon icon-phone-actions-ring mr-1"></i> <?php echo houzez_option('hd1_4_phone'); ?></a>
</li>
<?php } ?>