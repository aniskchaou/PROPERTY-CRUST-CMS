<?php
global $post, $author_id;
if(houzez_option('agent_tabs', 1)) {

    if(is_author()) {
        $permalink = get_author_posts_url($author_id);
    } else {
        $permalink = get_permalink($post->ID);
    }
    
    $tab_all = $tab1_active = $tab2_active = $sortby = $tab1_link = $tab2_link = $tab_1_name = $tab_2_name = '';

    $agent_detail_tab_1 = houzez_option('agent_detail_tab_1');
    $agent_detail_tab_2 = houzez_option('agent_detail_tab_2');

    if(!empty($agent_detail_tab_1) || !empty($agent_detail_tab_2)) {

    $tab_1 = houzez_get_term_by( 'term_id', $agent_detail_tab_1, 'property_status' );
    $tab_2 = houzez_get_term_by( 'term_id', $agent_detail_tab_2, 'property_status' );

    $all_link = add_query_arg( 'tab', '', $permalink );

    if( $tab_1 ) {
        $tab1_link = add_query_arg( 'tab', $tab_1->slug, $permalink );
        $tab_1_name = $tab_1->name;
    }

    if( $tab_2 ) {
        $tab2_link = add_query_arg( 'tab', $tab_2->slug, $permalink );
        $tab_2_name = $tab_2->name;
    }

    
    if( isset( $_GET['tab'] ) && $_GET['tab'] == $tab_1->slug ) {
        $tab1_active = "active";
    } elseif( isset( $_GET['tab'] ) && $_GET['tab']  == $tab_2->slug ) {
        $tab2_active = "active";
    } else {
        $tab_all = "active";
    }
    ?>
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link <?php echo esc_attr( $tab_all ); ?>" href="<?php echo esc_url($all_link); ?>"><?php esc_html_e('All', 'houzez');?></a>
        </li>

        <?php if(!empty($agent_detail_tab_1) && !empty($tab_1_name)) { ?>
        <li class="nav-item">
            <a class="nav-link <?php echo esc_attr( $tab1_active ); ?>" href="<?php echo esc_url($tab1_link);?>"><?php echo esc_attr($tab_1_name);?></a>
        </li>
        <?php } ?>

        <?php if(!empty($agent_detail_tab_2) && !empty($tab_2_name)) { ?>
        <li class="nav-item">
            <a class="nav-link <?php echo esc_attr( $tab2_active ); ?>" href="<?php echo esc_url($tab2_link);?>"><?php echo esc_attr($tab_2_name);?></a>
        </li>
        <?php } ?>
    </ul><!-- nav-tabs -->
    <?php }
}
?>
