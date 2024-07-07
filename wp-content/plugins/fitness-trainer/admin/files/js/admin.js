"use strict";
var ajaxurl = admindata.ajaxurl;
var loader_image = admindata.loading_image;
function update_user_setting() {
		var search_params={
			"action"  		: 	"ep_fitness_update_user_settings",
			"form_data"		:	jQuery("#user_form_iv").serialize(),
			"_wpnonce"		:  	admindata.settings,
		};
		jQuery.ajax({
			url : ajaxurl,
			dataType : "json",
			type : "post",
			data : search_params,
			success : function(response){
				var url = admindata.wp_ep_fitness_ADMINPATH+"admin.php?page=wp-iv_user-directory-admin&message=success";
				jQuery(location).attr('href',url);

			}
		});
	}
jQuery(function() {
	if (jQuery("#exp_date")[0]){	
		jQuery( "#exp_date" ).datepicker({ dateFormat: 'dd-mm-yy' });
	}

});


jQuery(window).on('load',function(){
	if (jQuery("#user-data")[0]){	
		jQuery('#user-data').show();
		var oTable = jQuery('#user-data').dataTable();
		oTable.fnSort( [ [1,'DESC'] ] );
	}
});
function update_stripe_setting() {
	var search_params={
		"action"  		: 	"ep_fitness_update_stripe_settings",
		"form_data"		:	jQuery("#stripe_form_iv").serialize(),
		"_wpnonce"		:  	admindata.settings,
	};
	jQuery.ajax({
		url : ajaxurl,
		dataType : "json",
		type : "post",
		data : search_params,
		success : function(response){
			jQuery('#iv-loading').html('<div class="col-md-12 alert alert-success">Update Successfully.</div>');
			
		}
	});
	
}

