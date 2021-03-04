<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
if(!class_exists('Fave_Visitor')) {
    class Fave_Visitor {

        public $ip = null;
        public $referrer = null;
        public $language = null;
        public $unique_identifier = null;

        /**
         * Generate a unique identifier to identify unique visitors.
         *
         * @access public
         * @return md5|string
         */
        public static function unique_identifier() {
            return md5( json_encode( [
                self::get_language(),
                self::get_browser(),
                self::get_ip(),
                self::get_platform(),
                
            ] ) );
        }

        /**
         * Get user OS info based.
         *
         * @link  https://stackoverflow.com/questions/3441880/get-users-os-and-version-number/15497878#15497878
         * @access public
         * @return string|os
         */
        public static function get_platform() {
            $user_agent = $_SERVER['HTTP_USER_AGENT'];
            $device = wp_is_mobile() ? 'mobile' : 'desktop';
            $os_platform = false;
            $os_array = [
                '/macintosh|mac os x/i'            =>  'macOS',
                '/ubuntu/i'                        =>  'Ubuntu',
                '/linux/i'                         =>  'Linux',
                '/android/i'                       =>  'Android',
                '/iphone|ipad|ipod/i'              =>  'iOS',
                '/webos/i'                         =>  'webOS',
                '/windows nt 10/i'                 =>  'Windows 10',
                '/windows nt 6.2|windows nt 6.3/i' =>  'Windows 8',
                '/windows nt 6.1/i'                =>  'Windows 7',
                '/win32/i'                         =>  'Windows',
            ];

            foreach ( $os_array as $regex => $value ) {
                if ( preg_match( $regex, $user_agent ) ) {
                    $os_platform = $value;
                }
            }

            return [
                'platform' => $os_platform,
                'device' => $device,
            ];
        }


        /**
         * Get user IP address if available in $_SERVER.
         *
         * @access public
         * @return false|IP Address
         */
        public static function get_ip() {
            $server_ip_keys = [
                'HTTP_CLIENT_IP',
                'HTTP_X_FORWARDED_FOR',
                'HTTP_X_FORWARDED',
                'HTTP_X_CLUSTER_CLIENT_IP',
                'HTTP_FORWARDED_FOR',
                'HTTP_FORWARDED',
                'REMOTE_ADDR',
            ];

            foreach ( $server_ip_keys as $key ) {
                if ( isset( $_SERVER[ $key ] ) && filter_var( $_SERVER[ $key ], FILTER_VALIDATE_IP ) ) {
                    return $_SERVER[ $key ];
                }
            }

            // Fallback local ip.
            return '127.0.0.1';
        }


        /**
         * Get visitor's browser language code
         *
         * @access public
         * @return false|language
         */
        public static function get_language( $default = 'en') {
            if ( !empty( $_SERVER['HTTP_ACCEPT_LANGUAGE'] ) ) {

                $available_lang = explode( ',', $_SERVER['HTTP_ACCEPT_LANGUAGE'] );
                foreach ( $available_lang as $val ) {

                    if ( preg_match( "/(.*);q=([0-1]{0,1}.\d{0,4})/i", $val, $matches ) ) {
                        $lang[$matches[1]] = (float) $matches[2];
                    } else {
                        $lang[$val] = 1.0;
                    }
                }

                $q = 0.0;
                foreach ( $lang as $key => $value ) {
                    if ( $value > $q ) {
                        $q = (float) $value;
                        $default = $key;
                    }
                }

                return $default;

            }
            return false;
        }

        /**
         * Get user browser info based on $_SERVER['HTTP_USER_AGENT']
         *
         * @link  https://stackoverflow.com/questions/3441880/get-users-os-and-version-number/15497878#15497878
         * @access public
         * @return false|language
         */
        public static function get_browser() {
            $user_agent = $_SERVER['HTTP_USER_AGENT'];
            $browser = false;
            $browser_array  = [
                '/msie/i'      =>  'Internet Explorer',
                '/firefox/i'   =>  'Firefox',
                '/safari/i'    =>  'Safari',
                '/konqueror/i' =>  'Konqueror',
                '/chrome/i'    =>  'Chrome',
                '/edge/i'      =>  'Edge',
                '/opera/i'     =>  'Opera',
                '/netscape/i'  =>  'Netscape',
                '/mobile/i'    =>  'Handheld Browser'
            ];

            foreach ( $browser_array as $regex => $value ) {
                if ( preg_match( $regex, $user_agent ) ) {
                    $browser = $value;
                }
            }

            return $browser;
        }

        /**
         * Get referrer URL if available
         *
         * @access public
         * @return array|url|domain
         */
        public static function get_referrer() {

            if ( !empty( $_SERVER['HTTP_REFERER'] ) ) {
                
                $url = $_SERVER['HTTP_REFERER'];
                $parts = parse_url( $url );

                if ( $parts === false || empty( $parts['host'] ) ) {
                    return false;
                }

                $array = array(
                    'url' => $url,
                    'domain' => $parts['host'],
                );

                return $array;
            }
            return false;
        }

        /**
         * Get user agent
         *
         * @access public
         * @return string
         */
        public static function get_user_agent() {
            return $_SERVER['HTTP_USER_AGENT'];
        }

        /**
         * Get user country and city if available
         * through IP-based geolocation.
         *
         * @link  http://www.geoplugin.net
         * @access public
         * @return city|country
         */
        public static function get_location() {
            
            $cookie_obj = new FTI_Cookies();
            $cookie = $cookie_obj->get( md5( 'fave_visitor_location' ) );

            if ( ! empty( $cookie ) ) {
                return $cookie;
            }

            $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=". self::get_ip()));
            //$ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=54.36.149.47")); 
/*print_r($ipdat);
wp_die();*/
            $geoplugin_city = $ipdat->geoplugin_city;
            $geoplugin_countryName = $ipdat->geoplugin_countryName;
            $geoplugin_countryCode = $ipdat->geoplugin_countryCode;
        
            $location_data = $ipdat->geoplugin_city.','.$ipdat->geoplugin_countryName.','.$geoplugin_countryCode;
            
            $cookie_obj->set( md5( 'fave_visitor_location' ), $location_data, time() + DAY_IN_SECONDS );

            return $location_data;
        }


    }
}