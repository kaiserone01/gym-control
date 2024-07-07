"use strict";
var ajaxurl = fit_data.ajaxurl;
jQuery(document).ready(function() {
jQuery( "#datepicker4" ).datepicker();
} );
function delete_report(id){
	var cmt = confirm(fit_data.delete_message);
	if (cmt == true) {
		var ajaxurl = fit_data.ajaxurl;
		var search_params = {
			"action": 		"ep_fitness_delete_report",
			"post_id":	id, 	
			"_wpnonce":  	fit_data.settingnonce,
		};
		jQuery.ajax({
			url: ajaxurl,
			dataType: "json",
			type: "post",
			data: search_params,
			success: function(response) {              		
				
				jQuery("#"+id).fadeOut(800, function(){ jQuery(this).remove();});
			}
		});
	}


}

jQuery.fn.extend({
  autoHeight: function () {
    function autoHeight_(element) {
      return jQuery(element)
        .css({ 'height': 'auto', 'overflow-y': 'hidden' })
        .height(element.scrollHeight);
    }
    return this.each(function() {
      autoHeight_(this).on('input', function() {
        autoHeight_(this);
      });
    });
  }
});

jQuery('textarea').autoHeight();
	
function iv_save_report1 (){

	var ajaxurl =fit_data.ajaxurl;
	var loader_image = fit_data.loading_image;
				jQuery('#update_message').html(loader_image);
				var search_params={
					"action"  : 	"ep_fitness_save_report1",	
					"form_data":	jQuery("#add_report1").serialize(), 
					"_wpnonce":  	fit_data.settingnonce,
				};
				jQuery.ajax({					
					url : ajaxurl,					 
					dataType : "json",
					type : "post",
					data : search_params,
					success : function(response){
						if(response.code=='success'){
								var url = fit_data.permalink;    						
								jQuery(location).attr('href',url);	
						}						
					}
				});
	
}
	