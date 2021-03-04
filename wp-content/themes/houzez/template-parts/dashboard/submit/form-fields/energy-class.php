<div class="form-group">
        <label for="energy_class">
        	<?php echo houzez_option('cl_energy_cls', 'Energy Class' ).houzez_required_field('energy_class'); ?>
        </label>

        <select name="energy_class" id="energy_class" <?php houzez_required_field_2('energy_class'); ?> class="selectpicker form-control bs-select-hidden" title="<?php echo houzez_option('cl_energy_cls_plac', 'Select'); ?>" data-live-search="false" data-selected-text-format="count" data-actions-box="true">
        <option value=""><?php echo houzez_option('cl_energy_cls_plac', 'Select Energy Class'); ?></option>

        <?php
        $energy_array = houzez_option('energy_class_data', 'A+, A, B, C, D, E, F, G, H'); 
        $energy_array = explode(',', $energy_array);

        if( ! empty( $energy_array ) ) {

             foreach ($energy_array as $e_class) { 
                $e_class = trim($e_class);
                ?>

                <option <?php selected(houzez_get_field_meta('energy_class'), esc_attr($e_class)); ?> value="<?php echo esc_attr($e_class);?>"><?php echo esc_attr($e_class);?></option>

             <?php
             }

        }

        ?>

	</select><!-- selectpicker -->
</div>