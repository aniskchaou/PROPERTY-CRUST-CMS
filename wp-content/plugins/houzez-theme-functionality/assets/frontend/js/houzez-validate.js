( function( $ ) {
    'use strict';

    

	window.houzezValidateElementor = function(form) {

		if (jQuery().validate && jQuery().ajaxSubmit) {

			var $form = jQuery(form),
	            submitButton = $form.find('.houzez-submit-button'),
	            messageContainer = $form.find('.ele-form-messages'),
	            errorContainer = $form.find(".error-container"),
	            ajaxLoader = $form.find('.houzez-loader-js'),
	            formOptions = {
	                beforeSubmit: function () {
	                	ajaxLoader.addClass('loader-show');
	                    submitButton.attr('disabled', 'disabled');
	                    messageContainer.fadeOut('fast');
	                    errorContainer.fadeOut('fast');
	                },
	                success: function (response, statusText, xhr, $form) {

	                    var response = $.parseJSON(response);
	                    ajaxLoader.removeClass('loader-show');
	                    submitButton.removeAttr('disabled');

	                    if (response.success) {

	                        $form.resetForm();
	                        messageContainer.html('<div class="alert alert-success alert-dismissible fade show" role="alert">'+response.msg+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>').fadeIn('fast');

	                        if(houzez_vars.houzez_reCaptcha == 1) {
                                $form.find('.g-recaptcha-response').remove();
                                if( houzez_vars.g_recaptha_version == 'v3' ) {
                                    houzezReCaptchaLoad();
                                } else {
                                    houzezReCaptchaReset();
                                }
                            }

                            if( response.redirect_to != '' ) {
                                setTimeout(function(){
                                    window.location.replace(response.redirect_to);
                                }, 500);
                            }

	                    } else {
	                        messageContainer.html('<div class="alert alert-danger alert-dismissible fade show" role="alert">'+response.msg+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>').fadeIn('fast');
	                    }
	                }
	            };

	        $form.validate({ 
	           
	            highlight: function ( element, errorClass, validClass ) {
	            jQuery( element ).addClass( "is-invalid" ).removeClass( "is-valid" );
	            },
	            unhighlight: function (element, errorClass, validClass) {
	                jQuery( element ).removeClass( "is-invalid" );
	            },
	            errorLabelContainer: errorContainer,
	            submitHandler: function (form) {
                    $(form).ajaxSubmit(formOptions);
                }
	        });

		} // end if jQuery.validate
		
	} // end houzezValidateElementor
        
    


} )( jQuery );