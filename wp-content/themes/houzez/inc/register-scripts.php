<?php
/* ----------------------------------------------------------------------------
 * Enqueue styles.
 *----------------------------------------------------------------------------*/
if( !function_exists('houzez_enqueue_styles') ) {
    function houzez_enqueue_styles() {

        if ( ! is_admin() ) {

            $minify_css = houzez_option('minify_css');
            $css_minify_prefix = '';
            if ($minify_css != 0) {
                $css_minify_prefix = '.min';
            }


            /* Register Styles
             * ----------------------*/
            if( houzez_option('css_all_in_one', 1) ) {
                
                wp_enqueue_style('houzez-all-css', HOUZEZ_CSS_DIR_URI . 'all-css.css', array(), HOUZEZ_THEME_VERSION);
                wp_enqueue_style('font-awesome-5-all', HOUZEZ_CSS_DIR_URI . 'font-awesome/css/all.min.css', array(), '5.14.0', 'all');

            } else {
                wp_enqueue_style('bootstrap', HOUZEZ_CSS_DIR_URI . 'bootstrap.min.css', array(), '4.5.0');
                wp_enqueue_style('bootstrap-select', HOUZEZ_CSS_DIR_URI . 'bootstrap-select.min.css', array(), '1.13.18');
                wp_enqueue_style('font-awesome-5-all', HOUZEZ_CSS_DIR_URI . 'font-awesome/css/all.min.css', array(), '5.14.0', 'all');
                wp_enqueue_style('houzez-icons', HOUZEZ_CSS_DIR_URI . 'icons'.$css_minify_prefix.'.css', array(), HOUZEZ_THEME_VERSION);

                if ( is_singular('property') ) {
                    wp_enqueue_style('lightslider', HOUZEZ_CSS_DIR_URI . 'lightslider.css', array(), '1.1.3');
                }

                wp_enqueue_style('slick-min', HOUZEZ_CSS_DIR_URI . 'slick-min.css', array(), HOUZEZ_THEME_VERSION);
                wp_enqueue_style('slick-theme-min', HOUZEZ_CSS_DIR_URI . 'slick-theme-min.css', array(), HOUZEZ_THEME_VERSION);

                wp_enqueue_style('jquery-ui', HOUZEZ_CSS_DIR_URI . 'jquery-ui.min.css', array(), '1.12.1');
                wp_enqueue_style('radio-checkbox', HOUZEZ_CSS_DIR_URI . 'radio-checkbox-min.css', array(), HOUZEZ_THEME_VERSION);

                wp_enqueue_style('bootstrap-datepicker', HOUZEZ_CSS_DIR_URI . 'bootstrap-datepicker.min.css', array(), '1.8.0');

                wp_enqueue_style('houzez-main', HOUZEZ_CSS_DIR_URI . 'main'.$css_minify_prefix.'.css', array(), HOUZEZ_THEME_VERSION);
                wp_enqueue_style('houzez-styling-options', HOUZEZ_CSS_DIR_URI . 'styling-options'.$css_minify_prefix.'.css', array(), HOUZEZ_THEME_VERSION);
            }

            if ( is_page_template('template/user_dashboard_crm.php') ) {
                wp_enqueue_style('OverlayScrollbars', HOUZEZ_CSS_DIR_URI . 'OverlayScrollbars.min.css', array(), '1.8.0');
            }

            if (is_rtl()) {
                wp_enqueue_style('bootstrap-rtl', get_template_directory_uri() . '/css/bootstrap-rtl.min.css', array(), '4.4.1', 'all');
                wp_enqueue_style('houzez-rtl', get_template_directory_uri() . '/css/rtl' . $css_minify_prefix . '.css', array(), HOUZEZ_THEME_VERSION, 'all');
            }

            wp_enqueue_style('houzez-style', get_stylesheet_uri(), array(), HOUZEZ_THEME_VERSION, 'all');

        } //is_admin
    }
    add_action( 'wp_enqueue_scripts', 'houzez_enqueue_styles' );
}

/* ----------------------------------------------------------------------------
 * Enqueue scripts
 *----------------------------------------------------------------------------*/
