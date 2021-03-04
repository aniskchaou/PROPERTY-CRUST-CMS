/**
 * Created by waqasriaz on 22/06/16.
 */
jQuery(document).ready(function ($) {
    "use strict";

    var ajaxurl = houzez_admin_vars.ajaxurl;
    var paid_text = houzez_admin_vars.paid_status;
    var nonce = houzez_admin_vars.nonce;
    var install_now = houzez_admin_vars.install_now;
    var installing = houzez_admin_vars.installing;
    var installed = houzez_admin_vars.installed;
    var activate_now = houzez_admin_vars.activate_now;
    var activating = houzez_admin_vars.activating;
    var activated = houzez_admin_vars.activated;
    var active = houzez_admin_vars.active;
    var failed = houzez_admin_vars.failed;

    /*--------------------------------------------------------------
    * Install plugin
    * ------------------------------------------------------------*/
    function houzez_install_plugin($current_btn) {
        var $button = $current_btn;
        var plugin_slug    = $current_btn.data('slug');
        var plugin_source  = $current_btn.data('source');
        var plugin_file    = $current_btn.data('file');

        jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajaxurl,
            data: {
                'action'        : 'houzez_plugin_installation',
                'plugin_slug'   : plugin_slug,
                'plugin_source' : plugin_source,
                'plugin_file'   : plugin_file,
                _ajax_nonce     : nonce
            },
            beforeSend: function( ) {
                $button.addClass('updating-message');
                $button.text(installing);
                
            },
            complete: function(){
                $button.removeClass('updating-message');
            },
            success: function (res) {
            
                if (res.success) {
                    $button.addClass('updated-message');
                    $button.text(installed);

                    setTimeout(function () {

                        $button.removeClass('updated-message');
                        $button.text(activate_now).addClass('houzez-activate-btn').removeClass('houzez-install-btn');

                    }, 900);

                } else {

                    $button.text(failed);
                    setTimeout(function () {
                        $button.text(install_now);
                    }, 900);
                }

            },
            error: function (errorThrown) {}
        });
    }
    

    /*--------------------------------------------------------------
    * Activate plugin
    * ------------------------------------------------------------*/
    function houzez_activate($current_btn) {
        
        var $button = $current_btn;
        var plugin_file    = $current_btn.data('file');

        jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajaxurl,
            data: {
                'action'        : 'houzez_plugin_activate',
                'plugin_file'   : plugin_file,
                _ajax_nonce     : nonce
            },
            beforeSend: function( ) {
                $button.addClass('updating-message');
                $button.text(activating);
            },
            complete: function(){
                $button.removeClass('updating-message');
            },
            success: function (res) {

                if (res.success) {
                    $button.addClass('updated-message');
                    $button.text(activated);

                    setTimeout(function () {

                        $button.removeClass('updated-message');
                        $button.text(active).addClass('button-disabled').removeClass('houzez-activate-btn');

                    }, 900);

                } else {

                    $button.text(failed);
                    setTimeout(function () {
                        $button.text(activate_now);
                    }, 900);
                }

            },
            error: function (errorThrown) {}
        });

    }


    $('.houzez-plugin-js').on('click', function(e) {
        e.preventDefault();
        var $clicked_btn = $(this);

        if( $clicked_btn.hasClass('houzez-install-btn') ) {

            houzez_install_plugin($clicked_btn);

        } else if( $clicked_btn.hasClass('houzez-activate-btn') ) {
            houzez_activate($clicked_btn);
        }

    });


    /*--------------------------------------------------------------
    * Feedback
    * ------------------------------------------------------------*/
    $('#houzez-feedback-submit').on('click', function(e) {
        e.preventDefault();

        var $button = $(this);
        var button_text = $button.text();
        var form_messages = $('#form-messages');
        var email = $('#houzez_feedback_email').val();
        var email_subject = $('#houzez_feedback_subject').val();
        var message = $('#houzez_feedback_message').val();
        var feedback_nonce = $('#houzez_feedback_nonce').val();

        if( !email ) {
            form_messages.html('<span class="error">Please provide email address.</span>');
        }
        else if( !email_subject ) {
            form_messages.html('<span class="error">Please select subject.</span>');
        }
        else if( !message ) {
            form_messages.html('<span class="error">Please enter message.</span>');

        } else {

            form_messages.html('');

            jQuery.ajax({
                type: 'POST',
                dataType: 'json',
                url: ajaxurl,
                data: {
                    'action'         : 'houzez_feedback',
                    'email'          : email,
                    'subject'        : email_subject,
                    'message'        : message,
                    'feedback_nonce' : feedback_nonce
                },
                beforeSend: function( ) {
                    $button.addClass('updating-message');
                },
                complete: function(){
                    $button.removeClass('updating-message');
                },
                success: function (response) {

                    if (response.success) {
                        document.getElementById("admin-houzez-form").reset();
                        form_messages.html('<span class="success">'+response.msg+'</span>');

                    } else {
                        form_messages.html('<span class="error">'+response.msg+'</span>');
                    }

                    setTimeout(function () {
                        form_messages.html('');
                    }, 2500);

                },
                error: function (errorThrown) {}
            });

        }

    });
    

    $("#fave_listing_template .inside .rwmb-meta-box > div:gt(0):lt(2)").wrapAll('<div id="only_for_listings_templates">');

    $("#only_for_listings_templates > div:gt(0):lt(1)").wrapAll('<div id="listing_tabs">');

    $('#fave_listings_tabs').on('change', function() {
        checkTabs();
    });
    function checkTabs() { 
        var tabs = jQuery('#fave_listings_tabs').val();

        if( tabs == 'enable' ) {
            jQuery('#listing_tabs').show();
        } else {
            jQuery('#listing_tabs').hide();
        }
    }

    jQuery(window).on('load', function(){ 
        checkTabs();
    });

    $('#activate_purchase_listing').on('click', function(){
        var itemID, invoiceID, purchaseType;

        itemID       = $(this).attr('data-item');
        invoiceID    = $(this).attr('data-invoice');
        purchaseType = $(this).attr('data-purchaseType');

        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                'action'        : 'houzez_activate_purchase_listing',
                'item_id'       : itemID,
                'invoice_id'    : invoiceID,
                'purchase_type' : purchaseType

            },
            beforeSend: function( ) {
                $(this).find('.houzez-loader-js').addClass('loader-show');
            },
            complete: function(){
                $(this).find('.houzez-loader-js').removeClass('loader-show');
            },
            success: function (data) {
                jQuery("#activate_purchase_listing").remove();
                jQuery("#houzez_invoice_payment_status .fave_admin_label").removeClass('label-red');
                jQuery("#houzez_invoice_payment_status .fave_admin_label").addClass('label-green');
                jQuery("#houzez_invoice_payment_status .fave_admin_label").empty().html(paid_text);

            },
            error: function (errorThrown) {}
        });

    });

    $('#activate_package').on('click', function(){
        var itemID, invoiceID;

        itemID       = $(this).attr('data-item');
        invoiceID    = $(this).attr('data-invoice');

        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                'action'     : 'houzez_activate_pack_purchase',
                'item_id'    : itemID,
                'invoice_id' : invoiceID

            },
            beforeSend: function( ) {
                $(this).find('.houzez-loader-js').addClass('loader-show');
            },
            complete: function(){
                $(this).find('.houzez-loader-js').removeClass('loader-show');
            },
            success: function (data) {
                jQuery("#activate_package").remove();
                jQuery("#houzez_invoice_payment_status .fave_admin_label").removeClass('label-red');
                jQuery("#houzez_invoice_payment_status .fave_admin_label").addClass('label-green');
                jQuery("#houzez_invoice_payment_status .fave_admin_label").empty().html(paid_text);

            },
            error: function (errorThrown) {}
        });

    });

    $(document).ready(function ($) {
    
        $('#specific_sidebar').on('change', function(){
            checkSidebar();
        });
        
        function checkSidebar() {
            var specific_sidebar = jQuery('#specific_sidebar').val();
            
            if( specific_sidebar == 'yes' ) {
                jQuery('#houzez_selected_sidebar').stop(true,true).fadeIn(500);
            } else {
                jQuery('#houzez_selected_sidebar').hide();
            }
        }


        jQuery(window).load(function(){ 
            checkSidebar();
        });
        
    });

});
