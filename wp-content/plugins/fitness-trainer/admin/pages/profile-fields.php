<?php
	global $wpdb;
	global $current_user;
	$ii=1;
?>
<div class="bootstrap-wrapper">
	<div class="dashboard-eplugin container-fluid">
		<div class="row">
			<div class="col-xs-12" id="submit-button-holder">
				<div class="pull-right"><button class="btn btn-info btn-lg" onclick="return update_profile_fields();"><?php esc_html_e('Update','epfitness');?> </button>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12"><h3 class="page-header"><?php esc_html_e('Update Profile Setting','epfitness');?> <br /><small> &nbsp;</small> </h3>
			</div>
		</div>
		<form id="profile_fields" name="profile_fields" class="form-horizontal" role="form" onsubmit="return false;">
			<div id="success_message">	</div>
			<div class="panel panel-success">
				<div class="panel-heading"><h4> <?php esc_html_e('My Account Menu','epfitness');?> </h4></div>
				<div class="panel-body">
					<div class="row ">
						<div class="col-sm-3 ">
							<h4><strong><?php esc_html_e('Menu Title / Label','epfitness');?> </strong> </h4>
						</div>
						<div class="col-sm-7">
							<h4><strong><?php esc_html_e('Link','epfitness');?> </strong></h4>
						</div>
						<div class="col-sm-2">
							<h4><strong><?php esc_html_e('Action','epfitness');?></strong> </h4>
						</div>
					</div>
					<?php
						$profile_page=get_option('_ep_fitness_profile_page');
						$page_link= get_permalink( $profile_page);
					?>
					<div class="row ">
						<div class="col-sm-3 ">
							<?php esc_html_e('Membership Level','epfitness');	 ?>
						</div>
						<div class="col-sm-7">
							<a href="<?php echo esc_url($page_link); ?>?&profile=level">
								<?php echo esc_url($page_link); ?>?&profile=level
							</a>
						</div>
						<div class="col-sm-2">
							<div class="checkbox ">
								<label><?php
									$account_menu_check='';
									if( get_option( '_ep_fitness_mylevel' ) ) {
										$account_menu_check= get_option('_ep_fitness_mylevel');
									}
								?>
								<input type="checkbox" name="mylevel" id="mylevel" value="yes" <?php echo ($account_menu_check=='yes'? 'checked':'' ); ?> > <?php esc_html_e( 'Hide', 'epfitness' );?>
								</label>
							</div>
						</div>
					</div>
					<div class="row ">
						<div class="col-sm-3 ">
							<?php esc_html_e('Account Settings','epfitness');?>
						</div>
						<div class="col-sm-7">
							<a href="<?php echo esc_url($page_link); ?>?&profile=setting">
								<?php echo esc_url($page_link); ?>?&profile=setting
							</a>
						</div>
						<div class="col-sm-2">
							<div class="checkbox ">
								<label><?php
									$account_menu_check='';
									if( get_option( '_ep_fitness_menusetting' ) ) {
										$account_menu_check= get_option('_ep_fitness_menusetting');
									}
								?>
								<input type="checkbox" name="menusetting" id="menusetting" value="yes" <?php echo ($account_menu_check=='yes'? 'checked':'' ); ?> > <?php esc_html_e( 'Hide', 'epfitness' );?>
								</label>
							</div>
						</div>
					</div>
					<div class="row ">
						<div class="col-sm-3 ">
							<?php esc_html_e('All Records','epfitness');?>
						</div>
						<div class="col-sm-7">
							<a href="<?php echo esc_url($page_link); ?>?&profile=setting">
								<?php echo esc_url($page_link); ?>?&profile=records
							</a>
						</div>
						<div class="col-sm-2">
							<div class="checkbox ">
								<label><?php
									$account_menu_check='';
									if( get_option( '_ep_fitness_menurecords' ) ) {
										$account_menu_check= get_option('_ep_fitness_menurecords');
									}
								?>
								<input type="checkbox" name="menurecords" id="menurecords" value="yes" <?php echo ($account_menu_check=='yes'? 'checked':'' ); ?> > <?php esc_html_e( 'Hide', 'epfitness' );?>
								</label>
							</div>
						</div>
					</div>
					<div class="row ">
						<div class="col-sm-3 ">
							<?php esc_html_e('Add Records','epfitness');?>
						</div>
						<div class="col-sm-7">
							<a href="<?php echo esc_url($page_link); ?>?&profile=setting">
								<?php echo esc_url($page_link); ?>?&profile=add-record
							</a>
						</div>
						<div class="col-sm-2">
							<div class="checkbox ">
								<label><?php
									$account_menu_check='';
									if( get_option( '_ep_fitness_menuadd-record' ) ) {
										$account_menu_check= get_option('_ep_fitness_menuadd-record');
									}
								?>
								<input type="checkbox" name="menuadd-record" id="menuadd-record" value="yes" <?php echo ($account_menu_check=='yes'? 'checked':'' ); ?> > <?php esc_html_e( 'Hide', 'epfitness' );?>
								</label>
							</div>
						</div>
					</div>
					<div class="row ">
						<div class="col-sm-3 ">
							<?php esc_html_e('Add Report','epfitness');?>
						</div>
						<div class="col-sm-7">
							<a href="<?php echo esc_url($page_link); ?>?&profile=setting">
								<?php echo esc_url($page_link); ?>?&profile=add-report
							</a>
						</div>
						<div class="col-sm-2">
							<div class="checkbox ">
								<label><?php
									$account_menu_check='';
									if( get_option( '_ep_fitness_menuadd-report' ) ) {
										$account_menu_check= get_option('_ep_fitness_menuadd-report');
									}
								?>
								<input type="checkbox" name="menuadd-report" id="menuadd-report" value="yes" <?php echo ($account_menu_check=='yes'? 'checked':'' ); ?> > <?php esc_html_e( 'Hide', 'epfitness' );?>
								</label>
							</div>
						</div>
					</div>
					<div class="row ">
						<div class="col-sm-3 ">
							<?php esc_html_e('My Report','epfitness');?>
						</div>
						<div class="col-sm-7">
							<a href="<?php echo esc_url($page_link); ?>?&profile=my-report">
								<?php echo esc_url($page_link); ?>?&profile=my-report
							</a>
						</div>
						<div class="col-sm-2">
							<div class="checkbox ">
								<label><?php
									$account_menu_check='';
									if( get_option( '_ep_fitness_menumy-report' ) ) {
										$account_menu_check= get_option('_ep_fitness_menumy-report');
									}
								?>
								<input type="checkbox" name="menumy-report" id="menumy-report" value="yes" <?php echo ($account_menu_check=='yes'? 'checked':'' ); ?> > <?php esc_html_e( 'Hide', 'epfitness' );?>
								</label>
							</div>
						</div>
					</div>
					<div id="custom_menu_div">
						<?php
							$old_custom_menu = array();
							if(get_option('ep_fitness_profile_menu')){
								$old_custom_menu=get_option('ep_fitness_profile_menu' );
							}
							$ii=1;
							if($old_custom_menu!=''){
								foreach ( $old_custom_menu as $field_key => $field_value ) {
								?>
								<div class="row form-group " id="menu_<?php echo esc_html($ii); ?>">
									<div class=" col-sm-3">
										<input type="text" class="form-control" name="menu_title[]" id="menu_title[]"  value="<?php echo esc_url($field_key); ?>" placeholder="<?php esc_html_e( 'Enter Menu Title', 'epfitness' );?>">
									</div>
									<div  class=" col-sm-7">
										<input type="text" class="form-control" name="menu_link[]" id="menu_link[]"  value="<?php echo esc_url($field_value); ?>" placeholder="<?php esc_html_e( 'Enter Menu Link', 'epfitness' );?>">
									</div>
									<div  class=" col-sm-2">
										<button class="btn btn-danger btn-xs" onclick="return iv_remove_menu('<?php echo esc_url($ii); ?>');"><?php esc_html_e('Delete','epfitness');?></button>
									</div>
								</div>
								<?php
									$ii++;
								}
							}else{?>
							<div class="row form-group " id="menu_<?php echo esc_html($ii); ?>">
								<div class=" col-sm-3">
									<input type="text" class="form-control" name="menu_title[]" id="menu_title[]"   placeholder="<?php esc_html_e( 'Enter Menu Title', 'epfitness' );?> ">
								</div>
								<div  class=" col-sm-7">
									<input type="text" class="form-control" name="menu_link[]" id="menu_link[]"  placeholder="<?php esc_html_e( 'Enter Menu Link. Example  http://www.google.com', 'epfitness' );?>">
								</div>
								<div  class=" col-sm-2">
									<button class="btn btn-danger btn-xs" onclick="return iv_remove_menu('<?php echo esc_html($ii); ?>');"><?php esc_html_e('Delete','epfitness');?></button>
								</div>
							</div>
							<?php
								$ii++;
							}
						?>
					</div>
					<div class="col-xs-12">
						<button class="btn btn-warning btn-xs" onclick="return iv_add_menu();"><?php esc_html_e('Add More','epfitness');?> </button>
					</div>
				</div>
			</div>
			<div class="panel panel-info">
				<div class="panel-heading"><h4><?php esc_html_e('User Profile Fields +Signup Form Fields','epfitness');?> </h4></div>
				<div class="panel-body">
					<div class="row ">
						<div class="col-sm-4 ">
							<h4><?php esc_html_e('User Meta Name','epfitness');?> </h4>
						</div>
						<div class="col-sm-4">
							<h4><?php esc_html_e('Display Label','epfitness');?> </h4>
						</div>
						<div class="col-sm-1">
							<h4><?php esc_html_e('Signup Form','epfitness');?> </h4>
						</div>
						<div class="col-sm-1">
							<h4><?php esc_html_e('Require','epfitness');?> </h4>
						</div>
						<div class="col-sm-2">
							<h4><?php esc_html_e('Action','epfitness');?> </h4>
						</div>
					</div>
					<div id="profilefields_div10">
						<?php
							$default_fields = array();
							$field_set=get_option('ep_fitness_profile_fields' );
							if($field_set!=""){
								$default_fields=get_option('ep_fitness_profile_fields' );
								}else{
								$default_fields['first_name']='First Name';
								$default_fields['last_name']='Last Name';
								$default_fields['phone']='Phone Number';
								$default_fields['mobile']='Mobile Number';
								$default_fields['address']='Address';
								$default_fields['occupation']='Occupation';
								$default_fields['description']='About';
								$default_fields['web_site']='Website Url';
							}
							$i=1;
							$sign_up_array=  get_option( 'ep_fitness_signup_fields' );
							$require_array=  get_option( 'ep_fitness_signup_require' );
							foreach ( $default_fields as $field_key => $field_value ) {
								$sign_up='no';
								if(isset($sign_up_array[$field_key]) && $sign_up_array[$field_key] == 'yes') {
									$sign_up='yes';
								}
								$require='no';
								if(isset($require_array[$field_key]) && $require_array[$field_key] == 'yes') {
									$require='yes';
								}
								echo '<div class="row form-group " id="profilefield_'.$i.'"><div class=" col-sm-4"> <input type="text" class="form-control" name="meta_name[]" id="meta_name[]" value="'.$field_key . '" placeholder="'. esc_html__( 'Enter User Meta Name', 'epfitness' ).' "> </div>
								<div  class=" col-sm-4">
								<input type="text" class="form-control" name="meta_label[]" id="meta_label[]" value="'.$field_value . '" placeholder="'. esc_html__( 'Enter User Meta Label', 'epfitness' ).'">
								</div>
								<div class="checkbox col-sm-1">
								<label>
								<input type="checkbox" name="signup[]" id="signup[]" value="'.$field_key.'" '.($sign_up=='yes'? 'checked':'' ).' >
								</label>
								</div>
								<div class="checkbox col-sm-1">
								<label>
								<input type="checkbox" name="srequire[]" id="srequire[]" value="'.$field_key.'" '. ($require=='yes'? 'checked':'' ).' >
								</label>
								</div>
								<div  class=" col-sm-2">';
							?>
							<button class="btn btn-danger btn-xs" onclick="return iv_remove_field('<?php echo esc_html($i); ?>');"><?php esc_html_e('Delete','epfitness');?> </button>
						</div>
					</div>
					<?php
						$i++;
					}
				?>
			</div>
			<div class="col-xs-12">
				<button class="btn btn-warning btn-xs" onclick="return iv_add_field_profilefields();"><?php esc_html_e('Add More','epfitness');?> </button>
			</div>
		</div>
	</div>
</form>
<div class="row">
	<div class="col-xs-12">
		<div align="center">
			<div id="success_fields1"></div>
			<button class="btn btn-info btn-lg" onclick="return update_profile_fields();"><?php esc_html_e('Update','epfitness');?>  </button>
		</div>
		<p>&nbsp;</p>
	</div>
</div>
</div>
</div>
<?php
	wp_enqueue_script('iv_property-script-profiled-fields', wp_ep_fitness_URLPATH . 'admin/files/js/profiled-fields.js');
	wp_localize_script('iv_property-script-profiled-fields', 'profilefields', array(
	'ajaxurl' 				=> admin_url( 'admin-ajax.php' ),
	'loading_image'		=> '<img src="'.wp_ep_fitness_URLPATH.'admin/files/images/loader.gif">',				
	'settings'=> wp_create_nonce("settings"), 	
	'wp_ep_fitness_ADMINPATH' => wp_ep_fitness_ADMINPATH,
	'i'=> esc_html($i), 
	'ii'=> esc_html($ii), 
	) );
	?>			