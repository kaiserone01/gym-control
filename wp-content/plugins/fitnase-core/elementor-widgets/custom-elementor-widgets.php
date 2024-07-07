<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once( 'controls/icons.php' );

class Fitnase_Elementor_Custom_Widget {

	private static $instance = null;

	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	public function fitnase_add_elementor_custom_widgets() {
		require_once( 'brand-image-slider.php' );
		require_once( 'contact-form7-widget.php' );
		require_once( 'contact-info-widget.php' );
		require_once( 'fitnase-image.php' );
		require_once( 'home-slider.php' );
		require_once( 'icon-box.php' );
		require_once( 'photo-gallery.php' );
		require_once( 'pricing-table.php' );
		require_once( 'recent-posts.php' );
		require_once( 'section-title.php' );
		require_once( 'service-box.php' );
		require_once( 'service-info.php' );
		require_once( 'team-details.php' );
		require_once( 'team-member.php' );
		require_once( 'testimonial.php' );
		require_once( 'video-popup.php' );
	}

	public function init() {
		add_action( 'elementor/widgets/widgets_registered', array( $this, 'fitnase_add_elementor_custom_widgets' ) );
	}
}

Fitnase_Elementor_Custom_Widget::get_instance()->init();

// Add New Category In Elementor Widget

function fitnase_elementor_widget_categories( $elements_manager ) {

	$elements_manager->add_category(
		'fitnase_elements',
		[
			'title' => __( 'Fitnase Elements', 'fitnase-core' ),
		]
	);

}

add_action( 'elementor/elements/categories_registered', 'fitnase_elementor_widget_categories' );