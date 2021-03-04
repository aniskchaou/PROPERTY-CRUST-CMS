<?php
/**
 * Created by PhpStorm.
 * User: waqasriaz
 * Date: 02/10/15
 * Time: 11:45 AM
 */
/*-----------------------------------------------------------------------------------*/
// Allowed HTML tags
/*-----------------------------------------------------------------------------------*/
if( !function_exists('houzez_allowed_html')) {
    function houzez_allowed_html() {
        $allowed_html_array = array(
            'a' => array(
                'href' => array(),
                'title' => array(),
                'target' => array()
            ),
            'strong' => array(),
            'th' => array(),
            'td' => array(),
            'span' => array(),
        ); 
        return $allowed_html_array;
    }
}

if( !function_exists('houzez_minify_js') ) {
    function houzez_minify_js() {
        $minify_js = houzez_option('minify_js');
        $js_minify_prefix = '';
        if ($minify_js != 0) {
            $js_minify_prefix = '.min';
        }
        return $js_minify_prefix;
    }
}


/*-----------------------------------------------------------------------------------*/
// Check if page build with elementor 
/*-----------------------------------------------------------------------------------*/
if(!function_exists('houzez_check_is_elementor')) {
    function houzez_check_is_elementor(){
        global $post;
        if ( did_action( 'elementor/loaded' ) ) {
            return \Elementor\Plugin::$instance->db->is_built_with_elementor($post->ID);
        }
        return false;
    }
}

if(!function_exists('givewp_check_is_elementor')) {
    function givewp_check_is_elementor(){
        global $post;
        if ( did_action( 'elementor/loaded' ) ) {
            return \Elementor\Plugin::$instance->db->is_built_with_elementor($post->ID);
        }
        return false;
    }
}


if( !function_exists('houzez_get_search_filters_class') ) {
    function houzez_get_search_filters_class() {
        if( houzez_is_half_map() ) {
            return 'houzez-search-filters-js';
        }
        return '';
    }
}

if( !function_exists('houzez_search_filters_class') ) {
    function houzez_search_filters_class() {
        echo houzez_get_search_filters_class();
    }
}

if( !function_exists('houzez_check_classic_editor') ) {
    function houzez_check_classic_editor() {

        if( class_exists('Classic_Editor') || isset( $_GET['classic-editor'] ) ) {
            return true;
        }
        return false;

    }
}

/*-----------------------------------------------------------------------------------*/
// Register locations in theme for elementor templates 
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'houzez_register_elementor_templates_locations' ) ) {

    function houzez_register_elementor_templates_locations( $elementor_theme_manager ) {

        $elementor_theme_manager->register_location( 'header' );
        $elementor_theme_manager->register_location( 'footer' );
        $elementor_theme_manager->register_location( 'single' );
        $elementor_theme_manager->register_location( 'archive' );
    }

    add_action( 'elementor/theme/register_locations', 'houzez_register_elementor_templates_locations' );
}

if( !function_exists('houzez_get_listing_data')) {
    function houzez_get_listing_data($field, $single = true) {
        $prefix = 'fave_';
        $data = get_post_meta(get_the_ID(), $prefix.$field, $single);

        if($data != '') {
            return $data;
        }
        return '';
    }
}

if( !function_exists('houzez_is_ajax_request') ) {
    function houzez_is_ajax_request() {
        if ( ! empty( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest' ) {
            return true;
        }
        return false;
    }
}

if( !function_exists('houzez_get_lazyload_for_bg') ) {
    function houzez_get_lazyload_for_bg() {
        if( houzez_option('lazyload_images', 0) ) {
            return 'houzez-lazy-bg houzez-lazyload';
        }
        return '';
    }
}

if( !function_exists('houzez_get_local') ) {
    function houzez_get_local() {
        $local = get_locale();
        $local = explode('_', $local);

        if( isset( $local[0] ) && !empty($local[0]) ) {
            return $local[0];
        }
        
        return 'en';
    }
}

if( !function_exists( 'houzez_is_bedsbaths_range' )) {
    function houzez_is_bedsbaths_range() {
        $is_enabled = houzez_option( 'range-bedsroomsbaths', 0 );

        if( $is_enabled ) {
            return true;
        }

        return false;
    }
}

if( !function_exists( 'houzez_input_attr_for_bbr' )) {
    function houzez_input_attr_for_bbr() {
        
        $return = 'type="number" min="1" max="99"';
        if( houzez_is_bedsbaths_range() ) {
            $return = 'type="text"';
        }

        echo $return;

    }
}


if( !function_exists('houzez_current_screen')) {
    function houzez_current_screen() {
        global $pagenow;
        $post_type = houzez_admin_post_type();

        $get_action = isset($_GET['action']) ? $_GET['action'] : '';

        if( $post_type == 'page' && ( $pagenow == 'post-new.php' || $get_action == 'edit' ) ) {
            return 'admin_page';
        } 
        return 'others';
    }
}

if( !function_exists('houzez_admin_post_type') ) {
    function houzez_admin_post_type () {
        global $post, $parent_file, $typenow, $current_screen, $pagenow;

        $post_type = NULL;

        if($post && (property_exists($post, 'post_type') || method_exists($post, 'post_type')))
            $post_type = $post->post_type;

        if(empty($post_type) && !empty($current_screen) && (property_exists($current_screen, 'post_type') || method_exists($current_screen, 'post_type')) && !empty($current_screen->post_type))
            $post_type = $current_screen->post_type;

        if(empty($post_type) && !empty($typenow))
            $post_type = $typenow;

        if(empty($post_type) && function_exists('get_current_screen'))
            $post_type = get_current_screen();

        if(empty($post_type) && isset($_REQUEST['post']) && !empty($_REQUEST['post']) && function_exists('get_post_type') && $get_post_type = get_post_type((int)$_REQUEST['post']))
            $post_type = $get_post_type;

        if(empty($post_type) && isset($_REQUEST['post_type']) && !empty($_REQUEST['post_type']))
            $post_type = sanitize_key($_REQUEST['post_type']);

        if(empty($post_type) && 'edit.php' == $pagenow)
            $post_type = 'post';

        return $post_type;
    }
}


if( !function_exists('houzez_get_form_user_type') ) {
    function houzez_get_form_user_type($token) {
    
       $value = '';
       
       if( $token == 'buyer' ) {
            $value = houzez_option('spl_con_buyer', "I'm a buyer");

       } else if( $token == 'tennant' ) {
            $value = houzez_option('spl_con_tennant', "I'm a tennant");

       } else if( $token == 'agent' ) {
            $value = houzez_option('spl_con_agent', "I'm an agent");

       } else if( $token == 'other' ) {
            $value = houzez_option('spl_con_other', "Other");
       } 

       return $value;
    }
}

if( !function_exists('houzez_lazyload_for_bg') ) {
    function houzez_lazyload_for_bg() {
        echo houzez_get_lazyload_for_bg();
    }
}

if( !function_exists('houzez_banner_search_autocomplete_html') ) {
    function houzez_banner_search_autocomplete_html () {
        global $post;
        $banner_search = get_post_meta( $post->ID, 'fave_page_header_search', true );

        if( $banner_search ) {
            if( houzez_option('banner_radius_search', 0) != 1 ) {
                echo '<div id="houzez-auto-complete-banner" class="auto-complete"></div>';
            }
        }
    }
}

if( !function_exists('houzez_get_header_search_position')) {
    function houzez_get_header_search_position() {
        
        $search_position = houzez_option('search_position');
        $adv_search_pos = get_post_meta(get_the_ID(), 'fave_adv_search_pos', true);
        $hide_show = get_post_meta(get_the_ID(), 'fave_adv_search', true);
        $header_type = get_post_meta(get_the_ID(), 'fave_header_type', true);

        if( $adv_search_pos == 'under_menu' && $hide_show == 'hide_show') {
            $search_position = 'under_banner';

        } elseif( $adv_search_pos == 'under_banner') {
            $search_position = 'under_banner';
        }

        if( $header_type == 'none' && wp_is_mobile() ) {
            $search_position = 'under_nav';
        }

        return $search_position;
    }
}

if( !function_exists('houzez_after_login_redirect') ) {
    function houzez_after_login_redirect() {
        global $post;
        $after_login_redirect = houzez_option('login_redirect');
        $login_redirect = home_url();
        if ($after_login_redirect == 'same_page') {

            if (is_tax()) {
                $login_redirect = get_term_link(get_query_var('term'), get_query_var('taxonomy'));
            } else {
                if (is_home() || is_front_page()) {
                    $login_redirect = home_url();
                } else {
                    if (!is_404() && !is_search() && !is_author()) {
                        $login_redirect = get_permalink($post->ID);
                    }
                }
            }

            $login_redirect = add_query_arg( 'login', 'success', $login_redirect );

        } else {
            $login_redirect = houzez_option('login_redirect_link');
        }

        if ($after_login_redirect == 'same_page' && houzez_is_login_page()) {
            $login_redirect = home_url();
            $login_redirect = add_query_arg( 'login', 'success', $login_redirect );
        }

        return $login_redirect;
    }
}

if(!function_exists('houzez_get_percent_up_down')) {
    function houzez_get_percent_up_down($old_number, $new_number) {

        if( $old_number != 0 ) {
            $percent = (($new_number - $old_number) / $old_number * 100);
        } else {
            $percent = $new_number * 100;
        }
        

        $class = 'text-success';
        $arrow = 'icon-arrow-button-up-2';
        if( $old_number > $new_number ) {
            $class = 'text-danger';
            $arrow = 'icon-arrow-button-down-2';
        } 
        
        $output = '<div class="views-percentage '.$class.'">
            <i class="houzez-icon '.$arrow.'"></i> '.round($percent, 1).'%
        </div>';

        return $output;
    }
}

if( !function_exists('houzez_currency_switcher_enabled')) {
    function houzez_currency_switcher_enabled() {
        $currency_switcher_enable = houzez_option('currency_switcher_enable', 0);

        if( $currency_switcher_enable ) {
            return true;
        }
        return false;
    }
}

if(!function_exists('houzez_views_percentage')) {
    function houzez_views_percentage($old_number, $new_number) {
        echo houzez_get_percent_up_down($old_number, $new_number);
    }
}

if(!function_exists('houzez_search_builtIn_fields')) {
    function houzez_search_builtIn_fields() {
        $array = array(
            'keyword',
            'city',
            'areas',
            'status',
            'type',
            'bedrooms',
            'rooms',
            'bathrooms',
            'min-area',
            'max-area',
            'min-land-area',
            'max-land-area',
            'min-price',
            'max-price',
            'property-id',
            'label',
            'state',
            'country',
            'price',
            'geolocation',
            'price-range',
            'garage',
            'year-built',
        );
        return $array;
    }
}

if(!function_exists('houzez_search_builtIn_fields_elementor')) {
    function houzez_search_builtIn_fields_elementor() {
        $array = array(
            'keyword' => esc_html__('keyword', 'houzez'),
            'status' => esc_html__('Status', 'houzez'),
            'type' => esc_html__('Type', 'houzez'),
            'bedrooms' => esc_html__('Bedrooms', 'houzez'),
            'rooms' => esc_html__('Bedrooms', 'houzez'),
            'bathrooms' => esc_html__('Bathrooms', 'houzez'),
            'min-area' => esc_html__('Min Area', 'houzez'),
            'max-area' => esc_html__('Max Area', 'houzez'),
            'min-price' => esc_html__('Min Price', 'houzez'),
            'max-price' => esc_html__('Max Price', 'houzez'),
            'property-id' => esc_html__('Property ID', 'houzez'),
            'label' => esc_html__('Labels', 'houzez'),
            'min-land-area' => esc_html__('Min Land Area', 'houzez'),
            'max-land-area' => esc_html__('Max Land Area', 'houzez'),
            'country' => esc_html__('Country', 'houzez'),
            'state' => esc_html__('State', 'houzez'),
            'city' => esc_html__('City', 'houzez'),
            'areas' => esc_html__('Area', 'houzez'),
            'geolocation' => esc_html__('Geolocation', 'houzez'),
            'price-range' => esc_html__('Price Range', 'houzez'),
            'garage' => esc_html__('Garage', 'houzez'),
            'year-built' => esc_html__('Year Built', 'houzez'),
            'submit-button' => esc_html__('Search Button', 'houzez'),
        );

        if(!taxonomy_exists('property_country')) {
            unset($array['country']);
        }

        if(!taxonomy_exists('property_state')) {
            unset($array['state']);
        }

        if(!taxonomy_exists('property_city')) {
            unset($array['city']);
        }

        if(!taxonomy_exists('property_area')) {
            unset($array['areas']);
        }

        return $array;
    }
}

if(!function_exists('houzez_custom_search_fields')) {
    function houzez_custom_search_fields() {
        $custom_fields_array = array();
        $custom_search_fields_array = array();
        if(class_exists('Houzez_Fields_Builder')) {
            $fields = Houzez_Fields_Builder::get_form_fields();

            if(!empty($fields)) {
                foreach ( $fields as $value ) {
                    $field_title = $value->label;
                    $field_name = $value->field_id;
                    $is_search = $value->is_search;
                    
                    $custom_fields_array[$field_name] = $field_title; 

                    if($is_search == 'yes') {
                        $custom_search_fields_array[$field_name] = $field_title;
                    }
                }
            }
        }

        return $custom_search_fields_array;
    }
}

if(!function_exists('houzez_details_section_fields')) {
    function houzez_details_section_fields() {
        $array = array(
            'beds',
            'baths',
            'rooms',
            'area-size',
            'area-size-unit',
            'land-area',
            'land-area-unit',
            'garage',
            'garage-size',
            'property-id',
            'year'
        );
        return $array;
    }
}

if(!function_exists('houzez_is_tax')) {
    function houzez_is_tax() {
        if(is_tax(
                array(
                    'property_type',
                    'property_status',
                    'property_feature',
                    'property_label',
                    'property_country',
                    'property_state',
                    'property_city',
                    'property_area'
                )
            )
        ) {
            return true;
        }
        return false;
    }
}

if(!function_exists('houzez_listing_composer_fields')) {
    function houzez_listing_composer_fields() {
        $array = array(
            'bed',
            'room',
            'bath',
            'garage',
            'area-size',
            'land-area',
            'year-built',
            'property-id',
        );
        return $array;
    }
}

if(!function_exists('houzez_overview_composer_fields')) {
    function houzez_overview_composer_fields() {
        $array = array(
            'type',
            'bedrooms',
            'rooms',
            'bathrooms',
            'garage',
            'area-size',
            'land-area',
            'year-built',
            'property-id',
        );
        return $array;
    }
}

if(!function_exists('houzez_listing_fields_for_icons')) {
    function houzez_listing_fields_for_icons() {
        $array = array(
            'bed' => esc_html__('Bed', 'houzez'),
            'room' => esc_html__('Room', 'houzez'),
            'bath' => esc_html__('Bath', 'houzez'),
            'garage' => esc_html__('Garage', 'houzez'),
            'area-size' => esc_html__('Area Size', 'houzez'),
            'land-area' => esc_html__('Land Area Size', 'houzez'),
            'year-built' => esc_html__('Year Built', 'houzez'),
            'property-id' => esc_html__('Property ID', 'houzez'),
        );
        return $array;
    }
}

if(!function_exists('houzez_listing_fields_for_icons_luxury')) {
    function houzez_listing_fields_for_icons_luxury() {
        $array = array(
            'icon_prop_id' => esc_html__('Property ID', 'houzez'),
            'icon_bedrooms' => esc_html__('Bedrooms', 'houzez'),
            'icon_rooms' => esc_html__('Rooms', 'houzez'),
            'icon_bathrooms' => esc_html__('Bathrooms', 'houzez'),
            'icon_prop_size' => esc_html__('Property Size', 'houzez'),
            'icon_prop_land' => esc_html__('Land Size', 'houzez'),
            'icon_garage_size' => esc_html__('Garage Size', 'houzez'),
            'icon_garage' => esc_html__('Garage', 'houzez'),
            'icon_year' => esc_html__('Year Built', 'houzez'),
        );
        return $array;
    }
}

if( !function_exists('houzez_dock_search_class')) {
    function houzez_dock_search_class() {
        $dock_search_enable = houzez_option('enable_advanced_search_over_headers');
        $search_over_header_pages = houzez_option('adv_search_over_header_pages');
        $search_selected_pages = houzez_option('adv_search_selected_pages');
        $return_class = '';

        if( $dock_search_enable != 0 ) {
            if( $search_over_header_pages == 'only_home' ) {
                if (is_front_page()) {
                    $return_class = 'top-banner-wrap-dock-search';
                }
            } else if( $search_over_header_pages == 'all_pages' ) {
                    $return_class = 'top-banner-wrap-dock-search';

            } else if ( $search_over_header_pages == 'only_innerpages' ){
                if (!is_front_page()) {
                     $return_class = 'top-banner-wrap-dock-search';
                }
            } else if( $search_over_header_pages == 'specific_pages' ) {
                if( is_page( $search_selected_pages ) ) {
                     $return_class = 'top-banner-wrap-dock-search';
                }
            }
        }

        return $return_class;
    }
}

if(!function_exists('houzez_v1_4_meta_type')) {
    function houzez_v1_4_meta_type() {
        $v1_4_meta_type = houzez_option('v1_4_meta_type');
        if($v1_4_meta_type == 'icons') {
            $icons_class = 'item-amenities-with-icons';
        } elseif($v1_4_meta_type == 'text') {
            $icons_class = 'item-amenities-without-icons';
        } else {
            $icons_class = '';
        }

        return $icons_class;
    } 
}

if( !function_exists('houzez_is_admin') ) {
    function houzez_is_admin() {
        global $current_user;
        $current_user = wp_get_current_user();

        if (in_array('administrator', (array)$current_user->roles)) {
            return true;
        }
        return false;
    }
}

if(!function_exists('houzez_v2_meta_type')) {
    function houzez_v2_meta_type() {
        $v2_meta_type = houzez_option('v2_meta_type');
        if($v2_meta_type == 'icons') {
            $icons_class = 'item-amenities-with-icons';
        } elseif($v2_meta_type == 'without_icons') {
            $icons_class = 'item-amenities-without-icons';
        } else {
            $icons_class = '';
        }

        return $icons_class;
    } 
}

if(!function_exists('houzez_is_multiselect')) {
    function houzez_is_multiselect($value = false) {
        if($value) {
            return true;
        }
        return false;
    }
}

if(!function_exists('houzez_get_multiselect')) {
    function houzez_get_multiselect($value) {
        $is_multiselect = houzez_is_multiselect($value);

        if($is_multiselect) {
            return 'multiple';
        }
        return '';
    }
}

if(!function_exists('houzez_multiselect')) {
    function houzez_multiselect($value) {
        echo houzez_get_multiselect($value);
    }
}

if(!function_exists('houzez_get_ajax_search')) {
    function houzez_get_ajax_search() {
        $ajax_class = '';
        if( (is_page_template(array('template/template-search.php')) && houzez_option('search_result_page') == 'half_map') || is_page_template(array('template/property-listings-map.php')) ) {
            $ajax_class = 'houzez_search_ajax';

        }
        return $ajax_class;
    }
}

if( !function_exists('houzez_hide_calulator')) {
    function houzez_hide_calculator() {
        $term_status = wp_get_post_terms( get_the_ID(), 'property_status', array("fields" => "all"));

        if ( ! empty( $term_status ) && ! is_wp_error( $term_status ) ) {

            $cal_where = houzez_option('cal_where');
            if( empty($cal_where) ) {
                $cal_where = array();
            }
            
            if( in_array( $term_status[0]->term_id, $cal_where ) ) {
                return false;
            }
        }
       
        return true;
    }
}

if(!function_exists('houzez_ajax_search')) {
    function houzez_ajax_search() {
        echo houzez_get_ajax_search();
    }
}

if(!function_exists('houzez_is_half_map')) {
    function houzez_is_half_map() {

        if( (is_page_template(array('template/template-search.php')) && houzez_option('search_result_page') == 'half_map') || is_page_template(array('template/property-listings-map.php')) ) {
            return true;

        }
        return false;
    }
}

if(!function_exists('houzez_half_map_layout')) {
    function houzez_half_map_layout() {
        $listing_view = '';
        if( (is_page_template(array('template/template-search.php')) && houzez_option('search_result_page') == 'half_map')) {
            $listing_view = houzez_option('search_result_posts_layout', 'list-view-v1');

        } elseif(is_page_template(array('template/property-listings-map.php'))) {
            $listing_view = houzez_option('halfmap_posts_layout', 'list-view-v1');

        }
        if($listing_view == 'list-view-v1' || $listing_view == 'list-view-v2' || $listing_view == 'list-view-v5') {

            $listing_view = 'list-view';

        } 

        return $listing_view;
    }
}

if( !function_exists('houzez_is_splash') ) {
    function houzez_is_splash() {
        if ( is_page_template( array(
            'template/template-splash.php',
        ) )
        ) {
            return true;
        }
        return false;
    }
}

if( !function_exists('houzez_is_login_page') ) {
    function houzez_is_login_page() {
        if ( is_page_template( array(
            'template/template-login.php',
        ) )
        ) {
            return true;
        }
        return false;
    }
}

if( !function_exists('houzez_get_transparent') ) {
    function houzez_get_transparent() {
        $css_class = '';
        $transparent = get_post_meta(get_the_ID(), 'fave_main_menu_trans', true);
        $header_type = get_post_meta(get_the_ID(), 'fave_header_type', true);
        $header_style = houzez_option('header_style');

        if( $transparent != 'no' && $header_type != 'none' && !empty($transparent) && !empty($header_type) && $header_style == '4' && !wp_is_mobile() ) {
            $css_class = 'header-transparent-wrap';
        }

        if(houzez_is_splash()) {
            $css_class = 'header-transparent-wrap';
        }
        return $css_class;
    }
}

if( !function_exists('houzez_transparent') ) {
    function houzez_transparent() {
        echo houzez_get_transparent();
    }
}

if( !function_exists('houzez_is_transparent_logo') ) {
    function houzez_is_transparent_logo() {
        $css_class = '';
        $header_type = houzez_option('header_style');
        $transparent = get_post_meta(get_the_ID(), 'fave_main_menu_trans', true);

        if( $transparent != 'no' && !empty($transparent) && ($header_type == '4') ) {
            return true;
        }

        if(houzez_is_splash()) {
            return true;
        }
        return false;
    }
}

if( !function_exists('houzez_is_transparent') ) {
    function houzez_is_transparent() {
        $transparent = get_post_meta(get_the_ID(), 'fave_main_menu_trans', true);

        if( $transparent != 'no' && !empty($transparent) ) {
            return true;
        }
        return false;
    }
}

if(!function_exists('houzez_header_search_width')) {
    function houzez_header_search_width() {
        $search_width = houzez_option('search_width', 'container');

        if(houzez_is_half_map()) {
            $search_width = 'container-fluid';
        }

        return $search_width;
    }
}

if(!function_exists('houzez_return_formatted_date')) {
    function houzez_return_formatted_date($date_unix) {

        $return_date = '';
        if(!empty($date_unix)) {
            $return_date = date(get_option( 'date_format' ), $date_unix);
        }
        return $return_date;
        
    }
}

if(!function_exists('houzez_get_formatted_time')) {
    function houzez_get_formatted_time($date_unix) {

        $return_time = '';
        if(!empty($date_unix)) {
            $return_time = date(get_option( 'time_format' ), $date_unix);
        }
        return $return_time;
        
    }
}

if(!function_exists('houzez_search_builder')) {
    function houzez_search_builder() {
        if(houzez_is_half_map()) {
            return houzez_option('search_builder_halfmap');
        } else {
            return houzez_option('search_builder');
        }
    }
}

if(!function_exists('houzez_search_builder_first_row')) {
    function houzez_search_builder_first_row() {

        if( (isset($_GET['search_style']) && $_GET['search_style'] == 'style_3') || ( isset($_GET['halfmap_search']) && $_GET['halfmap_search'] == 'v3') ) {
            return 5;
        }

        if(houzez_is_half_map()) {
            return houzez_option('search_top_row_fields_halfmap');
        } else {
            return houzez_option('search_top_row_fields');
        }
    }
}

if(!function_exists('houzez_is_radius_search')) {
    function houzez_is_radius_search() {
        if(houzez_is_half_map()) {
            return houzez_option('enable_radius_search_halfmap');
        } else {
            return houzez_option('enable_radius_search');
        }
    }
}

if(!function_exists('houzez_is_price_range_search')) {
    function houzez_is_price_range_search() {
        if(houzez_is_half_map()) {
            return houzez_option('price_range_halfmap');
        } else {
            return houzez_option('price_range');
        }
    }
}

if( !function_exists('houzez_is_woocommerce')) {
    function houzez_is_woocommerce() {

        if( houzez_option('houzez_payment_gateways', 'houzez_custom_gw') == 'gw_woocommerce' && class_exists( 'WooCommerce' ) ) {
            return true;
        } else {
            return false;
        }
    }
}

if(!function_exists('houzez_search_style')) {
    function houzez_search_style() {

        $search_style = houzez_option('search_style', 'style_1');
        $halfmap_search = houzez_option('halfmap_search_layout', 'v1');

        if(isset($_GET['search_style'])) {
            $search_style = $_GET['search_style'];
        }
        if(isset($_GET['halfmap_search'])) {
            $halfmap_search = $_GET['halfmap_search'];
        }

        if(houzez_is_half_map()) {

            if( $halfmap_search == 'v3' ) {
                return true;
            } else {
                return false;
            }
            
        } else {
            if( $search_style == 'style_3' ) {
                return true;
            } else {
                return false;
            }
        }
    }
}

if(!function_exists('houzez_is_other_featuers_search')) {
    function houzez_is_other_featuers_search() {
        if(houzez_is_half_map()) {
            return houzez_option('search_other_features_halfmap');
        } else {
            return houzez_option('search_other_features');
        }
    }
}

if(!function_exists('houzez_adv_search_visible')) {
    function houzez_adv_search_visible() {
        $adv_visible = houzez_option('header-search-visible', 0);
        $adv_halfmap_visible = houzez_option('halfmap-search-visible', 0);

        if( isset($_GET['s_visible']) && $_GET['s_visible'] == 'yes' ) {
            $adv_visible = 1;
        }

        if(houzez_is_half_map()) {
            return $adv_halfmap_visible;
        } else {
            return $adv_visible;
        }
    }
}

if(!function_exists('houzez_adv_visible_class')) {
    function houzez_adv_visible_class() {

        if(houzez_adv_search_visible()) {
            return 'show';
        }
        return '';
    }
}

if( !function_exists('houzez_dummy_search_style_3') ) {
    
    function houzez_dummy_search_style_3() {
        
        $fields_array = array( 
            'keyword' => 'Keyword',
            'bedrooms' => 'Bedrooms',
            'price' => 'Price',
            'type' => 'Type', 
            'status' => 'Status',
            'city' => 'city',
            'min-area' => 'min-area',
            'max-area' => 'max-area',
            'bathrooms' => 'Bathrooms',
            'property-id' => 'property-id',
        );
        return $fields_array;
    }
}

if(!function_exists('houzez_get_term_slug')) {
    function houzez_get_term_slug($term_id, $tax) {
        if(!empty($term_id)) {
            $term = get_term( $term_id, $tax );

            if( !is_wp_error($term) && !empty($term) ) {
                return $term->slug;
            }
            return '';
        }
        return '';
    }
}

if(!function_exists('houzez_hide_empty_taxonomies')) {
    function houzez_hide_empty_taxonomies() {
        $state_city_area_dropdowns = houzez_option('state_city_area_dropdowns');
        if( $state_city_area_dropdowns != 0 ) {
            $hide_empty = true;
        } else {
            $hide_empty = false;
        }

        return $hide_empty;
    }
}

if(!function_exists('houzez_enable_svg_type')) {
    function houzez_enable_svg_type($mimes) {
      $mimes['svg'] = 'image/svg+xml';
      return $mimes;
    }
}
add_filter('upload_mimes', 'houzez_enable_svg_type');

if( !function_exists('houzez_listing_data')) {
    function houzez_listing_data($field) {
        echo houzez_get_listing_data($field);
    }
}

if( !function_exists('houzez_get_listing_data_by_id')) {
    function houzez_get_listing_data_by_id($field, $ID) {
        $prefix = 'fave_';
        $data = get_post_meta($ID, $prefix.$field, true);

        if($data != '') {
            return $data;
        }
        return '';
    }
}

if( !function_exists('houzez_field_meta')) {
    function houzez_field_meta($field_name, $escape = true) {
        echo houzez_get_field_meta($field_name, $escape);
    }
}

if( !function_exists('houzez_get_field_meta')) {
    function houzez_get_field_meta($field_name, $escape = true) {
        global $prop_meta_data;

        $prefix = 'fave_';
        $field_name = $prefix.$field_name;

        if (isset($prop_meta_data[$field_name])) {
            if($escape) {
                return sanitize_text_field($prop_meta_data[$field_name][0]);
            } else {
                return $prop_meta_data[$field_name][0];
            }
        } else {
            return;
        }
    }
}

if( !function_exists('houzez_listing_data_by_id')) {
    function houzez_listing_data_by_id($field, $ID) {
        echo houzez_get_listing_data_by_id($field, $ID);
    }
}
if( !function_exists('houzez_wpml_translate_single_string') ) {
    function houzez_wpml_translate_single_string($string_name) {
        $translated_string = apply_filters('wpml_translate_single_string', $string_name, 'houzez_cfield', $string_name );

        return $translated_string;
    }
}

if( !function_exists('houzez_banner_fullscreen') ) {
    function houzez_banner_fullscreen() {
        $banner_height = get_post_meta(get_the_ID(), 'fave_header_full_screen', true);
        if( $banner_height != 0 ) {
            echo 'top-banner-wrap-fullscreen';
        }
        return '';
    }
}
if( !function_exists('houzez_banner_search_type') ) {
    function houzez_banner_search_type() {
        $banner_search = get_post_meta(get_the_ID(), 'fave_page_header_search', true);
        $search_style = get_post_meta(get_the_ID(), 'fave_head_search_style', true);
        if( $banner_search != 0 ) {
            if($search_style == 'vertical') {
                echo 'vertical-search-wrap';
            } else {
                echo 'horizontal-search-wrap';
            }
        }
        return '';
    }
}

if(!function_exists('houzez_form_type')) {
    function houzez_form_type() {
        $form_type = houzez_option('form_type', 'custom_form');

        if($form_type == 'contact_form_7_gravity_form') {
            return true;
        }
        return false;
    }
}

if( !function_exists('houzez_get_map_system') ) {
    function houzez_get_map_system() {
        $houzez_map_system = houzez_option('houzez_map_system');

        if($houzez_map_system == 'osm' || $houzez_map_system == 'mapbox') {
            $map_system = 'osm';
        } elseif($houzez_map_system == 'google' && houzez_option('googlemap_api_key') != "") {
            $map_system = 'google';
        } else {
            $map_system = 'osm';
        }
        return $map_system;
    }
}

if( !function_exists('houzez_load_ui_slider') ) {
    function houzez_load_ui_slider() {

        if( houzez_option('enable_radius_search_halfmap', 0) ||
            houzez_option('price_range_halfmap', 0) || 
            houzez_option('enable_radius_search', 0) || 
            houzez_option('price_range', 0) || 
            houzez_option('price_range_mobile', 0)
        ) {
            return true;
        }
        return false;
    }
}

if( !function_exists('houzez_get_all_countries') ):
    function houzez_get_all_countries( $selected = '' ) {
        $taxonomy  = 'property_country';
        $args = array(
            'hide_empty'  => false
        );
        $tax_terms      =   get_terms($taxonomy,$args);
        $select_country    =   '';

        foreach ($tax_terms as $tax_term) {
            $select_country.= '<option value="' . $tax_term->slug.'" ';
            if($tax_term->slug == $selected){
                $select_country.= ' selected="selected" ';
            }
            $select_country.= ' >' . $tax_term->name . '</option>';
        }
        return $select_country;
    }
endif;

if( !function_exists('houzez_metabox_map_type') ) {
    function houzez_metabox_map_type() {
        $houzez_map_system = houzez_option('houzez_map_system');

        if($houzez_map_system == 'osm' || $houzez_map_system == 'mapbox') {
            $map_system = 'osm';
        } elseif($houzez_map_system == 'google') {
            $map_system = 'map';
        } else {
            $map_system = 'osm';
        }
        return $map_system;
    }
}

if( !function_exists('houzez_map_api_key') ) {

    function houzez_map_api_key() {

        $houzez_map_system = houzez_get_map_system();   
        $mapbox_api_key = houzez_option('mapbox_api_key');   
        $googlemap_api_key = houzez_option('googlemap_api_key'); 

        if($houzez_map_system == 'google') {
            $googlemap_api_key = urlencode( $googlemap_api_key );
            return $googlemap_api_key;

        } elseif($houzez_map_system == 'osm') {
            $mapbox_api_key = urlencode( $mapbox_api_key );
            return $mapbox_api_key;
        }
    }
}

if(!function_exists('houzez_map_in_section')) {
    function houzez_map_in_section() {
        if(houzez_option('map_in_section') == 1) {
            return true;

        } elseif(isset($_GET['map_in_section']) && $_GET['map_in_section'] == 'yes') {
            return true;

        } elseif( houzez_option('prop-top-area') == 'v6' ) {

            return true;
        }
        return false;
    }
}

if( !function_exists('houzez_get_show_phone') ) {
    function houzez_get_show_phone() {
        $phone_number_full = houzez_option('phone_number_full', 1);
        $class = '';
        if( $phone_number_full != 1 ) {
            $class = "agent-show-onClick agent-phone-hidden";
        }

        return $class;
    }
}

if( !function_exists('houzez_show_phone') ) {
    function houzez_show_phone() {
        echo houzez_get_show_phone();
    }
}

if( !function_exists('houzez_container_needed') ) {
    function houzez_container_needed() {

        $files = apply_filters( 'houzez_container_needed_filter', array(
            'template/property-listings-map.php',
            'template/user_dashboard_profile.php',
            'template/user_dashboard_properties.php',
            'template/user_dashboard_favorites.php',
            'template/user_dashboard_invoices.php',
            'template/user_dashboard_saved_search.php',
            'template/user_dashboard_floor_plans.php',
            'template/user_dashboard_multi_units.php',
            'template/user_dashboard_membership.php',
            'template/user_dashboard_gdpr.php',
            'template/user_dashboard_submit.php',
            'template/template-thankyou.php',
            'template/user_dashboard_messages.php',
            'template/properties-parallax.php'
        ) );

        if( is_singular( 'property' ) ) {
            return false;
        } elseif ( is_page_template( $files ) ) {
            return false;
        }
        return true;
    }
}

if( !function_exists('houzez_is_landing_page') ) {
    function houzez_is_landing_page() {

        $files = apply_filters( 'houzez_is_landing_page_filter', array(
            'template/property-listings-map.php',
            'template/user_dashboard_profile.php',
            'template/user_dashboard_properties.php',
            'template/user_dashboard_favorites.php',
            'template/user_dashboard_invoices.php',
            'template/user_dashboard_saved_search.php',
            'template/user_dashboard_floor_plans.php',
            'template/user_dashboard_multi_units.php',
            'template/user_dashboard_membership.php',
            'template/user_dashboard_gdpr.php',
            'template/user_dashboard_submit.php',
            'template/user_dashboard_messages.php'
        ) );

        if ( is_page_template( $files ) ) {
            return true;
        }
        return false;
    }
}

if( !function_exists('houzez_is_dashboard') ) {
    function houzez_is_dashboard() {

        $files = apply_filters( 'houzez_is_dashboard_filter', array(
            'template/user_dashboard_profile.php',
            'template/user_dashboard_insight.php',
            'template/user_dashboard_crm.php',
            'template/user_dashboard_properties.php',
            'template/user_dashboard_favorites.php',
            'template/user_dashboard_invoices.php',
            'template/user_dashboard_saved_search.php',
            'template/user_dashboard_floor_plans.php',
            'template/user_dashboard_multi_units.php',
            'template/user_dashboard_membership.php',
            'template/user_dashboard_gdpr.php',
            'template/user_dashboard_submit.php',
            'template/user_dashboard_messages.php'
            
        ) );

        if ( is_page_template($files) ) {
            return true;
        }
        return false;
    }
}

if( !function_exists('houzez_is_listings_template') ) {
    function houzez_is_listings_template() {

        $files = apply_filters( 'houzez_is_listings_template_filter', array(
            'template/property-listings-map.php',
            'template/template-listing-list-v1.php',
            'template/template-listing-list-v2.php',
            'template/template-listing-list-v5.php',
            'template/template-listing-list-v1-fullwidth.php',
            'template/template-listing-list-v2-fullwidth.php',
            'template/template-listing-list-v5-fullwidth.php',
            'template/template-listing-grid-v1.php',
            'template/template-listing-grid-v1-fullwidth-2cols.php',
            'template/template-listing-grid-v1-fullwidth-3cols.php',
            'template/template-listing-grid-v1-fullwidth-4cols.php',
            'template/template-listing-grid-v2.php',
            'template/template-listing-grid-v2-fullwidth-2cols.php',
            'template/template-listing-grid-v2-fullwidth-3cols.php',
            'template/template-listing-grid-v2-fullwidth-4cols.php',
            'template/template-listing-grid-v4.php',
            'template/template-listing-grid-v5.php',
            'template/template-listing-grid-v5-fullwidth-2cols.php',
            'template/template-listing-grid-v5-fullwidth-3cols.php',
            'template/template-listing-grid-v6.php',
            'template/template-listing-grid-v6-fullwidth-2cols.php',
            'template/template-listing-grid-v6-fullwidth-3cols.php',
            'template/template-listing-grid-v3.php',
            'template/template-listing-grid-v3-fullwidth-2cols.php',
            'template/template-listing-grid-v3-fullwidth-3cols.php',
        ) );

        if ( is_page_template( $files ) ) {
            return true;
        }
        return false;
    }
}

if(!function_exists('houzez_map_needed')) {
    function houzez_map_needed() {
        global $post;
        
        $post_id = isset($post->ID) ? $post->ID : 0;
        $header_type = get_post_meta($post_id, 'fave_header_type', true);
        
        if(is_page_template('template/user_dashboard_submit.php')) {
            return true;

        } elseif($header_type == 'property_map') {
            return true;

        } elseif(is_page_template('template/property-listings-map.php')) {
            return true;

        } elseif(is_page_template('template/template-search.php') && houzez_option('search_result_page') == 'half_map') {
            return true;

        } elseif ( is_singular( 'property' ) ) {
            return true;
        }

        return false;
    }
}


if( !function_exists( 'houzez_browser_body_class' ) ) {
    function houzez_browser_body_class($classes) {
        global $post;
        
        if(houzez_is_dashboard()) {
            $classes[] = 'houzez-dashboard';
        }    
        
        if ( is_page_template( 'template/template-onepage.php' ) ) {
            $classes[] = 'houzez-onepage-mode';
        }

        if( houzez_is_half_map() ) {
            $classes[] = 'houzez-halfmap-page';
        }

        $fave_head_trans = 'no';
        if( houzez_postid_needed() ) {
            $header_type = get_post_meta($post->ID, 'fave_header_type', true);
            $fave_page_header_search = get_post_meta($post->ID, 'fave_page_header_search', true);
            if ($fave_page_header_search != 'yes') {
                $fave_head_trans = get_post_meta($post->ID, 'fave_main_menu_trans', true);

                $classes[] = 'transparent-'.$fave_head_trans;
            }
            $classes[] = 'houzez-header-'.$header_type;
        }
            
        return $classes;
    }
    add_filter('body_class', 'houzez_browser_body_class');
}


if( !function_exists('houzez_search_needed') ) {
    function houzez_search_needed() {

        $files = apply_filters( 'houzez_search_needed_filter', array(
            'template/property-listings-map.php',
            'template/user_dashboard_profile.php',
            'template/user_dashboard_properties.php',
            'template/user_dashboard_favorites.php',
            'template/user_dashboard_invoices.php',
            'template/user_dashboard_saved_search.php',
            'template/user_dashboard_floor_plans.php',
            'template/user_dashboard_multi_units.php',
            'template/user_dashboard_membership.php',
            'template/user_dashboard_gdpr.php',
            'template/user_dashboard_submit.php',
            'template/template-packages.php',
            'template/template-payment.php',
            'template/template-thankyou.php',
            'template/user_dashboard_messages.php'
        ) );

        if( is_singular( 'property' ) ) {
            return true;
        } elseif( is_search() ) {
            return false;
        }  elseif( is_author() ) {
            return false;
        } elseif( is_404() ) {
            return false;
        } elseif ( is_page_template( $files ) ) {
            return false;

        } elseif(houzez_is_half_map()) {
            return false;

        } elseif(houzez_is_splash()) {
            return false;
        }
        return true;
    }
}

if(!function_exists('houzez_check_for_taxonomy')) {
    function houzez_check_for_taxonomy($tax_setting_name) {

        if(class_exists('Houzez_Taxonomies')) {
            if(Houzez_Taxonomies::get_setting($tax_setting_name) != 'disabled') {
                return true;
            } else {
                return false;
            }
        }

        return true;
    }
}

if( !function_exists('houzez_postid_needed') ) {
    function houzez_postid_needed() {
        if( is_search() ) {
            return false;
        } elseif( is_author() ) {
            return false;
        } elseif( is_404() ) {
            return false;
        }
        return true;
    }
}

if( !function_exists('houzez_is_footer') ) {
    function houzez_is_footer() {

        $files = apply_filters( 'houzez_is_footer_filter', array(
            'template/user_dashboard_profile.php',
            'template/user_dashboard_properties.php',
            'template/user_dashboard_favorites.php',
            'template/user_dashboard_invoices.php',
            'template/user_dashboard_saved_search.php',
            'template/user_dashboard_floor_plans.php',
            'template/user_dashboard_multi_units.php',
            'template/user_dashboard_membership.php',
            'template/user_dashboard_gdpr.php',
            'template/user_dashboard_submit.php',
            'template/user_dashboard_messages.php'
        ) );

        if ( is_page_template( 'template/template-splash.php' ) ) {
            return false;
        } elseif ( is_page_template( $files ) ) {
            return false;
        }
        return true;
    }
}

if(!function_exists('houzez_enqueue_maps_api')) {
    function houzez_enqueue_maps_api() {
        if(houzez_get_map_system() == 'google') {

            houzez_enqueue_google_api(); 
            houzez_enqueue_geo_location_js();

        } else {
            houzez_enqueue_osm_api();
            houzez_enqueue_osm_location_js();
        }
    }
}

if( !function_exists('houzez_check_role') ) {
    function houzez_check_role() {
        global $current_user;
        $current_user = wp_get_current_user();
        //houzez_agent, subscriber, author, houzez_buyer, houzez_owner, houzez_seller, houzez_manager, houzez_agency
        $use_houzez_roles = 1;

        if( $use_houzez_roles != 0 ) {
            if (in_array('houzez_buyer', (array)$current_user->roles) || in_array('subscriber', (array)$current_user->roles)) {
                return false;
            }
            return true;
        }
        return true;
    }
}

if( !function_exists('houzez_is_agency') ) {
    function houzez_is_agency() {
        global $current_user;
        $current_user = wp_get_current_user();
        
        if (in_array('houzez_agency', (array)$current_user->roles)) {
            return true;
        }
        return false;
    }
}

if( !function_exists('houzez_is_owner') ) {
    function houzez_is_owner() {
        global $current_user;
        $current_user = wp_get_current_user();
        
        if (in_array('houzez_owner', (array)$current_user->roles)) {
            return true;
        }
        return false;
    }
}

if( !function_exists('houzez_is_buyer') ) {
    function houzez_is_buyer() {
        global $current_user;
        $current_user = wp_get_current_user();
        
        if (in_array('houzez_buyer', (array)$current_user->roles) || in_array('subscriber', (array)$current_user->roles)) {
            return true;
        }
        return false;
    }
}

if(!function_exists('houzez_area_unit_label')) {
    function houzez_area_unit_label() {
        $measurement_unit_adv_search = houzez_option('measurement_unit_adv_search');

        if( $measurement_unit_adv_search == 'sqft' ) {
            $measurement_unit_adv_search = houzez_option('measurement_unit_sqft_text');
        } elseif( $measurement_unit_adv_search == 'sq_meter' ) {
            $measurement_unit_adv_search = houzez_option('measurement_unit_square_meter_text');
        }

        return $measurement_unit_adv_search;
    }
}


if(!function_exists('houzez_traverse_comma_string')) {
    function houzez_traverse_comma_string($string) {
        if(!empty($string)) {
            $string_array = explode(',', $string);
            
            if(!empty($string_array[0])) {
                return $string_array;
            }
        }
        return '';
    }
}

if( !function_exists('houzez_user_role_by_post_id')) {
    function houzez_user_role_by_post_id($the_id) {

        $user_id = get_post_field( 'post_author', $the_id );
        $user = new WP_User($user_id); //administrator

        if( $user->ID == 0 ) {
            return 'houzez_guest';
        }
        $user_role = $user->roles[0];
        return $user_role;
    }
}

if( !function_exists('houzez_user_role_by_user_id')) {
    function houzez_user_role_by_user_id($user_id) {

        $user = new WP_User($user_id);

        if( $user->ID == 0 ) {
            return 'houzez_guest';
        }
        $user_role = $user->roles[0];
        return $user_role;
    }
}


add_action( 'before_delete_post', 'homey_delete_property_attachments' );
if( !function_exists('homey_delete_property_attachments') ) {
    function homey_delete_property_attachments($postid) {
        
        // We check if the global post type isn't ours and just return
        global $post_type;

        if ($post_type == 'houzez_reviews') {
            houzez_adjust_listing_rating_on_delete($postid); 
        }

        if(houzez_is_demo()) {
            return;
        }
        if ($post_type == 'property') {
            $media = get_children(array(
                'post_parent' => $postid,
                'post_type' => 'attachment'
            ));
            if (!empty($media)) {
                foreach ($media as $file) {
                    wp_delete_attachment($file->ID);
                }
            }
            $attachment_ids = get_post_meta($postid, 'fave_property_images', false);
            if (!empty($attachment_ids)) {
                foreach ($attachment_ids as $id) {
                    wp_delete_attachment($id);
                }
            }
        }
        return;
    }
}

if(!function_exists('houzez_delete_property_attachments_frontend')) {
    function houzez_delete_property_attachments_frontend($postid) {
            
        // We check if the global post type isn't ours and just return
        global $post_type;


        if(houzez_is_demo()) {
            return;
        }
        $media = get_children(array(
            'post_parent' => $postid,
            'post_type' => 'attachment'
        ));
        if (!empty($media)) {
            foreach ($media as $file) {
                wp_delete_attachment($file->ID);
            }
        }
        $attachment_ids = get_post_meta($postid, 'fave_property_images', false);
        if (!empty($attachment_ids)) {
            foreach ($attachment_ids as $id) {
                wp_delete_attachment($id);
            }
        }
        return;
    }
}

// retrieves the attachment ID from the file URL
if( !function_exists('houzez_get_image_id') ) {
    function houzez_get_image_id($image_url)
    {
        global $wpdb;
        $attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url));
        return $attachment[0];
    }
}

