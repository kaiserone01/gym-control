<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

// Remove CSF welcome page
add_filter( 'csf_welcome_page', '__return_false' );

/*
 *  Create theme options
 */

$fitnase_theme_option = 'fitnase_theme_options';

CSF::createOptions($fitnase_theme_option, array(
	'framework_title' => wp_kses(
		sprintf(__("Fitnase Options <small>V %s</small>", 'fitnase'), $fitnase_theme_data->get('Version')),
		array('small' => array())
	),
	'menu_title'      => esc_html__('Theme Options', 'fitnase'),
	'menu_slug'       => 'fitnase-options',
	'menu_type'       => 'submenu',
	'menu_parent'     => 'fitnase',
	'class'           => 'fitnase-theme-option-wrapper',
	'footer_credit'      => wp_kses(
		__( 'Developed by: <a target="_blank" href="https://fitnase.net">Fitnase</a>', 'fitnase' ),
		array(
			'a'      => array(
				'href'   => array(),
				'target' => array()
			),
		)
	),
	'async_webfont' => false,
	'defaults'        => fitnase_default_theme_options(),
));

/*
 * General options
 */
require_once 'general-options.php';

/*
 * Header options
 */
require_once 'typography-options.php';

/*
 * Header options
 */
require_once 'header-options.php';

/*
 * Page options
 */
require_once 'banner-options.php';


/*
 * Page options
 */
require_once 'page-options.php';

/*
 * Page options
 */
require_once 'blog-page-options.php';

/*
 * Post options
 */
require_once 'single-post-options.php';

/*
 * Service options
 */
require_once 'service-options.php';


/*
 * Team options
 */
require_once 'team-options.php';

/*
 * Project options
 */
//require_once 'project-options.php';

/*
 * WooCommerce Options
 */
if ( class_exists( 'WooCommerce' ) ) {
	require_once 'woocommerce-options/woocommerce-options.php';
}

/*
 * Search Page options
 */
require_once 'search-page-options.php';

/*
 * Error 404 Page options
 */
require_once 'error-page-options.php';

/*
 * Footer options
 */
require_once 'footer-options.php';



// Custom Css section
CSF::createSection( $fitnase_theme_option, array(
	'title'  => esc_html__( 'Custom Css', 'fitnase' ),
	'id'     => 'custom_css_options',
	'icon'   => 'fa fa-css3',
	'fields' => array(

		array(
			'id'       => 'fitnase_custom_css',
			'type'     => 'code_editor',
			'title'    => esc_html__( 'Custom Css', 'fitnase' ),
			'settings' => array(
				'theme'  => 'mbo',
				'mode'   => 'css',
			),
			'sanitize' => false,
		),
	)
) );


/*
 * Backup options
 */
CSF::createSection($fitnase_theme_option, array(
	'title'  => esc_html__('Backup', 'fitnase'),
	'id'     => 'backup_options',
	'icon'   => 'fa fa-window-restore',
	'fields' => array(
		array(
			'type' => 'backup',
		),
	)
));