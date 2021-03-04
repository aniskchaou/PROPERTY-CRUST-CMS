<div class="form-group">
	<textarea class="form-control" name="virtual_tour" rows="7" placeholder="<?php echo houzez_option('cl_virtual_plac', 'Enter virtual tour iframe/embeded code');?>"><?php
    if (houzez_edit_property()) {
        houzez_field_meta('virtual_tour', false);
    }
    ?></textarea>
</div>