if( !function_exists('houzez_enqueue_scripts') ) {
    function houzez_enqueue_scripts() {
        if ( ! is_admin() ) {
            global $post;
            $login_redirect = $houzez_date_language = $page_header_type = $woo_checkout_url = $agent_form_redirect = '';
            $userID = get_current_user_id();
            $houzez_local = houzez_get_localization();

            $page_id = isset($post->ID) ? $post->ID : '';

            if(!empty($page_id)) {
                $page_header_type = get_post_meta($page_id, 'fave_header_type', true); 
            }


            $protocol = is_ssl() ? 'https' : 'http';

            $houzez_logged_in = 'yes';
            if (!is_user_logged_in()) {
                $houzez_logged_in = 'no';
            }

            if (is_rtl()) {
                $houzez_rtl = "yes";
            } else {
                $houzez_rtl = "no";
            }

            $houzez_default_radius = houzez_option('houzez_default_radius');
            if (isset($_GET['radius'])) {
                $houzez_default_radius = $_GET['radius'];
            }

            $geo_country_limit = houzez_option('geo_country_limit');
            $geocomplete_country = '';
            if ($geo_country_limit != 0) {
                $geocomplete_country = houzez_option('geocomplete_country');
            }

            $after_login_redirect = houzez_option('login_redirect');
            if ($after_login_redirect == 'same_page') {

                if (is_tax()) {
                    $login_redirect = get_term_link(get_query_var('term'), get_query_var('taxonomy'));
                } else {
                    if (is_home() || is_front_page()) {
                        $login_redirect = site_url();
                    } else {
                        if (!is_404() && !is_search() && !is_author()) {
                            $login_redirect = get_permalink($post->ID);
                        }
                    }
                }

            } else {
                $login_redirect = houzez_option('login_redirect_link');
            }

            if (is_singular('post') && comments_open() && get_option('thread_comments')) {
                wp_enqueue_script('comment-reply');
            }

        
            if( houzez_option('js_all_in_one', 1) ) {

                wp_enqueue_script('houzez-all-in-one', HOUZEZ_JS_DIR_URI. 'vendors/all-scripts.js', array('jquery'), HOUZEZ_THEME_VERSION, true);

            } else {

                wp_enqueue_script('bootstrap', HOUZEZ_JS_DIR_URI. 'vendors/bootstrap.bundle.min.js', array('jquery'), '4.5.0', true);

                wp_enqueue_script('bootstrap-select', HOUZEZ_JS_DIR_URI. 'vendors/bootstrap-select.min.js', array('jquery'), '1.13.18', true);
                wp_enqueue_script('modernizr', HOUZEZ_JS_DIR_URI. 'vendors/modernizr.custom.js', array('jquery'), '3.2.0', true);
            
                wp_enqueue_script('slideout', HOUZEZ_JS_DIR_URI. 'vendors/slideout.min.js', array('jquery'), HOUZEZ_THEME_VERSION, true);
                wp_enqueue_script('lightbox', HOUZEZ_JS_DIR_URI. 'vendors/lightbox.min.js', array('jquery'), HOUZEZ_THEME_VERSION, true);
                wp_enqueue_script('theia-sticky-sidebar', HOUZEZ_JS_DIR_URI. 'vendors/theia-sticky-sidebar.min.js', array('jquery'), HOUZEZ_THEME_VERSION, true);

                wp_enqueue_script('slick', HOUZEZ_JS_DIR_URI. 'vendors/slick.min.js', array('jquery'), HOUZEZ_THEME_VERSION, true);
            }

            if( houzez_option('preload_pages', 1) ) {
                wp_enqueue_script('houzez-instant-page', HOUZEZ_JS_DIR_URI. 'houzez-instant-page.js', array(), '3.0.0', true);
            }

            wp_register_script('chart', HOUZEZ_JS_DIR_URI. 'vendors/Chart.min.js', array('jquery'), '2.8.0', true);

            if ( is_singular('property') ) {
                wp_register_script('lightslider', HOUZEZ_JS_DIR_URI. 'vendors/lightslider.min.js', array('jquery'), '1.1.3', true);
                wp_enqueue_script('lightslider');
                wp_enqueue_script('chart');
            }

            if( houzez_get_map_system() == 'osm' ) {
                wp_enqueue_script( 'jquery-ui-autocomplete' );  // Use in osm-properties.js
            }

            if( houzez_load_ui_slider() ) {
                wp_enqueue_script( 'jquery-ui-slider' );
            }

            if( wp_is_mobile() ) {
                wp_enqueue_script( 'jquery-touch-punch' );
            }


            if( $page_header_type == 'video' || houzez_option('backgroud_type') == 'video' ) {
                wp_enqueue_script('vide', HOUZEZ_JS_DIR_URI. 'vendors/jquery.vide.min.js', array('jquery'), '0.5.1', true);
            }

            if( $page_header_type == 'static_image' || is_page_template('template/properties-parallax.php') || is_page_template('template/template-splash.php') ) {
                wp_enqueue_script('parallax-background', HOUZEZ_JS_DIR_URI. 'vendors/parallax-background.min.js', array('jquery'), '1.2', true);
            }

            if ( is_page_template('template/user_dashboard_crm.php') 
                || is_page_template('template/user_dashboard_insight.php') 
                || is_singular('houzez_agent')
                || is_singular('houzez_agency')
                || is_author()
            ) {
                wp_enqueue_script('chart');
                wp_enqueue_script('overlayScrollbars', HOUZEZ_JS_DIR_URI. 'vendors/jquery.overlayScrollbars.min.js', array('jquery'), '1.8.0', true);
            }

            if ( is_page_template('template/user_dashboard_crm.php') 
                || is_page_template('template/user_dashboard_invoices.php') 
                || is_singular('property')
            ) {
                
            }
            
            if ( is_page_template('template/blog-masonry.php') ) {
                wp_enqueue_script('imagesloaded', HOUZEZ_JS_DIR_URI. 'vendors/imagesloaded.pkgd.min.js', array('jquery'), '4.1.1', true);
            }

            if ( is_page_template('template/user_dashboard_submit.php') ) {
                wp_enqueue_script('validate', HOUZEZ_JS_DIR_URI . 'vendors/jquery.validate.min.js', array('jquery'), '1.19.0', true);
            }

            if (is_singular('property') || houzez_is_dashboard() ) {

                wp_enqueue_script('bootstrap-datepicker', HOUZEZ_JS_DIR_URI. 'vendors/bootstrap-datepicker.min.js', array('jquery'), '1.9.0', true);

                $agent_form_redirect = houzez_option('agent_form_redirect', '');

                if( !empty($agent_form_redirect) ) {
                    $agent_form_redirect = get_permalink($agent_form_redirect);
                }


                $houzez_date_language = houzez_option('houzez_date_language');
                $houzez_date_language = esc_html($houzez_date_language);

                if ($houzez_date_language != 'xx' && !empty($houzez_date_language)) {
                    $handle = "bootstrap-datepicker." . $houzez_date_language;
                    $name = "bootstrap-datepicker." . $houzez_date_language . ".min.js";
                    wp_enqueue_script($handle, HOUZEZ_JS_DIR_URI . 'vendors/locales/' . $name, array('jquery'), '1.0', true);
                }

                if (function_exists('icl_translate')) {
                    if (ICL_LANGUAGE_CODE != 'en') {
                        $handle = "bootstrap-datepicker." . ICL_LANGUAGE_CODE;
                        $name = "bootstrap-datepicker." . ICL_LANGUAGE_CODE . ".min.js";
                        wp_enqueue_script($handle, HOUZEZ_JS_DIR_URI . 'vendors/locales/' . $name, array('jquery'), '1.0', true);
                    }
                    $houzez_date_language = ICL_LANGUAGE_CODE;
                }
            }

            if ( class_exists( 'WooCommerce' ) ) {
                $woo_checkout_url = wc_get_checkout_url();
            } 

            $search_min_price = houzez_option('advanced_search_widget_min_price', 0);
            $search_min_price_range_for_rent = houzez_option('advanced_search_min_price_range_for_rent', 0);

            $search_max_price = houzez_option('advanced_search_widget_max_price', 2500000);
            $search_max_price_range_for_rent = houzez_option('advanced_search_max_price_range_for_rent', 12000);

            /*if( isset($_GET['min-price']) && $_GET['min-price'] != '' ) {
                $search_min_price = $_GET['min-price'];
                $search_min_price_range_for_rent = $_GET['min-price'];
            }

            if( isset($_GET['max-price']) && $_GET['max-price'] != '' ) {
                $search_max_price = $_GET['max-price'];
                $search_max_price_range_for_rent = $_GET['max-price'];
            }*/

            if ( class_exists( 'FCC_Rates' ) && houzez_currency_switcher_enabled() && isset( $_COOKIE[ "houzez_set_current_currency" ] ) ) {

                $currency_data = Fcc_get_currency($_COOKIE['houzez_set_current_currency']);
                $currency_position = $currency_data['position'];
                $currency_symbol = $currency_data['symbol'];
                $thousands_separator = $currency_data['thousands_sep'];

                if( function_exists('houzez_get_plain_price') ) {
                    $search_min_price = houzez_get_plain_price($search_min_price);
                    $search_max_price = houzez_get_plain_price($search_max_price);
                    $search_min_price_range_for_rent = houzez_get_plain_price($search_min_price_range_for_rent);
                    $search_max_price_range_for_rent = houzez_get_plain_price($search_max_price_range_for_rent);
                }
                

            } else {
                $currency_position   = houzez_option('currency_position', 'before');
                $currency_symbol     = houzez_option('currency_symbol', '$');
                $thousands_separator = houzez_option('thousands_separator', ',');

                if( is_singular('property') ) {
                    $s_currency_maker = currency_maker();
                    $currency_symbol = $s_currency_maker['currency'];
                    $currency_position = $s_currency_maker['currency_position'];
                    $thousands_separator = $s_currency_maker['thousands_separator'];
                }
            }

            wp_enqueue_script('houzez-custom', get_theme_file_uri( '/js/custom' . houzez_minify_js() . '.js' ), array('jquery'), HOUZEZ_THEME_VERSION, true);

            wp_localize_script('houzez-custom', 'houzez_vars',
            array(
                'admin_url' => get_admin_url(),
                'houzez_rtl' => $houzez_rtl,
                'user_id' => $userID,
                'redirect_type' => $after_login_redirect,
                'login_redirect' => $login_redirect,
                'wp_is_mobile' => wp_is_mobile(),
                'default_lat' => houzez_option('map_default_lat', 25.686540),
                'default_long' => houzez_option('map_default_long', -80.431345),
                'houzez_is_splash' => houzez_is_splash(),
                'prop_detail_nav' => houzez_option('prop-detail-nav', 'no'),
                'is_singular_property' => is_singular('property'),
                'search_position' => houzez_get_header_search_position(),
                'login_loading' => esc_html__('Sending user info, please wait...', 'houzez'),
                'not_found' => esc_html__("We didn't find any results", 'houzez'),
                'houzez_map_system' => houzez_get_map_system(),
                'for_rent' => houzez_get_term_slug(houzez_option('search_rent_status'), 'property_status'),
                'for_rent_price_slider' => houzez_get_term_slug(houzez_option('search_rent_status_for_price_range'), 'property_status'),
                'search_min_price_range' => $search_min_price,
                'search_max_price_range' => $search_max_price,
                'search_min_price_range_for_rent' => $search_min_price_range_for_rent,
                'search_max_price_range_for_rent' => $search_max_price_range_for_rent,
                'get_min_price' => isset($_GET['min-price']) ? $_GET['min-price'] : 0,
                'get_max_price' => isset($_GET['max-price']) ? $_GET['max-price'] : 0,
                'currency_position' => $currency_position,
                'currency_symbol' => $currency_symbol,
                'decimals' => houzez_option('decimals', '2'),
                'decimal_point_separator' => houzez_option('decimal_point_separator', '.'),
                'thousands_separator' => $thousands_separator,
                'is_halfmap' => houzez_is_half_map(),
                'houzez_date_language' => $houzez_date_language,
                'houzez_default_radius' => $houzez_default_radius,
                'houzez_reCaptcha' => houzez_show_google_reCaptcha(),
                'geo_country_limit' => $geo_country_limit,
                'geocomplete_country' => $geocomplete_country,
                'is_edit_property' => houzez_edit_property(),
                'processing_text' => esc_html__('Processing, Please wait...', 'houzez'),
                'halfmap_layout' => houzez_half_map_layout(),
                'prev_text' => esc_html__('Prev', 'houzez'),
                'next_text' => esc_html__('Next', 'houzez'),
                'keyword_search_field' => houzez_option('keyword_field'),
                'keyword_autocomplete' => houzez_option('keyword_autocomplete', 0),
                'autosearch_text' => esc_html__('Searching...', 'houzez'),
                'paypal_connecting' => esc_html__('Connecting to paypal, Please wait... ', 'houzez'),
                'transparent_logo' => houzez_is_transparent_logo(),
                'is_transparent' => houzez_is_transparent(),
                'is_top_header' => houzez_option('top_bar', 0),
                'simple_logo' => houzez_option('custom_logo', '', 'url'),
                'retina_logo' => houzez_option('retina_logo', '', 'url'),
                'mobile_logo' => houzez_option('mobile_logo', '', 'url'),
                'retina_logo_mobile' => houzez_option('mobile_retina_logo', '', 'url'),
                'retina_logo_mobile_splash' => houzez_option('retina_logo_mobile_splash', '', 'url'),
                'custom_logo_splash' => houzez_option('custom_logo_splash', '', 'url'),
                'retina_logo_splash' => houzez_option('retina_logo_splash', '', 'url'),
                'monthly_payment' => esc_html__('Monthly Payment', 'houzez'),
                'weekly_payment' => esc_html__('Weekly Payment', 'houzez'),
                'bi_weekly_payment' => esc_html__('Bi-Weekly Payment', 'houzez'),
                'compare_url' => houzez_get_template_link_2('template/template-compare.php'),
                'template_thankyou' => houzez_get_template_link('template/template-thankyou.php'),
                'compare_page_not_found' => esc_html__('Please create page using compare properties template', 'houzez'),
                'compare_limit' => esc_html__('Maximum item compare are 4', 'houzez'),
                'compare_add_icon' => '',
                'compare_remove_icon' => '',
                'add_compare_text' => houzez_option('cl_add_compare', 'Add to Compare'),
                'remove_compare_text' => houzez_option('cl_remove_compare', 'Remove from Compare'),
                'is_mapbox' => houzez_option('houzez_map_system'),
                'api_mapbox' => houzez_option('mapbox_api_key'),
                'is_marker_cluster' => houzez_option('map_cluster_enable'),
                'g_recaptha_version' => houzez_option( 'recaptha_type', 'v2' ),
                's_country' => isset($_GET['country']) ? $_GET['country'] : '',
                's_state' => isset($_GET['states']) ? $_GET['states'] : '',
                's_city' => isset($_GET['location']) ? $_GET['location'] : '',
                's_areas' => isset($_GET['areas']) ? $_GET['areas'] : '',
                'woo_checkout_url' => esc_url($woo_checkout_url),
                'agent_redirection' => $agent_form_redirect,
            )
        ); // end ajax calls

        
        if(houzez_is_dashboard()) {    

            if( houzez_option('enable_paid_submission') == 'membership') {
                $user_package_id = houzez_get_user_package_id($userID);
                $package_images = get_post_meta( $user_package_id, 'fave_package_images', true );
                $package_unlimited_images = get_post_meta( $user_package_id, 'fave_unlimited_images', true );
                if( $package_unlimited_images != 1 && !empty($package_images)) {
                    $max_prop_images = $package_images;
                } else {
                    $max_prop_images = houzez_option('max_prop_images', '50');
                }
            } else {
                $max_prop_images = houzez_option('max_prop_images', '50');
            }

            wp_enqueue_script('bootbox-min', HOUZEZ_JS_DIR_URI . 'vendors/bootbox.min.js', array('jquery'), '4.4.0', true);

            wp_enqueue_script('houzez_property',  get_theme_file_uri('/js/houzez_property.js'), array('jquery', 'plupload', 'jquery-ui-sortable'), HOUZEZ_THEME_VERSION, true);
            $prop_data = array(
                'ajaxURL' => admin_url('admin-ajax.php'),
                'verify_nonce' => wp_create_nonce('verify_gallery_nonce'),
                'verify_file_type' => esc_html__('Valid file formats', 'houzez'),
                'houzez_logged_in' => $houzez_logged_in,
                'msg_digits' => esc_html__('Please enter only digits', 'houzez'),
                'max_prop_images' => $max_prop_images,
                'image_max_file_size' => houzez_option('image_max_file_size'),
                'max_prop_attachments' => houzez_option('max_prop_attachments', '3'),
                'attachment_max_file_size' => houzez_option('attachment_max_file_size', '12000kb'),
                'plan_title_text' => houzez_option('cl_plan_title', 'Plan Title' ),
                'plan_size_text' => houzez_option('cl_plan_size', 'Plan Size' ),
                'plan_bedrooms_text' => houzez_option('cl_plan_bedrooms', 'Bedrooms' ),
                'plan_bathrooms_text' => houzez_option('cl_plan_bathrooms', 'Bathrooms' ),
                'plan_price_text' => houzez_option('cl_plan_price', 'Price' ),
                'plan_price_postfix_text' => houzez_option('cl_plan_price_postfix', 'Price Postfix' ),
                'plan_image_text' => houzez_option('cl_plan_img', 'Plan Image' ),
                'plan_description_text' => houzez_option('cl_plan_des', 'Description'),
                'plan_upload_text' => houzez_option('cl_plan_img_btn', 'Select Image'),
                'plan_upload_size' => houzez_option('cl_plan_img_size', 'Minimum size 800 x 600 px'),

                'mu_title_text' => houzez_option('cl_subl_title', 'Title' ),
                'mu_type_text' => houzez_option('cl_subl_type', 'Property Type' ),
                'mu_beds_text' => houzez_option('cl_subl_bedrooms', 'Bedrooms' ),
                'mu_baths_text' => houzez_option('cl_subl_bathrooms', 'Bathrooms' ),
                'mu_size_text' => houzez_option('cl_subl_size', 'Property Size' ),
                'mu_size_postfix_text' => houzez_option('cl_subl_size_postfix', 'Size Postfix' ),
                'mu_price_text' => houzez_option('cl_subl_price', 'Price' ),
                'mu_price_postfix_text' => houzez_option('cl_subl_price_postfix', 'Price Postfix' ),
                'mu_availability_text' => houzez_option('cl_subl_date', 'Availability Date' ),

                'are_you_sure_text' => esc_html__('Are you sure you want to do this?', 'houzez'),
                'delete_btn_text' => esc_html__('Delete', 'houzez'),
                'cancel_btn_text' => esc_html__('Cancel', 'houzez'),
                'confirm_btn_text' => esc_html__('Confirm', 'houzez'),
                'processing_text' => esc_html__('Processing, Please wait...', 'houzez'),
                'add_listing_msg' => esc_html__('Submitting, Please wait...', 'houzez'),
                'confirm_featured' => esc_html__('Are you sure you want to make this a listing featured?', 'houzez'),
                'confirm_featured_remove' => esc_html__('Are you sure you want to remove this listing from featured?', 'houzez'),
                'confirm_relist' => esc_html__('Are you sure you want to relist this property?', 'houzez'),
                'delete_confirmation' => esc_html__('Are you sure you want to delete?', 'houzez'),
                'featured_listings_none' => esc_html__('You have used all the "Featured" listings in your package.', 'houzez'),
                'prop_sent_for_approval' => esc_html__('Sent for Approval', 'houzez'),
                'is_edit_property' => houzez_edit_property(),
                'is_mapbox' => houzez_option('houzez_map_system'),
                'api_mapbox' => houzez_option('mapbox_api_key'),
                'enable_title_limit' => houzez_option('enable_title_limit', 0),
                'property_title_limit' => houzez_option('property_title_limit'),
            );
            wp_localize_script('houzez_property', 'houzezProperty', $prop_data);

            // Edit profile template
            if (is_page_template('template/user_dashboard_profile.php') || is_page_template('template/user_dashboard_gdpr.php') || is_page_template('template/user_dashboard_membership.php')) {
                
                if(!wp_script_is('plupload')) {
                    wp_enqueue_script('plupload');
                }

                wp_register_script('houzez_user_profile',  get_theme_file_uri('/js/houzez_user_profile.js'), array('jquery', 'plupload'), HOUZEZ_THEME_VERSION, true);
                $user_profile_data = array(
                    'ajaxURL' => admin_url('admin-ajax.php'),
                    'user_id' => $userID,
                    'houzez_upload_nonce' => wp_create_nonce('houzez_upload_nonce'),
                    'verify_file_type' => esc_html__('Valid file formats', 'houzez'),
                    'houzez_site_url' => home_url(),
                    'gdpr_agree_text' => esc_html__('Please Agree GDPR', 'houzez'),
                );
                wp_localize_script('houzez_user_profile', 'houzezUserProfile', $user_profile_data);
                wp_enqueue_script('houzez_user_profile');
            } // end edit profile

        } // End Houzez_is_dashboard


        //enqueue google reCaptcha
        if ( houzez_show_google_reCaptcha() ) {

            $recaptha_type = houzez_option( 'recaptha_type', 'v2' );

            if ( 'v3' === $recaptha_type ) {
                $render = houzez_option( 'recaptha_site_key' );
            } else {
                $render = 'explicit';
            }

            $recaptcha_src = esc_url_raw( add_query_arg( array(
                'render' => $render,
                'onload' => 'houzezReCaptchaLoad',
            ), '//www.google.com/recaptcha/api.js' ) );

            wp_enqueue_script(
                'houzez-google-recaptcha',
                $recaptcha_src,
                array(),
                HOUZEZ_THEME_VERSION,
                true
            );
        }

        //enqueue maps scripts
        if(houzez_get_map_system() == 'google') {
            houzez_google_maps_scripts();
        } else {
            houzez_osm_maps_scripts();
        }
        

        } // is_admin
    }

    add_action( 'wp_enqueue_scripts', 'houzez_enqueue_scripts' );
}



