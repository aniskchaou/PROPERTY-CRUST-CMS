<?php
$currency_switcher_enable = houzez_option('currency_switcher_enable');
$is_multi_currency = houzez_option('multi_currency');
if( $currency_switcher_enable != 0 && $is_multi_currency != 1 ) {
    if (class_exists('FCC_Rates')) {

        $supported_currencies = houzez_get_list_of_supported_currencies();

        if (0 < count($supported_currencies)) {

            $current_currency = houzez_get_wpc_current_currency();
            ?>
			<div class="switcher-wrap currency-switcher-wrap">
				<button class="btn dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><span><?php echo esc_attr($current_currency); ?></span>
				</button>
				<ul id="hz-currency-switcher-list" class="dropdown-menu" aria-labelledby="dropdown">
					<?php
					foreach ($supported_currencies as $currency_code) {
		                echo '<li data-currency-code="' . esc_attr($currency_code) . '">' . esc_attr($currency_code) . '</li>';
		            }
					?>
				</ul>
				<input type="hidden" id="hz-switch-to-currency" value="<?php echo esc_attr($current_currency); ?>" />
			</div><!-- currency-switcher-wrap -->
			<?php
		}
    }
}
?>