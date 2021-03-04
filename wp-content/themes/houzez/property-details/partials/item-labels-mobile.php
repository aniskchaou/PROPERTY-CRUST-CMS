<?php
$term_id = '';
$term_status = wp_get_post_terms( get_the_ID(), 'property_status', array("fields" => "all"));

$label_id = '';
$term_label = wp_get_post_terms( get_the_ID(), 'property_label', array("fields" => "all"));
?>
<span class="labels-wrap labels-right"> 
    <?php 
    if( !empty($term_status) && houzez_option( 'detail_status', 1 ) != 0 ) {
        foreach( $term_status as $status ) {
            $status_id = $status->term_id;
            $status_name = $status->name;
            echo '<a href="'.get_term_link($status_id).'" class="label-status label status-color-'.intval($status_id).'">
                    '.esc_attr($status_name).'
                </a>';
        }
    }

    if( !empty($term_label) && houzez_option( 'detail_label', 1 ) != 0 ) {
        foreach( $term_label as $label ) {
            $label_id = $label->term_id;
            $label_name = $label->name;
            echo '<a href="'.get_term_link($label_id).'" class="hz-label label label-color-'.intval($label_id).'">
                    '.esc_attr($label_name).'
                </a>';
        }
    }
    ?>       
</span>

