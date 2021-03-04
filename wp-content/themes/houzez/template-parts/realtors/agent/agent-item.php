<?php 
global $houzez_local;
$des = get_post_meta(get_the_ID(), 'fave_agent_des', true);
$position = get_post_meta(get_the_ID(), 'fave_agent_position', true);
$company = get_post_meta(get_the_ID(), 'fave_agent_company', true);
$logo_id = get_post_meta(get_the_ID(), 'fave_agent_logo', true);
?>
<div class="agent-item">
	<div class="agent-thumb">
		<a href="<?php the_permalink(); ?>">
			<?php
			if( has_post_thumbnail() && get_the_post_thumbnail() != '' ) {
		        the_post_thumbnail( 'thumbnail', array('class' => 'img-fluid rounded-circle') );
		    }else{
		        houzez_image_placeholder( 'thumbnail' );
		    }
			?>
		</a>
	</div>

	<div class="agent-info">
		<div class="agent-name">
			<a href="<?php the_permalink(); ?>"><strong><?php the_title(); ?></strong></a>
		</div>

		<div class="agent-company">
			<?php if( !empty($position) || !empty($company) ) { ?>
                <?php echo esc_attr($position); ?>
                <?php if( !empty($company) ) { ?>
                , <?php echo esc_attr($company); ?>

                <?php } ?>
            <?php } ?>
		</div>
	</div>
	<div class="agent-body">
		<?php echo houzez_get_excerpt(15); ?>
	</div>
	<div class="agent-link">
		<a href="<?php the_permalink(); ?>"><?php echo $houzez_local['view_profile']; ?></a>
	</div>
</div>