"use strict";
jQuery(document).ready(function($) {
		var getWidth = jQuery('.bootstrap-wrapper').width();
		if (getWidth < 991) {
			jQuery('.bootstrap-wrapper').addClass('narrow-width');
			} else {
			jQuery('.bootstrap-wrapper').removeClass('narrow-width');
		}
	});