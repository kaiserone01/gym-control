"use strict";
jQuery(document).ready(function() {
	setTimeout(function(){
		(function($, window, document, undefined) {   
			// init cubeportfolio
			jQuery('#js-grid-blog-posts').cubeportfolio({
					filters: '#js-filters-blog-posts',
					search: '#js-search-blog-posts',
					defaultFilter: '*',
					animationType: '3dflip',
					gapHorizontal: 70,
					gapVertical: 30,
					gridAdjustment: 'responsive',
					mediaQueries: [{
							width: 1500,
							cols: 6,
					}, {
							width: 1100,
							cols: 5,
					}, {
							width: 800,
							cols: 4,
					}, {
							width: 480,
							cols: 4,
							options: {
									caption: '',
									gapHorizontal: 50,
									gapVertical: 20,
							}
					}, {
							width: 320,
							cols: 1,
							options: {
									caption: '',
									gapHorizontal: 50,
							}
					}],
					caption: 'revealBottom',
					displayType: 'fadeIn',
					displayTypeSpeed: 400,
			});
	})(jQuery, window, document);

					},1000);

} );