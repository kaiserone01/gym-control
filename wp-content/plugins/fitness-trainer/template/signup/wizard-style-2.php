<?php
	global $wpdb;
	wp_enqueue_style('wp-ep_fitness-style-signup-11', wp_ep_fitness_URLPATH . 'admin/files/css/iv-bootstrap.css');
	wp_enqueue_style('profile-registration-style', wp_ep_fitness_URLPATH. 'admin/files/css/profile-registration.css');
	wp_enqueue_script('ep_fitness-script-signup-12', wp_ep_fitness_URLPATH . 'admin/files/js/bootstrap.min.js');
	wp_enqueue_style('front-end', wp_ep_fitness_URLPATH . 'admin/files/css/front-end.css');
	
	require(wp_ep_fitness_DIR .'/admin/files/css/color_style.php');
	$api_currency= 'USD';
	if( get_option('_ep_fitness_api_currency' )!=FALSE ) {
		$api_currency= get_option('_ep_fitness_api_currency' );
	}
	if($api_currency==''){$api_currency= 'USD';}
	if(isset($_REQUEST['payment_gateway'])){
		$payment_gateway=$_REQUEST['payment_gateway'];
	}
	$iv_gateway='paypal-express';
	if( get_option( 'ep_fitness_payment_gateway' )!=FALSE ) {
		$iv_gateway = get_option('ep_fitness_payment_gateway');
		if($iv_gateway=='paypal-express'){
			$post_name='ep_fitness_paypal_setting';
			$row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_name = '%s' ",$post_name ));
			$paypal_id='0';
			if(isset($row->ID)){
				$paypal_id= $row->ID;
			}
			$api_currency=get_post_meta($paypal_id, 'ep_fitness_paypal_api_currency', true);
		}
	}
	$package_id='0';
	if(isset($_REQUEST['package_id'])){
		$package_id=$_REQUEST['package_id'];
		$recurring= get_post_meta($package_id, 'ep_fitness_package_recurring', true);
		if($recurring == 'on'){
			$package_amount=get_post_meta($package_id, 'ep_fitness_package_recurring_cost_initial', true);
			}else{
			$package_amount=get_post_meta($package_id, 'ep_fitness_package_cost',true);
		}
		if($package_amount=='' || $package_amount=='0' ){$iv_gateway='paypal-express';}
	}
	$form_meta_data= get_post_meta( $package_id,'ep_fitness_content',true);
	$row = $wpdb->get_row($wpdb->prepare( "SELECT * FROM $wpdb->posts WHERE id = '%s' ", $package_id));
	$package_name='';
	$package_amount='';
	if(isset($row->post_title)){
		$package_name=$row->post_title;
		$count =get_post_meta($package_id, 'ep_fitness_package_recurring_cycle_count', true);
		$package_name=$package_name;
		$package_amount=get_post_meta($package_id, 'ep_fitness_package_cost',true);
	}
	$newpost_id='';
	$post_name='ep_fitness_stripe_setting';
	$row = $wpdb->get_row($wpdb->prepare( "SELECT * FROM $wpdb->posts WHERE post_name = '%s' ",$post_name ));
	if(isset($row->ID)){
		$newpost_id= $row->ID;
	}
	$stripe_mode=get_post_meta( $newpost_id,'ep_fitness_stripe_mode',true);
	if($stripe_mode=='test'){
		$stripe_publishable =get_post_meta($newpost_id, 'ep_fitness_stripe_publishable_test',true);
		}else{
		$stripe_publishable =get_post_meta($newpost_id, 'ep_fitness_stripe_live_publishable_key',true);
	}