function iv_update_payment_settings() {
	// New Block For Ajax*****
	var search_params={
		"action"  		: 	"ep_fitness_update_payment_setting",
		"form_data"		:	jQuery("#payment_settings").serialize(),
		"_wpnonce"		:  	admindata.settings,
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
function iv_update_page_settings(){
	var search_params={
		"action"  		: 	"ep_fitness_update_page_setting",
		"form_data"		:	jQuery("#page_settings").serialize(),
		"_wpnonce"		:  	admindata.settings,
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
function iv_update_email_settings(){
	
	var search_params={
		"action"  		: 	"ep_fitness_update_email_setting",
		"form_data"		:	jQuery("#email_settings").serialize(),
		"_wpnonce"		:  	admindata.settings,
	};
	jQuery.ajax({
		url : ajaxurl,
		dataType : "json",
		type : "post",
		data : search_params,
		success : function(response){
			jQuery('#update_message').html('<div class="alert alert-info alert-dismissable"><a class="panel-close close" data-dismiss="alert">x</a>'+response.msg +'.</div>');
			jQuery('#email-success').html('<div class="alert alert-info alert-dismissable"><a class="panel-close close" data-dismiss="alert">x</a>'+response.msg +'.</div>');
			
			
		}
	});
}
function iv_update_mailchamp_settings(){
	
	var search_params={
		"action"  		: 	"ep_fitness_update_mailchamp_setting",
		"form_data"		:	jQuery("#mailchimp_settings").serialize(),
		"_wpnonce"		:  	admindata.settings,
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

function iv_update_account_settings(){
	
	var search_params={
		"action"  		: 	"ep_fitness_update_account_setting",
		"form_data"		:	jQuery("#account_settings").serialize(),
		"_wpnonce"		:  	admindata.settings,
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


function update_paypal_setting() {	
	var search_params={
		"action"  		: 	"ep_fitness_update_paypal_settings",
		"form_data"		:	jQuery("#paypal_form_iv").serialize(),
		"_wpnonce"		:  	admindata.settings,
	};
	jQuery.ajax({
		url : ajaxurl,
		dataType : "json",
		type : "post",
		data : search_params,
		success : function(response){
			jQuery('#iv-loading').html('<div class="col-md-5 alert alert-success">Update Successfully. <a class="btn btn-success btn-xs" href="?page=wp-ep_fitness-payment-settings"> Go Payment Setting Page</aa></div>');
		}
	});
}
jQuery(document).ready(function () {
	jQuery("input[name='payment_gateway']").on("click", function(){ 
		iv_update_payment_settings_admin();
	});
});
function  iv_update_payment_settings_admin(){
	jQuery("#update_message_payment").html(loader_image);
	var search_params = {
		"action"			: 	"ep_fitness_gateway_settings_update",
		"payment_gateway"	: 	jQuery("input[name=payment_gateway]:checked").val(),
		"_wpnonce"			:  	admindata.settings,
	};
	jQuery.ajax({
		url: ajaxurl,
		dataType: "json",
		type: "post",
		data: search_params,
		success: function(response) {
			jQuery('#update_message_payment').html('<div class="alert alert-info alert-dismissable"><a class="panel-close close" data-dismiss="alert">x</a>'+response.msg +'.</div>');
		}
	});
}
function update_the_package() {
	var loader_image = admindata.loading_image;
	jQuery("#loading").html(loader_image);
	// New Block For Ajax*****
	var search_params={
		"action"  		: 	"ep_fitness_update_package",
		"form_data"		:	jQuery("#package_form_iv").serialize(),
		"_wpnonce"		:  	admindata.settings,
	};
	jQuery.ajax({
		url : ajaxurl,
		dataType : "json",
		type : "post",
		data : search_params,
		success : function(response){
			var url = admindata.wp_ep_fitness_ADMINPATH+"admin.php?page=wp-ep_fitness-package-all&form_submit=success";
			jQuery(location).attr('href',url);
		}
	});
}
function save_the_form() {
	var loader_image = admindata.loading_image;
	jQuery("#loading").html(loader_image);
	// New Block For Ajax*****
	var search_params={
		"action"  		: 	"ep_fitness_save_package",
		"form_data"		:	jQuery("#package_form_iv").serialize(),
		"_wpnonce"		:  	admindata.settings,
	};
	jQuery.ajax({
		url : admindata.ajaxurl,
		dataType : "json",
		type : "post",
		data : search_params,
		success : function(response){
			var url = admindata.wp_ep_fitness_ADMINPATH+"admin.php?page=wp-ep_fitness-package-all&form_submit=success";
			jQuery(location).attr('href',url);
		}
	});
}
jQuery(document).ready(function(){
	jQuery('#package_recurring').on("click", function(){
		if(this.checked){
			jQuery('#recurring_block').show();
			}else{
			jQuery('#recurring_block').hide();
		}
	});
});
jQuery(document).ready(function(){
	jQuery('#package_enable_trial_period').on("click", function(){
		if(this.checked){
			jQuery('#trial_block').show();
			}else{
			jQuery('#trial_block').hide();
		}
	});
});
function iv_package_status_change(status_id,curr_status){
	status_id =status_id.trim();
	curr_status=curr_status.trim();
	var ajaxurl = admindata.ajaxurl;
	var search_params = {
		"action"			: 	"ep_fitness_update_package_status",
		"status_id"			: 	status_id,
		"status_current"	:	curr_status,
		"_wpnonce"			:  	admindata.settings,
	};
	jQuery.ajax({
		url: ajaxurl,
		dataType: "json",
		type: "post",
		data: search_params,
		success: function(response) {
			if(response.code=='success'){
				jQuery("#status_"+status_id).html('<button class="btn btn-info btn-xs" onclick="return iv_package_status_change(\' '+status_id+' \' ,\' '+response.current_st+' \');">'+response.msg+'</button>');
			}
		}
	});
}
jQuery(document).ready(function() {
	jQuery('input[type=radio][name=post_for_radio]').on("click", function(){
		if (this.value == 'role') {
			jQuery("#package_div").show();
			jQuery("#user_div").hide();
			jQuery("#Woocommerce").hide();
		}
		else if (this.value == 'user') {
			jQuery("#package_div").hide();
			jQuery("#Woocommerce").hide();
			jQuery("#user_div").show();
			}else if(this.value =='Woocommerce'){
			jQuery("#package_div").hide();
			jQuery("#user_div").hide();
			jQuery("#Woocommerce").show();
		}
	});
});
function iv_update_dir_setting(){
	var search_params={
		"action"  		: 	"iv_update_dir_setting",
		"form_data"		:	jQuery("#directory_settings").serialize(),
		"_wpnonce"		:  	admindata.settings,
	};
	jQuery.ajax({
		url : ajaxurl,
		dataType : "json",
		type : "post",
		data : search_params,
		success : function(response){
			jQuery('#update_message').html('<div class="alert alert-info alert-dismissable"><a class="panel-close close" data-dismiss="alert">x</a>'+response.msg +'.</div>');
		}
	})
}
jQuery(function() {
		if (jQuery("#start_date")[0]){
			jQuery( "#start_date" ).datepicker({ dateFormat: 'dd-mm-yy' });
		}	
		if (jQuery("#end_date")[0]){
			jQuery( "#end_date" ).datepicker({ dateFormat: 'dd-mm-yy' });
		}
});
function iv_create_coupon() {	
	var search_params={
		"action"  		: 	"ep_fitness_create_coupon",
		"form_data"		:	jQuery("#coupon_form_iv").serialize(),
		"form_pac_ids"	: 	jQuery("#package_id").val(),
		"_wpnonce"		:  	admindata.coupon,
	};
	jQuery.ajax({
		url : ajaxurl,
		dataType : "json",
		type : "post",
		data : search_params,
		success : function(response){
			var url = admindata.wp_ep_fitness_ADMINPATH+"admin.php?page=wp-ep_fitness-coupons-form&form_submit=success";
			jQuery(location).attr('href',url);
		}
	});
}
function iv_update_coupon() {
	var search_params={
		"action"  		: 	"ep_fitness_update_coupon",
		"form_data"		:	jQuery("#coupon_form_iv").serialize(),
		"form_pac_ids"	: 	jQuery("#package_id").val(),
		"_wpnonce"		:  	admindata.coupon,
	};
	jQuery.ajax({
		url : ajaxurl,
		dataType : "json",
		type : "post",
		data : search_params,
		success : function(response){
			var url = admindata.wp_ep_fitness_ADMINPATH+"admin.php?page=wp-ep_fitness-coupons-form&form_submit=success";
			jQuery(location).attr('href',url);
		}
	});
}