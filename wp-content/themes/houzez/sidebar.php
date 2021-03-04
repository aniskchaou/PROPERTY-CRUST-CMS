<?php
/**
 * Created by PhpStorm.
 * User: waqasriaz
 * Date: 16/12/15
 * Time: 5:02 PM
 */
global $post;
$sidebar_meta = array('specific_sidebar' => 'no');
if( houzez_postid_needed() ) {
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
        if (is_active_sidebar('default-sidebar')) {
            dynamic_sidebar('default-sidebar');
        }
    }
    ?>
</aside>