if( !function_exists('houzez_propperty_id_prefix') ) {
    function houzez_propperty_id_prefix( $property_id ) {
        $property_id_prefix = houzez_option('property_id_prefix');
        if( !empty( $property_id_prefix ) ) {
            $property_id = $property_id_prefix.$property_id;
        }
        return $property_id;
    }
}

if( !function_exists('houzez_show_agent_box') ) {
    function houzez_show_agent_box() {
        global $current_user;
        $current_user = wp_get_current_user();
        //houzez_agent, subscriber, author, houzez_buyer, houzez_owner
        $use_houzez_roles = 1;

        if( $use_houzez_roles != 0 ) {
            if ( in_array('houzez_owner', (array)$current_user->roles) ||
                in_array('houzez_agent', (array)$current_user->roles) ||
                in_array('houzez_seller', (array)$current_user->roles) ||
                in_array('houzez_manager', (array)$current_user->roles) ||
                in_array('author', (array)$current_user->roles)
            ) {
                return false;
            }
            return true;
        }
        return true;
    }
}

if( !function_exists('houzez_is_agency') ) {
    function houzez_is_agency() {
        global $current_user;
        $current_user = wp_get_current_user();
        //houzez_agent, subscriber, author, houzez_buyer, houzez_owner
        $use_houzez_roles = 1;

        if( $use_houzez_roles != 0 ) {
            if (in_array('houzez_agency', (array)$current_user->roles) ) {
                return true;
            }
            return false;
        }
        return false;
    }
}

if( !function_exists('houzez_is_agent') ) {
    function houzez_is_agent() {
        global $current_user;
        $current_user = wp_get_current_user();
        //houzez_agent, subscriber, author, houzez_buyer, houzez_owner
        $use_houzez_roles = 1;

        if( $use_houzez_roles != 0 ) {
            if (in_array('houzez_agent', (array)$current_user->roles) ) {
                return true;
            }
            return false;
        }
        return false;
    }
}

if( !function_exists('houzez_not_buyer') ) {
    function houzez_not_buyer() {
        global $current_user;
        $current_user = wp_get_current_user();
        //houzez_agent, subscriber, author, houzez_buyer, houzez_owner
        $use_houzez_roles = 1;

        if( $use_houzez_roles != 0 ) {
            if (in_array('houzez_buyer', (array)$current_user->roles) ) {
                return false;
            }
            return true;
        }
        return true;
    }
}

if ( !function_exists('houzez_edit_property') ) {
    function houzez_edit_property() {
        if ( isset( $_GET[ 'edit_property' ] ) && ! empty( $_GET[ 'edit_property' ] ) ) {
            return true;
        }

        return false;
    }
}


if( !function_exists('houzez_check_post_status')) {
    function houzez_check_post_status( $post_id ) {
        if( get_post_status( $post_id ) == 'draft' ) {
            return false;
        }
        return true;
    }
}

if( !function_exists('houzez_is_published')) {
    function houzez_is_published( $post_id ) {
        if( get_post_status( $post_id ) == 'publish' ) {
            return true;
        }
        return false;
    }
}

if( !function_exists('houzez_on_hold')) {
    function houzez_on_hold( $post_id ) {
        if( get_post_status( $post_id ) == 'on_hold' ) {
            return true;
        }
        return false;
    }
}

if ( ! function_exists( 'houzez_http_or_https' ) ) {
    function houzez_http_or_https() {
        if (is_ssl()) {
            $http_or_https = 'https';
        } else {
            $http_or_https = 'http';
        }

        return $http_or_https;
    }
}
/* --------------------------------------------------------------------------
 * Removes version scripts number if enabled for better Google Page Speed Scores. @since Houzez 1.4.0
 ---------------------------------------------------------------------------*/
if ( ! function_exists( 'houzez_remove_wp_ver_css_js' ) ) {
    function houzez_remove_wp_ver_css_js( $src ) {
        if ( houzez_option( 'remove_scripts_version', '1' ) ) {
            if ( strpos( $src, 'ver=' ) ) {
                $src = remove_query_arg( 'ver', $src );
            }
        }
        return $src;
    }
}
add_filter( 'style_loader_src', 'houzez_remove_wp_ver_css_js', 9999 );
add_filter( 'script_loader_src', 'houzez_remove_wp_ver_css_js', 9999 );


/*-----------------------------------------------------------------------------------*/
// Get terms array
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'houzez_get_terms_array' ) ) {
    function houzez_get_terms_array( $tax_name, &$terms_array ) {

        $tax_terms = get_terms( array(
            'taxonomy'   => $tax_name,
            'hide_empty' => false,
        ) );
        houzez_add_term_children( 0, $tax_terms, $terms_array );
    }
}


if ( ! function_exists( 'houzez_add_term_children' ) ) :
    function houzez_add_term_children( $parent_id, $tax_terms, &$terms_array, $prefix = '' ) {
        if ( ! empty( $tax_terms ) && ! is_wp_error( $tax_terms ) ) {
            foreach ( $tax_terms as $term ) {
                if ( $term->parent == $parent_id ) {
                    $terms_array[ $term->slug ] = $prefix . $term->name;
                    houzez_add_term_children( $term->term_id, $tax_terms, $terms_array, $prefix . '- ' );
                }
            }
        }
    }
endif;

/* --------------------------------------------------------------------------
 * Houzez get term array by name, slug, id
 ---------------------------------------------------------------------------*/
if( !function_exists('houzez_get_term_by') ) {
    function houzez_get_term_by( $field, $value, $taxonomy ) {
        $term = get_term_by( $field, $value, $taxonomy );
        if( $term ) {
            return $term;
        }
        return false;
    }
}

if ( !function_exists( 'houzez_get_property_status_meta' ) ):
    function houzez_get_property_status_meta( $term_id = false, $field = false ) {
        $defaults = array(
            'color_type' => 'inherit',
            'color' => '#000000',
            'ppp' => ''
        );

        if ( $term_id ) {
            $meta = get_option( '_houzez_property_status_'.$term_id );
            $meta = wp_parse_args( (array) $meta, $defaults );
        } else {
            $meta = $defaults;
        }

        if ( $field ) {
            if ( isset( $meta[$field] ) ) {
                return $meta[$field];
            } else {
                return false;
            }
        }
        return $meta;
    }
endif;

if ( !function_exists( 'houzez_get_property_type_meta' ) ):
    function houzez_get_property_type_meta( $term_id = false, $field = false ) {
        $defaults = array(
            'color_type' => 'inherit',
            'color' => '#ffffff',
            'ppp' => ''
        );

        if ( $term_id ) {
            $meta = get_option( '_houzez_property_type_'.$term_id );
            $meta = wp_parse_args( (array) $meta, $defaults );
        } else {
            $meta = $defaults;
        }

        if ( $field ) {
            if ( isset( $meta[$field] ) ) {
                return $meta[$field];
            } else {
                return false;
            }
        }
        return $meta;
    }
endif;

if ( !function_exists( 'houzez_get_property_label_meta' ) ):
    function houzez_get_property_label_meta( $term_id = false, $field = false ) {
        $defaults = array(
            'color_type' => 'inherit',
            'color' => '#bcbcbc',
            'ppp' => ''
        );

        if ( $term_id ) {
            $meta = get_option( '_houzez_property_label_'.$term_id );
            $meta = wp_parse_args( (array) $meta, $defaults );
        } else {
            $meta = $defaults;
        }

        if ( $field ) {
            if ( isset( $meta[$field] ) ) {
                return $meta[$field];
            } else {
                return false;
            }
        }
        return $meta;
    }
endif;

if ( !function_exists( 'houzez_get_property_area_meta' ) ):
    function houzez_get_property_area_meta( $term_id = false, $field = false ) {
        $defaults = array(
            'parent_city' => ''
        );

        if ( $term_id ) {
            $meta = get_option( '_houzez_property_area_'.$term_id );
            $meta = wp_parse_args( (array) $meta, $defaults );
        } else {
            $meta = $defaults;
        }

        if ( $field ) {
            if ( isset( $meta[$field] ) ) {
                return $meta[$field];
            } else {
                return false;
            }
        }
        return $meta;
    }
endif;

