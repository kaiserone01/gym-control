<?php
	wp_enqueue_style('stylemyaccountsettings', wp_ep_fitness_URLPATH . 'admin/files/css/my-account-settings.css');
?>
<div class="profile-content">
	<div class="portlet row light">
    <div class="col-md-12 portlet-title tabbable-line clearfix">
		  <div class="caption caption-md">
				<span class="caption-subject"><?php  esc_html_e('Profile','epfitness');?> </span>
			</div>
      <ul class="nav nav-tabs">
        <li >
          <a href="#tab_1_1" data-toggle="tab" class="active"><?php  esc_html_e('Personal Info','epfitness');?> </a>
				</li>
        <li>
          <a href="#tab_1_3" data-toggle="tab"><?php  esc_html_e('Change Password','epfitness');?> </a>
				</li>
        <li>
          <a href="#tab_1_5" data-toggle="tab"><?php  esc_html_e('Social','epfitness');?> </a>
				</li>
			</ul>
		</div>
    <div class=" col-md-12 portlet-body">
      <div class="tab-content">
        <div class="tab-pane active" id="tab_1_1">
          <form role="form" name="profile_setting_form" id="profile_setting_form" action="#">
						<div class="margiv-top-10"> <label class="control-label"><?php echo esc_html_e('Image Gallery', 'epfitness'); ?></label>
							<button type="button" onclick="edit_gallery_image('gallery_image_div');"  class="btn btn-xs green-haze"><?php esc_html_e('Add Images','epfitness'); ?></button>
							<?php
								$gallery_ids=get_user_meta($current_user->ID ,'image_gallery_ids',true);
								$gallery_ids_array = array_filter(explode(",", $gallery_ids));
							?>
							<input type="hidden" name="gallery_image_ids" id="gallery_image_ids" value="<?php echo esc_html($gallery_ids); ?>">
							<div class="" id="gallery_image_div">
								<?php
									if(sizeof($gallery_ids_array)>0){
										foreach($gallery_ids_array as $slide){
										?>
										<div id="gallery_image_div<?php echo esc_html($slide);?>" class="col-md-3"><img  class="img-responsive"  src="<?php echo wp_get_attachment_url( $slide ); ?>"><button type="button" onclick="remove_gallery_image('gallery_image_div<?php echo esc_html($slide);?>', <?php echo esc_html($slide);?>);"  class="btn btn-xs btn-danger">X</button> </div>
										<?php
										}
									}
								?>
							</div>
							<div class="clearfix"><p></p></div>
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
								foreach ( $default_fields as $field_key => $field_value ) { ?>
								<div class="form-group">
									<label class="control-label"><?php echo esc_html($field_value); ?></label>
									<input type="text" placeholder="<?php esc_html_e('Enter','epfitness'); ?> <?php echo ' '.esc_html($field_value);?>" name="<?php echo esc_html($field_key);?>" id="<?php echo esc_html($field_key);?>"  class="form-control-solid" value="<?php echo get_user_meta($current_user->ID,$field_key,true); ?>"/>
								</div>
								<?php
								}
							?>
						</div>
						<div class="margiv-top-10">
							<div class="" id="update_message"></div>
							<button type="button" onclick="update_profile_setting();"  class="btn-new btn-custom"><?php  esc_html_e('Save Changes','epfitness');?></button>
						</div>
					</form>
				</div>
				<div class="tab-pane" id="tab_1_3">
					<form action="" name="pass_word" id="pass_word">
						<div class="form-group">
							<label class="control-label"><?php  esc_html_e('Current Password','epfitness');?> </label>
							<input type="password" id="c_pass" name="c_pass" class="form-control-solid"/>
						</div>
						<div class="form-group">
							<label class="control-label"><?php  esc_html_e('New Password','epfitness');?> </label>
							<input type="password" id="n_pass" name="n_pass" class="form-control-solid"/>
						</div>
						<div class="form-group">
							<label class="control-label"><?php  esc_html_e('Re-type New Password','epfitness');?> </label>
							<input type="password" id="r_pass" name="r_pass" class="form-control-solid"/>
						</div>
						<div class="margin-top-10">
							<div class="" id="update_message_pass"></div>
							<button type="button" onclick="iv_update_password();"  class="btn-new btn-custom"><?php  esc_html_e('Change Password','epfitness');?></button>
						</div>
					</form>
				</div>
				<div class="tab-pane" id="tab_1_5">
					<form action="#" name="setting_fb" id="setting_fb">
						<div class="form-group">
							<label class="control-label"><?php esc_html_e('FaceBook','epfitness'); ?></label>
							<input type="text" name="facebook" id="facebook" value="<?php echo get_user_meta($current_user->ID,'facebook',true); ?>" class="form-control-solid"/>
						</div>
						<div class="form-group">
							<label class="control-label"><?php esc_html_e('Linkedin','epfitness'); ?></label>
							<input type="text" name="linkedin" id="linkedin" value="<?php echo get_user_meta($current_user->ID,'linkedin',true); ?>" class="form-control-solid"/>
						</div>
						<div class="form-group">
							<label class="control-label"><?php esc_html_e('Twitter','epfitness'); ?></label>
							<input type="text" name="twitter" id="twitter" value="<?php echo get_user_meta($current_user->ID,'twitter',true); ?>" class="form-control-solid"/>
						</div>
						
						<div class="form-group">
							<label class="control-label"><?php esc_html_e('Pinterest','epfitness'); ?> </label>
							<input type="text" name="pinterest" id="pinterest" value="<?php echo get_user_meta($current_user->ID,'pinterest',true); ?>"  class="form-control-solid"/>
						</div>
						<div class="form-group">
							<label class="control-label"><?php esc_html_e('Instagram','epfitness'); ?> </label>
							<input type="text" name="Instagram" id="Instagram" value="<?php echo get_user_meta($current_user->ID,'instagram',true); ?>"  class="form-control-solid"/>
						</div>
						<div class="form-group">
							<label class="control-label"><?php esc_html_e('Vimeo','epfitness'); ?> </label>
							<input type="text" name="vimeo" id="vimeo" value="<?php echo get_user_meta($current_user->ID,' vimeo',true); ?>"  class="form-control-solid"/>
						</div>
						<div class="form-group">
							<label class="control-label"><?php esc_html_e('YouTube','epfitness'); ?> </label>
							<input type="text" name="youtube" id="youtube" value="<?php echo get_user_meta($current_user->ID,' youtube',true); ?>"  class="form-control-solid"/>
						</div>
						<div class="margin-top-10">
							<div class="" id="update_message_fb"></div>
							<button type="button" onclick="iv_update_fb();"  class="btn-new btn-custom"><?php  esc_html_e('Save Changes','epfitness');?> </button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
	wp_enqueue_script('iv_fitness-ar-script-s13', wp_ep_fitness_URLPATH . 'admin/files/js/profile/setting.js');
	wp_localize_script('iv_fitness-ar-script-s13', 'fit_s13', array(
	'ajaxurl' 			=> admin_url( 'admin-ajax.php' ),
	'loading_image'		=> '<img src="'.wp_ep_fitness_URLPATH.'admin/files/images/loader.gif">',
	'current_user_id'	=>get_current_user_id(),
	'delete_message'=> esc_html__( 'Do you want to delete the report?','epfitness'),
	'permalink'=>  get_permalink()."?&fitprofile=records"  	,
	'add'=> 		   esc_html__( 'Add','epfitness'),
	'setimage'=> esc_html__( 'Set Image','epfitness'),
	'edit'=> esc_html__( 'Edit','epfitness'),
	'remove'=> esc_html__( 'Remove','epfitness'),
	'settingnonce'=> wp_create_nonce("settings"),
	) );
?>