?>
<div class=" bootstrap-wrapper">
		<?php
			if($iv_gateway=='paypal-express'){
			?>
			<form id="ep_fitness_registration" name="ep_fitness_registration" class="form-horizontal" action="<?php  the_permalink() ?>?package_id=<?php echo esc_html($package_id); ?>&payment_gateway=paypal&iv-submit-listing=register" method="post" role="form">
			<?php
			}
			if($iv_gateway=='stripe'){?>
				<form id="ep_fitness_registration" name="ep_fitness_registration" class="form-horizontal" action="<?php  the_permalink() ?>?&package_id=<?php echo esc_html($package_id); ?>&payment_gateway=stripe&iv-submit-stripe=register" method="post" role="form">
				<input type="hidden" name="payment_gateway" id="payment_gateway" value="stripe">
				<input type="hidden" name="iv-submit-stripe" id="iv-submit-stripe" value="register">
				<?php
				}
				if($iv_gateway=='woocommerce'){
				?>
				<form id="ep_fitness_registration" name="ep_fitness_registration" class="form-horizontal" action="<?php  the_permalink() ?>?package_id=<?php echo esc_html($package_id); ?>&payment_gateway=woocommerce&iv-submit-listing=register" method="post" role="form">
					<?php
					}
					if($iv_gateway=='stripe'){?>
					<form id="ep_fitness_registration" name="ep_fitness_registration" class="form-horizontal" action="<?php  the_permalink() ?>?&package_id=<?php echo esc_html($package_id); ?>&payment_gateway=stripe&iv-submit-stripe=register" method="post" role="form">
						<input type="hidden" name="payment_gateway" id="payment_gateway" value="stripe">
						<input type="hidden" name="iv-submit-stripe" id="iv-submit-stripe" value="register">
						<?php
						}
					?>
					<div class="content form-content">
									<div class="form-group"  >
											<div  class="col-md-3 control-label">
											</div>
											<label  class="col-md-9 ">
												<h3  class="form-title">
													<?php  esc_html_e('User Information','epfitness');?>
												</h3>
												</label>
									</div>		
									<?php
										if(isset($_REQUEST['message-error'])){?>
										<div class="row alert alert-info alert-dismissable" id='loading-2'><a class="panel-close close" data-dismiss="alert">x</a> <?php  echo sanitize_text_field($_REQUEST['message-error']); ?></div>
										<?php
										}
									?>	
									<div id="selected-column-1" class=" ">
										<div class="text-center" id="loading"> </div>
										<div class="form-group row"  >
											<label  class="col-md-3 control-label"><?php  esc_html_e('User Name','epfitness');?><span class="chili"></span></label>
											<div class="col-md-9">
												<input type="text"  class="form-control-solid" name="iv_member_user_name"  data-validation="length alphanumeric"
												data-validation-length="4-12" data-validation-error-msg="<?php  esc_html_e(' The user name has to be an alphanumeric value between 4-12 characters','epfitness');?>" class="form-control ctrl-textbox" placeholder="<?php  esc_html_e('Enter User Name','epfitness');?>"  >
											</div>
										</div>
										<div class="form-group row">
											<label  class="col-md-3 control-label" ><?php  esc_html_e('Email Address','epfitness');?><span class="chili"></span></label>
											<div class="col-md-9">
												<input type="email" class="form-control-solid" name="iv_member_email" data-validation="email"  class="form-control ctrl-textbox" placeholder="<?php  esc_html_e('Enter email address','epfitness');?>" data-validation-error-msg="<?php  esc_html_e('Please enter a valid email address','epfitness');?> " >
											</div>
										</div>
										<div class="form-group row ">
											<label  class="col-md-3 control-label"><?php  esc_html_e('Password','epfitness');?><span class="chili"></span></label>
											<div class="col-md-9">
												<input type="password" class="form-control-solid" name="iv_member_password"  class="form-control ctrl-textbox" data-validation-error-msg="<?php  esc_html_e(' The password is not strong enough','epfitness');?>" data-validation="strength"
												data-validation-strength="2">
												<?php wp_nonce_field( 'signup' ); ?>
											</div>
										</div>
										<?php
											$i=1;
											$default_fields = array();
											$default_fields=get_option('ep_fitness_profile_fields');
											$sign_up_array=get_option( 'ep_fitness_signup_fields');
											$require_array=get_option( 'ep_fitness_signup_require');
											if(is_array($default_fields)){
												foreach ( $default_fields as $field_key => $field_value ) {
													$sign_up='no';
													if(isset($sign_up_array[$field_key]) && $sign_up_array[$field_key] == 'yes') {
														$sign_up='yes';
													}
													$require='no';
													if(isset($require_array[$field_key]) && $require_array[$field_key] == 'yes') {
														$require='yes';
													}
													if($sign_up=='yes'){
													?>
													<div class="form-group row">
														<label  class="col-md-3 control-label" ><?php echo esc_html($field_value); ?><span class="<?php echo($require=='yes'?'chili':''); ?>"></span></label>
														<div class="col-md-9">
															<input type="text" class="form-control-solid" name="<?php echo esc_html($field_key);?>" <?php echo($require=='yes'?'data-validation="length" data-validation-length="2-100"':''); ?>
															class="form-control ctrl-textbox" placeholder="<?php echo 'Enter '.esc_html($field_value);?>" >
														</div>
													</div>
													<?php
													}
												}
											}
											$ep_fitness_pack='ep_fitness_pack';
											$sql=$wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_type = '%s'  and post_status='draft' ",$ep_fitness_pack );
											$membership_pack = $wpdb->get_results($sql);
											$total_package = count($membership_pack);
											if(sizeof($membership_pack)<1){ ?>
											<input type="hidden" name="reg_error" id="reg_error" value="yes">
											<input type="hidden" name="package_id" id="package_id" value="0">
											<input type="hidden" name="return_page" id="return_page" value="<?php  the_permalink() ?>">
											<div class="row">
												<div class="col-md-3">
												</div>
												<div class="col-md-9 ">
													<div id="paypal-button" class="margin-top-20">
														<div id="loading-3"><img src='<?php echo wp_ep_fitness_URLPATH. 'admin/files/images/loader.gif'; ?>' /></div>
														<button  id="submit_ep_fitness_payment" name="submit_ep_fitness_payment"  type="submit" class="btn-new btn-custom ctrl-btn"  > <?php  esc_html_e('Submit','epfitness');?></button>
													</div>
												</div>
											</div>
											<?php
											}
										?>
									</div>
									<input type="hidden" name="hidden_form_name" id="hidden_form_name" value="ep_fitness_registration">
							
					
					<?php
						if(sizeof($membership_pack)>0){
						?>	
								<div class="form-group"  >
												<div  class="col-md-3 control-label"> 
												</div>
											<label  class="col-md-9 ">
												<h3  class="form-title">
													<?php  esc_html_e('Payment Info','epfitness');?>
												</h3>
												</label>
									</div>
									<?php
										if($iv_gateway=='paypal-express'){
											include(wp_ep_fitness_template.'signup/paypal_form_2.php');
										}
										if($iv_gateway=='stripe'){
											include(wp_ep_fitness_template.'signup/iv_stripe_form_2.php');
										}
										if($iv_gateway=='woocommerce'){
											include(wp_ep_fitness_template.'signup/woocommerce.php');
										}
									?>
							
						<?php
						}
					?>
					</div>
				</form>			
			</div>
			<?php
				wp_enqueue_script("jquery");
				wp_enqueue_script('jquery.form-validator', wp_ep_fitness_URLPATH . 'admin/files/js/jquery.form-validator.js');
				wp_enqueue_script('fitness-script-30', wp_ep_fitness_URLPATH . 'admin/files/js/signup.js');
				wp_localize_script('fitness-script-30', 'epsignup_data', array(
				'ajaxurl' 			=> admin_url( 'admin-ajax.php' ),
				'loader_image'=>'<img src="'.wp_ep_fitness_URLPATH. 'admin/files/images/loader.gif" />',
				'loader_image2'=>'<img src="'.wp_ep_fitness_URLPATH. 'admin/files/images/old-loader.gif" />',
				'right_icon'=>'<img src="'.wp_ep_fitness_URLPATH. 'admin/files/images/right_icon.png" />',
				'wrong_16x16'=>'<img src="'.wp_ep_fitness_URLPATH. 'admin/files/images/wrong_16x16.png" />',
				'stripe_publishable'=>$stripe_publishable,
				'package_amount'=>$package_amount,
				'api_currency'=>$api_currency,
				'iv_gateway'=>$iv_gateway,
				'HideCoupon'=>esc_html__("Hide Coupon",'epfitness'),
				'Havecoupon'=>esc_html__("Have a coupon?",'epfitness'),
				'dirwpnonce'=> wp_create_nonce("signup"),
				'signup'=> wp_create_nonce("signup"),
				) );
			?>													