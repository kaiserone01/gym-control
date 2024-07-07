<?php
// Create WooCommerce options section
CSF::createSection($fitnase_theme_option, array(
	'title' => esc_html__('WooCommerce', 'fitnase'),
	'id'    => 'td_woo_options',
	'icon'  => 'fa fa-shopping-cart',
));

CSF::createSection($fitnase_theme_option, array(
	'parent' => 'td_woo_options',
	'title'  => esc_html__('Shop Page', 'fitnase'),
	'icon'   => 'fa fa-shopping-bag',
	'fields' => array(

		array(
			'id'      => 'shop_page_layout',
			'type'    => 'select',
			'title'   => esc_html__('Shop Layout', 'fitnase'),
			'options' => array(
				'full-width'  => esc_html__('Full Width', 'fitnase'),
				'left-sidebar'  => esc_html__('Left Sidebar', 'fitnase'),
				'right-sidebar' => esc_html__('Right Sidebar', 'fitnase'),
			),
			'default' => 'full-width',
			'desc'    => esc_html__('Select shop page layout.', 'fitnase'),
		),

		array(
			'id'         => 'shop_default_sidebar',
			'type'       => 'select',
			'title'      => esc_html__( 'Sidebar', 'fitnase' ),
			'options'    => 'fitnase_sidebars',
			'default' => 'fitnase-shop-sidebar',
			'dependency' => array( 'shop_page_layout', '!=', 'full-width' ),
			'desc'       => esc_html__( 'Select shop page sidebar.', 'fitnase' ),
		),

		array(
			'id'         => 'shop_custom_title',
			'type'       => 'text',
			'title'      => esc_html__('Shop Title', 'fitnase'),
			'default' => esc_html__('Shop', 'fitnase'),
			'desc'       => esc_html__('Shop page banner title here.', 'fitnase')
		),

		array(
			'id'    => 'product_per_page',
			'type'  => 'text',
			'title' => esc_html__( 'Product Per Page', 'fitnase' ),
			'default' => 9,
			'desc'  => esc_html__( 'Type how many product you want to show per page. Number only.', 'fitnase' ),
		),

		array(
			'id'    => 'product_column',
			'type'  => 'text',
			'title' => esc_html__( 'Product Column Per Row', 'fitnase' ),
			'default' => 3,
			'desc'  => esc_html__( 'How many product you want to show per row. Number only.', 'fitnase' ),
		),

		array(
			'id'       => 'product_quick_view',
			'type'     => 'switcher',
			'title'    => esc_html__('Enable Quick View Icon', 'fitnase'),
			'default'  => true,
			'text_on'  => esc_html__('Yes', 'fitnase'),
			'text_off' => esc_html__('No', 'fitnase'),
			'desc'     => esc_html__('Enable or disable product quick view icon.', 'fitnase'),
		),

		array(
			'id'       => 'product_wish_list',
			'type'     => 'switcher',
			'title'    => esc_html__('Enable Wish list Icon', 'fitnase'),
			'default'  => true,
			'text_on'  => esc_html__('Yes', 'fitnase'),
			'text_off' => esc_html__('No', 'fitnase'),
			'desc'     => esc_html__('Enable or disable product wish list icon.', 'fitnase'),
		),
	)
));

CSF::createSection($fitnase_theme_option, array(
	'parent' => 'td_woo_options',
	'title'  => esc_html__('Single Product', 'fitnase'),
	'icon'   => 'fa fa-product-hunt',
	'fields' => array(

		array(
			'id'      => 'product_page_layout',
			'type'    => 'select',
			'title'   => esc_html__('Product Layout', 'fitnase'),
			'options' => array(
				'full-width'  => esc_html__('Full Width', 'fitnase'),
				'left-sidebar'  => esc_html__('Left Sidebar', 'fitnase'),
				'right-sidebar' => esc_html__('Right Sidebar', 'fitnase'),
			),
			'default' => 'right-sidebar',
			'desc'    => esc_html__('Select product layout.', 'fitnase'),
		),

		array(
			'id'         => 'product_default_sidebar',
			'type'       => 'select',
			'title'      => esc_html__( 'Sidebar', 'fitnase' ),
			'options'    => 'fitnase_sidebars',
			'default' => 'fitnase-shop-sidebar',
			'dependency' => array( 'product_page_layout', '!=', 'full-width' ),
			'desc'       => esc_html__( 'Select product sidebar.', 'fitnase' ),
		),

		array(
			'id'         => 'product_banner_title',
			'type'       => 'text',
			'title'      => esc_html__('Product Banner Title', 'fitnase'),
			'default' => esc_html__('Shop', 'fitnase'),
			'desc'       => esc_html__('If not empty, this title will show for all single product\'s banner title. Make this field empty to show product default title. You can overwrite it on the individual product page.', 'fitnase')
		),

		array(
			'id'       => 'product_sku',
			'type'     => 'switcher',
			'title'    => esc_html__('Show SKU', 'fitnase'),
			'default'  => true,
			'text_on'  => esc_html__('Yes', 'fitnase'),
			'text_off' => esc_html__('No', 'fitnase'),
			'desc'     => esc_html__('Show / Hide product SKU.', 'fitnase'),
		),

		array(
			'id'       => 'product_cat',
			'type'     => 'switcher',
			'title'    => esc_html__('Show Category', 'fitnase'),
			'default'  => true,
			'text_on'  => esc_html__('Yes', 'fitnase'),
			'text_off' => esc_html__('No', 'fitnase'),
			'desc'     => esc_html__('Show / Hide product category.', 'fitnase'),
		),

		array(
			'id'       => 'product_tag',
			'type'     => 'switcher',
			'title'    => esc_html__('Show Tags', 'fitnase'),
			'default'  => true,
			'text_on'  => esc_html__('Yes', 'fitnase'),
			'text_off' => esc_html__('No', 'fitnase'),
			'desc'     => esc_html__('Show / Hide product tags.', 'fitnase'),
		),

		array(
			'id'       => 'show_related_products',
			'type'     => 'switcher',
			'title'    => esc_html__('Show Related Products', 'fitnase'),
			'default'  => true,
			'text_on'  => esc_html__('Yes', 'fitnase'),
			'text_off' => esc_html__('No', 'fitnase'),
			'desc'     => esc_html__('Show / Hide related products.', 'fitnase'),
		),

		array(
			'id'    => 'related_products_column',
			'type'  => 'text',
			'title' => esc_html__( 'Related Products Column', 'fitnase' ),
			'default' => 3,
			'desc'  => esc_html__( 'How many product you want to show per row. Number only.', 'fitnase' ),
			'dependency'            => array('show_related_products', '==', true),
		),
	)
));