if( !function_exists('houzez_get_all_cities') ):
    function houzez_get_all_cities( $selected = '' ) {
        $taxonomy       =   'property_city';
        $args = array(
            'hide_empty'    => false
        );
        $tax_terms      =   get_terms($taxonomy,$args);
        $select_city    =   '';

        foreach ($tax_terms as $tax_term) {
            $select_city.= '<option value="' . $tax_term->slug.'" ';
            if($tax_term->slug == $selected){
                $select_city.= ' selected="selected" ';
            }
            $select_city.= ' >' . $tax_term->name . '</option>';
        }
        return $select_city;
    }
endif;

if ( !function_exists( 'houzez_get_property_city_meta' ) ):
    function houzez_get_property_city_meta( $term_id = false, $field = false ) {
        $defaults = array(
            'parent_state' => ''
        );

        if ( $term_id ) {
            $meta = get_option( '_houzez_property_city_'.$term_id );
            $meta = wp_parse_args( (array) $meta, $defaults );
        } else {
            $meta = $defaults;
        }

        if ( $field ) {
            if ( isset( $meta[$field] ) ) {
                return $meta[$field];
            } else {
                return false;
            }
        }
        return $meta;
    }
endif;

if ( !function_exists( 'houzez_get_property_state_meta' ) ):
    function houzez_get_property_state_meta( $term_id = false, $field = false ) {
        $defaults = array(
            'parent_country' => ''
        );

        if ( $term_id ) {
            $meta = get_option( '_houzez_property_state_'.$term_id );
            $meta = wp_parse_args( (array) $meta, $defaults );
        } else {
            $meta = $defaults;
        }

        if ( $field ) {
            if ( isset( $meta[$field] ) ) {
                return $meta[$field];
            } else {
                return false;
            }
        }
        return $meta;
    }
endif;

if( !function_exists('houzez_get_all_states') ):
    function houzez_get_all_states( $selected = '' ) {
        $taxonomy       =   'property_state';
        $args = array(
            'hide_empty'    => false
        );
        $tax_terms      =   get_terms($taxonomy,$args);
        $select_state    =   '';

        foreach ($tax_terms as $tax_term) {
            $select_state.= '<option value="' . $tax_term->slug.'" ';
            if($tax_term->slug == $selected){
                $select_state.= ' selected="selected" ';
            }
            $select_state.= ' >' . $tax_term->name . '</option>';
        }
        return $select_state;
    }
endif;

if ( !function_exists( 'houzez_update_recent_colors' ) ):
    function houzez_update_recent_colors( $color, $num_col = 10 ) {
        if ( empty( $color ) )
            return false;

        $current = get_option( 'houzez_recent_colors' );
        if ( empty( $current ) ) {
            $current = array();
        }

        $update = false;

        if ( !in_array( $color, $current ) ) {
            $current[] = $color;
            if ( count( $current ) > $num_col ) {
                $current = array_slice( $current, ( count( $current ) - $num_col ), ( count( $current ) - 1 ) );
            }
            $update = true;
        }

        if ( $update ) {
            update_option( 'houzez_recent_colors', $current );
        }

    }
endif;

if ( !function_exists( 'houzez_update_property_status_colors' ) ):
    function houzez_update_property_status_colors( $cat_id, $color, $type ) {

        $colors = (array)get_option( 'fave_cat_colors' );

        if ( array_key_exists( $cat_id, $colors ) ) {

            if ( $type == 'inherit' ) {
                unset( $colors[$cat_id] );
            } elseif ( $colors[$cat_id] != $color ) {
                $colors[$cat_id] = $color;
            }

        } else {

            if ( $type != 'inherit' ) {
                $colors[$cat_id] = $color;
            }
        }

        update_option( 'houzez_property_status_colors', $colors );

    }
endif;

if ( !function_exists( 'houzez_update_property_type_colors' ) ):
    function houzez_update_property_type_colors( $cat_id, $color, $type ) {

        $colors = (array)get_option( 'fave_cat_colors' );

        if ( array_key_exists( $cat_id, $colors ) ) {

            if ( $type == 'inherit' ) {
                unset( $colors[$cat_id] );
            } elseif ( $colors[$cat_id] != $color ) {
                $colors[$cat_id] = $color;
            }

        } else {

            if ( $type != 'inherit' ) {
                $colors[$cat_id] = $color;
            }
        }

        update_option( 'houzez_property_type_colors', $colors );

    }
endif;


if ( !function_exists( 'houzez_update_property_label_colors' ) ):
    function houzez_update_property_label_colors( $cat_id, $color, $type ) {

        $colors = (array)get_option( 'fave_label_colors' );

        if ( array_key_exists( $cat_id, $colors ) ) {

            if ( $type == 'inherit' ) {
                unset( $colors[$cat_id] );
            } elseif ( $colors[$cat_id] != $color ) {
                $colors[$cat_id] = $color;
            }

        } else {

            if ( $type != 'inherit' ) {
                $colors[$cat_id] = $color;
            }
        }

        update_option( 'houzez_property_label_colors', $colors );

    }
endif;


/* --------------------------------------------------------------------------
 * Remove Recent Comment Style
 ---------------------------------------------------------------------------*/
if( !function_exists('houzez_remove_recent_comments_style') ) {
    function houzez_remove_recent_comments_style()
    {
        global $wp_widget_factory;
        remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
    }

    add_action('widgets_init', 'houzez_remove_recent_comments_style');
}

/* --------------------------------------------------------------------------
 * Get time and date 
 ---------------------------------------------------------------------------*/
 if( !function_exists('houzez_get_date') ) {
    function houzez_get_date() {
        return date_i18n( get_option('date_format') );
    }
 }

 if( !function_exists('houzez_get_time') ) {
    function houzez_get_time() {
        return date_i18n( get_option('time_format') );
    }
 }

 /* --------------------------------------------------------------------------
 * Get excerpt limit 
 ---------------------------------------------------------------------------*/
if( !function_exists('houzez_get_excerpt') ) {
    function houzez_get_excerpt($limit, $id = '')
    {
        $excerpt = explode(' ', get_the_excerpt($id), $limit);
        if (count($excerpt) >= $limit) {
            array_pop($excerpt);
            $excerpt = implode(" ", $excerpt) . '...';
        } else {
            $excerpt = implode(" ", $excerpt);
        }
        $excerpt = preg_replace('`\[[^\]]*\]`', '', $excerpt);
        return $excerpt;
    }
}

/* --------------------------------------------------------------------------
 * Get content limit 
 ---------------------------------------------------------------------------*/
if( !function_exists('houzez_get_content') ) {
    function houzez_get_content($limit)
    {
        $content = explode(' ', get_the_content(), $limit);
        if (count($content) >= $limit) {
            array_pop($content);
            $content = implode(" ", $content) . '...';
        } else {
            $content = implode(" ", $content);
        }
        $content = preg_replace('/\[.+\]/', '', $content);
        $content = apply_filters('the_content', $content);
        $content = str_replace(']]>', ']]&gt;', $content);
        return $content;
    }
}


/* --------------------------------------------------------------------------
 * Open Graph
 ---------------------------------------------------------------------------*/
if ( !function_exists( 'houzez_add_opengraph' ) ) {
    function houzez_add_opengraph() {
        if ( is_singular( 'property' ) ) {

            global $post;
            if ( has_excerpt( $post->ID ) ) {
                $description = strip_tags( get_the_excerpt() );
            } else {
                $description = str_replace( "\r\n", ' ', substr( strip_tags( strip_shortcodes( $post->post_content ) ), 0, 160 ) );
            }
            if ( empty( $description ) ) {
                $description = get_bloginfo( 'description' );
            }

            echo '<meta property="og:title" content="' . get_the_title() . '"/>';
            echo '<meta property="og:description" content="' . $description . '" />';
            echo '<meta property="og:type" content="article"/>';
            echo '<meta property="og:url" content="' . get_permalink() . '"/>';
            echo '<meta property="og:site_name" content="' . get_bloginfo( 'name' ) . '"/>';
            if ( has_post_thumbnail( $post->ID ) ) {
                $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
                echo '<meta property="og:image" content="' . esc_attr( $thumbnail_src[ 0 ] ) . '"/>';
            }

        }
    }

    if ( !defined('WPSEO_VERSION') && !class_exists('NY_OG_Admin')) {
        add_action( 'wp_head', 'houzez_add_opengraph', 5 );
    }
}

/*-----------------------------------------------------------------------------------*/
// Number List
/*-----------------------------------------------------------------------------------*/
if( !function_exists('houzez_number_list') ) {
    function houzez_number_list($list_for) {
        $num_array = array(1,2,3,4,5,6,7,8,9,10);
        $searched_num = '';

        if( $list_for == 'bedrooms' ) {
            if( isset( $_GET['bedrooms'] ) ) {
                $searched_num = $_GET['bedrooms'];
            }

            $adv_beds_list = houzez_option('adv_beds_list');
            if( !empty($adv_beds_list) ) {
                $adv_beds_list_array = explode( ',', $adv_beds_list );

                if( is_array( $adv_beds_list_array ) && !empty( $adv_beds_list_array ) ) { 
                    $temp_adv_beds_list_array = array();
                    foreach( $adv_beds_list_array as $beds ) {
                        $temp_adv_beds_list_array[] = $beds;
                    }

                    if( !empty( $temp_adv_beds_list_array ) ) {
                        $num_array = $temp_adv_beds_list_array;
                    }
                }
            }
        }

        if( $list_for == 'bathrooms' ) {
            if( isset( $_GET['bathrooms'] ) ) {
                $searched_num = $_GET['bathrooms'];
            }

            $adv_baths_list = houzez_option('adv_baths_list');
            if( !empty($adv_baths_list) ) {
                $adv_baths_list_array = explode( ',', $adv_baths_list );

                if( is_array( $adv_baths_list_array ) && !empty( $adv_baths_list_array ) ) {
                    $temp_adv_baths_list_array = array();
                    foreach( $adv_baths_list_array as $baths ) {
                        $temp_adv_baths_list_array[] = $baths;
                    }

                    if( !empty( $temp_adv_baths_list_array ) ) {
                        $num_array = $temp_adv_baths_list_array;
                    }
                }
            }
        }

        if( $list_for == 'rooms' ) {
            if( isset( $_GET['rooms'] ) ) {
                $searched_num = $_GET['rooms'];
            }

            $adv_rooms_list = houzez_option('adv_rooms_list');
            if( !empty($adv_rooms_list) ) {
                $adv_rooms_list_array = explode( ',', $adv_rooms_list );

                if( is_array( $adv_rooms_list_array ) && !empty( $adv_rooms_list_array ) ) {
                    $temp_adv_rooms_list_array = array();
                    foreach( $adv_rooms_list_array as $rooms ) {
                        $temp_adv_rooms_list_array[] = $rooms;
                    }

                    if( !empty( $temp_adv_rooms_list_array ) ) {
                        $num_array = $temp_adv_rooms_list_array;
                    }
                }
            }
        }

        if( !empty( $num_array ) ) {
            $num_array = array_filter($num_array, 'strlen');

            foreach( $num_array as $num ){
                $option_label = '';
                
                $option_label = $num;

                if( $num == '0' ) {
                    $option_label = houzez_option('srh_studio', 'Studio');
                }

                if( $searched_num == $num ) {
                    echo '<option value="'.esc_attr( $num ).'" selected="selected">'.esc_attr( $option_label ).'</option>';
                } else {
                    echo '<option value="'.esc_attr( $num ).'">'.esc_attr( $option_label ).'</option>';
                }
            }
        }

        $any_text = houzez_option('srh_any', esc_html__( 'Any', 'houzez'));

        if( $searched_num == 'any' )  {
            echo '<option value="any" selected="selected">'.$any_text.'</option>';
        } else {
            echo '<option value="any">'.$any_text.'</option>';
        }

    }
}

/*-----------------------------------------------------------------------------------*/
// Get attachment meta by attachment ID
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'houzez_get_attachment_metadata' ) ) {
    function houzez_get_attachment_metadata($attachment_id)
    {
        $thumbnail_image = get_posts(array('p' => $attachment_id, 'post_type' => 'attachment'));

        if ($thumbnail_image && isset($thumbnail_image[0])) {
            return $thumbnail_image[0];
        }
    }
}

/*-----------------------------------------------------------------------------------*/
// Favethemes object to array
/*-----------------------------------------------------------------------------------*/
if( !function_exists('houzez_objectToArray') ):
    function houzez_objectToArray ($object) {

        if(!is_object($object) && !is_array($object))
            return $object;

        return array_map('houzez_objectToArray', (array) $object);
    }
endif;

/* --------------------------------------------------------------------------
 * Get author by post id
 ---------------------------------------------------------------------------*/
if( !function_exists('houzez_get_author_by_post_id') ):
    function houzez_get_author_by_post_id( $post_id = 0 ){
        $post = get_post( $post_id );
        return $post->post_author;
    }
endif;

/* --------------------------------------------------------------------------
 * Get get author avatar
 ---------------------------------------------------------------------------*/
if ( !function_exists('houzez_get_avatar_url') ) {
    function houzez_get_avatar_url($get_avatar){
        preg_match("/src='(.*?)'/i", $get_avatar, $matches);
        return $matches[1];
    }
}

/* --------------------------------------------------------------------------
 * Get fave get author
 ---------------------------------------------------------------------------*/
if( !function_exists('houzez_get_author') ):
    function houzez_get_author( $post_id = 0 ){
        $post = get_post( $post_id );
        return $post->post_author;
    }
endif;

/* --------------------------------------------------------------------------
 * Get image url
 ---------------------------------------------------------------------------*/
if ( !function_exists( 'houzez_get_image_url' ) ):
    function houzez_get_image_url( $image_size, $post_id = NULL ) {
        $thumb_id = get_post_thumbnail_id($post_id);
        $thumb_url_array = wp_get_attachment_image_src( $thumb_id, $image_size, true );

        return $thumb_url_array;
    }
endif;

/* --------------------------------------------------------------------------
 * Get image url by image ID
 ---------------------------------------------------------------------------*/
if ( !function_exists( 'houzez_get_image_by_id' ) ):
    function houzez_get_image_by_id( $thumb_id, $image_size ) {
        $thumb_url_array = wp_get_attachment_image_src( $thumb_id, $image_size, true );

        return $thumb_url_array;
    }
endif;

/* --------------------------------------------------------------------------
 * Get invoice post type meta with default values
 ---------------------------------------------------------------------------*/
if ( !function_exists( 'houzez_get_invoice_meta' ) ):
    function houzez_get_invoice_meta( $post_id, $field = false ) {

        $defaults = array(
            'invoice_billion_for' => '',
            'invoice_billing_type' => '',
            'invoice_item_id' => '',
            'invoice_item_price' => '',
            'invoice_tax' => '',
            'invoice_payment_method' => '',
            'invoice_purchase_date' => '',
            'invoice_buyer_id' => ''
        );

        $meta = get_post_meta( $post_id, '_houzez_invoice_meta', true );
        $meta = wp_parse_args( (array) $meta, $defaults );

        if ( $field ) {
            if ( isset( $meta[$field] ) ) {
                return $meta[$field];
            } else {
                return false;
            }
        }
        return $meta;
    }
endif;

/* --------------------------------------------------------------------------
 * Get sidebar meta with default values
 ---------------------------------------------------------------------------*/
if ( !function_exists( 'houzez_get_sidebar_meta' ) ):
    function houzez_get_sidebar_meta( $post_id, $field = false ) {

        $defaults = array(
            'specific_sidebar' => 'no',
            'selected_sidebar' => 'default-sidebar',
        );

        $meta = get_post_meta( $post_id, '_houzez_sidebar_meta', true );
        $meta = wp_parse_args( (array) $meta, $defaults );

        if ( $field ) {
            if ( isset( $meta[$field] ) ) {
                return $meta[$field];
            } else {
                return false;
            }
        }
        return $meta;
    }
endif;

/* --------------------------------------------------------------------------
 * Get user package post type meta with default values
 ---------------------------------------------------------------------------*/
if ( !function_exists( 'houzez_get_user_packages_meta' ) ):
    function houzez_get_user_packages_meta( $post_id, $field = false ) {

        $defaults = array(
            'package_name' => ''
        );

        $meta = get_post_meta( $post_id, '_houzez_user_package_meta', true );
        $meta = wp_parse_args( (array) $meta, $defaults );

        if ( $field ) {
            if ( isset( $meta[$field] ) ) {
                return $meta[$field];
            } else {
                return false;
            }
        }
        return $meta;
    }
endif;

/* --------------------------------------------------------------------------
 * Get property post type meta with default values
 ---------------------------------------------------------------------------*/
if ( !function_exists( 'houzez_get_property_meta' ) ):
    function houzez_get_property_meta( $post_id, $field = false ) {

        /*$defaults = array(
            'fave_payment_status' => ''
        );*/

        //$meta = get_post_meta( $post_id, 'fave_payment_status', true );
        //$meta = wp_parse_args( (array) $meta, $defaults );

        /*if ( $field ) {
            if ( isset( $meta[$field] ) ) {
                return $meta[$field];
            } else {
                return false;
            }
        }*/
        //return $meta;
    }
endif;

/* --------------------------------------------------------------------------
 * Remove spaces and chars from string
 ---------------------------------------------------------------------------*/
if ( ! function_exists( 'houzez_clean' ) ) {
    function houzez_clean($string)
    {
        $string = preg_replace('/&#36;/', '', $string);
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string);
        $string = preg_replace('/\D/', '', $string);
        return $string;
    }
}

if( !function_exists('houzez_clean_20')) {
    function houzez_clean_20($string) {
       $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

       return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }
}


/* --------------------------------------------------------------------------
 * Get term
 ---------------------------------------------------------------------------*/
if ( ! function_exists( 'houzez_taxonomy_simple' ) ) {
    function houzez_taxonomy_simple( $tax_name ) {
        
        $terms = wp_get_post_terms( get_the_ID(), $tax_name, array("fields" => "names"));
        if (!empty($terms) && ! is_wp_error( $terms ) ) {
            
            $temp_array = array();
 
            foreach ( $terms as $term ) {
                $temp_array[] = $term;
            }
                                 
            $result = join( ", ", $temp_array );
            return $result;
        }
        return '';
    }
}

if ( ! function_exists( 'houzez_array_to_comma' ) ) {
    function houzez_array_to_comma( $arr_array = array() ) {
        
       if ( !empty($arr_array) ) {
            
            $temp_array = array();
 
            foreach ( $arr_array as $item ) {

                $item = houzez_wpml_translate_single_string($item);
                $temp_array[] = $item;
            }
                                 
            $result = join( ", ", $temp_array );
            return $result;
        }
        return '';
    }
}


if ( ! function_exists( 'houzez_get_post_term_slug' ) ) {
    function houzez_get_post_term_slug( $post_id, $tax_name ) {
        $terms = get_the_terms( $post_id, $tax_name );
        if ( !empty( $terms ) ){
            // get the first term
            $term = array_shift( $terms );
            return $term->slug;
        }
    }
}

if ( ! function_exists( 'houzez_post_term_slug' ) ) {
    function houzez_post_term_slug( $post_id, $tax_name ) {
        echo houzez_get_post_term_slug( $post_id, $tax_name );
    }
}


if ( ! function_exists( 'houzez_taxonomy_simple_2' ) ) {
    function houzez_taxonomy_simple_2( $tax_name, $propID ) {

        $terms = wp_get_post_terms( $propID, $tax_name, array("fields" => "names"));
        if (!empty($terms) && ! is_wp_error( $terms )){
            $temp_array = array();
 
            foreach ( $terms as $term ) {
                $temp_array[] = $term;
            }
                                 
            $result = join( ", ", $temp_array );
            return $result;
        }
        return '';
    }
}

if ( ! function_exists( 'houzez_get_taxonomy_id' ) ) {
    function houzez_get_taxonomy_id( $tax_name )
    {
        $terms = wp_get_post_terms( get_the_ID(), $tax_name, array("fields" => "ids"));
        $term_id = '';
        if (!empty($terms) && ! is_wp_error( $terms )):
            foreach( $terms as $term ):
                $term_id = $term;
            endforeach;
            return $term_id;
        endif;
        return '';
    }
}

if ( ! function_exists( 'houzez_get_taxonomy' ) ) {
    function houzez_get_taxonomy($tax_name)
    {
        $terms = wp_get_post_terms( get_the_ID(), $tax_name, array("fields" => "all"));
        if (!empty($terms)):
            foreach ($terms as $term):
                $term_link = get_term_link($term, $tax_name);
                if (is_wp_error($term_link))
                    continue;
                $taxonomy = '<a href="' . esc_url( $term_link ) . '">' . esc_attr( $term->name ) . '</a>&nbsp';
                return $taxonomy;
            endforeach;
        endif;
        return '';
    }
}

/**
 *   ----------------------------------------------------------------------------------------------------------------------------------------------------
 *   46.0 - Add next and prev links to a numbered link list - pagination on single post.
 *   ----------------------------------------------------------------------------------------------------------------------------------------------------
 */
if( !function_exists('houzez_link_pages_args_prevnext_add') ) {
    function houzez_link_pages_args_prevnext_add($args)
    {
        global $page, $numpages, $more, $pagenow;

        if (!$args['next_or_number'] == 'next_and_number')
            return $args;

        $args['next_or_number'] = 'number';
        if (!$more)
            return $args;

        if ($page - 1)
            $args['before'] .= _wp_link_page($page - 1)
                . $args['link_before'] . $args['previouspagelink'] . $args['link_after'] . '</a>';

        if ($page < $numpages)
            $args['after'] = _wp_link_page($page + 1)
                . $args['link_before'] . $args['nextpagelink'] . $args['link_after'] . '</a>'
                . $args['after'];

        return $args;
    }

    add_filter('wp_link_pages_args', 'houzez_link_pages_args_prevnext_add');
}

/**
 *   -------------------------------------------------------------
 *   Houzez Pagination
 *   -------------------------------------------------------------
 */
if( !function_exists( 'houzez_pagination' ) ){
    function houzez_pagination($pages = '', $range = 2 ) {
        global $paged;

        if(empty($paged))$paged = 1;

        $prev = $paged - 1;
        $next = $paged + 1;
        $showitems = ( $range * 2 )+1;
        $range = 2; // change it to show more links

        if( $pages == '' ){
            global $wp_query;
            $pages = $wp_query->max_num_pages;
            if( !$pages ){
                $pages = 1;
            }
        }


        if( 1 != $pages ){

            $output = "";
            $inner = "";
            $output .= '<div class="pagination-wrap">';
                $output .= '<nav>';
                    $output .= '<ul class="pagination justify-content-center">';
                        
                        if( $paged > 2 && $paged > $range+1 && $showitems < $pages ) { 
                            $output .= '<li class="page-item">';
                                $output .= '<a class="page-link" href="'.get_pagenum_link(1).'" aria-label="Previous">';
                                    $output .= '<i class="houzez-icon arrow-button-left-1"></i>';
                                $output .= '</a>';
                            $output .= '</li>';
                        }

                        if( $paged > 1 ) { 
                            $output .= '<li class="page-item">';
                                $output .= '<a class="page-link" href="'.get_pagenum_link($prev).'" aria-label="Previous">';
                                    $output .= '<i class="houzez-icon icon-arrow-left-1"></i>';
                                $output .= '</a>';
                            $output .= '</li>';
                        } else {
                            $output .= '<li class="page-item disabled">';
                                $output .= '<a class="page-link" aria-label="Previous">';
                                    $output .= '<i class="houzez-icon icon-arrow-left-1"></i>';
                                $output .= '</a>';
                            $output .= '</li>';
                        }

                        for ( $i = 1; $i <= $pages; $i++ ) {
                            if ( 1 != $pages &&( !( $i >= $paged+$range+1 || $i <= $paged-$range-1 ) || $pages <= $showitems ) )
                            {
                                if ( $paged == $i ){
                                    $inner .= '<li class="page-item active"><a class="page-link" href="'.get_pagenum_link($i).'">'.$i.' <span class="sr-only"></span></a></li>';
                                } else {
                                    $inner .= '<li class="page-item"><a class="page-link" href="'.get_pagenum_link($i).'">'.$i.'</a></li>';
                                }
                            }
                        }
                        $output .= $inner;
                        

                        if($paged < $pages) {
                            $output .= '<li class="page-item">';
                                $output .= '<a class="page-link" href="'.get_pagenum_link($next).'" aria-label="Next">';
                                    $output .= '<i class="houzez-icon icon-arrow-right-1"></i>';
                                $output .= '</a>';
                            $output .= '</li>';
                        }

                        if( $paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages ) {
                            $output .= '<li class="page-item">';
                                $output .= '<a class="page-link" href="'.get_pagenum_link( $pages ).'" aria-label="Next">';
                                    $output .= '<i class="houzez-icon arrow-button-right-1"></i>';
                                $output .= '</a>';
                            $output .= '</li>';
                        }


                    $output .= '</ul>';
                $output .= '</nav>';
            $output .= '</div>';

            echo $output;

        }
    }
}

if( !function_exists( 'houzez_ajax_pagination' ) ){
    function houzez_ajax_pagination($pages = '', $paged, $range = 2 ) {

        if(empty($paged))$paged = 1;

        $prev = $paged - 1;
        $next = $paged + 1;
        $showitems = ( $range * 2 )+1;
        $range = 2; // change it to show more links

        if( $pages == '' ){
            global $wp_query;
            $pages = $wp_query->max_num_pages;
            if( !$pages ){
                $pages = 1;
            }
        }

        if( 1 != $pages ){

            echo '<div class="pagination-wrap houzez_ajax_pagination">';
            echo '<nav>';
            echo '<ul class="pagination justify-content-center">';
            echo ( $paged > 2 && $paged > $range+1 && $showitems < $pages ) ? '<li class="page-item"><a class="page-link" data-houzepagi="1" rel="First" href="'.get_pagenum_link(1).'"><span aria-hidden="true"><i class="fa fa-angle-double-left"></i></span></a></li>' : '';
            echo ( $paged > 1 ) ? '<li class="page-item"><a class="page-link" data-houzepagi="'.$prev.'" rel="Prev" href="'.get_pagenum_link($prev).'"><i class="houzez-icon icon-arrow-left-1"></i></a></li>' : '<li class="page-item disabled"><a class="page-link" aria-label="Previous"><i class="houzez-icon icon-arrow-left-1"></i></a></li>';
            for ( $i = 1; $i <= $pages; $i++ ) {
                if ( 1 != $pages &&( !( $i >= $paged+$range+1 || $i <= $paged-$range-1 ) || $pages <= $showitems ) )
                {
                    if ( $paged == $i ){
                        echo '<li class="page-item active"><a class="page-link" data-houzepagi="'.$i.'" href="'.get_pagenum_link($i).'">'.$i.' <span class="sr-only"></span></a></li>';
                    } else {
                        echo '<li class="page-item"><a class="page-link" data-houzepagi="'.$i.'" href="'.get_pagenum_link($i).'">'.$i.'</a></li>';
                    }
                }
            }
            echo ( $paged < $pages ) ? '<li class="page-item"><a class="page-link" data-houzepagi="'.$next.'" rel="Next" href="'.get_pagenum_link($next).'"><i class="houzez-icon icon-arrow-right-1"></i></a></li>' : '';
            echo ( $paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages ) ? '<li class="page-item"><a class="page-link" data-houzepagi="'.$pages.'" rel="Last" href="'.get_pagenum_link( $pages ).'"><span aria-hidden="true"><i class="fa fa-angle-double-right"></i></span></a></li>' : '';
            echo '</ul>';
            echo '</nav>';
            echo '</div>';

        }
    }
}


