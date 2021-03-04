<?php 
global $post; 
$fave_page_title = get_post_meta($post->ID, 'fave_page_title', true);

if($fave_page_title != 'hide') {
?>
<div class="page-title flex-grow-1">
	<h1><?php the_title(); ?></h1>
</div><!-- page-title -->
<?php
}?>