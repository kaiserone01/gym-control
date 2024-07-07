<?php

//Register widget area
function fitnase_widgets_init() {
	register_sidebar(array(
		'name'          => esc_html__('Sidebar', 'fitnase'),
		'id'            => 'fitnase-sidebar',
		'description'   => esc_html__('Add widgets here.', 'fitnase'),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	));


	register_sidebar(array(
		'name'          => esc_html__('Service Sidebar', 'fitnase'),
		'id'            => 'fitnase-service-sidebar',
		'description'   => esc_html__('Add service widgets here.', 'fitnase'),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	));


	register_sidebar(array(
		'name'          => esc_html__('Team Sidebar', 'fitnase'),
		'id'            => 'fitnase-team-sidebar',
		'description'   => esc_html__('Add team widgets here.', 'fitnase'),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	));

	$footer_widget_column = fitnase_option('footer_widget_column', 'col-lg-3');
	register_sidebar(array(
		'name'          => esc_html__('Footer Widget', 'fitnase'),
		'id'            => 'fitnase-footer-widget',
		'description'   => esc_html__('Add footer widgets here.', 'fitnase'),
		'before_widget' => '<div id="%1$s" class="widget '.esc_attr($footer_widget_column).' col-md-6 %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	));

	/**
	 * Load Shop Sidebar.
	 */
	if ( class_exists( 'WooCommerce' ) ) {
		register_sidebar(array(
			'name'          => esc_html__('Shop Sidebar', 'fitnase'),
			'id'            => 'fitnase-shop-sidebar',
			'description'   => esc_html__('Add shop widgets here.', 'fitnase'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		));
	}
}

add_action('widgets_init', 'fitnase_widgets_init');