if( !function_exists( 'houzez_loadmore' ) ) {
    function houzez_loadmore($max_num_pages) {
        $more_link = get_next_posts_link( __('Load More', 'houzez'), $max_num_pages );
        $allowed_html_array = array(
            'a' => array(
                'href' => array(),
                'title' => array()
            )
        );

        if(!empty($more_link)) : ?>
            <div id="fave-pagination-loadmore" class="pagination-wrap fave-load-more">
                <div class="pagination">
                    <?php echo wp_kses( $more_link, $allowed_html_array); ?>
                </div>
            </div>
        <?php endif;
    }
}

/**
 *   ---------------------------------------------------------
 *   Include simple pagination - deprecated
 *   ---------------------------------------------------------
 */
if ( !function_exists( 'houzez_pagination_deprecated' ) ):
    function houzez_pagination_deprecated() {
        global $wp_query, $wp_rewrite;
        $allowed_html_array = array(
            'i' => array(
                'class' => array()
            ),
            'span' => array(
                'aria-hidden' => array()
            )
        );

        $wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;
        $pagination = array(
            'base' => @add_query_arg( 'paged', '%#%' ),
            'format' => '',
            'total' => $wp_query->max_num_pages,
            'current' => $current,
            'prev_text' => wp_kses(__( '<span aria-hidden="true"><i class="fa fa-angle-left"></i></span>', 'houzez' ), $allowed_html_array),
            'next_text' => wp_kses(__( '<span aria-hidden="true"><i class="fa fa-angle-right"></i></span>', 'houzez' ), $allowed_html_array),
            'type' => 'array'
        );
        if ( $wp_rewrite->using_permalinks() )
            $pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg( 's', get_pagenum_link( 1 ) ) ) . 'page/%#%/', 'paged' );

        if ( !empty( $wp_query->query_vars['s'] ) )
            $pagination['add_args'] = array( 's' => str_replace( ' ', '+', get_query_var( 's' ) ) );

        $links = paginate_links( $pagination );

        if( is_array( $links ) ) {
            $paged = ( get_query_var('paged') == 0 ) ? 1 : get_query_var('paged');
            echo '<div class="pagination-main"><ul class="pagination">';

            foreach ( $links as $link ) {
                echo "<li>$link</li>";
            }
            echo '</ul></div>';
        }
    }
endif;


if( !function_exists('houzez_listing_meta_v1') ) {
    function houzez_listing_meta_v1()
    {
        $propID = get_the_ID();
        $prop_bed     = get_post_meta( get_the_ID(), 'fave_property_bedrooms', true );
        $prop_bath     = get_post_meta( get_the_ID(), 'fave_property_bathrooms', true );
        $prop_size     = get_post_meta( $propID, 'fave_property_size', true );

        if( empty($prop_bed) && empty($prop_bath) && empty($prop_size) ) { return; }

        $output = '';
        $output .= '<p>';
        if( !empty( $prop_bed ) ) {
            $prop_bed = esc_attr( $prop_bed );
            $prop_bed_lebel = ($prop_bed > 1 ) ? esc_html__( 'Beds', 'houzez' ) : esc_html__( 'Bed', 'houzez' );

            $output .= '<span class="h-beds">';
            $output .= $prop_bed_lebel .': '. $prop_bed;
            $output .= '</span>';
        }
        if( !empty( $prop_bath ) ) {
            $prop_bath = esc_attr( $prop_bath );
            $prop_bath_lebel = ($prop_bath > 1 ) ? esc_html__( 'Baths', 'houzez' ) : esc_html__( 'Bath', 'houzez' );

            $output .= '<span class="h-baths">';
            $output .= $prop_bath_lebel .': '. $prop_bath;
            $output .= '</span>';
        }

        $listing_area_size = houzez_get_listing_area_size( $propID );

        if( !empty( $listing_area_size ) ) {
            $output .= '<span class="h-area">';
            $output .= houzez_get_listing_size_unit($propID) . ': ' . houzez_get_listing_area_size($propID);
            $output .= '</span>';
        }

        $output .= '</p>';

        return $output;

    }
}

if( !function_exists('houzez_listing_meta_v1_without_p') ) {
    function houzez_listing_meta_v1_without_p()
    {
        $propID = get_the_ID();
        $prop_bed     = get_post_meta( get_the_ID(), 'fave_property_bedrooms', true );
        $prop_bath     = get_post_meta( get_the_ID(), 'fave_property_bathrooms', true );
        $prop_size     = get_post_meta( $propID, 'fave_property_size', true );

        if( empty($prop_bed) && empty($prop_bath) && empty($prop_size) ) { return; }

        $output = '';
        if( !empty( $prop_bed ) ) {
            $prop_bed = esc_attr( $prop_bed );
            $prop_bed_lebel = ($prop_bed > 1 ) ? esc_html__( 'Beds', 'houzez' ) : esc_html__( 'Bed', 'houzez' );

            $output .= '<span class="h-beds">';
            $output .= $prop_bed_lebel .': '. $prop_bed;
            $output .= '</span>';
        }
        if( !empty( $prop_bath ) ) {
            $prop_bath = esc_attr( $prop_bath );
            $prop_bath_lebel = ($prop_bath > 1 ) ? esc_html__( 'Baths', 'houzez' ) : esc_html__( 'Bath', 'houzez' );

            $output .= '<span class="h-baths">';
            $output .= $prop_bath_lebel .': '. $prop_bath;
            $output .= '</span>';
        }

        $listing_area_size = houzez_get_listing_area_size( $propID );

        if( !empty( $listing_area_size ) ) {
            $output .= '<span class="h-area">';
            $output .= houzez_get_listing_size_unit($propID) . ': ' . houzez_get_listing_area_size($propID);
            $output .= '</span>';
        }

        return $output;

    }
}

if( !function_exists('houzez_listing_meta_v3') ) {
    function houzez_listing_meta_v3()
    {
        $propID = get_the_ID();
        $prop_bed     = get_post_meta( get_the_ID(), 'fave_property_bedrooms', true );
        $prop_bath     = get_post_meta( get_the_ID(), 'fave_property_bathrooms', true );
        $prop_size     = get_post_meta( $propID, 'fave_property_size', true );

        if( empty($prop_bed) && empty($prop_bath) && empty($prop_size) ) { return; }

        $output = '';
        $output .= '<ul class="item-amenities">';
        if( !empty( $prop_bed ) ) {
            $prop_bed = esc_attr( $prop_bed );
            $prop_bed_lebel = ($prop_bed > 1 ) ? esc_html__( 'Bedrooms', 'houzez' ) : esc_html__( 'Bedroom', 'houzez' );

            $output .= '<li class="h-beds">';
            $output .= '<span>'.$prop_bed.'</span>';
            $output .= $prop_bed_lebel;
            $output .= '</li>';
        }
        if( !empty( $prop_bath ) ) {
            $prop_bath = esc_attr( $prop_bath );
            $prop_bath_lebel = ($prop_bath > 1 ) ? esc_html__( 'Bathrooms', 'houzez' ) : esc_html__( 'Bathroom', 'houzez' );

            $output .= '<li class="h-baths">';
            $output .= '<span>'.$prop_bath.'</span>';
            $output .= $prop_bath_lebel;
            $output .= '</li>';
        }

        $listing_area_size = houzez_get_listing_area_size( $propID );

        if( !empty( $listing_area_size ) ) {
            $output .= '<li class="h-area">';
            $output .= '<span>'.houzez_get_listing_area_size($propID).'</span>';
            $output .= houzez_get_listing_size_unit($propID);
            $output .= '</li>';

        }

        $output .= '</ul>';

        return $output;

    }
}

if( !function_exists('houzez_get_land_area_size') ) {
    function houzez_get_land_area_size( $propID ) {
        $prop_area_size = '';
        $prop_size     = get_post_meta( $propID, 'fave_property_land', true );
        $houzez_base_area = houzez_option('houzez_base_area');

        if( !empty( $prop_size ) ) {

            if( isset( $_COOKIE[ "houzez_current_area" ] ) ) {
                if( $_COOKIE[ "houzez_current_area" ] == 'sq_meter' && $houzez_base_area != 'sq_meter'  ) {
                    $prop_size = $prop_size * 0.09290304; //m2 = ft2 x 0.09290304

                } elseif( $_COOKIE[ "houzez_current_area" ] == 'sqft' && $houzez_base_area != 'sqft' ) {
                    $prop_size = $prop_size / 0.09290304; //ft2 = m2 ÷ 0.09290304
                }
            }

            $prop_area_size = esc_attr( round($prop_size, 3) );

        }
        return $prop_area_size;

    }
}

if( !function_exists('houzez_get_listing_area_size') ) {
    function houzez_get_listing_area_size( $propID ) {
        $prop_area_size = '';
        $prop_size     = get_post_meta( $propID, 'fave_property_size', true );
        $houzez_base_area = houzez_option('houzez_base_area');

        if( !empty( $prop_size ) ) {

            if( isset( $_COOKIE[ "houzez_current_area" ] ) ) {
                if( $_COOKIE[ "houzez_current_area" ] == 'sq_meter' && $houzez_base_area != 'sq_meter'  ) {
                    $prop_size = $prop_size * 0.09290304; //m2 = ft2 x 0.09290304

                } elseif( $_COOKIE[ "houzez_current_area" ] == 'sqft' && $houzez_base_area != 'sqft' ) {
                    $prop_size = $prop_size / 0.09290304; //ft2 = m2 ÷ 0.09290304
                }
            }

            $prop_area_size = esc_attr( round($prop_size, 2) );

        }
        return $prop_area_size;

    }
}

if( !function_exists('houzez_get_listing_size_unit') ) {
    function houzez_get_listing_size_unit( $propID ) {
        $measurement_unit_global = houzez_option('measurement_unit_global');
        $area_switcher_enable = houzez_option('area_switcher_enable');

        if( $area_switcher_enable != 0 ) {
            $prop_size_prefix = houzez_option('houzez_base_area');

            if( isset( $_COOKIE[ "houzez_current_area" ] ) ) {
                $prop_size_prefix =$_COOKIE[ "houzez_current_area" ];
            }

            if( $prop_size_prefix == 'sqft' ) {
                $prop_size_prefix = houzez_option('measurement_unit_sqft_text');
            } elseif( $prop_size_prefix == 'sq_meter' ) {
                $prop_size_prefix = houzez_option('measurement_unit_square_meter_text');
            }

        } else {
            if ($measurement_unit_global == 1) {
                $prop_size_prefix = houzez_option('measurement_unit');

                if( $prop_size_prefix == 'sqft' ) {
                    $prop_size_prefix = houzez_option('measurement_unit_sqft_text');
                } elseif( $prop_size_prefix == 'sq_meter' ) {
                    $prop_size_prefix = houzez_option('measurement_unit_square_meter_text');
                }

            } else {
                $prop_size_prefix = get_post_meta( $propID, 'fave_property_size_prefix', true);
            }
        }
        return $prop_size_prefix;
    }
}

if( !function_exists('houzez_get_land_size_unit') ) {
    function houzez_get_land_size_unit( $propID ) {
        $measurement_unit_global = houzez_option('measurement_unit_global');
        $area_switcher_enable = houzez_option('area_switcher_enable');

        if( $area_switcher_enable != 0 ) {
            $prop_size_prefix = houzez_option('houzez_base_area');

            if( isset( $_COOKIE[ "houzez_current_area" ] ) ) {
                $prop_size_prefix =$_COOKIE[ "houzez_current_area" ];
            }

            if( $prop_size_prefix == 'sqft' ) {
                $prop_size_prefix = houzez_option('measurement_unit_sqft_text');
            } elseif( $prop_size_prefix == 'sq_meter' ) {
                $prop_size_prefix = houzez_option('measurement_unit_square_meter_text');
            }

        } else {
            if ($measurement_unit_global == 1) {
                $prop_size_prefix = houzez_option('measurement_unit');

                if( $prop_size_prefix == 'sqft' ) {
                    $prop_size_prefix = houzez_option('measurement_unit_sqft_text');
                } elseif( $prop_size_prefix == 'sq_meter' ) {
                    $prop_size_prefix = houzez_option('measurement_unit_square_meter_text');
                }

            } else {
                $prop_size_prefix = get_post_meta( $propID, 'fave_property_land_postfix', true);
            }
        }
        return $prop_size_prefix;
    }
}


if( !function_exists('houzez_listing_meta_widget') ) {
    function houzez_listing_meta_widget()
    {
        $prop_bed     = get_post_meta( get_the_ID(), 'fave_property_bedrooms', true );
        $prop_bath     = get_post_meta( get_the_ID(), 'fave_property_bathrooms', true );
        $prop_size     = get_post_meta( get_the_ID(), 'fave_property_size', true );
        //$prop_size_prefix     = get_post_meta( get_the_ID(), 'fave_property_size_prefix', true );

        if( !empty( $prop_bed ) ) {
            $prop_bed = esc_attr( $prop_bed );
            $prop_bed_lebel = ($prop_bed > 1 ) ? esc_html__( 'beds', 'houzez' ) : esc_html__( 'bed', 'houzez' );

            echo esc_attr( $prop_bed ).' '.esc_attr( $prop_bed_lebel ).' • ';
        }
        if( !empty( $prop_bath ) ) {
            $prop_bath = esc_attr( $prop_bath );
            $prop_bath_lebel = ($prop_bath > 1 ) ? esc_html__( 'baths', 'houzez' ) : esc_html__( 'bath', 'houzez' );

            echo esc_attr( $prop_bath ).' '. esc_attr( $prop_bath_lebel ).' • ';
        }
        if( !empty( $prop_size ) ) {
            echo houzez_property_size( 'after' );
        }

    }
}

if( !function_exists('houzez_listing_meta_v2') ) {
    function houzez_listing_meta_v2()
    {
        $prop_bed     = get_post_meta( get_the_ID(), 'fave_property_bedrooms', true );
        $prop_bath     = get_post_meta( get_the_ID(), 'fave_property_bathrooms', true );
        $prop_size     = get_post_meta( get_the_ID(), 'fave_property_size', true );
        //$prop_size_prefix     = get_post_meta( get_the_ID(), 'fave_property_size_prefix', true );

        if( !empty( $prop_bed ) ) {
            $prop_bed = esc_attr( $prop_bed );
            $prop_bed_lebel = ($prop_bed > 1 ) ? esc_html__( 'bd', 'houzez' ) : esc_html__( 'bd', 'houzez' );

            echo '<li>';
            echo esc_attr( $prop_bed ).' '. esc_attr( $prop_bed_lebel );
            echo '</li>';
        }
        if( !empty( $prop_bath ) ) {
            $prop_bath = esc_attr( $prop_bath );
            $prop_bath_lebel = ($prop_bath > 1 ) ? esc_html__( 'ba', 'houzez' ) : esc_html__( 'ba', 'houzez' );

            echo '<li>';
            echo esc_attr( $prop_bath ).' '. esc_attr( $prop_bath_lebel );
            echo '</li>';
        }
        if( !empty( $prop_size ) ) {

            echo '<li>';
            echo houzez_property_size( 'after' );
            echo '</li>';
        }

    }
}

if( !function_exists('houzez_property_size') ) {
    function houzez_property_size( $position ) {

        $propID = get_the_ID();
        if( $position == 'before' ) {
            $prop_size = houzez_get_listing_size_unit( $propID ).' '.houzez_get_listing_area_size( $propID );
        } else {
            $prop_size = houzez_get_listing_area_size( $propID ).' '.houzez_get_listing_size_unit( $propID );
        }
        return  $prop_size;
    }
}

if( !function_exists('houzez_property_land_area') ) {
    function houzez_property_land_area( $position ) {

        $propID = get_the_ID();
        $land_area_unit = get_post_meta( $propID, 'fave_property_land_postfix', true);
        $land_area = get_post_meta( $propID, 'fave_property_land', true);

        if( $position == 'before' ) {
            $prop_size = houzez_get_land_size_unit( $propID ).' '.houzez_get_land_area_size( $propID );
        } else {
            $prop_size = houzez_get_land_area_size( $propID ).' '.houzez_get_land_size_unit( $propID );
        }
        return  $prop_size;
    }
}

if( !function_exists('houzez_property_size_by_id') ) {
    function houzez_property_size_by_id( $propID, $position ) {

        // Since v1.3.0
        if( $position == 'before' ) {
            $prop_size = houzez_get_listing_size_unit( $propID ).' '.houzez_get_listing_area_size( $propID );
        } else {
            $prop_size = houzez_get_listing_area_size( $propID ).' '.houzez_get_listing_size_unit( $propID );
        }
        return  $prop_size;
    }
}

if( !function_exists('houzez_property_land_area_by_id') ) {
    function houzez_property_land_area_by_id( $propID, $position ) {

        // Since v1.3.0
        if( $position == 'before' ) {
            $prop_size = houzez_get_land_size_unit( $propID ).' '.houzez_get_land_area_size( $propID );
        } else {
            $prop_size = houzez_get_land_area_size( $propID ).' '.houzez_get_land_size_unit( $propID );
        }
        return  $prop_size;
    }
}

if( !function_exists('houzez_property_slider_meta') ) {
    function houzez_property_slider_meta()
    {
        $propID = get_the_ID();
        $prop_bed     = get_post_meta( get_the_ID(), 'fave_property_bedrooms', true );
        $prop_bath     = get_post_meta( get_the_ID(), 'fave_property_bathrooms', true );
        $prop_size     = get_post_meta( get_the_ID(), 'fave_property_size', true );

        $measurement_unit_global = houzez_option('measurement_unit_global');
        if( $measurement_unit_global == 1 ) {
            $prop_size_prefix = houzez_option('measurement_unit');
        } else {
            $prop_size_prefix = get_post_meta(get_the_ID(), 'fave_property_size_prefix', true);
        }

        echo '<ul class="list-inline">';
        if( !empty( $prop_bed ) ) {
            $prop_bed = esc_attr( $prop_bed );
            $prop_bed_lebel = ($prop_bed > 1 ) ? esc_html__( 'Beds', 'houzez' ) : esc_html__( 'Bed', 'houzez' );

            echo '<li>';
            echo '<strong>'.$prop_bed_lebel .':</strong> '. $prop_bed;
            echo '</li>';
        }
        if( !empty( $prop_bath ) ) {
            $prop_bath = esc_attr( $prop_bath );
            $prop_bath_lebel = ($prop_bath > 1 ) ? esc_html__( 'Baths', 'houzez' ) : esc_html__( 'Bath', 'houzez' );

            echo '<li>';
            echo '<strong>'.$prop_bath_lebel .'</strong> '. $prop_bath;
            echo '</li>';
        }
        if( !empty( $prop_size ) ) {
            $prop_size = esc_attr( $prop_size );

            echo '<li>';
            echo '<strong>'.houzez_get_listing_size_unit( $propID ) .':</strong> '. houzez_get_listing_area_size( $propID );
            echo '</li>';
        }
        echo '</ul>';

    }
}

/*-----------------------------------------------------------------------------------*/
// Featured image place holder
/*-----------------------------------------------------------------------------------*/

if( !function_exists('houzez_get_image_placeholder')){
    function houzez_get_image_placeholder( $featured_image_size ){

        $placeholder_url = houzez_option( 'houzez_placeholder', false, 'url' );

        if ( ! empty( $placeholder_url ) ) {
            $placeholder_image_id = attachment_url_to_postid( $placeholder_url );
            if ( ! empty( $placeholder_image_id ) ) {
                return wp_get_attachment_image( $placeholder_image_id, $featured_image_size, false, array( "class" => "img-fluid" ) );
            }

        } else {
            $dummy_image_url = houzez_get_dummy_placeholder_link( $featured_image_size );
            if ( ! empty( $dummy_image_url ) ) {
                return sprintf( '<img class="img-fluid" src="%s" alt="%s">', esc_url( $dummy_image_url ), the_title_attribute( 'echo=0' ) );
            }
        }

        return '';
    }
}

if( !function_exists('houzez_get_image_placeholder_url')){
    function houzez_get_image_placeholder_url( $image_size ){

        $placeholder_url = houzez_option( 'houzez_placeholder', false, 'url' );
        if ( ! empty( $placeholder_url ) ) {
            $placeholder_image_id = attachment_url_to_postid( $placeholder_url );
            if ( ! empty( $placeholder_image_id ) ) {
                return wp_get_attachment_image_url( $placeholder_image_id, $image_size, false );
            }
        }

        return houzez_get_dummy_placeholder_link( $image_size );
    }
}

if( !function_exists('houzez_get_dummy_placeholder_link')){
    function houzez_get_dummy_placeholder_link( $image_size ){

        global $_wp_additional_image_sizes;
        $img_width = 0;
        $img_height = 0;
        $img_text = get_bloginfo('name');

        $protocol = 'http';
        $protocol = ( is_ssl() ) ? 'https' : $protocol;

        if ( in_array( $image_size , array( 'thumbnail', 'medium', 'large' ) ) ) {

            $img_width = get_option( $image_size . '_size_w' );
            $img_height = get_option( $image_size . '_size_h' );

        } elseif ( isset( $_wp_additional_image_sizes[ $image_size ] ) ) {

            $img_width = $_wp_additional_image_sizes[ $image_size ]['width'];
            $img_height = $_wp_additional_image_sizes[ $image_size ]['height'];

        }

        if( intval( $img_width ) > 0 && intval( $img_height ) > 0 ) {
            return $protocol.'://placehold.it/' . $img_width . 'x' . $img_height . '&text=' . urlencode( $img_text ) . '';
        }

        return '';
    }
}

if( !function_exists( 'houzez_image_placeholder' ) ) {
    function houzez_image_placeholder( $image_size ) {
        echo houzez_get_image_placeholder( $image_size );
    }
}

/*-----------------------------------------------------------------------------------*/
// Get submit property url
/*-----------------------------------------------------------------------------------*/
if( !function_exists('houzez_dashboard_add_listing') ) {
    function houzez_dashboard_add_listing() {
        $args = array(
            'meta_key' => '_wp_page_template',
            'meta_value' => 'template/user_dashboard_submit.php'
        );
        $pages = get_pages($args);
        if( $pages ) {
            $add_link = get_permalink( $pages[0]->ID );
        } else {
            $add_link = home_url('/');
        }
        return $add_link;
    }
}

/*-----------------------------------------------------------------------------------*/
// Get required *
/*-----------------------------------------------------------------------------------*/
if( !function_exists('houzez_required_field') ) {
    function houzez_required_field( $field ) {
        $required_fields = houzez_option('required_fields');
        
        if(array_key_exists($field, $required_fields)) {
            $field = $required_fields[$field];
            if( $field != 0 ) {
                return ' *';
            }
        }
        
        return '';
    }
}

if( !function_exists('houzez_get_required_field_2') ) {
    function houzez_get_required_field_2( $field ) {
        $required_fields = houzez_option('required_fields');
        
        if(array_key_exists($field, $required_fields)) {
            $field = $required_fields[$field];
            if( $field != 0 ) {
                return 'required';
            }
        }
        return '';
    }
}

if( !function_exists('houzez_required_field_2') ) {
    function houzez_required_field_2( $field ) {
        echo houzez_get_required_field_2($field);
    }
}

/*-----------------------------------------------------------------------------------*/
// Get user properties dashboard
/*-----------------------------------------------------------------------------------*/
if( !function_exists('houzez_dashboard_listings') ) {
    function houzez_dashboard_listings() {
        $args = array(
            'meta_key' => '_wp_page_template',
            'meta_value' => 'template/user_dashboard_properties.php'
        );
        $pages = get_pages($args);
        if( $pages ) {
            $add_link = get_permalink( $pages[0]->ID );
        } else {
            $add_link = home_url('/');
        }
        return $add_link;
    }
}

/*-----------------------------------------------------------------------------------*/
// Get favorites properties dashboard
/*-----------------------------------------------------------------------------------*/
if( !function_exists('houzez_dashboard_favorites_link') ) {
    function houzez_dashboard_favorites_link() {
        $args = array(
            'meta_key' => '_wp_page_template',
            'meta_value' => 'template/user_dashboard_favorites.php'
        );
        $pages = get_pages($args);
        if( $pages ) {
            $add_link = get_permalink( $pages[0]->ID );
        } else {
            $add_link = home_url('/');
        }
        return $add_link;
    }
}

/*-----------------------------------------------------------------------------------*/
// Get template link
/*-----------------------------------------------------------------------------------*/
if( !function_exists('houzez_get_template_link') ) {
    function houzez_get_template_link($template) {
        $args = array(
            'meta_key' => '_wp_page_template',
            'meta_value' => $template
        );
        $pages = get_pages($args);
        if( $pages ) {
            $add_link = get_permalink( $pages[0]->ID );
        } else {
            $add_link = home_url('/');
        }
        return $add_link;
    }
}

/*-----------------------------------------------------------------------------------*/
// Revolution sliders
/*-----------------------------------------------------------------------------------*/
if( !function_exists('houzez_get_revolution_slider') ) {
    function houzez_get_revolution_slider() {
        global $wpdb;
        $catList = array();
        //Revolution Slider
        if (is_plugin_active('revslider/revslider.php')) {
            $sliders = $wpdb->get_results($q = "SELECT * FROM " . $wpdb->prefix . "revslider_sliders ORDER BY id");

            // Iterate over the sliders
            $catList = array();
            foreach ($sliders as $key => $item) {
                $catList[$item->alias] = stripslashes($item->title);
            }
        }

        return $catList;
    }
}

/*-----------------------------------------------------------------------------------*/
// Get template link
/*-----------------------------------------------------------------------------------*/
if( !function_exists('houzez_get_template_link') ) {
    function houzez_get_template_link($template) {
        $args = array(
            'meta_key' => '_wp_page_template',
            'meta_value' => $template
        );
        $pages = get_pages($args);
        if( $pages ) {
            $add_link = get_permalink( $pages[0]->ID );
        } else {
            $add_link = home_url('/');
        }
        return $add_link;
    }
}

/*-----------------------------------------------------------------------------------*/
// Get template link
/*-----------------------------------------------------------------------------------*/
if( !function_exists('houzez_get_template_link_2') ) {
    function houzez_get_template_link_2($template) {
        $args = array(
            'meta_key' => '_wp_page_template',
            'meta_value' => $template
        );
        $pages = get_pages($args);
        if( $pages ) {
            $add_link = get_permalink( $pages[0]->ID );
        } else {
            $add_link = '';
        }
        return $add_link;
    }
}

/*-----------------------------------------------------------------------------------*/
// Get Saved Search dashboard
/*-----------------------------------------------------------------------------------*/
if( !function_exists('houzez_dashboard_saved_search_link') ) {
    function houzez_dashboard_saved_search_link() {
        $args = array(
            'meta_key' => '_wp_page_template',
            'meta_value' => 'template/user_dashboard_saved_search.php'
        );
        $pages = get_pages($args);
        if( $pages ) {
            $add_link = get_permalink( $pages[0]->ID );
        } else {
            $add_link = home_url('/');
        }
        return $add_link;
    }
}

/*-----------------------------------------------------------------------------------*/
// Get search page link
/*-----------------------------------------------------------------------------------*/
if( !function_exists('houzez_get_search_template_link') ) {
    function houzez_get_search_template_link() {

        $template = 'template/template-search.php';

        $args = array(
            'meta_key' => '_wp_page_template',
            'sort_order' => 'desc',
            'sort_column' => 'ID',
            'meta_value' => $template
        );
        $pages = get_pages($args);
        if( $pages ) {
            $add_link = get_permalink( $pages[0]->ID );
        } else {
            $add_link = home_url('/');
        }
        return $add_link;
    }
}

if( !function_exists('houzez_properties_listing_link') ) {
    function houzez_properties_listing_link() {
        global $post;
        $args = array(
            'meta_key' => '_wp_page_template',
            'meta_value' => get_post_meta( $post->ID, '_wp_page_template', true )
        );
        $pages = get_pages($args);
        if( $pages ) {
            $add_link = get_permalink( $post->ID );
        } else {
            $add_link = home_url('/');
        }
        return $add_link;
    }
}

