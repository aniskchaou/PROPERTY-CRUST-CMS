<?php
global $houzez_local;
$text = get_post_meta(get_the_ID(), 'fave_testi_text', true);
$name = get_post_meta(get_the_ID(), 'fave_testi_name', true);
$position = get_post_meta(get_the_ID(), 'fave_testi_position', true);
$company = get_post_meta(get_the_ID(), 'fave_testi_company', true);
$photo_id = get_post_meta(get_the_ID(), 'fave_testi_photo', true);
$logo_id = get_post_meta(get_the_ID(), 'fave_testi_logo', true);
?>
<div class="testimonial-item testimonial-item-v1">

	<?php if (!empty($photo_id)) { ?>
        <div class="testimonial-thumb dfg">
            <?php echo wp_get_attachment_image($photo_id, 'thumbnail', false, array('class' => 'img-fluid rounded-circle')); ?>
        </div>
    <?php } ?>

	<?php if($logo_id != '') { ?>
	<div class="testimonial-logo">
	<?php echo wp_get_attachment_image($logo_id, 'thumbnail'); ?>
	</div><!-- testimonial-logo -->
	<?php } ?>

	<div class="testimonial-body">
		<?php echo wp_kses_post($text); ?>
	</div><!-- testimonial-body -->
	<div class="testimonial-info">
		<?php echo $houzez_local['by_text']; ?> <strong><?php echo esc_attr($name); ?></strong><br>
		<em>
			<?php echo esc_attr($position);
			if(!empty($company)){
            echo ', '. esc_attr($company); 
            } ?>
		</em>
	</div><!-- testimonial-info -->
</div><!-- testimonial-item -->