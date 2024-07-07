<?php
	wp_enqueue_style('wp-ep_fitness-style-2', wp_ep_fitness_URLPATH . 'admin/files/css/iv-bootstrap.css');
?>
<div class="bootstrap-wrapper">
 	<div class="dashboard-eplugin container-fluid">
 		<?php
			global $wpdb, $post;
			// Save action   ep_fitness_meta_save
			//*************************	plugin file *********
			$set_package='';
			$ep_fitness_current_author= $post->post_author;
			$current_user = wp_get_current_user();
			$userId=$current_user->ID;
			if(isset($current_user->roles[0]) and $current_user->roles[0]=='administrator'){
			?>
			<div class="row">			
				<div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-4">
					<label>
						<?php
							$post_for1='role';
							if(get_post_meta( $post->ID,'_ep_post_for', true )=='role'){
								$post_for1='checked';
							}
							if(get_post_meta( $post->ID,'_ep_post_for', true )==''){
								$post_for1='checked';
							}
						?>
						<input type="radio" name="post_for_radio" id="post_for_radio" value="role" <?php echo esc_html($post_for1);?>> <?php esc_html_e('Only for the user role','epfitness');?>
					</label>
				</div>
				<div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-4">
					<label>
						<?php
							$post_for2='';
							if(get_post_meta( $post->ID,'_ep_post_for', true )=='user'){
								$post_for2='checked';
							}
						?>
						<input type="radio" name="post_for_radio" id="post_for_radio" value="user" <?php echo esc_html($post_for2);?>> <?php esc_html_e('Only specific users','epfitness');?>
					</label>
				</div>
				<div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-4">
					<label>
						<?php
							$post_for3='';
							if(get_post_meta( $post->ID,'_ep_post_for', true )=='Woocommerce'){
								$post_for3='checked';
							}
						?>
						<input type="radio" name="post_for_radio" id="post_for_radio" value="Woocommerce" <?php echo esc_html($post_for3);?>> <?php esc_html_e('Woocommerce Products','epfitness');?>
					</label>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="row" id="package_div"  <?php echo ($post_for1=='checked'?'':'style="display: none;"' );?>  <?php echo ($post_for1=='checked'?'':'class="dnone"' );?>>
			  <div class="form-group col-xs-12 col-sm-12 col-md-8 col-lg-8">
					<?php
						
						$save_ep_postfor_package= get_post_meta( $post->ID,'_ep_postfor_package', true );
						if($save_ep_postfor_package==''){$save_ep_postfor_package= array();}
						$i=0;
					?>
					<select multiple size="15" class="form-control" id="specific_package[]" name="specific_package[]">
						<?php
							global $wp_roles;
							foreach ( $wp_roles->roles as $key=>$value ){
								$selected='';
								if (in_array($key, $save_ep_postfor_package)) {
									$selected='selected';
								}
							?>
							<option value="<?php echo esc_html($key); ?>" <?php echo esc_html($selected); ?>><?php echo esc_html($value['name']); ?></option>
							<?php
							}
						?>
					</select>
				</div>
			</div>
			<div class="row" id="user_div"  <?php echo ($post_for2=='checked'?'':'style="display: none;"' );?> <?php echo ($post_for2=='checked'?'':'class="dnone"' );?>>
				<div class="form-group col-xs-12 col-sm-12 col-md-8 col-lg-8">
					<?php esc_html_e( 'Select your specific users :', 'epfitness' );?>
					<select multiple size="20" class="form-control" id="specific_users[]" name="specific_users[]">
						<?php
							$sql="SELECT * FROM $wpdb->users ";
							$user_rows = $wpdb->get_results($sql);
							$save_ep_users=array();
							if(get_post_meta( $post->ID,'_ep_postfor_user', true )!=''){
								$save_ep_users=get_post_meta( $post->ID,'_ep_postfor_user', true );
							}
							if(sizeof($user_rows)>0){
								foreach ( $user_rows as $row )
								{	$selected='';
									if (in_array($row->ID, $save_ep_users)) {
										$selected='selected';
									}
									echo '<option value="'.$row->ID.'"'.$selected.' >'.$row->ID.': '.$row->display_name.' - '.$row->user_email.' </option>';
								}
							}
						?>
					</select>
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="row" id="Woocommerce" <?php echo ($post_for3=='checked'?'':'style="display: none;"' );?> <?php echo ($post_for3=='checked'?'':'class="dnone"' );?>>
				<div class="form-group col-xs-12 col-sm-12 col-md-8 col-lg-8">
					<?php esc_html_e( 'Select Products, The product buyer will get the content access :', 'epfitness' );
						$post_4_woo_array=array();
						if(get_post_meta( $post->ID,'_ep_postfor_woocommerce', true )!=''){
							$post_4_woo_array=get_post_meta( $post->ID,'_ep_postfor_woocommerce', true );
						}
					?>
					<select multiple size="20" class="form-control" id="Woocommerce_products[]" name="Woocommerce_products[]">
						<?php
							$product='product';
							$sql=$wpdb->prepare( "SELECT * FROM $wpdb->posts where post_type='%s' ", $product);
							$product_rows = $wpdb->get_results($sql);
							if(sizeof($product_rows)>0){
								foreach ( $product_rows as $row )
								{	$selected='';
									if (in_array($row->ID, $post_4_woo_array)) {
										$selected='selected';
									}
									echo '<option value="'.$row->ID.'"'.$selected.' >'.$row->post_title.' </option>';
								}
							}
						?>
					</select>
				</div>
			</div>
			<div class="clearfix"></div>
			<hr>
			<div class="row" id="daynumber_div"  >
				<div class="form-group col-xs-12 col-sm-12 col-md-8 col-lg-8">
					<label> <?php esc_html_e('Post for the Day','epfitness');?>  </label>
					<textarea class="form-control" name="day_number" id="day_number"  placeholder="<?php esc_html_e('Enter day number  e.g. 1,2,5,8 (If you select calendar view from custom post type setting then day number is required)','epfitness');  ?>"><?php echo get_post_meta( $post->ID,'_ep_user_day_number', true );?></textarea>
				</div>
			</div>
			<hr>
			<?php esc_html_e(' Note : You can get more content restriction setting for a specific  user,  ', 'epfitness'); ?><b> <a href="<?php echo esc_url(get_admin_url()); ?>admin.php?page=wp-iv_user-directory-admin"><?php esc_html_e('Here','epfitness');  ?> </a>  </b><br/>
			<img width="300px" src="<?php echo wp_ep_fitness_URLPATH. "assets/images/user-setting.png";?>">
			<?php
			}
		?>
 		<br/>
	</div>
	<input type="hidden" name="listing_data_submit" id="listing_data_submit" value="yes">
</div>
<?php
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
?>