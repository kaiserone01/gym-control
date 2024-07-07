<div class="profile-content">
	<div class="portlet light">
		<div class="portlet-title tabbable-line clearfix">
			<div class="caption caption-md">
				<span class="caption-subject"> <?php esc_html_e('Edit Record','epfitness'); ?></span>
			</div>
		</div>
		<div class="portlet-body">
			<div class="tab-content">
				<div class="tab-pane active" id="tab_1_1">
					<?php
						global $wpdb;					
						$package_id=get_user_meta($current_user->ID,'ep_fitness_package_id',true);
						$max=get_post_meta($package_id, 'ep_fitness_package_max_post_no', true);
						$curr_post_id=$_REQUEST['post-id'];
						$current_post = $curr_post_id;
						$post_edit = get_post($curr_post_id);
						$have_edit_access='yes';
						$title = $post_edit->post_title;
						$content = $post_edit->post_content;
					?>
					<div class="row">
						<div class="col-md-12">
							<form action="" id="edit_post" name="edit_post"  method="POST" role="form">
								<div class="form-group row ">
									<label  class="col-sm-3 col-form-label"><?php esc_html_e('Image','epfitness'); ?> </label>
									<div class="col-sm-2">
										<div class="image-content" id="post_image_div">
											<?php $feature_image = wp_get_attachment_image_src( get_post_thumbnail_id( $curr_post_id ), 'thumbnail' );
												if(isset($feature_image[0])){ ?>
												<img title="profile image" class="" src="<?php  echo esc_url($feature_image[0]); ?>">
												<?php
												}else{ ?>
												<a href="javascript:void(0);" onclick="edit_post_image('post_image_div');"  >
													<?php  echo '<img src="'. wp_ep_fitness_URLPATH.'assets/images/image-add-icon.png">'; ?>
												</a>
												<?php
												}
												$feature_image_id=get_post_thumbnail_id( $curr_post_id );
											?>
										</div>
										<input type="hidden" name="feature_image_id" id="feature_image_id" value="<?php echo esc_html($feature_image_id); ?>">
									</div>
									<div class="" id="post_image_edit">
										<button type="button" onclick="edit_post_image('post_image_div');"  class="btn btn-sm green-haze"><?php esc_html_e('Add','epfitness'); ?> </button>
									</div>
								</div>
								<div class="form-group row">
									<label for="text" class="col-sm-3 col-form-label"><?php esc_html_e('Week #','epfitness'); ?></label>
									<div class="col-sm-9">
										<input type="text" class="col-sm-8" name="week" id="week" value="<?php echo  get_post_meta($curr_post_id,'week',true); ?>" placeholder="<?php esc_html_e('Enter Week number','epfitness'); ?>">
									</div>
								</div>
								<div class="form-group row">
									<label for="text" class="col-sm-3 col-form-label"><?php esc_html_e('Date','epfitness'); ?></label>
									<div class="col-sm-9">
										<input class="input-medium col-sm-8 " id="date4" name='date' size="16" type="text" value="<?php echo  get_post_meta($curr_post_id,'date',true); ?>" >
										<span class="add-on"><i class="icon-th"></i></span>									
										
									</div>
								</div>
								<?php
									$field_set=get_option('ep_fitness_fields' );
									$default_fields=array();
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
									$i=1;
									foreach ( $default_fields as $field_key => $field_value ) { ?>
									<div class="form-group row">
										<label for="text" class="col-sm-3 col-form-label"><?php  esc_html_e($field_value, 'epfitness'); ?></label>
										<div class="col-sm-9">
											<input type="text" class="col-sm-8" name="<?php echo esc_html($field_key);?>" id="<?php echo esc_html($field_key);?>" value="<?php echo get_post_meta($curr_post_id,$field_key,true); ?>" placeholder="<?php  esc_html_e('Enter', 'epfitness'); ?> <?php  esc_html_e($field_value, 'epfitness'); ?>">
										</div>
									</div>
									<?php
									}
								?>
								<div class="form-group row">
									<label for="text" class="col-sm-3 col-form-label"></label>
									<div class="col-sm-9">
									  <div class="" id="update_message"></div>
									  <input type="hidden" name="user_post_id" id="user_post_id" value="<?php echo esc_html($curr_post_id); ?>">
										<button type="button" onclick="iv_update_post_user();"  class="btn green-haze"><?php esc_html_e('Update Record','epfitness'); ?></button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
	wp_enqueue_script('iv_fitness-ar-script-r13', wp_ep_fitness_URLPATH . 'admin/files/js/profile/record.js');
	wp_localize_script('iv_fitness-ar-script-r13', 'fit_data', array(
	'ajaxurl' 			=> admin_url( 'admin-ajax.php' ),
	'loading_image'		=> '<img src="'.wp_ep_fitness_URLPATH.'admin/files/images/loader.gif">',
	'current_user_id'	=>get_current_user_id(),
	'delete_message'=> esc_html__( 'Do you want to delete the report?','epfitness'),
	'permalink'=>  get_permalink($current_page_permalink)."?&fitprofile=records"  	,
	'add'=> 		   esc_html__( 'Add','epfitness'),
	'setimage'=>esc_html__('Set Image','epfitness'),
	'edit'=>esc_html__('Edit','epfitness'),
	'remove'=>esc_html__('Remove','epfitness'),
	'settingnonce'=> wp_create_nonce("settings"),
	) );
?>