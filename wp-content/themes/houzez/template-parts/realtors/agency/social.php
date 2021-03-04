<?php
$agency_facebook = get_post_meta( get_the_ID(), 'fave_agency_facebook', true );
$agency_twitter = get_post_meta( get_the_ID(), 'fave_agency_twitter', true );
$agency_linkedin = get_post_meta( get_the_ID(), 'fave_agency_linkedin', true );
$agency_googleplus = get_post_meta( get_the_ID(), 'fave_agency_googleplus', true );
$agency_youtube = get_post_meta( get_the_ID(), 'fave_agency_youtube', true );
$agency_pinterest = get_post_meta( get_the_ID(), 'fave_agency_pinterest', true );
$agency_instagram = get_post_meta( get_the_ID(), 'fave_agency_instagram', true );
$agency_vimeo = get_post_meta( get_the_ID(), 'fave_agency_vimeo', true );
$agency_mobile = get_post_meta( get_the_ID(), 'fave_agency_mobile', true );
$agency_whatsapp = get_post_meta( get_the_ID(), 'fave_agency_whatsapp', true );
$agency_mobile_call = str_replace(array('(',')',' ','-'),'', $agency_mobile);
$agency_whatsapp_call = str_replace(array('(',')',' ','-'),'', $agency_whatsapp);
?>

<?php if( !empty( $agency_facebook ) ) { ?>
<span>
	<a class="btn-facebook" target="_blank" href="<?php echo esc_url( $agency_facebook ); ?>">
		<i class="houzez-icon icon-social-media-facebook mr-2"></i>
	</a>
</span>
<?php } ?>

 <?php if( !empty( $agency_instagram ) ) { ?>
<span>
	<a class="btn-instagram" target="_blank" href="<?php echo esc_url( $agency_instagram ); ?>">
		<i class="houzez-icon icon-social-instagram mr-2"></i>
	</a>
</span>
<?php } ?>

<?php if( !empty( $agency_twitter ) ) { ?>
<span>
	<a class="btn-twitter" target="_blank" href="<?php echo esc_url( $agency_twitter ); ?>">
		<i class="houzez-icon icon-social-media-twitter mr-2"></i>
	</a>
</span>
<?php } ?>

<?php if( !empty( $agency_linkedin ) ) { ?>
<span>
	<a class="btn-linkedin" target="_blank" href="<?php echo esc_url( $agency_linkedin ); ?>">
		<i class="houzez-icon icon-professional-network-linkedin mr-2"></i>
	</a>
</span>
<?php } ?>

<?php if( !empty( $agency_googleplus ) ) { ?>
<span>
	<a class="btn-googleplus" target="_blank" href="<?php echo esc_url( $agency_googleplus ); ?>">
		<i class="houzez-icon icon-social-media-google-plus-1 mr-2"></i>
	</a>
</span>
<?php } ?>

<?php if( !empty( $agency_youtube ) ) { ?>
<span>
	<a class="btn-youtube" target="_blank" href="<?php echo esc_url( $agency_youtube ); ?>">
		<i class="houzez-icon icon-social-video-youtube-clip mr-2"></i>
	</a>
</span>
<?php } ?>

<?php if( !empty( $agency_pinterest ) ) { ?>
<span>
	<a class="btn-pinterest" target="_blank" href="<?php echo esc_url( $agency_pinterest ); ?>">
		<i class="houzez-icon icon-social-pinterest mr-2"></i>
	</a>
</span>
<?php } ?>

<?php if( !empty( $agency_vimeo ) ) { ?>
<span>
	<a class="btn-vimeo" target="_blank" href="<?php echo esc_url( $agency_vimeo ); ?>">
		<i class="houzez-icon icon-social-video-vimeo mr-2"></i>
	</a>
</span>
<?php } ?>
<?php if( !empty( $agency_whatsapp ) ) { ?>
<span class="agent-whatsapp">
	<a class="btn-whatsapp" target="_blank" href="https://wa.me/<?php echo esc_attr($agency_whatsapp_call); ?>">
		<i class="houzez-icon icon-messaging-whatsapp mr-2"></i>
	</a>
</span>
<?php } ?>