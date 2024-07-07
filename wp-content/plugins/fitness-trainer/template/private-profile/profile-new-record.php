<div class="profile-content">
	<span class="caption-subject"> <?php esc_html_e('New Record','epfitness'); ?></span>
	<hr>
	<div class="portlet-body">
		<div class="row">
			<div class="col-md-12">
				<form action="" id="new_post" name="new_post"  method="POST" role="form">
					<div class="form-group row">
						<label  class="col-sm-3 col-form-label"><?php esc_html_e('Image','epfitness'); ?> </label>
						<div class="col-sm-2">
							<div class="image-content" id="post_image_div">
								<a href="javascript:void(0);" onclick="edit_post_image('post_image_div');"  >
									<?php  echo '<img src="'. wp_ep_fitness_URLPATH.'assets/images/image-add-icon.png">'; ?>
								</a>
							</div>
							<input type="hidden" name="feature_image_id" id="feature_image_id" value="">
						</div>
						<button type="button" onclick="edit_post_image('post_image_div');"  class="btn btn-sm green-haze"><?php esc_html_e('Add','epfitness'); ?> </button>
					</div>
					<div class="form-group row">
						<label for="text" class="col-sm-3 col-form-label"><?php esc_html_e('Week #','epfitness'); ?></label>
						<div class="col-sm-9">
							<input type="text" class="col-sm-8" name="week" id="week" value="" placeholder="<?php esc_html_e('Enter Week number','epfitness'); ?>">
						</div>
					</div>
					<div class="form-group row">
						<label for="text" class="col-sm-3 col-form-label"><?php esc_html_e('Date','epfitness'); ?></label>
						<div class="col-sm-9">
							<input type="text" class="col-sm-8" id="date4" name='date' size="16" value="" placeholder="<?php esc_html_e('Date','epfitness'); ?>">
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
							<label for="text" class="col-sm-3 col-form-label"><?php echo esc_html_e($field_value, 'epfitness'); ?></label>
							<div class="col-sm-9">
								<input type="text" class="col-sm-8" name="<?php echo esc_html($field_key);?>" id="<?php echo esc_html($field_key);?>" value="" placeholder="<?php echo esc_html_e('Enter', 'epfitness'); ?> <?php echo esc_html_e($field_value, 'epfitness'); ?>">
							</div>
						</div>
						<?php
						}
					?>
					<div class="form-group row">
						<label for="text" class="col-sm-3 col-form-label"></label>
						<div class="col-sm-9">
							<div class="" id="update_message"></div>
							<button type="button" onclick="iv_save_post_user();"  class="btn green-haze"><?php esc_html_e('Save Record','epfitness'); ?></button>
						</div>
					</div>
				</form>
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
	'edit'=> esc_html__( 'Edit','epfitness'),
	'remove'=> esc_html__( 'Remove','epfitness'),
	'settingnonce'=> wp_create_nonce("settings"),
	) );
?>