if( !function_exists('houzez_properties_listing_full_link') ) {
    function houzez_properties_listing_full_link() {
        global $post;
        $args = array(
            'meta_key' => '_wp_page_template',
            'meta_value' => 'template/property-listing-fullwidth.php'
        );
        $pages = get_pages($args);
        if( $pages ) {
            $add_link = get_permalink( $post->ID );
        } else {
            $add_link = home_url('/');
        }
        return $add_link;
    }
}



/*-----------------------------------------------------------------------------------*/
// Get Invoices dashboard
/*-----------------------------------------------------------------------------------*/
if( !function_exists('houzez_dashboard_invoices_link') ) {
    function houzez_dashboard_invoices_link() {
        $args = array(
            'meta_key' => '_wp_page_template',
            'meta_value' => 'template/user_dashboard_invoices.php'
        );
        $pages = get_pages($args);
        if( $pages ) {
            $add_link = get_permalink( $pages[0]->ID );
        } else {
            $add_link = home_url('/');
        }
        return $add_link;
    }
}

/*-----------------------------------------------------------------------------------*/
// Generate Hirarchical terms
/*-----------------------------------------------------------------------------------*/
if(!function_exists('houzez_hirarchical_options')){
    function houzez_hirarchical_options($taxonomy_name, $taxonomy_terms, $searched_term, $prefix = " " ){

        if (!empty($taxonomy_terms) && taxonomy_exists($taxonomy_name)) {
            foreach ($taxonomy_terms as $term) {

                if( $taxonomy_name == 'property_area' ) {
                    $term_meta= get_option( "_houzez_property_area_$term->term_id");
                    $parent_city = sanitize_title($term_meta['parent_city']);

                    if ($searched_term == $term->slug) {
                        echo '<option data-ref="' . urldecode($term->slug) . '" data-belong="'.urldecode($parent_city).'" value="' . urldecode($term->slug) . '" selected="selected">' . esc_attr($prefix) . esc_attr($term->name) . '</option>';
                    } else {
                        echo '<option data-ref="' . urldecode($term->slug) . '" data-belong="'.urldecode($parent_city).'" value="' . urldecode($term->slug) . '">' . esc_attr($prefix) . esc_attr($term->name) .'</option>';
                    }
                    
                } elseif( $taxonomy_name == 'property_city' ) {
                    $term_meta= get_option( "_houzez_property_city_$term->term_id");
                    $parent_state = sanitize_title($term_meta['parent_state']);

                    if ($searched_term == $term->slug) {
                        echo '<option data-ref="' . urldecode($term->slug) . '" data-belong="'.urldecode($parent_state).'" value="' . urldecode($term->slug) . '" selected="selected">' . esc_attr($prefix) . esc_attr($term->name) . '</option>';
                    } else {
                        echo '<option data-ref="' . urldecode($term->slug) . '" data-belong="'.urldecode($parent_state).'" value="' . urldecode($term->slug) . '">' . esc_attr($prefix) . esc_attr($term->name) .'</option>';
                    }

                } elseif( $taxonomy_name == 'property_state' ) {

                    $term_meta = get_option( "_houzez_property_state_$term->term_id");
                    $parent_country = sanitize_title($term_meta['parent_country']);

                    if ($searched_term == $term->slug) {
                        echo '<option data-ref="' . urldecode($term->slug) . '" data-belong="'.urldecode($parent_country).'" value="' . urldecode($term->slug) . '" selected="selected">' . esc_attr($prefix) . esc_attr($term->name) . '</option>';
                    } else {
                        echo '<option data-ref="' . urldecode($term->slug) . '" data-belong="'.urldecode($parent_country).'" value="' . urldecode($term->slug) . '">' . esc_attr($prefix) . esc_attr($term->name) .'</option>';
                    }

                } elseif( $taxonomy_name == 'property_country' ) {
            
                    if ($searched_term == $term->slug) {
                        echo '<option data-ref="' . urldecode($term->slug) . '" value="' . urldecode($term->slug) . '" selected="selected">' . esc_attr($prefix) . esc_attr($term->name) . '</option>';
                    } else {
                        echo '<option data-ref="' . urldecode($term->slug) . '" value="' . urldecode($term->slug) . '">' . esc_attr($prefix) . esc_attr($term->name) .'</option>';
                    }

                } else {

                    if ($searched_term == $term->slug) {
                        echo '<option value="' . urldecode($term->slug) . '" selected="selected">' . esc_attr($prefix) . esc_attr($term->name) . '</option>';
                    } else {
                        echo '<option value="' . urldecode($term->slug) . '">' . esc_attr($prefix) . esc_attr($term->name) . '</option>';
                    }
                }


                $child_terms = get_terms($taxonomy_name, array(
                    'hide_empty' => false,
                    'parent' => $term->term_id
                ));

                if (!empty($child_terms)) {
                    houzez_hirarchical_options( $taxonomy_name, $child_terms, $searched_term, "- ".$prefix );
                }
            }
        }
    }
}

/**
 *   ----------------------------------------------------------------------------------------------------------------------------------------------------
 *   Property post type array
 *   ----------------------------------------------------------------------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'houzez_get_property_type_id_array' ) ) {
    function houzez_get_property_type_id_array($add_all_type = true) {

        if (is_admin() === false) {
            return;
        }

        $types = get_categories(array(
            'hide_empty' => 0,
            'taxonomy'   => 'property_type',
        ));

        $houzez_property_type_id_array_walker = new houzez_property_type_id_array_walker;
        $houzez_property_type_id_array_walker->walk($types, 4);

        if ($add_all_type === true) {
            $types_buffer['- All Types -'] = '';
            return array_merge(
                $types_buffer,
                $houzez_property_type_id_array_walker->houzez_array_buffer
            );
        } else {
            return $houzez_property_type_id_array_walker->houzez_array_buffer;
        }
    }
}

class houzez_property_type_id_array_walker extends Walker {
    var $tree_type = 'property_type';
    var $db_fields = array ('parent' => 'parent', 'id' => 'term_id');

    var $houzez_array_buffer = array();

    function start_lvl( &$output, $depth = 0, $args = array() ) {
    }

    function end_lvl( &$output, $depth = 0, $args = array() ) {
    }


    function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
        $this->houzez_array_buffer[str_repeat(' - ', $depth) .  $category->name] = $category->term_id;
    }


    function end_el( &$output, $page, $depth = 0, $args = array() ) {
    }

}

/**
 *   ----------------------------------------------------------------------------------------------------------------------------------------------------
 *   Property post type slug tree
 *   ----------------------------------------------------------------------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'houzez_get_property_type_slug_array' ) ) {
    function houzez_get_property_type_slug_array($add_all_type = true) {

        if (is_admin() === false) {
            return;
        }

        $types = get_categories(array(
            'hide_empty' => 0,
            'taxonomy'   => 'property_type',
        ));

        $houzez_property_type_slug_array_walker = new houzez_property_type_slug_array_walker;
        $houzez_property_type_slug_array_walker->walk($types, 4);

        if ($add_all_type === true) {
            $types_buffer['- All Types -'] = '';
            return array_merge(
                $types_buffer,
                $houzez_property_type_slug_array_walker->houzez_array_buffer
            );
        } else {
            return $houzez_property_type_slug_array_walker->houzez_array_buffer;
        }
    }
}

class houzez_property_type_slug_array_walker extends Walker {
    var $tree_type = 'property_type';
    var $db_fields = array ('parent' => 'parent', 'id' => 'term_id');

    var $houzez_array_buffer = array();

    function start_lvl( &$output, $depth = 0, $args = array() ) {
    }

    function end_lvl( &$output, $depth = 0, $args = array() ) {
    }


    function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
        $this->houzez_array_buffer[str_repeat(' - ', $depth) .  $category->name] = $category->slug;
    }


    function end_el( &$output, $page, $depth = 0, $args = array() ) {
    }

}

/**
 *   ----------------------------------------------------------------------------------------------------------------------------------------------------
 *   property post type property status tree
 *   ----------------------------------------------------------------------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'houzez_get_property_status_id_array' ) ) {
    function houzez_get_property_status_id_array($add_all_status = true) {

        if (is_admin() === false) {
            return;
        }

        $categories = get_categories(array(
            'hide_empty' => 0,
            'taxonomy'   => 'property_status',
        ));

        $houzez_property_status_id_array_walker = new houzez_property_status_id_array_walker;
        $houzez_property_status_id_array_walker->walk($categories, 4);

        if ($add_all_status === true) {
            $status_buffer['- All -'] = '';
            return array_merge(
                $status_buffer,
                $houzez_property_status_id_array_walker->houzez_array_buffer
            );
        } else {
            return $houzez_property_status_id_array_walker->houzez_array_buffer;
        }
    }
}

class houzez_property_status_id_array_walker extends Walker {
    var $tree_type = 'property_status';
    var $db_fields = array ('parent' => 'parent', 'id' => 'term_id');

    var $houzez_array_buffer = array();

    function start_lvl( &$output, $depth = 0, $args = array() ) {
    }

    function end_lvl( &$output, $depth = 0, $args = array() ) {
    }


    function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
        $this->houzez_array_buffer[str_repeat(' - ', $depth) .  $category->name] = $category->term_id;
    }


    function end_el( &$output, $page, $depth = 0, $args = array() ) {
    }

}

/**
 *   ----------------------------------------------------------------------------------------------------------------------------------------------------
 *   property post type property status tree slug
 *   ----------------------------------------------------------------------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'houzez_get_property_status_slug_array' ) ) {
    function houzez_get_property_status_slug_array($add_all_status = true) {



        if (is_admin() === false) {
            return;
        }

        $categories = get_categories(array(
            'hide_empty' => 0,
            'taxonomy'   => 'property_status',
        ));

        $houzez_property_status_slug_array_walker = new houzez_property_status_slug_array_walker;
        $houzez_property_status_slug_array_walker->walk($categories, 4);

        if ($add_all_status === true) {
            $status_buffer['- All -'] = '';
            return array_merge(
                $status_buffer,
                $houzez_property_status_slug_array_walker->houzez_array_buffer
            );
        } else {
            return $houzez_property_status_slug_array_walker->houzez_array_buffer;
        }
    }
}

class houzez_property_status_slug_array_walker extends Walker {
    var $tree_type = 'property_status';
    var $db_fields = array ('parent' => 'parent', 'id' => 'term_id');

    var $houzez_array_buffer = array();

    function start_lvl( &$output, $depth = 0, $args = array() ) {
    }

    function end_lvl( &$output, $depth = 0, $args = array() ) {
    }


    function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
        $this->houzez_array_buffer[str_repeat(' - ', $depth) .  $category->name] = $category->slug;
    }


    function end_el( &$output, $page, $depth = 0, $args = array() ) {
    }

}

/**
 *   ----------------------------------------------------------------------------------------------------------------------------------------------------
 *   property post type property city tree
 *   ----------------------------------------------------------------------------------------------------------------------------------------------------
 */

if ( ! function_exists( 'houzez_get_property_city_id_array' ) ) {
    function houzez_get_property_city_id_array($add_all_city = true) {

        if (is_admin() === false) {
            return;
        }

        $categories = get_categories(array(
            'hide_empty' => 0,
            'taxonomy'   => 'property_city',
        ));

        $houzez_property_city_id_array_walker = new houzez_property_city_id_array_walker;
        $houzez_property_city_id_array_walker->walk($categories, 4);

        if ($add_all_city === true) {
            $cities_buffer['- All -'] = '';
            return array_merge(
                $cities_buffer,
                $houzez_property_city_id_array_walker->houzez_array_buffer
            );
        } else {
            return $houzez_property_city_id_array_walker->houzez_array_buffer;
        }
    }
}

class houzez_property_city_id_array_walker extends Walker {
    var $tree_type = 'property_city';
    var $db_fields = array ('parent' => 'parent', 'id' => 'term_id');

    var $houzez_array_buffer = array();

    function start_lvl( &$output, $depth = 0, $args = array() ) {
    }

    function end_lvl( &$output, $depth = 0, $args = array() ) {
    }


    function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
        $this->houzez_array_buffer[str_repeat(' - ', $depth) .  $category->name] = $category->term_id;
    }


    function end_el( &$output, $page, $depth = 0, $args = array() ) {
    }

}

/**
 *   ----------------------------------------------------------------------------------------------------------------------------------------------------
 *   property post type property city tree
 *   ----------------------------------------------------------------------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'houzez_get_property_city_slug_array' ) ) {
    function houzez_get_property_city_slug_array($add_all_cities = true) {



        if (is_admin() === false) {
            return;
        }

        $categories = get_categories(array(
            'hide_empty' => 0,
            'taxonomy'   => 'property_city',
        ));

        $houzez_property_city_slug_array_walker = new houzez_property_city_slug_array_walker;
        $houzez_property_city_slug_array_walker->walk($categories, 4);

        if ($add_all_cities === true) {
            $cities_buffer['- All -'] = '';
            return array_merge(
                $cities_buffer,
                $houzez_property_city_slug_array_walker->houzez_array_buffer
            );
        } else {
            return $houzez_property_city_slug_array_walker->houzez_array_buffer;
        }
    }
}

class houzez_property_city_slug_array_walker extends Walker {
    var $tree_type = 'property_city';
    var $db_fields = array ('parent' => 'parent', 'id' => 'term_id');

    var $houzez_array_buffer = array();

    function start_lvl( &$output, $depth = 0, $args = array() ) {
    }

    function end_lvl( &$output, $depth = 0, $args = array() ) {
    }


    function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
        $this->houzez_array_buffer[str_repeat(' - ', $depth) .  $category->name] = $category->slug;
    }


    function end_el( &$output, $page, $depth = 0, $args = array() ) {
    }

}


if( !function_exists('houzez_count_property_views') ) {
    function houzez_count_property_views( $prop_id ) {

        $total_views = intval( get_post_meta($prop_id, 'houzez_total_property_views', true) );

        if( $total_views != '' ) {
            $total_views++;
        } else {
            $total_views = 1;
        }
        update_post_meta( $prop_id, 'houzez_total_property_views', $total_views );

        $today = date('m-d-Y', time());
        $today_time = date('m-d-Y h:i:s', time());

        //$today = date('m-d-Y', strtotime("-1 days"));
        $views_by_date = get_post_meta($prop_id, 'houzez_views_by_date', true);

        if( $views_by_date != '' || is_array($views_by_date) ) {
            if (!isset($views_by_date[$today])) {

                if (count($views_by_date) > 60) {
                    array_shift($views_by_date);
                }
                $views_by_date[$today] = 1;

            } else {
                $views_by_date[$today] = intval($views_by_date[$today]) + 1;
            }
        } else {
            $views_by_date = array();
            $views_by_date[$today] = 1;
        }

        update_post_meta($prop_id, 'houzez_views_by_date', $views_by_date);
        update_post_meta($prop_id, 'houzez_recently_viewed', current_time('mysql'));

    }
}

if( !function_exists('houzez_return_traffic_labels') ) {
    function houzez_return_traffic_labels( $prop_id ) {

        $record_days = houzez_option('houzez_stats_days');
        if( empty($record_days) ) {
            $record_days = 14;
        }

        $views_by_date = get_post_meta($prop_id, 'houzez_views_by_date', true);

        if (!is_array($views_by_date)) {
            $views_by_date = array();
        }
        $array_labels = array_keys($views_by_date);
        $array_labels = array_slice( $array_labels, -1 * $record_days, $record_days, false );

        return $array_labels;
    }
}


if ( ! function_exists( 'houzez_get_property_state_id_array' ) ) {
    function houzez_get_property_state_id_array($add_all_category = true) {

        if (is_admin() === false) {
            return;
        }

        $categories = get_categories(array(
            'hide_empty' => 0,
            'taxonomy'   => 'property_state',
        ));

        $houzez_property_state_id_array_walker = new houzez_property_state_id_array_walker;
        $houzez_property_state_id_array_walker->walk($categories, 4);

        if ($add_all_category === true) {
            $categories_buffer['- All -'] = '';
            return array_merge(
                $categories_buffer,
                $houzez_property_state_id_array_walker->houzez_array_buffer
            );
        } else {
            return $houzez_property_state_id_array_walker->houzez_array_buffer;
        }
    }
}

class houzez_property_state_id_array_walker extends Walker {
    var $tree_type = 'property_state';
    var $db_fields = array ('parent' => 'parent', 'id' => 'term_id');

    var $houzez_array_buffer = array();

    function start_lvl( &$output, $depth = 0, $args = array() ) {
    }

    function end_lvl( &$output, $depth = 0, $args = array() ) {
    }


    function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
        $this->houzez_array_buffer[str_repeat(' - ', $depth) .  $category->name] = $category->term_id;
    }


    function end_el( &$output, $page, $depth = 0, $args = array() ) {
    }

}

/**
 *   ----------------------------------------------------------------------------------------------------------------------------------------------------
 *   property post type property state tree
 *   ----------------------------------------------------------------------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'houzez_get_property_state_slug_array' ) ) {
    function houzez_get_property_state_slug_array($add_all_category = true) {

        if (is_admin() === false) {
            return;
        }

        $categories = get_categories(array(
            'hide_empty' => 0,
            'taxonomy'   => 'property_state',
        ));

        $houzez_property_state_slug_array_walker = new houzez_property_state_slug_array_walker;
        $houzez_property_state_slug_array_walker->walk($categories, 4);

        if ($add_all_category === true) {
            $categories_buffer['- All -'] = '';
            return array_merge(
                $categories_buffer,
                $houzez_property_state_slug_array_walker->houzez_array_buffer
            );
        } else {
            return $houzez_property_state_slug_array_walker->houzez_array_buffer;
        }
    }
}

class houzez_property_state_slug_array_walker extends Walker {
    var $tree_type = 'property_state';
    var $db_fields = array ('parent' => 'parent', 'id' => 'term_id');

    var $houzez_array_buffer = array();

    function start_lvl( &$output, $depth = 0, $args = array() ) {
    }

    function end_lvl( &$output, $depth = 0, $args = array() ) {
    }


    function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
        $this->houzez_array_buffer[str_repeat(' - ', $depth) .  $category->name] = $category->slug;
    }


    function end_el( &$output, $page, $depth = 0, $args = array() ) {
    }

}

/**
 *   ----------------------------------------------------------------------------------------------------------------------------------------------------
 *   property post type property area tree
 *   ----------------------------------------------------------------------------------------------------------------------------------------------------
 */

if ( ! function_exists( 'houzez_get_property_area_slug_array' ) ) {
    function houzez_get_property_area_slug_array($add_all_category = true) {

        if (is_admin() === false) {
            return;
        }

        $categories = get_categories(array(
            'hide_empty' => 0,
            'taxonomy'   => 'property_area',
        ));

        $houzez_property_area_slug_array_walker = new houzez_property_area_slug_array_walker;
        $houzez_property_area_slug_array_walker->walk($categories, 4);

        if ($add_all_category === true) {
            $categories_buffer['- All -'] = '';
            return array_merge(
                $categories_buffer,
                $houzez_property_area_slug_array_walker->houzez_array_buffer
            );
        } else {
            return $houzez_property_area_slug_array_walker->houzez_array_buffer;
        }
    }
}

class houzez_property_area_slug_array_walker extends Walker {
    var $tree_type = 'property_area';
    var $db_fields = array ('parent' => 'parent', 'id' => 'term_id');

    var $houzez_array_buffer = array();

    function start_lvl( &$output, $depth = 0, $args = array() ) {
    }

    function end_lvl( &$output, $depth = 0, $args = array() ) {
    }


    function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
        $this->houzez_array_buffer[str_repeat(' - ', $depth) .  $category->name] = $category->slug;
    }


    function end_el( &$output, $page, $depth = 0, $args = array() ) {
    }

}


/**
 *   ----------------------------------------------------------------------------------------------------------------------------------------------------
 *   property post type property area tree
 *   ----------------------------------------------------------------------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'houzez_get_property_label_slug_array' ) ) {
    function houzez_get_property_label_slug_array($add_all_category = true) {

        if (is_admin() === false) {
            return;
        }

        $categories = get_categories(array(
            'hide_empty' => 0,
            'taxonomy'   => 'property_label',
        ));

        $houzez_property_label_slug_array_walker = new houzez_property_label_slug_array_walker;
        $houzez_property_label_slug_array_walker->walk($categories, 4);

        if ($add_all_category === true) {
            $categories_buffer['- All -'] = '';
            return array_merge(
                $categories_buffer,
                $houzez_property_label_slug_array_walker->houzez_array_buffer
            );
        } else {
            return $houzez_property_label_slug_array_walker->houzez_array_buffer;
        }
    }
}

class houzez_property_label_slug_array_walker extends Walker {
    var $tree_type = 'property_label';
    var $db_fields = array ('parent' => 'parent', 'id' => 'term_id');

    var $houzez_array_buffer = array();

    function start_lvl( &$output, $depth = 0, $args = array() ) {
    }

    function end_lvl( &$output, $depth = 0, $args = array() ) {
    }


    function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
        $this->houzez_array_buffer[str_repeat(' - ', $depth) .  $category->name] = $category->slug;
    }


    function end_el( &$output, $page, $depth = 0, $args = array() ) {
    }

}

if( !function_exists('houzez_return_traffic_data') ) {
    function houzez_return_traffic_data($prop_id) {

        $record_days = houzez_option('houzez_stats_days');
        if( empty($record_days) ) {
            $record_days = 14;
        }

        $views_by_date = get_post_meta( $prop_id, 'houzez_views_by_date', true );
        if ( !is_array( $views_by_date ) ) {
            $views_by_date = array();
        }
        $array_values = array_values( $views_by_date );
        $array_values = array_slice( $array_values, -1 * $record_days, $record_days, false );

        return $array_values;
    }
}

/**
 *   ----------------------------------------------------------------------------------------------------------------------------------------------------
 *   Generates a taxonomy tree slug array
 *   ----------------------------------------------------------------------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'houzez_get_agent_category_slug_array' ) ) {
    function houzez_get_agent_category_slug_array($add_all_taxonomy = true ) {

        if (is_admin() === false) {
            return;
        }

        $categories = get_categories(array(
            'hide_empty' => 0,
            'taxonomy'   => 'agent_category',
        ));

        $houzez_get_agent_category_slug_array_walker = new houzez_get_agent_category_slug_array_walker;
        $houzez_get_agent_category_slug_array_walker->walk($categories, 4);

        if ($add_all_taxonomy === true) {
            $categories_buffer['- All -'] = '';
            return array_merge(
                $categories_buffer,
                $houzez_get_agent_category_slug_array_walker->houzez_array_buffer
            );
        } else {
            return $houzez_get_agent_category_slug_array_walker->houzez_array_buffer;
        }
    }
}

class houzez_get_agent_category_slug_array_walker extends Walker {
    var $tree_type = 'agent_category';
    var $db_fields = array ('parent' => 'parent', 'id' => 'term_id');

    var $houzez_array_buffer = array();

    function start_lvl( &$output, $depth = 0, $args = array() ) {
    }

    function end_lvl( &$output, $depth = 0, $args = array() ) {
    }


    function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
        $this->houzez_array_buffer[str_repeat(' - ', $depth) .  $category->name] = $category->slug;
    }


    function end_el( &$output, $page, $depth = 0, $args = array() ) {
    }

}


/**
 *   ----------------------------------------------------------------------------------------------------------------------------------------------------
 *   property post type property labels tree
 *   ----------------------------------------------------------------------------------------------------------------------------------------------------
 */

if ( ! function_exists( 'houzez_get_property_label_id_array' ) ) {
    function houzez_get_property_label_id_array($add_all_city = true) {

        if (is_admin() === false) {
            return;
        }

        $categories = get_categories(array(
            'hide_empty' => 0,
            'taxonomy'   => 'property_label',
        ));

        $houzez_property_city_id_array_walker = new houzez_property_label_id_array_walker;
        $houzez_property_city_id_array_walker->walk($categories, 4);

        if ($add_all_city === true) {
            $cities_buffer['- All -'] = '';
            return array_merge(
                $cities_buffer,
                $houzez_property_city_id_array_walker->houzez_array_buffer
            );
        } else {
            return $houzez_property_city_id_array_walker->houzez_array_buffer;
        }
    }
}

class houzez_property_label_id_array_walker extends Walker {
    var $tree_type = 'property_label';
    var $db_fields = array ('parent' => 'parent', 'id' => 'term_id');

    var $houzez_array_buffer = array();

    function start_lvl( &$output, $depth = 0, $args = array() ) {
    }

    function end_lvl( &$output, $depth = 0, $args = array() ) {
    }


    function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
        $this->houzez_array_buffer[str_repeat(' - ', $depth) .  $category->name] = $category->term_id;
    }


    function end_el( &$output, $page, $depth = 0, $args = array() ) {
    }

}


/**
 *   ----------------------------------------------------------------------------------------------------------------------------------------------------
 *   property post type property area tree
 *   ----------------------------------------------------------------------------------------------------------------------------------------------------
 */

if ( ! function_exists( 'houzez_get_property_area_id_array' ) ) {
    function houzez_get_property_area_id_array($add_all_city = true) {

        if (is_admin() === false) {
            return;
        }

        $categories = get_categories(array(
            'hide_empty' => 0,
            'taxonomy'   => 'property_area',
        ));

        $houzez_property_city_id_array_walker = new houzez_property_area_id_array_walker;
        $houzez_property_city_id_array_walker->walk($categories, 4);

        if ($add_all_city === true) {
            $cities_buffer['- All -'] = '';
            return array_merge(
                $cities_buffer,
                $houzez_property_city_id_array_walker->houzez_array_buffer
            );
        } else {
            return $houzez_property_city_id_array_walker->houzez_array_buffer;
        }
    }
}

class houzez_property_area_id_array_walker extends Walker {
    var $tree_type = 'property_area';
    var $db_fields = array ('parent' => 'parent', 'id' => 'term_id');

    var $houzez_array_buffer = array();

    function start_lvl( &$output, $depth = 0, $args = array() ) {
    }

    function end_lvl( &$output, $depth = 0, $args = array() ) {
    }


    function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
        $this->houzez_array_buffer[str_repeat(' - ', $depth) .  $category->name] = $category->term_id;
    }


    function end_el( &$output, $page, $depth = 0, $args = array() ) {
    }

}

/*-----------------------------------------------------------------------------------*/
// get taxonomies with with id value
/*-----------------------------------------------------------------------------------*/
if(!function_exists('houzez_get_taxonomies_with_id_value')){
    function houzez_get_taxonomies_with_id_value($taxonomy, $parent_taxonomy, $taxonomy_id, $prefix = " " ){

        if (!empty($parent_taxonomy)) {
            foreach ($parent_taxonomy as $term) {
                if ($taxonomy_id != $term->term_id) {
                    echo '<option value="' . $term->term_id . '">' . $prefix . $term->name . '</option>';
                } else {
                    echo '<option value="' . $term->term_id . '" selected="selected">' . $prefix . $term->name . '</option>';
                }
                $get_child_terms = get_terms($taxonomy, array(
                    'hide_empty' => false,
                    'parent' => $term->term_id
                ));

                if (!empty($get_child_terms)) {
                    houzez_get_taxonomies_with_id_value( $taxonomy, $get_child_terms, $taxonomy_id, "- ".$prefix );
                }
            }
        }
    }
}

/*-----------------------------------------------------------------------------------*/
// Get taxonomy by post id and taxonomy name
/*-----------------------------------------------------------------------------------*/
if(!function_exists('houzez_taxonomy_by_postID')){
    function houzez_taxonomy_by_postID( $property_id, $taxonomy_name ){

        $tax_terms = get_the_terms( $property_id, $taxonomy_name );
        $tax_name = '';
        if( !empty($tax_terms) ){
            foreach( $tax_terms as $tax_term ){
                $tax_name = $tax_term->name;
                break;
            }
        }
        return $tax_name;
    }
}

