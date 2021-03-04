<?php
global $post;
$sidebar_meta['specific_sidebar'] = 'no';
if(!is_author()) {
$sidebar_meta = houzez_get_sidebar_meta($post->ID);
}
?>
<aside id="sidebar" class="sidebar-wrap">
    <?php
    if( $sidebar_meta['specific_sidebar'] == 'yes' ) {
        if( is_active_sidebar( $sidebar_meta['selected_sidebar'] ) ) {
            dynamic_sidebar( $sidebar_meta['selected_sidebar'] );
        }
    } else {
        if (is_active_sidebar('agent-sidebar')) {
            dynamic_sidebar('agent-sidebar');
        }
    }
    ?>
</aside>