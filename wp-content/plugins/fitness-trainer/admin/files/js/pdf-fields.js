"use strict";
var ajaxurl = pdffields.ajaxurl;
var loader_image = pdffields.loading_image;
var i=pdffields.i;
var ii=pdffields.ii;
function update_pdf_fields(){
	jQuery('#success_message_pdf').html(loader_image);
	var search_params = {
		"action": 		"ep_fitness_update_report_fields",
		"form_data":	jQuery("#report_fields").serialize(),
		"_wpnonce"		:  	recordfields.settings,
	};
	jQuery.ajax({
		url: ajaxurl,
		dataType: "json",
		type: "post",
		data: search_params,
		success: function(response) {
			jQuery('#success_message_pdf').html('<div class="alert alert-info alert-dismissable"><a class="panel-close close" data-dismiss="alert">x</a>'+response.code +'.</div>');
		}
	});
}
function iv_add_field_pdf(){
	jQuery('#pdf_field_div').append('<div class="row form-group " id="field_'+i+'"><div class=" col-sm-5"> <input type="text" class="form-control" name="meta_name[]" id="meta_name[]" value="" placeholder="Enter Post Meta Name "> </div>	<div  class=" col-sm-5"><input type="text" class="form-control" name="meta_label[]" id="meta_label[]" value="" placeholder="Enter Post Meta Label"></div><div  class=" col-sm-2"><button class="btn btn-danger btn-xs" onclick="return iv_remove_field_pdf('+i+');">Delete</button>');
	i=i+1;
}
function iv_remove_field_pdf(div_id){
	jQuery("#field_"+div_id).remove();
}