<?php
	wp_enqueue_style('dataTables', wp_ep_fitness_URLPATH . 'admin/files/css/jquery.dataTables.css');
	wp_enqueue_script('dataTables', wp_ep_fitness_URLPATH . 'admin/files/js/jquery.dataTables.js');
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
		esc_html_e('<h1>Access Denied</h1> ','epfitness');
		}else{
	?>
	<div class="profile-content">
	  <div class="portlet-title tabbable-line clearfix">
			<div class="caption caption-md">
				<span class="caption-subject">
					<?php
						esc_html_e('Trainer Dashboard : My Clients','epfitness');
					?></span>
			</div>
		</div>
	  <table id="user-data" class="display table " width="100%">
			<thead  class="dfont">
				<tr>
					<th width="6%"> <?php  esc_html_e('ID','epfitness')	;?> </th>
				  <th width="22%"> <?php  esc_html_e('User Name/ Email','epfitness')	;?></th>
					<th width="16%"> <?php  esc_html_e('Role','epfitness')	;?> </th>
				  <th width="28%"> <?php  esc_html_e('Add','epfitness')	;?> </th>
				  <th width="28%"> <?php  esc_html_e('View','epfitness')	;?> </th>
				</tr>
			</thead>
			<tbody>
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
					if ( ! empty( $user_query->results ) ) {
						foreach ( $user_query->results as $user ) {					
						?>
						<tr  class="dfont">
							<td><?php echo esc_html($user->ID); ?></td>
						  <td ><?php echo get_user_meta($user->ID, 'first_name', true).' '.get_user_meta($user->ID, 'last_name', true).' ('. $user->display_name.')'; ?>
								<br/><?php echo esc_html($user->user_email); ?>
							</td>
							 <td ><?php if(isset($user->roles[0])){ echo $user->roles[0];};  ?>
							</td>
						  <td>
								<a class="btn btn-primary btn-xs" href="<?php echo get_permalink($current_page_permalink); ?>?&fitprofile=add-plan&dashuid=<?php echo esc_html($user->ID); ?>"> <?php  esc_html_e('Plan','epfitness')	;?></a>
								<a class="btn btn-primary btn-xs" href="<?php echo get_permalink($current_page_permalink); ?>?&fitprofile=add-recordpt&dashuid=<?php echo esc_html($user->ID); ?>"> <?php  esc_html_e('Record','epfitness')	;?></a>
								<a class="btn btn-primary btn-xs" href="<?php echo get_permalink($current_page_permalink); ?>?&fitprofile=new-report&dashuid=<?php echo esc_html($user->ID); ?>"> <?php  esc_html_e('Report','epfitness')	;?></a>
							</td>
						  <td>
								<a class="btn btn-primary btn-xs" href="<?php echo get_permalink($current_page_permalink); ?>?&fitprofile=client-plan&dashuid=<?php echo esc_html($user->ID); ?>"> <?php  esc_html_e('Plan','epfitness')	;?></a>
								<a class="btn btn-primary btn-xs" href="<?php echo get_permalink($current_page_permalink); ?>?&fitprofile=saved-record&dashuid=<?php echo esc_html($user->ID); ?>"> <?php  esc_html_e('Record','epfitness')	;?></a>
								<a class="btn btn-primary btn-xs" href="<?php echo get_permalink($current_page_permalink); ?>?&fitprofile=add-report&dashuid=<?php echo esc_html($user->ID); ?>"> <?php  esc_html_e('Report','epfitness')	;?></a>
							</td>
						</tr>
						<?php
						}
					}
				?>
			</tbody>
		</table>
	</div>
	<?php
	}
?>