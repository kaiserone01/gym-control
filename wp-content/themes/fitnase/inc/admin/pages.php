<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access directly.
/**
 *
 * Fitnase Admin Pages
 *
 */
if ( ! class_exists( 'Fitnase_Admin' ) ) {

  class Fitnase_Admin{
    private static $instance = null;

    public static function init() {
      if( is_null( self::$instance ) ) {
        self::$instance = new self();
      }
      return self::$instance;
    }

    public function __construct() {

      add_action( 'init', array( $this, 'fitnase_create_tgmpa_page' ), 1 );
      add_action( 'admin_menu', array( $this, 'fitnase_create_admin_page' ), 1 );
      add_action( 'admin_enqueue_scripts', array( $this, 'fitnase_admin_page_enqueue_scripts' ) );
      
      add_filter( 'ocdi/plugin_page_setup', array( $this, 'fitnase_pt_ocdi_page_setup' ) );
    
    }

    public function fitnase_create_admin_page() {
      add_menu_page( esc_html__( 'Fitnase', 'fitnase' ), esc_html__( 'Fitnase', 'fitnase' ), 'manage_options', 'fitnase', array( $this, 'fitnase_admin_page_dashboard' ), 'dashicons-screenoptions', 2 );
      add_submenu_page( 'fitnase', esc_html__( 'Welcome', 'fitnase' ), esc_html__( 'Welcome & Support', 'fitnase' ), 'manage_options', 'fitnase', array( $this, 'fitnase_admin_page_dashboard' ) );
    }

    public function fitnase_admin_page_dashboard() {
      require_once FITNASE_INC_DIR .'admin/page-dashboard.php';
    }

    public function fitnase_create_tgmpa_page() {
      require_once FITNASE_INC_DIR .'admin/class-tgm-plugin-activation.php';
      require_once FITNASE_INC_DIR .'admin/page-tgmpa.php';
    }

    public function fitnase_admin_page_enqueue_scripts() {
      wp_enqueue_style( 'fitnase-admin', get_theme_file_uri( 'inc/admin/assets/css/admin.css' ), array(), FITNASE_VERSION, 'all' );
    }

    public function fitnase_pt_ocdi_page_setup( $args ) {

      $args['parent_slug'] = 'fitnase';
      $args['menu_slug']   = 'fitnase-import-demo';
      $args['menu_title']  = esc_html__( 'Import Demo', 'fitnase' );
      $args['capability']  = 'manage_options';

      return $args;

    }

  }

  Fitnase_Admin::init();
}