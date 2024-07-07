<?php
	global $wpdb,$wp_roles;
	$user_id='';
	if(isset($_GET['id'])){ $user_id=$_GET['id'];}
	$user = new WP_User( $user_id );
?>
<div class="bootstrap-wrapper">
	<div class="dashboard-eplugin container-fluid">
		<div class="row">
			<div class="col-md-12"><h3 class=""><?php esc_html_e('User Settings: Edit', 'epfitness'); ?> </h3>
			</div>
		</div>
		<div class="col-md-7 panel panel-info">
			<div class="panel-body">
				<form id="user_form_iv" name="user_form_iv" class="form-horizontal" role="form" onsubmit="return false;">
					<div class="form-group">
						<label for="text" class="col-md-3 control-label"></label>
						<div id="iv-loading"></div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-md-4 control-label"><?php esc_html_e('User Name', 'epfitness'); ?></label>
						<div class="col-md-8">
							<label for="inputEmail3" class="control-label"><?php echo esc_html($user->user_login); ?></label>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-md-4 control-label"><?php esc_html_e('Email Address', 'epfitness'); ?></label>
						<div class="col-md-8">
							<label for="inputEmail3" class="control-label"><?php echo esc_html($user->user_email); ?></label>
						</div>
					</div>
					<div class="form-group">
						<label for="text" class="col-md-4 control-label"><?php esc_html_e('User Role', 'epfitness'); ?></label>
						<div class="col-md-8">
							<?php
								$user_role= $user->roles[0];
							?>
							<select name="user_role" id ="user_role" class="form-control">
								<?php
									foreach ( $wp_roles->roles as $key=>$value ){
										echo'<option value="'.$key.'"  '.($user_role==$key? " selected" : " ") .' >'.$key.'</option>';
									}
								?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="text" class="col-md-4 control-label"><?php esc_html_e('User Package', 'epfitness'); ?></label>
						<div class="col-md-8">
							<?php
								$ep_fitness_pack='ep_fitness_pack';
								$sql=$wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_type = '%s'  and post_status='draft'", $ep_fitness_pack ) ;
								$membership_pack = $wpdb->get_results($sql);
								$total_package=count($membership_pack);
								if($membership_pack>0){
									$i=0; $current_package_id=get_user_meta($user_id,'ep_fitness_package_id',true);
									echo'<select name="package_sel" id ="package_sel" class=" form-control">';
									foreach ( $membership_pack as $row )
									{
										if($current_package_id==$row->ID){
											echo '<option value="'. $row->ID.'" selected>'. $row->post_title.' [User Current Package]</option>';
											}else{
											echo '<option value="'. $row->ID.'" >'. $row->post_title.'</option>';
										}
										$i++;
									}
									echo '</select>';
								}
							?>
						</div>
					</div>
					<div class="form-group">
						<label for="text" class="col-md-4 control-label"><?php esc_html_e('Payment Status', 'epfitness'); ?></label>
						<div class="col-md-8">
							<?php
								$payment_status= get_user_meta($user_id, 'ep_fitness_payment_status', true);
							?>
							<select name="payment_status" id ="payment_status" class="form-control">
								<option value="success" <?php echo ($payment_status == 'success' ? 'selected' : '') ?>>Success</option>
								<option value="pending" <?php echo ($payment_status == 'pending' ? 'selected' : '') ?>>Pendinge</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-md-4 control-label"><?php esc_html_e('Expiry Date', 'epfitness'); ?></label>
						<div class="col-md-8">
							<?php
								$exp_date= get_user_meta($user_id, 'ep_fitness_exprie_date', true);
							?>
							<input type="text"  name="exp_date"  readonly   id="exp_date" class="form-control ctrl-textbox"  value="<?php echo esc_html($exp_date); ?>" placeholder="">
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-md-4 control-label"><?php esc_html_e('Content Settings', 'epfitness'); ?></label>
						<div class="col-md-8">
							<?php
								$user_content= get_user_meta($user_id, 'iv_user_content_setting', true);
							?>
							<label class="col-md-12">
								<input type="radio" name="content_setting" id="content_setting" value="package_only" <?php echo ($user_content=='package_only'? 'checked':'' );?>>
								<?php esc_html_e('Role Content Only','epfitness');?>
							</label>
							<label class="col-md-12">
								<input type="radio" name="content_setting" id="content_setting" value="specific_content" <?php echo ($user_content=='specific_content'? 'checked':'' );?>>
								<?php esc_html_e('Specific Content Only','epfitness');?>
							</label>
							<label class="col-md-12">
								<input type="radio" name="content_setting" id="woocommerce_content" value="woocommerce_content" <?php if ( $user_content=='woocommerce_content'){ echo 'checked'; }?>>
								<?php esc_html_e('Woocommerce Content','epfitness');?>
							</label>
							<label class="col-md-12">
								<input type="radio" name="content_setting" id="content_setting" value="both_content" <?php if ($user_content=='' OR $user_content=='both_content'){ echo 'checked'; }?>>
								<?php esc_html_e('All Content [Role,Specific User, Woocommerce]','epfitness');?>
							</label>
						</div>
					</div>
					<input type="hidden"  name="user_id"     id="user_id"   value="<?php echo esc_html($user_id); ?>" >
					<div class="row">
						<div class="col-md-12">
							<label for="" class="col-md-4 control-label"></label>
							<div class="col-md-8">
							<button class="btn btn-info " onclick="return update_user_setting();"><?php esc_html_e('Update User', 'epfitness'); ?></button></div>
							<p>&nbsp;</p>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>