<?php
global $property_data;
$property_features = get_terms( 'property_feature', array( 'orderby' => 'name', 'order' => 'ASC', 'hide_empty' => false ) );

$features_terms_id = array();
if (houzez_edit_property()) {
    $features_terms = get_the_terms( $property_data->ID, 'property_feature' );
    if ( $features_terms && ! is_wp_error( $features_terms ) ) {
        foreach( $features_terms as $feature ) {
            $features_terms_id[] = intval( $feature->term_id );
        }
    }
}
if( !empty( $property_features ) ) {
    $count = 1;
    foreach( $property_features as $feature ) {

        echo '<div class="col-md-3 col-sm-6 col-6">';
        echo '<label class="control control--checkbox">';
        if ( in_array( $feature->term_id, $features_terms_id ) ) {
            echo '<input type="checkbox" name="prop_features[]" id="feature-' . esc_attr( $count ) . '" value="' . esc_attr( $feature->term_id ) . '" checked />';
            echo esc_attr( $feature->name );
            echo '<span class="control__indicator"></span>';
        } else {
            echo '<input type="checkbox" name="prop_features[]" id="feature-' . esc_attr( $count ) . '" value="' . esc_attr( $feature->term_id ) . '" />';
            echo esc_attr( $feature->name );
            echo '<span class="control__indicator"></span>';
        }
        echo '</label>';
        echo '</div>';
        $count++;

    }
}
?>