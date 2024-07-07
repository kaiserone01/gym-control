"use strict";
jQuery(document).ready(function() {
	jQuery( "#datepicker4" ).datepicker();
	
} );
function iv_update_post (){
	tinyMCE.triggerSave();	
	var ajaxurl =fit_data.ajaxurl;
	var loader_image = fit_data.loading_image;
	jQuery('#update_message').html(loader_image);
	var search_params={
		"action"  : 	"ep_fitness_update_listing",	
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
				var url = fit_data.permalink;;    						
				jQuery(location).attr('href',url);	
			}
		}
	});
}
function iv_save_post (){
	tinyMCE.triggerSave();
	var ajaxurl =fit_data.ajaxurl;
	var loader_image = fit_data.loading_image;
	jQuery('#update_message').html(loader_image);
	var search_params={
		"action"  : 	"ep_fitness_save_listing",
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
function  remove_post_image	(profile_image_id){
	jQuery('#'+profile_image_id).html('');
	jQuery('#feature_image_id').val('');
	jQuery('#'+profile_image_id).html('<button type="button" onclick="edit_post_image(\'post_image_div\');"  class="btn btn-xs green-haze">Add</button>');
}
function edit_post_image(profile_image_id){
	var image_gallery_frame;               
	image_gallery_frame = wp.media.frames.downloadable_file = wp.media({
		title: fit_data.setimage,
		button: {
			text: fit_data.setimage,
		},
		multiple: false,
		displayUserSettings: true,
	});
	image_gallery_frame.on( 'select', function() {
		var selection = image_gallery_frame.state().get('selection');
		selection.map( function( attachment ) {
			attachment = attachment.toJSON();
			if ( attachment.id ) {							
				jQuery('#feature_image_id').val(attachment.id );
				jQuery('#'+profile_image_id).html('<img  class="img-responsive"  src="'+attachment.sizes.thumbnail.url+'"><button type="button" onclick="edit_post_image(\'post_image_div\');"  class="btn btn-xs green-haze">Edit</button> &nbsp;<button type="button" onclick="remove_post_image(\'post_image_div\');"  class="btn btn-xs green-haze">Remove</button>');
			}
		});
	});
	image_gallery_frame.open();
}