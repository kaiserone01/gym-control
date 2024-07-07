<?php

function fitnase_install_required_plugins() {

	$plugins = array(

		array(
			'name'     => esc_html__('Breadcrumb NavXT', 'fitnase'),
			'slug'     => 'breadcrumb-navxt',
			'version'  => '6.6.0',
			'required' => false,
		),

		array(
			'name'     => esc_html__('Codestar Framework', 'fitnase'),
			'slug'     => 'codestar-framework',
			'source'   => get_template_directory(). '/inc/plugins/codestar-framework.zip',
			'version'  => '2.2.2',
			'required' => true
		),


		array(
			'name'     => esc_html__('Contact Form 7', 'fitnase'),
			'slug'     => 'contact-form-7',
			'version'  => '5.4.1',
			'required' => false
		),

		array(
			'name'     => esc_html__('Elementor Page Builder', 'fitnase'),
			'slug'     => 'elementor',
			'version'  => '3.2.3',
			'required' => true,
		),



		array(
			'name'     => esc_html__('One Click Demo Import', 'fitnase'),
			'slug'     => 'one-click-demo-import',
			'version'  => '3.0.2',
			'required' => false,
		),


		array(
			'name'     => esc_html__('Fitnase Core', 'fitnase'),
			'slug'     => 'fitnase-core',
			'source'   => get_template_directory(). '/inc/plugins/fitnase-core.zip',
			'version'  => '1.0.1',
			'required' => true
		),

		array(
			'name'     => esc_html__('Fitness Trainer', 'fitnase'),
			'slug'     => 'fitness-trainer',
			'source'   => get_template_directory(). '/inc/plugins/fitness-trainer.zip',
			'version'  => '1.5.8',
			'required' => true
		),

		array(
			'name'     => esc_html__('TI WooCommerce Wishlist', 'fitnase'),
			'slug'     => 'ti-woocommerce-wishlist',
			'version'  => '1.25.5',
			'required' => false,
		),

		array(
			'name'     => esc_html__('WooCommerce', 'fitnase'),
			'slug'     => 'woocommerce',
			'version'  => '5.4.1',
			'required' => false,
		),

		array(
			'name'     => esc_html__('YITH WooCommerce Quick View', 'fitnase'),
			'slug'     => 'yith-woocommerce-quick-view',
			'version'  => '1.6.1',
			'required' => false,
		),
	);

	$config = array(
		'id'           => 'fitnase',
		'parent_slug'  => 'fitnase',
		'menu'         => 'fitnase-plugins',
		'has_notices'  => true,
		'dismissable'  => true,
		'is_automatic' => false,
		'dismiss_msg'  => '',
		'message'      => '',
		'default_path' => '',
	);

	tgmpa($plugins, $config);
}

add_action('tgmpa_register', 'fitnase_install_required_plugins');