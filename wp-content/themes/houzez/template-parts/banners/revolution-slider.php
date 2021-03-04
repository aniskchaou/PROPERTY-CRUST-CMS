<?php
global $post;

if (is_plugin_active('revslider/revslider.php')) {
    $revslider_alias = get_post_meta($post->ID, 'fave_page_header_revslider', true); ?>

    <section class="top-banner-wrap slider-revolution-wrap">
        <?php putRevSlider($revslider_alias) ?>

        <?php 
		if(houzez_option('adv_search_which_header_show')['header_rs'] != 0) {
			get_template_part('template-parts/search/dock-search-main');
		}
		?>
    </section><!-- slider-revolution-wrap -->
    
<?php
}?>
