"use strict";
jQuery('document').ready(function($){
	var commentform=jQuery('#commentform'); // find the comment form
    commentform.prepend('<div id="comment-status" ></div>'); // add info panel before the form to provide feedback or errors
    var statusdiv=jQuery('#comment-status'); // define the infopanel
    commentform.submit(function(){			
			var formdata=commentform.serialize();	
			statusdiv.html(fit_data.processing);		
			var formurl=commentform.attr('action');		
			jQuery.ajax({
				type: 'post',
				url: formurl,
				data: formdata,
				error: function(XMLHttpRequest, textStatus, errorThrown)
				{
					statusdiv.html(fit_data.quickly);
				},
				success: function(data, textStatus){
					if(data == "success" || textStatus == "success"){
							statusdiv.html(fit_data.thanks);
							jQuery('#commentform').reset();
						}else{
							statusdiv.html(fit_data.Please_wait);
							commentform.find('textarea[name=comment]').val('');
					}
				}
			});
			return false;
		});
	});