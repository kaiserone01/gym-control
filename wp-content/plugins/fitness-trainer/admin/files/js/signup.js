"use strict";
(function($) {
	var select = jQuery(".card-expiry-year"),
	year = new Date().getFullYear();
	for (var i = 0; i < 12; i++) {
		select.append(jQuery("<option value='"+(i + year)+"' "+(i === 0 ? "selected" : "")+">"+(i + year)+"</option>"))
	}
})(jQuery);
(function($) {	
	var active_payment_gateway= epsignup_data.iv_gateway; 
	jQuery(document).ready(function($) {
		jQuery.validate({
			form : '#ep_fitness_registration',
			modules : 'security',		
			onSuccess : function() {
				jQuery("#loading-3").show();
				jQuery("#loading").html(epsignup_data.loader_image);
				if(active_payment_gateway=='stripe'){									
					Stripe.createToken({
						number: jQuery('#card_number').val(),
						cvc: jQuery('#card_cvc').val(),
						exp_month: jQuery('#card_month').val(),
						exp_year: jQuery('#card_year').val(),
					}, stripeResponseHandler);
					return false;
					}else{ // Else for paypal
					return true; // false Will stop the submission of the form
				}
			},
		})
	})
	// this identifies your website in the createToken call below
		if(epsignup_data.iv_gateway=='stripe'){
			Stripe.setPublishableKey(epsignup_data.stripe_publishable);
		}
		function stripeResponseHandler(status, response) {
			if (response.error) {				
				jQuery("#payment-errors").html('<div class="alert alert-info alert-dismissable"><a class="panel-close close" data-dismiss="alert">x</a>'+response.error.message +'.</div> ');
				jQuery("#loading-3").hide();
				} else {
				var form$ = jQuery("#ep_fitness_registration");
				// token contains id, last4, and card type
				var token = response['id'];
				// insert the token into the form so it gets submitted to the server
				form$.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
				// and submit
				form$.get(0).submit();
			}
		}
 
})(jQuery);
jQuery(document).ready(function() {
	jQuery('#coupon_name').on('keyup change', function() {
		var ajaxurl =epsignup_data.ajaxurl;
		var search_params={
			"action"  				: "ep_fitness_check_coupon",	
			"coupon_code" 		:	jQuery("#coupon_name").val(),
			"package_id" 			: jQuery("#package_id").val(),
			"package_amount" 	: epsignup_data.package_amount,
			"api_currency" 		: epsignup_data.api_currency,
			"_wpnonce"				: epsignup_data.dirwpnonce,
		};
		jQuery('#coupon-result').html(epsignup_data.loader_image2);
		jQuery.ajax({					
			url : ajaxurl,					 
			dataType : "json",
			type : "post",
			data : search_params,
			success : function(response){
				if(response.code=='success'){							
					jQuery('#coupon-result').html(epsignup_data.right_icon);							
					}else{
					jQuery('#coupon-result').html(epsignup_data.wrong_16x16);
				}
				jQuery('#total').html('<label class="control-label">'+response.gtotal +'</label>');
				jQuery('#discount').html('<label class="control-label">'+response.dis_amount +'</label>');
			}
		});
	});
});
jQuery(function(){	
	jQuery('#package_sel').on('change', function (e) {
		var optionSelected = jQuery("option:selected", this);
		var pack_id = this.value;
		jQuery("#package_id").val(pack_id);
		var ajaxurl = epsignup_data.ajaxurl;
		var search_params={
			"action"  			: "ep_fitness_check_package_amount",	
			"coupon_code" 		:jQuery("#coupon_name").val(),
			"package_id" 		: pack_id,
			"package_amount" 	:epsignup_data.package_amount,
			"api_currency" 		:epsignup_data.api_currency,
			"_wpnonce"				: epsignup_data.signup,
		};
		jQuery.ajax({					
			url : ajaxurl,					 
			dataType : "json",
			type : "post",
			data : search_params,
			success : function(response){
				if(response.code=='success'){							
					jQuery('#coupon-result').html(epsignup_data.right_icon);
					}else{
					jQuery('#coupon-result').html(epsignup_data.wrong_16x16);
				}
				jQuery('#p_amount').html(response.p_amount);							
				jQuery('#total').html(response.gtotal);
				jQuery('#discount').html(response.dis_amount);
			}
		});
	});	
});	
function show_coupon(){
	jQuery("#coupon-div").show();
	jQuery("#show_hide_div").html('<label for="text" class="col-md-3 col-xs-3 col-sm-3 control-label"></label><div class="col-md-9 col-xs-9 col-sm-9 " ><button type="button" onclick="hide_coupon();"  class="btn-new btn-custom ctrl-btn">'+epsignup_data.HideCoupon+'</button></div>');
}
function hide_coupon(){
	jQuery("#coupon-div").hide();
	jQuery("#show_hide_div").html('<label for="text" class="col-md-3 col-xs-3 col-sm-3 control-label"></label><div class="col-md-9 col-xs-9 col-sm-9 " ><button type="button" onclick="show_coupon();"  class="btn-new btn-custom ctrl-btn">'+epsignup_data.Havecoupon+'</button></div>');
}