/* -----------------------------------------------------------------------------------------------------------
 *  Get user current listings
 -------------------------------------------------------------------------------------------------------------*/
if( !function_exists('houzez_get_current_listings') ):
    function houzez_get_current_listings( $userID ) {
        $args = array(
            'post_type'   => 'property',
            'post_status' => 'any',
            'author'      => $userID,

        );
        $posts = new WP_Query( $args );
        return $posts->found_posts;
        wp_reset_postdata();
    }
endif;

/* -----------------------------------------------------------------------------------------------------------
 *  Get user current featured listings
 -------------------------------------------------------------------------------------------------------------*/
if( !function_exists('houzez_get_current_featured_listings') ):
    function houzez_get_current_featured_listings( $userID ) {

        $args = array(
            'post_type'     =>  'property',
            'post_status'   =>  'any',
            'author'        =>  $userID,
            'meta_query'    =>  array(
                array(
                    'key'   => 'fave_featured',
                    'value' => 1,
                    'meta_compare '=>'='
                )
            )
        );
        $posts = new WP_Query( $args );
        return $posts->found_posts;
        wp_reset_postdata();

    }
endif;

if(!function_exists('houzez_theme_activate')) {
    function houzez_theme_activate() {

        if(isset($_GET['houzez'])) {
            update_option( 'houzez_activation', $_GET['houzez'] );
        }
    }
}
houzez_theme_activate();

if(!function_exists('houzez_theme_verified')) {
    function houzez_theme_verified() {

        if( get_option( 'houzez_activation' ) === 'activated' ) {
            return true;
        } 
        return false;
    }
}

if(!function_exists('houzez_set_demo_mode')) {
    function houzez_set_demo_mode() {

        if(isset($_GET['houzez_demo_mode'])) {
            update_option( 'houzez_demo_mode', $_GET['houzez_demo_mode'] );
        }
    }
}
houzez_set_demo_mode();

if(!function_exists('houzez_is_demo')) {
    function houzez_is_demo() {
        return get_option('houzez_demo_mode');
    }
}

if ( !function_exists( 'houzez_get_agents_array' ) ) {
    
    function houzez_get_agents_array() {

        $agents_array = array(
            - 1 => houzez_option('cl_none', 'None'),
        );

        $agents_posts = get_posts(
            array(
                'post_type'        => 'houzez_agent',
                'posts_per_page'   => - 1,
                'suppress_filters' => false,
            )
        );

        if ( count( $agents_posts ) > 0 ) {
            foreach ( $agents_posts as $agent_post ) {
                $agents_array[ $agent_post->ID ] = $agent_post->post_title;
            }
        }

        return $agents_array;

    }
}


if ( !function_exists( 'houzez_get_agency_array' ) ) {
    function houzez_get_agency_array() {

        $agency_array = array(
            - 1 => houzez_option('cl_none', 'None'),
        );

        $agency_posts = get_posts(
            array(
                'post_type'        => 'houzez_agency',
                'posts_per_page'   => - 1,
                'suppress_filters' => false,
            )
        );

        if ( count( $agency_posts ) > 0 ) {
            foreach ( $agency_posts as $agency_post ) {
                $agency_array[ $agency_post->ID ] = $agency_post->post_title;
            }
        }

        return $agency_array;

    }
}

if(!function_exists('houzez_get_term_id_by_slug')) {
    function houzez_get_term_id_by_slug($slug, $taxonomy) {
        if( !taxonomy_exists($taxonomy) && empty($slug)) {
            return '';
        }
        $term = get_term_by('slug', $slug, $taxonomy);
        if(empty($term)) {
            return '';
        }
        return $term->term_id;
    }
}

if(!function_exists('houzez_get_term_name_by_slug')) {
    function houzez_get_term_name_by_slug($slug, $taxonomy) {
        if( !taxonomy_exists($taxonomy) && empty($slug)) {
            return '';
        }
        $term = get_term_by('slug', $slug, $taxonomy);
        if(empty($term)) {
            return '';
        }
        return $term->name;
    }
}

/*-----------------------------------------------------------------------------------*/
// Propert Edit Form Hierarchichal Taxonomy Options
/*-----------------------------------------------------------------------------------*/
if(!function_exists('houzez_get_taxonomies_for_edit_listing')){
    function houzez_get_taxonomies_for_edit_listing( $listing_id, $taxonomy ){

        $taxonomy_id = '';
        $taxonomy_terms = get_the_terms( $listing_id, $taxonomy );

        if( !empty($taxonomy_terms) ){
            foreach( $taxonomy_terms as $term ){
                $taxonomy_id = $term->term_id;
                break;
            }
        }


        $taxonomy_id = intval($taxonomy_id);
        if( !empty($taxonomy_id)) {
            echo '<option value="-1">'.esc_html__( 'None', 'houzez').'</option>';
        } else {
            echo '<option value="-1" selected="selected">'.esc_html__( 'None', 'houzez').'</option>';
        }
        $parent_taxonomy = get_terms(
            array(
                $taxonomy
            ),
            array(
                'orderby'       => 'name',
                'order'         => 'ASC',
                'hide_empty'    => false,
                'parent' => 0
            )
        );
        houzez_get_taxonomies_with_id_value( $taxonomy, $parent_taxonomy, $taxonomy_id );

    }
}

/*-----------------------------------------------------------------------------------*/
// Generate Hirarchical terms
/*-----------------------------------------------------------------------------------*/
if(!function_exists('houzez_get_search_taxonomies')){
    function houzez_get_search_taxonomies($taxonomy_name, $searched_data = "", $args = array() ){
        
        $hide_empty = false;
        if($taxonomy_name == 'property_city' || $taxonomy_name == 'property_area' || $taxonomy_name == 'property_country' || $taxonomy_name == 'property_state') {
            $hide_empty = houzez_hide_empty_taxonomies();
        }
        
        $defaults = array(
            'taxonomy' => $taxonomy_name,
            'orderby'       => 'name',
            'order'         => 'ASC',
            'hide_empty'    => $hide_empty,
        );

        $args       = wp_parse_args( $args, $defaults );
        $taxonomies = get_terms( $args );

        if ( empty( $taxonomies ) || is_wp_error( $taxonomies ) ) {
            return false;
        }

        $output = '';
        foreach( $taxonomies as $category ) {
            if( $category->parent == 0 ) {

                $data_attr = $data_subtext = '';

                if( $taxonomy_name == 'property_city' ) {
                    $term_meta= get_option( "_houzez_property_city_$category->term_id");
                    $parent_state = isset($term_meta['parent_state']) ? $term_meta['parent_state'] : '';
                    $parent_state = sanitize_title($parent_state);
                    $data_attr = 'data-belong="'.esc_attr($parent_state).'"';
                    $data_subtext = 'data-subtext="'.houzez_get_term_name_by_slug($parent_state, 'property_state').'"';

                } elseif( $taxonomy_name == 'property_area' ) {
                    $term_meta= get_option( "_houzez_property_area_$category->term_id");
                    $parent_city = isset($term_meta['parent_city']) ? $term_meta['parent_city'] : '';
                    $parent_city = sanitize_title($parent_city);
                    $data_attr = 'data-belong="'.esc_attr($parent_city).'"';
                    $data_subtext = 'data-subtext="'.houzez_get_term_name_by_slug($parent_city, 'property_city').'"';

                } elseif( $taxonomy_name == 'property_state' ) {
                    $term_meta = get_option( "_houzez_property_state_$category->term_id");
                    $parent_country = isset($term_meta['parent_country']) ? $term_meta['parent_country'] : '';
                    $parent_country = sanitize_title($parent_country);
                    $data_attr = 'data-belong="'.esc_attr($parent_country).'"';
                    $data_subtext = 'data-subtext="'.houzez_get_term_name_by_slug($parent_country, 'property_country').'"';

                }

                if ( !empty($searched_data) && in_array( $category->slug, $searched_data ) ) {
                    $output.= '<option data-ref="'.esc_attr($category->slug).'" '.$data_attr.' '.$data_subtext.' value="' . esc_attr($category->slug) . '" selected="selected">'. esc_attr($category->name) . '</option>';
                } else {
                    $output.= '<option data-ref="'.esc_attr($category->slug).'" '.$data_attr.' '.$data_subtext.' value="' . esc_attr($category->slug) . '">' . esc_attr($category->name) . '</option>';
                }

                foreach( $taxonomies as $subcategory ) {
                    if($subcategory->parent == $category->term_id) {

                        $data_attr_child = '';
                        if( $taxonomy_name == 'property_city' ) {
                            $term_meta= get_option( "_houzez_property_city_$subcategory->term_id");
                            $parent_state = isset($term_meta['parent_state']) ? $term_meta['parent_state'] : '';
                            $parent_state = sanitize_title($parent_state);
                            $data_attr_child = 'data-belong="'.esc_attr($parent_state).'"';

                        } elseif( $taxonomy_name == 'property_area' ) {
                            $term_meta= get_option( "_houzez_property_area_$subcategory->term_id");
                            $parent_city = isset($term_meta['parent_city']) ? $term_meta['parent_city'] : '';
                            $parent_city = sanitize_title($parent_city);
                            $data_attr_child = 'data-belong="'.esc_attr($parent_city).'"';

                        } elseif( $taxonomy_name == 'property_state' ) {
                            $term_meta= get_option( "_houzez_property_state_$subcategory->term_id");
                            $parent_country = isset($term_meta['parent_country']) ? $term_meta['parent_country'] : '';
                            $parent_country = sanitize_title($parent_country);
                            $data_attr_child = 'data-belong="'.esc_attr($parent_country).'"';
                        }

                        if ( !empty($searched_data) && in_array( $subcategory->slug, $searched_data ) ) {
                            $output.= '<option data-ref="'.esc_attr($subcategory->slug).'" '.$data_attr_child.' value="' . esc_attr($subcategory->slug) . '" selected="selected"> - '. esc_attr($subcategory->name) . '</option>';
                        } else {
                            $output.= '<option data-ref="'.esc_attr($subcategory->slug).'" '.$data_attr_child.' value="' . esc_attr($subcategory->slug) . '"> - ' . esc_attr($subcategory->name) . '</option>';
                        }
                    }
                }
            }
        }
        echo $output;

    }
}

/*-----------------------------------------------------------------------------------*/
// Property edit taxonomy for multiple
/*-----------------------------------------------------------------------------------*/
if(!function_exists('houzez_get_taxonomies_for_edit_listing_multivalue')){
    function houzez_get_taxonomies_for_edit_listing_multivalue( $listing_id, $taxonomy ){

        $taxonomy_terms_ids= array();
        $taxonomy_terms = get_the_terms( $listing_id, $taxonomy );

        if ( $taxonomy_terms && ! is_wp_error( $taxonomy_terms ) ) {
            foreach( $taxonomy_terms as $term ) {
                $taxonomy_terms_ids[] = intval( $term->term_id );
            }
        }

        $parent_taxonomy = get_terms(
            array(
                $taxonomy
            ),
            array(
                'orderby'       => 'name',
                'order'         => 'ASC',
                'hide_empty'    => false,
                'parent' => 0
            )
        );

        if (!empty($parent_taxonomy)) {
                    
            foreach ($parent_taxonomy as $p_tax) {

                if ( in_array( $p_tax->term_id, $taxonomy_terms_ids ) ) {
                    echo '<option value="' . $p_tax->term_id . '" selected="selected">'. $p_tax->name . '</option>';
                } else {
                    echo '<option value="' . $p_tax->term_id . '">' . $p_tax->name . '</option>';
                }

                $get_child_tax = get_terms($taxonomy, array(
                    'hide_empty' => false,
                    'parent' => $p_tax->term_id
                ));

                if (!empty($get_child_tax)) {
                    foreach($get_child_tax as $child_tax) {
                        if ( in_array( $child_tax->term_id, $taxonomy_terms_ids ) ) {
                            echo '<option value="' . $child_tax->term_id . '" selected="selected"> - '. $child_tax->name . '</option>';
                        } else {
                            echo '<option value="' . $child_tax->term_id . '"> - ' . $child_tax->name . '</option>';
                        }
                    }
                }// end get_child_tax

            }// end foreach parent_taxonomy
        }

    }
}

if(!function_exists('houzez_taxonomy_hirarchical_options_for_search')){
    function houzez_taxonomy_hirarchical_options_for_search($taxonomy_name, $taxonomy_terms, $target_term_name, $prefix = " " ){
        if (!empty($taxonomy_terms)) {
            foreach ($taxonomy_terms as $term) {

                if( $taxonomy_name == 'property_area' ) {
                    $term_meta= get_option( "_houzez_property_area_$term->term_id");
                    $parent_city = sanitize_title($term_meta['parent_city']);

                    if ($target_term_name == $term->slug) {
                        echo '<option data-ref="' . urldecode($term->slug) . '" data-belong="'.urldecode($parent_city).'" value="' . urldecode($term->slug) . '" selected="selected">' . esc_attr($prefix) . esc_attr($term->name) . '</option>';
                    } else {
                        echo '<option data-ref="' . urldecode($term->slug) . '" data-belong="'.urldecode($parent_city).'" value="' . urldecode($term->slug) . '">' . esc_attr($prefix) . esc_attr($term->name) .'</option>';
                    }

                } elseif( $taxonomy_name == 'property_city' ) {
                    $term_meta= get_option( "_houzez_property_city_$term->term_id");
                    $parent_state = sanitize_title($term_meta['parent_state']);

                    if ($target_term_name == $term->slug) {
                        echo '<option data-ref="' . urldecode($term->slug) . '" data-belong="'.urldecode($parent_state).'" value="' . urldecode($term->slug) . '" selected="selected">' . esc_attr($prefix) . esc_attr($term->name) . '</option>';
                    } else {
                        echo '<option data-ref="' . urldecode($term->slug) . '" data-belong="'.urldecode($parent_state).'" value="' . urldecode($term->slug) . '">' . esc_attr($prefix) . esc_attr($term->name) .'</option>';
                    }

                }  elseif( $taxonomy_name == 'property_state' ) {
                    $term_meta= get_option( "_houzez_property_state_$term->term_id");
                    $parent_country = sanitize_title($term_meta['parent_country']);

                    if ($target_term_name == $term->slug) {
                        echo '<option data-ref="' . urldecode($term->slug) . '" data-belong="'.urldecode($parent_country).'" value="' . urldecode($term->slug) . '" selected="selected">' . esc_attr($prefix) . esc_attr($term->name) . '</option>';
                    } else {
                        echo '<option data-ref="' . urldecode($term->slug) . '" data-belong="'.urldecode($parent_country).'" value="' . urldecode($term->slug) . '">' . esc_attr($prefix) . esc_attr($term->name) .'</option>';
                    }

                } elseif( $taxonomy_name == 'property_country' ) {
            
                    if ($target_term_name == $term->slug) {
                        echo '<option data-ref="' . urldecode($term->slug) . '" value="' . urldecode($term->slug) . '" selected="selected">' . esc_attr($prefix) . esc_attr($term->name) . '</option>';
                    } else {
                        echo '<option data-ref="' . urldecode($term->slug) . '" value="' . urldecode($term->slug) . '">' . esc_attr($prefix) . esc_attr($term->name) .'</option>';
                    }

                } else {
                    if ($target_term_name == $term->slug) {
                        echo '<option value="' . urldecode($term->slug) . '" selected="selected">' . $prefix . $term->name . '</option>';
                    } else {
                        echo '<option value="' . urldecode($term->slug) . '">' . $prefix . $term->name . '</option>';
                    }
                }


                $child_terms = get_terms($taxonomy_name, array(
                    'hide_empty' => false,
                    'parent' => $term->term_id
                ));

                if (!empty($child_terms)) {
                    houzez_taxonomy_hirarchical_options_for_search( $taxonomy_name, $child_terms, $target_term_name, "- ".$prefix );
                }
            }
        }
    }
}

/*-----------------------------------------------------------------------------------*/
// Propert Edit Form Hierarchichal Taxonomy Options
/*-----------------------------------------------------------------------------------*/
if(!function_exists('houzez_taxonomy_edit_hirarchical_options_for_search')){
    function houzez_taxonomy_edit_hirarchical_options_for_search( $property_id, $taxonomy_name ){

        $existing_term_name = '';
        $taxonomy_terms = get_the_terms( $property_id, $taxonomy_name );

        if( !empty($taxonomy_terms) ){
            foreach( $taxonomy_terms as $tax_term ){
                $existing_term_name = $tax_term->slug;
                break;
            }
        }

        if( empty($existing_term_name) ){
            echo '<option value="" selected="selected">'.houzez_option('cl_none', 'None').'</option>';
        } else {
            echo '<option value="">'.houzez_option('cl_none', 'None').'</option>';
        }

        $parent_terms = get_terms(
            array(
                $taxonomy_name
            ),
            array(
                'orderby'       => 'name',
                'order'         => 'ASC',
                'hide_empty'    => false,
                'parent' => 0
            )
        );
        houzez_taxonomy_hirarchical_options_for_search( $taxonomy_name, $parent_terms, $existing_term_name );

    }
}

/* ------------------------------------------------------------------------------
/  Country list function
/ ------------------------------------------------------------------------------ */
if( !function_exists('houzez_country_list') ):
    function houzez_country_list($selected, $class='') {
        $countries = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique","Montenegro", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles","Serbia", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Zambia", "Zimbabwe");
        $country_select = '<select id="property_country"  name="property_country" class="'.$class.'">';

        foreach ($countries as $country) {
            $country_select.='<option value="' . $country . '"';
            if ($selected == $country) {
                $country_select.='selected="selected"';
            }
            $country_select.='>' . $country . '</option>';
        }

        $country_select.='</select>';
        return $country_select;
    }
endif; // end   houzez_country_list

/**
 *   ----------------------------------------------------------------------------------------------------------------------------------------------------
 *   Get excerpt with limit and read more on/off
 *   ----------------------------------------------------------------------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'houzez_clean_excerpt' ) ) {
    function houzez_clean_excerpt ($fave_characters, $fave_read_more = false) {
        global $post;
        $fave_excerpt_output = $post->post_excerpt;

        if ( $fave_excerpt_output == NULL ) {

            $fave_excerpt_output = get_the_content();
            $fave_excerpt_output = preg_replace(" (\[.*?\])",'',$fave_excerpt_output);
            $fave_excerpt_output = strip_shortcodes($fave_excerpt_output);
            $fave_excerpt_output = strip_tags($fave_excerpt_output);
            $fave_characters = intval($fave_characters);
            $fave_excerpt_output = substr( $fave_excerpt_output, 0, $fave_characters );
            $fave_excerpt_output = substr( $fave_excerpt_output, 0, strripos($fave_excerpt_output, " ") );
            $fave_excerpt_output = trim( preg_replace( '/\s+/', ' ', $fave_excerpt_output) );

            if ( $fave_read_more != "false" ) {
                $fave_excerpt_output = $fave_excerpt_output.'. <a class="continue-reading" href="'. get_permalink() .'">'.esc_html__( "Continue reading", "houzez").' <i class="fa fa-angle-double-right"></i></a>';
            } else {
                $fave_excerpt_output = $fave_excerpt_output . '...';
            }
        }

        return $fave_excerpt_output;
    }
}

/**
 *   ------------------------------------------------------------------------------------
 *   Generates a category tree
 *   ------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'houzez_get_category_id_array' ) ) {
    function houzez_get_category_id_array($add_all_category = true) {

        if (is_admin() === false) {
            return;
        }

        $categories = get_categories(array(
            'hide_empty' => 0
        ));

        $houzez_category_id_array_walker = new houzez_category_id_array_walker;
        $houzez_category_id_array_walker->walk($categories, 4);

        if ($add_all_category === true) {
            $categories_buffer['- All categories -'] = '';
            return array_merge(
                $categories_buffer,
                $houzez_category_id_array_walker->houzez_array_buffer
            );
        } else {
            return $houzez_category_id_array_walker->houzez_array_buffer;
        }
    }
}

class houzez_category_id_array_walker extends Walker {
    var $tree_type = 'category';
    var $db_fields = array ('parent' => 'parent', 'id' => 'term_id');

    var $houzez_array_buffer = array();

    function start_lvl( &$output, $depth = 0, $args = array() ) {
    }

    function end_lvl( &$output, $depth = 0, $args = array() ) {
    }


    function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
        $this->houzez_array_buffer[str_repeat(' - ', $depth) .  $category->name] = $category->term_id;
    }


    function end_el( &$output, $page, $depth = 0, $args = array() ) {
    }

}


/* --------------------------------------------------------------------------
 * Generate Unique ID each elemement
 ---------------------------------------------------------------------------*/
if ( !function_exists('houzez_unique_key') ) {

    function houzez_unique_key(){

        $key = uniqid();
        return $key;
    }
}

/* --------------------------------------------------------------------------
 * Walkscore API
 ---------------------------------------------------------------------------*/

if ( !function_exists('houzez_walkscore' ) ) {

    function houzez_walkscore($post_id) {
        $api_key = houzez_option( 'houzez_walkscore_api' );
        $property_location = get_post_meta( $post_id,'fave_property_map_address',true);

        if ( empty( $property_location ) ) {
            return;
        }

        echo '<div id="ws-walkscore-tile"></div>';
        $walkscore_data = "var ws_wsid    = '" . esc_html( $api_key ) . "';
                 var ws_address = '" . esc_html( $property_location ) . "';
                 var ws_format  = 'wide';
                 var ws_width   = '650';
                 var ws_width   = '100%';
                 var ws_height  = '400';";
        wp_enqueue_script( 'houzez-walkscore', 'https://www.walkscore.com/tile/show-walkscore-tile.php', array(), null, true );
        wp_add_inline_script( 'houzez-walkscore', $walkscore_data, 'before' );
    }
}

/* ------------------------------------------------------------------------------
/  Country Code to Country Name
/ ------------------------------------------------------------------------------ */
if( !function_exists('HOUZEZ_billing_period') ) {
    function HOUZEZ_billing_period($biling_period) {

        if ($biling_period == 'Day') {
            return esc_html__('day', 'houzez');
        } else if ($biling_period == 'Days') {
            return esc_html__('days', 'houzez');
        } else if ($biling_period == 'Week') {
            return esc_html__('week', 'houzez');
        } else if ($biling_period == 'Weeks') {
            return esc_html__('weeks', 'houzez');
        } else if ($biling_period == 'Month') {
            return esc_html__('month', 'houzez');
        } else if ($biling_period == 'Months') {
            return esc_html__('months', 'houzez');
        } else if ($biling_period == 'Year') {
            return esc_html__('year', 'houzez');
        } else if ($biling_period == 'Years') {
            return esc_html__('years', 'houzez');
        }
    }
}


