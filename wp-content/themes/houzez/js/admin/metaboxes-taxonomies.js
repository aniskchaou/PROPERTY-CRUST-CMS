(function($) {
    	
        $(document).ready(function ($) {
			"use strict";

    	/* Color picker metabox handle */
    	if($('.fave_colorpicker').length){
    		$('.fave_colorpicker').wpColorPicker();

    		$('a.fave_colorpick').click(function(e){
    			e.preventDefault();
    			$('.fave_colorpicker').val($(this).attr('data-color'));
    			$('.fave_colorpicker').change();
    		});	
    	}

    	fave_toggle_color_picker();
    	
    	$("body").on("click", "input.color-type", function(e){
					fave_toggle_color_picker();
		});
			   
    	function fave_toggle_color_picker(){
    		var picker_value = $('input.color-type:checked').val();
    		if(picker_value == 'custom'){
    			$('#fave_color_wrap').show();
    		} else {
    			$('#fave_color_wrap').hide();
    		}
    	}

    });
    	
})(jQuery);