<?php
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
					<span class="caption-subject"><?php esc_html_e('Clients Plan','epfitness');?>
					</span>
					<span class="btn btn-xs">
						<a  class="btn btn-xs green-haze" href="<?php echo get_permalink($current_page_permalink); ?>?&fitprofile=add-plan" role="button">
							<?php esc_html_e('Add New Plan','epfitness');?>
						</a>
					</span>
				</div>
			</div>
			<div class="row">
				<form name="search_report" id="search_report" action="<?php echo get_permalink($current_page_permalink);?>?&fitprofile=client-plan" method="post">
					<div class="col-md-6 form-group" >
						<label for="text" class=" control-label"><?php esc_html_e('Client','epfitness'); ?></label>
						<select name="report_for_user" id="p_for_user" class="form-group col-md-12" >
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
					<div class="col-md-4 form-group" >
						<label for="text" class="control-label"><?php esc_html_e('Post Type','epfitness'); ?></label>
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
							$post_type=(isset($_REQUEST['cpt_page'])? $_REQUEST['cpt_page']:key($cpt));
							$i=1;$old_select=$post_type;
							echo "<select id='cpt_page' name='cpt_page' class='col-md-12  form-group'>";
							foreach ( $cpt as $field_key => $field_value ) {
								echo "<option value='{$field_key}' ".($old_select==$field_key ? 'selected':'').">{$field_value}</option>";
							}
							echo "</select>";
						?>
					</div>
					<div class="col-md-2 form-group" >
						<label for="text" class=" control-label"> &nbsp;</label>
						<button type="submit"  class="btn btn-xs green-haze"><?php esc_html_e('Search','epfitness'); ?></button>
					</div>
				</form>
			</div>	 
			<?php
				if ($_SERVER['REQUEST_METHOD'] == 'POST'){
					$i=1;$f_cpt='';
					$default_fields = array();
					$field_set=get_option('_ep_fitness_url_postype' );
					if($field_set!=""){
						$default_fields=get_option('_ep_fitness_url_postype' );
						}else{
						$default_fields['training-plans']='Training Plans';
						$default_fields['detox-plans']='Detox Plans';
						$default_fields['diet-plans']='Diet Plans';
						$default_fields['diet-guide']='Diet Guide';
						$default_fields['recipes']='Recipes';
					}
					foreach ( $default_fields as $field_key => $field_value ) {
						$f_cpt=$field_key;
						break;
					}
					foreach ( $default_fields as $field_key => $field_value ) {
						$old_select=get_option('cpt_page_'.$field_key);
						if($field_key==$post_type){
							if($old_select!=''){
								$file_include=$old_select.'-pt.php';
								}else{
								if($i==1){
									$file_include='training-calendar-pt.php';
									}else{
									$file_include='post-list-pt.php';
								}
							}
							break;
						}
						$i++;
					}
					if( isset($_REQUEST['report_for_user']) AND  $_REQUEST['report_for_user']!=''){
						$search_user=$_REQUEST['report_for_user'];
						include(  wp_ep_fitness_template. 'private-profile/'.$file_include);
					}
				?>
				<?php
				}
			?>
		</div>
	</div>
	<?php
	}
?>