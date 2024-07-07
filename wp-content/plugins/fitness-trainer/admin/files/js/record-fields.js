"use strict";
var ajaxurl = recordfields.ajaxurl;
var loader_image = recordfields.loading_image;
var i=recordfields.i;
var ii=recordfields.ii;
function update_dir_fields(){			
	jQuery('#record_field_message').html(loader_image);
	var search_params = {
		"action": 		"ep_fitness_update_dir_fields",
		"form_data":	jQuery("#record_fields").serialize(),
		"_wpnonce"		:  	recordfields.settings,
	};
	jQuery.ajax({
		url: ajaxurl,
		dataType: "json",
		type: "post",
		data: search_params,
		success: function(response) {
			jQuery('#record_field_message').html('<div class="alert alert-info alert-dismissable"><a class="panel-close close" data-dismiss="alert">x</a>'+response.code +'.</div>');
		}
	});
}
function iv_add_record_field(){
	jQuery('#record_field_div').append('<div class="row form-group " id="record_field_'+i+'"><div class=" col-sm-5"> <input type="text" class="form-control" name="meta_name[]" id="meta_name[]" value="" placeholder="Enter Post Meta Name "> </div>	<div  class=" col-sm-5"><input type="text" class="form-control" name="meta_label[]" id="meta_label[]" value="" placeholder="Enter Post Meta Label"></div><div  class=" col-sm-2"><button class="btn btn-danger btn-xs" onclick="return iv_record_remove_field('+i+');">Delete</button>');
	i=i+1;
}
function iv_record_remove_field(div_id){ 
	jQuery("#record_field_"+div_id).remove();
}