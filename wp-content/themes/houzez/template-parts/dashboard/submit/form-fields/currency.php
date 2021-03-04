<?php 
global $houzez_local; 
$is_multi_currency = houzez_option('multi_currency');
$default_multi_currency = get_the_author_meta( 'fave_author_currency' , get_current_user_id() );
if(empty($default_multi_currency)) {
    $default_multi_currency = houzez_option('default_multi_currency');
}

if( $is_multi_currency == 1 && class_exists('Houzez_Currencies')) { ?>

<div class="col-md-6 col-sm-12">
	<div class="form-group">
		<label for="currency">
			<?php echo esc_html__('Currency', 'houzez'); ?>	
		</label>

		<select name="currency" class="selectpicker form-control bs-select-hidden" data-live-search="false" data-live-search-style="begins">
	        <option value=""><?php echo $houzez_local['choose_currency']; ?></option>
	        <?php
	        $currencies = Houzez_Currencies::get_form_fields();
	        if(!empty($currencies)) {
		        foreach ($currencies as $currency) {

		        	if (houzez_edit_property()) {
		        		echo '<option '.selected($currency->currency_code, houzez_get_field_meta('currency'), false).' value="'.esc_attr($currency->currency_code).'">'.esc_attr($currency->currency_code).'</option>';

		        	} else {
		        		echo '<option '.selected($currency->currency_code, $default_multi_currency, false).' value="'.esc_attr($currency->currency_code).'">'.esc_attr($currency->currency_code).'</option>';
		        	}
		        }
		    }
	        ?>
	    </select>
	</div>
</div>

<?php } ?>