/* ------------------------------------------------------------------------------
/  Country Code to Country Name
/ ------------------------------------------------------------------------------ */
if( !function_exists('houzez_country_code_to_country') ):
    function houzez_country_code_to_country( $code ){
        $country = '';
        if( $code == 'AF' ) $country = esc_html__('Afghanistan', 'houzez');
        if( $code == 'AX' ) $country = esc_html__('Aland Islands', 'houzez');
        if( $code == 'AL' ) $country = esc_html__('Albania', 'houzez');
        if( $code == 'DZ' ) $country = esc_html__('Algeria', 'houzez');
        if( $code == 'AS' ) $country = esc_html__('American Samoa', 'houzez');
        if( $code == 'AD' ) $country = esc_html__('Andorra', 'houzez');
        if( $code == 'AO' ) $country = esc_html__('Angola', 'houzez');
        if( $code == 'AI' ) $country = esc_html__('Anguilla', 'houzez');
        if( $code == 'AQ' ) $country = esc_html__('Antarctica', 'houzez');
        if( $code == 'AG' ) $country = esc_html__('Antigua and Barbuda', 'houzez');
        if( $code == 'AR' ) $country = esc_html__('Argentina', 'houzez');
        if( $code == 'AM' ) $country = esc_html__('Armenia', 'houzez');
        if( $code == 'AW' ) $country = esc_html__('Aruba', 'houzez');
        if( $code == 'AU' ) $country = esc_html__('Australia', 'houzez');
        if( $code == 'AT' ) $country = esc_html__('Austria', 'houzez');
        if( $code == 'AZ' ) $country = esc_html__('Azerbaijan', 'houzez');
        if( $code == 'BS' ) $country = esc_html__('Bahamas the', 'houzez');
        if( $code == 'BH' ) $country = esc_html__('Bahrain', 'houzez');
        if( $code == 'BD' ) $country = esc_html__('Bangladesh', 'houzez');
        if( $code == 'BB' ) $country = esc_html__('Barbados', 'houzez');
        if( $code == 'BY' ) $country = esc_html__('Belarus', 'houzez');
        if( $code == 'BE' ) $country = esc_html__('Belgium', 'houzez');
        if( $code == 'BZ' ) $country = esc_html__('Belize', 'houzez');
        if( $code == 'BJ' ) $country = esc_html__('Benin', 'houzez');
        if( $code == 'BM' ) $country = esc_html__('Bermuda', 'houzez');
        if( $code == 'BT' ) $country = esc_html__('Bhutan', 'houzez');
        if( $code == 'BO' ) $country = esc_html__('Bolivia', 'houzez');
        if( $code == 'BA' ) $country = esc_html__('Bosnia and Herzegovina', 'houzez');
        if( $code == 'BW' ) $country = esc_html__('Botswana', 'houzez');
        if( $code == 'BV' ) $country = esc_html__('Bouvet Island (Bouvetoya)', 'houzez');
        if( $code == 'BR' ) $country = esc_html__('Brazil', 'houzez');
        if( $code == 'IO' ) $country = esc_html__('British Indian Ocean Territory (Chagos Archipelago)', 'houzez');
        if( $code == 'VG' ) $country = esc_html__('British Virgin Islands', 'houzez');
        if( $code == 'BN' ) $country = esc_html__('Brunei Darussalam', 'houzez');
        if( $code == 'BG' ) $country = esc_html__('Bulgaria', 'houzez');
        if( $code == 'BF' ) $country = esc_html__('Burkina Faso', 'houzez');
        if( $code == 'BI' ) $country = esc_html__('Burundi', 'houzez');
        if( $code == 'KH' ) $country = esc_html__('Cambodia', 'houzez');
        if( $code == 'CM' ) $country = esc_html__('Cameroon', 'houzez');
        if( $code == 'CA' ) $country = esc_html__('Canada', 'houzez');
        if( $code == 'CV' ) $country = esc_html__('Cape Verde', 'houzez');
        if( $code == 'KY' ) $country = esc_html__('Cayman Islands', 'houzez');
        if( $code == 'CF' ) $country = esc_html__('Central African Republic', 'houzez');
        if( $code == 'TD' ) $country = esc_html__('Chad', 'houzez');
        if( $code == 'CL' ) $country = esc_html__('Chile', 'houzez');
        if( $code == 'CN' ) $country = esc_html__('China', 'houzez');
        if( $code == 'CX' ) $country = esc_html__('Christmas Island', 'houzez');
        if( $code == 'CC' ) $country = esc_html__('Cocos (Keeling) Islands', 'houzez');
        if( $code == 'CO' ) $country = esc_html__('Colombia', 'houzez');
        if( $code == 'KM' ) $country = esc_html__('Comoros the', 'houzez');
        if( $code == 'CD' ) $country = esc_html__('Congo', 'houzez');
        if( $code == 'CG' ) $country = esc_html__('Congo the', 'houzez');
        if( $code == 'CK' ) $country = esc_html__('Cook Islands', 'houzez');
        if( $code == 'CR' ) $country = esc_html__('Costa Rica', 'houzez');
        if( $code == 'CI' ) $country = esc_html__("Cote d'Ivoire", 'houzez');
        if( $code == 'HR' ) $country = esc_html__('Croatia', 'houzez');
        if( $code == 'CU' ) $country = esc_html__('Cuba', 'houzez');
        if( $code == 'CW' ) $country = esc_html__('Curaçao', 'houzez');
        if( $code == 'CY' ) $country = esc_html__('Cyprus', 'houzez');
        if( $code == 'CZ' ) $country = esc_html__('Czech Republic', 'houzez');
        if( $code == 'DK' ) $country = esc_html__('Denmark', 'houzez');
        if( $code == 'DJ' ) $country = esc_html__('Djibouti', 'houzez');
        if( $code == 'DM' ) $country = esc_html__('Dominica', 'houzez');
        if( $code == 'DO' ) $country = esc_html__('Dominican Republic', 'houzez');
        if( $code == 'EC' ) $country = esc_html__('Ecuador', 'houzez');
        if( $code == 'EG' ) $country = esc_html__('Egypt', 'houzez');
        if( $code == 'SV' ) $country = esc_html__('El Salvador', 'houzez');
        if( $code == 'GQ' ) $country = esc_html__('Equatorial Guinea', 'houzez');
        if( $code == 'ER' ) $country = esc_html__('Eritrea', 'houzez');
        if( $code == 'EE' ) $country = esc_html__('Estonia', 'houzez');
        if( $code == 'ET' ) $country = esc_html__('Ethiopia', 'houzez');
        if( $code == 'FO' ) $country = esc_html__('Faroe Islands', 'houzez');
        if( $code == 'FK' ) $country = esc_html__('Falkland Islands (Malvinas)', 'houzez');
        if( $code == 'FJ' ) $country = esc_html__('Fiji the Fiji Islands', 'houzez');
        if( $code == 'FI' ) $country = esc_html__('Finland', 'houzez');
        if( $code == 'FR' ) $country = esc_html__('France', 'houzez');
        if( $code == 'GF' ) $country = esc_html__('French Guiana', 'houzez');
        if( $code == 'PF' ) $country = esc_html__('French Polynesia', 'houzez');
        if( $code == 'TF' ) $country = esc_html__('French Southern Territories', 'houzez');
        if( $code == 'GA' ) $country = esc_html__('Gabon', 'houzez');
        if( $code == 'GM' ) $country = esc_html__('Gambia the', 'houzez');
        if( $code == 'GE' ) $country = esc_html__('Georgia', 'houzez');
        if( $code == 'DE' ) $country = esc_html__('Germany', 'houzez');
        if( $code == 'GH' ) $country = esc_html__('Ghana', 'houzez');
        if( $code == 'GI' ) $country = esc_html__('Gibraltar', 'houzez');
        if( $code == 'GR' ) $country = esc_html__('Greece', 'houzez');
        if( $code == 'GL' ) $country = esc_html__('Greenland', 'houzez');
        if( $code == 'GD' ) $country = esc_html__('Grenada', 'houzez');
        if( $code == 'GP' ) $country = esc_html__('Guadeloupe', 'houzez');
        if( $code == 'GU' ) $country = esc_html__('Guam', 'houzez');
        if( $code == 'GT' ) $country = esc_html__('Guatemala', 'houzez');
        if( $code == 'GG' ) $country = esc_html__('Guernsey', 'houzez');
        if( $code == 'GN' ) $country = esc_html__('Guinea', 'houzez');
        if( $code == 'GW' ) $country = esc_html__('Guinea-Bissau', 'houzez');
        if( $code == 'GY' ) $country = esc_html__('Guyana', 'houzez');
        if( $code == 'HT' ) $country = esc_html__('Haiti', 'houzez');
        if( $code == 'HM' ) $country = esc_html__('Heard Island and McDonald Islands', 'houzez');
        if( $code == 'VA' ) $country = esc_html__('Holy See (Vatican City State)', 'houzez');
        if( $code == 'HN' ) $country = esc_html__('Honduras', 'houzez');
        if( $code == 'HK' ) $country = esc_html__('Hong Kong', 'houzez');
        if( $code == 'HU' ) $country = esc_html__('Hungary', 'houzez');
        if( $code == 'IS' ) $country = esc_html__('Iceland', 'houzez');
        if( $code == 'IN' ) $country = esc_html__('India', 'houzez');
        if( $code == 'ID' ) $country = esc_html__('Indonesia', 'houzez');
        if( $code == 'IR' ) $country = esc_html__('Iran', 'houzez');
        if( $code == 'IQ' ) $country = esc_html__('Iraq', 'houzez');
        if( $code == 'IE' ) $country = esc_html__('Ireland', 'houzez');
        if( $code == 'IM' ) $country = esc_html__('Isle of Man', 'houzez');
        if( $code == 'IL' ) $country = esc_html__('Israel', 'houzez');
        if( $code == 'IT' ) $country = esc_html__('Italy', 'houzez');
        if( $code == 'JM' ) $country = esc_html__('Jamaica', 'houzez');
        if( $code == 'JP' ) $country = esc_html__('Japan', 'houzez');
        if( $code == 'JE' ) $country = esc_html__('Jersey', 'houzez');
        if( $code == 'JO' ) $country = esc_html__('Jordan', 'houzez');
        if( $code == 'KZ' ) $country = esc_html__('Kazakhstan', 'houzez');
        if( $code == 'KE' ) $country = esc_html__('Kenya', 'houzez');
        if( $code == 'KI' ) $country = esc_html__('Kiribati', 'houzez');
        if( $code == 'KP' ) $country = esc_html__('Korea', 'houzez');
        if( $code == 'KR' ) $country = esc_html__('Korea', 'houzez');
        if( $code == 'KW' ) $country = esc_html__('Kuwait', 'houzez');
        if( $code == 'KG' ) $country = esc_html__('Kyrgyz Republic', 'houzez');
        if( $code == 'LA' ) $country = esc_html__('Lao', 'houzez');
        if( $code == 'LV' ) $country = esc_html__('Latvia', 'houzez');
        if( $code == 'LB' ) $country = esc_html__('Lebanon', 'houzez');
        if( $code == 'LS' ) $country = esc_html__('Lesotho', 'houzez');
        if( $code == 'LR' ) $country = esc_html__('Liberia', 'houzez');
        if( $code == 'LY' ) $country = esc_html__('Libyan Arab Jamahiriya', 'houzez');
        if( $code == 'LI' ) $country = esc_html__('Liechtenstein', 'houzez');
        if( $code == 'LT' ) $country = esc_html__('Lithuania', 'houzez');
        if( $code == 'LU' ) $country = esc_html__('Luxembourg', 'houzez');
        if( $code == 'MO' ) $country = esc_html__('Macao', 'houzez');
        if( $code == 'MK' ) $country = esc_html__('Macedonia', 'houzez');
        if( $code == 'MG' ) $country = esc_html__('Madagascar', 'houzez');
        if( $code == 'MW' ) $country = esc_html__('Malawi', 'houzez');
        if( $code == 'MY' ) $country = esc_html__('Malaysia', 'houzez');
        if( $code == 'MV' ) $country = esc_html__('Maldives', 'houzez');
        if( $code == 'ML' ) $country = esc_html__('Mali', 'houzez');
        if( $code == 'MT' ) $country = esc_html__('Malta', 'houzez');
        if( $code == 'MH' ) $country = esc_html__('Marshall Islands', 'houzez');
        if( $code == 'MQ' ) $country = esc_html__('Martinique', 'houzez');
        if( $code == 'MR' ) $country = esc_html__('Mauritania', 'houzez');
        if( $code == 'MU' ) $country = esc_html__('Mauritius', 'houzez');
        if( $code == 'YT' ) $country = esc_html__('Mayotte', 'houzez');
        if( $code == 'MX' ) $country = esc_html__('Mexico', 'houzez');
        if( $code == 'FM' ) $country = esc_html__('Micronesia', 'houzez');
        if( $code == 'MD' ) $country = esc_html__('Moldova', 'houzez');
        if( $code == 'MC' ) $country = esc_html__('Monaco', 'houzez');
        if( $code == 'MN' ) $country = esc_html__('Mongolia', 'houzez');
        if( $code == 'ME' ) $country = esc_html__('Montenegro', 'houzez');
        if( $code == 'MS' ) $country = esc_html__('Montserrat', 'houzez');
        if( $code == 'MA' ) $country = esc_html__('Morocco', 'houzez');
        if( $code == 'MZ' ) $country = esc_html__('Mozambique', 'houzez');
        if( $code == 'MM' ) $country = esc_html__('Myanmar', 'houzez');
        if( $code == 'NA' ) $country = esc_html__('Namibia', 'houzez');
        if( $code == 'NR' ) $country = esc_html__('Nauru', 'houzez');
        if( $code == 'NP' ) $country = esc_html__('Nepal', 'houzez');
        if( $code == 'AN' ) $country = esc_html__('Netherlands Antilles', 'houzez');
        if( $code == 'NL' ) $country = esc_html__('Netherlands the', 'houzez');
        if( $code == 'NC' ) $country = esc_html__('New Caledonia', 'houzez');
        if( $code == 'NZ' ) $country = esc_html__('New Zealand', 'houzez');
        if( $code == 'NI' ) $country = esc_html__('Nicaragua', 'houzez');
        if( $code == 'NE' ) $country = esc_html__('Niger', 'houzez');
        if( $code == 'NG' ) $country = esc_html__('Nigeria', 'houzez');
        if( $code == 'NU' ) $country = esc_html__('Niue', 'houzez');
        if( $code == 'NF' ) $country = esc_html__('Norfolk Island', 'houzez');
        if( $code == 'MP' ) $country = esc_html__('Northern Mariana Islands', 'houzez');
        if( $code == 'NO' ) $country = esc_html__('Norway', 'houzez');
        if( $code == 'OM' ) $country = esc_html__('Oman', 'houzez');
        if( $code == 'PK' ) $country = esc_html__('Pakistan', 'houzez');
        if( $code == 'PW' ) $country = esc_html__('Palau', 'houzez');
        if( $code == 'PS' ) $country = esc_html__('Palestinian Territory', 'houzez');
        if( $code == 'PA' ) $country = esc_html__('Panama', 'houzez');
        if( $code == 'PG' ) $country = esc_html__('Papua New Guinea', 'houzez');
        if( $code == 'PY' ) $country = esc_html__('Paraguay', 'houzez');
        if( $code == 'PE' ) $country = esc_html__('Peru', 'houzez');
        if( $code == 'PH' ) $country = esc_html__('Philippines', 'houzez');
        if( $code == 'PN' ) $country = esc_html__('Pitcairn Islands', 'houzez');
        if( $code == 'PL' ) $country = esc_html__('Poland', 'houzez');
        if( $code == 'PT' ) $country = esc_html__('Portugal, Portuguese Republic', 'houzez');
        if( $code == 'PR' ) $country = esc_html__('Puerto Rico', 'houzez');
        if( $code == 'QA' ) $country = esc_html__('Qatar', 'houzez');
        if( $code == 'RE' ) $country = esc_html__('Reunion', 'houzez');
        if( $code == 'RO' ) $country = esc_html__('Romania', 'houzez');
        if( $code == 'RU' ) $country = esc_html__('Russian Federation', 'houzez');
        if( $code == 'RW' ) $country = esc_html__('Rwanda', 'houzez');
        if( $code == 'BL' ) $country = esc_html__('Saint Barthelemy', 'houzez');
        if( $code == 'SH' ) $country = esc_html__('Saint Helena', 'houzez');
        if( $code == 'KN' ) $country = esc_html__('Saint Kitts and Nevis', 'houzez');
        if( $code == 'LC' ) $country = esc_html__('Saint Lucia', 'houzez');
        if( $code == 'MF' ) $country = esc_html__('Saint Martin', 'houzez');
        if( $code == 'PM' ) $country = esc_html__('Saint Pierre and Miquelon', 'houzez');
        if( $code == 'VC' ) $country = esc_html__('Saint Vincent and the Grenadines', 'houzez');
        if( $code == 'WS' ) $country = esc_html__('Samoa', 'houzez');
        if( $code == 'SM' ) $country = esc_html__('San Marino', 'houzez');
        if( $code == 'ST' ) $country = esc_html__('Sao Tome and Principe', 'houzez');
        if( $code == 'SA' ) $country = esc_html__('Saudi Arabia', 'houzez');
        if( $code == 'SN' ) $country = esc_html__('Senegal', 'houzez');
        if( $code == 'RS' ) $country = esc_html__('Serbia', 'houzez');
        if( $code == 'SC' ) $country = esc_html__('Seychelles', 'houzez');
        if( $code == 'SL' ) $country = esc_html__('Sierra Leone', 'houzez');
        if( $code == 'SG' ) $country = esc_html__('Singapore', 'houzez');
        if( $code == 'SK' ) $country = esc_html__('Slovakia (Slovak Republic)', 'houzez');
        if( $code == 'SI' ) $country = esc_html__('Slovenia', 'houzez');
        if( $code == 'SB' ) $country = esc_html__('Solomon Islands', 'houzez');
        if( $code == 'SO' ) $country = esc_html__('Somalia, Somali Republic', 'houzez');
        if( $code == 'ZA' ) $country = esc_html__('South Africa', 'houzez');
        if( $code == 'GS' ) $country = esc_html__('South Georgia and the South Sandwich Islands', 'houzez');
        if( $code == 'ES' ) $country = esc_html__('Spain', 'houzez');
        if( $code == 'LK' ) $country = esc_html__('Sri Lanka', 'houzez');
        if( $code == 'SD' ) $country = esc_html__('Sudan', 'houzez');
        if( $code == 'SR' ) $country = esc_html__('Suriname', 'houzez');
        if( $code == 'SJ' ) $country = esc_html__('Svalbard & Jan Mayen Islands', 'houzez');
        if( $code == 'SZ' ) $country = esc_html__('Swaziland', 'houzez');
        if( $code == 'SE' ) $country = esc_html__('Sweden', 'houzez');
        if( $code == 'CH' ) $country = esc_html__('Switzerland', 'houzez');
        if( $code == 'SY' ) $country = esc_html__('Syrian Arab Republic', 'houzez');
        if( $code == 'TW' ) $country = esc_html__('Taiwan', 'houzez');
        if( $code == 'TJ' ) $country = esc_html__('Tajikistan', 'houzez');
        if( $code == 'TZ' ) $country = esc_html__('Tanzania', 'houzez');
        if( $code == 'TH' ) $country = esc_html__('Thailand', 'houzez');
        if( $code == 'TL' ) $country = esc_html__('Timor-Leste', 'houzez');
        if( $code == 'TG' ) $country = esc_html__('Togo', 'houzez');
        if( $code == 'TK' ) $country = esc_html__('Tokelau', 'houzez');
        if( $code == 'TO' ) $country = esc_html__('Tonga', 'houzez');
        if( $code == 'TT' ) $country = esc_html__('Trinidad and Tobago', 'houzez');
        if( $code == 'TN' ) $country = esc_html__('Tunisia', 'houzez');
        if( $code == 'TR' ) $country = esc_html__('Turkey', 'houzez');
        if( $code == 'TM' ) $country = esc_html__('Turkmenistan', 'houzez');
        if( $code == 'TC' ) $country = esc_html__('Turks and Caicos Islands', 'houzez');
        if( $code == 'TV' ) $country = esc_html__('Tuvalu', 'houzez');
        if( $code == 'UG' ) $country = esc_html__('Uganda', 'houzez');
        if( $code == 'UA' ) $country = esc_html__('Ukraine', 'houzez');
        if( $code == 'UAE' ) $country = esc_html__('United Arab Emirates', 'houzez');
        if( $code == 'GB' ) $country = esc_html__('United Kingdom', 'houzez');
        if( $code == 'US' ) $country = esc_html__('United States', 'houzez');
        if( $code == 'UM' ) $country = esc_html__('United States Minor Outlying Islands', 'houzez');
        if( $code == 'VI' ) $country = esc_html__('United States Virgin Islands', 'houzez');
        if( $code == 'UY' ) $country = esc_html__('Uruguay, Eastern Republic of', 'houzez');
        if( $code == 'UZ' ) $country = esc_html__('Uzbekistan', 'houzez');
        if( $code == 'VU' ) $country = esc_html__('Vanuatu', 'houzez');
        if( $code == 'VE' ) $country = esc_html__('Venezuela', 'houzez');
        if( $code == 'VN' ) $country = esc_html__('Vietnam', 'houzez');
        if( $code == 'WF' ) $country = esc_html__('Wallis and Futuna', 'houzez');
        if( $code == 'EH' ) $country = esc_html__('Western Sahara', 'houzez');
        if( $code == 'YE' ) $country = esc_html__('Yemen', 'houzez');
        if( $code == 'ZM' ) $country = esc_html__('Zambia', 'houzez');
        if( $code == 'ZW' ) $country = esc_html__('Zimbabwe', 'houzez');
        if( $country == '') $country = $code;
        return $country;
    }
endif;

if( !function_exists('houzez_countries_list') ) {
    function houzez_countries_list() {
        $Countries = array(
            'US' => esc_html__('United States', 'houzez'),
            'CA' => esc_html__('Canada', 'houzez'),
            'AU' => esc_html__('Australia', 'houzez'),
            'FR' => esc_html__('France', 'houzez'),
            'DE' => esc_html__('Germany', 'houzez'),
            'IS' => esc_html__('Iceland', 'houzez'),
            'IE' => esc_html__('Ireland', 'houzez'),
            'IT' => esc_html__('Italy', 'houzez'),
            'ES' => esc_html__('Spain', 'houzez'),
            'SE' => esc_html__('Sweden', 'houzez'),
            'AT' => esc_html__('Austria', 'houzez'),
            'BE' => esc_html__('Belgium', 'houzez'),
            'FI' => esc_html__('Finland', 'houzez'),
            'CZ' => esc_html__('Czech Republic', 'houzez'),
            'DK' => esc_html__('Denmark', 'houzez'),
            'NO' => esc_html__('Norway', 'houzez'),
            'GB' => esc_html__('United Kingdom', 'houzez'),
            'CH' => esc_html__('Switzerland', 'houzez'),
            'NZ' => esc_html__('New Zealand', 'houzez'),
            'RU' => esc_html__('Russian Federation', 'houzez'),
            'PT' => esc_html__('Portugal', 'houzez'),
            'NL' => esc_html__('Netherlands', 'houzez'),
            'IM' => esc_html__('Isle of Man', 'houzez'),
            'AF' => esc_html__('Afghanistan', 'houzez'),
            'AX' => esc_html__('Aland Islands ', 'houzez'),
            'AL' => esc_html__('Albania', 'houzez'),
            'DZ' => esc_html__('Algeria', 'houzez'),
            'AS' => esc_html__('American Samoa', 'houzez'),
            'AD' => esc_html__('Andorra', 'houzez'),
            'AO' => esc_html__('Angola', 'houzez'),
            'AI' => esc_html__('Anguilla', 'houzez'),
            'AQ' => esc_html__('Antarctica', 'houzez'),
            'AG' => esc_html__('Antigua and Barbuda', 'houzez'),
            'AR' => esc_html__('Argentina', 'houzez'),
            'AM' => esc_html__('Armenia', 'houzez'),
            'AW' => esc_html__('Aruba', 'houzez'),
            'AZ' => esc_html__('Azerbaijan', 'houzez'),
            'BS' => esc_html__('Bahamas', 'houzez'),
            'BH' => esc_html__('Bahrain', 'houzez'),
            'BD' => esc_html__('Bangladesh', 'houzez'),
            'BB' => esc_html__('Barbados', 'houzez'),
            'BY' => esc_html__('Belarus', 'houzez'),
            'BZ' => esc_html__('Belize', 'houzez'),
            'BJ' => esc_html__('Benin', 'houzez'),
            'BM' => esc_html__('Bermuda', 'houzez'),
            'BT' => esc_html__('Bhutan', 'houzez'),
            'BO' => esc_html__('Bolivia, Plurinational State of', 'houzez'),
            'BQ' => esc_html__('Bonaire, Sint Eustatius and Saba', 'houzez'),
            'BA' => esc_html__('Bosnia and Herzegovina', 'houzez'),
            'BW' => esc_html__('Botswana', 'houzez'),
            'BV' => esc_html__('Bouvet Island', 'houzez'),
            'BR' => esc_html__('Brazil', 'houzez'),
            'IO' => esc_html__('British Indian Ocean Territory', 'houzez'),
            'BN' => esc_html__('Brunei Darussalam', 'houzez'),
            'BG' => esc_html__('Bulgaria', 'houzez'),
            'BF' => esc_html__('Burkina Faso', 'houzez'),
            'BI' => esc_html__('Burundi', 'houzez'),
            'KH' => esc_html__('Cambodia', 'houzez'),
            'CM' => esc_html__('Cameroon', 'houzez'),
            'CV' => esc_html__('Cape Verde', 'houzez'),
            'KY' => esc_html__('Cayman Islands', 'houzez'),
            'CF' => esc_html__('Central African Republic', 'houzez'),
            'TD' => esc_html__('Chad', 'houzez'),
            'CL' => esc_html__('Chile', 'houzez'),
            'CN' => esc_html__('China', 'houzez'),
            'CX' => esc_html__('Christmas Island', 'houzez'),
            'CC' => esc_html__('Cocos (Keeling) Islands', 'houzez'),
            'CO' => esc_html__('Colombia', 'houzez'),
            'KM' => esc_html__('Comoros', 'houzez'),
            'CG' => esc_html__('Congo', 'houzez'),
            'CD' => esc_html__('Congo, the Democratic Republic of the', 'houzez'),
            'CK' => esc_html__('Cook Islands', 'houzez'),
            'CR' => esc_html__('Costa Rica', 'houzez'),
            'CI' => esc_html__("Cote d'Ivoire", 'houzez'),
            'HR' => esc_html__('Croatia', 'houzez'),
            'CU' => esc_html__('Cuba', 'houzez'),
            'CW' => esc_html__('Curaçao', 'houzez'),
            'CY' => esc_html__('Cyprus', 'houzez'),
            'DJ' => esc_html__('Djibouti', 'houzez'),
            'DM' => esc_html__('Dominica', 'houzez'),
            'DO' => esc_html__('Dominican Republic', 'houzez'),
            'EC' => esc_html__('Ecuador', 'houzez'),
            'EG' => esc_html__('Egypt', 'houzez'),
            'SV' => esc_html__('El Salvador', 'houzez'),
            'GQ' => esc_html__('Equatorial Guinea', 'houzez'),
            'ER' => esc_html__('Eritrea', 'houzez'),
            'EE' => esc_html__('Estonia', 'houzez'),
            'ET' => esc_html__('Ethiopia', 'houzez'),
            'FK' => esc_html__('Falkland Islands (Malvinas)', 'houzez'),
            'FO' => esc_html__('Faroe Islands', 'houzez'),
            'FJ' => esc_html__('Fiji', 'houzez'),
            'GF' => esc_html__('French Guiana', 'houzez'),
            'PF' => esc_html__('French Polynesia', 'houzez'),
            'TF' => esc_html__('French Southern Territories', 'houzez'),
            'GA' => esc_html__('Gabon', 'houzez'),
            'GM' => esc_html__('Gambia', 'houzez'),
            'GE' => esc_html__('Georgia', 'houzez'),
            'GH' => esc_html__('Ghana', 'houzez'),
            'GI' => esc_html__('Gibraltar', 'houzez'),
            'GR' => esc_html__('Greece', 'houzez'),
            'GL' => esc_html__('Greenland', 'houzez'),
            'GD' => esc_html__('Grenada', 'houzez'),
            'GP' => esc_html__('Guadeloupe', 'houzez'),
            'GU' => esc_html__('Guam', 'houzez'),
            'GT' => esc_html__('Guatemala', 'houzez'),
            'GG' => esc_html__('Guernsey', 'houzez'),
            'GN' => esc_html__('Guinea', 'houzez'),
            'GW' => esc_html__('Guinea-Bissau', 'houzez'),
            'GY' => esc_html__('Guyana', 'houzez'),
            'HT' => esc_html__('Haiti', 'houzez'),
            'HM' => esc_html__('Heard Island and McDonald Islands', 'houzez'),
            'VA' => esc_html__('Holy See (Vatican City State)', 'houzez'),
            'HN' => esc_html__('Honduras', 'houzez'),
            'HK' => esc_html__('Hong Kong', 'houzez'),
            'HU' => esc_html__('Hungary', 'houzez'),
            'IN' => esc_html__('India', 'houzez'),
            'ID' => esc_html__('Indonesia', 'houzez'),
            'IR' => esc_html__('Iran, Islamic Republic of', 'houzez'),
            'IQ' => esc_html__('Iraq', 'houzez'),
            'IL' => esc_html__('Israel', 'houzez'),
            'JM' => esc_html__('Jamaica', 'houzez'),
            'JP' => esc_html__('Japan', 'houzez'),
            'JE' => esc_html__('Jersey', 'houzez'),
            'JO' => esc_html__('Jordan', 'houzez'),
            'KZ' => esc_html__('Kazakhstan', 'houzez'),
            'KE' => esc_html__('Kenya', 'houzez'),
            'KI' => esc_html__('Kiribati', 'houzez'),
            'KP' => esc_html__('Korea, Democratic People\'s Republic of', 'houzez'),
            'KR' => esc_html__('Korea, Republic of', 'houzez'),
            'KV' => esc_html__('kosovo', 'houzez'),
            'KW' => esc_html__('Kuwait', 'houzez'),
            'KG' => esc_html__('Kyrgyzstan', 'houzez'),
            'LA' => esc_html__('Lao People\'s Democratic Republic', 'houzez'),
            'LV' => esc_html__('Latvia', 'houzez'),
            'LB' => esc_html__('Lebanon', 'houzez'),
            'LS' => esc_html__('Lesotho', 'houzez'),
            'LR' => esc_html__('Liberia', 'houzez'),
            'LY' => esc_html__('Libyan Arab Jamahiriya', 'houzez'),
            'LI' => esc_html__('Liechtenstein', 'houzez'),
            'LT' => esc_html__('Lithuania', 'houzez'),
            'LU' => esc_html__('Luxembourg', 'houzez'),
            'MO' => esc_html__('Macao', 'houzez'),
            'MK' => esc_html__('Macedonia', 'houzez'),
            'MG' => esc_html__('Madagascar', 'houzez'),
            'MW' => esc_html__('Malawi', 'houzez'),
            'MY' => esc_html__('Malaysia', 'houzez'),
            'MV' => esc_html__('Maldives', 'houzez'),
            'ML' => esc_html__('Mali', 'houzez'),
            'MT' => esc_html__('Malta', 'houzez'),
            'MH' => esc_html__('Marshall Islands', 'houzez'),
            'MQ' => esc_html__('Martinique', 'houzez'),
            'MR' => esc_html__('Mauritania', 'houzez'),
            'MU' => esc_html__('Mauritius', 'houzez'),
            'YT' => esc_html__('Mayotte', 'houzez'),
            'MX' => esc_html__('Mexico', 'houzez'),
            'FM' => esc_html__('Micronesia, Federated States of', 'houzez'),
            'MD' => esc_html__('Moldova, Republic of', 'houzez'),
            'MC' => esc_html__('Monaco', 'houzez'),
            'MN' => esc_html__('Mongolia', 'houzez'),
            'ME' => esc_html__('Montenegro', 'houzez'),
            'MS' => esc_html__('Montserrat', 'houzez'),
            'MA' => esc_html__('Morocco', 'houzez'),
            'MZ' => esc_html__('Mozambique', 'houzez'),
            'MM' => esc_html__('Myanmar', 'houzez'),
            'NA' => esc_html__('Namibia', 'houzez'),
            'NR' => esc_html__('Nauru', 'houzez'),
            'NP' => esc_html__('Nepal', 'houzez'),
            'NC' => esc_html__('New Caledonia', 'houzez'),
            'NI' => esc_html__('Nicaragua', 'houzez'),
            'NE' => esc_html__('Niger', 'houzez'),
            'NG' => esc_html__('Nigeria', 'houzez'),
            'NU' => esc_html__('Niue', 'houzez'),
            'NF' => esc_html__('Norfolk Island', 'houzez'),
            'MP' => esc_html__('Northern Mariana Islands', 'houzez'),
            'OM' => esc_html__('Oman', 'houzez'),
            'PK' => esc_html__('Pakistan', 'houzez'),
            'PW' => esc_html__('Palau', 'houzez'),
            'PS' => esc_html__('Palestinian Territory, Occupied', 'houzez'),
            'PA' => esc_html__('Panama', 'houzez'),
            'PG' => esc_html__('Papua New Guinea', 'houzez'),
            'PY' => esc_html__('Paraguay', 'houzez'),
            'PE' => esc_html__('Peru', 'houzez'),
            'PH' => esc_html__('Philippines', 'houzez'),
            'PN' => esc_html__('Pitcairn', 'houzez'),
            'PL' => esc_html__('Poland', 'houzez'),
            'PR' => esc_html__('Puerto Rico', 'houzez'),
            'QA' => esc_html__('Qatar', 'houzez'),
            'RE' => esc_html__('Reunion', 'houzez'),
            'RO' => esc_html__('Romania', 'houzez'),
            'RW' => esc_html__('Rwanda', 'houzez'),
            'BL' => esc_html__('Saint Barthélemy', 'houzez'),
            'SH' => esc_html__('Saint Helena', 'houzez'),
            'KN' => esc_html__('Saint Kitts and Nevis', 'houzez'),
            'LC' => esc_html__('Saint Lucia', 'houzez'),
            'MF' => esc_html__('Saint Martin (French part)', 'houzez'),
            'PM' => esc_html__('Saint Pierre and Miquelon', 'houzez'),
            'VC' => esc_html__('Saint Vincent and the Grenadines', 'houzez'),
            'WS' => esc_html__('Samoa', 'houzez'),
            'SM' => esc_html__('San Marino', 'houzez'),
            'ST' => esc_html__('Sao Tome and Principe', 'houzez'),
            'SA' => esc_html__('Saudi Arabia', 'houzez'),
            'SN' => esc_html__('Senegal', 'houzez'),
            'RS' => esc_html__('Serbia', 'houzez'),
            'SC' => esc_html__('Seychelles', 'houzez'),
            'SL' => esc_html__('Sierra Leone', 'houzez'),
            'SG' => esc_html__('Singapore', 'houzez'),
            'SX' => esc_html__('Sint Maarten (Dutch part)', 'houzez'),
            'SK' => esc_html__('Slovakia', 'houzez'),
            'SI' => esc_html__('Slovenia', 'houzez'),
            'SB' => esc_html__('Solomon Islands', 'houzez'),
            'SO' => esc_html__('Somalia', 'houzez'),
            'ZA' => esc_html__('South Africa', 'houzez'),
            'GS' => esc_html__('South Georgia and the South Sandwich Islands', 'houzez'),
            'LK' => esc_html__('Sri Lanka', 'houzez'),
            'SD' => esc_html__('Sudan', 'houzez'),
            'SR' => esc_html__('Suriname', 'houzez'),
            'SJ' => esc_html__('Svalbard and Jan Mayen', 'houzez'),
            'SZ' => esc_html__('Swaziland', 'houzez'),
            'SY' => esc_html__('Syrian Arab Republic', 'houzez'),
            'TW' => esc_html__('Taiwan, Province of China', 'houzez'),
            'TJ' => esc_html__('Tajikistan', 'houzez'),
            'TZ' => esc_html__('Tanzania, United Republic of', 'houzez'),
            'TH' => esc_html__('Thailand', 'houzez'),
            'TL' => esc_html__('Timor-Leste', 'houzez'),
            'TG' => esc_html__('Togo', 'houzez'),
            'TK' => esc_html__('Tokelau', 'houzez'),
            'TO' => esc_html__('Tonga', 'houzez'),
            'TT' => esc_html__('Trinidad and Tobago', 'houzez'),
            'TN' => esc_html__('Tunisia', 'houzez'),
            'TR' => esc_html__('Turkey', 'houzez'),
            'TM' => esc_html__('Turkmenistan', 'houzez'),
            'TC' => esc_html__('Turks and Caicos Islands', 'houzez'),
            'TV' => esc_html__('Tuvalu', 'houzez'),
            'UG' => esc_html__('Uganda', 'houzez'),
            'UA' => esc_html__('Ukraine', 'houzez'),
            'UAE' => esc_html__('United Arab Emirates', 'houzez'),
            'UM' => esc_html__('United States Minor Outlying Islands', 'houzez'),
            'UY' => esc_html__('Uruguay', 'houzez'),
            'UZ' => esc_html__('Uzbekistan', 'houzez'),
            'VU' => esc_html__('Vanuatu', 'houzez'),
            'VE' => esc_html__('Venezuela, Bolivarian Republic of', 'houzez'),
            'VN' => esc_html__('Viet Nam', 'houzez'),
            'VG' => esc_html__('Virgin Islands, British', 'houzez'),
            'VI' => esc_html__('Virgin Islands, U.S.', 'houzez'),
            'WF' => esc_html__('Wallis and Futuna', 'houzez'),
            'EH' => esc_html__('Western Sahara', 'houzez'),
            'YE' => esc_html__('Yemen', 'houzez'),
            'ZM' => esc_html__('Zambia', 'houzez'),
            'ZW' => esc_html__('Zimbabwe', 'houzez')
        );
        return $Countries;
    }
}

