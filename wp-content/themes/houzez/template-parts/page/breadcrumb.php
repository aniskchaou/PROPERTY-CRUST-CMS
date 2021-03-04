<?php 
global $post; 
$site_breadcrumb = houzez_option('site_breadcrumb');
$page_breadcrumb = get_post_meta($post->ID, 'fave_page_breadcrumb', true);
?>

<div class="breadcrumb-wrap">
<?php
if($page_breadcrumb != 'hide') {
	if( $site_breadcrumb != 0 ) {
?>
	<nav>
		<?php houzez_breadcrumbs(); ?>
	</nav>
<?php } 
}?>
</div><!-- breadcrumb-wrap -->