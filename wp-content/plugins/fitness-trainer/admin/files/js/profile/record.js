"use strict";
var ajaxurl =fit_data.ajaxurl;
var loader_image = fit_data.loading_image;
var ajaxurl = fit_data.ajaxurl;
jQuery(document).ready(function() {
		
		if (jQuery("#date4")[0]){	
		jQuery( "#date4" ).datepicker();
		}
		
		if (jQuery("#date")[0]){	
		jQuery( "#date" ).datepicker();
		}
} );

	
function iv_update_post (){
	var loader_image = fit_data.loading_image;
	jQuery('#update_message').html(loader_image);
	var search_params={
		"action"  		: 	"ep_fitness_update_record",	
		"form_data"		:		jQuery("#edit_post").serialize(), 
		"_wpnonce"		:  	fit_data.settingnonce,
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
function  remove_post_image	(profile_image_id){
	jQuery('#'+profile_image_id).html('');
	jQuery('#feature_image_id').val(''); 
	jQuery('#post_image_edit').html('<button type="button" onclick="edit_post_image(\'post_image_div\');"  class="btn btn-xs green-haze">'+fit_data.add+'</button>');  
}
function edit_post_image(profile_image_id){	
	var image_gallery_frame;
	image_gallery_frame = wp.media.frames.downloadable_file = wp.media({
		title: fit_data.setimage,
		button: {
			text: fit_data.setimage ,
		},
		multiple: false,
		displayUserSettings: true,
	});                
	image_gallery_frame.on( 'select', function() {
		var selection = image_gallery_frame.state().get('selection');
		selection.map( function( attachment ) {
			attachment = attachment.toJSON();
			if ( attachment.id ) {
				jQuery('#'+profile_image_id).html('<img  class="img-responsive"  src="'+attachment.sizes.thumbnail.url+'">');
				jQuery('#feature_image_id').val(attachment.id ); 
				jQuery('#post_image_edit').html('<button type="button" onclick="edit_post_image(\'post_image_div\');"  class="btn btn-xs green-haze">'+fit_data.edit+'</button> &nbsp;<button type="button" onclick="remove_post_image(\'post_image_div\');"  class="btn btn-xs green-haze">'+fit_data.remove+'</button>');  
			}
		});
	});               
	image_gallery_frame.open(); 
}
;
function iv_save_post (){
	var ajaxurl =fit_data.ajaxurl;
	var loader_image = fit_data.loading_image;
	jQuery('#update_message').html(loader_image);
	var search_params={
		"action"  : 	"ep_fitness_save_record_pt",	
		"form_data":	jQuery("#new_post").serialize(), 
		"_wpnonce"		:  	fit_data.settingnonce,
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
function iv_update_expert_review (post_id){
	var ajaxurl =fit_data.ajaxurl;
	var loader_image = fit_data.loading_image;
	jQuery('#reviewmessage'+post_id).html(loader_image);
	var search_params={
		"action"  : 	"ep_fitness_update_expert_review",
		"review_data":	jQuery("#expert_review"+post_id).val(),
		"post_ex_id":	post_id,
		"_wpnonce"		:  	fit_data.settingnonce,
	};
	jQuery.ajax({
		url : ajaxurl,
		dataType : "json",
		type : "post",
		data : search_params,
		success : function(response){
			jQuery('#reviewmessage'+post_id).html('<div class="alert alert-info alert-dismissable"><a class="panel-close close" data-dismiss="alert">x</a>'+response.msg +'.</div>');
		}
	});
}
function iv_update_post_user (){
	var ajaxurl =fit_data.ajaxurl;
	var loader_image = fit_data.loading_image;
	jQuery('#update_message').html(loader_image);
	var search_params={
		"action"  : 	"ep_fitness_update_record",	
		"form_data":	jQuery("#edit_post").serialize(), 
		"_wpnonce"		:  	fit_data.settingnonce,
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
function iv_save_post_user (){
	var ajaxurl =fit_data.ajaxurl;
	var loader_image = fit_data.loading_image;
	jQuery('#update_message').html(loader_image);
	var search_params={
		"action"  : 	"ep_fitness_save_record",	
		"form_data":	jQuery("#new_post").serialize(), 
		"_wpnonce"		:  	fit_data.settingnonce,
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