/* --------------------------------------------------------------------------
 * Breadcrumb from http://dimox.net/wordpress-breadcrumbs-without-a-plugin/
 ---------------------------------------------------------------------------*/
if ( ! function_exists( 'houzez_breadcrumbs' ) ) {
    function houzez_breadcrumbs($options = array())
    {

        global $post;
        $allowed_html_array = array(
            'i' => array(
                'class' => array()
            )
        );

        $text['home']     = esc_html__('Home', 'houzez'); // text for the 'Home' link
        $text['category'] = esc_html__('%s', 'houzez'); // text for a category page
        $text['tax']      = esc_html__('%s', 'houzez'); // text for a taxonomy page
        $text['search']   = esc_html__('Search Results for "%s" Query', 'houzez'); // text for a search results page
        $text['tag']      = esc_html__('%s', 'houzez'); // text for a tag page
        $text['author']   = esc_html__('%s', 'houzez'); // text for an author page
        $text['404']      = esc_html__('Error 404', 'houzez'); // text for the 404 page

        $defaults = array(
            'show_current' => 1, // 1 - show current post/page title in breadcrumbs, 0 - don't show
            'show_on_home' => 0, // 1 - show breadcrumbs on the homepage, 0 - don't show
            'delimiter' => '',
            'before' => '<li class="breadcrumb-item active">',
            'after' => '</li>',

            'home_before' => '',
            'home_after' => '',
            'home_link' => home_url() . '/',

            'link_before' => '<li class="breadcrumb-item">',
            'link_after'  => '</li>',
            'link_attr'   => '',
            'link_in_before' => '',
            'link_in_after'  => ''
        );

        extract($defaults);

        $link = '<a href="%1$s"><span>' . $link_in_before . '%2$s' . $link_in_after . '</span></a>';

        // form whole link option
        $link = $link_before . $link . $link_after;

        if (isset($options['text'])) {
            $options['text'] = array_merge($text, (array) $options['text']);
        }

        // override defaults
        extract($options);

        // regex replacement
        $replace = $link_before . '<a' . esc_attr( $link_attr ) . '\\1>' . $link_in_before . '\\2' . $link_in_after . '</a>' . $link_after;

        /*
         * Use bbPress's breadcrumbs when available
         */
        if (function_exists('bbp_breadcrumb') && is_bbpress()) {

            $bbp_crumbs =
                bbp_get_breadcrumb(array(
                    'home_text' => $text['home'],
                    'sep' => '',
                    'sep_before' => '',
                    'sep_after'  => '',
                    'pad_sep' => 0,
                    'before' => $home_before,
                    'after' => $home_after,
                    'current_before' => $before,
                    'current_after'  => $after,
                ));

            if ($bbp_crumbs) {
                echo '<ul class="breadcrumb favethemes_bbpress_breadcrumb">' .$bbp_crumbs. '</ul>';
                return;
            }
        }

        // normal breadcrumbs
        if ((is_home() || is_front_page())) {

            if ($show_on_home == 1) {
                echo '<li class="breadcrumb-item">'. esc_attr( $home_before ) . '<a href="' . esc_url( $home_link ) . '">' . esc_attr( $text['home'] ) . '</a>'. esc_attr( $home_after ) .'</li>';
            }

        } else {

            echo '<ol class="breadcrumb">' .$home_before . sprintf($link, $home_link, $text['home']) . $home_after . $delimiter;

            if (is_category() || is_tax())
            {
                $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );

                if( $term ) {

                    $taxonomy_object = get_taxonomy( get_query_var( 'taxonomy' ) );
                    //echo '<li><a>'.$taxonomy_object->rewrite['slug'].'</a></li>';

                    $parent = $term->parent;

                    while ($parent):
                        $parents[] = $parent;
                        $new_parent = get_term_by( 'id', $parent, get_query_var( 'taxonomy' ));
                        $parent = $new_parent->parent;
                    endwhile;
                    if(!empty($parents)):
                        $parents = array_reverse($parents);

                        // For each parent, create a breadcrumb item
                        foreach ($parents as $parent):
                            $item = get_term_by( 'id', $parent, get_query_var( 'taxonomy' ));

                            $term_link = get_term_link( $item );
                            if ( is_wp_error( $term_link ) ) {
                                continue;
                            }
                            echo '<li class="breadcrumb-item"><a href="'.$term_link.'">'.$item->name.'</a></li>';
                        endforeach;
                    endif;

                    // Display the current term in the breadcrumb
                    echo '<li class="breadcrumb-item">'.$term->name.'</li>';

                } else {

                    $the_cat = get_category(get_query_var('cat'), false);

                    // have parents?
                    if ($the_cat->parent != 0) {

                        $cats = get_category_parents($the_cat->parent, true, $delimiter);
                        $cats = preg_replace('#<a([^>]+)>([^<]+)</a>#', $replace, $cats);

                        echo $cats;
                    }

                    // print category
                    echo $before . sprintf((is_category() ? $text['category'] : $text['tax']), single_cat_title('', false)) . $after;
                } // end terms else

            }
            else if (is_search()) {

                echo $before . sprintf($text['search'], get_search_query()) . $after;

            }
            else if (is_day()) {

                echo  sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter
                    . sprintf($link, get_month_link(get_the_time('Y'),get_the_time('m')), get_the_time('F')) . $delimiter
                    . $before . get_the_time('d') . $after;

            }
            else if (is_month()) {

                echo  sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter
                    . $before . get_the_time('F') . $after;

            }
            else if (is_year()) {

                echo $before . get_the_time('Y') . $after;

            }
            // single post or page
            else if (is_single() && !is_attachment()) {

                // custom post type
                if (get_post_type() != 'post' && get_post_type() != 'property' ) {

                    $post_type = get_post_type_object(get_post_type());
                    
                    if ($show_current == 1) {
                        echo esc_attr($delimiter) . $before . get_the_title() . $after;
                    }
                }
                elseif( get_post_type() == 'property' ){

                    $single_prop_breadcrumb = houzez_option('single_prop_breadcrumb', 'property_type');

                    if( $single_prop_breadcrumb == 'property_city_area') {
                         $terms = get_the_terms( get_the_ID(), 'property_city' );
                         $terms_2 = get_the_terms( get_the_ID(), 'property_area' );

                    } else if( $single_prop_breadcrumb == 'property_status_type') {
                         $terms = get_the_terms( get_the_ID(), 'property_status' );
                         $terms_2 = get_the_terms( get_the_ID(), 'property_type' );

                    } else {
                        $terms = get_the_terms( get_the_ID(), $single_prop_breadcrumb );
                    }
                    
                    if( !empty($terms) ) {
                        foreach ($terms as $term) {
                            $term_link = get_term_link($term);
                            // If there was an error, continue to the next term.
                            if (is_wp_error($term_link)) {
                                continue;
                            }
                            echo '<li class="breadcrumb-item"><a href="' . esc_url($term_link) . '"> <span>' . esc_attr( $term->name ). '</span></a></li>';
                        }
                    }

                    if( !empty($terms_2) ) {
                        foreach ($terms_2 as $term) {
                            $term_link = get_term_link($term);
                            // If there was an error, continue to the next term.
                            if (is_wp_error($term_link)) {
                                continue;
                            }
                            echo '<li class="breadcrumb-item"><a href="' . esc_url($term_link) . '"> <span>' . esc_attr( $term->name ). '</span></a></li>';
                        }
                    }


                    if ($show_current == 1) {
                        echo esc_attr($delimiter) . $before . get_the_title() . $after;
                    }
                }
                else {

                    $cat = get_the_category();

                    if( !empty($cat) ) {
                        $cats = get_category_parents($cat[0], true, esc_attr($delimiter));

                        if ($show_current == 0) {
                            $cats = preg_replace("#^(.+)esc_attr($delimiter)$#", "$1", $cats);
                        }

                        $cats = preg_replace('#<a([^>]+)>([^<]+)</a>#', $replace, $cats);

                        echo $cats;
                    }

                    if ($show_current == 1) {
                        echo $before . get_the_title() . $after;
                    }
                } // end else

            }
            elseif (!is_single() && !is_page() && get_post_type() != 'post' && !is_404() && !is_author() ) {

                $post_type = get_post_type_object(get_post_type());

                echo $before . $post_type->labels->name . $after;

            }
            elseif (is_attachment()) {

                $parent = get_post($post->post_parent);
                $cat = current(get_the_category($parent->ID));
                $cats = get_category_parents($cat, true, esc_attr($delimiter));

                if (!is_wp_error($cats)) {
                    $cats = preg_replace('#<a([^>]+)>([^<]+)</a>#', $replace, $cats);
                    echo $cats;
                }

                printf($link, get_permalink($parent), $parent->post_title);

                if ($show_current == 1) {
                    echo esc_attr($delimiter) . $before . get_the_title() . $after;
                }

            }
            elseif (is_page() && !$post->post_parent && $show_current == 1) {

                echo $before . get_the_title() . $after;

            }
            elseif (is_page() && $post->post_parent) {

                $parent_id  = $post->post_parent;
                $breadcrumbs = array();

                while ($parent_id) {
                    $page = get_post($parent_id);
                    $breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
                    $parent_id  = $page->post_parent;
                }

                $breadcrumbs = array_reverse($breadcrumbs);

                for ($i = 0; $i < count($breadcrumbs); $i++) {

                    echo ( $breadcrumbs[$i] );

                    if ($i != count($breadcrumbs)-1) {
                        echo esc_attr($delimiter);
                    }
                }

                if ($show_current == 1) {
                    echo esc_attr($delimiter) . $before . get_the_title() . $after;
                }

            }
            elseif (is_tag()) {
                echo $before . sprintf($text['tag'], single_tag_title('', false)) . $after;

            }
            elseif (is_author()) {

                global $author;

                $userdata = get_userdata($author);
                echo $before . sprintf($text['author'], $userdata->display_name) . $after;

            }
            elseif (is_404()) {
                echo $before . esc_attr( $text['404'] ). $after;
            }

            // have pages?
            if (get_query_var('paged')) {

                if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author()) {
                    echo ' (' . esc_html__('Page', 'houzez') . ' ' . get_query_var('paged') . ')';
                }
            }

            echo '</ol>';
        }

    } // breadcrumbs()
}

if( !function_exists('countries_dropdown') ) {
    function countries_dropdown($country_searched = '' ) {
        global $wpdb;
        $sql_2 = $wpdb->prepare( "SELECT * from $wpdb->postmeta WHERE meta_key = '%s' GROUP BY meta_value ORDER BY meta_value ASC", 'fave_property_country');

        $countries = $wpdb->get_results( $sql_2, OBJECT_K );

        foreach( $countries as $con ) {
            if( !empty($con->meta_value) ) {
                if ($country_searched == $con->meta_value) {
                    echo '<option value="' . $con->meta_value . '" selected="selected">' . houzez_country_code_to_country($con->meta_value) . '</option>';
                } else {
                    echo '<option value="' . $con->meta_value . '">' . houzez_country_code_to_country($con->meta_value) . '</option>';
                }
            }
        }
    }
}

if( !function_exists('houzez_get_all_countries') ):
    function houzez_get_all_countries( $selected = '' ) {

        global $wpdb;
        $sql_2 = $wpdb->prepare( "SELECT * from $wpdb->postmeta WHERE meta_key = '%s' GROUP BY meta_value", 'fave_property_country');

        $countries = $wpdb->get_results( $sql_2, OBJECT_K );

        $select_country = '';

        foreach( $countries as $con ) {
            $select_country.= '<option value="' . $con->meta_value.'" ';
            if($con->meta_value == $selected){
                $select_country.= ' selected="selected" ';
            }
            $select_country.= ' >' . houzez_country_code_to_country( $con->meta_value ) . '</option>';
        }
        return $select_country;

    }
endif;

if( !function_exists('yelp_widget_curl') ) {
    function yelp_widget_curl($signed_url)
    {

        // Send Yelp API Call using WP's HTTP API
        $data = wp_remote_get($signed_url);

        //Use curl only if necessary
        if (empty($data['body'])) {

            $ch = curl_init($signed_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            $data = curl_exec($ch); // Yelp response
            curl_close($ch);
            $data = yelp_update_http_for_ssl($data);
            $response = json_decode($data);

        } else {
            $data = yelp_update_http_for_ssl($data);
            $response = json_decode($data['body']);
        }

        // Handle Yelp response data
        return $response;

    }
}

/**
 * Function update http for SSL
 *
 */
if( !function_exists('yelp_update_http_for_ssl') ) {
    function yelp_update_http_for_ssl($data)
    {

        if (!empty($data['body']) && is_ssl()) {
            $data['body'] = str_replace('http:', 'https:', $data['body']);
        } elseif (is_ssl()) {
            $data = str_replace('http:', 'https:', $data);
        }
        $data = str_replace('http:', 'https:', $data);

        return $data;
    }
}

/**
 *
 * Get author ID's by role
 * */
if( !function_exists('houzez_author_ids_by_role') ) {
    function houzez_author_ids_by_role($role) {
        $ids = get_users(array('role' => $role, 'fields' => 'ID'));
        return $ids;
    }
}

// Filter to fix the Post Author Dropdown
if( !function_exists('houzez_author_override')) {
    function houzez_author_override($output)
    {
        global $post, $user_ID;

        // return if this isn't the theme author override dropdown
        if (!preg_match('/post_author_override/', $output)) return $output;

        // return if we've already replaced the list (end recursion)
        if (preg_match('/post_author_override_replaced/', $output)) return $output;

        // replacement call to wp_dropdown_users
        $output = wp_dropdown_users(array(
            'echo' => 0,
            'name' => 'post_author_override_replaced',
            'selected' => empty($post->ID) ? $user_ID : $post->post_author,
            'include_selected' => true
        ));

        // put the original name back
        $output = preg_replace('/post_author_override_replaced/', 'post_author_override', $output);

        return $output;
    }
}
add_filter('wp_dropdown_users', 'houzez_author_override');


if( !function_exists('houzez_disable_redirect_canonical')) {
    function houzez_disable_redirect_canonical($redirect_url)
    {

        if (is_singular(array('houzez_agent', 'houzez_agency'))) {
            $redirect_url = false;
        }

        return $redirect_url;
    }

    add_filter('redirect_canonical', 'houzez_disable_redirect_canonical');
}

function hz_saved_search_term ($slugs, $taxonomy) {
    $temp_array = array();

    if(is_array($slugs) && !empty($slugs)) {
        foreach ($slugs as $slug) {
            $term = get_term_by('slug', $slug, $taxonomy);
            $temp_array[] = $term->name;
        }

        $result = join( ", ", $temp_array );
        return $result;
    }
    return '';
}

if( !function_exists('houzez_verify_purchase_key') ) {
    function houzez_verify_purchase_key($code_to_verify) {

        $houzez_item_id = 15752549;
        $error = new WP_Error();

        if ( empty( $code_to_verify ) ) {
            $error->add( 'error', esc_html__( 'Please enter an item purchase code.', 'houzez' ) );

            return $error;
        }

        $envato_token = 'n3UqTOU50S2rPm17mcPtGsh8nAv9fmU4';

        $apiurl  = "https://api.envato.com/v1/market/private/user/verify-purchase:" . esc_html( $code_to_verify ) . ".json";
        $header            = array();
        $header['headers'] = array( "Authorization" => "Bearer " . $envato_token );
        $request  = wp_safe_remote_request( $apiurl, $header );

        if ( ! is_wp_error( $request ) && is_string( $request['body'] ) ) {
            $response_body = json_decode( $request['body'], true );

            if ( isset( $response_body['verify-purchase'] ) ) {
                $purchase_array = (array) $response_body['verify-purchase']; 
            }

            if ( isset( $purchase_array['item_id'] ) && $houzez_item_id == $purchase_array['item_id'] ) {
                update_option( 'houzez_activation', 'activated' );
                update_option( 'houzez_purchase_code', sanitize_text_field( $code_to_verify ) );
                return true;
            } else {
                $error->add( 'error', esc_html__( 'Invalid purchase code, please provide valid purchase code!', 'houzez' ) );
                return $error;
            }


        } else {

            $error->add( 'error', esc_html__( 'There is problem with API connection, try again.', 'houzez' ) );
            return $error;
        }

        //return false;
    }
}


if (!function_exists('houzez_theme_registration')) {
    function houzez_theme_registration() {
        
        $error = '';
        $verification = false;
        $purchase_key = '';

        if( isset($_POST['item_purchase_code'])) { 
            $purchase_key = $_POST['item_purchase_code'];
            $purchase_data = houzez_verify_purchase_key( $purchase_key );

            if ( ! is_wp_error( $purchase_data ) && $purchase_data === true ) {
                $verification = true;
            } else {
                $error = $purchase_data->errors['error'][0];
            }

            if ( $verification ) {

                set_transient( 'houzez_verification_success', true, 5 );

                global $wp;
                if ( $wp->request ) {
                    $current_url = add_query_arg( $wp->query_string, '', home_url( $wp->request ) );;
                } else {
                    $current_url = admin_url();
                }

                $string = '<script type="text/javascript">';
                $string .= 'window.location = "' . esc_url( $current_url ) . '"';
                $string .= '</script>';

                echo wp_kses( $string, array(
                    'script' => array(
                        'type' => array()
                    )
                ) );
            }

        }

        if( ! get_transient('houzez_verification_success') ) {
        ?>
        <div class="houzez_theme_registration notice notice-info">
            <form method="post">
                <h3 class="activation_title">Houzez Purchase Verification</h3>
                <p>Enter purchase code to verify your purchase. This will allow you to <strong class="">install plugins</strong>, <strong class="">import demo</strong> and unlock all features</p>

                <input name="item_purchase_code" autocomplete="off" class="regular-text" type="text" placeholder="Enter item purchase code.">
                <?php echo wp_nonce_field( 'envato_api_nonce', 'envato_api_nonce_field' ,true, false ); ?>
                <input type="submit" name="submit" class="button button-primary" value="Verify"/>
                <p>
                    You can consult <a target="_blank" href="https://favethemes.zendesk.com/hc/en-us/articles/360038085112-Where-Is-My-Purchase-Code-"> this article</a> to learn how to get item purchase code or you can purchase <a href="https://themeforest.net/item/houzez-real-estate-wordpress-theme/15752549" target="_blank">new license</a> from themeforest which will include 6 months free support and lifetime updates.  
                </p>
                <?php
                if ( ! empty( $error ) ) {
                    echo '<p class="error">' . esc_html( $error ) . '</p>';
                }
                ?>
            </form>
        </div>
        <?php
        }
    }
    
    if( ! houzez_theme_verified() ) {
        add_action( 'admin_notices', 'houzez_theme_registration' );
    }
}


if( !function_exists('houzez_verification_success') ) {
    function houzez_verification_success() {
        ?>
        <div class="notice notice-success is-dismissible">
            <p>Thanks for verifying houzez purchase!</p>
        </div>
        <?php
        delete_transient( 'houzez_verification_success' );
    }

    if ( get_transient( 'houzez_verification_success' )  && houzez_theme_verified() ) {
        add_action( 'admin_notices', 'houzez_verification_success' );
    }
}


/**
 * Send webhook request for contact form and inquiry form
 *----------------------------------------------------*/
if ( ! function_exists( 'houzez_webhook_post_for_inquiry_contact_widget' ) ) {
    
    function houzez_webhook_post_for_inquiry_contact_widget( $webhook_url, array $formData, $formId = 'contact_form' ) {

        $webhook_url = esc_url($webhook_url);

        $exclude_form_fields = apply_filters( 'houzez_widget_webhook_exclude_form_fields',
            array( 
                'action',
                'form_id',
                'webhook',
                'webhook_url',
                'redirect_to',
                'email_to', 
                'email_subject',
                'email_to_cc',
                'email_to_bcc',
                'houzez_contact_form',
            ),
            $formId
        );

        $formData = array_merge( $formData, array( 'form_id' => $formId ) );

        if ( !empty( $formData ) && is_array( $formData ) ) {
            if ( !empty( $exclude_form_fields ) && is_array( $exclude_form_fields ) ) {
                foreach ( $exclude_form_fields as $field ) {
                    if ( isset( $formData[ $field ] ) ) {
                        unset( $formData[ $field ] );
                    }
                }
            }
        }

        
        if ( !empty( $formData ) && !empty( $webhook_url ) ) {
            $args = apply_filters( 'houzez_widget_webhook_post_args', array(
                'body'    => wp_json_encode( $formData ),
                'headers' => array(
                    'Content-Type' => 'application/json; charset=UTF-8',
                ),
            ) );

            wp_safe_remote_post( $webhook_url, $args );
        }
    }
}

/**
 * Send webhook request 
 *----------------------------------------------------*/
if ( ! function_exists( 'houzez_webhook_post' ) ) {
    
    function houzez_webhook_post( array $formData, $formId = 'property_agent_contact_form' ) {

        $webhook_url = houzez_option( 'houzez_webhook_url' );

        $exclude_form_fields = apply_filters( 'houzez_webhook_exclude_form_fields',
            array( 
                'action',
                'target_email',
                'property_nonce',
                'prop_payment',
                'property_agent_contact_security',
                'contact_realtor_ajax', 
                'is_listing_form',
                'submit',
                'agent_id',
                'agent_type',
                'realtor_page',
            ),
            $formId
        );

        $formData = array_merge( $formData, array( 'form_id' => $formId ) );

        if ( !empty( $formData ) && is_array( $formData ) ) {
            if ( !empty( $exclude_form_fields ) && is_array( $exclude_form_fields ) ) {
                foreach ( $exclude_form_fields as $field ) {
                    if ( isset( $formData[ $field ] ) ) {
                        unset( $formData[ $field ] );
                    }
                }
            }
        }

        
        if ( !empty( $formData ) && !empty( $webhook_url ) ) {
            $args = apply_filters( 'houzez_webhook_post_args', array(
                'body'    => wp_json_encode( $formData ),
                'headers' => array(
                    'Content-Type' => 'application/json; charset=UTF-8',
                ),
            ) );

            wp_safe_remote_post( $webhook_url, $args );
        }
    }
}


