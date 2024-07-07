"use strict";
	var ajaxurl =fit_s13.ajaxurl;
	var loader_image = fit_s13.loading_image;

jQuery(".nav-tabs a").click(function(){
    jQuery(this).tab('show');
 });	
jQuery(document).ready(function($) {
	if (jQuery("#user-data")[0]){	
		jQuery('#user-data').show();				
		var oTable2 = jQuery('#user-data').dataTable({
			 "language": {		
					"sProcessing": 		fit_s13.sProcessing ,  
					"sSearch": 				fit_s13.sSearch ,   
					"lengthMenu":			fit_s13.lengthMenu ,
					"zeroRecords": 		fit_s13.zeroRecords,
					"info": 					fit_s13.info,
					"infoEmpty": 			fit_s13.infoEmpty,
					"infoFiltered":		fit_s13.infoFiltered ,
					"oPaginate": {
							"sFirst":   	fit_s13.sFirst,
							"sLast":    	fit_s13.sLast,
							"sNext":   		fit_s13.sNext ,
							"sPrevious":	fit_s13.sPrevious,
							},
					}
		});
		oTable2.fnSort( [ [1,'DESC'] ] );
		
	}
});	
function iv_cancel_membership_paypal (){
		if (confirm(fit_s13.confirmmessage)) {	
					jQuery('#update_message_paypal').html(loader_image);
			var search_params={
				"action"  	: 	"ep_fitness_cancel_paypal",
				"form_data"	:		jQuery("#paypal_cancel_form").serialize(),
				"_wpnonce"	:  	fit_s13.settingnonce,
			};
			jQuery.ajax({
				url : ajaxurl,
				dataType : "json",
				type : "post",
				data : search_params,
				success : function(response){
					if(response.code=='success'){
						jQuery('#paypal_cancel_div').hide();
						jQuery('#update_message_paypal').html('<div class="alert alert-info alert-dismissable"><a class="panel-close close" data-dismiss="alert">x</a>'+response.msg +'.</div>');
						}else{
						jQuery('#update_message_paypal').html('<div class="alert alert-info alert-dismissable"><a class="panel-close close" data-dismiss="alert">x</a>'+response.msg +'.</div>');
					}
				}
			});
		}
	}
  function iv_cancel_membership_stripe (){
		if (confirm(fit_s13.confirmmessage)) {		
			jQuery('#update_message_stripe').html(loader_image);
			var search_params={
				"action"  	: 	"ep_fitness_cancel_stripe",
				"form_data"	:		jQuery("#profile_cancel_form").serialize(),
				"_wpnonce"	:  	fit_s13.settingnonce,
			};
			jQuery.ajax({
				url : ajaxurl,
				dataType : "json",
				type : "post",
				data : search_params,
				success : function(response){
					jQuery('#stripe_cancel_div').hide();
					jQuery('#update_message_stripe').html('<div class="alert alert-info alert-dismissable"><a class="panel-close close" data-dismiss="alert">x</a>'+response.msg +'.</div>');
				}
			});
		}
	}

	jQuery(function(){
		jQuery('#package_sel').on('change', function (e) {
			var optionSelected = jQuery("option:selected", this);
			var pack_id = this.value;
			jQuery("#package_id").val(pack_id);		
			var search_params={
				"action"  				: "ep_fitness_check_package_amount",
				"coupon_code" 		:	jQuery("#coupon_name").val(),
				"package_id" 			: pack_id,
				"package_amount" 	:	'',
				"api_currency" 		:	fit_s13.currencyCode,
				"_wpnonce"				: fit_s13.signup,
			};
			jQuery.ajax({
				url : ajaxurl,
				dataType : "json",
				type : "post",
				data : search_params,
				success : function(response){					
					jQuery('#p_amount').html(response.p_amount);
				}
			});
		});
	});	

jQuery(document).ready(function() {	
	if (jQuery("#user-data")[0]){	
		jQuery( "#datepicker4" ).datepicker();
	}	
	
} );
	

