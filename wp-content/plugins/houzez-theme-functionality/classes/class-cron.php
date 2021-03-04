<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class HOUZEZ_Cron {
    
    
    public static function init() {
        add_filter('cron_schedules', array( __CLASS__, 'FCC_cron_schedules' ), 10, 1);
        add_action( 'favethemes_currencies_update', array( __CLASS__, 'FCC_update_currencies' ) );
    }

    /**
     * Update currencies.
     *
     */
    public static function FCC_update_currencies() {
        FCC_Rates::update();
    }

    /**
     * Schedule currency rates updates.
     */
    public static function FCC_schedule_updates( $api_key = '', $interval = '' ) {

        if ( empty( $api_key ) || empty(  $interval ) ) {
            $api_key = FCC_API_Settings::get_setting('api_key');
            $interval = FCC_API_Settings::get_setting('update_interval');
        }

        if ( $api_key && $interval ) {

            if ( ! wp_next_scheduled( 'favethemes_currencies_update' ) ) {
                wp_schedule_event(   time(), $interval, 'favethemes_currencies_update' );
            } else {
                wp_reschedule_event( time(), $interval, 'favethemes_currencies_update' );
            }
        }

        self::FCC_update_currencies();

    }

    /**
     * Add new schedules to wp_cron.
     *
     */
    public static function FCC_cron_schedules( $schedules ) {
        $schedules['one_minute'] = array(
            'interval' => 60,
            'display'  => esc_html__( 'Once a Minute', 'favethemes-currency-converter' ),
        );
        $schedules['weekly'] = array(
            'interval' => 604800,
            'display' => esc_html__( 'Once Weekly', 'favethemes-currency-converter' )
        );
        $schedules['biweekly'] = array(
            'interval' => 1209600,
            'display' => esc_html__( 'Once Biweekly', 'favethemes-currency-converter' )
        );
        $schedules['monthly'] = array(
            'interval' => 2419200,
            'display' => esc_html__( 'Once Monthly', 'favethemes-currency-converter' )
        );
        return $schedules;
    }
}
?>