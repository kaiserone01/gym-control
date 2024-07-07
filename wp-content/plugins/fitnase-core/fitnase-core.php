<?php
/*
Plugin Name: Fitnase Core
Author: e-plugins
Author URI: http://e-plugins.com/
Version: 1.0.1
Description: This plugin is required for Fitnase WordPress theme
Text Domain: fitnase-core
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

define( 'FITNASE_CORE_VERSION', '1.0.1' );

define( 'FITNASE_CORE', WP_PLUGIN_URL . '/' . plugin_basename( dirname( __FILE__ ) ) .'/');

/*
 * Translate direction
 */
load_plugin_textdomain( 'fitnase-core', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );


/*
 * Fitnase core functions
 */
require_once('inc/fitnase-core-functions.php' );

/*
 * Register Custom Widget
 */
if (class_exists( 'CSF' )){
	require_once('inc/widgets/custom-wp-widgets.php' );
}

//Register Custom Elementor Widget
if(defined( 'ELEMENTOR_PATH' )){
	define( 'FITNASE_CORE_ELEMENTOR_ASSETS', trailingslashit( FITNASE_CORE . 'elementor-widgets/assets' ) );
	require_once('elementor-widgets/custom-elementor-widgets.php' );
}

//Register Custom Posts
require_once('inc/register-custom-posts.php' );
add_filter( 'gutenberg_use_widgets_block_editor', '__return_false', 100 );
add_filter( 'use_widgets_block_editor', '__return_false' );