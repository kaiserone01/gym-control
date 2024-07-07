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
		esc_html_e('Access Denied ','epfitness');
		}else{
	?>
	<div class="profile-content">
		<div class="portlet light">
		  <div class="portlet-title tabbable-line clearfix">
				<div class="caption caption-md">
					<span class="caption-subject"><?php esc_html_e('Saved Report','epfitness');?>
					</span>
					<span class="btn btn-xs">
						<a  class="btn btn-xs green-haze" href="<?php echo get_permalink($current_page_permalink); ?>?&fitprofile=new-report" role="button">
							<?php esc_html_e('Add New Report','epfitness');?>
						</a>
					</span>
				</div>
			</div>
			<div class="clearfix">
				<div class="row">
					<form name="search_report" id="search_report" action="<?php echo get_permalink($current_page_permalink);?>?&fitprofile=add-report" method="post">
						<div class="col-md-3 form-group ">
							<?php esc_html_e('Report For','epfitness');?>
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
									$args2['orderby']='registered';
									$args2['role__in']=$role_user;
									$args2['order']='DESC';
									$user_query = new WP_User_Query( $args2 );
									$search_user="";
									if(isset($_REQUEST['report_for_user'])){
										$search_user=$_REQUEST['report_for_user'];
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
							'post_type' => 'fitnessreport', 
							'post_status' => 'private',
							'posts_per_page'=> '999',  
							'orderby' => 'date',
							'order' => 'ASC',
							);
							if(isset($current_user->roles[0]) and $current_user->roles[0]!='administrator'){
								$trainer_package= get_user_meta($current_user->ID, 'trainer_package', true);
								if($trainer_package>0){								
								}
							}
							///******* for search*******
							if(isset($_REQUEST['report_for_user']) AND $_REQUEST['report_for_user']!=""){
								$clientid=$_REQUEST['report_for_user'];
							}
							if(isset($_REQUEST['dashuid'])){
								$clientid=$_REQUEST['dashuid'];
							}
							$args['meta_query'] =
							array(
							'relation' => 'AND',
							array(
							'key'     => 'report_for_user',
							'value'   => $clientid,
							'compare' => '='
							),
							);
							$the_query = new WP_Query( $args );
							$i=1;
							if ( $the_query->have_posts() ) :
							while ( $the_query->have_posts() ) : $the_query->the_post();
							$id = get_the_ID();
							$con_user=get_post_meta($id,'report_for_user',true);
							$client_user = get_userdata((int)$con_user);
							$display_name=$client_user->user_nicename;
							$name_display=get_user_meta($con_user,'first_name',true).' '.get_user_meta($con_user,'last_name',true);
							if(trim($name_display)==''){$display_name=$client_user->user_nicename;}
						?>
						<div class="col-md-3 col-sm-6 form-group" id="<?php echo esc_html($id);?>">
							<div class="panel panel-default">
								<div class="panel-body text-center">
									<a href="<?php echo get_permalink($current_page_permalink);?>?&fitnesspdf=<?php echo esc_html($id);?>" target="_blank">
										<img src="<?php echo wp_ep_fitness_URLPATH. "admin/files/images/pdf.png"; ?>">
									</a>
									<div class="row" >
										<div class="col-md-12 col-sm-12 ">
											<label > <?php echo esc_html($display_name);?>  </label>
										</div>
										<div class="col-md-12 col-sm-12  ">
											<label > <?php esc_html_e('Report','epfitness');?>  </label>
										</div>
										<div class="col-md-12 col-sm-12 ">
											<small><?php echo date( 'd M Y', strtotime(get_post_meta($id,'report_date',true))  ); ?> </small>
										</div>
									</div>
									<div class="row">
										<div class=" col-md-6  col-xs-6 btn-xs green-haze custom_border" >
											<a class="btn btn-xs green-haze" href="<?php echo get_permalink($current_page_permalink); ?>?&fitprofile=edit-report&postid=<?php echo esc_html($id);?>" role="button"><?php esc_html_e('Edit','epfitness');?></a>
										</div>
										<div class=" col-md-6  col-xs-6 btn-xs green-haze custom_border">
											<a onclick="return delete_report('<?php echo esc_html($id);?>');"  class="btn btn-xs green-haze" type="button" target="_blank"><?php esc_html_e('Delete','epfitness');?> </a>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12 btn btn-xs green-haze custom_border">
											<a href="<?php echo get_permalink($current_page_permalink);?>?&fitnesspdf=<?php echo esc_html($id);?>" class="custom_color" type="button" target="_blank"><?php esc_html_e('View / Download','epfitness');?>  </a>
										</div>
									</div>
								</div>
							</div>
						</div>
						<?php
							if($i==4){?><div class="row"> </div><?php $i=0;}
							$i++;
							endwhile;
							endif;
						?>
					</div>
					<?php
					}
				?>
			</div>
		</div>
	</div>
	<?php
		wp_enqueue_script('iv_fitness-ar-script-report', wp_ep_fitness_URLPATH . 'admin/files/js/profile/report.js');
		wp_localize_script('iv_fitness-ar-script-report', 'fit_data', array(
		'ajaxurl' 			=> admin_url( 'admin-ajax.php' ),
		'loading_image'		=> '<img src="'.wp_ep_fitness_URLPATH.'admin/files/images/loader.gif">',
		'current_user_id'	=>get_current_user_id(),
		'settingnonce'=> wp_create_nonce("settings"),
		'delete_message'=> esc_html__( 'Do you want to delete the report?','epfitness'),
		) );
	?>
	<?php
	}
?>