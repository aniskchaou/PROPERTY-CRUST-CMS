<?php
/**
 * Add fields builder metaboxes fields
 *
 * @param $metabox_fields
 *
 * @return array
 */
function houzez_field_builder_metabox_fields( $metabox_fields ) {
	$houzez_prefix = 'fave_';
	$fields = array();
	$columns = 6;

	if( class_exists('Houzez_Fields_Builder') ) {

		$fields_array = Houzez_Fields_Builder::get_form_fields();

		if( !empty($fields_array) ) {

			foreach ($fields_array as $field) {

				$field_title = $field->label;  
				$field_type = $field->type;  
                $field_placeholder = $field->placeholder;
                $field_id = houzez_clean_20($field->field_id);

                $field_title = houzez_wpml_translate_single_string($field_title);
                $field_placeholder = houzez_wpml_translate_single_string($field_placeholder);


                if($field_type == 'select') {

                    $options = unserialize($field->fvalues);

                    $options_array = array();
                    if(!empty($options)) {
                        foreach ($options as $key => $val) {

                            $select_options = houzez_wpml_translate_single_string($val);
                            $options_array[$key] = $select_options;


                        }
                    }

                    $fields[] = array(
                        'id' => "{$houzez_prefix}".$field_id,
                        'name' => $field_title,
                        'type' => $field_type,
                        'placeholder' => $field_placeholder,
                        'std' => "",
                        'desc' => '',
                        'options' => $options_array,
                        'columns' => $columns,
                        'tab' => 'property_details',
                    );

                } else if($field_type == 'multiselect') {
                    $options = unserialize($field->fvalues);

                    $options_array = array();
                    if(!empty($options)) {
                        foreach ($options as $key => $val) {

                            $select_options = houzez_wpml_translate_single_string($val);
                            $options_array[$key] = $select_options;


                        }
                    }


                    $fields[] = array(
                        'id' => "{$houzez_prefix}".$field_id,
                        'name' => $field_title,
                        'type' => 'select_advanced',
                        'placeholder' => $field_placeholder,
                        'std' => "",
                        'desc' => '',
                        'multiple' => true,
                        'options' => $options_array,
                        'columns' => $columns,
                        'tab' => 'property_details',
                    );

                } elseif( $field_type == 'checkbox_list' || $field_type == 'radio' ) {
                    
                    $options = unserialize($field->fvalues);
                    $options    = explode( ',', $options );
                    $options    = array_filter( array_map( 'trim', $options ) );
                    $all_options     = array_combine( $options, $options );

                    $fields[] = array(
                        'id' => "{$houzez_prefix}".$field_id,
                        'name' => $field_title,
                        'type' => $field_type,
                        'options' => $all_options,
                        'columns' => $columns,
                        'inline' => true,
                        'tab' => 'property_details',
                    );


                } else {
                    $fields[] = array(
                        'id' => "{$houzez_prefix}".$field_id,
                        'name' => $field_title,
                        'type' => $field_type,
                        'placeholder' => $field_placeholder,
                        'std' => "",
                        'desc' => '',
                        'columns' => $columns,
                        'tab' => 'property_details',
                    );
                }


			} // end foreach

		}	

	}

	return array_merge( $metabox_fields, $fields );

}
add_filter( 'houzez_property_metabox_fields', 'houzez_field_builder_metabox_fields', 15 );
