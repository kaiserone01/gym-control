<?php

class Fitnase_Custom_Elementor_Icons_Base {
	private static $instance = null;

	public static function instance() {
		if (is_null(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function __construct() {
		Fitnase_Custom_Elementor_Icons_Assets::init();
		Fitnase_Custom_Elementor_Icons_Tab::init();
	}
}

Fitnase_Custom_Elementor_Icons_Base::instance();

/*
 *  Load icon assets
 */

class Fitnase_Custom_Elementor_Icons_Assets {

	public static function init() {
		add_action('wp_enqueue_scripts', [__CLASS__, 'frontend_enqueue'], 99);
		add_action('elementor/editor/before_enqueue_scripts', [__CLASS__, 'enqueue_editor_scripts']);
	}

	public static function frontend_enqueue() {
		wp_enqueue_style('flaticon', FITNASE_CORE_ELEMENTOR_ASSETS . 'fonts/flaticon.css', null, '1.0.0');

	}

	public static function enqueue_editor_scripts() {

		wp_enqueue_style('flaticon', FITNASE_CORE_ELEMENTOR_ASSETS . 'fonts/flaticon.css', null, '1.0.0');
	}
}

/*
 *  Add new icons tab
 */
class Fitnase_Custom_Elementor_Icons_Tab {

	public static function init() {

		add_filter('elementor/icons_manager/additional_tabs', [__CLASS__, 'fitnase_add_flaticon_fitness_icon']);
	}

	public static function fitnase_add_flaticon_fitness_icon($fitnase_icon_tab) {
		$fitnase_icon_tab['fitnase-fitness-icon'] = [
			'name' => 'fitnase-fitness-icon',
			'label' => __( 'Fitnase Icons', 'fitnase-core' ),
			'labelIcon' => 'flaticon-dumbbell',
			'url' => FITNASE_CORE_ELEMENTOR_ASSETS . 'fonts/flaticon.css',
			'enqueue' => [ FITNASE_CORE_ELEMENTOR_ASSETS . 'fonts/flaticon.css' ],
			'prefix' => '',
			'displayPrefix' => 'ep-icon',
			'ver' => '1.0.0',
			'fetchJson' => FITNASE_CORE_ELEMENTOR_ASSETS . 'fonts/js/flaticon.js',
			'native' => true,
		];
		return $fitnase_icon_tab;
	}
}

function fitnase_elementor_version( $operator = '<', $version = '2.6.0' ) {
	return defined( 'ELEMENTOR_VERSION' ) && version_compare( ELEMENTOR_VERSION, $version, $operator );
}

/*
 * Render Icons
 */

function fitnase_custom_icon_render( $settings = [], $old_icon_id = 'icon', $new_icon_id = 'selected_icon', $attributes = [] ) {
	// Check if its already migrated
	$migrated = isset( $settings['__fa4_migrated'][ $new_icon_id ] );
	// Check if its a new widget without previously selected icon using the old Icon control
	$is_new = empty( $settings[ $old_icon_id ] );

	$attributes['aria-hidden'] = 'true';

	if ( fitnase_elementor_version( '>=', '2.6.0' ) && ( $is_new || $migrated ) ) {
		\Elementor\Icons_Manager::render_icon( $settings[ $new_icon_id ], $attributes );
	} else {
		if ( empty( $attributes['class'] ) ) {
			$attributes['class'] = $settings[ $old_icon_id ];
		} else {
			if ( is_array( $attributes['class'] ) ) {
				$attributes['class'][] = $settings[ $old_icon_id ];
			} else {
				$attributes['class'] .= ' ' . $settings[ $old_icon_id ];
			}
		}
		printf( '<i %s></i>', \Elementor\Utils::render_html_attributes( $attributes ) );
	}
}