<?php
	if (!defined('ABSPATH')) {
		exit;
	}
	/**
		* The Admin Panel and related tasks are handled in this file.
	*/
	if (!class_exists('wp_ep_fitness_Admin')) {
		class wp_ep_fitness_Admin {
			static $pages = array();
			public function __construct() {
				add_action('admin_menu', array($this, 'admin_menu'));
				add_action('admin_print_scripts', array($this, 'load_scripts'));
				add_action('admin_print_styles', array($this, 'load_styles'));
				add_action('wp_ajax_ep_fitness_save_settings', array($this, 'ep_fitness_save_settings'));
				add_action('wp_ajax_ep_fitness_get_settings', array($this, 'ep_fitness_get_settings'));
				add_action('wp_ajax_ep_fitness_get_node', array($this, 'ep_fitness_get_node'));
				add_action('wp_ajax_ep_fitness_save_package', array($this, 'ep_fitness_save_package'));
				add_action('wp_ajax_ep_fitness_update_package', array($this, 'ep_fitness_update_package'));
				add_action('wp_ajax_ep_fitness_update_form_payment', array($this, 'ep_fitness_update_form_payment'));
				add_action('wp_ajax_ep_fitness_update_paypal_settings', array($this, 'ep_fitness_update_paypal_settings'));
				add_action('wp_ajax_ep_fitness_update_stripe_settings', array($this, 'ep_fitness_update_stripe_settings'));
				add_action('wp_ajax_ep_fitness_create_coupon', array($this, 'ep_fitness_create_coupon'));
				add_action('wp_ajax_ep_fitness_update_coupon', array($this, 'ep_fitness_update_coupon'));
				add_action('wp_ajax_ep_fitness_update_payment_setting', array($this, 'ep_fitness_update_payment_setting'));
				add_action('wp_ajax_ep_fitness_update_page_setting', array($this, 'ep_fitness_update_page_setting'));
				add_action('wp_ajax_ep_fitness_update_email_setting', array($this, 'ep_fitness_update_email_setting'));
				add_action('wp_ajax_ep_fitness_update_mailchamp_setting', array($this, 'ep_fitness_update_mailchamp_setting'));
				add_action('wp_ajax_ep_fitness_update_package_status', array($this, 'ep_fitness_update_package_status'));
				add_action('wp_ajax_ep_fitness_gateway_settings_update', array($this, 'ep_fitness_gateway_settings_update'));
				add_action('wp_ajax_ep_fitness_update_account_setting', array($this, 'ep_fitness_update_account_setting'));				
				add_action('wp_ajax_ep_fitness_update_user_settings', array($this, 'ep_fitness_update_user_settings'));
				add_action('wp_ajax_ep_fitness_settings_save', array($this, 'ep_fitness_settings_save'));
				add_action('wp_ajax_ep_fitness_email_admin_template_change', array($this, 'ep_fitness_email_admin_template_change'));
				add_action('wp_ajax_ep_fitness_update_profile_fields', array($this, 'ep_fitness_update_profile_fields'));
				add_action('wp_ajax_ep_fitness_update_dir_fields', array($this, 'ep_fitness_update_dir_fields'));
				add_action('wp_ajax_ep_fitness_update_report_fields', array($this, 'ep_fitness_update_report_fields'));
				add_action('wp_ajax_ep_fitness_update_post_type', array($this, 'ep_fitness_update_post_type'));
				add_action('wp_ajax_ep_fitness_update_post_type_page', array($this, 'ep_fitness_update_post_type_page'));
				add_action('wp_ajax_iv_update_dir_setting', array($this, 'iv_update_dir_setting'));
				add_action( 'init', array($this, 'ep_fitness_payment_post_type') );
				add_filter( 'manage_edit-iv_payment_columns', array($this, 'set_custom_edit_iv_payment_columns')  );
				add_action( 'manage_iv_payment_posts_custom_column' ,  array($this, 'custom_iv_payment_column')  , 10, 2 );
				$this->action_hook();
				wp_admin_notifications::load();
			}
			// Hook into the 'init' action
			public function ep_fitness_payment_post_type() {
				$args = array(
				'description' => 'ep_fitness Payment Post Type',
				'show_ui' => true,
				'exclude_from_search' => true,
				'labels' => array(
				'name'=> 'Payment History',
				'singular_name' => 'iv_payment',
				'edit' => 'Edit Payment History',
				'edit_item' => 'Edit Payment History',
				'view' => 'View Payment History',
				'view_item' => 'View Payment History',
				'search_items' => 'Search ',
				'not_found' => 'No  Found',
				'not_found_in_trash' => 'No Found in Trash',
				),
				'public' => true,
				'publicly_queryable' => false,
				'exclude_from_search' => true,
				'show_ui' => true,
				'show_in_menu' => 'flase',
				'hiearchical' => false,
				'capability_type' => 'post',
				'hierarchical' => false,
				'rewrite' => true,
				'supports' => array('title', 'editor', 'thumbnail','excerpt','custom-fields'),
				);
				register_post_type( 'iv_payment', $args );
				
				///ep_fitness_pack new post type for package
				$args2 = array(
				'description' => 'Packages',
				'show_ui' => true,
				'exclude_from_search' => true,
				'labels' => array(
				'name'=> 'Packages',
				'singular_name' => 'Package',
				'edit' => 'Edit Packages',
				'edit_item' => 'Edit Packages',
				'view' => 'View Packages',
				'view_item' => 'View Packages',
				'search_items' => 'Search ',
				'not_found' => 'No  Found',
				'not_found_in_trash' => 'No Found in Trash',),
				'public' => true,
				'publicly_queryable' => false,
				'exclude_from_search' => true,
				'show_ui' => true,
				'show_in_menu' => false,
				'hiearchical' => false,
				'capability_type' => 'post',
				'hierarchical' => false,
				'rewrite' => true,
				'supports' => array('title', 'editor', 'thumbnail','excerpt','custom-fields'),
				);
				register_post_type( 'ep_fitness_pack', $args2 );
				
			}
			public function set_custom_edit_iv_payment_columns($columns) {
				$columns['title']='Package Name';
				$columns['User'] = 'User Name';
				$columns['Member'] = 'User ID';
				$columns['Amount'] ='Amount';
				return $columns;
			}
			public function custom_iv_payment_column( $column, $post_id ) {
				global $post;
				switch ( $column ) {
					case 'User' :
					if(isset($post->post_author) ){
						$user_info = get_userdata( $post->post_author);
						if($user_info!='' ){
							$fullname = get_user_meta($user_info->ID,'first_name',true).' '.get_user_meta($user_info->ID,'last_name',true);
							echo  $fullname.' -> '.$user_info->user_login ;
						}
					}
					break;
					case 'Member' :
					echo esc_html($post->post_author);
					break;
					case 'Amount' :
					echo esc_html($post->post_content);
					break;
				}
			}
			/**
				* Menus in the wp-admin sidebar
			*/
			public function admin_menu() {
				add_menu_page('WP ep_fitness', 'Fit Membership', 'manage_options', 'wp-ep_fitness', array($this, 'menu_hook'),'dashicons-screenoptions',3);
				self::$pages['wp-ep_fitness-settings'] = add_submenu_page('wp-ep_fitness', 'WP ep_fitness Settings', 'Settings', 'manage_options', 'wp-ep_fitness-settings', array($this, 'menu_hook'));
				self::$pages['wp-ep_fitness-package-all'] = add_submenu_page('wp-ep_fitness', 'Package', 'Package', 'manage_options', 'wp-ep_fitness-package-all', array($this, 'menu_hook'));
				self::$pages['wp-ep_fitness-coupons-form'] = add_submenu_page('wp-ep_fitness', 'WP ep_fitness Create', 'Coupons', 'manage_options', 'wp-ep_fitness-coupons-form', array($this, 'menu_hook'));
				self::$pages['wp-ep_fitness-payment-setting'] = add_submenu_page('wp-ep_fitness', 'WP ep_fitness Settings', 'Payment Gateways', 'manage_options', 'wp-ep_fitness-payment-settings', array($this, 'menu_hook'));
			
				self::$pages['wp-iv_user-directory-admin'] = add_submenu_page('wp-ep_fitness', 'WP ep_fitness directory-admin', 'User Setting', 'manage_options', 'wp-iv_user-directory-admin', array($this, 'menu_hook'));
				
				add_submenu_page('wp-ep_fitness', 'WP ep_fitness', 'Payment  History', 'manage_options',  'edit.php?post_type=iv_payment');
				self::$pages['wp-ep_fitness-package-create'] = add_submenu_page('', 'WP ep_fitness package', '', 'manage_options', 'wp-ep_fitness-package-create', array($this, 'package_create_page'));
				self::$pages['wp-ep_fitness-package-update'] = add_submenu_page('', 'WP ep_fitness package', '', 'manage_options', 'wp-ep_fitness-package-update', array($this, 'package_update_page'));
				self::$pages['wp-ep_fitness-coupon-create'] = add_submenu_page('', 'WP ep_fitness coupon', '', 'manage_options', 'wp-ep_fitness-coupon-create', array($this, 'coupon_create_page'));
				self::$pages['wp-ep_fitness-coupon-update'] = add_submenu_page('', 'WP ep_fitness coupon', '', 'manage_options', 'wp-ep_fitness-coupon-update', array($this, 'coupon_update_page'));
				self::$pages['wp-ep_fitness-payment-paypal'] = add_submenu_page('', 'WP ep_fitness Payment setting', '', 'manage_options', 'wp-ep_fitness-payment-paypal', array($this, 'paypal_update_page'));
				self::$pages['wp-ep_fitness-payment-authorize'] = add_submenu_page('', 'WP ep_fitness Payment setting', '', 'manage_options', 'wp-ep_fitness-payment-authorize', array($this, 'authorize_update_page'));
				self::$pages['wp-ep_fitness-payment-stripe'] = add_submenu_page('', 'WP ep_fitness Payment setting', '', 'manage_options', 'wp-ep_fitness-payment-stripe', array($this, 'stripe_update_page'));
				self::$pages['wp-ep_fitness-user_update'] = add_submenu_page('', 'WP ep_fitness user_update', '', 'manage_options', 'wp-ep_fitness-user_update', array($this, 'user_update_page'));
			}
			/**
				* Menu Page Router
			*/
			public function menu_hook() {
				$screen = get_current_screen();
				switch ($screen->id) {
					default:
					include ('pages/welcome.php');
					break;
					case self::$pages['wp-ep_fitness-coupons-form']:
					include ('pages/all_coupons.php');
					break;
					case self::$pages['wp-ep_fitness-settings']:
					include ('pages/settings.php');
					break;
					case self::$pages['wp-ep_fitness-package-all']:
					include ('pages/package_all.php');
					break;
					case self::$pages['wp-ep_fitness-payment-setting']:
					include ('pages/payment-settings.php');
					break;
					case self::$pages['wp-iv_user-directory-admin']:
					include ('pages/user_directory_admin.php');
					break;
				}
			}
			public function  profile_fields_setting (){
				include ('pages/profile-fields.php');
			}
			public function coupon_create_page(){
				include ('pages/coupon_create.php');
			}
			public function coupon_update_page(){
				include ('pages/coupon_update.php');
			}
			public function package_create_page(){
				include ('pages/package_create.php');
			}
			public function package_update_page(){
				include ('pages/package_update.php');
			}
			public function authorize_update_page(){
				include ('pages/authorize_update.php');
			}
			public function paypal_update_page(){
				include ('pages/paypal_update.php');
			}
			public function stripe_update_page(){
				include ('pages/stripe_update.php');
			}
			public function user_update_page(){
				include ('pages/user_update.php');
			}
			/**
				* Page based Script Loader
			*/
			public function load_scripts() {
				$screen = get_current_screen();
				if (in_array($screen->id, array_values(self::$pages))) {
					$currencyCode='USD';
					wp_enqueue_script('jquery-ui-core');	
					wp_enqueue_script('jquery-ui-datepicker');				
					wp_enqueue_script('ep_fitness-script-4', wp_ep_fitness_URLPATH . 'admin/files/js/bootstrap.min.js');
					wp_enqueue_script('iv_property-script-dashboardadmin', wp_ep_fitness_URLPATH . 'admin/files/js/admin.js');
					wp_localize_script('iv_property-script-dashboardadmin', 'admindata', array(
					'ajaxurl' 				=> admin_url( 'admin-ajax.php' ),
					'loading_image'		=> '<img src="'.wp_ep_fitness_URLPATH.'admin/files/images/loader.gif">',
					'wp_ep_fitness_URLPATH'		=> wp_ep_fitness_URLPATH,
					'wp_ep_fitness_ADMINPATH' => wp_ep_fitness_ADMINPATH,
					'current_user_id'	=>get_current_user_id(),	
					'SetImage'		=>esc_html__('Set Image','epfitness'),
					'GalleryImages'=>esc_html__('Gallery Images','epfitness'),	
					'cancel-message' => esc_html__('Are you sure to cancel this Membership','epfitness'),
					'currencyCode'=>  $currencyCode,
					'dirwpnonce'=> wp_create_nonce("myaccount"),
					'settings'=> wp_create_nonce("settings"), 					
					'packagenonce'=> wp_create_nonce("package"),										
					'signup'=> wp_create_nonce("signup"),
					'contact'=> wp_create_nonce("contact"),
					'coupon'=> wp_create_nonce("coupon"),
					'fields'=> wp_create_nonce("fields"),
					'dirsetting'=> wp_create_nonce("dir-setting"),
					'mymenu'=> wp_create_nonce("my-menu"),
					'paymentgateway'=> wp_create_nonce("payment-gateway"), 
					'permalink'=> get_permalink(),			
					) );
				}
			}
			/**
				* Page based Style Loader
			*/
			public function load_styles() { 
				$screen = get_current_screen();
				if (in_array($screen->id, array_values(self::$pages))) {
					wp_enqueue_style('jquery-ui', wp_ep_fitness_URLPATH . 'admin/files/css/jquery-ui.css');
					
					wp_enqueue_style('wp-ep_fitness-style-4', wp_ep_fitness_URLPATH . 'admin/files/css/dashboard_admin.css');
				}
				wp_enqueue_style('wp-ep_fitness-style-2', wp_ep_fitness_URLPATH . 'admin/files/css/iv-bootstrap.css');
			}
			/**
				* This function declares the different forms, sections and fields.
			*/
			public function settings_form() {
				register_setting('wp_ep_fitness_settings', 'wp_ep_fitness_settings', array(&$this, 'validate'));
				add_settings_section('general_section', 'General Settings', 'wp_admin_forms::section_description', 'wp_ep_fitness_general_section');
				add_settings_field('text_field', 'Text Field', 'wp_admin_forms::textbox', 'wp_ep_fitness_general_section', 'general_section', array('id' => 'text_field', 'text' => '', 'settings' => 'wp_ep_fitness_settings'));
				add_settings_field('checkbox_field', 'Checkbox Field', 'wp_admin_forms::checkbox', 'wp_ep_fitness_general_section', 'general_section', array('id' => 'checkbox_field', 'text' => '', 'settings' => 'wp_ep_fitness_settings'));
				add_settings_field('textarea_field', 'Textbox Field', 'wp_admin_forms::textarea', 'wp_ep_fitness_general_section', 'general_section', array('id' => 'textarea_field', 'settings' => 'wp_ep_fitness_settings'));
			}
			/**
				* This functions validate the submitted user input.
				* @param array $var
				* @return array
			*/
			public function validate($var) {
				return $var;
			}
			/**
				* Use this function to execute actions
			*/
			public function action_hook() {
				if (!isset($_GET['action'])) {
					return;
				}
				switch ($_GET['action']) {
				}
			}
			public function ep_fitness_save_package() {
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'settings' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				parse_str($_POST['form_data'], $form_data);
				global $wpdb;
				$ep_fitness_pack='ep_fitness_pack';
				$last_post_id = $wpdb->get_var($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE post_type = '%s' ORDER BY `ID` DESC ", $ep_fitness_pack) );
				$form_number = $last_post_id + 1;
				$role_name='';
				if($form_data['package_name']==""){
					$post_name = 'Package' . $form_number;
					$role_name=$post_name;
					}else{
					$post_name = sanitize_text_field($form_data['package_name']) .'-'. $form_number;
					$role_name=sanitize_text_field($form_data['package_name']);
				}
				$post_title=sanitize_text_field($form_data['package_name']);
				$post_content= sanitize_textarea_field($form_data['package_feature']);
				$my_post_form = array('post_title' => wp_strip_all_tags($post_title), 'post_name' => wp_strip_all_tags($post_name), 'post_content' => $post_content, 'post_status' => 'draft', 'post_author' => get_current_user_id(),);
				$newpost_id = wp_insert_post($my_post_form);
				$post_type = 'ep_fitness_pack';
				$query = $wpdb->prepare("UPDATE {$wpdb->prefix}posts SET post_type='%s' WHERE id='%s' LIMIT 1",$post_type ,$newpost_id );
				$wpdb->query($query);
				update_post_meta($newpost_id, 'ep_fitness_package_cost', sanitize_text_field($form_data['package_cost']));
				update_post_meta($newpost_id, 'ep_fitness_package_initial_expire_interval', sanitize_text_field($form_data['package_initial_expire_interval']));
				update_post_meta($newpost_id, 'ep_fitness_package_initial_expire_type', sanitize_text_field($form_data['package_initial_expire_type']));
				update_post_meta($newpost_id, 'ep_fitness_display_order', sanitize_text_field($form_data['package_order']));
				//Woocommerce_products
				if(isset($form_data['Woocommerce_product'])){
					update_post_meta($newpost_id, 'ep_fitness_package_woocommerce_product', sanitize_text_field($form_data['Woocommerce_product']));
				}
				//trainer package*********
				update_post_meta($newpost_id, 'ep_fitness_package4pt', sanitize_text_field($form_data['pt_package']));
				update_user_meta($form_data['pt_package'], 'trainer_package',$newpost_id);
				if(isset($form_data['package_recurring'])){
					update_post_meta($newpost_id, 'ep_fitness_package_recurring', sanitize_text_field($form_data['package_recurring']));
					}else{
					update_post_meta($newpost_id, 'ep_fitness_package_recurring', '');
				}
				if(isset($form_data['eplugins_stripe_plan'])){
					update_post_meta($newpost_id, 'eplugins_stripe_plan', sanitize_text_field($form_data['eplugins_stripe_plan']));
					}else{
					update_post_meta($newpost_id, 'eplugins_stripe_plan', '');
				}
				update_post_meta($newpost_id, 'ep_fitness_package_recurring_cost_initial', sanitize_text_field($form_data['package_recurring_cost_initial']));
				update_post_meta($newpost_id, 'ep_fitness_package_recurring_cycle_count', sanitize_text_field($form_data['package_recurring_cycle_count']));
				update_post_meta($newpost_id, 'ep_fitness_package_recurring_cycle_type', sanitize_text_field($form_data['package_recurring_cycle_type']));
				update_post_meta($newpost_id, 'ep_fitness_package_recurring_cycle_limit', sanitize_text_field($form_data['package_recurring_cycle_limit']));
				if(isset($form_data['package_enable_trial_period'])){
					update_post_meta($newpost_id, 'ep_fitness_package_enable_trial_period', sanitize_text_field($form_data['package_enable_trial_period']));
					}else{
					update_post_meta($newpost_id, 'ep_fitness_package_enable_trial_period', 'no');
				}
				update_post_meta($newpost_id, 'ep_fitness_package_trial_amount', sanitize_text_field($form_data['package_trial_amount']));
				update_post_meta($newpost_id, 'ep_fitness_package_trial_period_interval', sanitize_text_field($form_data['package_trial_period_interval']));
				update_post_meta($newpost_id, 'ep_fitness_package_recurring_trial_type', sanitize_text_field($form_data['package_recurring_trial_type']));
				// Start User Role
				global $wp_roles;
				$contributor_roles = $wp_roles->get_role('contributor');
				$role_name_new= str_replace(' ', '_', $role_name);
				$wp_roles->remove_role( $role_name_new );
				$role_display_name = $role_name;
				$wp_roles->add_role($role_name_new, $role_display_name, array(
				'read' => true, // True allows that capability, False specifically removes it.
				'edit_posts' => true,
				'delete_posts' => true,
				'upload_files' => true //last in array needs no comma!
				));
				update_post_meta($newpost_id, 'ep_fitness_package_user_role', $role_name_new);
				if(isset($form_data['training_program'])){
					update_post_meta($newpost_id, 'iv_training_program', sanitize_text_field($form_data['training_program']));
				}
				// End User Role
				// For Stripe Plan Create*****
				if(isset($form_data['package_recurring'])){
					$iv_gateway = get_option('ep_fitness_payment_gateway');
					if($iv_gateway=='stripe'){
						include(wp_ep_fitness_DIR . '/admin/files/init.php');
						$post_name2='ep_fitness_stripe_setting';
						$row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_name = '%s' ",$post_name2));
						if(isset($row->ID )){
							$stripe_id= $row->ID;
						}
						$stripe_mode=get_post_meta( $stripe_id,'ep_fitness_stripe_mode',true);
						if($stripe_mode=='test'){
							$stripe_api =get_post_meta($stripe_id, 'ep_fitness_stripe_secret_test',true);
							}else{
							$stripe_api =get_post_meta($stripe_id, 'ep_fitness_stripe_live_secret_key',true);
						}
						$interval_count= ($form_data['package_recurring_cycle_count']=="" ? '1':sanitize_text_field($form_data['package_recurring_cycle_count']));
						$stripe_currency =get_post_meta($stripe_id, 'ep_fitness_stripe_api_currency',true);
						\Stripe\Stripe::setApiKey($stripe_api);
						$stripe_array=array();
						$post_package_one = get_post($newpost_id);
						$p_name = $post_package_one->post_name;
						$stripe_array['id']= $p_name;
						$stripe_array['amount']=$form_data['package_recurring_cost_initial'] * 100;
						$stripe_array['interval']=sanitize_text_field($form_data['package_recurring_cycle_type']);
						$stripe_array['interval_count']=$interval_count;
						$stripe_array['currency']=$stripe_currency;
						$stripe_array['product']=array('name' => $p_name);
						$trial=get_post_meta($newpost_id, 'ep_fitness_package_enable_trial_period', true);
						if($trial=='yes'){
							$trial_type = get_post_meta( $newpost_id,'ep_fitness_package_recurring_trial_type',true);
							$trial_cycle_count =get_post_meta($newpost_id, 'ep_fitness_package_trial_period_interval', true);
							switch ($trial_type) {
								case 'year':
								$periodNum =  365 * 1;
								break;
								case 'month':
								$periodNum =  30 * $trial_cycle_count;
								break;
								case 'week':
								$periodNum = 7 * $trial_cycle_count;
								break;
								case 'day':
								$periodNum = 1 * $trial_cycle_count;
								break;
							}
							$stripe_array['trial_period_days']=$periodNum;
						}
						\Stripe\Plan::create($stripe_array);
					}
				}
				// End Stripe Plan Create*****
				echo json_encode(array('code' => 'success'));
				exit(0);
			}
			public function iv_update_dir_setting(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'settings' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				parse_str($_POST['form_data'], $form_data);
				update_option('_dir_top_filter',sanitize_text_field($form_data['dir_top_filter']));
				update_option('_dir_done',sanitize_text_field($form_data['dir_done']));
				update_option('_dir_color',sanitize_text_field($form_data['dir_color']));
				update_option('fitness_calendar_days',sanitize_text_field($form_data['fitness_calendar_days']));
				echo json_encode(array("code" => "success","msg"=>"Updated Successfully"));
				exit(0);
			}
			public function ep_fitness_update_profile_fields(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'settings' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
						
				parse_str($_POST['form_data'], $form_data);
				$opt_array= array();
				$signup_array= array();
				$require_array= array();
				$max = sizeof($form_data['meta_name']);
				for($i = 0; $i < $max;$i++)
				{	
					if(strtolower($form_data['meta_name'][$i])!='wp_capabilities'){
						if($form_data['meta_name'][$i]!="" AND $form_data['meta_label'][$i]!=""){							
							$meta_name= trim(sanitize_text_field($form_data['meta_name'][$i]));
							$meta_name= strtolower(str_replace(" ",'', $meta_name));						
								$opt_array[$meta_name]=$form_data['meta_label'][$i];
								$default_signup='no';
								if(isset($form_data['signup'][$i])){
									$default_signup='yes';
									$signup_array[$form_data['signup'][$i]]=$default_signup;
								}
								$default_require='no';
								if(isset($form_data['srequire'][$i])){
									$default_require='yes';
									$require_array[$form_data['srequire'][$i]]=$default_require;
								}
							}	
					}
				}
				update_option('ep_fitness_profile_fields', $opt_array );
				update_option('ep_fitness_signup_fields', $signup_array );
				update_option('ep_fitness_signup_require', $require_array );
				$opt_array2= array();
				update_option('ep_fitness_profile_menu', '' );
				if(isset($form_data['menu_title'])){
					$max = sizeof($form_data['menu_title']);
					for($i = 0; $i < $max;$i++)
					{
						if($form_data['menu_title'][$i]!="" AND $form_data['menu_link'][$i]!=""){
							$opt_array2[$form_data['menu_title'][$i]]=sanitize_text_field($form_data['menu_link'][$i]);
						}
					}
					update_option('ep_fitness_profile_menu', $opt_array2 );
				}
				// remove menu******
				if(isset($form_data['listinghome'])){
					update_option( '_ep_fitness_menu_listinghome' ,sanitize_text_field($form_data['listinghome']));
					}else{
					update_option( '_ep_fitness_menu_listinghome' ,'no') ;
				}
				if(isset($form_data['mylevel'])){
					update_option( '_ep_fitness_mylevel' ,sanitize_text_field($form_data['mylevel']));
					}else{
					update_option( '_ep_fitness_mylevel' ,'no') ;
				}
				if(isset($form_data['menusetting'])){
					update_option( '_ep_fitness_menusetting' ,sanitize_text_field($form_data['menusetting']));
					}else{
					update_option( '_ep_fitness_menusetting' ,'no') ;
				}
				if(isset($form_data['menurecords'])){
					update_option( '_ep_fitness_menurecords' ,sanitize_text_field($form_data['menurecords']));
					}else{
					update_option( '_ep_fitness_menurecords' ,'no') ;
				}
				if(isset($form_data['menuadd-record'])){
					update_option( '_ep_fitness_menuadd-record' ,sanitize_text_field($form_data['menuadd-record']));
					}else{
					update_option( '_ep_fitness_menuadd-record' ,'no') ;
				}
				if(isset($form_data['menuadd-report'])){
					update_option( '_ep_fitness_menuadd-report' ,sanitize_text_field($form_data['menuadd-report']));
					}else{
					update_option( '_ep_fitness_menuadd-report' ,'no') ;
				}
				if(isset($form_data['menumy-report'])){
					update_option( '_ep_fitness_menumy-report' ,sanitize_text_field($form_data['menumy-report']));
					}else{
					update_option( '_ep_fitness_menumy-report' ,'no') ;
				}
				echo json_encode(array('code' => esc_html__( 'Update Successfully', 'epfitness')));
				exit(0);
			}
			public function  ep_fitness_update_post_type_page(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'settings' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				parse_str($_POST['form_data'], $form_data);
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
				
				$i=1;
				foreach ( $default_fields as $field_key => $field_value ) {
					update_option('cpt_page_'.$field_key, $form_data['cpt_page_'.$field_key]);
				}
				echo json_encode(array('code' => esc_html__( 'Update Successfully', 'epfitness')));
				exit(0);
			}
			public function  ep_fitness_update_post_type(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'settings' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				parse_str($_POST['form_data'], $form_data);
				$opt_array= array();
				$max = sizeof($form_data['posttype_name']);
				for($i = 0; $i < $max;$i++)
				{
					if($form_data['posttype_name'][$i]!="" AND $form_data['posttype_label'][$i]!=""){
						$post_type_key= trim(sanitize_text_field($form_data['posttype_name'][$i]));
						$post_type_key= strtolower(str_replace(" ",'', $post_type_key));
						$opt_array[$post_type_key]=sanitize_text_field($form_data['posttype_label'][$i]);
					}
				}
				update_option('_ep_fitness_url_postype', $opt_array );
				echo json_encode(array('code' => esc_html__( 'Update Successfully', 'epfitness')));
				exit(0);
			}
			public function ep_fitness_update_report_fields(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'settings' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				parse_str($_POST['form_data'], $form_data);
				$opt_array= array();
				$max = sizeof($form_data['meta_name']);
				for($i = 0; $i < $max;$i++)
				{
					if($form_data['meta_name'][$i]!="" AND $form_data['meta_label'][$i]!=""){
						
						$meta_name= trim(sanitize_text_field($form_data['meta_name'][$i]));
						$meta_name= strtolower(str_replace(" ",'', $meta_name));						
						$opt_array[$meta_name]=sanitize_text_field($form_data['meta_label'][$i]);
					}
				}
				update_option('ep_fitness_report_fields', $opt_array );
				update_option('epfitness_report_access', sanitize_text_field($form_data['report_access']));
				update_option('epfitness_trainer_role',  sanitize_text_field($form_data['trainer_role']));
				update_option('epfitness_report_title1', sanitize_text_field($form_data['report_title1']));
				update_option('epfitness_report_title2', sanitize_text_field($form_data['report_title2']));
				echo json_encode(array('code' => esc_html__( 'Update Successfully', 'epfitness')));
				exit(0);
			}
			public function ep_fitness_update_dir_fields(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'settings' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				
				parse_str($_POST['form_data'], $form_data);
				$opt_array= array();
				$max = sizeof($form_data['meta_name']);
				for($i = 0; $i < $max;$i++)
				{
					
					
					if($form_data['meta_name'][$i]!="" AND $form_data['meta_label'][$i]!=""){
						$meta_name= trim(sanitize_text_field($form_data['meta_name'][$i]));
						$meta_name= strtolower(str_replace(" ",'', $meta_name));
					
						$opt_array[$meta_name]=sanitize_text_field( $form_data['meta_label'][$i] );
					}
				}
				update_option('ep_fitness_fields', $opt_array );
				echo json_encode(array('code' => esc_html__( 'Update Successfully', 'epfitness')));
				exit(0);
			}
			public function ep_fitness_update_package() {
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'settings' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				parse_str($_POST['form_data'], $form_data);
				$post_content="";
				global $wpdb;
				$post_title=sanitize_text_field($form_data['package_name']);
				$post_id=sanitize_text_field($form_data['package_id']);
				$newpost_id=$post_id;
				$post_content= sanitize_textarea_field($form_data['package_feature']);
				$post_type = 'ep_fitness_pack';
				$query = $wpdb->prepare("UPDATE {$wpdb->prefix}posts SET post_title='%s', post_content='%s'  WHERE id='" . $post_id . "' LIMIT 1",$post_title , $post_content );
				$wpdb->query($query);
				update_post_meta($newpost_id, 'ep_fitness_package_cost', sanitize_text_field($form_data['package_cost']));
				update_post_meta($newpost_id, 'ep_fitness_package_initial_expire_interval', sanitize_text_field($form_data['package_initial_expire_interval']));
				update_post_meta($newpost_id, 'ep_fitness_package_initial_expire_type', sanitize_text_field($form_data['package_initial_expire_type']));
				update_post_meta($newpost_id, 'ep_fitness_display_order', sanitize_text_field($form_data['package_order']));
				//Woocommerce_products
				if(isset($form_data['Woocommerce_product'])){
					update_post_meta($newpost_id, 'ep_fitness_package_woocommerce_product', sanitize_text_field($form_data['Woocommerce_product']));
				}
				//trainer package*********
				$old_pt_user=get_post_meta($newpost_id, 'ep_fitness_package4pt', true);
				delete_user_meta($old_pt_user, 'trainer_package');
				update_post_meta($newpost_id, 'ep_fitness_package4pt', sanitize_text_field($form_data['pt_package']));
				update_user_meta($form_data['pt_package'], 'trainer_package',$newpost_id);
				if(isset($form_data['package_recurring'])){
					update_post_meta($newpost_id, 'ep_fitness_package_recurring', sanitize_text_field($form_data['package_recurring']));
					}else{
					update_post_meta($newpost_id, 'ep_fitness_package_recurring', '');
				}
				if(isset($form_data['eplugins_stripe_plan'])){
					update_post_meta($newpost_id, 'eplugins_stripe_plan', sanitize_text_field($form_data['eplugins_stripe_plan']));
					}else{
					update_post_meta($newpost_id, 'eplugins_stripe_plan', '');
				}
				if(isset($form_data['package_recurring'])){
					update_post_meta($newpost_id, 'ep_fitness_package_recurring', sanitize_text_field($form_data['package_recurring']));
					update_post_meta($newpost_id, 'ep_fitness_package_recurring_cost_initial', sanitize_text_field($form_data['package_recurring_cost_initial']));
					update_post_meta($newpost_id, 'ep_fitness_package_recurring_cycle_count', sanitize_text_field($form_data['package_recurring_cycle_count']));
					update_post_meta($newpost_id, 'ep_fitness_package_recurring_cycle_type', sanitize_text_field($form_data['package_recurring_cycle_type']));
					update_post_meta($newpost_id, 'ep_fitness_package_recurring_cycle_limit', sanitize_text_field($form_data['package_recurring_cycle_limit']));
					if(isset($form_data['package_enable_trial_period'])){
						update_post_meta($newpost_id, 'ep_fitness_package_enable_trial_period', sanitize_text_field($form_data['package_enable_trial_period']));
						}else{
						update_post_meta($newpost_id, 'ep_fitness_package_enable_trial_period', 'no');
					}
					update_post_meta($newpost_id, 'ep_fitness_package_trial_amount', sanitize_text_field($form_data['package_trial_amount']));
					update_post_meta($newpost_id, 'ep_fitness_package_trial_period_interval', sanitize_text_field($form_data['package_trial_period_interval']));
					update_post_meta($newpost_id, 'ep_fitness_package_recurring_trial_type', sanitize_text_field($form_data['package_recurring_trial_type']));
				}
				if(isset($form_data['training_program'])){
					update_post_meta($newpost_id, 'iv_training_program', sanitize_text_field($form_data['training_program']));
				}
				// For Stripe*****
				// For Stripe Plan Edit*****
				if(isset($form_data['package_recurring'])){
					$iv_gateway = get_option('ep_fitness_payment_gateway');
					if($iv_gateway=='stripe'){
						include(wp_ep_fitness_DIR . '/admin/files/init.php');
						$post_name2='ep_fitness_stripe_setting';
						$row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_name = '%s' ",$post_name2 ));
						if(isset($row->ID )){
							$stripe_id= $row->ID;
						}
						$stripe_mode=get_post_meta( $stripe_id,'ep_fitness_stripe_mode',true);
						if($stripe_mode=='test'){
							$stripe_api =get_post_meta($stripe_id, 'ep_fitness_stripe_secret_test',true);
							}else{
							$stripe_api =get_post_meta($stripe_id, 'ep_fitness_stripe_live_secret_key',true);
						}
						$interval_count= ($form_data['package_recurring_cycle_count']=="" ? '1':sanitize_text_field($form_data['package_recurring_cycle_count']));
						$stripe_currency =get_post_meta($stripe_id, 'ep_fitness_stripe_api_currency',true);
						\Stripe\Stripe::setApiKey($stripe_api);
						$stripe_array=array();
						$post_package_one = get_post($newpost_id);
						$p_name = $post_package_one->post_name;
						$stripe_array['id']= $p_name;
						$stripe_array['amount']=$form_data['package_recurring_cost_initial'] * 100;
						$stripe_array['interval']=sanitize_text_field($form_data['package_recurring_cycle_type']);
						$stripe_array['interval_count']=$interval_count;
						$stripe_array['currency']=$stripe_currency;
						$stripe_array['product']=array('name' => $p_name);
						$trial=get_post_meta($newpost_id, 'ep_fitness_package_enable_trial_period', true);
						if($trial=='yes'){
							$trial_type = get_post_meta( $newpost_id,'ep_fitness_package_recurring_trial_type',true);
							$trial_cycle_count =get_post_meta($newpost_id, 'ep_fitness_package_trial_period_interval', true);
							switch ($trial_type) {
								case 'year':
								$periodNum =  365 * 1;
								break;
								case 'month':
								$periodNum =  30 * $trial_cycle_count;
								break;
								case 'week':
								$periodNum = 7 * $trial_cycle_count;
								break;
								case 'day':
								$periodNum = 1 * $trial_cycle_count;
								break;
							}
							$stripe_array['trial_period_days']=$periodNum;
						}
						try {
							$p = \Stripe\Plan::retrieve($p_name);							
						} catch (Exception $e) {
								$api_error = $e->getMessage();
						}
						if(empty($api_error)){
							$p->delete();
						}
						try {
							\Stripe\Plan::create($stripe_array);
						} catch (Exception $e) {
								print_r($e);
						}
					}
				}
				// End Stripe Plan Create*****
				update_post_meta($newpost_id, 'ep_fitness_package_category_ids', $cat_ids);
				echo json_encode(array('code' => 'success'));
				exit(0);
			}
			public function ep_fitness_update_paypal_settings() {
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'settings' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				
				parse_str($_POST['form_data'], $form_data);
				$post_content="";
				global $wpdb;
				$post_name='ep_fitness_paypal_setting';
				$row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_name = '%s' ",$post_name));
				if(!isset($row->ID )){
					$my_post_form = array('post_title' => wp_strip_all_tags($post_name), 'post_name' => wp_strip_all_tags($post_name), 'post_content' => 'Paypal Setting', 'post_status' => 'draft', 'post_author' => get_current_user_id(),);
					$newpost_id = wp_insert_post($my_post_form);
					$post_type = 'iv_payment_setting';
					$query = $wpdb->prepare("UPDATE {$wpdb->prefix}posts SET post_type='%s' WHERE id='%s' LIMIT 1",$post_type,$newpost_id  );
					$wpdb->query($query);
					}else{
					$newpost_id= $row->ID;
				}
			
				update_post_meta($newpost_id, 'ep_fitness_paypal_mode', sanitize_text_field($form_data['paypal_mode']));
					
				update_post_meta($newpost_id, 'ep_fitness_paypal_username', sanitize_text_field($form_data['paypal_username']));
				
				update_post_meta($newpost_id, 'ep_fitness_paypal_api_password', sanitize_text_field($form_data['paypal_api_password'])); 
				update_post_meta($newpost_id, 'ep_fitness_paypal_api_signature', sanitize_text_field($form_data['paypal_api_signature'])); 
				update_post_meta($newpost_id, 'ep_fitness_paypal_api_currency', sanitize_text_field($form_data['paypal_api_currency']));
				
				update_option('_ep_fitness_api_currency', sanitize_text_field($form_data['paypal_api_currency'] ));
				
				echo json_encode(array('code' => 'success'));
				exit(0);
			}
			public function ep_fitness_update_stripe_settings() {
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'settings' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				parse_str($_POST['form_data'], $form_data);
				$post_content="";
				global $wpdb;
				$post_name='ep_fitness_stripe_setting';
				$row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_name = '%s' ",$post_name ));
				if(!isset($row->ID )){
					$my_post_form = array('post_title' => wp_strip_all_tags($post_name), 'post_name' => wp_strip_all_tags($post_name), 'post_content' => 'stripe Setting', 'post_status' => 'draft', 'post_author' => get_current_user_id(),);
					$newpost_id = wp_insert_post($my_post_form);
					$post_type = 'iv_payment_setting';
					$query = $wpdb->prepare("UPDATE {$wpdb->prefix}posts SET post_type='%s' WHERE id='%s' LIMIT 1",$post_type, $newpost_id);
					$wpdb->query($query);
					}else{
					$newpost_id= $row->ID;
				}
				update_post_meta($newpost_id, 'ep_fitness_stripe_mode', sanitize_text_field($form_data['stripe_mode']));
				update_post_meta($newpost_id, 'ep_fitness_stripe_live_secret_key', sanitize_text_field($form_data['secret_key']));
				update_post_meta($newpost_id, 'ep_fitness_stripe_live_publishable_key', sanitize_text_field($form_data['publishable_key']));
				update_post_meta($newpost_id, 'ep_fitness_stripe_secret_test', sanitize_text_field($form_data['secret_key_test']));
				update_post_meta($newpost_id, 'ep_fitness_stripe_publishable_test', sanitize_text_field($form_data['stripe_publishable_test']));
				update_post_meta($newpost_id, 'ep_fitness_stripe_api_currency', sanitize_text_field($form_data['stripe_api_currency']));
				update_option('_ep_fitness_api_currency', sanitize_text_field($form_data['stripe_api_currency'] ));
				echo json_encode(array('code' => 'success'));
				exit(0);
			}
			public function ep_fitness_create_coupon() {
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'coupon' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				parse_str($_POST['form_data'], $form_data);
				$post_content="";
				global $wpdb;
				$post_name=sanitize_text_field($form_data['coupon_name']);
				$coupon_data = array('post_title' => wp_strip_all_tags($post_name), 'post_name' => wp_strip_all_tags($post_name), 'post_content' => $post_name, 'post_status' => 'draft', 'post_author' => get_current_user_id(),);
				$newpost_id = wp_insert_post($coupon_data);
				$post_type = 'iv_coupon';
				$query =$wpdb->prepare( "UPDATE {$wpdb->prefix}posts SET post_type='%s' WHERE id='%s' LIMIT 1",$post_type, $newpost_id );
				$wpdb->query($query);
				if($form_data['coupon_count']==""){
					$coupon_limit='99999';
					}else{
					$coupon_limit=sanitize_text_field($form_data['coupon_count']);
				}
				$pac='';
				if(isset($_POST['form_pac_ids'])){$pac=$_POST['form_pac_ids'];}
				$pck_ids =implode(",",$pac);
				update_post_meta($newpost_id, 'iv_coupon_pac_id', $pck_ids);
				update_post_meta($newpost_id, 'iv_coupon_limit',$coupon_limit);
				update_post_meta($newpost_id, 'iv_coupon_start_date', sanitize_text_field($form_data['start_date']));
				update_post_meta($newpost_id, 'iv_coupon_end_date', sanitize_text_field($form_data['end_date']));
				update_post_meta($newpost_id, 'iv_coupon_amount', sanitize_text_field($form_data['coupon_amount']));
				update_post_meta($newpost_id, 'iv_coupon_type', sanitize_text_field($form_data['coupon_type']));
				echo json_encode(array('code' => 'success'));
				exit(0);
			}
			public function ep_fitness_update_coupon() {
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'coupon' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				parse_str($_POST['form_data'], $form_data);
				$post_content="";
				global $wpdb;
				$post_title=sanitize_text_field($form_data['coupon_name']);
				$post_id=sanitize_text_field($form_data['coupon_id']);
				$newpost_id=$post_id;
				$post_type = 'ep_fitness_pack';
				$query = $wpdb->prepare("UPDATE {$wpdb->prefix}posts SET post_title='%s' WHERE id='%s' LIMIT 1",$post_title, $post_id );
				$wpdb->query($query);
				$pck_ids =implode(",",$_POST['form_pac_ids']);
				update_post_meta($newpost_id, 'iv_coupon_pac_id', $pck_ids);
				update_post_meta($newpost_id, 'iv_coupon_limit', sanitize_text_field($form_data['coupon_count']));
				update_post_meta($newpost_id, 'iv_coupon_start_date', sanitize_text_field($form_data['start_date']));
				update_post_meta($newpost_id, 'iv_coupon_end_date', sanitize_text_field($form_data['end_date']));
				update_post_meta($newpost_id, 'iv_coupon_amount', sanitize_text_field($form_data['coupon_amount']));
				update_post_meta($newpost_id, 'iv_coupon_type', sanitize_text_field($form_data['coupon_type']));
				echo json_encode(array('code' => 'success'));
				exit(0);
			}
			public function ep_fitness_save_settings() {
				$nonce = $_POST['security'];
				if (!wp_verify_nonce($nonce, 'ep_fitness_save_settings')) {
					echo json_encode(array("code" => "error", "message" => "Unathorized Attempt"));
					} else {
					foreach ($_POST['settings'] as $key => $value) {
						update_option($key, $value);
					}
					echo json_encode(array("code" => "success", "message" => "Settings Saved"));
				}
				exit(0);
			}
			public function  ep_fitness_update_payment_setting(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'settings' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				parse_str($_POST['form_data'], $form_data);
				$iv_terms='no';
				if(isset($form_data['iv_terms'])){
					$iv_terms=sanitize_text_field($form_data['iv_terms']);
				}
				$terms_detail=$form_data['terms_detail'];
				$iv_coupon='';
				if(isset($form_data['iv_coupon'])){
					$iv_coupon=sanitize_text_field($form_data['iv_coupon']);
				}
				update_option('ep_fitness_payment_terms_text', $terms_detail );
				update_option('ep_fitness_payment_terms', $iv_terms );
				update_option('_ep_fitness_payment_coupon', $iv_coupon );
				echo json_encode(array("code" => "success","msg"=>"Updated Successfully"));
				exit(0);
			}
			public function ep_fitness_update_account_setting(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'settings' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				parse_str($_POST['form_data'], $form_data);
				$post_approved='no';
				
				$signup_redirect=sanitize_text_field($form_data['signup_redirect']);
				$private_profile_page  = sanitize_text_field($form_data['pri_profile_redirect']);
				$pub_profile_redirect=	sanitize_text_field($form_data['profile_redirect']);
				if(isset($form_data['hide_admin_bar'])){
					$admin_bar=sanitize_text_field($form_data['hide_admin_bar']);
					}else{
					$admin_bar='no';
				}
				
				update_option('ep_fitness_signup_redirect', $signup_redirect );
				update_option('_ep_fitness_profile_page', $private_profile_page );
				update_option('_ep_fitness_profile_public_page', $pub_profile_redirect );
				update_option('_ep_fitness_hide_admin_bar', $admin_bar );
				echo json_encode(array("code" => "success","msg"=>"Updated Successfully"));
				exit(0);
			}
			
			public function  ep_fitness_update_page_setting(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'settings' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				parse_str($_POST['form_data'], $form_data);
				$iv_terms='no';
				if(isset($form_data['iv_terms'])){
					$iv_terms=$form_data['iv_terms'];
				}
				$pricing_page=sanitize_text_field($form_data['pricing_page']);
				$signup_page=sanitize_text_field($form_data['signup_page']);
				$profile_page=sanitize_text_field($form_data['profile_page']);
				$profile_public=sanitize_text_field($form_data['profile_public']);
				$thank_you=sanitize_text_field($form_data['thank_you_page']);
				$login=$form_data['login_page'];
				update_option('_ep_fitness_price_table', $pricing_page);
				update_option('_ep_fitness_registration', $signup_page);
				update_option('_ep_fitness_profile_page', $profile_page);
				update_option('_ep_fitness_profile_public_page',$profile_public);
				update_option('_ep_fitness_thank_you_page',$thank_you);
				update_option('_ep_fitness_login_page',$login);
				echo json_encode(array("code" => "success","msg"=>"Updated Successfully"));
				exit(0);
			}
			public function ep_fitness_update_email_setting(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'settings' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				parse_str($_POST['form_data'], $form_data);
				$signup_form_id=$form_data['signup_form_id'];
				update_option( 'ep_fitness_signup_email_subject',sanitize_text_field($form_data['ep_fitness_signup_email_subject']));
				update_option( 'ep_fitness_signup_email',$form_data['signup_email_template']);
				update_option( 'ep_fitness_forget_email_subject',sanitize_text_field($form_data['forget_email_subject']));
				update_option( 'ep_fitness_forget_email',$form_data['forget_email_template']);
				update_option('admin_email_ep_fitness', $form_data['ep_fitness_admin_email']);
				update_option('ep_fitness_order_client_email_sub', sanitize_text_field($form_data['ep_fitness_order_email_subject']));
				update_option('ep_fitness_order_client_email', $form_data['order_client_email_template']);
				update_option('ep_fitness_order_admin_email_sub', sanitize_text_field($form_data['ep_fitness_order_admin_email_subject']));
				update_option('ep_fitness_order_admin_email', $form_data['order_admin_email_template']);
				update_option( 'ep_fitness_reminder_email_subject',sanitize_text_field($form_data['ep_fitness_reminder_email_subject']));
				update_option( 'ep_fitness_reminder_email',$form_data['reminder_email_template']);
				update_option('ep_fitness_reminder_day', sanitize_text_field($form_data['ep_fitness_reminder_day']));
				update_option( 'ep_fitness_contact_email_subject',sanitize_text_field($form_data['contact_email_subject']));
				update_option( 'ep_fitness_contact_email',$form_data['message_email_template']);
				$bcc_message=(isset($form_data['bcc_message'])? sanitize_text_field($form_data['bcc_message']):'' );
				update_option( '_ep_fitness_bcc_message',$bcc_message);
				update_option( 'ep_fitness_refund_email_subject',sanitize_text_field($form_data['refund_email_subject']));
				update_option( 'ep_fitness_refund_email',$form_data['ep_fitness_refund_email']);
				$refund_message_link=(isset($form_data['refund_message_link'])? sanitize_text_field($form_data['refund_message_link']):'' );
				update_option( '_ep_fitness_refund_message_link',$refund_message_link);
				echo json_encode(array("code" => "success","msg"=>"Updated Successfully"));
				exit(0);
			}
			public function ep_fitness_update_mailchamp_setting (){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'settings' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				parse_str($_POST['form_data'], $form_data);
				update_option('ep_fitness_mailchimp_api_key', sanitize_text_field($form_data['ep_fitness_mailchimp_api_key']));
				update_option('ep_fitness_mailchimp_confirmation', sanitize_text_field($form_data['ep_fitness_mailchimp_confirmation']));
				if(isset($form_data['ep_fitness_mailchimp_list'])){
					update_option('ep_fitness_mailchimp_list', sanitize_text_field($form_data['ep_fitness_mailchimp_list']));
				}
				echo json_encode(array("code" => "success","msg"=>"Updated Successfully"));
				exit(0);
			}
			public function ep_fitness_update_package_status (){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'settings' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				global $wpdb;
				$package_id_update=sanitize_text_field(trim($_POST['status_id']));
				$package_current_status=trim($_POST['status_current']);
				if($package_current_status=="pending"){
					$package_st='draft';
					$pac_msg='Active';
					}else{
					$package_st='pending';
					$pac_msg='Inactive';
				}
				$post_type = 'ep_fitness_pack';
				$query = $wpdb->prepare("UPDATE {$wpdb->prefix}posts SET post_status='%s' WHERE ID='%s' LIMIT 1",$package_st,$package_id_update );
				$wpdb->query($query);
				echo json_encode(array("code" => "success","msg"=>$pac_msg,"current_st"=>$package_st));
				exit(0);
			}
			public function ep_fitness_email_admin_template_change() {
				$ep_fitness_template = $_POST['ep_fitness_template'];
				$settings = array('textarea_rows' => 20,);
				$content_admin = get_option('ep_fitness_admin_email_'.$ep_fitness_template );
				echo esc_html($content_admin);
				exit(0);
			}
			public function ep_fitness_gateway_settings_update(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'settings' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				$payment_gateway = sanitize_text_field($_POST['payment_gateway']);
				global $wpdb;
				update_option('ep_fitness_payment_gateway', $payment_gateway);
				// For Stripe Plan Create*****
				$iv_gateway = get_option('ep_fitness_payment_gateway');
				if($iv_gateway=='stripe'){
					$stripe_id='';
					$post_name2='ep_fitness_stripe_setting';
					$row2 = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_name = '%s' ",$post_name2));
					if(isset($row2->ID)){
						$stripe_id= $row2->ID;
					}
					$ep_fitness_pack='ep_fitness_pack';
					$sql=$wpdb->prepare( "SELECT * FROM $wpdb->posts WHERE post_type = '%s'", $ep_fitness_pack);
					$membership_pack = $wpdb->get_results($sql);
					if(sizeof($membership_pack)>0){
						$i=0;
						include(wp_ep_fitness_DIR . '/admin/files/init.php');
						$stripe_mode=get_post_meta( $stripe_id,'ep_fitness_stripe_mode',true);
						if($stripe_mode=='test'){
							$stripe_api =get_post_meta($stripe_id, 'ep_fitness_stripe_secret_test',true);
							}else{
							$stripe_api =get_post_meta($stripe_id, 'ep_fitness_stripe_live_secret_key',true);
						}
						$stripe_currency =get_post_meta($stripe_id, 'ep_fitness_stripe_api_currency',true);
						\Stripe\Stripe::setApiKey($stripe_api);
						foreach ( $membership_pack as $row )
						{		$package_recurring=get_post_meta( $row->ID,'ep_fitness_package_recurring',true);
							if($package_recurring=='on'){
								$interval_count= get_post_meta( $row->ID,'ep_fitness_package_recurring_cycle_count',true);
								$interval_count= ($interval_count=="" ? '1':$interval_count);
								$stripe_array=array();
								$p_name = $row->post_name;
								$stripe_array['id']= $p_name;
								$stripe_array['amount']=get_post_meta( $row->ID,'ep_fitness_package_recurring_cost_initial',true) * 100;
								$stripe_array['interval']=get_post_meta( $row->ID,'ep_fitness_package_recurring_cycle_type',true);
								$stripe_array['interval_count']=$interval_count;
								$stripe_array['currency']=$stripe_currency;
								$stripe_array['product']=array('name' => $p_name);
								$trial=get_post_meta($row->ID, 'ep_fitness_package_enable_trial_period', true);
								if($trial=='yes'){
									$trial_type = get_post_meta( $row->ID,'ep_fitness_package_recurring_trial_type',true);
									$trial_cycle_count =get_post_meta($row->ID, 'ep_fitness_package_trial_period_interval', true);
									switch ($trial_type) {
										case 'year':
										$periodNum =  365 * 1;
										break;
										case 'month':
										$periodNum =  30 * $trial_cycle_count;
										break;
										case 'week':
										$periodNum = 7 * $trial_cycle_count;
										break;
										case 'day':
										$periodNum = 1 * $trial_cycle_count;
										break;
									}
									$stripe_array['trial_period_days']=$periodNum;
								}
								try {
									\Stripe\Plan::retrieve($p_name);
									} catch (Exception $e) {
									if($stripe_array['amount']>0){
										\Stripe\Plan::create($stripe_array);
									}
								}
							}
						}
					}
				}
				// End Stripe Plan Create*****
				echo json_encode(array("code" => "success","msg"=>"Updated Successfully: Your current gateway is ".$payment_gateway));
				exit(0);
			}
			public function ep_fitness_update_user_settings(){
				if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'settings' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				global $wpdb;
				parse_str($_POST['form_data'], $form_data);
				$user_id=sanitize_text_field($form_data['user_id']);
				$user_id=sanitize_text_field($form_data['user_id']);
				if($form_data['exp_date']!=''){
					$exp_d=date('Y-m-d', strtotime(sanitize_text_field($form_data['exp_date'])));
					update_user_meta($user_id, 'ep_fitness_exprie_date',$exp_d);
				}
				update_user_meta($user_id, 'ep_fitness_payment_status', sanitize_text_field($form_data['payment_status']));
				update_user_meta($user_id, 'iv_user_content_setting', sanitize_text_field($form_data['content_setting']));
				update_user_meta($user_id, 'ep_fitness_package_id',sanitize_text_field($form_data['package_sel']));
				$user = new WP_User( $user_id );
				$user->set_role(sanitize_text_field($form_data['user_role']));
				echo json_encode(array("code" => "success","msg"=>esc_html__( 'Updated Successfully', 'epfitness' )));
				exit(0);
			}
			public function ep_fitness_settings_save() {
				$sucess_message = $_POST['sucess_message'];
				$auto_reply = $_POST['auto_reply'];
				$fail_message = $_POST['fail_message'];
				$ep_fitness_admin_email_subject = $_POST['ep_fitness_admin_email_subject'];
				$ep_fitness_auto_email_subject = $_POST['ep_fitness_auto_email_subject'];
				update_option('ep_fitness_success_message', $sucess_message);
				update_option('ep_fitness_auto_reply', $auto_reply);
				update_option('ep_fitness_fail_message', $fail_message);
				echo json_encode(array("code" => "success","msg"=>"Updated Successfully"));
				exit(0);
			}
		}
	}
$wp_ep_fitness_admin = new wp_ep_fitness_Admin();