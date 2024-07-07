<?php
	if(isset($_REQUEST['postid'])){ $pdfpost_id=$_REQUEST['postid']; $postid=$pdfpost_id;}
	$postid=$pdfpost_id;
	// Check access****************
	$has_access='no';
	$current_userID= get_current_user_id();
	$post_author_id = get_post_field( 'post_author', $postid );
	$user_for=get_post_meta($postid,'report_for_user',true);
	if( $current_userID==$post_author_id){
		$has_access='yes';
	}
	if(isset($current_user->roles[0]) and $current_user->roles[0]=='administrator'){
		$has_access='yes';
	}
	$trainer_package= get_user_meta($current_user->ID, 'trainer_package', true);
	if($trainer_package>0){
		$has_access='yes';
	}
	if($has_access=='no'){
		esc_html_e('Access denied','epfitness');
		}else{
	?>
	<div class="profile-content">
		<div class="portlet-title tabbable-line clearfix">
			<div class="caption caption-md">
				<span class="caption-subject"><?php esc_html_e('Edit Report','epfitness');?>
				</span>
			</div>
		</div>
		<form action="" id="add_report1" name="add_report1"  method="POST" role="form">
			<div class="row" >
				<?php
					$report_access=get_option('epfitness_report_access');
					if(trim($report_access)==''){$report_access='users';}
					if($trainer_package>0 || $current_user->roles[0]=='administrator'){
						$sccess_url="add-report";
					?>
					<div class="col-md-3 form-group">
						<label ><?php esc_html_e('Report For','epfitness');?>  </label>
					</div>
					<div class="col-md-9 form-group">
						<select name="report_for_user" class="col-sm-8" >
							<?php
								$role_user=array();
								$trainer_package= get_user_meta($current_user->ID, 'trainer_package', true);
								if($trainer_package>0){
									$role_user[]= get_post_meta($trainer_package,'ep_fitness_package_user_role',true);
								}
								if(strtoupper($crole)==strtoupper('administrator')){
									$role_user=array();
								}
								$args = array();
								$args['number']='9999999';
								$args['role__in']=$role_user;
								$args['orderby']='registered';
								$args['order']='DESC';
								$user_query = new WP_User_Query( $args );
								if ( ! empty( $user_query->results ) ) {
									foreach ( $user_query->results as $user ) {	?>
									<option <?php echo($user_for==$user->ID?' selected ':'');?>value="<?php echo esc_html($user->ID); ?> " > <?php echo esc_html($user->ID); ?> | <?php echo esc_html($user->display_name); ?> | <?php echo esc_html($user->user_email); ?></option>
									<?php
									}
								}
							?>
						</select>
					</div>
					<?php
						}else{
						$sccess_url="my-report";
					?>
					<input type="hidden" name="report_for_user"  id="report_for_user" value="<?php echo esc_html($current_user->ID);?>">
					<?php
					}
				?>
			</div>
			<div class="form-group row">
				<label for="text" class="col-sm-3 col-form-label"><?php esc_html_e('Date','epfitness'); ?></label>
				<div class="col-sm-9">
					<div class="col wid1-3 hLay input-append date" id="dp1" data-date="12-Feb-2015" >
						<input class="input-medium col-sm-8 " id="datepicker4" name='report_date' size="16" type="text" value="<?php echo get_post_meta($postid,'report_date',true);?>" >
						<span class="add-on"><i class="icon-th"></i></span>
					</div>
					
				</div>
			</div>
			<?php
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
				foreach ( $default_fields as $field_key => $field_value ) {	?>
				<div class="form-group row">
					<label for="text" class="col-sm-3 col-form-label"><?php echo esc_html($field_value);?> </label>
					<div class="col-sm-9">
						<textarea class=" col-sm-12 " name ="<?php echo esc_html($field_key);?>" rows="3"><?php echo get_post_meta($postid,$field_key,true); ?></textarea>
					</div>
				</div>
				<?php
					$i++;
				}
			?>
			<div class="form-group row">
				<label for="text" class="col-sm-3 col-form-label"></label>
				<div class="col-sm-9">
					<div class="" id="update_message"></div>
					<input type="hidden" name="edit_report_id"  id="edit_report_id" value="<?php echo esc_html($postid);?>">
					<button type="button"  onclick="iv_save_report1();"  class="btn green-haze"><?php esc_html_e('Save Report','epfitness'); ?></button>
				</div>
			</div>
		</form>
	</div>
	<?php
		wp_enqueue_script('iv_fitness-ar-script-r11', wp_ep_fitness_URLPATH . 'admin/files/js/profile/report.js');
		wp_localize_script('iv_fitness-ar-script-r11', 'fit_data', array(
		'ajaxurl' 			=> admin_url( 'admin-ajax.php' ),
		'loading_image'		=> '<img src="'.wp_ep_fitness_URLPATH.'admin/files/images/loader.gif">',
		'current_user_id'	=>get_current_user_id(),
		'delete_message'=> esc_html__( 'Do you want to delete the report?','epfitness'),
		'permalink'=>  get_permalink($current_page_permalink).'?&fitprofile='.$sccess_url,
		'add'=> 		   esc_html__( 'Add','epfitness'),
		'setimage'=> esc_html__( 'Set Image','epfitness'),
		'edit'=> esc_html__( 'Edit','epfitness'),
		'remove'=> esc_html__( 'Remove','epfitness'),
		'settingnonce'=> wp_create_nonce("settings"),
		) );
	?>
	<?php
	}
?>