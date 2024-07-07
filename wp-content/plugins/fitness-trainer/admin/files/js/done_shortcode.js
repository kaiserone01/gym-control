"use strict";
var ajaxurl = fit_data.ajaxurl;
var loader_image = fit_data.loading_image;
function done_iv(){
		var search_params={
			"action"  		: "iv_training_done",
			"post_id" 		: fit_data.post_id,
			"day_num" 		: fit_data.day_num,
		};
		jQuery.ajax({
			url : ajaxurl,
			dataType : "json",
			type : "post",
			data : search_params,
			success : function(response){
				if(response.code=='success'){
					jQuery('#training_done_button').html(fit_data.message);
				}
			}
		});
}