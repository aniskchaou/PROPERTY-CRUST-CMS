<?php 
$multi_currency = houzez_option('multi_currency');
if($multi_currency == 1 ) {
    if(class_exists('Houzez_Currencies')) {

        $searched_currency = isset($_GET['currency']) ? $_GET['currency'] : '';

        $currencies = Houzez_Currencies::get_currency_codes();
        if($currencies) {
            echo '<div class="flex-search">';
            echo '<div class="form-group">';
            echo '<select name="currency" class="selectpicker form-control bs-select-hidden" data-live-search="false" data-live-search-style="begins" title="">';
            echo '<option value="">'.houzez_option('srh_currency', 'Currency').'</option>';
            echo '<option value="">'.houzez_option('srh_any', 'Any').'</option>';
            foreach ($currencies as $currency) {
                echo '<option '.selected( $currency->currency_code, $searched_currency, false).' value="'.esc_attr($currency->currency_code).'">'.esc_attr($currency->currency_code).'</option>'; 
            }
            echo '</select>';
            echo '</div>';
            echo '</div>';
        }
    }
}
?>