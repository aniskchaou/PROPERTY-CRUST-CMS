<div class="form-group">
	<label for="epc_potential_rating"><?php echo houzez_option('cl_energy_ecp_p', 'EPC Potential Rating'); ?></label>

	<input class="form-control" id="epc_potential_rating" name="epc_potential_rating" value="<?php
    if (houzez_edit_property()) {
        houzez_field_meta('epc_potential_rating');
    }
    ?>" placeholder="<?php echo houzez_option('cl_energy_ecp_p_plac'); ?>" type="text">
</div>