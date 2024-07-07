<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function fitnase_default_theme_options() {

	$allow_html = array(
		'a'      => array(
			'href'   => array(),
			'target' => array()
		),
		'strong' => array(),
		'small'  => array(),
		'span'   => array(),
		'p'      => array(),
		'h1'     => array(),
		'h2'     => array(),
		'h3'     => array(),
		'h4'     => array(),
		'h5'     => array(),
		'h6'     => array(),
	);

	return array(
		'copyright_text' => wp_kses(
			__( '&copy; Fitnase 2021 | All Right Reserved', 'fitnase' ), $allow_html

		),

		'footer_info_left_text' => wp_kses(
			__( 'Fitnase | Developed by: <a target="_blank" href="http://e-plugins.com/">e-plugins</a>', 'fitnase' ), $allow_html

		),

		'not_found_text' => wp_kses(
			__( '<h2>Oops!</h2><p>Sorry, The page you are looking for no longer exists.</p>', 'fitnase' ), $allow_html
		),

		'post_banner_title'   => esc_html__( 'Blog', 'fitnase' ),
		'blog_title'          => esc_html__( 'Blog', 'fitnase' ),
		'blog_read_more_text' => esc_html__( 'Read More', 'fitnase' ),
		'error_page_title'    => esc_html__( 'Error 404', 'fitnase' ),
		'search_placeholder'  => esc_html__( 'Search...', 'fitnase' ),
		'cta_text'            => esc_html__( 'Contact Us', 'fitnase' ),
	);
}

//Add custom icon set


/**
 * Enqueue Backend Styles And Scripts.
 **/

function fitnase_enqueue_backend_icon_for_csf() {
	wp_enqueue_style( 'flaticon', get_theme_file_uri( 'assets/fonts/flaticon/flaticon.css' ), array(), '1.0.0', 'all' );
}

add_action( 'admin_enqueue_scripts', 'fitnase_enqueue_backend_icon_for_csf' );


if ( ! function_exists( 'fitnase_csf_custom_icons' ) ) {

	function fitnase_csf_custom_icons( $icons ) {

		// Adding new icons
		$icons[] = array(
			'title' => esc_html__( 'FlatIcon', 'fitnase' ),
			'icons' => array(
				'flaticon-muscle'                          => 'flaticon-muscle',
				'flaticon-exercise'                        => 'flaticon-exercise',
				'flaticon-stationary-bike'                 => 'flaticon-stationary-bike',
				'flaticon-exercise-1'                      => 'flaticon-exercise-1',
				'flaticon-weightlifter'                    => 'flaticon-weightlifter',
				'flaticon-tape-measure'                    => 'flaticon-tape-measure',
				'flaticon-dumbbell'                        => 'flaticon-dumbbell',
				'flaticon-hand-grip'                       => 'flaticon-hand-grip',
				'flaticon-skipping-rope'                   => 'flaticon-skipping-rope',
				'flaticon-dumbbell-1'                      => 'flaticon-dumbbell-1',
				'flaticon-exercise-2'                      => 'flaticon-exercise-2',
				'flaticon-fitness'                         => 'flaticon-fitness',
				'flaticon-dancing'                         => 'flaticon-dancing',
				'flaticon-fitness-1'                       => 'flaticon-fitness-1',
				'flaticon-gym'                             => 'flaticon-gym',
				'flaticon-dumbbell-2'                      => 'flaticon-dumbbell-2',
				'flaticon-strongman'                       => 'flaticon-strongman',
				'flaticon-muscular-bodybuilder-with-clock' => 'flaticon-muscular-bodybuilder-with-clock',
				'flaticon-muscular'                        => 'flaticon-muscular',
				'flaticon-muscles'                         => 'flaticon-muscles',
				'flaticon-abs'                             => 'flaticon-abs',
				'flaticon-weightlifting'                   => 'flaticon-weightlifting',
				'flaticon-telephone'                       => 'flaticon-telephone',
				'flaticon-email'                           => 'flaticon-email',
				'flaticon-pin'                             => 'flaticon-pin',
				'flaticon-right-arrow'                     => 'flaticon-right-arrow',
				'flaticon-shopping-cart'                   => 'flaticon-shopping-cart',
			),
		);

		return $icons;
	}

	add_filter( 'csf_field_icon_add_icons', 'fitnase_csf_custom_icons' );
}