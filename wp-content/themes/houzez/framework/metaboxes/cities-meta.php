<?php
/* Add metaboxes to property city */

if ( !function_exists( 'houzez_property_city_add_meta_fields' ) ) :
    function houzez_property_city_add_meta_fields() {
        $houzez_meta = houzez_get_property_city_meta();
        
        if(taxonomy_exists('property_state')) {
            $all_states = houzez_get_all_states();
        ?>
        <div class="form-field">
            <label><?php _e( 'Which state has this city?', 'houzez' ); ?></label>
            <select name="fave[parent_state]" class="widefat">
                <option value=""><?php esc_html_e('Select State', 'houzez'); ?></option>
                <?php echo $all_states; ?>
            </select>
            <p class="description"><?php _e( 'Select state which has this city.', 'houzez' ); ?></p>
        </div>
        <?php
        }
    }
endif;

add_action( 'property_city_add_form_fields', 'houzez_property_city_add_meta_fields', 10, 2 );


/**
 *   ----------------------------------------------------------------------------------------------------------------------------------------------------
 *   2.0 - Edit meta field
 *   ----------------------------------------------------------------------------------------------------------------------------------------------------
 */

if ( !function_exists( 'houzez_property_city_edit_meta_fields' ) ) :
    function houzez_property_city_edit_meta_fields( $term ) {
        $houzez_meta = houzez_get_property_city_meta();

        if(is_object ($term)) {
            $term_id      =  $term->term_id;
            $term_meta    =  get_option( "_houzez_property_city_$term_id" );
            $parent_state  =  $term_meta['parent_state'] ? $term_meta['parent_state'] : '';
            $all_states   =  houzez_get_all_states($parent_state);

        } else {
            $all_states   =  houzez_get_all_states();
        }
        ?>

        <tr class="form-field">
            <th scope="row" valign="top"><label><?php _e( 'Which state has this city?', 'houzez' ); ?></label></th>
            <td>
                <select name="fave[parent_state]" class="widefat">
                    <?php echo $all_states; ?>
                </select>
                <p class="description"><?php _e( 'Select state which has this city.', 'houzez' ); ?></p>
            </td>
        </tr>

        <?php
    }
endif;

add_action( 'property_city_edit_form_fields', 'houzez_property_city_edit_meta_fields', 10, 2 );


if ( !function_exists( 'houzez_save_property_city_meta_fields' ) ) :
    function houzez_save_property_city_meta_fields( $term_id ) {

        if ( isset( $_POST['fave'] ) ) {

            $houzez_meta = array();

            $houzez_meta['parent_state'] = isset( $_POST['fave']['parent_state'] ) ? $_POST['fave']['parent_state'] : '';

            update_option( '_houzez_property_city_'.$term_id, $houzez_meta );
        }

    }
endif;
add_action( 'edited_property_city', 'houzez_save_property_city_meta_fields', 10, 2 );
add_action( 'create_property_city', 'houzez_save_property_city_meta_fields', 10, 2 );


?>