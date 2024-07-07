<?php
	/**
		*
		*
		* @version 1.5.8
		* @package Main
		* @author e-plugin.com 
	*/
	/*
		Plugin Name: Fitness Trainer
		Plugin URI: http://e-plugin.com/
		Description: Build Paid fitness site using Wordpress.No programming knowledge required.
		Author: e-plugin
		Author URI: http://e-plugin.com/
		Version: 1.5.8
		Text Domain: epfitness
		License: GPLv3
	*/
	// Exit if accessed directly
  if (!defined('ABSPATH')) {
  	exit;
	}
  if (!class_exists('wp_ep_fitness')) {  	
		final class wp_ep_fitness {
			private static $instance;
			/**
				* The Plug-in version.
				*
				* @var string
			*/
			public $version = "1.5.8";
			/**
				* The minimal required version of WordPress for this plug-in to function correctly.
				*
				* @var string
			*/
			public $wp_version = "3.5";
			public static function instance() {
				if (!isset(self::$instance) && !(self::$instance instanceof wp_ep_fitness)) {
					self::$instance = new wp_ep_fitness;
				}
				return self::$instance;
			}
			/**
				* Construct and start the other plug-in functionality
			*/
			public function __construct() {
				//
				// 1. Plug-in requirements
				//
				if (!$this->check_requirements()) {
					return;
				}
				//
				// 2. Declare constants and load dependencies
				//
				$this->define_constants();
				$this->load_dependencies();
				//
				// 3. Activation Hooks
				//
				register_activation_hook(__FILE__, array(&$this, 'activate'));
				register_deactivation_hook(__FILE__, array(&$this, 'deactivate'));
				register_uninstall_hook(__FILE__, 'wp_ep_fitness::uninstall');
				//
				// 4. Load Widget
				//
				add_action('widgets_init', array(&$this, 'register_widget'));
				//
				// 5. i18n
				//
				add_action('init', array(&$this, 'i18n'));
				//
				// 6. Actions
				//
				add_action('wp_ajax_ep_fitness_registration_submit', array($this, 'ep_fitness_registration_submit'));
				add_action('wp_ajax_nopriv_ep_fitness_registration_submit', array($this, 'ep_fitness_registration_submit'));
				add_action('wp_ajax_ep_fitness_user_exist_check', array($this, 'ep_fitness_user_exist_check'));
				add_action('wp_ajax_nopriv_ep_fitness_user_exist_check', array($this, 'ep_fitness_user_exist_check'));
				add_action('wp_ajax_ep_fitness_check_coupon', array($this, 'ep_fitness_check_coupon'));
				add_action('wp_ajax_nopriv_ep_fitness_check_coupon', array($this, 'ep_fitness_check_coupon'));					
				add_action('wp_ajax_ep_fitness_check_package_amount', array($this, 'ep_fitness_check_package_amount'));
				add_action('wp_ajax_nopriv_ep_fitness_check_package_amount', array($this, 'ep_fitness_check_package_amount'));
				add_action('wp_ajax_ep_fitness_update_profile_pic', array($this, 'ep_fitness_update_profile_pic'));
				add_action('wp_ajax_ep_fitness_update_profile_setting', array($this, 'ep_fitness_update_profile_setting'));					
				add_action('wp_ajax_ep_fitness_save_listing', array($this, 'ep_fitness_save_listing'));
				add_action('wp_ajax_ep_fitness_update_setting_fb', array($this, 'ep_fitness_update_setting_fb'));
				add_action('wp_ajax_ep_fitness_update_setting_hide', array($this, 'ep_fitness_update_setting_hide'));
				add_action('wp_ajax_ep_fitness_update_setting_password', array($this, 'ep_fitness_update_setting_password'));
				add_action('wp_ajax_ep_fitness_check_login', array($this, 'ep_fitness_check_login'));
				add_action('wp_ajax_nopriv_ep_fitness_check_login', array($this, 'ep_fitness_check_login'));
				add_action('wp_ajax_ep_fitness_forget_password', array($this, 'ep_fitness_forget_password'));
				add_action('wp_ajax_nopriv_ep_fitness_forget_password', array($this, 'ep_fitness_forget_password'));
				add_action('wp_ajax_ep_fitness_cancel_stripe', array($this, 'ep_fitness_cancel_stripe'));
				add_action('wp_ajax_ep_fitness_cancel_paypal', array($this, 'ep_fitness_cancel_paypal'));
				add_action('wp_ajax_ep_fitness_profile_stripe_upgrade', array($this, 'ep_fitness_profile_stripe_upgrade'));
				add_action('wp_ajax_ep_fitness_cron_job', array($this, 'ep_fitness_cron_job'));
				add_action('wp_ajax_nopriv_ep_fitness_cron_job', array($this, 'ep_fitness_cron_job'));	
				add_action('wp_ajax_ep_fitness_cpt_change', array($this, 'ep_fitness_cpt_change'));
				add_action('wp_ajax_nopriv_ep_fitness_cpt_change', array($this, 'ep_fitness_cpt_change'));	
				add_action('wp_ajax_ep_fitness_save_record', array($this, 'ep_fitness_save_record'));
				add_action('wp_ajax_ep_fitness_save_record_pt', array($this, 'ep_fitness_save_record_pt'));
				add_action('wp_ajax_ep_fitness_update_record', array($this, 'ep_fitness_update_record'));
				add_action('wp_ajax_ep_fitness_update_listing', array($this, 'ep_fitness_update_listing'));
				add_action('wp_ajax_iv_training_done', array($this, 'iv_training_done'));					
				add_action('wp_ajax_ep_fitness_update_expert_review', array($this, 'ep_fitness_update_expert_review'));				
				add_action('wp_ajax_ep_fitness_save_report1', array($this, 'ep_fitness_save_report1'));
				add_action('wp_ajax_ep_fitness_delete_report', array($this, 'ep_fitness_delete_report'));
				add_action('plugins_loaded', array($this, 'start'));
				add_action('add_meta_boxes', array($this, 'prfx_custom_meta_iv_listing'));				
				add_action('save_post', array($this, 'iv_listing_meta_save'));
				add_action( 'init', array($this, 'ep_fitness_paypal_form_submit') );
				add_action( 'init', array($this, 'ep_fitness_stripe_form_submit') );	
				add_action( 'init', array($this, 'ep_fitness_pdf_report') );
				add_action( 'init', array($this, 'ep_fitness_pdf_post') );					
				add_action('wp_login', array($this, 'check_expiry_date'));					
				add_action('pre_get_posts',array($this, 'iv_restrict_media_library') );
				add_action('init', array($this, 'remove_admin_bar') );	
				// For Visual Composer 
				add_action('vc_before_init',array($this, 'dir_vc_pricing_table') );
				add_action('vc_before_init',array($this, 'dir_vc_signup') );
				add_action('vc_before_init',array($this, 'dir_vc_user_login') );
				add_action('vc_before_init',array($this, 'dir_vc_my_account') );
				add_action('vc_before_init',array($this, 'dir_vc_public_profile') );
				add_action('vc_before_init',array($this, 'dir_vc_user_directory') );
				// 7. Shortcode						
					
				add_shortcode('ep_fitness_price_table', array($this, 'ep_fitness_price_table_func'));			
				add_shortcode('ep_fitness_form_wizard', array($this, 'ep_fitness_form_wizard_func'));
				add_shortcode('ep_fitness_profile_template', array($this, 'ep_fitness_profile_template_func'));
				add_shortcode('ep_fitness_profile_public', array($this, 'ep_fitness_profile_public_func'));				
				add_shortcode('ep_fitness_login', array($this, 'ep_fitness_login_func'));
				add_shortcode('ep_fitness_user_directory', array($this, 'ep_fitness_user_directory_func'));
				add_shortcode('fitness_done_button', array($this, 'fitness_done_button_func'));
				add_shortcode('ep_fitness_reminder_email_cron', array($this, 'ep_fitness_reminder_email_cron_func'));
				// 8. Filter
						
				add_action( 'wp_loaded', array($this, 'ep_fitness_woocommerce_form_submit') );
				//---- COMMENT FILTERS ----//	
				add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'fitness_plugin_action_links' ) );
				add_action( 'init', array($this, 'ep_post_type') );
				add_action( 'init', array($this, 'ep_create_my_taxonomy_category'));
				add_action( 'init', array($this, 'ep_create_my_taxonomy_tags'));	
				add_action( 'init', array($this, 'iv_physicalrecord_post_type') ); 
				//add_filter( 'template_include', array(&$this, 'include_template_function'), 9, 2  );
				// This function makes error for elementor post edit
			}
			/**
				* Define constants needed across the plug-in.
			*/
			private function define_constants() {
				if (!defined('wp_ep_fitness_BASENAME')) define('wp_ep_fitness_BASENAME', plugin_basename(__FILE__));
				
				if (!defined('wp_ep_fitness_DIR')) define('wp_ep_fitness_DIR', dirname(__FILE__));
				if (!defined('wp_ep_fitness_FOLDER'))define('wp_ep_fitness_FOLDER', plugin_basename(dirname(__FILE__)));
				if (!defined('wp_ep_fitness_ABSPATH'))define('wp_ep_fitness_ABSPATH', trailingslashit(str_replace("\\", "/", WP_PLUGIN_DIR . '/' . plugin_basename(dirname(__FILE__)))));
				if (!defined('wp_ep_fitness_URLPATH'))define('wp_ep_fitness_URLPATH', trailingslashit(plugins_url() . '/' . plugin_basename(dirname(__FILE__))));
				if (!defined('wp_ep_fitness_ADMINPATH'))define('wp_ep_fitness_ADMINPATH', get_admin_url());
				$filename = get_stylesheet_directory()."/fitnesstrainer/";
				if (!file_exists($filename)) {					
					if (!defined('wp_ep_fitness_template'))define( 'wp_ep_fitness_template', wp_ep_fitness_ABSPATH.'template/' );
					}else{
					if (!defined('wp_ep_fitness_template'))define( 'wp_ep_fitness_template', $filename);
				}	
			}				
			/**
				* Loads PHP files that required by the plug-in
			*/			
			public function remove_admin_bar() {
				$iv_hide = get_option( '_ep_fitness_hide_admin_bar');
				if (!current_user_can('administrator') && !is_admin()) {
					if($iv_hide=='yes'){							
						show_admin_bar(false);
					}
				}	
			}
			public function include_template_function( $template_path ) { 
				$default_fields = array();
				$field_set=get_option('_ep_fitness_url_postype' );		
				if($field_set!=""){ 
					$default_fields=get_option('_ep_fitness_url_postype' );
					}else{															
					$default_fields['training-plans']='Training Plans';
					$default_fields['detox-plans']='Detox Plans';
					$default_fields['diet-plans']='Diet Plans';
					$default_fields['diet-guide']='Diet Guide';
					$default_fields['recipes']='Recipes';																
				}
				foreach ( $default_fields as $field_key => $field_value ) {												
					if ( get_post_type() == $field_key ) { 
						if(  is_category() || is_archive() || is_single()){
								$profile_page=get_option('_ep_fitness_profile_page');
								$reg_page= get_permalink( $profile_page);							
								$post_id=get_the_ID();
								$redirect_url=$reg_page.'?&profile=post&id='.$post_id;
								wp_redirect( $redirect_url );
								exit();
						}	
					}
				}
				if ( get_post_type() == 'physical-record' ) { 
					if(  is_category() || is_archive() || is_single()){
						header("HTTP/1.1 301 Moved Permanently");
						header("Location: ".get_bloginfo('url'));
						exit();
					}	
				} 
				return $template_path;
			}
			public function ep_post_type(){
				$default_fields = array();
				$field_set=get_option('_ep_fitness_url_postype' );		
				if($field_set!=""){ 
					$default_fields=get_option('_ep_fitness_url_postype' );
					}else{															
					$default_fields['training-plans']='Training Plans';
					$default_fields['detox-plans']='Detox Plans';
					$default_fields['diet-plans']='Diet Plans';
					$default_fields['diet-guide']='Diet Guide';
					$default_fields['recipes']='Recipes';																	
				}
				
				foreach ( $default_fields as $field_key => $field_value ) {	
					if($field_key!="" ){
						$directory_url_2=$field_key;
                               $labels = array(
                            'name'                => _x( $directory_url_2, 'Post Type General Name', 'epfitness' ),
                            'singular_name'       => _x( $directory_url_2, 'Post Type Singular Name', 'epfitness' ),
                            'menu_name'           => esc_html__(  $field_value , 'epfitness' ),
                            'name_admin_bar'      => esc_html( $directory_url_2 ),
                            'parent_item_colon'   => esc_html__(  'Parent Item:', 'epfitness' ),
                            'all_items'           => esc_html__(  'All Items', 'epfitness' ),
                            'add_new_item'        => esc_html__(  'Add New Item', 'epfitness' ),
                            'add_new'             => esc_html__(  'Add New', 'epfitness' ),
                            'new_item'            => esc_html__(  'New Item', 'epfitness' ),
                            'edit_item'           => esc_html__(  'Edit Item', 'epfitness' ),
                            'update_item'         => esc_html__(  'Update Item', 'epfitness' ),
                            'view_item'           => esc_html__(  'View Item', 'epfitness' ),
                            'search_items'        => esc_html__(  'Search Item', 'epfitness' ),
                            'not_found'           => esc_html__(  'Not found', 'epfitness' ),
                            'not_found_in_trash'  => esc_html__(  'Not found in Trash', 'epfitness' ),
                            );
						$args = array(
						'label'               => esc_html(  $directory_url_2 ),
                        'description'         => esc_html(  $directory_url_2 ),
                        'labels'              => $labels,
                        'supports'            => array( 'title', 'editor', 'author', 'thumbnail', 'comments', 'post-formats','custom-fields' ),

                        'rewrite' 				=> array('slug' => _x( $directory_url_2, 'URL slug', 'epfitness' )),
                        'hierarchical'        => false,
                        'public'              => true,
                        'show_ui'             => true,
                        'show_in_menu'        => true,
                        'menu_position'       => 5,
                        'show_in_admin_bar'   => true,
						'show_in_rest'    => true,
                        'show_in_nav_menus'   => true,
                        'can_export'          => true,
                        'has_archive'         => true,
                        'exclude_from_search' => false,
                        'publicly_queryable'  => true,
                        'capability_type'     => 'post',
						);
						register_post_type( $directory_url_2, $args );
					}
				}			
			}
			public function ep_create_my_taxonomy_category(){
				$default_fields = array();
				$field_set=get_option('_ep_fitness_url_postype' );		
				if($field_set!=""){ 
					$default_fields=get_option('_ep_fitness_url_postype' );
					}else{															
					$default_fields['training-plans']='Training Plans';
					$default_fields['detox-plans']='Detox Plans';
					$default_fields['diet-plans']='Diet Plans';
					$default_fields['diet-guide']='Diet Guide';
					$default_fields['recipes']='Recipes';																
				}
				foreach ( $default_fields as $field_key => $field_value ) {	
					if($field_key!="" ){
						register_taxonomy(
						$field_key.'-category',
						$field_key,
						array(
						'label' => esc_html__(  'Categories', 'epfitness'),
						'rewrite' => array( 'slug' => $field_key.'-category' ),
						'hierarchical' => true,
						'show_in_rest'=> true,
						'query_var' => true,
						)
						);
					}
				}	
			}
			public function ep_create_my_taxonomy_tags(){
				$default_fields = array();
				$field_set=get_option('_ep_fitness_url_postype' );		
				if($field_set!=""){ 
					$default_fields=get_option('_ep_fitness_url_postype' );
					}else{															
					$default_fields['training-plans']='Training Plans';
					$default_fields['detox-plans']='Detox Plans';
					$default_fields['diet-plans']='Diet Plans';
					$default_fields['diet-guide']='Diet Guide';
					$default_fields['recipes']='Recipes';																
				}
				foreach ( $default_fields as $field_key => $field_value ) {	
					if($field_key!="" ){
						register_taxonomy(
						$field_key.'_tag',
						$field_key,
						array(
						'label' => esc_html__(  'Tags', 'epfitness'),
						'rewrite' => array( 'slug' => $field_key.'_tag' ),
						'hierarchical' => true,
						'show_in_rest' => true,
						'query_var' => true,
						)
						);
					}
				}	
			}										
			
			public function iv_physicalrecord_post_type(){
				$directory_url_2='physical-record';
				$labels = array(
				'name'                => _x( $directory_url_2, 'Post Type General Name', 'epfitness' ),
				'singular_name'       => _x( $directory_url_2, 'Post Type Singular Name', 'epfitness' ),
				'menu_name'           => esc_html__(  "Physical Record", 'epfitness' ),
				'name_admin_bar'      => esc_html( $directory_url_2 ),
				'parent_item_colon'   => esc_html__(  'Parent Item:', 'epfitness' ),
				'all_items'           => esc_html__(  'All Items', 'epfitness' ),
				'add_new_item'        => esc_html__(  'Add New Item', 'epfitness' ),
				'add_new'             => esc_html__(  'Add New', 'epfitness' ),
				'new_item'            => esc_html__(  'New Item', 'epfitness' ),
				'edit_item'           => esc_html__(  'Edit Item', 'epfitness' ),
				'update_item'         => esc_html__(  'Update Item', 'epfitness' ),
				'view_item'           => esc_html__(  'View Item', 'epfitness' ),
				'search_items'        => esc_html__(  'Search Item', 'epfitness' ),
				'not_found'           => esc_html__(  'Not found', 'epfitness' ),
				'not_found_in_trash'  => esc_html__(  'Not found in Trash', 'epfitness' ),
				);
				$args = array(
				'label'               => esc_html(  $directory_url_2 ),
				'description'         => esc_html(  $directory_url_2 ),
				'labels'              => $labels,
				'supports'            => array( 'title', 'editor', 'author', 'thumbnail', 'comments', 'post-formats','custom-fields' ),
				
				'rewrite' 				=> array('slug' => _x( $directory_url_2, 'URL slug', 'epfitness' )),
				'hierarchical'        => false,
				'public'              => true,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'menu_position'       => 5,
				'show_in_admin_bar'   => true,
				'show_in_rest'    => true,
				'show_in_nav_menus'   => true,
				'can_export'          => true,
				'has_archive'         => true,
				'exclude_from_search' => false,
				'publicly_queryable'  => true,
				'capability_type'     => 'post',
				);
				register_post_type( 'physical-record', $args );
			}
			public function ep_fitness_delete_report(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'settings' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				global $current_user;
				$id=sanitize_text_field($_POST['post_id']);
				$post_data= get_post( $id );
				$has_access='no';
				$current_userID= get_current_user_id();
				$post_author_id = get_post_field( 'post_author', $id );
				$user_for=get_post_meta($id,'report_for_user',true);
				if($current_userID==$post_author_id){
					$has_access='yes';
				}
				if(isset($current_user->roles[0]) and $current_user->roles[0]=='administrator'){
					$has_access='yes';					
				}					
				if($has_access=='yes'){							
					wp_delete_post($id);
					echo json_encode(array("code" => "success","msg"=> esc_html__( 'Updated Successfully', 'epfitness' )));
					exit(0);
				}
			}
			public function dir_vc_pricing_table() {
				vc_map( array(
				"name" => esc_html__(  "Pricing Table", "epfitness" ),
				"base" => "ep_fitness_price_table",
				'icon' =>  wp_ep_fitness_URLPATH.'/assets/images/vc-icon.png',      
				"class" => "",
				"category" => esc_html__(  "Content", "epfitness"),						 
				"params" => array(
				array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__(  "Style Name", "epfitness" ),
				"param_name" => "no",
				"value" => esc_html__(  "Default", "epfitness" ),
				"description" => esc_html__(  "You can select the style from wp-admin e.g : style-1.", "epfitness" )
				)
				)
				) );
			}
			public function dir_vc_signup() {
				vc_map( array(
				"name" => esc_html__(  "Signup ", "epfitness" ),
				"base" => "ep_fitness_form_wizard",
				'icon' =>  wp_ep_fitness_URLPATH.'/assets/images/vc-icon.png',
				"class" => "",
				"category" => esc_html__(  "Content", "epfitness"),						 
				"params" => array(
				array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__(  "Style Name", "epfitness" ),
				"param_name" => "Default",
				"value" => esc_html__(  "Default", "epfitness" ),
				"description" => esc_html__(  ".", "epfitness" )
				)
				)
				) );
			}
			public function dir_vc_my_account() {
				vc_map( array(
				"name" => esc_html__(  "My Acount ", "epfitness" ),
				"base" => "ep_fitness_profile_template",
				'icon' =>  wp_ep_fitness_URLPATH.'/assets/images/vc-icon.png',
				"class" => "",
				"category" => esc_html__(  "Content", "epfitness"),						  
				"params" => array(
				array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__(  "Style Name", "epfitness" ),
				"param_name" => "Default",
				"value" => esc_html__(  "Default", "epfitness" ),
				"description" => esc_html__(  ".", "epfitness" )
				)
				)
				) );
			}
			public function dir_vc_public_profile() {
				vc_map( array(
				"name" => esc_html__(  "Public Profile ", "epfitness" ),
				"base" => "ep_fitness_profile_public",
				'icon' =>  wp_ep_fitness_URLPATH.'/assets/images/vc-icon.png',
				"class" => "",
				"category" => esc_html__(  "Content", "epfitness"),
				
				"params" => array(
				array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__(  "Style Name", "epfitness" ),
				"param_name" => "Default",
				"value" => esc_html__(  "Default", "epfitness" ),
				"description" => esc_html__(  "You can select the style from wp-admin e.g : style-1 , style-2 ", "epfitness" )
				)
				)
				) );
			}
			public function dir_vc_user_directory() {
				vc_map( array(
				"name" => esc_html__(  "User Directory ", "epfitness" ),
				"base" => "ep_fitness_user_directory",
				'icon' =>  wp_ep_fitness_URLPATH.'/assets/images/vc-icon.png',
				"class" => "",
				"category" => esc_html__(  "Content", "epfitness"),			
				"params" => array(
				array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__(  "Show  number of user / Page", "epfitness" ),
				"param_name" => "per_page",
				"value" => esc_html__(  "12", "epfitness" ),
				"description" => esc_html__(  "You can set the number : 10,20 ", "epfitness" )
				)
				)
				) );
			}
			public function dir_vc_user_login() {
				vc_map( array(
				"name" => esc_html__(  "Login", "epfitness" ),
				"base" => "ep_fitness_login",
				'icon' =>  wp_ep_fitness_URLPATH.'/assets/images/vc-icon.png',
				"class" => "",
				"category" => esc_html__(  "Content", "epfitness"),
				"params" => array(
				array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__(  " Login", "epfitness" ),
				"param_name" => "style",
				"value" => esc_html__(  "Default", "epfitness" ),
				"description" => esc_html__(  "Default ", "epfitness" )
				)
				)
				) );
			}
			public function ep_fitness_woocommerce_form_submit(  ) {
				require(wp_ep_fitness_ABSPATH . '/admin/pages/payment-inc/woo-submit.php');
			}
			public function author_public_profile() {
				$author = get_the_author();	
				$iv_redirect = get_option( '_ep_fitness_profile_public_page');
				if($iv_redirect!='defult'){ 
					$reg_page= get_permalink( $iv_redirect) ; 
					return    $reg_page.'?&id='.$author; 
					exit;
				}
			}
			public function iv_registration_redirect(){
				$iv_redirect = get_option( 'ep_fitness_signup_redirect');
				if($iv_redirect!='defult'){
					$reg_page= get_permalink( $iv_redirect); 
					wp_redirect( $reg_page );
					exit;
				}	
			}
			public function iv_directories_cpt_change(){
				$custom_post_type = $_POST['select_data'];
				$args2 = array(
				'type'                     => $custom_post_type,
				'orderby'                  => 'name',
				'order'                    => 'ASC',
				'hide_empty'        	   => false,
				'hierarchical'             => 0,
				'exclude'                  => '',
				'include'                  => '',
				'number'                   => '',
				'taxonomy'                 => $custom_post_type.'-category',
				'pad_counts'               => false
				);
				$categories = get_categories( $args2 );
				if ( $categories && !is_wp_error( $categories ) ) :
				$val_cat2='<select name="postcats" id="postcats" class="form-control">';
				$val_cat2=$val_cat2.'<option  value="">'.esc_html__('Any Category','epfitness').'</option>';
				foreach ( $categories as $term ) {
					$val_cat2=$val_cat2. '<option  value="'.$term->slug.'" >'.$term->name.'</option>';
				}
				$val_cat2=$val_cat2.'</select>';
				endif;	
				$args3 = array(
				'type'                     => $custom_post_type,
				'orderby'                  => 'name',
				'order'                    => 'ASC',
				'hide_empty'               => 0,
				'hierarchical'             => 1,
				'exclude'                  => '',
				'include'                  => '',
				'number'                   => '',
				'taxonomy'                 => $custom_post_type.'_tag',
				'pad_counts'               => false
				);
				$tags='';
				$p_tag = get_categories( $args3 );												
				if ( $p_tag && !is_wp_error( $p_tag ) ) :
				foreach ( $p_tag as $term ) {
					$tags=$tags.'<div class="col-md-4"><label class="form-group"><input type="checkbox" name="tag_arr[]" id="tag_arr[]" value="'. $term->slug.'"> '.$term->name.'</label></div>';
				}
				endif;
				echo json_encode(array("msg" => $val_cat2,"tags" => $tags));
				exit(0);
			}	
			public function ep_fitness_login_func(){
				ob_start();	
					global $current_user;		
				if($current_user->ID==0){		
						include(wp_ep_fitness_template. 'private-profile/profile-login.php');
					}else{						
						include( wp_ep_fitness_template. 'private-profile/profile-template-1.php');
				}	
				$content = ob_get_clean();
				return $content;
			}
			public function ep_fitness_forget_password(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'settings' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				parse_str($_POST['form_data'], $data_a);
				if( ! email_exists(sanitize_email($data_a['forget_email'])) ) {
					echo json_encode(array("code" => "not-success","msg"=> esc_html__( "There is no user registered with that email address.",'epfitness') ));
					exit(0);
				} else {
					require( wp_ep_fitness_ABSPATH. 'inc/forget-mail.php');
					echo json_encode(array("code" => "success","msg"=> esc_html__( 'Updated Successfully', 'epfitness' )));
					exit(0);
				}
			}			
			public function ep_fitness_check_login(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'settings' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				parse_str($_POST['form_data'], $form_data);
				global $user;
				$creds = array();
				$creds['user_login'] =sanitize_text_field($form_data['username710']);
				$creds['user_password'] =  sanitize_text_field($form_data['password710']);
				$creds['remember'] =  'true';
				$secure_cookie = is_ssl() ? true : false;
				$user = wp_signon( $creds, $secure_cookie);
				if ( is_wp_error($user) ) {					
					echo json_encode(array("code" => "not-success","msg"=>$user->get_error_message()));
					exit(0);
				}
				if ( !is_wp_error($user) ) {
					$iv_redirect = get_option( '_ep_fitness_profile_page');
					if($iv_redirect!='defult'){
						if ( function_exists('icl_object_id') ) {
							$iv_redirect = icl_object_id($iv_redirect, 'page', true);
						}	
						$reg_page= get_permalink( $iv_redirect); 
						echo json_encode(array("code" => "success","msg"=>$reg_page));
						exit(0);
					}
				}		
			}
			public function ep_fitness_update_listing(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'settings' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				global $current_user; global $wpdb;	
				parse_str($_POST['form_data'], $form_data);	
				$allowed_html = wp_kses_allowed_html( 'post' );
				$post_id=sanitize_text_field($form_data['user_post_id']);
				$post_type = sanitize_text_field($form_data['cpt_page']);				
				$ep_post = array(
				'ID'           => sanitize_text_field($form_data['user_post_id']),
				'post_title'   => sanitize_text_field($form_data['title']),
				'post_content' => wp_kses( $form_data['edit_post_content'], $allowed_html),
				);
				wp_update_post( $ep_post );  
				if(isset($form_data['pt_date'] )){
					update_post_meta( $post_id,'pt_date', sanitize_text_field($form_data['pt_date']));
				}	
				if(isset($form_data['feature_image_id'] )){
					$attach_id =sanitize_text_field($form_data['feature_image_id']);
					set_post_thumbnail( $post_id, $attach_id );					
				}						
				if(isset($form_data['postcats'] )){ 						
					wp_set_object_terms( $post_id, $form_data['postcats'], $post_type.'-category');
				}
				$specific_users=(isset($form_data['specific_users'])?$form_data['specific_users']:'');
				update_post_meta( $post_id,'_ep_postfor_user', $specific_users);
				update_post_meta( $post_id,'_ep_post_for','user');
				$day_for=(isset($form_data['day_for'])?$form_data['day_for']:'');
				update_post_meta( $post_id,'_ep_day_option', sanitize_text_field($day_for));
				$day_number=(isset($form_data['day_number'])?$form_data['day_number']:'');
				update_post_meta( $post_id,'_ep_user_day_number', sanitize_text_field($day_number) );
				$day_date=(isset($form_data['day_date'])?$form_data['day_date']:'');
				update_post_meta( $post_id,'_ep_user_date', sanitize_text_field($day_date) ); 
				echo json_encode(array("code" => "success","msg"=> esc_html__( 'Updated Successfully', 'epfitness' )));
				exit(0);
			}
			public function fitness_done_button_func(){
				ob_start();	
				include( wp_ep_fitness_template. 'private-profile/done_shortcode.php');
				$content = ob_get_clean();
				return $content;
			}
			public function ep_fitness_user_directory_func($atts = ''){
				ob_start();						 
				include( wp_ep_fitness_template. 'user-directory/directory-template-2.php');
				$content = ob_get_clean();
				return $content;					
			}
			public function ep_fitness_profile_public_func($atts = '') {						
				ob_start();						
				include( wp_ep_fitness_template. 'profile-public/profile-template-2.php');						
				$content = ob_get_clean();	
				return $content;
			}
			public function ep_fitness_cancel_paypal(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'settings' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				global $wpdb;
				global $current_user;
				parse_str($_POST['form_data'], $form_data);
				if( ! class_exists('Paypal' ) ) {
					require(wp_ep_fitness_DIR . '/inc/class-paypal.php');
				}
				$post_name='ep_fitness_paypal_setting';						
				$row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_name = '%s' ",$post_name ));
				$paypal_id='0';
				if(sizeof($row )>0){
					$paypal_id= $row->ID;
				}
				$paypal_api_currency=get_post_meta($paypal_id, 'ep_fitness_paypal_api_currency', true);
				$paypal_username=get_post_meta($paypal_id, 'ep_fitness_paypal_username',true);
				$paypal_api_password=get_post_meta($paypal_id, 'ep_fitness_paypal_api_password', true);
				$paypal_api_signature=get_post_meta($paypal_id, 'ep_fitness_paypal_api_signature', true);
				$credentials = array();
				$credentials['USER'] = (isset($paypal_username)) ? $paypal_username : '';
				$credentials['PWD'] = (isset($paypal_api_password)) ? $paypal_api_password : '';
				$credentials['SIGNATURE'] = (isset($paypal_api_signature)) ? $paypal_api_signature : '';
				$paypal_mode=get_post_meta($paypal_id, 'ep_fitness_paypal_mode', true);
				$currencyCode = $paypal_api_currency;
				$sandbox = ($paypal_mode == 'live') ? '' : 'sandbox.';
				$sandboxBool = (!empty($sandbox)) ? true : false;
				$paypal = new Paypal($credentials,$sandboxBool);
				$oldProfile = get_user_meta($current_user->ID,'iv_paypal_recurring_profile_id',true);
				if (!empty($oldProfile)) {
					$cancelParams = array(
					'PROFILEID' => $oldProfile,
					'ACTION' => 'Cancel'
					);
					$paypal -> request('ManageRecurringPaymentsProfileStatus',$cancelParams);
					update_user_meta($current_user->ID,'iv_paypal_recurring_profile_id','');
					update_user_meta($current_user->ID,'iv_cancel_reason', sanitize_text_field($form_data['cancel_text'])); 
					update_user_meta($current_user->ID,'ep_fitness_payment_status', 'cancel'); 
					echo json_encode(array("code" => "success","msg"=>"Cancel Successfully"));
					exit(0);							
					}else{
					echo json_encode(array("code" => "not","msg"=>"Unable to Cancel "));
					exit(0);	
				}
			}
			public function ep_fitness_save_listing(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'settings' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				global $current_user; global $wpdb;	
				parse_str($_POST['form_data'], $form_data);		
				$allowed_html = wp_kses_allowed_html( 'post' );
				$my_post = array();
				$my_post['post_title'] = sanitize_text_field($form_data['title']);
				$my_post['post_content'] = wp_kses( $form_data['new_post_content'], $allowed_html);
				$my_post['post_status'] = 'publish';					
				$newpost_id= wp_insert_post( $my_post );						
				$post_type = $form_data['cpt_page'];
				if($post_type!=''){
					$query = $wpdb->prepare("UPDATE {$wpdb->prefix}posts SET post_type='%s' WHERE id='%s' LIMIT 1", $post_type,$newpost_id );
					$wpdb->query($query);										
				}
				$post_id=$newpost_id;
				// WPML Start******
				if ( function_exists('icl_object_id') ) {
					include_once( WP_PLUGIN_DIR . '/sitepress-multilingual-cms/inc/wpml-api.php' );
					$_POST['icl_post_language'] = $language_code = ICL_LANGUAGE_CODE;
					$query =$wpdb->prepare( "UPDATE {$wpdb->prefix}icl_translations SET element_type='post_%s' WHERE element_id='%s' LIMIT 1", $post_type,$newpost_id );
					$wpdb->query($query);					
				}
				// End WPML**********	
				if(isset($form_data['pt_date'] )){
					update_post_meta( $newpost_id,'pt_date', sanitize_text_field($form_data['pt_date']));
				}	
				if(isset($form_data['feature_image_id'] )){
					$attach_id =sanitize_text_field($form_data['feature_image_id']);
					set_post_thumbnail( $newpost_id, $attach_id );					
				}						
				if(isset($form_data['postcats'] )){ 
					$category_ids = array($form_data['postcats']);						
					$post_cats= array();
					foreach($category_ids AS $cid) {
						$post_cats=$cid;
					}
					wp_set_object_terms( $newpost_id, $post_cats, $post_type.'-category');
				}				
				$specific_users=(isset($form_data['specific_users'])?$form_data['specific_users']:'');
				update_post_meta( $post_id,'_ep_postfor_user', $specific_users);
				update_post_meta( $post_id,'_ep_post_for','user');
				$day_for=(isset($form_data['day_for'])?sanitize_text_field($form_data['day_for']):'');
				update_post_meta( $post_id,'_ep_day_option', $day_for );
				$day_number=(isset($form_data['day_number'])?sanitize_text_field($form_data['day_number']):'');
				update_post_meta( $post_id,'_ep_user_day_number', $day_number );
				$day_date=(isset($form_data['day_date'])?sanitize_text_field($form_data['day_date']):'');
				update_post_meta( $post_id,'_ep_user_date', $day_date ); 
				echo json_encode(array("code" => "success","msg"=> esc_html__( 'Updated Successfully', 'epfitness' )));
				exit(0);
			}
			public function  ep_fitness_profile_stripe_upgrade(){
				include(wp_ep_fitness_DIR . '/admin/files/init.php');
				global $wpdb;
				global $current_user;
				parse_str($_POST['form_data'], $form_data);	
				$newpost_id='';
				$post_name='ep_fitness_stripe_setting';
				$row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_name = '%s' ",$post_name ));
				if(isset($row->ID )){
					$newpost_id= $row->ID;
				}
				$stripe_mode=get_post_meta( $newpost_id,'ep_fitness_stripe_mode',true);	
				if($stripe_mode=='test'){
					$stripe_api =get_post_meta($newpost_id, 'ep_fitness_stripe_secret_test',true);	
					}else{
					$stripe_api =get_post_meta($newpost_id, 'ep_fitness_stripe_live_secret_key',true);	
				}
				\Stripe\Stripe::setApiKey($stripe_api);				
				// For  cancel ----
				$arb_status =	get_user_meta($current_user->ID, 'ep_fitness_payment_status', true);
				$cust_id = get_user_meta($current_user->ID,'ep_fitness_stripe_cust_id',true);
				$sub_id = get_user_meta($current_user->ID,'ep_fitness_stripe_subscrip_id',true);
				if($sub_id!=''){	
					try{
						$iv_cancel_stripe = \Stripe\Subscription::retrieve($sub_id);
						$iv_cancel_stripe->cancel();
						} catch (Exception $e) {
					}
					update_user_meta($current_user->ID,'ep_fitness_payment_status', 'cancel'); 
					update_user_meta($current_user->ID,'ep_fitness_stripe_subscrip_id','');
				}
				// Start  New 
				$response='';
				parse_str($_POST['form_data'], $form_data);
				include(wp_ep_fitness_DIR . '/admin/pages/payment-inc/stripe-upgrade.php');
				echo json_encode(array("code" => "success","msg"=>$response));
				exit(0);
			}
			public function ep_fitness_cancel_stripe(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'settings' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				include(wp_ep_fitness_DIR . '/admin/files/init.php');
				global $wpdb;
				global $current_user;				
				$newpost_id='';
				$post_name='ep_fitness_stripe_setting';
				$row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_name = '%s' ", $post_name ));
				if(isset($row->ID )){
					$newpost_id= $row->ID;
				}
				$stripe_mode=get_post_meta( $newpost_id,'ep_fitness_stripe_mode',true);	
				if($stripe_mode=='test'){
					$stripe_api =get_post_meta($newpost_id, 'ep_fitness_stripe_secret_test',true);	
					}else{
					$stripe_api =get_post_meta($newpost_id, 'ep_fitness_stripe_live_secret_key',true);	
				}
				parse_str($_POST['form_data'], $form_data);
				$sub_id = get_user_meta($current_user->ID,'ep_fitness_stripe_subscrip_id',true);
				
				\Stripe\Stripe::setApiKey($stripe_api);
				try{
				
					$iv_cancel_stripe = \Stripe\Subscription::retrieve($sub_id);
					$iv_cancel_stripe->cancel();
					} catch (Exception $e) {
				}
				update_user_meta($current_user->ID,'iv_cancel_reason', sanitize_text_field($form_data['cancel_text'])); 
				update_user_meta($current_user->ID,'ep_fitness_payment_status', 'cancel'); 
				update_user_meta($current_user->ID,'ep_fitness_stripe_subscrip_id','');
				echo json_encode(array("code" => "success","msg"=>"Cancel Successfully"));
				exit(0);
			}
			public function  ep_fitness_stripe_form_func(){
				require_once(wp_ep_fitness_ABSPATH.'files/short_code_file/iv_stripe_form_display.php');
			}
			public function ep_fitness_update_setting_hide(){
				global $current_user;
				parse_str($_POST['form_data'], $form_data);	
				$mobile_hide=(isset($form_data['mobile_hide'])? $form_data['mobile_hide']:'');	
				$email_hide=(isset($form_data['email_hide'])? $form_data['email_hide']:'');	
				$phone_hide=(isset($form_data['phone_hide'])? $form_data['phone_hide']:'');	
				update_user_meta($current_user->ID,'hide_email', $email_hide); 
				update_user_meta($current_user->ID,'hide_phone', $phone_hide);					
				update_user_meta($current_user->ID,'hide_mobile',$mobile_hide); 
				echo json_encode(array("code" => "success","msg"=> esc_html__( 'Updated Successfully', 'epfitness' )));
				exit(0);
			}
			public function iv_training_done(){
				global $current_user;
				$training_done_string='_post_done_'.$_POST['post_id'];
				$training_done_string2='_post_done_day_'.$_POST['post_id'].'_'.$_POST['day_num'];
				update_user_meta($current_user->ID,$training_done_string, 	'done'); 
				update_user_meta($current_user->ID,$training_done_string2, 	'done'); 
				echo json_encode(array("code" => "success","msg"=> esc_html__( 'Updated Successfully', 'epfitness' )));
				exit(0);
			}
			public function ep_fitness_update_expert_review(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'settings' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				global $current_user,$wp;
				$capability ='edit_post';
				$post_id_review=sanitize_text_field($_POST['post_ex_id']);							
				$post = array(
				'ID' => esc_sql(sanitize_text_field($_POST['post_ex_id'])),
				'post_content' => wp_kses_post(sanitize_text_field($_POST['review_data'])),									
				);
				$result = wp_update_post($post, true);
				if (is_wp_error($result)){
					echo json_encode(array("code" => "success","msg"=>"Error"));
					exit(0);
				}
				echo json_encode(array("code" => "success","msg"=> esc_html__( 'Updated Successfully', 'epfitness' )));  
				$review_data=sanitize_text_field($_POST['review_data']);
				include( wp_ep_fitness_ABSPATH. 'inc/notice-mail.php');							
				exit(0);
			}				
			public function ep_fitness_update_setting_fb(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'settings' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				global $current_user;
				parse_str($_POST['form_data'], $form_data);			
				if(array_key_exists('wp_capabilities',$form_data)){
					wp_die( 'Are you cheating:wp_capabilities :( ?' );		
				}		
				update_user_meta($current_user->ID,'twitter', sanitize_text_field($form_data['twitter'])); 
				update_user_meta($current_user->ID,'facebook', sanitize_text_field($form_data['facebook'])); 
				update_user_meta($current_user->ID,'gplus', sanitize_text_field($form_data['gplus'])); 
				update_user_meta($current_user->ID,'linkedin', sanitize_text_field($form_data['linkedin'])); 
				update_user_meta($current_user->ID,'pinterest', sanitize_text_field($form_data['pinterest'])); 
				update_user_meta($current_user->ID,'instagram', sanitize_text_field($form_data['instagram'])); 
				update_user_meta($current_user->ID,'vimeo', sanitize_text_field($form_data['vimeo'])); 
				update_user_meta($current_user->ID,'youtube', sanitize_text_field($form_data['youtube'])); 
				echo json_encode(array("code" => "success","msg"=> esc_html__( 'Updated Successfully', 'epfitness' )));
				exit(0);
			}
			public function ep_fitness_update_setting_password(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'settings' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				global $current_user;
				parse_str($_POST['form_data'], $form_data);						
				if ( wp_check_password( $form_data['c_pass'], $current_user->user_pass, $current_user->ID) ){
					if($form_data['r_pass']!=$form_data['n_pass']){
						echo json_encode(array("code" => "not", "msg"=> esc_html__( 'New Password & Re Password are not same', 'epfitness' )));
						exit(0);
						}else{
						wp_set_password( sanitize_text_field($form_data['n_pass']), $current_user->ID);
						echo json_encode(array("code" => "success","msg"=> esc_html__( 'Updated Successfully', 'epfitness' )));
						exit(0);
					}
					}else{
					echo json_encode(array("code" => "not", "msg"=> esc_html__( 'Current password is wrong', 'epfitness' )));
					exit(0);
				}
			}
			public function ep_fitness_update_profile_setting(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'settings' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				parse_str($_POST['form_data'], $form_data);	
				if(array_key_exists('wp_capabilities',$form_data)){
					wp_die( 'Are you cheating:wp_capabilities :( ?' );		
				}		
				global $current_user;										
				foreach ( $form_data as $field_key => $field_value ) { 
					if(strtolower(trim($field_key))!='wp_capabilities'){
						update_user_meta($current_user->ID,sanitize_text_field($field_key), sanitize_text_field($field_value)); 
					}
				}
				update_user_meta($current_user->ID, 'image_gallery_ids', sanitize_text_field($form_data['gallery_image_ids'])); 
				echo json_encode(array("code" => "success","msg"=> esc_html__( 'Updated Successfully', 'epfitness' )));
				exit(0);
			}
		
			public function iv_restrict_media_library( $wp_query ) {				
				if(!function_exists('wp_get_current_user')) { include(ABSPATH . "wp-includes/pluggable.php"); }
				
				global $current_user, $pagenow;
				if( is_admin() && !current_user_can('edit_others_posts') ) {
					$wp_query->set( 'author', $current_user->ID );
					add_filter('views_edit-post', 'fix_post_counts');
					add_filter('views_upload', 'fix_media_counts');
				}
			}
			public function check_expiry_date($user) {
				require_once(wp_ep_fitness_DIR . '/inc/check_expire_date.php');
			}
			public function ep_fitness_update_profile_pic(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'settings' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				global $current_user;
				if(isset($_REQUEST['profile_pic_url_1'])){
					$iv_profile_pic_url=sanitize_text_field($_REQUEST['profile_pic_url_1']);
					$attachment_thum=sanitize_text_field($_REQUEST['attachment_thum']);
					}else{
					$iv_profile_pic_url='';
					$attachment_thum='';
				}
				update_user_meta($current_user->ID, 'iv_profile_pic_thum', $attachment_thum);					
				update_user_meta($current_user->ID, 'iv_profile_pic_url', $iv_profile_pic_url);
				echo json_encode('success');
				exit(0);
			}
			public function ep_fitness_pdf_report(){ 
				require(wp_ep_fitness_DIR . '/template/pdf/pdf_report.php');
			}
			public function ep_fitness_pdf_post(){
				require(wp_ep_fitness_DIR . '/template/pdf/pdf_post.php');
			}
			public function ep_fitness_paypal_form_submit(  ) {
				require(wp_ep_fitness_DIR . '/admin/pages/payment-inc/paypal-submit.php');
			}	
			public function ep_fitness_stripe_form_submit(  ) {
				require(wp_ep_fitness_DIR . '/admin/pages/payment-inc/stripe-submit.php');
			}
			public function plugin_mce_css_ep_fitness( $mce_css ) {
				if ( ! empty( $mce_css ) )
				$mce_css .= ',';
				$mce_css .= plugins_url( 'admin/files/css/iv-bootstrap.css', __FILE__ );
				return $mce_css;
			}
			/***********************************
				* Adds a meta box to the post editing screen
			*/
			public function prfx_custom_meta_iv_listing() {
				$default_fields = array();
				$field_set=get_option('_ep_fitness_url_postype' );		
				if($field_set!=""){ 
					$default_fields=get_option('_ep_fitness_url_postype' );
					}else{															
					$default_fields['training-plans']='Training Plans';
					$default_fields['detox-plans']='Detox Plans';
					$default_fields['diet-plans']='Diet Plans';
					$default_fields['diet-guide']='Diet Guide';
					$default_fields['recipes']='Recipes';																	
				}
				foreach ( $default_fields as $field_key => $field_value ) {
					add_meta_box('prfx_meta', esc_html__( ' Assign the Post', 'epfitness'), array(&$this, 'iv_listing_meta_callback'),$field_key,'advanced');
				}	
			}
			public function ep_fitness_save_record_pt(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'settings' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				global $current_user; global $wpdb;	
				$directory_url_1='physical-record';					
				$post_type='physical-record';	
				parse_str($_POST['form_data'], $form_data);				
				$my_post = array();
				$my_post['post_author'] = sanitize_text_field($form_data['record_user_pt']);					
				$my_post['post_title'] = sanitize_text_field('User ID = '.$form_data['record_user_pt'].' | Date ='.date('Y-m-d H:i:s'));										
				$my_post['post_status'] = 'publish';
				$my_post['post_type'] = $directory_url_1;
				$newpost_id= wp_insert_post( $my_post );						
				// WPML Start******
				if ( function_exists('icl_object_id') ) {
					include_once( WP_PLUGIN_DIR . '/sitepress-multilingual-cms/inc/wpml-api.php' );
					$_POST['icl_post_language'] = $language_code = ICL_LANGUAGE_CODE;
					$query = $wpdb->prepare("UPDATE {$wpdb->prefix}icl_translations SET element_type='post_%s' WHERE element_id='%s' LIMIT 1", $directory_url_1,$newpost_id);
					$wpdb->query($query);					
				}
				// End WPML**********	
				if(isset($form_data['feature_image_id'] )){
					$attach_id =$form_data['feature_image_id'];
					set_post_thumbnail( $newpost_id, $attach_id );					
				}
				update_post_meta($newpost_id, 'week', sanitize_text_field($form_data['week'])); 
				update_post_meta($newpost_id, 'date', sanitize_text_field($form_data['date']));
				$default_fields = array();
				$field_set=get_option('ep_fitness_fields' );							
				if($field_set!=""){ 
					$default_fields=get_option('ep_fitness_fields' );
					}else{															
					$default_fields['height']='Height';
					$default_fields['weight']='Weight';
					$default_fields['chest']='Chest';
					$default_fields['l-arm']='Left Arm';
					$default_fields['r-arm']='Right Arm';
					$default_fields['waist']='Waist';
					$default_fields['abdomen']='Abdomen';
					$default_fields['hips']='Hips';
					$default_fields['l-thigh']='Left Thigh';
					$default_fields['r-thigh']='Right Thigh';
					$default_fields['l-calf']='Left Calf';
					$default_fields['r-calf']='Right Calf';
				}
				if(sizeof($default_fields )){			
					foreach( $default_fields as $field_key => $field_value ) { 
						if(isset($form_data[$field_key])){		
							$form_data[$field_key];
							update_post_meta($newpost_id, $field_key, sanitize_text_field($form_data[$field_key]) );
						}
					}					
				}
				echo json_encode(array("code" => "success","msg"=> esc_html__( 'Updated Successfully', 'epfitness' )));
				exit(0);
			}
			public function ep_fitness_save_record(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'settings' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				global $current_user; global $wpdb;	
				$directory_url_1='physical-record';					
				$post_type='physical-record';	
				parse_str($_POST['form_data'], $form_data);				
				$my_post = array();
				$my_post['post_title'] = 'User Name = '.$current_user->user_login.' | Date ='.date('Y-m-d H:i:s');
				$form_data['post_status']='publish';
				$my_post['post_status'] = sanitize_text_field($form_data['post_status']);					
				$newpost_id= wp_insert_post( $my_post );						
				$post_type = $directory_url_1;
				if($post_type!=''){
					$query = $wpdb->prepare("UPDATE {$wpdb->prefix}posts SET post_type='%s' WHERE id='%s' LIMIT 1" ,$post_type, $newpost_id);
					$wpdb->query($query);										
				}
				// WPML Start******
				if ( function_exists('icl_object_id') ) {
					include_once( WP_PLUGIN_DIR . '/sitepress-multilingual-cms/inc/wpml-api.php' );
					$_POST['icl_post_language'] = $language_code = ICL_LANGUAGE_CODE;
					$query = $wpdb->prepare("UPDATE {$wpdb->prefix}icl_translations SET element_type='post_%s' WHERE element_id='%s' LIMIT 1", $directory_url_1,$newpost_id );
					$wpdb->query($query);					
				}
				// End WPML**********					
				if(isset($form_data['feature_image_id'] )){
					$attach_id =$form_data['feature_image_id'];
					set_post_thumbnail( $newpost_id, $attach_id );					
				}
				update_post_meta($newpost_id, 'week', sanitize_text_field($form_data['week'])); 
				update_post_meta($newpost_id, 'date', sanitize_text_field($form_data['date']));
				$default_fields = array();
				$field_set=get_option('ep_fitness_fields' );
				if($field_set!=""){ 
					$default_fields=get_option('ep_fitness_fields' );
					}else{															
					$default_fields['height']='Height';
					$default_fields['weight']='Weight';
					$default_fields['chest']='Chest';
					$default_fields['l-arm']='Left Arm';
					$default_fields['r-arm']='Right Arm';
					$default_fields['waist']='Waist';
					$default_fields['abdomen']='Abdomen';
					$default_fields['hips']='Hips';
					$default_fields['l-thigh']='Left Thigh';
					$default_fields['r-thigh']='Right Thigh';
					$default_fields['l-calf']='Left Calf';
					$default_fields['r-calf']='Right Calf';
				}
				if(sizeof($default_fields )){			
					foreach( $default_fields as $field_key => $field_value ) { 
						if(isset($form_data[$field_key])){		
							$form_data[$field_key];
							update_post_meta($newpost_id, $field_key, sanitize_text_field($form_data[$field_key] ));
						}
					}					
				}
				echo json_encode(array("code" => "success","msg"=> esc_html__( 'Updated Successfully', 'epfitness' )));
				exit(0);
			}
			public function ep_fitness_update_record(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'settings' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				global $current_user;
				parse_str($_POST['form_data'], $form_data);		
				$newpost_id= sanitize_text_field($form_data['user_post_id']);
				if(isset($form_data['feature_image_id'] )){
					$attach_id =sanitize_text_field($form_data['feature_image_id']);
					set_post_thumbnail( $newpost_id, $attach_id );					
				}	
				update_post_meta($newpost_id, 'week', sanitize_text_field($form_data['week'])); 
				update_post_meta($newpost_id, 'date', sanitize_text_field($form_data['date']));
				$default_fields = array();
				$field_set=get_option('ep_fitness_fields' );
				if($field_set!=""){ 
					$default_fields=get_option('ep_fitness_fields' );
					}else{															
					$default_fields['height']='Height';
					$default_fields['weight']='Weight';
					$default_fields['chest']='Chest';
					$default_fields['l-arm']='Left Arm';
					$default_fields['r-arm']='Right Arm';
					$default_fields['waist']='Waist';
					$default_fields['abdomen']='Abdomen';
					$default_fields['hips']='Hips';
					$default_fields['l-thigh']='Left Thigh';
					$default_fields['r-thigh']='Right Thigh';
					$default_fields['l-calf']='Left Calf';
					$default_fields['r-calf']='Right Calf';
				}
				if(sizeof($default_fields )){			
					foreach( $default_fields as $field_key => $field_value ) { 
						if(isset($form_data[$field_key])){		
							$form_data[$field_key];
							update_post_meta($newpost_id, $field_key, sanitize_text_field($form_data[$field_key] ));
						}
					}					
				}	
				echo json_encode(array("code" => "success","msg"=> esc_html__( 'Updated Successfully', 'epfitness' )));
				exit(0);				
			}
			public function ep_fitness_check_coupon(){
				global $wpdb;
				$coupon_code=$_REQUEST['coupon_code'];
				$package_id=$_REQUEST['package_id'];
				$package_amount=get_post_meta($package_id, 'ep_fitness_package_cost',true);
				$api_currency =$_REQUEST['api_currency'];
				$post_cont = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_title = '%s' and  post_type='iv_coupon'" ,$coupon_code ));	
				if(sizeof($post_cont)>0 && $package_amount>0){
					$coupon_name = $post_cont->post_title;
					$current_date=$today = date("m/d/Y");
					$start_date=get_post_meta($post_cont->ID, 'iv_coupon_start_date', true);
					$end_date=get_post_meta($post_cont->ID, 'iv_coupon_end_date', true);
					$coupon_used=get_post_meta($post_cont->ID, 'iv_coupon_used', true);
					$coupon_limit=get_post_meta($post_cont->ID, 'iv_coupon_limit', true);
					$dis_amount=get_post_meta($post_cont->ID, 'iv_coupon_amount', true);							 
					$package_ids =get_post_meta($post_cont->ID, 'iv_coupon_pac_id', true);
					$all_pac_arr= explode(",",$package_ids);
					$today_time = strtotime($current_date);
					$start_time = strtotime($start_date);
					$expire_time = strtotime($end_date);
					if(in_array('0', $all_pac_arr)){
						$pac_found=1;
						}else{
						if(in_array($package_id, $all_pac_arr)){
							$pac_found=1;
							}else{
							$pac_found=0;
						}
					}
					$recurring = get_post_meta( $package_id,'ep_fitness_package_recurring',true); 
					if($today_time >= $start_time && $today_time<=$expire_time && $coupon_used<=$coupon_limit && $pac_found == '1' && $recurring!='on' ){
						$total = $package_amount -$dis_amount;
						$coupon_type= get_post_meta($post_cont->ID, 'iv_coupon_type', true);
						if($coupon_type=='percentage'){
							$dis_amount= $dis_amount * $package_amount/100;
							$total = $package_amount -$dis_amount ;
						}
						echo json_encode(array('code' => 'success',
						'dis_amount' => $dis_amount.' '.$api_currency,
						'gtotal' => $total.' '.$api_currency,
						'p_amount' => $package_amount.' '.$api_currency,
						));
						exit(0);
						}else{
						$dis_amount='';
						$total=$package_amount;
						echo json_encode(array('code' => 'not-success-2',
						'dis_amount' => '',
						'gtotal' => $total.' '.$api_currency,
						'p_amount' => $package_amount.' '.$api_currency,
						));
						exit(0);
					}
					}else{
					if($package_amount=="" or $package_amount=="0"){$package_amount='0';}
					$dis_amount='';
					$total=$package_amount;
					echo json_encode(array('code' => 'not-success-1',
					'dis_amount' => '',
					'gtotal' => $total.' '.$api_currency,
					'p_amount' => $package_amount.' '.$api_currency,
					));
					exit(0);
				}
			}
			public function ep_fitness_check_package_amount(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'signup' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				global $wpdb;
				$coupon_code=isset($_REQUEST['coupon_code']);
				$package_id=sanitize_text_field($_REQUEST['package_id']);
				if( get_post_meta( $package_id,'ep_fitness_package_recurring',true) =='on'  ){
					$package_amount=get_post_meta($package_id, 'ep_fitness_package_recurring_cost_initial', true);			
					}else{					
					$package_amount=get_post_meta($package_id, 'ep_fitness_package_cost',true);
				}				
				$api_currency= get_option('_ep_fitness_api_currency');
				$iv_gateway = get_option('ep_fitness_payment_gateway');
				if($iv_gateway=='woocommerce'){
					if ( class_exists( 'WooCommerce' ) ) {	
						$api_currency= get_option( 'woocommerce_currency' );
						$currencyCode= get_woocommerce_currency_symbol( $api_currency );
						$api_currency= get_woocommerce_currency_symbol( $api_currency );
						
					}
				}						
				$post_cont = $wpdb->get_row( $wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_title = '%s' and  post_type='iv_coupon'", $coupon_code));	
				if(sizeof($post_cont)>0){
					$coupon_name = $post_cont->post_title;
					$current_date=$today = date("m/d/Y");
					$start_date=get_post_meta($post_cont->ID, 'iv_coupon_start_date', true);
					$end_date=get_post_meta($post_cont->ID, 'iv_coupon_end_date', true);
					$coupon_used=get_post_meta($post_cont->ID, 'iv_coupon_used', true);
					$coupon_limit=get_post_meta($post_cont->ID, 'iv_coupon_limit', true);
					$dis_amount=get_post_meta($post_cont->ID, 'iv_coupon_amount', true);							 
					$package_ids =get_post_meta($post_cont->ID, 'iv_coupon_pac_id', true);
					$all_pac_arr= explode(",",$package_ids);
					$today_time = strtotime($current_date);
					$start_time = strtotime($start_date);
					$expire_time = strtotime($end_date);
					$pac_found= in_array($package_id, $all_pac_arr);							
					if($today_time >= $start_time && $today_time<=$expire_time && $coupon_used<=$coupon_limit && $pac_found=="1"){
						$total = $package_amount -$dis_amount;
						echo json_encode(array('code' => 'success',
						'dis_amount' => $dis_amount.' '.$api_currency,
						'gtotal' =>$total.' '.$api_currency,
						'p_amount' => $package_amount.' '.$api_currency,
						));
						exit(0);
						}else{
						$dis_amount='--';
						$total=$package_amount;
						echo json_encode(array('code' => 'not-success',
						'dis_amount' => $dis_amount.' '.$api_currency,
						'gtotal' => $total.' '.$api_currency,
						'p_amount' =>$package_amount.' '.$api_currency,
						));
						exit(0);
					}
					}else{
					$dis_amount='--';
					$total=$package_amount;
					echo json_encode(array('code' => 'not-success',
					'dis_amount' => $dis_amount.' '.$api_currency,
					'gtotal' => $total.' '.$api_currency,
					'p_amount' => $package_amount.' '.$api_currency,
					));
					exit(0);
				}
			}
			/**
				* Outputs the content of the meta box
			*/
			public function iv_listing_meta_callback($post) {
				wp_nonce_field(basename(__FILE__), 'prfx_nonce');
				require ('admin/pages/metabox.php');
			}
			public function iv_listing_meta_save($post_id) {	
				
				if (isset($_REQUEST['listing_data_submit'])) { 
				$post_for=(isset($_REQUEST['post_for_radio'])?$_REQUEST['post_for_radio']: get_post_meta( $post_id,'_ep_post_for', true ));
				
					update_post_meta( $post_id,'_ep_post_for', $post_for );
					$specific_package=(isset($_REQUEST['specific_package'])?$_REQUEST['specific_package']:'');
					update_post_meta( $post_id,'_ep_postfor_package', $specific_package);
					$specific_users=(isset($_REQUEST['specific_users'])?$_REQUEST['specific_users']:'');
					update_post_meta( $post_id,'_ep_postfor_user', $specific_users);
					$specific_products=(isset($_REQUEST['Woocommerce_products'])?$_REQUEST['Woocommerce_products']:'');
					update_post_meta( $post_id,'_ep_postfor_woocommerce', $specific_products);
					$day_for=(isset($_REQUEST['day_for'])?$_REQUEST['day_for']:'');
					update_post_meta( $post_id,'_ep_day_option', $day_for );
					$day_number=(isset($_REQUEST['day_number'])?$_REQUEST['day_number']:'');
					update_post_meta( $post_id,'_ep_user_day_number', sanitize_text_field($day_number) );
					$day_date=(isset($_REQUEST['day_date'])?$_REQUEST['day_date']:'');
					update_post_meta( $post_id,'_ep_user_date', sanitize_text_field($day_date) ); 
				}
			}
			public function ep_fitness_cpt_change(){
				$custom_post_type = $_POST['select_data'];
				$args2 = array(
				'type'                     => $custom_post_type,						
				'orderby'                  => 'name',
				'order'                    => 'ASC',
				'hide_empty'        	   => false,
				'hierarchical'             => 0,
				'exclude'                  => '',
				'include'                  => '',
				'number'                   => '',
				'taxonomy'                 => $custom_post_type.'-category',
				'pad_counts'               => false
				);
				$categories = get_categories( $args2 );
				if ( $categories && !is_wp_error( $categories ) ) :
				$val_cat2='<select name="postcats" id="postcats" class="form-control">';
				$val_cat2=$val_cat2.'<option  value="">'.esc_html__('Any Category','epfitness').'</option>';
				foreach ( $categories as $term ) {
					$val_cat2=$val_cat2. '<option  value="'.$term->slug.'" >'.$term->name.'</option>';
				}
				$val_cat2=$val_cat2.'</select>';
				endif;	
				$args3 = array(
				'type'                     => $custom_post_type,									
				'orderby'                  => 'name',
				'order'                    => 'ASC',
				'hide_empty'               => 0,
				'hierarchical'             => 1,
				'exclude'                  => '',
				'include'                  => '',
				'number'                   => '',
				'taxonomy'                 => $custom_post_type.'_tag',
				'pad_counts'               => false
				);
				$tags='';
				$p_tag = get_categories( $args3 );												
				if ( $p_tag && !is_wp_error( $p_tag ) ) :
				foreach ( $p_tag as $term ) {
					$tags=$tags.'<div class="col-md-4"><label class="form-group"><input type="checkbox" name="tag_arr[]" id="tag_arr[]" value="'. $term->slug.'"> '.$term->name.'</label></div>';
				}
				endif;
				echo json_encode(array("msg" => $val_cat2,"tags" => $tags));
				exit(0);
			}
			/**
				* Checks that the WordPress setup meets the plugin requirements
				* @global string $wp_version
				* @return boolean
			*/
			private function check_requirements() {
				global $wp_version;
				if (!version_compare($wp_version, $this->wp_version, '>=')) {
					add_action('admin_notices', 'wp_ep_fitness::display_req_notice');
					return false;
				}
				return true;
			}
			/**
				* Display the requirement notice
				* @static
			*/
			static function display_req_notice() {
				global $wp_ep_fitness;
				echo '<div id="message" class="error"><p><strong>';
				esc_html_e( 'Sorry, BootstrapPress re requires WordPress ' . $wp_ep_fitness->wp_version . ' or higher.
				Please upgrade your WordPress setup', 'epfitness');
				echo '</strong></p></div>';
			}
			public function ep_fitness_user_exist_check(){
				global $wpdb;
				parse_str($_POST['form_data'], $data_a2);
				if(isset($data_a2['contact_captcha'])){
					$captcha_answer="";
					if(isset($data_a2['captcha_answer'])){
						$captcha_answer=$data_a2['captcha_answer'];
					}
					if($data_a2['contact_captcha']!=$captcha_answer){
						echo json_encode('captcha_error');
						exit(0);
					}						
				}
				$userdata = array();
				$user_name='';
				if(isset($data_a2['iv_member_user_name'])){
					$userdata['user_login']=$data_a2['iv_member_user_name'];
				}					
				if(isset($data_a2['iv_member_email'])){
					$userdata['user_email']=$data_a2['iv_member_email'];
				}					
				if(isset($data_a2['iv_member_password'])){
					$userdata['user_pass']=$data_a2['iv_member_password'];
				}
				if($userdata['user_login']!='' and $userdata['user_email']!='' and $userdata['user_pass']!='' ){
					$user_id = username_exists( $userdata['user_login'] );
					if ( !$user_id and email_exists($userdata['user_email']) == false ) {							
						echo json_encode('success');
						exit(0);
						} else {
						echo json_encode('User or Email exists');
						exit(0);
					}
				}
			}
			private function load_dependencies() {
				// Admin Panel
				if (is_admin()) {						
					require_once ('admin/notifications.php');						
					require('admin/admin.php');
				}
				// Front-End Site
				if (!is_admin()) {
				}		// Global
			}
			/**
				* Called every time the plug-in is activated.
			*/
			public function activate() {
				require('install/install.php');
			}
			/**
				* Called when the plug-in is deactivated.
			*/
			public function deactivate() {
				global $wpdb;			
				$page_name='price-table';						
				$query = $wpdb->prepare("delete from {$wpdb->prefix}posts where  post_name='%s' LIMIT 1",$page_name );
				$wpdb->query($query);
				$page_name='registration';						
				$query = $wpdb->prepare("delete from {$wpdb->prefix}posts where  post_name='%s' LIMIT 1",$page_name );
				$wpdb->query($query);
				$page_name='my-account';						
				$query = $wpdb->prepare("delete from {$wpdb->prefix}posts where  post_name='%s' LIMIT 1",$page_name );
				$wpdb->query($query);
				$page_name='profile-public';						
				$query = $wpdb->prepare("delete from {$wpdb->prefix}posts where  post_name='%s' LIMIT 1",$page_name );
				$wpdb->query($query);
				$page_name='thank-you';						
				$query = $wpdb->prepare("delete from {$wpdb->prefix}posts where  post_name='%s' LIMIT 1",$page_name );
				$wpdb->query($query);
				$page_name='login';						
				$query = $wpdb->prepare("delete from {$wpdb->prefix}posts where  post_name='%s' LIMIT 1",$page_name );
				$wpdb->query($query);
				$page_name='user-directory';						
				$query = $wpdb->prepare("delete from {$wpdb->prefix}posts where  post_name='%s' LIMIT 1",$page_name );
				$wpdb->query($query);
				$page_name='iv-reminder-email-cron-job';						
				$query = $wpdb->prepare("delete from {$wpdb->prefix}posts where  post_name='%s' LIMIT 1",$page_name );
				$wpdb->query($query);
			}
			/**
				* Called when the plug-in is uninstalled
			*/
			static function uninstall() {
			}
			/**
				* Register the widgets
			*/
			public function register_widget() {
			}
			/**
				* Internationalization
			*/
			public function i18n() {
				load_plugin_textdomain('epfitness', false, basename(dirname(__FILE__)) . '/languages/' );
			}
			/**
				* Starts the plug-in main functionality
			*/
			public function start() {
			}
			
			public function ep_fitness_price_table_func($atts = '', $content = '') {				
				ob_start();						 
				include( wp_ep_fitness_template. 'price-table/price-table-1.php');
				$content = ob_get_clean();	
				return $content;			
			}			
			public function fitness_plugin_action_links( $links ) {
				$plugin_links = array(
				'<a href="admin.php?page=wp-ep_fitness-settings">' . esc_html__( 'Settings', 'epfitness' ) . '</a>',
				'<a href="'.esc_url('www.fitness.eplug-ins.com/fitpdoc').'/">' . esc_html__( 'Docs', 'epfitness' ) . '</a>','<a href="'.esc_url('www.codecanyon.net/item/fitness-trainer-training-membership-plugin/19901278/comments').'">' . esc_html__( 'Support', 'epfitness' ) . '</a>',
				);
				return array_merge( $plugin_links, $links );
			}	
			public function ep_fitness_form_wizard_func($atts = '') {
				global $current_user;
				$template_path=wp_ep_fitness_template.'signup/';
				ob_start();	 
				if($current_user->ID==0){
					$signup_access= get_option('users_can_register');	
					if($signup_access=='0'){
						esc_html_e( 'Sorry! You are not allowed for signup.', 'epfitness' );
						}else{
						include( $template_path. 'wizard-style-2.php');
					}						
					}else{						
						include( wp_ep_fitness_template. 'private-profile/profile-template-1.php');
				}			
				$content = ob_get_clean();	
				return $content;
			}
			public function ep_fitness_profile_template_func($atts = '') {
				global $current_user;
				ob_start();
				if($current_user->ID==0){
					require(wp_ep_fitness_template. 'private-profile/profile-login.php');
					}else{
					$tempale=get_option('ep_fitness_profile-template'); 
					if($tempale=='style-1'){
						include( wp_ep_fitness_template. 'private-profile/profile-template-1.php');
					}
					if($tempale=='style-2'){
						include( wp_ep_fitness_template. 'private-profile/profile-template-1.php');
					}
				}
				$content = ob_get_clean();	
				return $content;
			}
			public function  ep_fitness_save_report1(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'settings' ) ) {
					wp_die( 'Are you cheating:wpnonce10?' );
				}
				global $current_user; 
				parse_str($_POST['form_data'], $form_data);		
				if(isset($form_data['edit_report_id'])){ 
					$postid =sanitize_text_field($form_data['edit_report_id']);						
					$has_access='no';
					$current_userID= get_current_user_id();
					$post_author_id = get_post_field( 'post_author', $postid );
					$user_for=get_post_meta($postid,'report_for_user',true);
					if($current_userID==$post_author_id){
						$has_access='yes';
					}
					if(isset($current_user->roles[0]) and $current_user->roles[0]=='administrator'){
						$has_access='yes';					
					}
					if($has_access=='yes'){
						$valll= wp_delete_post($postid);	
					}
				}
				$post_type='fitnessreport';				
				$my_post = array();
				$my_post['post_title'] = 'Report for User Id :'.$form_data['report_for_user'];					
				$my_post['post_status']='private';	
				$my_post['post_type']=$post_type;
				$my_post['post_author'] = $current_user->ID;					
				$newpost_id= wp_insert_post( $my_post );					
				update_post_meta($newpost_id, 'report_date', $form_data['report_date']); 					
				update_post_meta($newpost_id, 'report_for_user', $form_data['report_for_user']);
				$default_fields = array();
				$field_set=get_option('ep_fitness_report_fields' );					
				if($field_set!=""){ 
					$default_fields=get_option('ep_fitness_report_fields' );
					}else{															
					$default_fields['goals']='Goals';
					$default_fields['reportsummary']='Report Summary';
					$default_fields['in_short']='In Short';
					$default_fields['weight_related_goals']='Weight related goals';
					$default_fields['fitness_related_goals']='Fitness related goals';
					$default_fields['blood_pressure']='Blood pressure';
					$default_fields['Other_notes']='Other notes';
					$default_fields['commit_suggestions']='We agreed you commit to the following suggestions:';
					$default_fields['Nutrition']='Nutrition';
					$default_fields['Hydration']='Hydration';
					$default_fields['Exercise_and_activity']='Exercise and activity';
					$default_fields['Other_consumables ']='Other consumables';
					$default_fields['Sleep']='Sleep';
					$default_fields['Rest']='Rest';
					$default_fields['focus_following_areas']='We agreed that you focus on the following area';
					$default_fields['following_weekly_plan']='We agreed to the following overall/weekly plan';
					$default_fields['motivation1']='You highlighted the following main challenges you face in committing to the above plan';
					$default_fields['motivation2']='We agreed on the following strategies for overcoming these challenges';
				}
				$i=1;	
				foreach ( $default_fields as $field_key => $field_value ) {	
					update_post_meta($newpost_id, $field_key, sanitize_textarea_field($form_data[$field_key]));
				}	
				echo json_encode(array("code" => "success","msg"=>"Report Saved "));
				exit(0);
			}	
			public function ep_fitness_reminder_email_cron_func ($atts = ''){
				include( wp_ep_fitness_ABSPATH. 'inc/reminder-email-cron.php');
			}
			public function ep_fitness_cron_job(){
				include( wp_ep_fitness_ABSPATH. 'inc/all_cron_job.php');
				exit(0);
			}
			public function ep_fitness_paypal_notify_url(){				
				include( wp_ep_fitness_ABSPATH. 'inc/paypal_deal_notify_mail.php');	
				exit(0);
			}
			public function ep_fitness_message_send(){
				parse_str($_POST['form_data'], $form_data);					
				include( wp_ep_fitness_ABSPATH. 'inc/message-mail.php');	
				echo json_encode(array("msg" => 'Message Sent'));
				exit(0);
			}
			public function paging() {
				global $wp_query;
			} 
			public function check_write_access($arg=''){
				$current_user = wp_get_current_user();
				$userId=$current_user->ID;
				if(isset($current_user->roles[0]) and $current_user->roles[0]=='administrator'){
					return true;
				}		
				$package_id=get_user_meta($userId,'ep_fitness_package_id',true);
				$access=get_post_meta($package_id, 'ep_fitness_package_'.$arg, true);
				if($access=='yes'){
					return true;
					}else{
					return false;
				}
			} 
			public function check_reading_access($arg='',$id=0){
				global $post;
				$current_user = wp_get_current_user();
				$userId=$current_user->ID;
				if($id>0){
					$post = get_post($id);
				}			 
				if($post->post_author==$userId){
					return true;
				}
				$package_id=get_user_meta($userId,'ep_fitness_package_id',true);					 
				$access=get_post_meta($package_id, 'ep_fitness_package_'.$arg, true);
				$active_module=get_option('_ep_fitness_active_visibility'); 
				if($active_module=='yes' ){		
					if(isset($current_user->ID) AND $current_user->ID!=''){
						$user_role= $current_user->roles[0];
						if(isset($current_user->roles[0]) and $current_user->roles[0]=='administrator'){
							return true;
						}																
						}else{							
						$user_role= 'visitor';
					}	
					$store_array=get_option('_iv_visibility_serialize_role');	
					if(isset($store_array[$user_role]))
					{	
						if(in_array($arg, $store_array[$user_role])){
							return true;
							}else{
							return false;
						}
						}else{ 
						return false;
					}
					}else{
					return true;
				}
			}
		}
	}
	/*
		* Creates a new instance of the BoilerPlate Class
	*/
	function ep_fitnessBootstrap() {
		return wp_ep_fitness::instance();
	}
ep_fitnessBootstrap(); ?>