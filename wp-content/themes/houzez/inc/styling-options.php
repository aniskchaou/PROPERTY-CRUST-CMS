<?php
/**
 * Theme Stylesheet Options
 * Refer to Theme Options
 * @package Houzez
 * @since   Houzez 1.0
**/

if(!function_exists('houzez_custom_styling')) {
  function houzez_custom_styling() {
    global $post;

    $pageID = $marker_type_color = '';
    if( !is_404() && !is_search() && !is_author() ) {
      $pageID = isset($post->ID) ? $post->ID : '';
    }

    $fave_header_type = get_post_meta( $pageID, 'fave_header_type', true );

    if( $fave_header_type == 'video' || $fave_header_type == 'static_image') {
      $parallax_opacity = get_post_meta( $pageID, 'fave_page_header_image_opacity', true );
      if( $parallax_opacity == '' ) {
        $parallax_opacity = '0.5';
      }

      $parallax_height = get_post_meta( $pageID, 'fave_page_header_image_height', true );
      if( !empty($parallax_height) ) {
        $parallax_height = 'height: ' . ( preg_match( '/(px|em|\%|pt|cm)$/', $parallax_height ) ? $parallax_height : $parallax_height . 'px' ) . ';';
      } else {
        $parallax_height = 'height: 600px';
      }

      $parallax_height_mobile = get_post_meta( $pageID, 'fave_header_image_height_mobile', true );
      if( !empty($parallax_height_mobile) ) {
        $parallax_height_mobile = 'height: ' . ( preg_match( '/(px|em|\%|pt|cm)$/', $parallax_height_mobile ) ? $parallax_height_mobile : $parallax_height_mobile . 'px' ) . ';';
      } else {
        $parallax_height_mobile = 'height: 300px';
      }
    }

    /*------------------------------------Typography-----------------------------------*/  
    $body_typo = houzez_option('typo-body');
    $body_font_family = isset($body_typo['font-family']) ? $body_typo['font-family'] : 'Roboto';
    $body_font_size = isset($body_typo['font-size']) ? $body_typo['font-size'] : '15px';
    $body_font_weight = isset($body_typo['font-weight']) ? $body_typo['font-weight'] : '300';
    $body_line_height = isset($body_typo['line-height']) ? $body_typo['line-height'] : '25px';
    $body_text_transform = isset($body_typo['text-transform']) ? $body_typo['text-transform'] : 'none';

    $typo_headers = houzez_option('typo-headers');
    $nav_font_family = isset($typo_headers['font-family']) ? $typo_headers['font-family'] : 'Roboto';
    $nav_font_size = isset($typo_headers['font-size']) ? $typo_headers['font-size'] : '15px';
    $nav_font_weight = isset($typo_headers['font-weight']) ? $typo_headers['font-weight'] : '500';
    $nav_text_aline = isset($typo_headers['text-align']) ? $typo_headers['text-align'] : 'left';
    $nav_line_height = isset($typo_headers['line-height']) ? $typo_headers['line-height'] : '25px';
    $nav_text_transform = isset($typo_headers['text-transform']) ? $typo_headers['text-transform'] : 'none';

    $typo_footer = houzez_option('typo-footer');
    $footer_font_family = isset($typo_footer['font-family']) ? $typo_footer['font-family'] : 'Roboto';
    $footer_font_size = isset($typo_footer['font-size']) ? $typo_footer['font-size'] : '14px';
    $footer_font_weight = isset($typo_footer['font-weight']) ? $typo_footer['font-weight'] : '300';
    $footer_text_aline = isset($typo_footer['text-align']) ? $typo_footer['text-align'] : 'left';
    $footer_line_height = isset($typo_footer['line-height']) ? $typo_footer['line-height'] : '25px';
    $footer_text_transform = isset($typo_footer['text-transform']) ? $typo_footer['text-transform'] : 'none';

    $typo_topbar = houzez_option('typo-topbar');
    $topbar_font_family = isset($typo_topbar['font-family']) ? $typo_topbar['font-family'] : 'Roboto';
    $topbar_font_size = isset($typo_topbar['font-size']) ? $typo_topbar['font-size'] : '14px';
    $topbar_font_weight = isset($typo_topbar['font-weight']) ? $typo_topbar['font-weight'] : '300';
    $topbar_text_aline = isset($typo_topbar['text-align']) ? $typo_topbar['text-align'] : 'left';
    $topbar_line_height = isset($typo_topbar['line-height']) ? $typo_topbar['line-height'] : '25px';
    $topbar_text_transform = isset($typo_topbar['text-transform']) ? $typo_topbar['text-transform'] : 'none';


    $typo_headings = houzez_option('typo-headings');
    $headings_font_family = isset($typo_headings['font-family']) ? $typo_headings['font-family'] : 'Roboto';
    $headings_font_weight = isset($typo_headings['font-weight']) ? $typo_headings['font-weight'] : '700';
    $headings_text_aline = isset($typo_headings['text-align']) ? $typo_headings['text-align'] : 'inherit';
    $headings_text_transform = isset($typo_headings['text-transform']) ? $typo_headings['text-transform'] : 'inherit';

    $houzez_typography = "
        body {
            font-family: {$body_font_family};
            font-size: {$body_font_size};
            font-weight: {$body_font_weight};
            line-height: {$body_line_height};
            text-align: left;
            text-transform: {$body_text_transform};
        }
        .main-nav,
        .dropdown-menu,
        .login-register,
        .btn.btn-create-listing,
        .logged-in-nav,
        .btn-phone-number {
          font-family: {$nav_font_family};
          font-size: {$nav_font_size};
          font-weight: {$nav_font_weight};
          text-align: {$nav_text_aline};
          text-transform: {$nav_text_transform};
        }

        .btn,
        .form-control,
        .bootstrap-select .text,
        .sort-by-title,
        .woocommerce ul.products li.product .button {
          font-family: {$body_font_family};
          font-size: {$body_font_size}; 
        }
        
        h1, h2, h3, h4, h5, h6, .item-title {
          font-family: {$headings_font_family};
          font-weight: {$headings_font_weight};
          text-transform: {$headings_text_transform};
        }

        .post-content-wrap h1, .post-content-wrap h2, .post-content-wrap h3, .post-content-wrap h4, .post-content-wrap h5, .post-content-wrap h6 {
          font-weight: {$headings_font_weight};
          text-transform: {$headings_text_transform};
          text-align: {$headings_text_aline}; 
        }

        .top-bar-wrap {
            font-family: {$topbar_font_family};
            font-size: {$topbar_font_size};
            font-weight: {$topbar_font_weight};
            line-height: {$topbar_line_height};
            text-align: {$topbar_text_aline};
            text-transform: {$topbar_text_transform};   
        }
        .footer-wrap {
            font-family: {$footer_font_family};
            font-size: {$footer_font_size};
            font-weight: {$footer_font_weight};
            line-height: {$footer_line_height};
            text-align: {$footer_text_aline};
            text-transform: {$footer_text_transform};
        }
        ";
    /*------------------------------------End Typography-----------------------------------*/  


    $header_1_height = houzez_option('header_1_height', '60');
    $header_2_height = houzez_option('header_2_height', '54');
    $header_3_top_height = houzez_option('header_3_top_height', '80');
    $header_3_bottom_height = houzez_option('header_3_bottom_height', '54');
    $header_4_height = houzez_option('header_4_height', '90');
    $header_5_top_height = houzez_option('header_5_top_height', '110');
    $header_5_bottom_height = houzez_option('header_5_bottom_height', '54');
    $header_6_height = houzez_option('header_6_height', '60');

    /* Headers Height
    /* ------------------------------------------------------------------------ */

    $headers_height = "
        .header-v1 .header-inner-wrap,
        .header-v1 .navbar-logged-in-wrap {
            line-height: {$header_1_height}px;
            height: {$header_1_height}px; 
        }
        .header-v2 .header-top .navbar {
          height: 110px; 
        }

        .header-v2 .header-bottom .header-inner-wrap,
        .header-v2 .header-bottom .navbar-logged-in-wrap {
          line-height: {$header_2_height}px;
          height: {$header_2_height}px; 
        }

        .header-v3 .header-top .header-inner-wrap,
        .header-v3 .header-top .header-contact-wrap {
          height: {$header_3_top_height}px;
          line-height: {$header_3_top_height}px; 
        }
        .header-v3 .header-bottom .header-inner-wrap,
        .header-v3 .header-bottom .navbar-logged-in-wrap {
          line-height: {$header_3_bottom_height}px;
          height: {$header_3_bottom_height}px; 
        }
        .header-v4 .header-inner-wrap,
        .header-v4 .navbar-logged-in-wrap {
          line-height: {$header_4_height}px;
          height: {$header_4_height}px; 
        }
        .header-v5 .header-top .header-inner-wrap,
        .header-v5 .header-top .navbar-logged-in-wrap {
          line-height: {$header_5_top_height}px;
          height: {$header_5_top_height}px; 
        }
        .header-v5 .header-bottom .header-inner-wrap {
          line-height: {$header_5_bottom_height}px;
          height: {$header_5_bottom_height}px; 
        }
        .header-v6 .header-inner-wrap,
        .header-v6 .navbar-logged-in-wrap {
          height: {$header_6_height}px;
          line-height: {$header_6_height}px; 
        }
    ";

    


    /* body colors
    /* ------------------------------------------------------------------------ */
    $body_text_color = houzez_option('body_text_color', '#222222');
    $body_bg_color = houzez_option('body_bg_color', '#f8f8f8');

    $houzez_body_colors = "
      body,
      #main-wrap,
      .fw-property-documents-wrap h3 span, 
      .fw-property-details-wrap h3 span {
        background-color: {$body_bg_color}; 
      }

       body,
      .form-control,
      .bootstrap-select .text,
      .item-title a,
      .listing-tabs .nav-tabs .nav-link,
      .item-wrap-v2 .item-amenities li span,
      .item-wrap-v2 .item-amenities li:before,
      .item-parallax-wrap .item-price-wrap,
      .list-view .item-body .item-price-wrap,
      .property-slider-item .item-price-wrap,
      .page-title-wrap .item-price-wrap,
      .agent-information .agent-phone span a,
      .property-overview-wrap ul li strong,
      .mobile-property-title .item-price-wrap .item-price,
      .fw-property-features-left li a,
      .lightbox-content-wrap .item-price-wrap,
      .blog-post-item-v1 .blog-post-title h3 a,
      .blog-post-content-widget h4 a,
      .property-item-widget .right-property-item-widget-wrap .item-price-wrap,
      .login-register-form .modal-header .login-register-tabs .nav-link.active,
      .agent-list-wrap .agent-list-content h2 a,
      .agent-list-wrap .agent-list-contact li a,
      .agent-contacts-wrap li a,
      .menu-edit-property li a,
      .statistic-referrals-list li a,
      .chart-nav .nav-pills .nav-link,
      .dashboard-table-properties td .property-payment-status,
      .dashboard-mobile-edit-menu-wrap .bootstrap-select > .dropdown-toggle.bs-placeholder,
      .payment-method-block .radio-tab .control-text,
      .post-title-wrap h2 a,
      .lead-nav-tab.nav-pills .nav-link,
      .deals-nav-tab.nav-pills .nav-link,
      .btn-light-grey-outlined:hover,
      button:not(.bs-placeholder) .filter-option-inner-inner,
      .fw-property-floor-plans-wrap .floor-plans-tabs a,
      .products > .product > .item-body > a,
      .woocommerce ul.products li.product .price,
      .woocommerce div.product p.price, 
      .woocommerce div.product span.price,
      .woocommerce #reviews #comments ol.commentlist li .meta,
      .woocommerce-MyAccount-navigation ul li a {
       color: {$body_text_color}; 
     }


    ";

    /* primary & secondary color 
    /* ----------------------------------------------------------- */
    $primary_color = houzez_option('houzez_primary_color', '#00aeff');
    $primary_color_hover = houzez_option('houzez_primary_color_hover');
    $primary_hover_code = isset($primary_color_hover['color']) ? $primary_color_hover['color'] : '#33beff';
    $primary_hover_rgba = isset($primary_color_hover['rgba']) ? $primary_color_hover['rgba'] : 'rgba(0, 174, 255, 0.65)';

    $secondary_color = houzez_option('houzez_secondary_color', '#28a745');
    $secondary_color_hover = houzez_option('houzez_secondary_color_hover');
    $secondary_hover_code = isset($secondary_color_hover['color']) ? $secondary_color_hover['color'] : '#34ce57';
    $secondary_hover_rgba = isset($secondary_color_hover['rgba']) ? $secondary_color_hover['rgba'] : 'rgba(52, 206, 87, 0.75)';

    $primaryandsecondary_colors = "
      a,
      a:hover,
      a:active,
      a:focus,
      .primary-text,
      .btn-clear,
      .btn-apply,
      .btn-primary-outlined,
      .btn-primary-outlined:before,
      .item-title a:hover,
      .sort-by .bootstrap-select .bs-placeholder,
      .sort-by .bootstrap-select > .btn,
      .sort-by .bootstrap-select > .btn:active,
      .page-link,
      .page-link:hover,
      .accordion-title:before,
      .blog-post-content-widget h4 a:hover,
      .agent-list-wrap .agent-list-content h2 a:hover,
      .agent-list-wrap .agent-list-contact li a:hover,
      .agent-contacts-wrap li a:hover,
      .agent-nav-wrap .nav-pills .nav-link,
      .dashboard-side-menu-wrap .side-menu-dropdown a.active,
      .menu-edit-property li a.active,
      .menu-edit-property li a:hover,
      .dashboard-statistic-block h3 .fa,
      .statistic-referrals-list li a:hover,
      .chart-nav .nav-pills .nav-link.active,
      .board-message-icon-wrap.active,
      .post-title-wrap h2 a:hover,
      .listing-switch-view .switch-btn.active,
      .item-wrap-v6 .item-price-wrap,
      .listing-v6 .list-view .item-body .item-price-wrap,
      .woocommerce nav.woocommerce-pagination ul li a, 
      .woocommerce nav.woocommerce-pagination ul li span,
      .woocommerce-MyAccount-navigation ul li a:hover {
        color: {$primary_color}; 
      }
      .agent-list-position a {
        color: {$primary_color}!important; 
      }

      .control input:checked ~ .control__indicator,
      .top-banner-wrap .nav-pills .nav-link,
      .btn-primary-outlined:hover,
      .page-item.active .page-link,
      .slick-prev:hover,
      .slick-prev:focus,
      .slick-next:hover,
      .slick-next:focus,
      .mobile-property-tools .nav-pills .nav-link.active,
      .login-register-form .modal-header,
      .agent-nav-wrap .nav-pills .nav-link.active,
      .board-message-icon-wrap .notification-circle,
      .primary-label,
      .fc-event, .fc-event-dot,
      .compare-table .table-hover > tbody > tr:hover,
      .post-tag,
      .datepicker table tr td.active.active,
      .datepicker table tr td.active.disabled,
      .datepicker table tr td.active.disabled.active,
      .datepicker table tr td.active.disabled.disabled,
      .datepicker table tr td.active.disabled:active,
      .datepicker table tr td.active.disabled:hover,
      .datepicker table tr td.active.disabled:hover.active,
      .datepicker table tr td.active.disabled:hover.disabled,
      .datepicker table tr td.active.disabled:hover:active,
      .datepicker table tr td.active.disabled:hover:hover,
      .datepicker table tr td.active.disabled:hover[disabled],
      .datepicker table tr td.active.disabled[disabled],
      .datepicker table tr td.active:active,
      .datepicker table tr td.active:hover,
      .datepicker table tr td.active:hover.active,
      .datepicker table tr td.active:hover.disabled,
      .datepicker table tr td.active:hover:active,
      .datepicker table tr td.active:hover:hover,
      .datepicker table tr td.active:hover[disabled],
      .datepicker table tr td.active[disabled],
      .ui-slider-horizontal .ui-slider-range {
        background-color: {$primary_color}; 
      }

      .control input:checked ~ .control__indicator,
      .btn-primary-outlined,
      .page-item.active .page-link,
      .mobile-property-tools .nav-pills .nav-link.active,
      .agent-nav-wrap .nav-pills .nav-link,
      .agent-nav-wrap .nav-pills .nav-link.active,
      .chart-nav .nav-pills .nav-link.active,
      .dashaboard-snake-nav .step-block.active,
      .fc-event,
      .fc-event-dot {
        border-color: {$primary_color}; 
      }

      .slick-arrow:hover {
        background-color: {$primary_hover_rgba}; 
      }

      .slick-arrow {
        background-color: {$primary_color}; 
      }

      .property-banner .nav-pills .nav-link.active {
        background-color: {$primary_hover_rgba} !important; 
      }

      .property-navigation-wrap a.active {
        color: {$primary_color};
        -webkit-box-shadow: inset 0 -3px {$primary_color};
        box-shadow: inset 0 -3px {$primary_color}; 
      }

      .btn-primary,
      .fc-button-primary,
      .woocommerce nav.woocommerce-pagination ul li a:focus, 
      .woocommerce nav.woocommerce-pagination ul li a:hover, 
      .woocommerce nav.woocommerce-pagination ul li span.current {
        color: #fff;
        background-color: {$primary_color};
        border-color: {$primary_color}; 
      }
      .btn-primary:focus, .btn-primary:focus:active,
      .fc-button-primary:focus,
      .fc-button-primary:focus:active {
        color: #fff;
        background-color: {$primary_color};
        border-color: {$primary_color}; 
      }
      .btn-primary:hover,
      .fc-button-primary:hover {
        color: #fff;
        background-color: {$primary_hover_code};
        border-color: {$primary_hover_code}; 
      }
      .btn-primary:active, 
      .btn-primary:not(:disabled):not(:disabled):active,
      .fc-button-primary:active,
      .fc-button-primary:not(:disabled):not(:disabled):active {
        color: #fff;
        background-color: {$primary_hover_code};
        border-color: {$primary_hover_code}; 
      }

      .btn-secondary,
      .woocommerce span.onsale,
      .woocommerce ul.products li.product .button,
      .woocommerce #respond input#submit.alt, 
      .woocommerce a.button.alt, 
      .woocommerce button.button.alt, 
      .woocommerce input.button.alt,
      .woocommerce #review_form #respond .form-submit input,
      .woocommerce #respond input#submit, 
      .woocommerce a.button, 
      .woocommerce button.button, 
      .woocommerce input.button {
        color: #fff;
        background-color: {$secondary_color};
        border-color: {$secondary_color}; 
      }
      .woocommerce ul.products li.product .button:focus,
      .woocommerce ul.products li.product .button:active,
      .woocommerce #respond input#submit.alt:focus, 
      .woocommerce a.button.alt:focus, 
      .woocommerce button.button.alt:focus, 
      .woocommerce input.button.alt:focus,
      .woocommerce #respond input#submit.alt:active, 
      .woocommerce a.button.alt:active, 
      .woocommerce button.button.alt:active, 
      .woocommerce input.button.alt:active,
      .woocommerce #review_form #respond .form-submit input:focus,
      .woocommerce #review_form #respond .form-submit input:active,
      .woocommerce #respond input#submit:active, 
      .woocommerce a.button:active, 
      .woocommerce button.button:active, 
      .woocommerce input.button:active,
      .woocommerce #respond input#submit:focus, 
      .woocommerce a.button:focus, 
      .woocommerce button.button:focus, 
      .woocommerce input.button:focus {
        color: #fff;
        background-color: {$secondary_color};
        border-color: {$secondary_color}; 
      }
      .btn-secondary:hover,
      .woocommerce ul.products li.product .button:hover,
      .woocommerce #respond input#submit.alt:hover, 
      .woocommerce a.button.alt:hover, 
      .woocommerce button.button.alt:hover, 
      .woocommerce input.button.alt:hover,
      .woocommerce #review_form #respond .form-submit input:hover,
      .woocommerce #respond input#submit:hover, 
      .woocommerce a.button:hover, 
      .woocommerce button.button:hover, 
      .woocommerce input.button:hover {
        color: #fff;
        background-color: {$secondary_hover_code};
        border-color: {$secondary_hover_code}; 
      }
      .btn-secondary:active, 
      .btn-secondary:not(:disabled):not(:disabled):active {
        color: #fff;
        background-color: {$secondary_hover_code};
        border-color: {$secondary_hover_code}; 
      }

      .btn-primary-outlined {
        color: {$primary_color};
        background-color: transparent;
        border-color: {$primary_color}; 
      }
      .btn-primary-outlined:focus, .btn-primary-outlined:focus:active {
        color: {$primary_color};
        background-color: transparent;
        border-color: {$primary_color}; 
      }
      .btn-primary-outlined:hover {
        color: #fff;
        background-color: {$primary_hover_code};
        border-color: {$primary_hover_code}; 
      }
      .btn-primary-outlined:active, .btn-primary-outlined:not(:disabled):not(:disabled):active {
        color: {$primary_color};
        background-color: rgba(26, 26, 26, 0);
        border-color: {$primary_hover_code}; 
      }

      .btn-secondary-outlined {
        color: {$secondary_color};
        background-color: transparent;
        border-color: {$secondary_color}; 
      }
      .btn-secondary-outlined:focus, .btn-secondary-outlined:focus:active {
        color: {$secondary_color};
        background-color: transparent;
        border-color: {$secondary_color}; 
      }
      .btn-secondary-outlined:hover {
        color: #fff;
        background-color: {$secondary_hover_code};
        border-color: {$secondary_hover_code}; 
      }
      .btn-secondary-outlined:active, .btn-secondary-outlined:not(:disabled):not(:disabled):active {
        color: {$secondary_color};
        background-color: rgba(26, 26, 26, 0);
        border-color: {$secondary_hover_code}; 
      }

      .btn-call {
        color: {$secondary_color};
        background-color: transparent;
        border-color: {$secondary_color}; 
      }
      .btn-call:focus, .btn-call:focus:active {
        color: {$secondary_color};
        background-color: transparent;
        border-color: {$secondary_color}; 
      }
      .btn-call:hover {
        color: {$secondary_color};
        background-color: rgba(26, 26, 26, 0);
        border-color: {$secondary_hover_code}; 
      }
      .btn-call:active, .btn-call:not(:disabled):not(:disabled):active {
        color: {$secondary_color};
        background-color: rgba(26, 26, 26, 0);
        border-color: {$secondary_hover_code}; 
      }
      .icon-delete .btn-loader:after{
          border-color: {$primary_color} transparent {$primary_color} transparent
      }
    ";

    /* advanced search
    /* ------------------------------------------------------------------------ */
    $adv_background = houzez_option('adv_background', '#ffffff');
    $side_search_background = houzez_option('side_search_background', '#ffffff');
    $adv_text_color = houzez_option('adv_text_color20', '#a1a7a8');
    $adv_other_color = houzez_option('adv_other_color', '#222222');
    $adv_halfmap_other_color = houzez_option('adv_halfmap_other_color', '#222222');
    $adv_borders = houzez_option('adv_textfields_borders', '#dce0e0');

    $adv_btn_bg_regular = houzez_option('adv_search_btn_bg', false, 'regular');
    $adv_btn_bg_hover = houzez_option('adv_search_btn_bg', false, 'hover');

    $adv_btn_color_regular = houzez_option('adv_search_btn_text', false, 'regular');
    $adv_btn_color_hover = houzez_option('adv_search_btn_text', false, 'hover');

    $adv_btn_border_regular = houzez_option('adv_search_border', false, 'regular');
    $adv_btn_border_hover = houzez_option('adv_search_border', false, 'hover');

    $adv_button_color_regular = houzez_option('adv_button_color', false, 'regular');
    $adv_button_color_hover = houzez_option('adv_button_color', false, 'hover');

    $adv_button_bg_color_regular = houzez_option('adv_button_bg_color', false, 'regular');
    $adv_button_bg_color_hover = houzez_option('adv_button_bg_color', false, 'hover');

    $adv_button_border_color_regular = houzez_option('adv_button_border_color', false, 'regular');
    $adv_button_border_color_hover = houzez_option('adv_button_border_color', false, 'hover');

    $adv_overlay_open_close_bg_color = houzez_option('adv_overlay_open_close_bg_color');
    $adv_overlay_open_close_color = houzez_option('adv_overlay_open_close_color');

    $header_search_padding = houzez_option('header_search_padding');
    $adv_padding_top = $header_search_padding['padding-top'];
    $adv_padding_bottom = $header_search_padding['padding-bottom'];

    $search_colors = "
      .form-control::-webkit-input-placeholder,
      .search-banner-wrap ::-webkit-input-placeholder,
      .advanced-search ::-webkit-input-placeholder,
      .advanced-search-banner-wrap ::-webkit-input-placeholder,
      .overlay-search-advanced-module ::-webkit-input-placeholder {
        color: {$adv_text_color}; 
      }
      .bootstrap-select > .dropdown-toggle.bs-placeholder, 
      .bootstrap-select > .dropdown-toggle.bs-placeholder:active, 
      .bootstrap-select > .dropdown-toggle.bs-placeholder:focus, 
      .bootstrap-select > .dropdown-toggle.bs-placeholder:hover {
        color: {$adv_text_color}; 
      }
      .form-control::placeholder,
      .search-banner-wrap ::-webkit-input-placeholder,
      .advanced-search ::-webkit-input-placeholder,
      .advanced-search-banner-wrap ::-webkit-input-placeholder,
      .overlay-search-advanced-module ::-webkit-input-placeholder {
        color: {$adv_text_color}; 
      }

      .search-banner-wrap ::-moz-placeholder,
      .advanced-search ::-moz-placeholder,
      .advanced-search-banner-wrap ::-moz-placeholder,
      .overlay-search-advanced-module ::-moz-placeholder {
        color: {$adv_text_color}; 
      }

      .search-banner-wrap :-ms-input-placeholder,
      .advanced-search :-ms-input-placeholder,
      .advanced-search-banner-wrap ::-ms-input-placeholder,
      .overlay-search-advanced-module ::-ms-input-placeholder {
        color: {$adv_text_color}; 
      }

      .search-banner-wrap :-moz-placeholder,
      .advanced-search :-moz-placeholder,
      .advanced-search-banner-wrap :-moz-placeholder,
      .overlay-search-advanced-module :-moz-placeholder {
        color: {$adv_text_color}; 
      }

      .advanced-search .form-control,
      .advanced-search .bootstrap-select > .btn,
      .location-trigger,
      .vertical-search-wrap .form-control,
      .vertical-search-wrap .bootstrap-select > .btn,
      .step-search-wrap .form-control,
      .step-search-wrap .bootstrap-select > .btn,
      .advanced-search-banner-wrap .form-control,
      .advanced-search-banner-wrap .bootstrap-select > .btn,
      .search-banner-wrap .form-control,
      .search-banner-wrap .bootstrap-select > .btn,
      .overlay-search-advanced-module .form-control,
      .overlay-search-advanced-module .bootstrap-select > .btn,
      .advanced-search-v2 .advanced-search-btn,
      .advanced-search-v2 .advanced-search-btn:hover {
        border-color: {$adv_borders}; 
      }

      .advanced-search-nav,
      .search-expandable,
      .overlay-search-advanced-module {
        background-color: {$adv_background}; 
      }
      .btn-search {
        color: {$adv_btn_color_regular};
        background-color: {$adv_btn_bg_regular};
        border-color: {$adv_btn_border_regular};
      }
      .btn-search:hover, .btn-search:active  {
        color: {$adv_btn_color_hover};
        background-color: {$adv_btn_bg_hover};
        border-color: {$adv_btn_border_hover};
      }
      .advanced-search-btn {
        color: {$adv_button_color_regular};
        background-color: {$adv_button_bg_color_regular};
        border-color: {$adv_button_border_color_regular}; 
      }
      .advanced-search-btn:hover, .advanced-search-btn:active {
        color: {$adv_button_color_hover};
        background-color: {$adv_button_bg_color_hover};
        border-color: {$adv_button_border_color_hover}; 
      }
      .advanced-search-btn:focus {
        color: {$adv_button_color_regular};
        background-color: {$adv_button_bg_color_regular};
        border-color: {$adv_button_border_color_regular}; 
      }
      .search-expandable-label {
        color: {$adv_overlay_open_close_color};
        background-color: {$adv_overlay_open_close_bg_color};
      }
      .advanced-search-nav {
        padding-top: {$adv_padding_top};
        padding-bottom: {$adv_padding_bottom};
      }
      .features-list-wrap .control--checkbox,
      .features-list-wrap .control--radio,
      .range-text, 
      .features-list-wrap .control--checkbox, 
      .features-list-wrap .btn-features-list, 
      .overlay-search-advanced-module .search-title, 
      .overlay-search-advanced-module .overlay-search-module-close {
          color: {$adv_other_color};
      }
      .advanced-search-half-map {
        background-color: {$side_search_background}; 
      }
      .advanced-search-half-map .range-text, 
      .advanced-search-half-map .features-list-wrap .control--checkbox, 
      .advanced-search-half-map .features-list-wrap .btn-features-list {
          color: {$adv_halfmap_other_color};
      }
    ";

    /* header v.1 - colors
    /* ------------------------------------------------------------------------ */
    $ssb_color = houzez_option('ssb_color', '#ffffff');
    $ssb_color_hover = houzez_option('ssb_color_hover', '#ffffff');
    $ssb_bg_color = houzez_option('ssb_bg_color', '#28a745');
    $ssb_bg_color_hover = houzez_option('ssb_bg_color_hover', '#28a745');
    $ssb_border_color = houzez_option('ssb_border_color', '#28a745');
    $ssb_border_color_hover = houzez_option('ssb_border_color_hover', '#28a745');

    $saved_search_btn = "
      .save-search-btn {
          border-color: {$ssb_border_color} ;
          background-color: {$ssb_bg_color} ;
          color: {$ssb_color} ;
      }
      .save-search-btn:hover,
      .save-search-btn:active {
          border-color: {$ssb_border_color_hover};
          background-color: {$ssb_bg_color_hover} ;
          color: {$ssb_color_hover} ;
      }";


    /* header v.1 - colors
    /* ------------------------------------------------------------------------ */
    $header_1_bg = houzez_option('header_1_bg', '#004274');
    $header_1_links_color = houzez_option('header_1_links_color', '#ffffff');
    $header_1_links_hover_color = houzez_option('header_1_links_hover_color', '#00aeff');
    $header_1_links_hover_bg_color = houzez_option('header_1_links_hover_bg_color');
    $header_1_links_hover_bg_color = isset($header_1_links_hover_bg_color['rgba']) ? $header_1_links_hover_bg_color['rgba'] : 'rgba(0, 174, 255, 0.1)';

    $houzez_1_colors = "
      .header-v1 {
        background-color: {$header_1_bg};
        border-bottom: 1px solid {$header_1_bg}; 
      }

      .header-v1 a {
        color: {$header_1_links_color}; 
      }

      .header-v1 a:hover,
      .header-v1 a:active {
        color: {$header_1_links_hover_color};
        background-color: {$header_1_links_hover_bg_color}; 
      }
    ";


    /* header v.2 - colors and header v.5 - colors
    /* ------------------------------------------------------------------------ */
    $header_2_top_bg = houzez_option('header_2_top_bg', '#ffffff');
    $header_2_top_text = houzez_option('header_2_top_text', '#004274');
    $header_2_bg = houzez_option('header_2_bg', '#004274');
    $header_2_links_color = houzez_option('header_2_links_color', '#ffffff');
    $header_2_links_hover_color = houzez_option('header_2_links_hover_color', '#00aeff');
    $header_2_links_hover_bg_color = houzez_option('header_2_links_hover_bg_color');
    $header_2_links_hover_bg_color = isset($header_2_links_hover_bg_color['rgba']) ? $header_2_links_hover_bg_color['rgba'] : 'rgba(0, 174, 255, 0.1)';
    $header_2_border = houzez_option('header_2_border');
    $header_2_border = isset($header_2_border['rgba']) ? $header_2_border['rgba'] : 'rgba(0, 66, 116, 0.2)';

    $houzez_2_colors = "
      .header-v2 .header-top,
      .header-v5 .header-top,
      .header-v2 .header-contact-wrap {
        background-color: {$header_2_top_bg}; 
      }

      .header-v2 .header-bottom, 
      .header-v5 .header-bottom {
        background-color: {$header_2_bg};
      }

      .header-v2 .header-contact-wrap .header-contact-right, .header-v2 .header-contact-wrap .header-contact-right a, .header-contact-right a:hover, header-contact-right a:active {
        color: {$header_2_top_text}; 
      }

      .header-v2 .header-contact-left {
        color: {$header_2_top_text}; 
      }

      .header-v2 .header-bottom,
      .header-v2 .navbar-nav > li,
      .header-v2 .navbar-nav > li:first-of-type,
      .header-v5 .header-bottom,
      .header-v5 .navbar-nav > li,
      .header-v5 .navbar-nav > li:first-of-type {
        border-color: {$header_2_border};
      }

      .header-v2 a,
      .header-v5 a {
        color: {$header_2_links_color}; 
      }

      .header-v2 a:hover,
      .header-v2 a:active,
      .header-v5 a:hover,
      .header-v5 a:active {
        color: {$header_2_links_hover_color};
        background-color: {$header_2_links_hover_bg_color}; 
      }

      .header-v2 .header-contact-right a:hover, 
      .header-v2 .header-contact-right a:active,
      .header-v3 .header-contact-right a:hover, 
      .header-v3 .header-contact-right a:active {
        background-color: transparent;
      }

      .header-v2 .header-social-icons a,
      .header-v5 .header-social-icons a {
        color: {$header_2_top_text}; 
      }
    ";

    /* header v.3 - colors
    /* ------------------------------------------------------------------------ */
    $header_3_bg = houzez_option('header_3_bg', '#004274');
    $header_3_bg_menu = houzez_option('header_3_bg_menu', '#004274');
    $header_3_callus_color = houzez_option('header_3_callus_color', '#ffffff');
    $header_3_callus_bg = houzez_option('header_3_callus_bg_color', '#00aeff');
    $header_3_links_color = houzez_option('header_3_links_color', '#ffffff');
    $header_3_links_hover_color = houzez_option('header_3_links_hover_color', '#00aeff');
    $header_3_links_hover_bg_color = houzez_option('header_3_links_hover_bg_color');
    $header_3_links_hover_bg_color = isset($header_3_links_hover_bg_color['rgba']) ? $header_3_links_hover_bg_color['rgba'] : 'rgba(0, 174, 255, 0.1)';
    $header_3_social_color = houzez_option('header_3_social_color', '#004274');
    $header_3_border =  houzez_option('header_3_border');
    $header_3_border =  isset($header_3_border['rgba']) ? $header_3_border['rgba'] : 'rgba(0, 174, 239, 0.2)';

    $houzez_3_colors = "
      .header-v3 .header-top {
        background-color: {$header_3_bg}; 
      }

      .header-v3 .header-bottom {
        background-color: {$header_3_bg_menu}; 
      }

      .header-v3 .header-contact,
      .header-v3-mobile {
        background-color: {$header_3_callus_bg};
        color: {$header_3_callus_color}; 
      }

      .header-v3 .header-bottom,
      .header-v3 .login-register,
      .header-v3 .navbar-nav > li,
      .header-v3 .navbar-nav > li:first-of-type {
        border-color: {$header_3_border}; 
      }

      .header-v3 a, 
      .header-v3 .header-contact-right a:hover, .header-v3 .header-contact-right a:active {
        color: {$header_3_links_color}; 
      }

      .header-v3 a:hover,
      .header-v3 a:active {
        color: {$header_3_links_hover_color};
        background-color: {$header_3_links_hover_bg_color}; 
      }

      .header-v3 .header-social-icons a {
        color: {$header_3_social_color}; 
      }
    ";

    /* header v.4 - colors
    /* ------------------------------------------------------------------------ */
    $header_4_bg = houzez_option('header_4_bg', '#ffffff');
    $header_4_links_color = houzez_option('header_4_links_color', '#004274');
    $header_4_links_hover_color = houzez_option('header_4_links_hover_color', '#00aeff');
    $header_4_links_hover_bg_color = houzez_option('header_4_links_hover_bg_color');
    $header_4_links_hover_bg_color = isset($header_4_links_hover_bg_color['rgba']) ? $header_4_links_hover_bg_color['rgba'] : 'rgba(0, 174, 255, 0.1)';

    $houzez_4_colors = "
      .header-v4 {
        background-color: {$header_4_bg}; 
      }

      .header-v4 a {
        color: {$header_4_links_color}; 
      }

      .header-v4 a:hover,
      .header-v4 a:active {
        color: {$header_4_links_hover_color};
        background-color: {$header_4_links_hover_bg_color}; 
      }
    ";

    /* header v.6 - colors
    /* ------------------------------------------------------------------------ */
    $header_6_bg = houzez_option('header_6_bg', '#004274');
    $header_6_links_color = houzez_option('header_6_links_color', '#ffffff');
    $header_6_links_hover_color = houzez_option('header_6_links_hover_color', '#00aeff');
    $header_6_social_color = houzez_option('header_6_social_color', '#ffffff');
    $header_6_links_hover_bg_color = houzez_option('header_6_links_hover_bg_color');
    $header_6_links_hover_bg_color = isset($header_6_links_hover_bg_color['rgba']) ? $header_6_links_hover_bg_color['rgba'] : 'rgba(0, 174, 255, 0.1)';

    $houzez_6_colors = "
      .header-v6 .header-top {
        background-color: {$header_6_bg}; 
      }

      .header-v6 a {
        color: {$header_6_links_color}; 
      }

      .header-v6 a:hover,
      .header-v6 a:active {
        color: {$header_6_links_hover_color};
        background-color: {$header_6_links_hover_bg_color}; 
      }

      .header-v6 .header-social-icons a {
        color: {$header_6_social_color}; 
      }
    ";

    /* header transparent - nav colors
    /* ----------------------------------------------------------- */
    $transparent_links_color = houzez_option('header_4_transparent_links_color', '#ffffff');
    $transparent_links_hover_color = houzez_option('header_4_transparent_links_hover_color', '#ffffff');

    $transparent_border_bottom_color = houzez_option('header_4_transparent_border_bottom_color');
    $transparent_border_bottom_color = isset($transparent_border_bottom_color['rgba']) ? $transparent_border_bottom_color['rgba'] : '';
    $transparent_border_bottom1 = houzez_option('header_4_transparent_border_bottom1');

    $transparent_menu = "
      .header-transparent-wrap .header-v4 {
        background-color: transparent;
        border-bottom: {$transparent_border_bottom1['border-bottom']} {$transparent_border_bottom1['border-style']} {$transparent_border_bottom_color}; 
      }

      .header-transparent-wrap .header-v4 a {
        color: {$transparent_links_color}; 
      }

      .header-transparent-wrap .header-v4 a:hover,
      .header-transparent-wrap .header-v4 a:active {
        color: {$transparent_links_hover_color};
        background-color: rgba(255, 255, 255, 0.1); 
      }
    ";

    /* Sub-menu colors
    /* ----------------------------------------------------------- */
    $header_submenu_links_color = houzez_option('header_submenu_links_color', '#004274');
    $header_submenu_links_hover_color = houzez_option('header_submenu_links_hover_color', '#00aeff');
    $header_submenu_border_color = houzez_option('header_submenu_border_color', '#dce0e0');
    $header_submenu_bg = houzez_option('header_submenu_bg');
    $header_submenu_bg = isset($header_submenu_bg['rgba']) ? $header_submenu_bg['rgba'] : 'rgba(255, 255, 255, 0.95)';

    $nav_submenu_colors = "
      .main-nav .navbar-nav .nav-item .dropdown-menu {
        background-color: {$header_submenu_bg}; 
      }

      .main-nav .navbar-nav .nav-item .nav-item a {
        color: {$header_submenu_links_color};
        border-bottom: 1px solid {$header_submenu_border_color}; 
      }

      .main-nav .navbar-nav .nav-item .nav-item a:hover,
      .main-nav .navbar-nav .nav-item .nav-item a:active {
        color: {$header_submenu_links_hover_color}; 
      }
    ";

    /* create listing button
    /* ------------------------------------------------------------------------ */
    $header_4_btn_color = houzez_option('header_4_btn_color', '#ffffff');
    $header_4_btn_hover_color = houzez_option('header_4_btn_hover_color', '#ffffff');
    $header_4_btn_hover_color = isset($header_4_btn_hover_color['rgba']) ? $header_4_btn_hover_color['rgba'] : 'rgba(255, 255, 255, 0.99)';

    $header_4_btn_bg_color = houzez_option('header_4_btn_bg_color', '#00aeff');
    $header_4_btn_bg_hover_color = houzez_option('header_4_btn_bg_hover_color');
    $header_4_btn_bg_hover_color = isset($header_4_btn_bg_hover_color['rgba']) ? $header_4_btn_bg_hover_color['rgba'] : 'rgba(0, 174, 255, 0.65)';

    $header_4_btn_border = houzez_option('header_4_btn_border');
    $header_4_btn_border_hover_color = houzez_option('header_4_btn_border_hover_color');
    $header_4_btn_border_hover_color = isset($header_4_btn_border_hover_color['color']) ? $header_4_btn_border_hover_color['color'] : '#00aeff';

    $create_listing_button = "
      .header-main-wrap .btn-create-listing {
        color: {$header_4_btn_color};
        border: {$header_4_btn_border['border-left']} {$header_4_btn_border['border-style']} {$header_4_btn_border['border-color']};
        background-color: {$header_4_btn_bg_color}; 
      }

      .header-main-wrap .btn-create-listing:hover,
      .header-main-wrap .btn-create-listing:active {
        color: {$header_4_btn_hover_color};
        border: {$header_4_btn_border['border-left']} {$header_4_btn_border['border-style']} {$header_4_btn_border_hover_color};
        background-color: {$header_4_btn_bg_hover_color}; 
      }
    ";


    /* create listing button - transparent header
    /* ------------------------------------------------------------------------ */
    $transparent_btn_color = houzez_option('header_4_transparent_btn_color', '#ffffff');
    $transparent_btn_hover_color = houzez_option('header_4_transparent_btn_hover_color', '#ffffff');
    $transparent_btn_hover_color = isset($transparent_btn_hover_color['rgba']) ? $transparent_btn_hover_color['rgba'] : 'rgba(255, 255, 255, 0.2)';

    $transparent_btn_bg_color = houzez_option('header_4_transparent_btn_bg_color');
    $transparent_btn_bg_color = isset($transparent_btn_bg_color['rgba']) ? $transparent_btn_bg_color['rgba'] : 'rgba(255, 255, 255, 0.99)';
    $transparent_btn_bg_hover_color = houzez_option('header_4_transparent_btn_bg_hover_color');
    $transparent_btn_bg_hover_color = isset($transparent_btn_bg_hover_color['rgba']) ? $transparent_btn_bg_hover_color['rgba'] : 'rgba(0, 174, 255, 0.65)';

    $transparent_btn_border = houzez_option('header_4_transparent_btn_border');
    $transparent_btn_border_hover_color = houzez_option('header_4_transparent_btn_border_hover_color');
    $transparent_btn_border_hover_color = isset($transparent_btn_border_hover_color['color']) ? $transparent_btn_border_hover_color['color'] : '#00aeff';

    $create_listing_button_transparent = "
      .header-transparent-wrap .header-v4 .btn-create-listing {
        color: {$transparent_btn_color};
        border: {$transparent_btn_border['border-bottom']} {$transparent_btn_border['border-style']} {$transparent_btn_border['border-color']};
        background-color: {$transparent_btn_bg_color}; 
      }

      .header-transparent-wrap .header-v4 .btn-create-listing:hover,
      .header-transparent-wrap .header-v4 .btn-create-listing:active {
        color: {$transparent_btn_hover_color};
        border: {$transparent_btn_border['border-bottom']} {$transparent_btn_border['border-style']} {$transparent_btn_border_hover_color};
        background-color: {$transparent_btn_bg_hover_color}; 
      }
    ";

    /* mobile nav - colors
    /* ------------------------------------------------------------------------ */
    $mob_menu_bg_color = houzez_option('mob_menu_bg_color', '#004274');
    $mob_menu_btn_color = houzez_option('mob_menu_btn_color', '#ffffff');
    $mob_nav_bg_color = houzez_option('mob_nav_bg_color', '#ffffff');
    $mob_link_color = houzez_option('mob_link_color', '#004274');
    $mobile_nav_border = houzez_option('mobile_nav_border');

    $mobile_menu = "
      .header-mobile {
        background-color: {$mob_menu_bg_color}; 
      }
      .header-mobile .toggle-button-left,
      .header-mobile .toggle-button-right {
        color: {$mob_menu_btn_color}; 
      }

      .nav-mobile .logged-in-nav a,
      .nav-mobile .main-nav,
      .nav-mobile .navi-login-register {
        background-color: {$mob_nav_bg_color}; 
      }

      .nav-mobile .logged-in-nav a,
      .nav-mobile .main-nav .nav-item .nav-item a,
      .nav-mobile .main-nav .nav-item a,
      .navi-login-register .main-nav .nav-item a {
        color: {$mob_link_color};
        border-bottom: {$mobile_nav_border['border-top']} {$mobile_nav_border['border-style']} {$mobile_nav_border['border-color']};
        background-color: {$mob_nav_bg_color};
      }

      .nav-mobile .btn-create-listing,
      .navi-login-register .btn-create-listing {
        color: #fff;
        border: 1px solid {$primary_color};
        background-color: {$primary_color}; 
      }

      .nav-mobile .btn-create-listing:hover, .nav-mobile .btn-create-listing:active,
      .navi-login-register .btn-create-listing:hover,
      .navi-login-register .btn-create-listing:active {
        color: #fff;
        border: 1px solid {$primary_color};
        background-color: rgba(0, 174, 255, 0.65); 
      }
    ";


    /* user account menu
    /* ------------------------------------------------------------------------ */
    $ua_menu_bg = houzez_option('ua_menu_bg', '#ffffff');
    $ua_menu_links_color = houzez_option('ua_menu_links_color', '#004274');
    $ua_menu_links_hover_color = houzez_option('ua_menu_links_hover_color', '#00aeff');
    $ua_menu_border_color = houzez_option('ua_menu_border_color', '#dce0e0');
    $ua_menu_links_hover_bg_color = houzez_option('ua_menu_links_hover_bg_color');
    $ua_menu_links_hover_bg_color = isset($ua_menu_links_hover_bg_color['rgba']) ? $ua_menu_links_hover_bg_color['rgba'] : 'rgba(0, 174, 255, 0.1)';

    $user_account_menu = "
      .header-transparent-wrap .logged-in-nav a,
      .logged-in-nav a {
        color: {$ua_menu_links_color};
        border-color: {$ua_menu_border_color};
        background-color: {$ua_menu_bg}; 
      }

      .header-transparent-wrap .logged-in-nav a:hover,
      .header-transparent-wrap .logged-in-nav a:active,
      .logged-in-nav a:hover,
      .logged-in-nav a:active {
        color: {$ua_menu_links_hover_color};
        background-color: {$ua_menu_links_hover_bg_color};
        border-color: {$ua_menu_border_color}; 
      }
    ";

    /* featured label
    /* ------------------------------------------------------------------------ */
    $featured_label_bg_color = houzez_option('featured_label_bg_color', '#77c720');
    $featured_label_color = houzez_option('featured_label_color', '#ffffff');

    $houzez_featured_label_colors = "
    .label-featured {
      background-color: {$featured_label_bg_color};
      color: {$featured_label_color}; 
    }
    ";

    /* property detail 
    /* ------------------------------------------------------------------------ */
    $houzez_prop_details_bg =  houzez_option('houzez_prop_details_bg', '0, 174, 255, 0.1', 'rgba');
    $prop_details_border_color =  houzez_option('prop_details_border_color', '#00aeff');

    $prop_detail_color = "
      .detail-wrap {
        background-color: {$houzez_prop_details_bg};
        border-color: {$prop_details_border_color}; 
      }
    ";

    /* dashaboard Menu
    /* ------------------------------------------------------------------------ */
    $dm_background = houzez_option('dm_background', '#002B4B');
    $dm_color = houzez_option('dm_color', '#839EB2');
    $dm_hover_color = houzez_option('dm_hover_color', '#ffffff');
    $dm_submenu_active_color = houzez_option('dm_submenu_active_color', '#00aeff');

    $dashaboard_menu_colors = "
    .dashboard-side-wrap {
      background-color: {$dm_background}; 
    }

    .side-menu a {
      color: {$dm_color}; 
    }

    .side-menu a.active,
    .side-menu .side-menu-parent-selected > a,
    .side-menu-dropdown a,
    .side-menu a:hover {
      color: {$dm_hover_color}; 
    }
    .dashboard-side-menu-wrap .side-menu-dropdown a.active {
      color: {$dm_submenu_active_color}
    }
    ";

    /* top bar - colors
    /* ------------------------------------------------------------------------ */
    $top_bar_bg = houzez_option('top_bar_bg', '#000000');
    $top_bar_color = houzez_option('top_bar_color', '#111111');
    $topbar_menu_btn_color = houzez_option('topbar_menu_btn_color', '#111111');
    $top_bar_color_hover = houzez_option('top_bar_color_hover', '#00AEEF', 'rgba');

    $topbar_styling = ".top-bar-wrap,
    .top-bar-wrap .dropdown-menu,
    .switcher-wrap .dropdown-menu {
      background-color: {$top_bar_bg};
    }
    .top-bar-wrap a,
    .top-bar-contact,
    .top-bar-slogan,
    .top-bar-wrap .btn,
    .top-bar-wrap .dropdown-menu,
    .switcher-wrap .dropdown-menu,
    .top-bar-wrap .navbar-toggler {
      color: {$top_bar_color};
    }
    .top-bar-wrap a:hover,
    .top-bar-wrap a:active,
    .top-bar-wrap .btn:hover,
    .top-bar-wrap .btn:active,
    .top-bar-wrap .dropdown-menu li:hover,
    .top-bar-wrap .dropdown-menu li:active,
    .switcher-wrap .dropdown-menu li:hover,
    .switcher-wrap .dropdown-menu li:active {
      color: {$top_bar_color_hover};
    }";



    /* Energy Class
    /* ------------------------------------------------------------------------ */
    $energy_1_color = houzez_option('energy_1_color', '#33a357');
    $energy_2_color = houzez_option('energy_2_color', '#79b752');
    $energy_3_color = houzez_option('energy_3_color', '#c3d545');
    $energy_4_color = houzez_option('energy_4_color', '#fff12c');
    $energy_5_color = houzez_option('energy_5_color', '#edb731');
    $energy_6_color = houzez_option('energy_6_color', '#d66f2c');
    $energy_7_color = houzez_option('energy_7_color', '#cc232a');
    $energy_8_color = houzez_option('energy_8_color', '#cc232a');
    $energy_9_color = houzez_option('energy_9_color', '#cc232a');
    $energy_10_color = houzez_option('energy_10_color', '#cc232a');

    $energy_class_colors = "
    .class-energy-indicator:nth-child(1) {
        background-color: {$energy_1_color};
    }
    .class-energy-indicator:nth-child(2) {
        background-color: {$energy_2_color};
    }
    .class-energy-indicator:nth-child(3) {
        background-color: {$energy_3_color};
    }
    .class-energy-indicator:nth-child(4) {
        background-color: {$energy_4_color};
    }
    .class-energy-indicator:nth-child(5) {
        background-color: {$energy_5_color};
    }
    .class-energy-indicator:nth-child(6) {
        background-color: {$energy_6_color};
    }
    .class-energy-indicator:nth-child(7) {
        background-color: {$energy_7_color};
    }
    .class-energy-indicator:nth-child(8) {
        background-color: {$energy_8_color};
    }
    .class-energy-indicator:nth-child(9) {
        background-color: {$energy_9_color};
    }
    .class-energy-indicator:nth-child(10) {
        background-color: {$energy_10_color};
    }
    ";


    /* footer
    /* ------------------------------------------------------------------------ */
    $footer_bg_color = houzez_option('footer_bg_color', '#004274');
    $footer_bottom_bg_color = houzez_option('footer_bottom_bg_color', '#00335a');
    $footer_color = houzez_option('footer_color', '#ffffff');
    $footer_hover_color = houzez_option('footer_hover_color', '#00aeff', 'rgba');

    $footer_styling = "
    .footer-top-wrap {
      background-color: {$footer_bg_color}; 
    }

    .footer-bottom-wrap {
      background-color: {$footer_bottom_bg_color}; 
    }

    .footer-top-wrap,
    .footer-top-wrap a,
    .footer-bottom-wrap,
    .footer-bottom-wrap a,
    .footer-top-wrap .property-item-widget .right-property-item-widget-wrap .item-amenities,
    .footer-top-wrap .property-item-widget .right-property-item-widget-wrap .item-price-wrap,
    .footer-top-wrap .blog-post-content-widget h4 a,
    .footer-top-wrap .blog-post-content-widget,
    .footer-top-wrap .form-tools .control,
    .footer-top-wrap .slick-dots li.slick-active button:before,
    .footer-top-wrap .slick-dots li button::before,
    .footer-top-wrap .widget ul:not(.item-amenities):not(.item-price-wrap):not(.contact-list):not(.dropdown-menu):not(.nav-tabs) li span {
      color: {$footer_color}; 
    }
    ";

    if( !empty($footer_hover_color) ) {
      $footer_styling .= "
          .footer-top-wrap a:hover,
          .footer-bottom-wrap a:hover,
          .footer-top-wrap .blog-post-content-widget h4 a:hover {
            color: {$footer_hover_color}; 
          }";
    }
    
    $banners_style = '';
    if( $fave_header_type == 'video' || $fave_header_type == 'static_image') {
      $banners_style .= "
        .banner-inner:before,
        .video-background:before {
          opacity: {$parallax_opacity};
        }
        .top-banner-wrap {
           {$parallax_height}
         }
         @media (max-width: 767px) {
          .top-banner-wrap {
           {$parallax_height_mobile}
         }
       }
      ";
    }

    $map_cluster = houzez_option('map_cluster', '', 'url');
    if (!empty($map_cluster)) {
        $clusterIcon = $map_cluster;
    } else {
        $clusterIcon = HOUZEZ_IMAGE . 'map/cluster-icon.png';
    }

    $osm_cluster_css = "
        .houzez-osm-cluster {
            background-image: url({$clusterIcon});
            text-align: center;
            color: #fff;
            width: 48px;
            height: 48px;
            line-height: 48px;
        }
    ";

    // Property label color
    $prop_label = $marker_type_color = $prop_status_label = '';
    if( taxonomy_exists('property_label') ) {

        $taxonomy_label = get_terms( 'property_label' );
        $prop_label = '';

        if( $taxonomy_label ) {
            foreach( $taxonomy_label as $term ) {

                $houzez_term_id = $term->term_id;
                $meta = get_option( '_houzez_property_label_'.$houzez_term_id );


                if ( isset($meta['color_type']) && $meta['color_type'] == 'custom' ) {

                    $prop_label .= "
                    .label-color-{$houzez_term_id} {
                        background-color: {$meta['color']};
                    }
                    ";

                }
            }
        }
    }

    // Property status color
    if( taxonomy_exists('property_status') ) {

        $prop_status = get_terms( 'property_status' );
        $prop_status_label = '';

        if( $prop_status ) {
            foreach( $prop_status as $term ) {

                $houzez_term_id = $term->term_id;
                $meta = get_option( '_houzez_property_status_'.$houzez_term_id );

                if ( isset($meta['color_type']) && $meta['color_type'] == 'custom' ) {

                    $prop_status_label .= "
                    .status-color-{$houzez_term_id} {
                        background-color: {$meta['color']};
                    }
                    ";

                }
            }
        }

    }

    // Marker color based on type
    if( taxonomy_exists('property_type') ) {

        $marker_type = get_terms( 'property_type' );
        $marker_type_color = '';

        if( $marker_type ) {
            foreach( $marker_type as $term ) {

                $houzez_term_id = $term->term_id;
                $meta = get_option( '_houzez_property_type_'.$houzez_term_id );

                if ( isset($meta['color_type']) && $meta['color_type'] == 'custom' ) {

                    $marker_type_color .= "
                    .gm-marker-color-{$houzez_term_id} {
                        background-color: {$meta['color']};
                        border-color:{$meta['color']};
                    }
                    ";
                    $marker_type_color .="
                    .gm-marker-color-{$houzez_term_id}:after {
                        border-top-color: {$meta['color']};
                    }
                    ";

                }
            }
        }

    }

    $houzez_custom_css = houzez_option('custom_css');

    wp_add_inline_style( 'houzez-style',
      $prop_label.
      $prop_status_label.
      $marker_type_color.
      $houzez_typography.
      $headers_height.
      $houzez_body_colors.
      $primaryandsecondary_colors.
      $houzez_1_colors.
      $houzez_2_colors.
      $houzez_3_colors.
      $houzez_4_colors.
      $houzez_6_colors.
      $mobile_menu.
      $transparent_menu.
      $nav_submenu_colors.
      $create_listing_button.
      $create_listing_button_transparent.
      $user_account_menu.
      $search_colors.
      $saved_search_btn.
      $houzez_featured_label_colors.
      $dashaboard_menu_colors.
      $prop_detail_color.
      $topbar_styling.
      $energy_class_colors.
      $footer_styling.
      $osm_cluster_css.
      $banners_style.
      $houzez_custom_css
    );

  }
}
add_action( 'wp_enqueue_scripts', 'houzez_custom_styling', 21 );
?>