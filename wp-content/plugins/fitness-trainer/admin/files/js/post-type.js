"use strict";
var ajaxurl = posttype.ajaxurl;
var loader_image = posttype.loading_image;
function update_dir_post_type(){	
	jQuery('#success_post_type').html(loader_image);
	var search_params = { 
		"action": 		"ep_fitness_update_post_type",
		"form_data":	jQuery("#dir_post_type").serialize(),
		"_wpnonce"		:  	posttype.settings,
	};
	jQuery.ajax({
		url: ajaxurl,
		dataType: "json",
		type: "post",
		data: search_params,
		success: function(response) {
			jQuery('#success_post_type').html('<div class="alert alert-info alert-dismissable"><a class="panel-close close" data-dismiss="alert">x</a>'+response.code +'.</div>');
		}
	});
}
function iv_add_field_posttype(){ 
	jQuery('#posttype_field_div').append('<div class="row form-group " id="post_type_'+posttype.i+'"><div class=" col-sm-5"> <input type="text" class="form-control" name="posttype_name[]" id="posttype_name[]" value="" placeholder="Enter post type, no space & upper case"> </div>	<div  class=" col-sm-5"><input type="text" class="form-control" name="posttype_label[]" id="posttype_label[]" value="" placeholder="Enter Post Type Label"></div><div  class=" col-sm-2"><button class="btn btn-danger btn-xs" onclick="return iv_remove_post_type('+posttype.i+');">Delete</button>');
	i=i+1;
}
function iv_remove_post_type(div_id){ 
	jQuery("#post_type_"+div_id).remove();
}
function update_dir_post_type_page(){
	jQuery('#success_post_type2').html(loader_image);
	var search_params = {
		"action": 		"ep_fitness_update_post_type_page",
		"form_data":	jQuery("#dir_post_type_page").serialize(),
		"_wpnonce"		:  	posttype.settings,
	};
	jQuery.ajax({
		url: ajaxurl,
		dataType: "json",
		type: "post",
		data: search_params,
		success: function(response) {
			jQuery('#success_post_type2').html('<div class="alert alert-info alert-dismissable"><a class="panel-close close" data-dismiss="alert">x</a>'+response.code +'.</div>');
		}
	});
}