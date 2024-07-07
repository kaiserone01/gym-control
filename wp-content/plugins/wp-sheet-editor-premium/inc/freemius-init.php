<?php

defined( 'ABSPATH' ) || exit;
// Create a helper function for easy SDK access.
if ( !function_exists( 'vgse_freemius' ) ) {
    function vgse_freemius()
    {
        global  $vgse_freemius ;
        
        if ( !isset( $vgse_freemius ) ) {
            // Include Freemius SDK.
            require_once VGSE_DIST_DIR . '/vendor/freemius/start.php';
            if ( !defined( 'WP_FS__PRODUCT_1010_MULTISITE' ) ) {
                define( 'WP_FS__PRODUCT_1010_MULTISITE', true );
            }
            $vgse_freemius = fs_dynamic_init( array(
                'id'             => '1010',
                'slug'           => 'wp-sheet-editor-bulk-spreadsheet-editor-for-posts-and-pages',
                'premium_slug'   => 'wp-sheet-editor-premium',
                'type'           => 'plugin',
                'public_key'     => 'pk_ec1c7da603c0772f1bfe276efb715',
                'is_premium'     => true,
                'has_addons'     => false,
                'has_paid_plans' => true,
                'anonymous_mode' => ( date( 'Y-m-d' ) < '2020-10-20' ? true : false ),
                'menu'           => array(
                'slug'       => 'vg_sheet_editor_setup',
                'first-path' => 'admin.php?page=vg_sheet_editor_setup',
                'support'    => false,
            ),
                'is_live'        => true,
            ) );
        }
        
        return $vgse_freemius;
    }

}
// Init Freemius.
vgse_freemius();
vgse_freemius()->add_filter( 'show_deactivation_feedback_form', '__return_false' );
// Signal that SDK was initiated.
do_action( 'vgse_freemius_loaded' );