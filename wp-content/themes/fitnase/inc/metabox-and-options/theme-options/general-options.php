<?php

// Create general section
CSF::createSection( $fitnase_theme_option, array(
	'title'  => esc_html__( 'General Options', 'fitnase' ),
	'id'     => 'general_options',
	'icon'   => 'fa fa-google',
	'fields' => array(
		array(
			'id'       => 'theme_primary_color',
			'type'     => 'color',
			'title'    => esc_html__( 'Primary Color', 'fitnase' ),
			'desc'     => esc_html__( 'Select theme primary color. Few colors not change from here. You can change them from individual Elementor widget.', 'fitnase' ),
			'output'   => array(
				'background-color' => '.ep-primary-bg, .sidebar-widget-area .widget.widget_categories a:hover, .sidebar-widget-area .widget.widget_archive li:hover a, .sidebar-widget-area .widget.widget_pages li a:hover, .sidebar-widget-area .widget.widget_meta li a:hover, .sidebar-widget-area .widget.widget_nav_menu li a:hover, .sidebar-widget-area .widget.widget_nav_menu li.current-menu-item a, .sidebar-widget-area .widget.widget_fitnase_nav_menu li a:hover, .sidebar-widget-area .widget.widget_fitnase_nav_menu li.current-menu-item a, .widget_calendar .wp-calendar-table tbody td a, .widget.widget_tag_cloud a:hover,
button[type="submit"], .post-pagination ul li a:hover, .page-links a:hover, .post-pagination ul li span.current, .page-links .current, .ep-button, .woocommerce .widget_shopping_cart .cart_list li a.remove, .woocommerce.widget_shopping_cart .cart_list li a.remove, .woocommerce a.button, .post-tags a, .no-thumb .blog-next-prev-img, .blog-next-prev-img:before, .post-details-wrapper article .entry-content .wp-block-button__link, .post-details-wrapper article .entry-content .wp-block-file .wp-block-file__button,
.wp-block-tag-cloud a, input[type="submit"], .slick-dots button, .ep-single-icon-box:hover .ep-icon-box-icon, .ep-video-button:before, .ep-video-button:after, .slick-arrow, .ep-photo-gallery-wrapper .slick-dots button:hover,
.ep-photo-gallery-wrapper .slick-dots .slick-active button, .ep-recent-post-date:before, .widget-social-icons li a:hover, .scroll-to-top, .widget form.search-form button[type="submit"]:hover, .widget.widget_product_categories li a:hover, .woocommerce span.onsale, ul.ep-post-list li:hover:before, .woocommerce nav.woocommerce-pagination ul li a:hover, .woocommerce nav.woocommerce-pagination ul li span.current, .sidebar-widget-area .widget.widget_layered_nav li a:hover,.sidebar-widget-area .widget.widget_layered_nav li.chosen a, .woocommerce .widget_layered_nav_filters ul li:hover, .woocommerce-cart-form__cart-item.cart_item td.product-remove a,
.woocommerce .widget_price_filter .ui-slider .ui-slider-range, .woocommerce .widget_price_filter .ui-slider .ui-slider-handle,
.woocommerce button.button, .woocommerce div.product div.images .woocommerce-product-gallery__trigger, .woocommerce button.button.alt, div#review_form_wrapper .form-submit button[type="submit"], .woocommerce a.button.alt,.woocommerce button.button.alt.disabled, .woocommerce button.button.alt.disabled:hover, .woocommerce div.product form.cart .reset_variations, .woocommerce div.product form.cart .reset_variations:hover, .woocommerce.ep-product-list-view .ep-shop-page a.added_to_cart,
.woocommerce-MyAccount-navigation ul li.is-active a, .woocommerce-MyAccount-navigation ul li a:hover, .mfp-iframe-holder .mfp-close,
.mfp-image-holder .mfp-close, .header-mini-cart .cart-product-count, .ep-member-img-and-info:hover .ep-member-info-wrapper,
.ep-member-img-and-info:hover .ep-member-info-wrapper:before, .tinv-wishlist .product-remove button',

				'color' => '.ep-primary-color, a:hover, .widget.widget_rss .rss-date, .ep-button:hover, input[type="submit"]:hover, button[type="submit"]:hover,
.post-meta li i, .post-meta li a:hover, .sticky .post-content-wrapper:before, .header-top-are i, .header-top-are li:before, .comment-metadata time, .comments-area .reply a:hover, .comment-author.vcard .fn a:hover,.header-top-are li a:hover, .main-navigation ul li a:hover,
.main-navigation ul li.current-menu-item > a,.main-navigation ul li.current_page_item > a,.main-navigation ul li.current-menu-ancestor > a, .main-navigation ul li.current_page_ancestor > a,.main-navigation ul ul li a:hover,.main-navigation ul ul li.current-menu-item > a,
.main-navigation ul ul li.current_page_item > a,.main-navigation ul ul li.current-menu-ancestor > a, .main-navigation ul ul li.current_page_ancestor > a,.slicknav_nav a:hover, .slicknav_item.slicknav_row:hover a, .slicknav_item.slicknav_row:hover .slicknav_arrow, .slicknav_menu .current-menu-item > a, .slicknav_menu .current-menu-item .slicknav_row > a, .slicknav_menu .current-menu-ancestor > a, .slicknav_menu .current-menu-ancestor > .slicknav_row > a, .current-menu-ancestor > .slicknav_row .slicknav_arrow, .current-menu-item .slicknav_row .slicknav_arrow,.post-tags a:hover, .post-details-wrapper article .entry-content .wp-block-button__link:hover, .ep-service-title:hover,.post-details-wrapper article .entry-content .wp-block-file .wp-block-file__button:hover, .post-details-wrapper article .entry-content .is-style-outline .wp-block-button__link:hover, .post-details-wrapper article .entry-content .is-style-outline .wp-block-button__link, .wp-block-tag-cloud a:hover,
.ep-testimonial-slider-wrapper .slick-arrow, .ep-recent-post-date a, .breadcrumb-container, .breadcrumb-container a, .breadcrumb-container a:hover, .ep-product-thumb-buttons a:hover i,.ep-product-thumb-buttons .tinvwl_add_to_wishlist_button:hover,
.ep-team-details-wrapper .widget-social-icons li a:hover, .bypostauthor .comment-author.vcard .fn:after, ul.ep-post-list li:before, .ep-recent-widget-date a, .ep-recent-widget-date i, .ep-product-grid-view #ep-shop-view-mode .ep-shop-grid, .ep-product-list-view #ep-shop-view-mode .ep-shop-list, #ep-shop-view-mode li:hover,.woocommerce #respond input#submit:hover,
.woocommerce a.button:hover,.woocommerce button.button:hover, .widget_product_tag_cloud a:hover,.woocommerce input.button:hover,
.woocommerce #respond input#submit.alt:hover,.woocommerce a.button.alt:hover,.woocommerce button.button.alt:hover,
.woocommerce input.button.alt:hover,div#review_form_wrapper .form-submit button[type="submit"]:hover, .woocommerce .woocommerce-cart-form__contents button.button:disabled:hover,.woocommerce .woocommerce-cart-form__contents button.button:disabled[disabled]:hover,.woocommerce div.product .woocommerce-tabs ul.tabs li.active a, .woocommerce div.product .woocommerce-tabs ul.tabs li a:hover, .comment-form-rating a',

				'border-color' => '.widget.widget_tag_cloud a:hover, button[type="submit"], input[type="submit"], button[type="submit"]:hover, .post-pagination ul li a:hover, .page-links a:hover, .post-pagination ul li span.current, .page-links .current, .ep-button, .ep-button:hover, input[type="submit"]:hover, button[type="submit"]:hover, .woocommerce a.button, .post-tags a,input:focus, input[type=text]:focus, input[type=email]:focus, input[type=password]:focus, input[type=url]:focus, input[type=search]:focus, input[type=tel]:focus, input[type=number]:focus, input[type=date]:focus, textarea:focus,.comment-message textarea:focus, .post-details-wrapper article .entry-content .wp-block-button__link, .wp-block-quote.is-style-large, .wp-block-quote.has-text-align-right, .woocommerce form .form-row.woocommerce-validated .select2-container, .woocommerce form .form-row.woocommerce-validated input.input-text, .woocommerce form .form-row.woocommerce-validated select,
.post-details-wrapper article .entry-content .wp-block-file .wp-block-file__button, .post-details-wrapper article .entry-content .is-style-outline .wp-block-button__link:hover, .post-details-wrapper article .entry-content .is-style-outline .wp-block-button__link, blockquote.wp-block-quote, blockquote, .wp-block-tag-cloud a, .woocommerce .woocommerce-cart-form__contents button.button:disabled:hover, .woocommerce .woocommerce-cart-form__contents button.button:disabled[disabled]:hover,
.widget-social-icons li a:hover, .woocommerce div.product div.images .woocommerce-product-gallery__trigger,
.woocommerce button.button.alt:hover, div#review_form_wrapper .form-submit button[type="submit"]:hover, .woocommerce.ep-product-list-view .ep-shop-page a.added_to_cart, .woocommerce #respond input#submit:hover,
.woocommerce a.button:hover,.woocommerce button.button:hover,.woocommerce input.button:hover,.woocommerce #respond input#submit.alt:hover,
.woocommerce a.button.alt:hover,.woocommerce button.button.alt:hover,.woocommerce input.button.alt:hover,div#review_form_wrapper .form-submit button[type="submit"]:hover,
.woocommerce .woocommerce-cart-form__contents button.button:disabled:hover,.woocommerce .woocommerce-cart-form__contents button.button:disabled[disabled]:hover,.ep-pricing-price-wrapper:before, .woocommerce #respond input#submit,.woocommerce a.button,
.woocommerce button.button,.woocommerce input.button,.woocommerce #respond input#submit.alt,.woocommerce a.button.alt,
.woocommerce button.button.alt, .woocommerce #content table.cart td.actions .input-text:focus, .woocommerce table.cart td.actions .input-text:focus,.woocommerce-page #content table.cart td.actions .input-text:focus,
.woocommerce-page table.cart td.actions .input-text:focus, .tinv-wishlist .product-remove button,.woocommerce input.button.alt,
div#review_form_wrapper .form-submit button[type="submit"],.fitnase-contact-form-container select:focus,.fitnase-contact-form-container .ep-form-control-wrapper input:focus,.fitnase-contact-form-container textarea:focus, .widget_product_tag_cloud a:hover',

				'fill' => '.ep-primary-color svg',
			),
		),

		array(
			'id'       => 'enable_preloader',
			'type'     => 'switcher',
			'title'    => esc_html__( 'Enable Pre Loader', 'fitnase' ),
			'text_on'  => esc_html__( 'Yes', 'fitnase' ),
			'text_off' => esc_html__( 'No', 'fitnase' ),
			'desc'     => esc_html__( 'Enable or disable Site Preloader.', 'fitnase' ),
			'default'  => true
		),

		array(
			'id'           => 'preloader_image',
			'type'         => 'media',
			'title'        => esc_html__( 'Preloader Image', 'fitnase' ),
			'library'      => 'image',
			'url'          => false,
			'button_title' => esc_html__( 'Upload Image', 'fitnase' ),
			'desc'         => esc_html__( 'Upload Preloader image', 'fitnase' ),
			'dependency'   => array( 'enable_preloader', '==', 'true' ),

		),

		array(
			'id'          => 'preloader_background_color',
			'type'        => 'color',
			'title'       => esc_html__( 'Preloader Background Color', 'fitnase' ),
			'desc'        => esc_html__( 'Select preloader background color.', 'fitnase' ),
			'dependency'  => array( 'enable_preloader', '==', true ),
			'output'      => '.preloader-wrapper',
			'output_mode' => 'background-color',
		),
	),
) );