if (is_admin() ){
    function houzez_admin_scripts(){
        global $pagenow, $typenow;

        wp_enqueue_style( 'houzez-admin.css', HOUZEZ_CSS_DIR_URI. 'admin/admin.css', array(), HOUZEZ_THEME_VERSION, 'all' );

        wp_enqueue_script('houzez-admin-ajax', HOUZEZ_JS_DIR_URI .'admin/houzez-admin-ajax.js', array('jquery'));
        wp_localize_script('houzez-admin-ajax', 'houzez_admin_vars',
            array( 
                'nonce'        => wp_create_nonce( 'houzez-admin-nonce' ),
                'ajaxurl'      => admin_url( 'admin-ajax.php' ),
                'paid_status'  => esc_html__( 'Paid','houzez' ),
                'activate_now' => esc_html__( 'Activate Now', 'houzez' ),
                'activating'   => esc_html__( 'Activating...', 'houzez' ),
                'activated'    => esc_html__( 'Activated!', 'houzez' ),
                'install_now'  => esc_html__( 'Install Now', 'houzez' ),
                'installing'   => esc_html__( 'Installing...', 'houzez' ),
                'installed'    => esc_html__( 'Installed!', 'houzez' ),
                'active'       => esc_html__( 'Active', 'houzez' ),
                'failed'       => esc_html__( 'Failed!', 'houzez' ),
            )
        );


        if ( isset( $_GET['taxonomy'] ) && ( $_GET['taxonomy'] == 'property_status' || $_GET['taxonomy'] == 'property_type' || $_GET['taxonomy'] == 'property_label' ) ) {
            wp_enqueue_style( 'wp-color-picker' );
            wp_enqueue_script( 'houzez_taxonomies', HOUZEZ_JS_DIR_URI.'admin/metaboxes-taxonomies.js', array( 'jquery', 'wp-color-picker' ), 'houzez' );
        }

    }
    add_action('admin_enqueue_scripts', 'houzez_admin_scripts');
}

// Header custom JS
function houzez_header_scripts(){

    $custom_js_header = houzez_option('custom_js_header');

    if ( $custom_js_header != '' ){
        echo ( $custom_js_header );
    }
}
if(!is_admin()){
    add_action('wp_head', 'houzez_header_scripts');
}

// Footer custom JS
function houzez_footer_scripts(){
    $custom_js_footer = houzez_option('custom_js_footer');

    if ( $custom_js_footer != '' ){
        echo ( $custom_js_footer );
    }
}
if(!is_admin()){
    add_action( 'wp_footer', 'houzez_footer_scripts', 100 );
}