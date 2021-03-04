<?php
global $post, $total_listing_found, $houzez_local, $listings_tabs;
$listing_page_link = get_permalink( $post->ID );
$listings_tab_1 = get_post_meta( $post->ID, 'fave_listings_tab_1', true );
$listings_tab_2 = get_post_meta( $post->ID, 'fave_listings_tab_2', true );

$tab1_link = add_query_arg( 'tab', $listings_tab_1, $listing_page_link );
$tab2_link = add_query_arg( 'tab', $listings_tab_2, $listing_page_link );

$tab_1 = houzez_get_term_by( 'slug', $listings_tab_1, 'property_status' );
$tab_2 = houzez_get_term_by( 'slug', $listings_tab_2, 'property_status' );

$tab_all = $tab1_active = $tab2_active = '';
if( isset( $_GET['tab'] ) && $_GET['tab'] == $listings_tab_1 ) {
    $tab1_active = "class = active";
} elseif( isset( $_GET['tab'] ) && $_GET['tab']  == $listings_tab_2 ) {
    $tab2_active = "class = active";
} else {
    $tab_all = "class = active";
}

$property_label = houzez_option('cl_property', 'Property');
if( $total_listing_found > 1 ) {
   $property_label = houzez_option('cl_properties', 'Properties'); 
}
?>
<div class="listing-tabs flex-grow-1">
    <?php 
    if($listings_tabs != 'disable') {
        if( !empty($tab_1) || !empty($tab_2) ) { ?>
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link <?php echo esc_attr( $tab_all ); ?>" href="<?php echo esc_url( $listing_page_link ); ?>"><?php echo esc_html__('All', 'houzez'); ?></a>
            </li>

            <?php if( $listings_tab_1 != '0' ) { ?>
            <li class="nav-item">
                <a class="nav-link <?php echo esc_attr( $tab1_active ); ?>" href="<?php echo esc_url( $tab1_link ); ?>"><?php echo esc_attr( $tab_1->name ); ?></a>
            </li>
            <?php } ?>

            <?php if( $listings_tab_2 != '0' ) { ?>
            <li class="nav-item">
                <a class="nav-link <?php echo esc_attr( $tab2_active ); ?>" href="<?php echo esc_url( $tab2_link ); ?>"><?php echo esc_attr( $tab_2->name ); ?></a>
            </li>
            <?php } ?>

        </ul><!-- nav-tabs -->
        <?php } 
    } else { 
        echo esc_attr($total_listing_found).' '.$property_label;
    }?>
</div><!-- listing-tabs -->
