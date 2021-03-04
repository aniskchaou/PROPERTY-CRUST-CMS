<?php if( has_tag() ) { ?>
<div class="post-footer-wrap">
	<div class="post-tag-wrap">
	    <strong><?php esc_html_e( 'Tags', 'houzez' ); ?></strong><br>
	    <?php
	    $tags = get_the_tags();
	    foreach( $tags as $tag ) {

            echo '<a class="post-tag" href="'.get_tag_link($tag->term_id).'">'.esc_attr($tag->name).'</a> ';
        }
	    ?>
	</div><!-- post-tag-wrap -->
</div><!-- post-footer-wrap -->
<?php } ?>