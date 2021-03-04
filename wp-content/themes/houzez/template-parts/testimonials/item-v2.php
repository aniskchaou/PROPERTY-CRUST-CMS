<?php
global $houzez_local;
$text = get_post_meta(get_the_ID(), 'fave_testi_text', true);
$name = get_post_meta(get_the_ID(), 'fave_testi_name', true);
$position = get_post_meta(get_the_ID(), 'fave_testi_position', true);
$company = get_post_meta(get_the_ID(), 'fave_testi_company', true);
$photo_id = get_post_meta(get_the_ID(), 'fave_testi_photo', true);
$logo_id = get_post_meta(get_the_ID(), 'fave_testi_logo', true);
?>
<div class="testimonial-item testimonial-item-v2">
	<div class="testimonial-icon">
		<i class="houzez-icon icon-close-quote"></i>
	</div><!-- testimonial-icon -->
	<div class="testimonial-body">
		<?php echo wp_kses_post($text); ?>
	</div><!-- testimonial-body -->
	<div class="d-flex align-items-center">
		
		<?php if (!empty($photo_id)) { ?>
	        <div class="testimonial-thumb">
	            <?php echo wp_get_attachment_image($photo_id, array('70', '70'), false, array('class' => 'img-fluid rounded-circle', 'srcset' => '')); ?>
	        </div>
	    <?php } ?>	

		<div class="testimonial-info">
			<?php echo $houzez_local['by_text']; ?> <strong><?php echo esc_attr($name); ?></strong><br>
			<em>
				<?php echo esc_attr($position);
				if(!empty($company)){
	            echo ', '. esc_attr($company); 
	            } ?>
            </em>
		</div><!-- testimonial-info -->
	</div><!-- d-flex -->
</div><!-- testimonial-item -->