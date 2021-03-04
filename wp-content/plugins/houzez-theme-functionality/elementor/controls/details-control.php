<?php
class Houzez_Property_Details_Control extends \Elementor\Base_Control {


	public function get_type() {
		return 'houzez-details-sort-control';
	}

	protected function get_control_uid( $input_type = 'default' ) {
		return 'elementor-control-' . $input_type . '-{{{ data._cid }}}';
	}

	public function enqueue() {

		wp_enqueue_style( 'houzez-elementor-sort-control', HOUZEZ_PLUGIN_URL . 'assets/frontend/css/sort-control.css', array(), HOUZEZ_PLUGIN_CORE_VERSION, 'all' );

	}

	public function content_template() {
		global $sorting_settings;
		$control_uid = $this->get_control_uid(); 

		$sort_fields = array(
			'property_id',
			'property_price',
			'property_size',
			'property_land',
			'property_bedrooms',
			'property_bathrooms',
			'property_garage',
			'property_garage_size',
			'property_year',
			'property_status',
			'property_type',
			
		);

		if ( ! is_array( $sorting_settings ) && ! empty( $sorting_settings ) ) {
			$sort_fields = explode( ',', $sorting_settings );
		}

		$data_fields = array(
			'property_id' 		  => esc_html__('Property ID', 'houzez-theme-functionality'),
			'property_price'      => esc_html__('Property Price', 'houzez-theme-functionality'),
			'property_size'       => esc_html__('Property Size', 'houzez-theme-functionality'),
			'property_land'       => esc_html__('Property Land Size', 'houzez-theme-functionality'),
			'property_bedrooms'   => esc_html__('Property Bedrooms', 'houzez-theme-functionality'),
			'property_bathrooms'  => esc_html__('Property Bathrooms', 'houzez-theme-functionality'),
			'property_garage'     => esc_html__('Property Garages', 'houzez-theme-functionality'),
			'property_garage_size'=> esc_html__('Property Garage Size', 'houzez-theme-functionality'),
			'property_year'       => esc_html__('Property Year Built', 'houzez-theme-functionality'),
			'property_status'     => esc_html__('Property Status', 'houzez-theme-functionality'),
			'property_type'       => esc_html__('Property Type', 'houzez-theme-functionality'),
		);

		//Custom Fields
        if(class_exists('Houzez_Fields_Builder')) {
        	$fields_array = Houzez_Fields_Builder::get_form_fields(); 

        	$custom_fields_array = array();

            if(!empty($fields_array)) {
                foreach ( $fields_array as $value ) {
                    $field_title = $value->label;
                    $field_id = houzez_clean_20($value->field_id);
                    $field_title = houzez_wpml_translate_single_string($field_title);
                    
                    $custom_fields_array[ $field_id ] = $field_title;
                }

                $data_fields = array_merge( $data_fields, $custom_fields_array );
            }
        }


		// add filter to third party to add more fields 
		$data_fields = apply_filters( 'houzez_property_details_sort_fields', $data_fields );

		if ( ! empty( $sort_fields ) && is_array( $sort_fields ) ) {
			$data_fields = array_merge( array_flip( $sort_fields ), $data_fields );
		}
		?>

		<div class="houzez-details-sortable-js-wrap">
            <ul class="houzez-sortable-css houzez-details-sortable-list houzez-details-sortable-<?php echo esc_attr( $control_uid ); ?>"></ul>
            <input type="hidden" class="houzez-details-sorting-js" id="houzez-details-sort-id-<?php echo esc_attr( $control_uid ); ?>"
                   data-setting="{{{ data.name }}}">
        </div>

        <script type="application/javascript">

            jQuery(document).ready( () => {

                function houzezPropertyDetailsMetaList(id, dataFields, getStored){

                    var setStored, setChecked;

                    var checkedBoxVals = jQuery("#houzez-details-sort-id-<?php echo esc_attr( $control_uid ); ?>").val();

                    if(checkedBoxVals === ''){ 
                        setStored = getStored;

                    } else { 
                        setStored = checkedBoxVals.split(',');
                    }

                    jQuery.each(dataFields, (index, element) => {

                        if( jQuery.inArray(index, setStored) >= 0 ) {
                            setChecked = 'checked';
                        } else {
                            setChecked = '';
                        }
                        jQuery(id).append('<li><label><input type="checkbox" ' +setChecked+ ' value="'+index+'" > '+element+'</label></li>');

                    });

                }

                houzezPropertyDetailsMetaList(".houzez-details-sortable-<?php echo esc_attr( $control_uid ); ?>", <?php echo json_encode($data_fields)?>,<?php echo json_encode($sort_fields); ?>);

                jQuery('.<?php echo 'houzez-details-sortable-' . $control_uid ?>').sortable({
                    update: HouzezChangeMeta
                });

                jQuery("<?php echo '.houzez-details-sortable-' . $control_uid; ?> input[type='checkbox'] ").on('change', HouzezChangeMeta);

                function HouzezChangeMeta() {
                    var checkboxValues = jQuery("<?php echo '.houzez-details-sortable-' . $control_uid ?>").find('input[type="checkbox"]:checked').map( function() {
                            return this.value;
                        }).get().join(',');

                    jQuery('.houzez-details-sortable-js-wrap .houzez-details-sorting-js').val(checkboxValues).trigger('input');
                }

            });

        </script>

		<?php

	}
}