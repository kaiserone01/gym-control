<?php
	wp_enqueue_style('save_all_records', wp_ep_fitness_URLPATH . 'admin/files/css/all_records.css');
	$current_page_permalink= get_page_link();
	$userId=$current_user->ID;
	$user_id=$current_user->ID;
	$user = new WP_User( $userId );
	if ( !empty( $user->roles ) && is_array( $user->roles ) ) {
		foreach ( $user->roles as $role ){
			$crole= $role;
			break;
		}
	}
	$message='';
	$has_access='no';
	$trainer_package= get_user_meta($current_user->ID, 'trainer_package', true);
	if($trainer_package>0){
		$has_access='yes';
	}
	if(strtoupper($crole)==strtoupper('administrator')){
		$has_access='yes';
	}
	if($has_access=='no'){
		esc_html_e('Access Denied','epfitness');
		}else{
		if(isset($_GET['delete_id']))  {
			$post_id=sanitize_text_field($_GET['delete_id']);
			$post_edit = get_post($post_id);
			if(isset($post_edit)){
				wp_delete_post($post_id);
				delete_post_meta($post_id,true);
				$message= esc_html__( "Deleted Successfully",'epfitness');
			}
		}
		
	?>	
  <div class="profile-content">
		<div class="portlet light">
		  <div class="portlet-title tabbable-line clearfix">
				<div class="caption caption-md">
					<span class="caption-subject"><?php esc_html_e('Saved Record','epfitness');?>
					</span>
					<span class="btn btn-xs">
						<a class="btn btn-xs green-haze" href="<?php echo get_permalink($current_page_permalink); ?>?&fitprofile=add-recordpt">
						<?php esc_html_e('Add New Record','epfitness');?> </a>
					</span>
					<?php echo esc_html($message); ?>
				</div>
			</div>
			<div class="clearfix">
				<?php
					$userId=$current_user->ID;
					$user_id=$current_user->ID;
					$user = new WP_User( $userId );
					if ( !empty( $user->roles ) && is_array( $user->roles ) ) {
						foreach ( $user->roles as $role ){
							$crole= $role;
							break;
						}
					}
					$cuser_role='';
					if(strtoupper($crole)==strtoupper('administrator')){
						$cuser_role='admin';
					}
				?>
				<div class="row">
					<form name="search_report" id="search_report" action="<?php echo get_permalink();?>?&fitprofile=saved-record" method="post">
						<div class="col-md-3 form-group">
							<?php esc_html_e('Record For','epfitness');?>
						</div>
						<div class="col-md-7 form-group">
							<select name="report_for_user" id="report_for_user" class="col-md-12 " >
								<?php
									$role_user=array();
									$trainer_package= get_user_meta($current_user->ID, 'trainer_package', true);
									if($trainer_package>0){
										$role_user[]= get_post_meta($trainer_package,'ep_fitness_package_user_role',true);
									}
									if(strtoupper($crole)==strtoupper('administrator')){
										$role_user=array();
									}
									$args2 = array();
									$args2['number']='9999999';
									$args2['role__in']=$role_user;
									$args2['orderby']='registered';
									$args2['order']='DESC';
									$user_query = new WP_User_Query( $args2 );
									$search_user="";
									if(isset($_REQUEST['report_for_user'])){
										$search_user=$_REQUEST['report_for_user'];
										}else{
										if(isset($_REQUEST['report_for_user_chart'])){
											$search_user=$_REQUEST['report_for_user_chart'];
										}
									}
									if(isset($_REQUEST['dashuid'])){
										$search_user=$_REQUEST['dashuid'];
									}
									if ( ! empty( $user_query->results ) ) {
										foreach ( $user_query->results as $user ) {	?>
										<option value="<?php echo esc_html($user->ID); ?>" <?php echo ($search_user==$user->ID?" selected ":"");?> > <?php echo esc_html($user->ID); ?> | <?php echo esc_html($user->display_name); ?> | <?php echo esc_html($user->user_email); ?></option>
										<?php
										}
									}
								?>
							</select>
						</div>
						<div class="col-md-2 form-group" >
							<button type="submit" class="btn btn-xs green-haze"  ><?php esc_html_e('Search','epfitness'); ?></button>
						</div>
					</form>
				</div>
				<?php
					if ($_SERVER['REQUEST_METHOD'] == 'POST' OR isset($_REQUEST['dashuid'])){
					?>
					<div class="row">
						<?php
							$args = array(
							'post_type' => 'physical-record', 
							'posts_per_page'=> '999',  
							'orderby' => 'date',
							'order' => 'ASC',
							);
							if(isset($_REQUEST['report_for_user'])){
								$search_user=$_REQUEST['report_for_user'];
								$args['author']=$search_user;
								}else{
								if(isset($_REQUEST['report_for_user_chart'])){
									$search_user=$_REQUEST['report_for_user_chart'];
									$args['author']=$search_user;
								}
								if(isset($_REQUEST['dashuid'])){
									$search_user=$_REQUEST['dashuid'];
									$args['author']=$search_user;
								}
							}
							$the_query = new WP_Query( $args );
						?>
						<div class="panel panel-default">
							<div class="panel-heading"><?php esc_html_e('Chart','epfitness'); ?>
							</div>
							<div class="panel-body">
								<?php
									include(  wp_ep_fitness_template. 'private-profile/saved-record-chat.php');
								?>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading"><?php esc_html_e('Saved Records','epfitness'); ?>
							</div>
							<div class="panel-body">
								<table class=" ">
									<?php
										///******* for search*******
										$i=1;
										if ( $the_query->have_posts() ) :
										while ( $the_query->have_posts() ) : $the_query->the_post();
											$id = get_the_ID();
									?>
									<tr>
										<td width="20%" class="td1">
											<?php $feature_image = wp_get_attachment_image_src( get_post_thumbnail_id( $id), 'large' );
												if(isset($feature_image[0])){ ?>
												<a data-fancybox="gallery" href="<?php echo esc_url($feature_image[0]); ?>">
													<img title="profile image" class="img_1"  src="<?php  echo esc_url($feature_image[0]); ?>">
												</a>
												<?php
													}else{
													echo'<img src="'. wp_ep_fitness_URLPATH.'assets/images/Blank-Profile.jpg">';
												}
											?>
											&nbsp;
										</td>
										<td width="25%" class="td2">
											<p> <?php esc_html_e('Date','epfitness'); ?>: <?php echo  get_post_meta($id,'date',true); ?></p>
											<p> <?php esc_html_e('Week','epfitness'); ?> #: <?php echo  get_post_meta($id,'week',true); ?> </p>
											<?php
												$field_set=get_option('ep_fitness_fields' );
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
												<p> <?php echo esc_html_e($field_value, 'epfitness'); ?>: <?php echo get_post_meta($id,$field_key,true); ?> </p>
												<?php
													if($i==5){ ?>
													</td><td width="25%" class="td3">
													<?php
													}
													$i++;
												}
											?>
										</td>
										<td width="30%" class="td30">
											<p> <b> <?php  esc_html_e('Expert Review:','epfitness');?>  </b> </p>
											<p>
												<?php
													$content = get_post_field('post_content', $id);
													$content = str_replace( ']]>', ']]&gt;', $content );
												?>
												<textarea name="expert_review<?php echo esc_html($id);?>" id="expert_review<?php echo esc_html($id);?>"><?php echo  esc_html($content);?></textarea>
											</p>
											<div id="reviewmessage<?php echo esc_html($id);?>"> </div>
											<button type="button" onclick="iv_update_expert_review(<?php echo esc_html($id);?>);"  class="btn btn-xs green-haze"><?php  esc_html_e('Update','epfitness');?></button>
										</td>
										<td>
										
											<a href="<?php echo get_permalink($current_page_permalink); ?><?php echo '?&fitprofile=edit-recordpt&post-id='.$id ;?>"  class="btn btn-success btn-xs"><?php esc_html_e('Edit','epfitness'); ?>
											</a>
											<a href="<?php echo get_permalink($current_page_permalink); ?><?php echo '?&fitprofile=saved-record&delete_id='.$id ;?>"  onclick="return confirm('Are you sure to delete this post?');"  class="btn btn-xs btn-danger">X
											</a>
										</td>
									</tr>
									<?php
										endwhile;
										endif;
									?>
								</table>
							</div>
						</div>
					</div>
					<?php
					}
				?>
			</div>
		</div>
	</div>
	<?php
		wp_enqueue_script('iv_fitness-ar-script-r14', wp_ep_fitness_URLPATH . 'admin/files/js/profile/record.js');
		wp_localize_script('iv_fitness-ar-script-r14', 'fit_data', array(
		'ajaxurl' 			=> admin_url( 'admin-ajax.php' ),
		'loading_image'		=> '<img src="'.wp_ep_fitness_URLPATH.'admin/files/images/loader.gif">',
		'current_user_id'	=>get_current_user_id(),
		'delete_message'=> esc_html__( 'Do you want to delete the data?','epfitness'),
		'add'=> 		   esc_html__( 'Add','epfitness'),
		'setimage'=>esc_html__( 'Set Image','epfitness'),
		'edit'=>esc_html__( 'Edit','epfitness'),
		'settingnonce'=> wp_create_nonce("settings"),
		'remove'=>esc_html__( 'Remove','epfitness'),
		) );
	?>
	<?php
	}
?>