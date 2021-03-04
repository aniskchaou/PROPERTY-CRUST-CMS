<div class="form-group">
	<label for="renewable_energy_global_index"><?php echo houzez_option('cl_energy_renew_index', 'Renewable energy performance index'); ?></label>

	<input class="form-control" id="renewable_energy_global_index" name="renewable_energy_global_index" value="<?php
    if (houzez_edit_property()) {
        houzez_field_meta('renewable_energy_global_index');
    }
    ?>" placeholder="<?php echo houzez_option('cl_energy_renew_index_plac', 'For example: 0.00 kWh / m²a'); ?>" type="text">
</div>