<?php
class Houzez_Address_Control extends \Elementor\Base_Control {


	public function get_type() {
		return 'houzez-address-sort-control';
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
			'property_address',
			'property_country',
			'property_state',
			'property_city',
			'property_area',
			'property_zip',
		);

		if ( ! is_array( $sorting_settings ) && ! empty( $sorting_settings ) ) {
			$sort_fields = explode( ',', $sorting_settings );
		}

		$data_fields = array(
			'property_address' => esc_html__('Property Address', 'houzez-theme-functionality'),
			'property_country' => esc_html__('Property Country', 'houzez-theme-functionality'),
			'property_state'   => esc_html__('Property State', 'houzez-theme-functionality'),
			'property_city'    => esc_html__('Property City', 'houzez-theme-functionality'),
			'property_area'    => esc_html__('Property Area', 'houzez-theme-functionality'),
			'property_zip'     => esc_html__('Property Zip/Postal Code', 'houzez-theme-functionality'),
		);


		// add filter to third party to add more fields 
		$data_fields = apply_filters( 'houzez_address_sort_fields', $data_fields );

		if ( ! empty( $sort_fields ) && is_array( $sort_fields ) ) {
			$data_fields = array_merge( array_flip( $sort_fields ), $data_fields );
		}
		?>

		<div class="houzez-sortable-js-wrap">
            <ul class="houzez-sortable-css houzez-sortable-list houzez-sortable-<?php echo esc_attr( $control_uid ); ?>"></ul>
            <input type="hidden" class="houzez-sorting-js" id="houzez-sort-id-<?php echo esc_attr( $control_uid ); ?>"
                   data-setting="{{{ data.name }}}">
        </div>

        <script type="application/javascript">

            jQuery(document).ready( () => {

                function houzezAddressList(id, dataFields, getStored){

                    var setStored, setChecked;

                    var checkedBoxVals = jQuery("#houzez-sort-id-<?php echo esc_attr( $control_uid ); ?>").val();

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

                houzezAddressList(".houzez-sortable-<?php echo esc_attr( $control_uid ); ?>", <?php echo json_encode($data_fields)?>,<?php echo json_encode($sort_fields); ?>);

                jQuery('.<?php echo 'houzez-sortable-' . $control_uid ?>').sortable({
                    update: HouzezMakeChange
                });

                jQuery("<?php echo '.houzez-sortable-' . $control_uid; ?> input[type='checkbox'] ").on('change', HouzezMakeChange);

                function HouzezMakeChange() {
                    var checkboxValues = jQuery("<?php echo '.houzez-sortable-' . $control_uid ?>").find('input[type="checkbox"]:checked').map( function() {
                            return this.value;
                        }).get().join(',');

                    jQuery('.houzez-sortable-js-wrap .houzez-sorting-js').val(checkboxValues).trigger('input');
                }

            });

        </script>

		<?php

	}
}