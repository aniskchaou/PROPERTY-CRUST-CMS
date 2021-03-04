<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class FCC_Rates {
    
    /**
     * Currencies list.
     *
     * @since 1.0.0
     * @access protected
     * @var string
     */
    protected static $currencies_list = 'http://openexchangerates.org/api/currencies.json';

    /**
     * Exchange rates API
     *
     * @since 1.0.0
     * @access protected
     * @var string
     */
    protected static $currencies_rates = 'http://openexchangerates.org/api/latest.json?app_id=';

    /**
     * Initialize
     *
     * @access public
     * @return void
     */
    public static function init() {
        static::$currencies_list  = 'http://openexchangerates.org/api/currencies.json';
        static::$currencies_rates = 'http://openexchangerates.org/api/latest.json?app_id=';
    }


    /**
     *
     * Insert/Update database with currency rates
     *
     */
    public static function update() {

        $option = get_option( 'fcc_api_settings' );
        if ( ! isset( $option['api_key'] ) ) {
            return null;
        }

        $api_key = $option['api_key'];

        if(empty($api_key)) {
            return null;
        }

        // Get the currencies rates (default base currency is US dollars).
        $response = wp_remote_get( static::$currencies_rates . $api_key );

        $json = isset( $response['body'] ) ? json_decode( $response['body'] ) : $response;
        $new_rates = isset( $json->rates ) ? (array) $json->rates : $json;

        // Check for request errors.
        if ( ! $new_rates instanceof \WP_Error ) {

            if ( is_array( $new_rates ) && count( $new_rates ) > 99 ) {

                // Check if there is already values exist in database 
                $old_rates  = self::get_rates();
                $action     = ! $old_rates || is_null( $old_rates ) ? 'insert' : 'update';

                global $wpdb;
                $table = $wpdb->prefix . 'favethemes_currency_converter';

                // Make currencies meta.
                $data = self::make_currency_data();

                // Traverse rates and put in database
                foreach ( $new_rates as $currency_code => $rate_usd ) :

                    if ( is_string( $currency_code ) && $rate_usd && isset( $data[ $currency_code ] ) ) {
                
                        $currency_code = strtoupper( substr( sanitize_key( $currency_code ), 0, 3 ) );
                        $rate_usd      = floatval( $rate_usd );
                        $currency_data = json_encode( (array) $data[ $currency_code ] );

                    } else {
                        continue;
                    }

                    if ( $action == 'update' ) {

                        if ( count( $old_rates ) != count( $new_rates ) ) {
    
                            $wpdb->delete(
                                $table, array( 'currency_code' => $currency_code, )
                            );

                            $wpdb->insert(
                                $table, array(
                                    'currency_code' => $currency_code,
                                    'currency_rate' => $rate_usd,
                                    'currency_data' => $currency_data,
                                    'timestamp'     => current_time( 'mysql' )
                                )
                            );

                        } else {
                            $wpdb->update(
                                $table, array(
                                'currency_rate' => $rate_usd,
                                'currency_data' => $currency_data,
                                'timestamp'     => current_time( 'mysql' )
                            ), array( 'currency_code' => $currency_code ) );
                        }

                    } elseif ( $action == 'insert' ) {
                        $wpdb->insert(
                            $table, array(
                                'currency_code' => $currency_code,
                                'currency_rate' => $rate_usd,
                                'currency_data' => $currency_data,
                                'timestamp'     => current_time( 'mysql' )
                            )
                        );
                    }

                endforeach;

            }

        } else {

            trigger_error(
                esc_html__( 'There was a problem to update currencies and exchange rates, Please check your API key is valid and you have usage quota.', 'favethemes-currency-converter' ),
                E_USER_WARNING
            );

        }

        return $new_rates;
    }

    /**
     * Get currency exchange rates.
     */
    public static function get_exchange_rate_data() {

        global $wpdb;
        $table_name = $wpdb->prefix . 'favethemes_currency_converter';

        $results = $wpdb->get_results(
            "SELECT * FROM $table_name"
        );

        if(!empty($results)) {
            return $results;
        }
        return false;
    }

    /**
     * Get currency exchange rates.
     */
    public static function get_rates() {

        global $wpdb;
        $table_name = $wpdb->prefix . 'favethemes_currency_converter';

        $results = $wpdb->get_results(
            "SELECT * FROM $table_name", ARRAY_A
        );

        $rates = array();
        if ( $results && is_array( $results ) ) {
            foreach ( $results as $row ) {
                $rates[strtoupper($row['currency_code'])] = floatval( $row['currency_rate'] );
            }
        }

        return $rates;
    }


    /**
     * Get currencies data.
     */
    public static function get_currencies() {

        global $wpdb;
        $table = $wpdb->prefix . 'favethemes_currency_converter';

        $results = $wpdb->get_results(
            "SELECT * FROM {$table}", ARRAY_A
        );

        $currencies = array();
        if ( $results && is_array( $results ) ) {
            foreach ( $results as $row ) {
                $currencies[$row['currency_code']] = (array) json_decode( $row['currency_data'] );
            }
        }

        return $currencies;
    }


    /**
     * Make currency data according to currency code
     */
    public static function make_currency_data() {

        $currencies = array();

        $currency_data = wp_remote_get( static::$currencies_list );
        $currency_data = isset( $currency_data['body'] ) ? (array) json_decode( $currency_data['body'] ) : $currency_data;

        if ( ! $currency_data instanceof \WP_Error ) {

            if ( is_array( $currency_data ) && count( $currency_data ) > 99 ) {

                foreach ( $currency_data as $currency_code => $currency_name ) {

                    if ( ! is_string( $currency_code ) || ! is_string( $currency_name ) ) {
                        continue;
                    }

                    $currency_code = strtoupper( substr( sanitize_key( $currency_code ), 0, 3 ) );
                    // Defaults values
                    $currencies[$currency_code] = array(
                        'name'          => sanitize_text_field( $currency_name ),
                        'symbol'        => $currency_code,
                        'position'      => 'before',
                        'decimals'      => 2,
                        'thousands_sep' => ',',
                        'decimals_sep'  => '.'
                    );

                }

            }

        }

        $currency_data = self::fcc_currencies_format_currency_data( $currencies );

        return (array) apply_filters( 'fcc_currencies_make_currency_data', $currency_data );
    }


    public static function fcc_currencies_format_currency_data( $currencies = '' ) {

        $data = $currencies;

        if ( $currencies && is_array( $currencies ) && count( $currencies ) > 100 ) :

            foreach ( $currencies as $currency_code => $currency_data ) :

                if ( ! $currency_data['symbol'] || ! isset( $currency_data['name'] ) ) {
                    continue;
                }


                if ( $currency_code == 'AUD' ) {

                // Australian Dollar
                $data[$currency_code] = array(
                    'name'          => $currency_data['name'],
                    'symbol'        => 'A&#36;',
                    'position'      => 'after',
                    'decimals'      => 2,
                    'thousands_sep' => ',',
                    'decimals_sep'  => '.',
                );

            } elseif ( $currency_code == 'BRL' ) {

                // Brazilian Real
                $data[$currency_code] = array(
                    'name'          => $currency_data['name'],
                    'symbol'        => 'R&#36;',
                    'position'      => 'after',
                    'decimals'      => 2,
                    'thousands_sep' => '&nbsp;',
                    'decimals_sep'  => '.',
                );

            } elseif ( $currency_code == 'BND' ) {

                // Brunei Dollar
                $data[$currency_code] = array(
                    'name'          => $currency_data['name'],
                    'symbol'        => 'B&#36;',
                    'position'      => 'before',
                    'decimals'      => 2,
                    'thousands_sep' => ',',
                    'decimals_sep'  => '.',
                );

            } elseif ( $currency_code == 'BTC' || $currency_code == 'XBT') {

                // Bitcoin
                $data[$currency_code] = array(
                    'name'          => $currency_data['name'],
                    'symbol'        => $currency_data['symbol'],
                    'position'      => 'before',
                    'decimals'      => 2,
                    'thousands_sep' => ',',
                    'decimals_sep'  => '.',
                );

            } elseif ( $currency_code == 'CAD' ) {

                // Canadian Dollar
                $data[$currency_code] = array(
                    'name'          => $currency_data['name'],
                    'symbol'        => 'C&#36;',
                    'position'      => 'after',
                    'decimals'      => 3,
                    'thousands_sep' => '&nbsp;',
                    'decimals_sep'  => ',',
                );

            } elseif ( $currency_code == 'CHF' ) {

                $data[$currency_code] = array(
                    'name'          => $currency_data['name'],
                    'symbol'        => 'SFr.',
                    'position'      => 'after',
                    'decimals'      => 3,
                    'thousands_sep' => '&nbsp;',
                    'decimals_sep'  => ',',
                );

            } elseif ( $currency_code == 'CNY' ) {

                // Chinese Renmimbi (Yuan)
                $data[$currency_code] = array(
                    'name'          => $currency_data['name'],
                    'symbol'        => '&#165',
                    'position'      => 'before',
                    'decimals'      => 2,
                    'thousands_sep' => ',',
                    'decimals_sep'  => '.',
                );

            } elseif ( $currency_code == 'DKK' ) {

                // Danish Crown
                $data[$currency_code] = array(
                    'name'          => $currency_data['name'],
                    'symbol'        => 'kr.',
                    'position'      => 'after',
                    'decimals'      => 3,
                    'thousands_sep' => '&nbsp;',
                    'decimals_sep'  => ',',
                );

            } elseif ( $currency_code == 'EUR' ) {

                // Euro
                $data[$currency_code] = array(
                    'name'          => $currency_data['name'],
                    'symbol'        => '&#8364;',
                    'position'      => 'before',
                    'decimals'      => 2,
                    'thousands_sep' => '.',
                    'decimals_sep'  => ',',
                );

            } elseif ( $currency_code == 'GBP' ) {

                // British Pound
                $data[$currency_code] = array(
                    'name'          => $currency_data['name'],
                    'symbol'        => '&#163;',
                    'position'      => 'after',
                    'decimals'      => 2,
                    'thousands_sep' => ',',
                    'decimals_sep'  => '.',
                );

            } elseif ( $currency_code == 'JPY' ) {

                // Japanese Yen
                $data[$currency_code] = array(
                    'name'          => $currency_data['name'],
                    'symbol'        => '&#165;',
                    'position'      => 'after',
                    'decimals'      => 0,
                    'thousands_sep' => ',',
                    'decimals_sep'  => '.',
                );

            } elseif ( $currency_code == 'LAK' ) {

                // Laos Kip
                $data[$currency_code] = array(
                    'name'          => $currency_data['name'],
                    'symbol'        => '&#8365;',
                    'position'      => 'after',
                    'decimals'      => 2,
                    'thousands_sep' => '.',
                    'decimals_sep'  => ',',
                );

            } elseif ( $currency_code == 'HKD' ) {

                // Hong Kong Dollar
                $data[$currency_code] = array(
                    'name'          => $currency_data['name'],
                    'symbol'        => 'HK&#36;',
                    'position'      => 'before',
                    'decimals'      => 2,
                    'thousands_sep' => ',',
                    'decimals_sep'  => '.',
                );

            } elseif ( $currency_code == 'IDR' ) {

                // Indonesian Rupee
                $data[$currency_code] = array(
                    'name'          => $currency_data['name'],
                    'symbol'        => '&#8377;',
                    'position'      => 'after',
                    'decimals'      => 2,
                    'thousands_sep' => '.',
                    'decimals_sep'  => ',',
                );

            } elseif ( $currency_code == 'MMK' ) {

                // Burmese Kyat
                $data[$currency_code] = array(
                    'name'          => $currency_data['name'],
                    'symbol'        => 'Ks',
                    'position'      => 'after',
                    'decimals'      => 2,
                    'thousands_sep' => ',',
                    'decimals_sep'  => '.',
                );

            } elseif ( $currency_code == 'MYR' ) {

                // Malaysian Ringgit
                $data[$currency_code] = array(
                    'name'          => $currency_data['name'],
                    'symbol'        => 'RM',
                    'position'      => 'before',
                    'decimals'      => 2,
                    'thousands_sep' => '.',
                    'decimals_sep'  => ',',
                );

            } elseif ( $currency_code == 'MXN' ) {

                // Mexican Peso
                $data[$currency_code] = array(
                    'name'          => $currency_data['name'],
                    'symbol'        => 'Mex#36;',
                    'position'      => 'after',
                    'decimals'      => 2,
                    'thousands_sep' => '&nbsp;',
                    'decimals_sep'  => ',',
                );

            } elseif ( $currency_code == 'NZD' ) {

                // New Zealand Dollar
                $data[$currency_code] = array(
                    'name'          => $currency_data['name'],
                    'symbol'        => 'NZ&#36;',
                    'position'      => 'after',
                    'decimals'      => 2,
                    'thousands_sep' => ',',
                    'decimals_sep'  => '.',
                );

            } elseif ( $currency_code == 'NOK' ) {

                // Norwegian Crown
                $data[$currency_code] = array(
                    'name'          => $currency_data['name'],
                    'symbol'        => 'kr',
                    'position'      => 'after',
                    'decimals'      => 3,
                    'thousands_sep' => '.',
                    'decimals_sep'  => ',',
                );

            } elseif ( $currency_code == 'PLN' ) {

                // Polish złoty
                $data[$currency_code] = array(
                    'name'          => $currency_data['name'],
                    'symbol'        => 'z&#322;',
                    'position'      => 'after',
                    'decimals'      => 2,
                    'thousands_sep' => '.',
                    'decimals_sep'  => ',',
                );

            } elseif ( $currency_code == 'PHP' ) {

                // Philippines Peso
                $data[$currency_code] = array(
                    'name'          => $currency_data['name'],
                    'symbol'        => '&#8369;',
                    'position'      => 'after',
                    'decimals'      => 2,
                    'thousands_sep' => ',',
                    'decimals_sep'  => '.',
                );

            } elseif ( $currency_code == 'RON' ) {

                // Romanian Leu
                $data[$currency_code] = array(
                    'name'          => $currency_data['name'],
                    'symbol'        => 'Lei',
                    'position'      => 'after',
                    'decimals'      => 2,
                    'thousands_sep' => '.',
                    'decimals_sep'  => ',',
                );

            } elseif ( $currency_code == 'RUB' ) {

                // Russian Ruble
                $data[$currency_code] = array(
                    'name'          => $currency_data['name'],
                    'symbol'        => '&#8381;',
                    'position'      => 'after',
                    'decimals'      => 2,
                    'thousands_sep' => '.',
                    'decimals_sep'  => ',',
                );

            } elseif ( $currency_code == 'SAR' ) {

                // Saudi Ryal
                $data[$currency_code] = array(
                    'name'          => $currency_data['name'],
                    'symbol'        => 'SR',
                    'position'      => 'after',
                    'decimals'      => 3,
                    'thousands_sep' => ',',
                    'decimals_sep'  => '.',
                );

            } elseif ( $currency_code == 'SGD' ) {

                // Singapore Dollar
                $data[$currency_code] = array(
                    'name'          => $currency_data['name'],
                    'symbol'        => 'S&#36;',
                    'position'      => 'before',
                    'decimals'      => 2,
                    'thousands_sep' => '.',
                    'decimals_sep'  => ',',
                );

            } elseif ( $currency_code == 'SEK' ) {

                // Swedish Crown
                $data[$currency_code] = array(
                    'name'          => $currency_data['name'],
                    'symbol'        => 'kr',
                    'position'      => 'after',
                    'decimals'      => 2,
                    'thousands_sep' => '.',
                    'decimals_sep'  => ',',
                );

            } elseif ( $currency_code == 'THB' ) {

                // Thai Baht
                $data[$currency_code] = array(
                    'name'          => $currency_data['name'],
                    'symbol'        => '&#3647;',
                    'position'      => 'after',
                    'decimals'      => 2,
                    'thousands_sep' => ',',
                    'decimals_sep'  => '.',
                );

            } elseif ( $currency_code == 'TRY' ) {

                // Turkish Lira
                $data[$currency_code] = array(
                    'name'          => $currency_data['name'],
                    'symbol'        => '&#8378;',
                    'position'      => 'after',
                    'decimals'      => 2,
                    'thousands_sep' => ',',
                    'decimals_sep'  => '.',
                );

            } elseif ( $currency_code == 'TWD' ) {

                // Taiwan New Dollar
                $data[$currency_code] = array(
                    'name'          => $currency_data['name'],
                    'symbol'        => 'NT&#36;',
                    'position'      => 'after',
                    'decimals'      => 2,
                    'thousands_sep' => ',',
                    'decimals_sep'  => '.',
                );

            } elseif ( $currency_code == 'USD' ) {

                // US Dollar
                $data[$currency_code] = array(
                    'name'          => $currency_data['name'],
                    'symbol'        => '&#36;',
                    'position'      => 'before',
                    'decimals'      => 2,
                    'thousands_sep' => ',',
                    'decimals_sep'  => '.',
                );

            } elseif ( $currency_code == 'VND' ) {

                // Vietnamese Dong
                $data[$currency_code] = array(
                    'name'          => $currency_data['name'],
                    'symbol'        => '&#8363;',
                    'position'      => 'after',
                    'decimals'      => 2,
                    'thousands_sep' => ',',
                    'decimals_sep'  => '.',
                );

            } elseif ( $currency_code == 'WON' ) {

                // Korean Won
                $data[$currency_code] = array(
                    'name'          => $currency_data['name'],
                    'symbol'        => '&#8361;',
                    'position'      => 'after',
                    'decimals'      => 2,
                    'thousands_sep' => ',',
                    'decimals_sep'  => '.',
                );

            } else {

                // All others
                $data[$currency_code] = array(
                    'name'          => $currency_data['name'],
                    'symbol'        => $currency_data['symbol'],
                    'position'      => 'after',
                    'decimals'      => 2,
                    'thousands_sep' => ',',
                    'decimals_sep'  => '.',
                );

            }

            endforeach;

        endif;

        // Custom currencies from database
        $custom_currencies = Houzez_Currencies::get_currencies_data();

        if($custom_currencies) {
            foreach ( $custom_currencies as $c_data ) {
                $data[$c_data->currency_code] = array(
                    'name'          => $c_data->currency_name,
                    'symbol'        => $c_data->currency_symbol,
                    'position'      => $c_data->currency_position,
                    'decimals'      => $c_data->currency_decimal,
                    'thousands_sep' => $c_data->currency_thousand_separator,
                    'decimals_sep'  => $c_data->currency_decimal_separator,
                );
            }
        }

        return (array) $data;

    }

        
}
?>