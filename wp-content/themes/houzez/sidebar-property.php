<?php
global $post;
$agent_form = houzez_option('agent_form_sidebar');
$sidebar_meta = houzez_get_sidebar_meta($post->ID);

if( isset( $_GET['agent_form']) && $_GET['agent_form'] == 'yes' ) {
    $agent_form = 1;
}
?>

<aside id="sidebar" class="sidebar-wrap">
    <?php
    if( is_singular('property') ) { 

        if( $agent_form != 0 ) {
            get_template_part( 'property-details/agent', 'form' );
        } 

        if( is_active_sidebar( 'single-property' ) ) {
            dynamic_sidebar( 'single-property' );
        }
    } else {
        if( $sidebar_meta['specific_sidebar'] == 'yes' ) {
            if( is_active_sidebar( $sidebar_meta['selected_sidebar'] ) ) {
                dynamic_sidebar( $sidebar_meta['selected_sidebar'] );
            }
        } else {
            if( is_active_sidebar( 'property-listing' ) ) {
                dynamic_sidebar( 'property-listing' );
            }
        }
    }

    ?>
</aside>