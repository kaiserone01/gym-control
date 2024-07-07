"use strict";
jQuery(function() {
		jQuery('#package_sel').on("change", function() {
			this.form.submit();
		});
	});
	jQuery(document).ready(function($) {
    var getWidth = jQuery('.bootstrap-wrapper').width();
    if (getWidth < 780) {
      jQuery('.bootstrap-wrapper').addClass('narrow-width');
			} else {
      jQuery('.bootstrap-wrapper').removeClass('narrow-width');
		}
	});
(function($, window, document, undefined) {
		var slider = $('.cbp-slider');
		slider.find('.cbp-slider-item').addClass('cbp-item');
		slider.cubeportfolio({
		layoutMode: 'slider',
		gridAdjustment: 'responsive',
		mediaQueries: [{
		width: 1,
		cols: 1
		}],
		gapHorizontal: 0,
		gapVertical: 0,
		caption: '',
		});
	})(jQuery, window, document);