function done_iv(){ 

		var ajaxurl =fit_p15.ajaxurl;
		var loader_image = fit_p15.loading_image;
		var search_params={
			"action"  		: "iv_training_done",
			"post_id" 		: fit_p15.postid,
			"day_num" 		: fit_p15.daynumber,
		};
		jQuery.ajax({					
			url : ajaxurl,					 
			dataType : "json",
			type : "post",
			data : search_params,
			success : function(response){
				if(response.code=='success'){							
					jQuery('#training_done').html(fit_p15.donemessage);
				}
			}
		});

}