<?php
/* Add metaboxes to property Area/Neighborhood */

if ( !function_exists( 'houzez_property_area_add_meta_fields' ) ) :
    function houzez_property_area_add_meta_fields() {
        $houzez_meta = houzez_get_property_area_meta();
    
        if(taxonomy_exists('property_city')) {
            $all_cities = houzez_get_all_cities();
        ?>
        <div class="form-field">
            <label><?php _e( 'Which city has this area?', 'houzez' ); ?></label>
            <select name="fave[parent_city]" class="widefat">
                <option value=""><?php esc_html_e('Select City', 'houzez'); ?></option>
                <?php echo $all_cities; ?>
            </select>
            <p class="description"><?php _e( 'Select city which has this area.', 'houzez' ); ?></p>
        </div>
        <?php
        }
    }
endif;

add_action( 'property_area_add_form_fields', 'houzez_property_area_add_meta_fields', 10, 2 );


/**
 *   ----------------------------------------------------------------------------------------------------------------------------------------------------
 *   2.0 - Edit meta field
 *   ----------------------------------------------------------------------------------------------------------------------------------------------------
 */

if ( !function_exists( 'houzez_property_area_edit_meta_fields' ) ) :
    function houzez_property_area_edit_meta_fields( $term ) {
        $houzez_meta = houzez_get_property_area_meta();

        if(is_object ($term)) {
            $term_id      =  $term->term_id;
            $term_meta    =  get_option( "_houzez_property_area_$term_id" );
            $parent_city  =  $term_meta['parent_city'] ? $term_meta['parent_city'] : '';
            $all_cities   =  houzez_get_all_cities($parent_city);

        } else {
            $all_cities   =  houzez_get_all_cities();
        }
        ?>

        <tr class="form-field">
            <th scope="row" valign="top"><label><?php _e( 'Which city has this area?', 'houzez' ); ?></label></th>
            <td>
                <select name="fave[parent_city]" class="widefat">
                    <?php echo $all_cities; ?>
                </select>
                <p class="description"><?php _e( 'Select city which has this area.', 'houzez' ); ?></p>
            </td>
        </tr>

        <?php
    }
endif;

add_action( 'property_area_edit_form_fields', 'houzez_property_area_edit_meta_fields', 10, 2 );