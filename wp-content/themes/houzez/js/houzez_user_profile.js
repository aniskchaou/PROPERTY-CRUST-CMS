jQuery(document).ready(function($) {

    "use strict";


    if ( typeof houzezUserProfile !== "undefined" ) {

        var user_id = houzezUserProfile.user_id;
        var ajaxURL = houzezUserProfile.ajaxURL;
        var houzez_upload_nonce = houzezUserProfile.houzez_upload_nonce;
        var verify_file_type = houzezUserProfile.verify_file_type;
        var houzez_site_url = houzezUserProfile.houzez_site_url;
        var gdpr_agree_text = houzezUserProfile.gdpr_agree_text;
        var processing_text = houzez_vars.processing_text;


        /*-------------------------------------------------------------------
         *  GDPR Request
         * ------------------------------------------------------------------*/
         $('#houzez_gdpr_form').on('submit', function(e) {
            e.preventDefault();
            var $this = $(this);
            var $messages = $('#gdpr-msg');

            var data = {
                'action' : 'houzez_gdrf_data_request',
                'gdpr_data_type' : $('input[name=gdrf_data_type]:checked', '#houzez_gdpr_form').val(),
                'gdrf_data_email' : $('#gdrf_data_email').val(),
                'gdrf_data_nonce' : $('#houzez_gdrf_data_nonce').val(),
            };
            
            $.ajax({
                type: 'POST',
                url: ajaxURL,
                data: data,
                beforeSend: function( ) {
                    $this.find('.houzez-loader-js').addClass('loader-show');
                },
                complete: function(){
                    $this.find('.houzez-loader-js').removeClass('loader-show');
                },
                success: function (res) {

                    if(res.success) {
                        $messages.empty().append('<div class="alert alert-success" role="alert">'+ res.data +'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    } else {
                        $messages.empty().append('<div class="alert alert-danger" role="alert">'+ res.data +'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    }

                },
                error: function(xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    console.log(err.Message);
                }
            });

         });

         /*-------------------------------------------------------------------
         *  Cancel Stripe
         * ------------------------------------------------------------------*/
        $('#houzez_stripe_cancel').click(function(){
            var stripe_user_id, cancel_msg;
            stripe_user_id = $(this).attr('data-stripeid');
            cancel_msg = $(this).attr('data-message');
            $('#stripe_cancel_success').text(processing_text);

            $.ajax({
                type: 'POST',
                url: ajaxURL,
                data: {
                    'action' : 'houzez_cancel_stripe'
                },
                success: function (data) {
                    $('#stripe_cancel_success').text(cancel_msg);
                },
                error: function (errorThrown) {
                }
            });
        });

        /*-------------------------------------------------------------------
         *  Register Agency agent
         * ------------------------------------------------------------------*/
        $('#houzez_agency_agent_register').on('click', function(e){
            e.preventDefault();

            var currnt = $(this);
            var $form = $(this).parents('form');
            var $messages = $('#aa_register_message');
            $messages.empty();

            $.ajax({
                type: 'post',
                url: ajaxURL,
                dataType: 'json',
                data: $form.serialize(),
                beforeSend: function () {
                    currnt.find('.houzez-loader-js').addClass('loader-show');
                },
                complete: function(){
                    currnt.find('.houzez-loader-js').removeClass('loader-show');
                },
                success: function( response ) {
                    if( response.success ) {
                        $('#aa_username, #aa_email, #aa_firstname, #aa_lastname, #aa_password').val('');
                        $messages.empty().append('<div class="alert alert-success" role="alert"><i class="houzez-icon icon-check-circle-1 mr-1"></i>'+ response.msg +'</div>');
                    } else {
                        $messages.empty().append('<div class="alert alert-danger" role="alert"><i class="houzez-icon icon-check-circle-1 mr-1"></i>'+ response.msg +'</div>');
                    }
                },
                error: function(xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    console.log(err.Message);
                }
            });
            return;
        });


        /*-------------------------------------------------------------------
         *  Register Agency agent update
         * ------------------------------------------------------------------*/
        $('#houzez_agency_agent_update').on('click', function(e){
            e.preventDefault();

            var currnt = $(this);
            var $form = $(this).parents('form');
            var $messages = $('#aa_register_message');

            $.ajax({
                type: 'post',
                url: ajaxURL,
                dataType: 'json',
                data: $form.serialize(),
                beforeSend: function () {
                    currnt.find('.houzez-loader-js').addClass('loader-show');
                },
                complete: function(){
                    currnt.find('.houzez-loader-js').removeClass('loader-show');
                },
                success: function( response ) {
                    if( response.success ) {
                        $messages.empty().append('<div class="alert alert-success" role="alert"><i class="houzez-icon icon-check-circle-1 mr-1"></i>'+ response.msg +'</div>');
                    } else {
                        $messages.empty().append('<div class="alert alert-danger" role="alert"><i class="houzez-icon icon-check-circle-1 mr-1"></i>'+ response.msg +'</div>');
                    }
                },
                error: function(xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    console.log(err.Message);
                }
            });
            return;
        });

        /*-------------------------------------------------------------------
         *  Update Profile [user_profile.php]
         * ------------------------------------------------------------------*/
        $(".houzez_update_profile").click( function(e) {
            e.preventDefault();

            var $this = $(this);
            var $form = $this.parents( 'form' );
            var $block = $this.parents( '.dashboard-content-block' );
            var $result = $block.find('.notify');

            var description = tinyMCE.get('about').getContent();
            

            var gdpr_agreement;

            if($('#gdpr_agreement').length > 0 ) {
                if(!$('#gdpr_agreement').is(":checked")) {
                    jQuery('#profile_message').empty().append('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-hide="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+gdpr_agree_text+'</div>');
                    $(".dashboard-content-area").animate({ scrollTop: 0 }, "slow");
                    return false;
                } else {
                    gdpr_agreement = 'checked';
                }
            } 

            $.ajax({
                url: ajaxURL,
                data: $form.serialize() + "&bio="+description,
                method: $form.attr('method'),
                dataType: "JSON",

                beforeSend: function( ) {
                    $this.find('.houzez-loader-js').addClass('loader-show');
                },
                success: function(data) { 
                    if( data.success ) {
                        $result.empty().append('<div class="alert alert-success alert-dismissible fade show" role="alert">'+data.msg+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    } else {
                        $result.empty().append('<div class="alert alert-danger alert-dismissible fade show" role="alert">'+data.msg+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    }
                },
                error: function(errorThrown) {

                },
                complete: function(){
                    $this.find('.houzez-loader-js').removeClass('loader-show');
                }
            });

        });

        /*-------------------------------------------------------------------
         *  Change Password [user-profile.php]
         * ------------------------------------------------------------------*/
        $("#houzez_change_pass").click( function(e) {
            e.preventDefault();
            var securitypassword, oldpass, newpass, confirmpass;

            var $this = $(this);
            newpass          = $("#newpass").val();
            confirmpass      = $("#confirmpass").val();
            securitypassword = $("#houzez-security-pass").val();

            $.ajax({
                type: 'POST',
                dataType: 'json',
                url:   ajaxURL,
                data: {
                    'action'      : 'houzez_ajax_password_reset',
                    'newpass'     : newpass,
                    'confirmpass' : confirmpass,
                    'houzez-security-pass' : securitypassword,
                },
                beforeSend: function( ) {
                    $this.find('.houzez-loader-js').addClass('loader-show');
                },
                success: function(data) {
                    if( data.success ) {
                        jQuery('#password_reset_msgs').empty().append('<p class="success text-success"><i class="fa fa-check"></i> '+ data.msg +'</p>');
                        jQuery('#newpass, #confirmpass').val('');
                    } else {
                        jQuery('#password_reset_msgs').empty().append('<p class="error text-danger"><i class="fas fa-times"></i> '+ data.msg +'</p>');
                    }
                },
                error: function(errorThrown) {

                },
                complete: function(){
                    $this.find('.houzez-loader-js').removeClass('loader-show');
                }
            });

        });

        $('#houzez_delete_account').click(function(e){
            e.preventDefault();

            var confirm = window.confirm("Are you sure!, you want to delete a account.");

            if ( confirm == true ) {

                $.ajax({
                    type: 'post',
                    url: ajaxURL,
                    dataType: 'json',
                    data: {
                        'action': 'houzez_delete_account'
                    },
                    beforeSend: function () {
                        profile_processing_modal(processing_text);
                    },
                    success: function( response ) {
                        if( response.success ) {
                            window.location.href = houzez_site_url;
                        }
                    },
                    error: function(xhr, status, error) {
                        var err = eval("(" + xhr.responseText + ")");
                        console.log(err.Message);
                    }
                });

            }

        });

        $('.houzez_delete_agency_agent').click(function(e){
            e.preventDefault();

            var confirm = window.confirm("Are you sure!, you want to delete a account.");
            var agent_id = $(this).attr('data-agentid');
            var agent_delete_security = $('#agent_delete_security').val();

            if ( confirm == true ) {

                $.ajax({
                    type: 'post',
                    url: ajaxURL,
                    dataType: 'json',
                    data: {
                        'action': 'houzez_delete_agency_agent',
                        'agent_delete_security': agent_delete_security,
                        'agent_id': agent_id
                    },
                    beforeSend: function () {
                        profile_processing_modal(processing_text);
                    },
                    success: function( response ) {
                        if( response.success ) {
                            window.location.reload();
                        }
                    },
                    error: function(xhr, status, error) {
                        var err = eval("(" + xhr.responseText + ")");
                        console.log(err.Message);
                    }
                });

            }

        });


        $( '#houzez_user_role' ).on( 'change', function(e) {
            e.preventDefault();

            var user_role = $( this ).val();
            var nonce    = $('#houzez-role-security-pass').val();
            var _wp_http_referer = $( 'input[name="_wp_http_referer"]' ).val();

            $.ajax({
                type: 'post',
                url: ajaxURL,
                dataType: 'json',
                data: {
                    'action': 'houzez_change_user_role',
                    'role': user_role,
                    'houzez-role-security-pass' : nonce,
                    '_wp_http_referer' : _wp_http_referer
                },
                beforeSend: function () {
                    profile_processing_modal(processing_text);
                },
                success: function( response ) {
                    if( response.success ) {
                        window.location.reload(true);
                    }
                },
                error: function(xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    console.log(err.Message);
                }
            });
        });

        $( '#houzez_user_currency' ).on( 'change', function(e) {
            e.preventDefault();

            var user_currency = $( this ).val();
            var nonce    = $('#houzez-user-currency-security-pass').val();

            $.ajax({
                type: 'post',
                url: ajaxURL,
                dataType: 'json',
                data: {
                    'action': 'houzez_change_user_currency',
                    'currency': user_currency,
                    'houzez-user-currency-security-pass' : nonce
                },
                beforeSend: function () {
                    profile_processing_modal(processing_text);
                },
                success: function( response ) {
                    if( response.success ) {
                        window.location.reload();
                    }
                },
                error: function(xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    console.log(err.Message);
                }
            });
        });

        var profile_processing_modal = function ( msg ) {
            var process_modal ='<div class="modal fade" id="fave_modal" tabindex="-1" role="dialog" aria-labelledby="faveModalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-body houzez_messages_modal">'+msg+'</div></div></div></div></div>';
            jQuery('body').append(process_modal);
            jQuery('#fave_modal').modal();
        }

        var profile_processing_modal_close = function ( ) {
            jQuery('#fave_modal').modal('hide');
        }

        /*-------------------------------------------------------------------
         *  Upload user profile image
         * ------------------------------------------------------------------*/
        var houzez_plupload = new plupload.Uploader({
            browse_button: 'select_user_profile_photo',
            file_data_name: 'houzez_file_data_name',
            multi_selection : false,
            url: ajaxURL + "?action=houzez_user_picture_upload&verify_nonce=" + houzez_upload_nonce + "&user_id=" + user_id,
            filters: {
                mime_types : [
                    { title : verify_file_type, extensions : "jpg,jpeg,gif,png" }
                ],
                max_file_size: '12000kb',
                prevent_duplicates: true
            }
        });
        houzez_plupload.init();

        houzez_plupload.bind('FilesAdded', function(up, files) {
            var houzez_thumbnail = "";
            plupload.each(files, function(file) {
                houzez_thumbnail += '<div id="imageholder-' + file.id + '" class="houzez-thumb">' + '' + '</div>';
            });
            document.getElementById('houzez_profile_photo').innerHTML = houzez_thumbnail;
            up.refresh();
            houzez_plupload.start();
        });

        houzez_plupload.bind('UploadProgress', function(up, file) {
            document.getElementById( "imageholder-" + file.id ).innerHTML = '<span>' + file.percent + "%</span>";
        });

        houzez_plupload.bind('Error', function( up, err ) {
            document.getElementById('houzez_upload_errors').innerHTML += "<br/>" + "Error #" + err.code + ": " + err.message;
        });

        houzez_plupload.bind('FileUploaded', function ( up, file, ajax_res ) {
            var response = $.parseJSON( ajax_res.response );

            if ( response.success ) {

                var houzez_profile_thumb = '<img class="img-fluid" src="' + response.url + '" alt="" />' +
                    '<input type="hidden" class="profile-pic-id" id="profile-pic-id" name="profile-pic-id" value="' + response.attachment_id + '"/>';

                document.getElementById( "imageholder-" + file.id ).innerHTML = houzez_profile_thumb;

            } else {
                console.log ( response );
            }
        });

    }

});