/**
 * Created by waqasriaz on 06/10/15.
 */
jQuery(document).ready( function($) {
    "use strict";

    if ( typeof houzezProperty !== "undefined" ) {
        
        var dtGlobals = {}; // Global storage
        dtGlobals.isMobile	= (/(Android|BlackBerry|iPhone|iPad|Palm|Symbian|Opera Mini|IEMobile|webOS)/.test(navigator.userAgent));
        dtGlobals.isAndroid	= (/(Android)/.test(navigator.userAgent));
        dtGlobals.isiOS		= (/(iPhone|iPod|iPad)/.test(navigator.userAgent));
        dtGlobals.isiPhone	= (/(iPhone|iPod)/.test(navigator.userAgent));
        dtGlobals.isiPad	= (/(iPad|iPod)/.test(navigator.userAgent));

        var ajax_url = houzezProperty.ajaxURL;
        var is_edit_property = houzezProperty.is_edit_property;
        var houzez_logged_in = houzezProperty.houzez_logged_in;
        var login_sending = houzezProperty.login_loading;
        var process_loader_refresh = houzezProperty.process_loader_refresh;
        var process_loader_spinner = houzezProperty.process_loader_spinner;
        var process_loader_circle = houzezProperty.process_loader_circle;
        var process_loader_cog = houzezProperty.process_loader_cog;
        var success_icon = houzezProperty.success_icon;
        var verify_nonce = houzezProperty.verify_nonce;
        var verify_file_type = houzezProperty.verify_file_type;
        var msg_digits = houzezProperty.msg_digits;
        var max_prop_images = houzezProperty.max_prop_images;
        var image_max_file_size = houzezProperty.image_max_file_size;
        var max_prop_attachments = houzezProperty.max_prop_attachments;
        var attachment_max_file_size = houzezProperty.attachment_max_file_size;
        var add_listing_msg = houzezProperty.add_listing_msg;
        var processing_text = houzezProperty.processing_text;

        var plan_title_text = houzezProperty.plan_title_text;
        var plan_size_text = houzezProperty.plan_size_text;
        var plan_bedrooms_text = houzezProperty.plan_bedrooms_text;
        var plan_bathrooms_text = houzezProperty.plan_bathrooms_text;
        var plan_price_text = houzezProperty.plan_price_text;
        var plan_price_postfix_text = houzezProperty.plan_price_postfix_text;
        var plan_image_text = houzezProperty.plan_image_text;
        var plan_description_text = houzezProperty.plan_description_text;
        var plan_upload_text = houzezProperty.plan_upload_text;

        var mu_title_text = houzezProperty.mu_title_text;
        var mu_type_text = houzezProperty.mu_type_text;
        var mu_beds_text = houzezProperty.mu_beds_text;
        var mu_baths_text = houzezProperty.mu_baths_text;
        var mu_size_text = houzezProperty.mu_size_text;
        var mu_size_postfix_text = houzezProperty.mu_size_postfix_text;
        var mu_price_text = houzezProperty.mu_price_text;
        var mu_price_postfix_text = houzezProperty.mu_price_postfix_text;
        var mu_availability_text = houzezProperty.mu_availability_text;
        var are_you_sure_text = houzezProperty.are_you_sure_text;
        var delete_btn_text = houzezProperty.delete_btn_text;
        var cancel_btn_text = houzezProperty.cancel_btn_text;
        var confirm_btn_text = houzezProperty.confirm_btn_text;

        // For validation
        var prop_title = houzezProperty.prop_title;
        var prop_price = houzezProperty.prop_price;
        var prop_sec_price = houzezProperty.prop_sec_price;
        var prop_type = houzezProperty.prop_type;
        var prop_status = houzezProperty.prop_status;
        var prop_labels = houzezProperty.prop_labels;
        //var prop_description = houzezProperty.description;
        var price_label = houzezProperty.price_label;
        var prop_id = houzezProperty.prop_id;
        var bedrooms = houzezProperty.bedrooms;
        var bathrooms = houzezProperty.bathrooms;
        var area_size = houzezProperty.area_size;
        var land_area = houzezProperty.land_area;
        var garages = houzezProperty.garages;
        var year_built = houzezProperty.year_built;
        var property_map_address = houzezProperty.property_map_address;
        var neighborhood = houzezProperty.neighborhood;
        var city = houzezProperty.city;
        var state = houzezProperty.state;
        var country = houzezProperty.country;
        var enable_title_limit = houzezProperty.enable_title_limit;
        var property_title_limit = houzezProperty.property_title_limit;

        var fave_processing_modal = function ( msg ) {
            var process_modal ='<div class="modal fade" id="fave_modal" tabindex="-1" role="dialog" aria-labelledby="faveModalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-body houzez_messages_modal">'+msg+'</div></div></div></div></div>';
            jQuery('body').append(process_modal);
            jQuery('#fave_modal').modal();
        }

        var fave_processing_modal_close = function ( ) {
            jQuery('#fave_modal').modal('hide');
        }

        /*--------------------------------------------------------------------------
         *  Delete property
         * -------------------------------------------------------------------------*/
        $( 'a.delete-property' ).on( 'click', function (){
            
                var $this = $( this );
                var propID = $this.data('id');
                var propNonce = $this.data('nonce');

                bootbox.confirm({
                message: "<strong>"+houzezProperty.delete_confirmation+"</strong>",
                buttons: {
                    confirm: {
                        label: delete_btn_text,
                        className: 'btn btn-primary'
                    },
                    cancel: {
                        label: cancel_btn_text,
                        className: 'btn btn-grey-outlined'
                    }
                },
                callback: function (result) {
                    if(result==true) {
                        fave_processing_modal( processing_text );

                        $.ajax({
                            type: 'POST',
                            dataType: 'json',
                            url: ajax_url,
                            data: {
                                'action': 'houzez_delete_property',
                                'prop_id': propID,
                                'security': propNonce
                            },
                            success: function(data) {
                                if ( data.success == true ) {
                                    window.location = data.redirect;
                                } else {
                                    jQuery('#fave_modal').modal('hide');
                                    alert( data.reason );
                                }
                            },
                            error: function(errorThrown) {

                            }
                        }); // $.ajax
                    } // result
                } // Callback
            });

            return false;
            
        });

        /*--------------------------------------------------------------------------
         *   Make Property Featured - only for membership
         * -------------------------------------------------------------------------*/
        $('.make-prop-featured').on('click', function (e) {
            e.preventDefault();
            var $this = $(this);
            var prop_id = $this.attr('data-propid');
            var prop_type = $this.attr('data-proptype');

            bootbox.confirm({
                message: "<strong>"+houzezProperty.confirm_featured+"</strong>",
                buttons: {
                    confirm: {
                        label: confirm_btn_text,
                        className: 'btn btn-primary'
                    },
                    cancel: {
                        label: cancel_btn_text,
                        className: 'btn btn-grey-outlined'
                    }
                },
                callback: function (result) {
                    if(result==true) {
                        fave_processing_modal( processing_text );
                        make_prop_featured(prop_id, $this, prop_type);
                        $this.unbind("click");
                    }
                }
            });
            
        });

        var make_prop_featured = function( prop_id, currentDiv, prop_type ) {

            var $messages = $('#dash-prop-msg');

            $.ajax({
                type: 'POST',
                url: ajax_url,
                dataType: 'JSON',
                data: {
                    'action' : 'houzez_make_prop_featured',
                    'propid' : prop_id,
                    'prop_type': prop_type
                },
                success: function ( res ) {

                    if( res.success ) {
                        window.location.reload();
                    } else {
                        houzez_processing_modal_close();
                        $('html, body').animate({
                            scrollTop: $(".dashboard-content-inner-wrap").offset().top
                        }, 'slow');
                        $messages.empty().append('<div class="alert alert-danger alert-dismissible fade show" role="alert">'+houzezProperty.featured_listings_none+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    }

                },
                error: function(xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    console.log(err.Message);
                }

            });//end ajax
        }

        /*--------------------------------------------------------------------------
         *   Make Property Featured - only for membership
         * -------------------------------------------------------------------------*/
        $('.remove-prop-featured').click(function (e) {
            e.preventDefault();

            var $this = $(this);
            var prop_id = $this.attr('data-propid');

            bootbox.confirm({
                message: "<strong>"+houzezProperty.confirm_featured_remove+"</strong>",
                buttons: {
                    confirm: {
                        label: confirm_btn_text,
                        className: 'btn btn-primary'
                    },
                    cancel: {
                        label: cancel_btn_text,
                        className: 'btn btn-grey-outlined'
                    }
                },
                callback: function (result) {
                    if(result==true) {
                        fave_processing_modal( processing_text );
                        remove_prop_featured(prop_id, $this);
                        $(this).unbind("click");
                    }
                }
            });

        });

        var remove_prop_featured = function( prop_id, currentDiv ) {

            $.ajax({
                type: 'POST',
                url: ajax_url,
                dataType: 'JSON',
                data: {
                    'action' : 'houzez_remove_prop_featured',
                    'propid' : prop_id
                },
                success: function ( res ) {
                    if( res.success ) {
                        window.location.reload();
                    }
                },
                error: function(xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    console.log(err.Message);
                }

            });//end ajax
        }

        /*--------------------------------------------------------------------------
         *   Resend Property For approval - only for membership
         * -------------------------------------------------------------------------*/
        $('.resend-for-approval').click(function (e) {
            e.preventDefault();

            var prop_id = $(this).attr('data-propid');
            resend_for_approval(prop_id, $(this));
            $(this).unbind("click");
            
        });

        var resend_for_approval = function( prop_id, currentDiv ) {
            var $messages = $('#dash-prop-msg');

            $.ajax({
                type: 'POST',
                url: ajax_url,
                dataType: 'JSON',
                data: {
                    'action' : 'houzez_resend_for_approval',
                    'propid' : prop_id
                },
                beforeSend: function( ) {
                    fave_processing_modal( processing_text );
                },
                complete: function(){
                    houzez_processing_modal_close();
                },
                success: function ( res ) {

                    if( res.success ) {
                        houzez_processing_modal_close();
                        window.location.reload();
                        
                    } else {
                        houzez_processing_modal_close();
                        $('html, body').animate({
                            scrollTop: $(".dashboard-content-inner-wrap").offset().top
                        }, 'slow');
                        $messages.empty().append('<div class="alert alert-danger alert-dismissible fade show" role="alert">'+res.msg+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    }

                },
                error: function(xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    console.log(err.Message);
                }

            });//end ajax
        }

        if( $('#invoice-print-button').length > 0 ) {

            $('#invoice-print-button').click(function (e) {
                e.preventDefault();
                var invoiceID, printWindow;
                invoiceID = $(this).attr('data-id');

                printWindow = window.open('', 'Print Me', 'width=800 ,height=842');
                $.ajax({
                    type: 'POST',
                    url: ajax_url,
                    data: {
                        'action': 'houzez_create_invoice_print',
                        'invoice_id': invoiceID,
                    },
                    success: function (data) {
                        printWindow.document.write(data);
                        printWindow.document.close();
                        printWindow.focus();
                    },
                    error: function (xhr, status, error) {
                        var err = eval("(" + xhr.responseText + ")");
                        console.log(err.Message);
                    }

                });
            });
        }

        //Login user before while submission
        var houzez_login_user_before_submit = function(currnt) {
            var $form = currnt.parents('form');
            var $messages = $('#sumission_login_register_msgs');

            var sp_username = $('#sp_username').val();
            var sp_password = $('#sp_password').val();
            var security = $('#houzez_register_security2').val();
            var houzez_loggedin_success = $('#houzez_loggedin_success').val();

            if(houzez_loggedin_success == 1 ) {
                $('#submit_property_form').submit();
                return;
            }

            $.ajax({
                type: 'post',
                url: ajax_url,
                dataType: 'json',
                data: {
                    'action': 'houzez_login',
                    'username': sp_username,
                    'password': sp_password,
                    'houzez_register_security2': security,
                    'is_submit_listing': 'yes',
                },
                beforeSend: function( ) {
                    currnt.find('.houzez-loader-js').addClass('loader-show');
                },
                complete: function(){
                    currnt.find('.houzez-loader-js').removeClass('loader-show');
                },
                success: function( response ) {
                    if( response.success ) {
                        $messages.empty().append('<div class="alert alert-success" role="alert"><i class="houzez-icon icon-check-circle-1 mr-1"></i>'+ response.msg +'</div>');
                        $('#submit_property_form').append('<input type="hidden" name="houzez_loggedin_success" id="houzez_loggedin_success" value="1">');
                        $('#submit_property_form').submit();
                    
                    } else {
                        $messages.empty().append('<div class="alert alert-danger" role="alert"><i class="houzez-icon icon-check-circle-1 mr-1"></i>'+ response.msg +'</div>');
                    }
                },
                error: function(xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    console.log(err.Message);
                }
            });
        }

        $('input[name="fave_agent_display_option"]').on('click', function() {
            var $this = $(this);
            var $contact_info = $this.val();
            $('.agents-dropdown, .agencies-dropdown').hide();

            if($contact_info == 'agent_info') {
                $('.agents-dropdown').show();
            } else if($contact_info == 'agency_info') {
                $('.agencies-dropdown').show();
            }
        });

        //Register/Login user before submit property
        var houzez_register_login_user_before_submit = function ( currnt ) {

            var $form = currnt.parents('form');
            var $messages = $('#sumission_login_register_msgs');

            var username = $('#username').val();
            var useremail = $('#user_email').val();
            var phone_number = $('#phone_number').val();
            var user_role = $('#user_role').val();
            var register_security = $('#houzez_register_security2').val();

            var houzez_registered_success = $('#houzez_registered_success').val();

            if(houzez_registered_success == 1) {
                $('#submit_property_form').submit();
                return;
            }

            $.ajax({
                type: 'post',
                url: ajax_url,
                dataType: 'json',
                data: {
                    'action': 'houzez_register_user_with_membership',
                    'username': username,
                    'useremail': useremail,
                    'phone_number': phone_number,
                    'first_name': '',
                    'last_name': '',
                    'user_role': user_role,
                    'houzez_register_security2': register_security,
                    'is_submit_listing': 'yes',
                },
                beforeSend: function( ) {
                    currnt.find('.houzez-loader-js').addClass('loader-show');
                },
                complete: function(){
                    currnt.find('.houzez-loader-js').removeClass('loader-show');
                },
                success: function( response ) {
                    if( response.success ) {
                        $messages.empty().append('<div class="alert alert-success" role="alert"><i class="houzez-icon icon-check-circle-1 mr-1"></i>'+ response.msg +'</div>');
                        $('#submit_property_form').append('<input type="hidden" name="houzez_registered_success" id="houzez_registered_success" value="1">');
                        $('#submit_property_form').submit();
                    } else {
                        $messages.empty().append('<div class="alert alert-danger" role="alert"><i class="houzez-icon icon-check-circle-1 mr-1"></i>'+ response.msg +'</div>');
                    }
                },
                error: function(xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    console.log(err.Message);
                }
            });
        }

        if( houzez_logged_in == 'no' ) {
            var add_new_property = $('#add_new_property');
            if (add_new_property.length > 0) {

                add_new_property.on('click', function (e) {
                    e.preventDefault();
                    var currnt = $(this);
                    var login_while_submission = $('#login_while_submission').val();
                    if( login_while_submission == 1 ) {
                        houzez_login_user_before_submit(currnt);
                        
                    } else {
                        houzez_register_login_user_before_submit(currnt);
                    }
                    return;
                });
            }
        }

        //Duplicate listings
        $( '.clone-property' ).on( 'click', function( e ) {
            e.preventDefault();
            var $this = $( this );
            var propid = $this.data( 'property' );
            $.ajax({
                url: ajax_url,
                data: {
                    'action': 'houzez_property_clone',
                    'propID': propid
                },
                method: 'POST',
                dataType: "JSON",

                beforeSend: function( ) {
                    houzez_processing_modal(processing_text);
                },
                success: function( response ) { 
                    window.location = response.redirect;
                },
                complete: function(){
                }
            });

        });

        //Put On Hold
        $( '.put-on-hold' ).on( 'click', function( e ) {
            e.preventDefault();
            var $this = $( this );
            var propid = $this.data( 'property' );
            $.ajax({
                url: ajax_url,
                data: {
                    'action': 'houzez_property_on_hold',
                    'propID': propid
                },
                method: 'POST',
                dataType: "JSON",

                beforeSend: function( ) {
                    houzez_processing_modal(processing_text);
                },
                success: function( response ) {
                    window.location.reload();
                },
                complete: function(){
                }
            });

        });

        //Re listings
        $( 'a.relist-free' ).on( 'click', function( e ) {
            e.preventDefault();
            var $this = $( this );
            var propid = $this.data( 'property' );
    
            $.ajax({
                url: ajax_url,
                data: {
                    action: 'houzez_relist_free',
                    propID: propid
                },
                method: 'POST',
                dataType: "JSON",

                beforeSend: function( ) {
                    houzez_processing_modal(processing_text);
                },
                success: function( response ) {
                    window.location.reload();
                },
                complete: function(){
                }
            });

        });

        var houzez_validation = function( field_required ) {
            if( field_required != 0 ) {
                return true;
            }
            return false;
        };

        var houzez_processing_modal = function ( msg ) {
            var process_modal ='<div class="modal fade" id="fave_modal" tabindex="-1" role="dialog" aria-labelledby="faveModalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-body houzez_messages_modal">'+msg+'</div></div></div></div></div>';
            jQuery('body').append(process_modal);
            jQuery('#fave_modal').modal();
        };

        var houzez_processing_modal_close = function ( ) {
            jQuery('#fave_modal').modal('hide');
        };


        //Save property as draft
        $( "#save_as_draft" ).on('click', function() {
            var $form = $('#submit_property_form');
            var save_as_draft = $('#save_as_draft');
            var description = tinyMCE.get('prop_des').getContent();

            $.ajax({
                type: 'post',
                url: ajax_url,
                dataType: 'json',
                data: $form.serialize() + "&action=save_as_draft&description="+description,
                beforeSend: function( ) {
                    $('.houzez-loader-js').addClass('loader-show');
                },
                complete: function(){
                    $('.houzez-loader-js').removeClass('loader-show');
                },
                success: function( response ) {
                    
                    if( response.success ) {
                        $('input[name=draft_prop_id]').remove();
                        $('#submit_property_form').prepend('<input type="hidden" name="draft_prop_id" value="'+response.property_id+'">');
                        jQuery('#modal-save-draft').modal('show');
                    }
                },
                error: function(xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    console.log(err.Message);
                }
            })
        });

        var title_length = function() {
            var maxLength = property_title_limit;
            $('#prop_title').keyup(function() {
              var textlen = $(this).val().length;
              $('#rchars').text(textlen);
            });
        }

        if( enable_title_limit == 1 && property_title_limit != "" ) {
            title_length();
        }

        /* ------------------------------------------------------------------------ */
        /*  START CREATE LISTING FORM STEPS AND VALIDATION
         /* ------------------------------------------------------------------------ */
         var add_new_property_validation = function() {
            $("[data-hide]").on("click", function(){
                $(this).closest("." + $(this).attr("data-hide")).hide();
            });

            var current = 1;

            var form        = $("#submit_property_form");
            var formStep    = $(".form-step");
            var formStepGal = $(".form-step-gal");
            var formStepLocation = $(".form-step-location");
            var btnnext     = $(".btn-next");
            var btnback     = $(".btn-back");
            var btncancel     = $(".btn-cancel");
            var btnsubmit_block   = $(".btn-step-submit");
            var btnsubmit   = form.find("button[type='submit']");

            var menu_edit_property   = $('.menu-edit-property li a');
            var menu_edit_mobile   = $('#menu_edit_mobile');

            var errorBlock      = $(".validate-errors");
            var errorBlockGal   = $(".validate-errors-gal");
            var galThumbs       = $(".property-thumb");

            $('.steps-total').html(formStep.length);

            // Init buttons and UI
            formStep.not(':eq(0)').hide();
            formStep.eq(0).addClass('active');


            // Hide buttons according to the current step
            var hideButtons = function(current) {
                var limit = parseInt(formStep.length);

                $(".action").hide();

                if (current < limit) btnnext.show();

                if (current > 1) {
                    btnback.show();
                    btncancel.hide();
                } else {
                    btnback.hide();
                    btncancel.show();
                }
                if (current == limit) {
                    btnnext.hide();
                    btnsubmit_block.show();
                } else {
                    btnsubmit_block.hide();
                }
            };

            hideButtons(current);

            menu_edit_property.on('click', function(e) {
                e.preventDefault();
                var $this = $(this);
                var $current = $this.data('val');
                var blocks = $('.dashboard-content-block-wrap');

                if(form.valid()){
                    errorBlock.hide();
                    menu_edit_property.removeClass('active');
                    $this.addClass('active');

                    blocks.hide();
                    $('#'+$current).show();
                } else {
                    errorBlock.show();
                }

            });

            menu_edit_mobile.on('change', function(e) {
                e.preventDefault();
                var $this = $(this);
                var $current = $this.val();
                var blocks = $('.dashboard-content-block-wrap');

                if(form.valid()){
                    errorBlock.hide();
                    menu_edit_property.removeClass('active');
                    $this.addClass('active');

                    blocks.hide();
                    $('#'+$current).show();
                } else {
                    errorBlock.show();
                }

            });

            // Next button click action
            btnnext.click(function(e) {
                e.preventDefault();
                
                $('html, body').animate({
                    scrollTop: $(".dashboard-content-inner-wrap").offset().top-150
                }, 'slow');

                if(dtGlobals.isiOS) {
                    property_gallery_images();
                }

                if(current < formStep.length){
                    
                    if($(formStepGal).is(':visible')){
                        if(!$(".property-thumb").length > 0){ 
                            errorBlockGal.show();
                            return
                        }else{
                            errorBlockGal.hide();
                        }
                    }
                    if(form.valid()){
                        formStep.removeClass('active').css({display:'none'});
                        formStep.eq(current++).addClass('active').css({display:'block'});
                        errorBlock.hide();
                    }else{
                        errorBlock.show();
                        form.find('select').selectpicker('refresh');
                    }
                }
                hideButtons(current);
                $('.steps-counter').html(current);
            });

            // Back button click action
            btnback.click(function(e){
                e.preventDefault();
                errorBlock.hide();
                
                $('html, body').animate({
                    scrollTop: $(".dashboard-content-inner-wrap").offset().top-150
                }, 'slow');

                if(current > 1){
                    current = current - 2;
                    if(current < formStep.length){
                        formStep.removeClass('active').css({display:'none'});
                        formStep.eq(current++).addClass('active').css({display:'block'});
                    }
                }
                hideButtons(current);
                $('.steps-counter').html(current);
            });

            // Submit button click
            btnsubmit.click(function(){

                if($(formStepGal).is(':visible')){
                    if(!$(".property-thumb").length > 0){
                        errorBlockGal.show();
                        return
                    }else{
                        errorBlockGal.hide();
                    }
                }
                if(form.valid()){ 
                    errorBlock.hide();
                }else{ 
                    errorBlock.show();
                    $('html, body').animate({
                        scrollTop: $(".dashboard-content-inner-wrap").offset().top-150
                    }, 'slow');
                }
            });

            if(form.length > 0){ 
                form.validate({ 
                    ignore: ":hidden:not(.submit-form-wrap .account-block.active .selectpicker)",
                    errorPlacement: function (error, element) {
                        return false;
                    },
                    rules: {
                        
                    },
                    messages: {
                        
                    },
                    highlight: function ( element, errorClass, validClass ) {
                    $( element ).addClass( "is-invalid" ).removeClass( "is-valid" );
                    },
                    unhighlight: function (element, errorClass, validClass) {
                        $( element ).removeClass( "is-invalid" );
                    },
                    submitHandler: function(form) {
                        $(".houzez-submit-js").attr("disabled", true);
                        $('.houzez-submit-js .houzez-loader-js').addClass('loader-show');
                        form.submit();
                    }
                });

            }

        }
        add_new_property_validation();

        /* ------------------------------------------------------------------------ */
        /*	Property additional Features
         /* ------------------------------------------------------------------------ */
        $( "#houzez_additional_details_main" ).sortable({
            revert: 100,
            placeholder: "detail-placeholder",
            handle: ".sort-additional-row",
            cursor: "move"
        });

        $( '.add-additional-row' ).click(function( e ){
            e.preventDefault();

            var numVal = $(this).data("increment") + 1;
            $(this).data('increment', numVal);
            $(this).attr({
                "data-increment" : numVal
            });

            var newAdditionalDetail = '<tr>'+
                '<td class="table-half-width">'+
                '<input class="form-control" type="text" name="additional_features['+numVal+'][fave_additional_feature_title]" id="fave_additional_feature_title_'+numVal+'" value="">'+
                '</td>'+
                '<td class="table-half-width">'+
                '<input class="form-control" type="text" name="additional_features['+numVal+'][fave_additional_feature_value]" id="fave_additional_feature_value_'+numVal+'" value="">'+
                '</td>'+
                '<td class="">'+
                '<a class="sort-additional-row btn btn-light-grey-outlined"><i class="houzez-icon icon-navigation-menu"></i></a>'+
                '</td>'+
                '<td>'+
                '<button data-remove="'+numVal+'" class="remove-additional-row btn btn-light-grey-outlined"><i class="houzez-icon icon-close"></i></button>'+
                '</td>'+
                '</tr>';

            $( '#houzez_additional_details_main').append( newAdditionalDetail );
            removeAdditionalDetails();
        });

        var removeAdditionalDetails = function (){

            $( '.remove-additional-row').click(function( event ){
                event.preventDefault();
                var $this = $( this );
                $this.closest( 'tr' ).remove();
            });
        }
        removeAdditionalDetails();

        /* ------------------------------------------------------------------------ */
        /*	Floor Plans
         /* ------------------------------------------------------------------------ */
        
        $( '#add-floorplan-row' ).click(function( e ){
            e.preventDefault();

            var numVal = $(this).data("increment") + 1;
            $(this).data('increment', numVal);
            $(this).attr({
                "data-increment" : numVal
            });

            var newFloorPlan = '' +
                '<div class="houzez-floorplan-clone">'+
                '<div class="row">'+
                '<div class="col-md-12 col-sm-12">'+
                '<div class="remove-floorplan-row" data-remove="'+numVal+'">'+
                    '<i class="houzez-icon icon-remove-circle mr-2"></i>'+
                '</div>'+
                '<div class="form-group">'+
                '<label for="floor_plans['+numVal+'][fave_plan_title]">'+plan_title_text+'</label>'+
                '<input name="floor_plans['+numVal+'][fave_plan_title]" type="text" id="fave_plan_title_'+numVal+'" class="form-control">'+
                '</div>'+
                '</div>'+
                '<div class="col-md-6 col-sm-12">'+
                '<div class="form-group">'+
                '<label for="floor_plans['+numVal+'][fave_plan_rooms]">'+plan_bedrooms_text+'</label>'+
                '<input name="floor_plans['+numVal+'][fave_plan_rooms]" type="text" id="fave_plan_rooms_'+numVal+'" class="form-control">'+
                '</div>'+
                '</div>'+
                '<div class="col-md-6 col-sm-12">'+
                '<div class="form-group">'+
                '<label for="floor_plans['+numVal+'][fave_plan_bathrooms]">'+plan_bathrooms_text+'</label>'+
                '<input name="floor_plans['+numVal+'][fave_plan_bathrooms]" type="text" id="fave_plan_bathrooms_'+numVal+'" class="form-control">'+
                '</div>'+
                '</div>'+
                '<div class="col-md-6 col-sm-12">'+
                '<div class="form-group">'+
                '<label for="floor_plans['+numVal+'][fave_plan_price]">'+plan_price_text+'</label>'+
                '<input name="floor_plans['+numVal+'][fave_plan_price]" type="text" id="fave_plan_price_'+numVal+'" class="form-control">'+
                '</div>'+
                '</div>'+
                '<div class="col-md-6 col-sm-12">'+
                '<div class="form-group">'+
                '<label for="floor_plans['+numVal+'][fave_plan_price_postfix]">'+plan_price_postfix_text+'</label>'+
                '<input name="floor_plans['+numVal+'][fave_plan_price_postfix]" type="text" id="fave_plan_price_postfix_'+numVal+'" class="form-control">'+
                '</div>'+
                '</div>'+
                '<div class="col-md-6 col-sm-12">'+
                '<div class="form-group">'+
                '<label for="floor_plans['+numVal+'][fave_plan_size]">'+plan_size_text+'</label>'+
                '<input name="floor_plans['+numVal+'][fave_plan_size]" type="text" id="fave_plan_size_'+numVal+'" class="form-control">'+
                '</div>'+
                '</div>'+
                '<div class="col-md-6 col-sm-12">'+
                '<div class="form-group">'+
                '<label for="floor_plans['+numVal+'][fave_plan_image]">'+plan_image_text+'</label>'+
                '<div class="d-flex align-items-start">'+
                '<img class="floor-thumb img-fluid" src="https://placehold.it/100x75" width="100" height="75" alt="thumb">'+
                '<div class="ml-2">'+
                '<a href="#" id="floorplan-file-select-'+numVal+'" class="floorplan-file-select btn btn-primary btn-full-width">'+plan_upload_text+'</a>'+
                '<input name="floor_plans['+numVal+'][fave_plan_image]" type="hidden" id="fave_plan_image_'+numVal+'" class="fave_plan_image form-control" value="">'+
                '<small class="form-text text-muted">'+houzezProperty.plan_upload_size+'</small>'+
                '<div class="errors-log"></div>'+
                '<div class="progress houzez-hidden"></div>'+
                '</div>'+
                '</div>'+
                '</div>'+
                '</div>'+
                '<div class="col-md-12 col-sm-12">'+
                '<div class="form-group">'+
                '<label for="floor_plans['+numVal+'][fave_plan_description]">'+plan_description_text+'</label>'+
                '<textarea name="floor_plans['+numVal+'][fave_plan_description]" rows="4" id="fave_plan_description_'+numVal+'" class="form-control"></textarea>'+
                '</div>'+
                '</div>'+
                '</div>'+
                '<hr>'+
                '</div>';

            $( '#houzez_floor_plans_main').append( newFloorPlan );
            removeFloorPlans();
            bindFloorPlanEvents();
        });

        var removeFloorPlans = function (){

            $( '.remove-floorplan-row').click(function( event ){
                event.preventDefault();
                var $this = $( this );
                $this.parents( '.houzez-floorplan-clone' ).remove();
            });
        }
        removeFloorPlans();


        /* ------------------------------------------------------------------------ */
        /*	Multi Units
         /* ------------------------------------------------------------------------ */
        $( '#add-subproperty-row' ).click(function( e ){
            e.preventDefault();

            var numVal = $(this).data("increment") + 1;
            $(this).data('increment', numVal);
            $(this).attr({
                "data-increment" : numVal
            });

            var newSubProperty = '' +
                '<div class="houzez-units-clone">'+
                '<div class="row">'+
                '<div class="col-md-12 col-sm-12">'+
                '<div class="remove-subproperty-row" data-remove="'+numVal+'">'+
                '<i class="houzez-icon icon-remove-circle mr-2"></i>'+
                '</div>'+
                '<div class="form-group">'+
                '<label for="fave_multi_units['+numVal+'][fave_mu_title]">'+mu_title_text+'</label>'+
                '<input name="fave_multi_units['+numVal+'][fave_mu_title]" type="text" class="form-control">'+
                '</div>'+
                '</div>'+
                '<div class="col-md-6 col-sm-12">'+
                '<div class="form-group">'+
                '<label for="fave_multi_units['+numVal+'][fave_mu_beds]">'+mu_beds_text+'</label>'+
                '<input name="fave_multi_units['+numVal+'][fave_mu_beds]" type="text" class="form-control">'+
                '</div>'+
                '</div>'+
                '<div class="col-md-6 col-sm-12">'+
                '<div class="form-group">'+
                '<label for="fave_multi_units['+numVal+'][fave_mu_baths]">'+mu_baths_text+'</label>'+
                '<input name="fave_multi_units['+numVal+'][fave_mu_baths]" type="text" class="form-control">'+
                '</div>'+
                '</div>'+
                '<div class="col-md-6 col-sm-12">'+
                '<div class="form-group">'+
                '<label for="fave_multi_units['+numVal+'][fave_mu_size]">'+mu_size_text+'</label>'+
                '<input name="fave_multi_units['+numVal+'][fave_mu_size]" type="text" class="form-control">'+
                '</div>'+
                '</div>'+
                '<div class="col-md-6 col-sm-12">'+
                '<div class="form-group">'+
                '<label for="fave_multi_units['+numVal+'][fave_mu_size_postfix]">'+mu_size_postfix_text+'</label>'+
                '<input name="fave_multi_units['+numVal+'][fave_mu_size_postfix]" type="text" class="form-control">'+
                '</div>'+
                '</div>'+
                '<div class="col-md-6 col-sm-12">'+
                '<div class="form-group">'+
                '<label for="fave_multi_units['+numVal+'][fave_mu_price]">'+mu_price_text+'</label>'+
                '<input name="fave_multi_units['+numVal+'][fave_mu_price]" type="text" class="form-control">'+
                '</div>'+
                '</div>'+
                '<div class="col-md-6 col-sm-12">'+
                '<div class="form-group">'+
                '<label for="fave_multi_units['+numVal+'][fave_mu_price_postfix]">'+mu_price_postfix_text+'</label>'+
                '<input name="fave_multi_units['+numVal+'][fave_mu_price_postfix]" type="text" class="form-control">'+
                '</div>'+
                '</div>'+
                '<div class="col-md-6 col-sm-12">'+
                '<div class="form-group">'+
                '<label for="fave_multi_units['+numVal+'][fave_mu_type]">'+mu_type_text+'</label>'+
                '<input name="fave_multi_units['+numVal+'][fave_mu_type]" type="text" class="form-control">'+
                '</div>'+
                '</div>'+
                '<div class="col-md-6 col-sm-12">'+
                '<div class="form-group">'+
                '<label for="fave_multi_units['+numVal+'][fave_mu_availability_date]">'+mu_availability_text+'</label>'+
                '<input name="fave_multi_units['+numVal+'][fave_mu_availability_date]" type="text" class="form-control">'+
                '</div>'+
                '</div>'+
                '</div>'+
                '<hr>'+
                '</div>';

            $( '#multi_units_main').append( newSubProperty );
            removeSubProperty();
        });

        var removeSubProperty = function (){

            $( '.remove-subproperty-row').click(function( event ){
                event.preventDefault();
                var $this = $( this );
                $this.parents( '.houzez-units-clone' ).remove();
            });
        }
        removeSubProperty();

        /* ------------------------------------------------------------------------ */
        /*	Property attachment delete
         /* ------------------------------------------------------------------------ */
        var propertyAttachmentEvents = function() {

            $( "#houzez_attachments_container" ).sortable({
                revert: 100,
                placeholder: "attachments-placeholder",
                handle: ".sort-attachment",
                cursor: "move"
            });

            //Remove Image
            $('.attachment-delete').on('click', function(e){
                e.preventDefault();
                var $this = $(this);
                var thumbnail = $this.closest('.attach-thumb');
                var loader = $this.siblings('.icon-loader');
                var prop_id = $this.data('attach-id');
                var thumb_id = $this.data('attachment-id');

                loader.show();

                var ajax_request = $.ajax({
                    type: 'post',
                    url: ajax_url,
                    dataType: 'json',
                    data: {
                        'action': 'houzez_remove_property_thumbnail',
                        'prop_id': prop_id,
                        'thumb_id': thumb_id,
                        'removeNonce': verify_nonce
                    }
                });

                ajax_request.done(function( response ) {
                    if ( response.remove_attachment ) {
                        thumbnail.remove();
                    } else {

                    }
                });

                ajax_request.fail(function( jqXHR, textStatus ) {
                    alert( "Request failed: " + textStatus );
                });

            });

        }
        propertyAttachmentEvents();

        /* ------------------------------------------------------------------------ */
        /*	Property Thumbnails actions ( make features & delete )
         /* ------------------------------------------------------------------------ */
        var propertyThumbnailEvents = function() {

            // Set Featured Image
            $('.icon-featured').click(function(e){
                e.preventDefault();

                var $this = jQuery(this);
                var thumb_id = $this.data('attachment-id');
                

                $('.property-thumb .featured_image_id').remove();
                $('.property-thumb .icon-featured').removeClass('text-success');

                $this.closest('.property-thumb').append('<input type="hidden" class="featured_image_id" name="featured_image_id" value="'+thumb_id+'">');
                $this.addClass('text-success');
            });

            //Remove Image
            $('.icon-delete').click(function(e){
                e.preventDefault();

                var $this = $(this);
                var thumbnail = $this.closest('.property-thumb');
                var loader = $this.siblings('.icon-loader');
                var prop_id = $this.data('property-id');
                var thumb_id = $this.data('attachment-id');

                loader.show();

                var ajax_request = $.ajax({
                    type: 'post',
                    url: ajax_url,
                    dataType: 'json',
                    data: {
                        'action': 'houzez_remove_property_thumbnail',
                        'prop_id': prop_id,
                        'thumb_id': thumb_id,
                        'removeNonce': verify_nonce
                    },
                    beforeSend: function( ) {
                        $this.find('.houzez-loader-js').addClass('loader-show');
                    },
                });

                ajax_request.done(function( response ) {
                    if ( response.remove_attachment ) {
                        thumbnail.remove();
                    } else {

                    }
                });

                ajax_request.fail(function( jqXHR, textStatus ) {
                    alert( "Request failed: " + textStatus );
                });

            });

        }

        propertyThumbnailEvents();

        // Property Gallery images
        var property_gallery_images = function() {

            $( "#houzez_property_gallery_container" ).sortable({
                placeholder: "sortable-placeholder"
            });

            var plup_uploader = new plupload.Uploader({
                browse_button: 'select_gallery_images',
                file_data_name: 'property_upload_file',
                container: 'houzez_gallery_dragDrop',
                drop_element: 'houzez_gallery_dragDrop',
                url: ajax_url + "?action=houzez_property_img_upload&verify_nonce=" + verify_nonce,
                filters: {
                    mime_types : [
                        { title : verify_file_type, extensions : "jpg,jpeg,gif,png" }
                    ],
                    max_file_size: image_max_file_size,
                    prevent_duplicates: false
                }
            });
            plup_uploader.init();

            plup_uploader.bind('FilesAdded', function(up, files) {
                var houzez_thumbs = "";
                var maxfiles = max_prop_images;
                if(up.files.length > maxfiles ) {
                    up.splice(maxfiles);
                    alert('no more than '+maxfiles + ' file(s)');
                    return;
                }
                plupload.each(files, function(file) {
                    houzez_thumbs += '<div id="thumb-holder-' + file.id + '" class="col-md-2 col-sm-4 col-6 property-thumb">' + '' + '</div>';
                });
                document.getElementById('houzez_property_gallery_container').innerHTML += houzez_thumbs;
                up.refresh();
                plup_uploader.start();
            });


            plup_uploader.bind('UploadProgress', function(up, file) {
                document.getElementById( "thumb-holder-" + file.id ).innerHTML = '<span>' + file.percent + "%</span>";
            });

            plup_uploader.bind('Error', function( up, err ) {
                document.getElementById('houzez_errors').innerHTML += "<br/>" + "Error #" + err.code + ": " + err.message;
            });

            plup_uploader.bind('FileUploaded', function ( up, file, ajax_response ) {
                var response = $.parseJSON( ajax_response.response );

                if ( response.success ) {

                    var gallery_thumbnail = '<img class="img-fluid" src="' + response.url + '" alt="" />' +
                        '<div class="upload-gallery-thumb-buttons">'+
                        '<button class="icon icon-fav icon-featured" data-property-id="'+ 0 +'" data-attachment-id="' + response.attachment_id + '"><i class="houzez-icon icon-rating-star full-star"></i></button>'+
                        '<button class="icon icon-delete" data-property-id="'+ 0 +'" data-attachment-id="' + response.attachment_id + '"><span class="btn-loader houzez-loader-js"></span><i class="houzez-icon icon-remove-circle"></i></button>'+
                        '</div>'+
                        '<input type="hidden" class="propperty-image-id" name="propperty_image_ids[]" value="' + response.attachment_id + '"/>';

                    document.getElementById( "thumb-holder-" + file.id ).innerHTML = gallery_thumbnail;

                    propertyThumbnailEvents();

                } else {
                    console.log ( response );
                }
            });

        }
        property_gallery_images();


        //Js for property attachments upload
        var houzez_property_attachments = function() {

            var atch_uploader = new plupload.Uploader({
                browse_button: 'select_attachments',
                file_data_name: 'property_attachment_file',
                url: ajax_url + "?action=houzez_property_attachment_upload&verify_nonce=" + verify_nonce,
                filters: {
                    mime_types : [
                        { title : verify_file_type, extensions : "jpg,jpeg,png,pdf,zip" }
                    ],
                    max_file_size: attachment_max_file_size,
                    prevent_duplicates: true
                }
            });
            atch_uploader.init();

            atch_uploader.bind('FilesAdded', function(up, files) {
                var houzez_thumbs = "";
                var maxfiles = max_prop_attachments;
                if(up.files.length > maxfiles ) {
                    up.splice(maxfiles);
                    alert('no more than '+maxfiles + ' file(s)');
                    return;
                }
                plupload.each(files, function(file) {
                    houzez_thumbs += '<tr id="attachment-holder-' + file.id + '" class="attach-thumb">' + '' + '</tr>';
                });
                document.getElementById('houzez_attachments_container').innerHTML += houzez_thumbs;
                up.refresh();
                atch_uploader.start();
            });


            atch_uploader.bind('UploadProgress', function(up, file) {
                document.getElementById( "attachment-holder-" + file.id ).innerHTML = '<span>' + file.percent + "%</span>";
            });

            atch_uploader.bind('Error', function( up, err ) {
                document.getElementById('houzez_atach_errors').innerHTML += "<br/>" + "Error #" + err.code + ": " + err.message;
            });

            atch_uploader.bind('FileUploaded', function ( up, file, ajax_response ) {
                var response = $.parseJSON( ajax_response.response );

                if ( response.success ) {

                    var attachment_file = ''+
                        '<td class="table-full-width table-cell-title">'+
                            '<span>'+ response.attach_title +'</span>'+
                        '</td>'+
                        '<td>'+
                            '<a href="'+ response.url +'" target="_blank" class="btn btn-light-grey-outlined"><i class="houzez-icon icon-download-bottom"></i></a>'+
                        '</td>'+
                        '<td>'+
                            '<button data-attach-id="' + 0 + '"  data-attachment-id="' + response.attachment_id + '" class="attachment-delete btn btn-light-grey-outlined"><i class="houzez-icon icon-close"></i></button>'+
                        '</td>'+
                        '<td class="sort-attachment">'+
                            '<a class="btn btn-light-grey-outlined"><i class="houzez-icon icon-navigation-menu"></i></a>'+
                        '</td>'+
                        '<input type="hidden" class="propperty-attach-id" name="propperty_attachment_ids[]" value="' + response.attachment_id + '"/>';

                    document.getElementById( "attachment-holder-" + file.id ).innerHTML = attachment_file;

                    propertyAttachmentEvents();

                } else {
                    console.log ( response );
                }
            });

        }
        houzez_property_attachments();


        // Property Gallery images
        var floorPlanImage = function($button) {

            var $button = $button || 'floorplan-file-select';
            var $this = $("#" + $button);
            
            var parent = $this.parents(".houzez-floorplan-clone");
            var uploadErrors = parent.find(".errors-log");
            
            var uploader_floor = new plupload.Uploader({
                browse_button: $button,
                file_data_name: 'property_upload_file',
                url: ajax_url + "?action=houzez_property_img_upload&verify_nonce=" + verify_nonce,
                multi_selection: false,
                filters: {
                    mime_types : [
                        { title : verify_file_type, extensions : "jpg,jpeg,gif,pdf,png" }
                    ],
                    max_file_size: '12000kb',
                    prevent_duplicates: true
                }
            });
            uploader_floor.init();

            uploader_floor.bind('FilesAdded', function(up, files) {
                var maxfiles = max_prop_images;
                if(up.files.length > maxfiles ) {
                    up.splice(maxfiles);
                    alert('no more than '+maxfiles + ' file(s)');
                    return;
                }
                plupload.each(files, function(file) {
                });
                up.refresh();
                uploader_floor.start();
            });

            uploader_floor.bind('UploadProgress', function(up, file) {
                parent.find(".progress").removeClass('houzez-hidden');
                parent.find(".progress").html('<div class="progress-bar" role="progressbar" style="width: '+ file.percent +'%" aria-valuenow="'+ file.percent +'" aria-valuemin="0" aria-valuemax="100"></div>');
            });

            uploader_floor.bind('Error', function( up, err ) {
                uploadErrors.html("Error #" + err.code + ": " + err.message);
            });

            uploader_floor.bind('FileUploaded', function ( up, file, ajax_response ) {
                var response = $.parseJSON( ajax_response.response );

                if ( response.success ) {
                    uploadErrors.html("");
                    parent.find(".fave_plan_image").val(response.full_image);
                    parent.find(".floor-thumb").attr('src',response.full_image);
                    parent.find(".progress").html("");
                    parent.find(".progress").addClass('houzez-hidden');
                } else {
                    console.log ( response );
                    uploadErrors.html(response.reason);
                    parent.find(".floor-thumb").attr('src','');
                    parent.find(".progress").html("");
                    parent.find(".progress").addClass('houzez-hidden');
                }
            });

        }
        
        var bindFloorPlanEvents = function () {
            var $houzezFloorplanClone = $(".houzez-floorplan-clone");

            $.each($houzezFloorplanClone, function( index, value ) {
                var browseButton = $(value).find('.floorplan-file-select').attr("id");
                floorPlanImage(browseButton);
            });
        };
        bindFloorPlanEvents();


        /*--------------------------------------------------------------------------
         *  Property Thread Message Attachment
         * -------------------------------------------------------------------------*/
        var thread_message_attachment = function() {

            /* initialize uploader */
            var uploader = new plupload.Uploader({
                browse_button: 'thread-message-attachment',
                file_data_name: 'messages_upload_file',
                container: 'property-thumbs-container',
                //drop_element: 'drag-and-drop-messages',
                multi_selection: true,
                url: ajax_url + "?action=houzez_message_attacment_upload&verify_nonce=" + verify_nonce,
                filters: {

                    max_file_size: image_max_file_size,
                    prevent_duplicates: true
                }
            });
            uploader.init();

            uploader.bind('FilesAdded', function(up, files) {
                var html = '';
                var propertyThumb = "";
                var maxfiles = max_prop_images;
                if(up.files.length > maxfiles ) {
                    up.splice(maxfiles);
                    alert('no more than '+maxfiles + ' file(s)');
                    return;
                }
                plupload.each(files, function(file) {
                    propertyThumb += '<div id="thumb-holder-' + file.id + '" class="property-thumb">' + '' + '</div>';
                });
                document.getElementById('property-thumbs-container').innerHTML += propertyThumb;
                up.refresh();
                uploader.start();
            });


            uploader.bind('UploadProgress', function(up, file) {
                document.getElementById( "thumb-holder-" + file.id ).innerHTML = '<li><lable>' + file.name + '<span>' + file.percent + "%</span></lable></li>";
            });

            uploader.bind('Error', function( up, err ) {
                document.getElementById('errors-log').innerHTML += "<br/>" + "Error #" + err.code + ": " + err.message;
            });

            uploader.bind('FileUploaded', function ( up, file, ajax_response ) {
                var response = $.parseJSON( ajax_response.response );

                if ( response.success ) {

                    console.log( ajax_response );

                    var message_html = '<li>' +
                        '<div class="attach-icon delete-attachment">' +
                        '<i class="fa fa-trash remove-message-attachment" data-attachment-id="' + response.attachment_id + '"></i>' +
                        '</div>' +
                        '<span class="attach-text">' + response.file_name + '</span>' +
                        '<input type="hidden" class="propperty-image-id" name="propperty_image_ids[]" value="' + response.attachment_id + '"/>' +
                        '</li>';

                    document.getElementById( "thumb-holder-" + file.id ).innerHTML = message_html;

                    messageAttachment();
                    thread_message_attachment();

                } else {
                    console.log ( response );
                    alert('error');
                }
            });

            uploader.refresh();

        }
        thread_message_attachment();

        var messageAttachment = function() {

            $( '.remove-message-attachment' ).on( 'click', function () {

                var $this = $(this);
                var thumbnail = $this.closest('li');
                var thumb_id = $this.data('attachment-id');
                $this.removeClass( 'fa-trash' );
                $this.addClass( 'fa-spinner' );

                var ajax_request = $.ajax({
                    type: 'post',
                    url: ajax_url,
                    dataType: 'json',
                    data: {
                        'action': 'houzez_remove_message_attachment',
                        'thumbnail_id': thumb_id,
                    }
                });

                ajax_request.done(function( response ) {
                    if ( response.attachment_remove ) {
                        thumbnail.remove();
                    } else {

                    }
                    thread_message_attachment();
                });

                ajax_request.fail(function( jqXHR, textStatus ) {
                    alert( "Request failed: " + textStatus );
                });

            });

        }

        $('.houzez_delete_msg_thread').on('click', function(e) {
            e.preventDefault();

            var $this = $( this );
            var thread_id = $this.data('thread-id');
            var sender_id = $this.data('sender-id');
            var receiver_id = $this.data('receiver-id');

            bootbox.confirm({
                message: "<p><strong>"+are_you_sure_text+"</strong></p>",
                buttons: {
                    confirm: {
                        label: delete_btn_text,
                        className: 'btn btn-primary'
                    },
                    cancel: {
                        label: cancel_btn_text,
                        className: 'btn btn-grey-outlined'
                    }
                },
                callback: function (result) {
         
                    if(result==true) {
                        fave_processing_modal( processing_text );

                        $.ajax({
                            type: 'POST',
                            dataType: 'json',
                            url: ajax_url,
                            data: {
                                'action': 'houzez_delete_message_thread',
                                'thread_id': thread_id,
                                'sender_id': sender_id,
                                'receiver_id': receiver_id
                            },
                            beforeSend: function( ) {
                               
                            },
                            success: function(data) {
                                if ( data.success == true ) {
                                    window.location.reload();
                                } else {
                                    jQuery('#fave_modal').modal('hide');
                                }
                            },
                            error: function(errorThrown) {

                            }
                        }); // $.ajax
                    } // result
                } // Callback
            });

        });

        $('.houzez_delete_message').on('click', function(e) {
            e.preventDefault();

            var $this = $( this );
            var message_id = $this.data('message-id');
            var created_by = $this.data('created-by');

            bootbox.confirm({
                message: "<p><strong>"+are_you_sure_text+"</strong></p>",
                buttons: {
                    confirm: {
                        label: delete_btn_text,
                        className: 'btn btn-primary'
                    },
                    cancel: {
                        label: cancel_btn_text,
                        className: 'btn btn-grey-outlined'
                    }
                },
                callback: function (result) {
         
                    if(result==true) {
                        fave_processing_modal( processing_text );

                        $.ajax({
                            type: 'POST',
                            dataType: 'json',
                            url: ajax_url,
                            data: {
                                'action': 'houzez_delete_message',
                                'message_id': message_id,
                                'created_by': created_by
                            },
                            beforeSend: function( ) {
                                
                            },
                            success: function(data) {
                                if ( data.success == true ) {
                                    window.location.reload();
                                } else {
                                    jQuery('#fave_modal').modal('hide');
                                }
                            },
                            error: function(errorThrown) {

                            }
                        }); // $.ajax
                    } // result
                } // Callback
            });

        });

        /*--------------------------------------------------------------------------
         * Delete Saved Search
         * --------------------------------------------------------------------------*/
        $('.remove-search').on('click', function(e) {
            e.preventDefault();
            var $this = $(this);
            var prop_id = $this.data('propertyid');
            var removeBlock = $this.parents('.saved-search-block');
            $this.parents('tr').remove();

            $.ajax({
                url: ajax_url,
                dataType: 'JSON',
                method: 'POST',
                data: {
                    'action': 'houzez_delete_search',
                    'property_id': prop_id
                },
                beforeSend: function () {
                },
                success: function (res) {
                    if (res.success) {
                    }
                },
                error: function (xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    console.log(err.Message);
                }
            });
        });

        /*--------------------------------------------------------------------------
         * login register toggle for property submission
         * --------------------------------------------------------------------------*/
        var login_here = $('.login-here');
        var register_here = $('.register-here');
        var step_login = $('.step-tab-login');
        var step_register = $('.step-tab-register');
        $('.step-login-btn a').on('click',function (e) {
            var this_login = $(this);
           if(this_login.hasClass('login-here')){
               this_login.hide();
               register_here.show();
               step_login.show();
               step_register.hide();
               $('#submit_property_form').append('<input type="hidden" name="login_while_submission" id="login_while_submission" value="1">');
           }else{
               this_login.hide();
               login_here.show();
               step_login.hide();
               step_register.show();
               $('#login_while_submission').remove();
           }
           e.preventDefault();
        });

        /* ------------------------------------------------------------------------ */
        /*  Top Browsers
         /* ------------------------------------------------------------------------ */
        if( $('#top-browsers-doughnut-chart').length > 0 ) { 
            var chartData = $('#top-browsers-doughnut-chart').data('chart');
            var ctx = document.getElementById('top-browsers-doughnut-chart').getContext('2d');
            var myDoughnutChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: chartData,
                        backgroundColor: [
                        'rgba(255, 99, 132, 0.5)',
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(255, 206, 86, 0.5)',
                        'rgba(75, 192, 192, 0.5)'
                        ],
                        borderColor: [
                        'rgba(255 ,99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    cutoutPercentage: 60,
                    responsive: false,
                    tooltips: false,
                }
            });
        }

        /* ------------------------------------------------------------------------ */
        /*  Top Devices
         /* ------------------------------------------------------------------------ */
        if( $('#devices-doughnut-chart').length > 0 ) { 
            var chartData = $('#devices-doughnut-chart').data('chart');
            var ctx = document.getElementById('devices-doughnut-chart').getContext('2d');
            var myDoughnutChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: chartData,
                        backgroundColor: [
                        'rgba(255, 99, 132, 0.5)',
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(255, 206, 86, 0.5)',
                        'rgba(75, 192, 192, 0.5)'
                        ],
                        borderColor: [
                        'rgba(255 ,99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    cutoutPercentage: 60,
                    responsive: false,
                    tooltips: false,
                }
            });
        }

        /* ------------------------------------------------------------------------ */
        /*  Top Countries
         /* ------------------------------------------------------------------------ */
        if( $('#top-countries-doughnut-chart').length > 0 ) { 
            var chartData = $('#top-countries-doughnut-chart').data('chart');
            var ctx = document.getElementById('top-countries-doughnut-chart').getContext('2d');
            var myDoughnutChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: chartData,
                        backgroundColor: [
                        'rgba(255, 99, 132, 0.5)',
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(255, 206, 86, 0.5)',
                        'rgba(75, 192, 192, 0.5)'
                        ],
                        borderColor: [
                        'rgba(255 ,99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    cutoutPercentage: 60,
                    responsive: false,
                    tooltips: false,
                }
            });
        }

        /* ------------------------------------------------------------------------ */
        /*  Top Platforms
         /* ------------------------------------------------------------------------ */
        if( $('#top-platforms-doughnut-chart').length > 0 ) { 
            var chartData = $('#top-platforms-doughnut-chart').data('chart');
            var ctx = document.getElementById('top-platforms-doughnut-chart').getContext('2d');
            var myDoughnutChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: chartData,
                        backgroundColor: [
                        'rgba(255, 99, 132, 0.5)',
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(255, 206, 86, 0.5)',
                        'rgba(75, 192, 192, 0.5)'
                        ],
                        borderColor: [
                        'rgba(255 ,99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    cutoutPercentage: 60,
                    responsive: false,
                    tooltips: false,
                }
            });
        }

        /* ------------------------------------------------------------------------ */
        /*  24 Hours Visits Chart
         /* ------------------------------------------------------------------------ */
        var visits_chart_24h = $('#visits-chart-24h');

        if( visits_chart_24h.length > 0 ) {

            var labels = visits_chart_24h.data('labels');
            var views = visits_chart_24h.data('views');
            var unique = visits_chart_24h.data('unique');
            var visit_label = visits_chart_24h.data('visit-label');
            var unique_label = visits_chart_24h.data('unique-label');

            var ctx = document.getElementById('visits-chart-24h').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: visit_label,
                        data: views,
                        backgroundColor: [
                        'rgba(255, 99, 132, 0.1)',
                        ],
                        borderColor: [
                        'rgba(255, 99, 132, 1)',
                        ],
                        borderWidth: 2
                    },{
                        label: unique_label,
                        data: unique,
                        backgroundColor: [
                        'rgba(54, 162, 235, 0.3)',
                        ],
                        borderColor: [
                        //'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        ],
                        borderWidth: 2
                    }]
                },
                options: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            boxWidth: 12
                        },
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                            },
                            gridLines: {
                                display: true
                            }
                        }],
                        xAxes: [{
                            gridLines: {
                                display: false
                            }
                        }]
                    },
                    tooltips: {
                        callbacks: {
                            labelColor: function(tooltipItem, chart) {
                                return {
                                    borderColor: 'rgb(255, 99, 132, 1)',
                                    backgroundColor: 'rgb(255, 99, 132, 1)'
                                };
                            },
                            labelTextColor: function(tooltipItem, chart) {
                                return '#fff';
                            }
                        }
                    }
                }
            });
        }

        /* ------------------------------------------------------------------------ */
        /*  7 days Visits Chart
         /* ------------------------------------------------------------------------ */
        var visits_chart_7d = $('#visits-chart-7d');

        if( visits_chart_7d.length > 0 ) {

            var labels_7d = visits_chart_7d.data('labels');
            var views_7d = visits_chart_7d.data('views');
            var unique_7d = visits_chart_7d.data('unique');
            var visit_label_7d = visits_chart_7d.data('visit-label');
            var unique_label_7d = visits_chart_7d.data('unique-label');

            var ctx = document.getElementById('visits-chart-7d').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels_7d,
                    datasets: [{
                        label: visit_label_7d,
                        data: views_7d,
                        backgroundColor: [
                        'rgba(255, 99, 132, 0.1)',
                        ],
                        borderColor: [
                        'rgba(255, 99, 132, 1)',
                        ],
                        borderWidth: 2
                    },{
                        label: unique_label_7d,
                        data: unique_7d,
                        backgroundColor: [
                        'rgba(54, 162, 235, 0.3)',
                        ],
                        borderColor: [
                        //'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        ],
                        borderWidth: 2
                    }]
                },
                options: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            boxWidth: 12
                        },
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                            },
                            gridLines: {
                                display: true
                            }
                        }],
                        xAxes: [{
                            gridLines: {
                                display: false
                            }
                        }]
                    },
                    tooltips: {
                        callbacks: {
                            labelColor: function(tooltipItem, chart) {
                                return {
                                    borderColor: 'rgb(255, 99, 132, 1)',
                                    backgroundColor: 'rgb(255, 99, 132, 1)'
                                };
                            },
                            labelTextColor: function(tooltipItem, chart) {
                                return '#fff';
                            }
                        }
                    }
                }
            });
        }

        /* ------------------------------------------------------------------------ */
        /*  7 days Visits Chart
         /* ------------------------------------------------------------------------ */
        var visits_chart_30d = $('#visits-chart-30d');

        if( visits_chart_30d.length > 0 ) {

            var labels_30d = visits_chart_30d.data('labels');
            var views_30d = visits_chart_30d.data('views');
            var unique_30d = visits_chart_30d.data('unique');
            var visit_label_30d = visits_chart_30d.data('visit-label');
            var unique_label_30d = visits_chart_30d.data('unique-label');

            var ctx = document.getElementById('visits-chart-30d').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels_30d,
                    datasets: [{
                        label: visit_label_30d,
                        data: views_30d,
                        backgroundColor: [
                        'rgba(255, 99, 132, 0.1)',
                        ],
                        borderColor: [
                        'rgba(255, 99, 132, 1)',
                        ],
                        borderWidth: 2
                    },{
                        label: unique_label_30d,
                        data: unique_30d,
                        backgroundColor: [
                        'rgba(54, 162, 235, 0.3)',
                        ],
                        borderColor: [
                        //'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        ],
                        borderWidth: 2
                    }]
                },
                options: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            boxWidth: 12
                        },
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                            },
                            gridLines: {
                                display: true
                            }
                        }],
                        xAxes: [{
                            gridLines: {
                                display: false
                            }
                        }]
                    },
                    tooltips: {
                        callbacks: {
                            labelColor: function(tooltipItem, chart) {
                                return {
                                    borderColor: 'rgb(255, 99, 132, 1)',
                                    backgroundColor: 'rgb(255, 99, 132, 1)'
                                };
                            },
                            labelTextColor: function(tooltipItem, chart) {
                                return '#fff';
                            }
                        }
                    }
                }
            });
        }

        var deals_doughnut_chart = $('#deals-doughnut-chart');
        if( deals_doughnut_chart.length > 0 ) {

            var active_deals = deals_doughnut_chart.data('active');
            var won_deals = deals_doughnut_chart.data('won');
            var lost_deals = deals_doughnut_chart.data('lost');

            var ctx = document.getElementById('deals-doughnut-chart').getContext('2d');
            var myDoughnutChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: [active_deals, won_deals, lost_deals],
                        backgroundColor: [
                        'rgba(255, 206, 86, 0.5)',
                        'rgba(75, 192, 192, 0.5)',
                        'rgba(255, 99, 132, 0.5)',                          
                        ],
                        borderColor: [
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(255 ,99, 132, 1)',
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    cutoutPercentage: 60,
                    responsive: false,
                    tooltips: false,
                }
            });
        }


    }

});