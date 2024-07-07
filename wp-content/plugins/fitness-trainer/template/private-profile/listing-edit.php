<?php
	$clientid='';
	if(isset($_REQUEST['id'])){
		$clientid=sanitize_text_field($_REQUEST['id']);
	}
?>
<div class="profile-content">
	<span class="caption-subject"> <?php esc_html_e('Edit Post','epfitness'); ?></span>
	<hr>
	<div class="portlet-body">
		<div class="" id="tab_1_1">
			<?php
				global $wpdb;
				$curr_post_id=$_REQUEST['postid'];
				$current_post = $curr_post_id;
				$post_edit = get_post($curr_post_id);
				$have_edit_access='yes';
				if($post_edit->post_author != $current_user->ID ){
					$have_edit_access='no';
				}
				if(isset($current_user->roles[0]) and $current_user->roles[0]=='administrator'){
					$have_edit_access='yes';
				}
				$trainer_package= get_user_meta($current_user->ID, 'trainer_package', true);
				if($trainer_package>0){
					$have_edit_access='yes';
				}
				if ( $have_edit_access=='no') {
					$iv_redirect = get_option( '_iv_directories_login_page');
					$reg_page= get_permalink( $iv_redirect);
				?>
				<?php esc_html_e('Access Denied ','epfitness'); ?>
				<?php
					}else{
					$title = $post_edit->post_title;
					$content = $post_edit->post_content;
					$post_type=$post_edit->post_type;
				?>
				<form action="" id="edit_post" name="edit_post"  method="POST" role="form">
					<div class="form-group display_none">
						<label for="text" class=" control-label"><?php esc_html_e('Psot Type','epfitness'); ?></label>
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
								$i=1;$old_select=$post_type;
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
							<input type="text" class="form-control" name="title" id="title"  placeholder="<?php esc_html_e('Enter listing Name Here','epfitness'); ?>" value="<?php echo esc_html($title);?>">
						</div>
					</div>
					<div class="row" >
						<div class="col-md-2 form-group">
							<label ><?php esc_html_e('Date','epfitness'); ?> </label>
						</div>
						<div class="col-md-7 form-group">
							<div class="col wid1-3 hLay input-append date" id="dp1" data-date="12-Feb-2015" >
								<input class="input-medium " id="datepicker4" name='pt_date' size="16" type="text" value="<?php echo get_post_meta($curr_post_id,'pt_date',true); ?>" >
								<span class="add-on"><i class="icon-th"></i></span>
							</div>										 
						</div>
					</div>
					<div class="form-group">
						<div class=" ">
							<?php								
								$settings_a = array(
								'editor_class' => 'form-control',
								'textarea_rows'=>20,
								);
								$content_client =$content;
								$editor_id = 'edit_post_content';
								wp_editor($content_client, $editor_id,$settings_a );
							?>
						</div>
					</div>
					<div class=" row form-group left">
						<div class=" col-md-12"> <?php esc_html_e('Feature Image','epfitness'); ?>  	</div>
						<div class=" col-md-12">
							<div id="post_image_div" class="col-md-6">
								<?php $feature_image = wp_get_attachment_image_src( get_post_thumbnail_id( $curr_post_id ), 'thumbnail' );
									if(isset($feature_image[0])){ ?>
									<a href="javascript:void(0);" onclick="edit_post_image('post_image_div');"  >
										<img title="profile image" class="  img-responsive" src="<?php  echo esc_url($feature_image[0]); ?>">
									</a>
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
							<div id="post_image_edit" class="col-md-6">
							</div>
							<input type="hidden" name="feature_image_id" id="feature_image_id" value="<?php echo esc_html($feature_image_id); ?>">
						</div>
					</div>
					<div class="clearfix"></div>
					<div class=" row form-group" >
						<label for="text" class=" col-md-12 control-label"><?php esc_html_e('Category','epfitness'); ?></label>
						<div class=" col-md-12 ">
							<?php
								$currentCategory=wp_get_object_terms( $post_edit->ID, $post_type.'-category');
								$post_cats=array();
								foreach($currentCategory as $c)
								{
									array_push($post_cats,$c->slug);
								}
								$selected='';
								echo '<select name="postcats[]" class="form-control " multiple="multiple" size="8">';
								echo'	<option value="">'. esc_html__( 'Choose a category','epfitness').'</option>';
								$taxonomy = $post_type.'-category';
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
								foreach ( $terms as $term_parent ) {
									if(in_array($term_parent->slug,$post_cats)){
										$selected=$term_parent->slug;
									}
								?>
								<?php
									echo '<option  value="'.$term_parent->slug.'" '.($selected==$term_parent->slug?'selected':'' ).'><strong>'.$term_parent->name.'<strong></option>';
								?>
								<?php
									$args2 = array(
									'type'                     => $post_type,
									'parent'                   => $term_parent->term_id,
									'orderby'                  => 'name',
									'order'                    => 'ASC',
									'hide_empty'               => 0,
									'hierarchical'             => 1,
									'exclude'                  => '',
									'include'                  => '',
									'number'                   => '',
									'taxonomy'                 => $post_type.'-category',
									'pad_counts'               => false
									);
									$categories = get_categories( $args2 );
									if ( $categories && !is_wp_error( $categories ) ) :
									foreach ( $categories as $term ) {
										if(in_array($term->slug,$post_cats)){
											$selected=$term->slug;
										}
										echo '<option  value="'.$term->slug.'" '.($selected==$term->slug?'selected':'' ).'>--'.$term->name.'</option>';
									}
									endif;
								?>
								<?php
									$i++;
								}
								endif;
								echo '</select>';
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
									$save_ep_users=array();
									if(get_post_meta( $post_edit->ID,'_ep_postfor_user', true )!=''){
										$save_ep_users=get_post_meta( $post_edit->ID,'_ep_postfor_user', true );
									}
									$selected='';
									foreach ( $ft_users as $user ) {
										$selected='';
										if (in_array($user->ID, $save_ep_users)) {
											$selected='selected';
										}
										echo '<option value="'.$user->ID.'"'.$selected.' >'.$user->ID.': '.$user->display_name.' - '.$user->user_email.' </option>';
									}
								?>
							</select>
						</div>
					</div>
					<div class="clearfix"></div>
					<hr>
					<div class="row" id="daynumber_div" >
						<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<label> <?php esc_html_e('Post for the Day','epfitness');?>  </label>
							<textarea class="form-control" name="day_number" id="day_number"  placeholder="<?php esc_html_e( 'Enter day number  e.g. 1,2,5,8 (for calendar view)', 'epfitness' );?>"><?php echo get_post_meta( $post_edit->ID,'_ep_user_day_number', true );?></textarea>
						</div>
					</div>
					<div class="margiv-top-10">
						<div class="" id="update_message"></div>
						<input type="hidden" name="user_post_id" id="user_post_id" value="<?php echo esc_html($curr_post_id); ?>">
						<button type="button" onclick="iv_update_post();"  class="btn green-haze"><?php esc_html_e('Save Post','epfitness'); ?></button>
					</div>
				</form>
				<?php
				} 
			?>
		</div>
	</div>
</div>
<?php
	wp_enqueue_script('iv_fitness-ar-script-post13', wp_ep_fitness_URLPATH . 'admin/files/js/profile/post.js');
	wp_localize_script('iv_fitness-ar-script-post13', 'fit_data', array(
	'ajaxurl' 			=> admin_url( 'admin-ajax.php' ),
	'loading_image'		=> '<img src="'.wp_ep_fitness_URLPATH.'admin/files/images/loader.gif">',
	'permalink'=>  get_permalink($current_page_permalink)."?&fitprofile=client-plan" ,
	'current_user_id'	=>get_current_user_id(),
	'delete_message'=> esc_html__( 'Do you want to delete the report?','epfitness'),
	'settingnonce'=> wp_create_nonce("settings"),
	) );
?>