function iv_update_fb (){

	jQuery('#update_message_fb').html(loader_image);
	var search_params={
		"action"  : 	"ep_fitness_update_setting_fb",
		"form_data":	jQuery("#setting_fb").serialize(),
		"_wpnonce":  	fit_s13.settingnonce,
	};
	jQuery.ajax({
		url : ajaxurl,
		dataType : "json",
		type : "post",
		data : search_params,
		success : function(response){
			jQuery('#update_message_fb').html('<div class="alert alert-info alert-dismissable"><a class="panel-close close" data-dismiss="alert">x</a>'+response.msg +'.</div>');
		}
	});
}
function iv_update_password (){
	var ajaxurl =fit_s13.ajaxurl;
	var loader_image = fit_s13.loading_image;
	jQuery('#update_message_pass').html(loader_image);
	var search_params={
		"action"  : 	"ep_fitness_update_setting_password",
		"form_data":	jQuery("#pass_word").serialize(),
		"_wpnonce":  	fit_s13.settingnonce,
	};
	jQuery.ajax({
		url : ajaxurl,
		dataType : "json",
		type : "post",
		data : search_params,
		success : function(response){
			jQuery('#update_message_pass').html('<div class="alert alert-info alert-dismissable"><a class="panel-close close" data-dismiss="alert">x</a>'+response.msg +'.</div>');
		}
	});
}
function edit_gallery_image(profile_image_id){
	var image_gallery_frame;
	var hidden_field_image_ids = jQuery('#gallery_image_ids').val();	
	image_gallery_frame = wp.media.frames.downloadable_file = wp.media({	
		title: fit_s13.setimage,
		button: {
			text:fit_s13.setimage,
		},
		multiple: true,
		displayUserSettings: true,
	});                
	image_gallery_frame.on( 'select', function() {
		var selection = image_gallery_frame.state().get('selection');
		selection.map( function( attachment ) {
			attachment = attachment.toJSON();
			console.log(attachment);
			if ( attachment.id ) {
				jQuery('#'+profile_image_id).append('<div id="gallery_image_div'+attachment.id+'" class="col-md-3"><img  class="img-responsive"  src="'+attachment.sizes.thumbnail.url+'"><button type="button" onclick="remove_gallery_image(\'gallery_image_div'+attachment.id+'\', '+attachment.id+');"  class="btn btn-xs btn-danger">X</button> </div>');
				hidden_field_image_ids=hidden_field_image_ids+','+attachment.id ;
				jQuery('#gallery_image_ids').val(hidden_field_image_ids); 
			}
		});
	});               
	image_gallery_frame.open(); 
}
function  remove_gallery_image(img_remove_div,rid){	
	var hidden_field_image_ids = jQuery('#gallery_image_ids').val();	
	hidden_field_image_ids =hidden_field_image_ids.replace(rid, '');	
	jQuery('#'+img_remove_div).remove();
	jQuery('#gallery_image_ids').val(hidden_field_image_ids); 
}

jQuery(document).ready(function($) {
	var getWidth = jQuery('.bootstrap-wrapper').width();
	if (getWidth < 780) {
		jQuery('.bootstrap-wrapper').addClass('narrow-width');
    } else {
		jQuery('.bootstrap-wrapper').removeClass('narrow-width');
	}
});
function edit_profile_image(profile_image_id){
	var image_gallery_frame;               
	image_gallery_frame = wp.media.frames.downloadable_file = wp.media({                   
		title: fit_s13.setimage,
		button: {
			text: fit_s13.setimage,
		},
		multiple: false,
		displayUserSettings: true,
	});
	image_gallery_frame.on( 'select', function() {
		var selection = image_gallery_frame.state().get('selection');
		selection.map( function( attachment ) {
			attachment = attachment.toJSON();
			if ( attachment.id ) {
				var ajaxurl =fit_s13.ajaxurl;
				var loader_image = fit_s13.loading_image;
				var search_params = {
					"action": 	"ep_fitness_update_profile_pic",
					"attachment_thum": attachment.sizes.thumbnail.url,
					"profile_pic_url_1": attachment.url,
					"_wpnonce":  	fit_s13.settingnonce,
				};
				jQuery.ajax({
					url: ajaxurl,
					dataType: "json",
					type: "post",
					data: search_params,
					success: function(response) {
						if(response=='success'){
							jQuery('#'+profile_image_id).html('<img  class="img-circle img-responsive"  src="'+attachment.sizes.thumbnail.url+'">');
						}
					}
				});
			}
		});
	});
	image_gallery_frame.open();
}
function update_profile_setting (){
	var ajaxurl =fit_s13.ajaxurl;
	var loader_image = fit_s13.loading_image;
  jQuery('#update_message').html(loader_image);
  var search_params={
		"action"  : 	"ep_fitness_update_profile_setting",
		"form_data":	jQuery("#profile_setting_form").serialize(),
	  "_wpnonce":  	fit_s13.settingnonce,
	};
	jQuery.ajax({
		url : ajaxurl,
		dataType : "json",
		type : "post",
		data : search_params,
		success : function(response){
			jQuery('#update_message').html('<div class="alert alert-info alert-dismissable"><a class="panel-close close" data-dismiss="alert">x</a>'+response.msg +'.</div>');
		}
	});
}