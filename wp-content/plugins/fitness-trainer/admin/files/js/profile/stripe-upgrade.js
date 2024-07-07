"use strict";
var ajaxurl =fit_data.ajaxurl;
var loader_image = fit_data.loading_image;
(function($) {
	var select = jQuery(".card-expiry-year"),
		year = new Date().getFullYear();
		for (var i = 0; i < 12; i++) {
			select.append(jQuery("<option value='"+(i + year)+"' "+(i === 0 ? "selected" : "")+">"+(i + year)+"</option>"))
		}									
	var active_payment_gateway=fit_data.iv_gateway;
	jQuery(document).ready(function($) {
		jQuery.validate({
			form : '#profile_upgrade_form',
			modules : 'security',
			onSuccess : function() {
				jQuery("#loading").html(loader_image);
				if(active_payment_gateway=='stripe'){
					var chargeAmount = 3000;
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
	Stripe.setPublishableKey(fit_data.stripe_publishable);
	function stripeResponseHandler(status, response) {
		if (response.error) {
			jQuery("#payment-errors").html('<div class="alert alert-info alert-dismissable"><a class="panel-close close" data-dismiss="alert">x</a>'+response.error.message +'.</div> ');
			} else {
			var form$ = jQuery("#profile_upgrade_form");		
			var token = response['id'];		
			form$.append("<input type='hidden' name='stripeToken' value='" + token + "' />");		
			var search_params={
				"action"  : 	"ep_fitness_profile_stripe_upgrade",
				"form_data":	jQuery("#profile_upgrade_form").serialize(),
			};
			jQuery.ajax({
				url : ajaxurl,
				dataType : "json",
				type : "post",
				data : search_params,
				success : function(response){
					jQuery('#payment-errors').html('<div class="alert alert-info alert-dismissable"><a class="panel-close close" data-dismiss="alert">x</a>'+response.msg +'.</div>');
					jQuery("#stripe_form").hide();
				}
			});
			
		}
	}
})(jQuery);