<?php
	// Check access****************
	$has_access='no';
	$trainer_package= get_user_meta($current_user->ID, 'trainer_package', true);
	if($trainer_package>0){
		$has_access='yes';
	}
	if(isset($current_user->roles[0]) and $current_user->roles[0]=='administrator'){
		$has_access='yes';
	}
	if($has_access=='no'){
		esc_html_e('<h1>Access Denied</h1> ','epfitness');
		}else{
		//***********End Access Check****************
		$clientid=0;
		if(isset($_REQUEST['dashuid'])){
			$clientid=sanitize_text_field($_REQUEST['dashuid']);
		}
	?>
  <div class="profile-content">
		<span class="caption-subject"> <?php esc_html_e('New Post','epfitness'); ?></span>
		<hr>
		<div class="portlet-body">
			<?php
				global $wpdb;
				$default_post_type = array();
				$postkey= array();
				$post_set=get_option('_ep_fitness_url_postype' );
				if($post_set!=""){
					$default_fields=get_option('_ep_fitness_url_postype' );
					}else{
					$default_fields['training-plans']='Training Plans';
					$default_fields['detox-plans']='Detox Plans';
					$default_fields['diet-plans']='Diet Plans';
					$default_fields['diet-guide']='Diet Guide';
					$default_fields['recipes']='Recipes';
				}
				foreach($default_fields as $key => $value)
				{
					$postkey[] = $key;
				}
				$post_type = join("','",$postkey);
				$sql=$wpdb->prepare("SELECT count(*) as total FROM $wpdb->posts WHERE post_type IN ('%s' )  and post_author='%s' ", $post_type,$current_user->ID);
				$all_post = $wpdb->get_row($sql);
				$my_post_count=$all_post->total;
			?>
			<div class="row">
				<div class="col-md-12">
					<form action="" id="new_post" name="new_post"  method="POST" role="form">
						<div class=" form-group" >
							<label for="text" class=" control-label"><?php esc_html_e('Post Type','epfitness'); ?></label>
							<div class="">
								<?php
									$cpt = array();
									$cpt_set=get_option('_ep_fitness_url_postype' );
									if($cpt_set!=""){
										$cpt=get_option('_ep_fitness_url_postype' );
										}else{
										$cpt['training-plans']='Training Plans';
										$cpt['detox-plans']='Detox Plans';
										$cpt['diet-plans']='Diet Plans';
										$cpt['diet-guide']='Diet Guide';
										$cpt['recipes']='Recipes';
									}
									$i=1;$old_select='';
									echo "<select id='cpt_page' name='cpt_page' class='form-control'>";
									foreach ( $cpt as $field_key => $field_value ) {
										echo "<option value='{$field_key}' ".($old_select==$field_key ? 'selected':'').">{$field_value}</option>";
									}
									echo "</select>";
								?>
							</div>
						</div>
						<div class=" form-group">
							<label for="text" class=" control-label"><?php esc_html_e('Name/Title','epfitness'); ?></label>
							<div class="  ">
								<input type="text" class="form-control-solid" name="title" id="title" value="" placeholder="<?php esc_html_e('Enter Name Here','epfitness'); ?>">
							</div>
						</div>
						<div class="row" >
							<div class="col-md-2 form-group">
								<label > <?php esc_html_e('Date', 'epfitness'); ?> </label>
							</div>
							<div class="col-md-7 form-group">
								<div class="col wid1-3 hLay input-append date" id="dp1" data-date="12-Feb-2015" >
									<input class="input-medium " id="datepicker4" name='pt_date' size="16" type="text" value="" >
									<span class="add-on"><i class="icon-th"></i></span>
								</div>
							</div>
						</div>
						<div class="form-group" >
							<div class=" ">
								<?php
									$settings_a = array(
									'textarea_rows' =>8,
									'editor_class' => 'form-control-solid',
									'textarea_rows'=>15,
									);
									$editor_id = 'new_post_content';
									wp_editor( '', $editor_id,$settings_a );
								?>
							</div>						
						</div>
						<div class=" row form-group left">
							<div class=" col-md-12"> <?php esc_html_e('Feature Image','epfitness'); ?> </div>
							<div class=" col-md-12">
								<div id="post_image_div" class="">
									<a href="javascript:void(0);" onclick="edit_post_image('post_image_div');"  >
										<?php  echo '<img src="'. wp_ep_fitness_URLPATH.'assets/images/image-add-icon.png">'; ?>
									</a>
								</div>
								<input type="hidden" name="feature_image_id" id="feature_image_id" value="">
							</div>
						</div>
						<div class="clearfix"></div>
						<div class="clearfix"></div>
						<div class=" row form-group" >
							<label for="text" class=" col-md-12 control-label"><?php esc_html_e('Category','epfitness'); ?></label>
							<div class=" col-md-12 " id="select_cpt">
								<?php
									$selected='';
									foreach ( $cpt as $field_key => $field_value ) {
										echo '<select name="postcats[]" class="form-control-solid " multiple="multiple" size="8">';
										echo'	<option selected="'.$selected.'" value="">'. esc_html__( 'Choose a category','epfitness').'</option>';
										$selected='';
										if( isset($_POST['submit'])){
											$selected = $_POST['postcats'];
										}									
										$taxonomy = $field_key.'-category';
										$args = array(
										'orderby'           => 'name',
										'order'             => 'ASC',
										'hide_empty'        => false,
										'exclude'           => array(),
										'exclude_tree'      => array(),
										'include'           => array(),
										'number'            => '',
										'fields'            => 'all',
										'slug'              => '',
										'parent'            => '0',
										'hierarchical'      => true,
										'child_of'          => 0,
										'childless'         => false,
										'get'               => '',
										);
										$terms = get_terms($taxonomy,$args); 
										if ( $terms && !is_wp_error( $terms ) ) :
										$i=0;
										foreach ( $terms as $term_parent ) {  ?>
										<?php
											echo '<option  value="'.$term_parent->slug.'" '.($selected==$term_parent->slug?'selected':'' ).'><strong>'.$term_parent->name.'<strong></option>';
										?>
										<?php
											$args2 = array(
											'type'                     => $field_key,
											'parent'                   => $term_parent->term_id,
											'orderby'                  => 'name',
											'order'                    => 'ASC',
											'hide_empty'               => 0,
											'hierarchical'             => 1,
											'exclude'                  => '',
											'include'                  => '',
											'number'                   => '',
											'taxonomy'                 => $field_key.'-category',
											'pad_counts'               => false
											);
											$categories = get_categories( $args2 );
											if ( $categories && !is_wp_error( $categories ) ) :
											foreach ( $categories as $term ) {
												echo '<option  value="'.$term->slug.'" '.($selected==$term->slug?'selected':'' ).'>--'.$term->name.'</option>';
											}
											endif;
											$i++;
										}
										endif;
										echo '</select>';
										break;
									}
								?>
							</div>
						</div>
						<?php
							$role_user=array();
							$trainer_package= get_user_meta($current_user->ID, 'trainer_package', true);
							if($trainer_package>0){
								$role_user[]= get_post_meta($trainer_package,'ep_fitness_package_user_role',true);
							}
							if(strtoupper($crole)==strtoupper('administrator')){
								$role_user=array();
							}
							$argsusers = array(
							'role__in'     => $role_user,
							'orderby'      => 'login',
							'order'        => 'ASC',
							'count_total'  => true,
							'fields'       => 'all',
							);
							$ft_users=get_users( $argsusers );
						?>
						<div class="row" id="user_div" >
							<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12" >
								<?php esc_html_e( 'Select your specific users : Hold shift to select more than 1 user', 'epfitness' );?>
								<select multiple size="20" class="form-control" id="specific_users[]" name="specific_users[]">
									<?php
										foreach ( $ft_users as $user ) {
											$selected=($clientid==$user->ID ?' selected':'' );
											echo '<option value="'.$user->ID.'"'.$selected.' >'.$user->ID.': '.$user->display_name.' - '.$user->user_email.' </option>';
										}
									?>
								</select>
							</div>
						</div>
						<div class="clearfix"></div>
						<hr>
						<div class="row" id="daynumber_div"  >
							<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<label> <?php esc_html_e('Post for the Day','epfitness');?>  </label>
								<textarea class="form-control" name="day_number" id="day_number"  placeholder="<?php esc_html_e( 'Enter day number  e.g. 1,2,5,8 (for calendar view )', 'epfitness' );?>"></textarea>
							</div>
						</div>
						<div class="margiv-top-10">
							<div class="" id="update_message"></div>
							<input type="hidden" name="user_post_id" id="user_post_id" value="">
							<button type="button" onclick="iv_save_post();"  class="btn green-haze"><?php esc_html_e('Save Post','epfitness'); ?></button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<?php
		wp_enqueue_script('iv_fitness-ar-script-p13', wp_ep_fitness_URLPATH . 'admin/files/js/profile/post.js');
		wp_localize_script('iv_fitness-ar-script-p13', 'fit_data', array(
		'ajaxurl' 			=> admin_url( 'admin-ajax.php' ),
		'loading_image'		=> '<img src="'.wp_ep_fitness_URLPATH.'admin/files/images/loader.gif">',
		'current_user_id'	=>get_current_user_id(),
		'delete_message'=> esc_html__( 'Do you want to delete the report?','epfitness'),
		'permalink'=>  get_permalink($current_page_permalink)."?&fitprofile=client-plan" ,
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