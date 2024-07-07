<?php
	global $wpdb;
	$ep_fitness='ep_fitness';
	$last_post_id = $wpdb->get_var($wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_type = '%s' ORDER BY `ID` DESC ",$ep_fitness ));
	$form_number = $last_post_id + 1;
	$form_name = 'ep_fitness_' . $form_number;
?>
<div class="bootstrap-wrapper">
	<div class="dashboard-eplugin container-fluid">		
		<div class="row">
			<div class="col-xs-12" id="submit-button-holder">
				<div class="pull-right"><button class="btn btn-info btn-lg" onclick="return save_the_form();"><?php esc_html_e('Save Package','epfitness'); ?></button></div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12"><h3 class="page-header"><?php esc_html_e('Create Package / Membership Level','epfitness'); ?> <br /><small> &nbsp;</small> </h3>
			</div>
		</div>
		<form id="package_form_iv" name="package_form_iv" class="form-horizontal" role="form" onsubmit="return false;">
			<div class="form-group">
				<label for="text" class="col-md-2 control-label"><?php esc_html_e('Package Name','epfitness'); ?></label>
				<div class="col-md-6">
					<input type="text" class="form-control" name="package_name" id="package_name" placeholder="<?php esc_html_e( 'Enter Package Name', 'epfitness' );?>">
				</div>
			</div>
			<?php
				$args = array();
				$args['number']='999';
				$args['orderby']='registered';
				$args['order']='DESC';
				$user_query = new WP_User_Query( $args );
			?>
			<div class="form-group">
				<label for="text" class="col-md-2 control-label"><?php esc_html_e('Select A Trainer','epfitness'); ?></label>
				<div class="col-md-3">
					<select  class="form-control" id="pt_package" name="pt_package">
						<?php
							echo '<option value="" >'. esc_html__( 'Site Admin','epfitness').' </option>';
							$selected='';
							if ( ! empty( $user_query->results ) ) {
								foreach ( $user_query->results as $user ) {
									echo '<option value="'.$user->ID.'"'.$selected.' >'.$user->display_name.' </option>';
								}
							}
						?>
					</select>
				</div>
				<div><?php esc_html_e('The trainer(user) can add plans for the package clients','epfitness'); ?> </div>
			</div>
			<div class="form-group">
				<label for="text" class="col-md-2 control-label"><?php esc_html_e('Package Feature List','epfitness'); ?></label>
				<div class="col-md-6">
					<textarea class="form-control" name="package_feature" id="package_feature" rows="5" placeholder="<?php esc_html_e( 'Enter Feature List', 'epfitness' );?> "></textarea>
					<?php esc_html_e('It will display on price list table','epfitness'); ?>
				</div>
			</div>
			<div class="form-group">
				<label for="text" class="col-md-2 control-label"> <?php esc_html_e('Order','epfitness'); ?> </label>
				<div class="col-md-6 ">
					<label>
						<input type="text" class="form-control" id="package_order" name="package_order" placeholder="<?php esc_html_e( 'Enter order number e.g. 1', 'epfitness' );?>">
					</label>
				</div>
			</div>
			<h3 class="page-header"> <?php esc_html_e('Billing Details','epfitness'); ?></h3>
			<div class="form-group">
				<label for="inputEmail3" class="col-md-2 control-label"><?php esc_html_e('Initial Payment','epfitness'); ?></label>
				<div class="col-md-6">
					<input type="text" class="form-control" id="package_cost" name="package_cost" placeholder="<?php esc_html_e( 'Enter Initial Payment', 'epfitness' );?>">
					<?php esc_html_e('The initial amount collected at user registration.','epfitness'); ?>
				</div>
			</div>
			<div class="form-group">
				<label for="text" class="col-md-2 control-label"><?php esc_html_e('Package Expire After','epfitness'); ?></label>
				<div class="col-md-2">
					<select id="package_initial_expire_interval" name="package_initial_expire_interval" class="ctrl-combobox form-control">
						<?php
							$package_id='0';
							$package_initial_period_interval= get_post_meta($package_id, 'ep_fitness_package_initial_expire_interval', true);
							echo '<option value="">None</option>';
							for($ii=1;$ii<31;$ii++){
								echo '<option value="'.$ii.'" '.($package_initial_period_interval == $ii ? 'selected' : '').'>'.$ii.'</option>';
							}
						?>
					</select>
				</div>
				<div class="col-md-4">
					<?php
						$package_initial_expire_type= get_post_meta($package_id, 'ep_fitness_package_initial_expire_type', true);
					?>
					<select name="package_initial_expire_type" id ="package_initial_expire_type" class=" form-control">
						<option value=""><?php esc_html_e( 'None', 'epfitness' );?> </option>
						<option value="day" <?php echo ($package_initial_expire_type == 'day' ? 'selected' : '') ?>><?php esc_html_e( 'Day(s)', 'epfitness' );?></option>
						<option value="week" <?php echo ($package_initial_expire_type == 'week' ? 'selected' : '') ?>><?php esc_html_e( 'Week(s)', 'epfitness' );?></option>
						<option value="month" <?php echo ($package_initial_expire_type == 'month' ? 'selected' : '') ?>><?php esc_html_e( 'Month(s)', 'epfitness' );?></option>
						<option value="year" <?php echo ($package_initial_expire_type == 'year' ? 'selected' : '') ?>><?php esc_html_e( 'Year(s)', 'epfitness' );?></option>
					</select>
				</div>
				<div class='col-md-12'><label for="text" class="col-md-2 control-label"></label>
					<?php esc_html_e('If select none then user package will expire after 19 years. Package Expire Option will not work on Recurring Subscription. "Billing Cycle Limit" will Work For Recurring Subscription.','epfitness'); ?>
				</div>
			</div>
			<div class="form-group">
				<label for="text" class="col-md-2 control-label"> <?php esc_html_e('Recurring Subscription','epfitness'); ?></label>
				<div class="col-md-6 ">
					<label>
						<input type="checkbox" name="package_recurring" id="package_recurring" value="on" > <?php esc_html_e('Enable Recurring Payment','epfitness'); ?>
					</label>
				</div>
			</div>
			<div id="recurring_block" class="dnone" >
				<div class="form-group">
					<label for="text" class="col-md-2 control-label"><?php esc_html_e('Billing Amount','epfitness'); ?></label>
					<div class="col-md-2">
						<input type="text" class="form-control" name ="package_recurring_cost_initial" id="package_recurring_cost_initial" placeholder="<?php esc_html_e( 'Amount e.g 10', 'epfitness' );?>">
					</div>
					<label for="text" class="col-md-1 control-label"><?php esc_html_e('Per','epfitness'); ?></label>
					<div class="col-md-1">
						<input type="text" class="form-control" id="package_recurring_cycle_count" name="package_recurring_cycle_count" placeholder="<?php esc_html_e( 'Cycle # e.g 1', 'epfitness' );?>">
					</div>
					<div class="col-md-2">
						<select name="package_recurring_cycle_type" id ="package_recurring_cycle_type" class="ctrl-combobox form-control">
							<option value="day"><?php esc_html_e( 'Day(s)', 'epfitness' );?></option>
							<option value="week"><?php esc_html_e( 'Week(s)', 'epfitness' );?></option>
							<option value="month"><?php esc_html_e( 'Month(s)', 'epfitness' );?></option>
							<option value="year"><?php esc_html_e( 'Year(s)', 'epfitness' );?></option>
						</select>
					</div>
					<div class='col-md-12'><label for="text" class="col-md-2 control-label"></label>
						<?php esc_html_e('The "Billing Amount" will Collect at User Registration.','epfitness'); ?>
					</div>
				</div>
				<?php
					if(get_option('ep_fitness_payment_gateway')!='woocommerce'){
					?>
					<div class="form-group">
						<label for="text" class="col-md-2 control-label"><?php esc_html_e('Billing Cycle Limit','epfitness'); ?></label>
						<div class="col-md-2">
							<select name="package_recurring_cycle_limit" id ="package_recurring_cycle_limit" class="ctrl-combobox form-control">
								<option value=""><?php esc_html_e( 'Never', 'epfitness' );?></option>
								<?php
									$package_recurring_cycle_limit= "";
									for($ii=1;$ii<35;$ii++){
										echo '<option value="'.$ii.'" '.($package_recurring_cycle_limit == $ii ? 'selected' : '').'>'.$ii.'</option>';
									}
								?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="text" class="col-md-2 control-label"> <?php esc_html_e('Trial','epfitness'); ?></label>
						<div class="col-md-6 ">
							<label>
								<input type="checkbox" name="package_enable_trial_period" id="package_enable_trial_period"  value='yes'> <?php esc_html_e('Enable Trial Period','epfitness'); ?>
							</label>
							<br/>
							<?php esc_html_e('"Billing Amount" will Collect After Trial Period. ','epfitness'); ?>
						</div>
					</div>
					<div id="trial_block" class="dnone" >
						<div class="form-group">
							<label for="inputEmail3" class="col-md-2 control-label"><?php esc_html_e('Trial Amount','epfitness'); ?></label>
							<div class="col-md-6">
								<input type="text" class="form-control" id="package_trial_amount" name="package_trial_amount" placeholder="<?php esc_html_e( 'Enter Amount to Bill for The Trial Period', 'epfitness' );?>">
								<?php esc_html_e('Amount to Bill for The Trial Period. Free is 0.[Stripe will not support this option ]','epfitness'); ?>
							</div>
						</div>
						<div class="form-group">
							<label for="text" class="col-md-2 control-label"><?php esc_html_e('Trial Period','epfitness'); ?></label>
							<div class="col-md-2">
								<select id="package_trial_period_interval" name="package_trial_period_interval" class="ctrl-combobox form-control">
									<?php
										$package_trial_period_interval= '1'	;
										for($ii=1;$ii<31;$ii++){
											echo '<option value="'.$ii.'" '.($package_trial_period_interval == $ii ? 'selected' : '').'>'.$ii.'</option>';
										}
									?>
								</select>
							</div>
							<div class="col-md-4">
								<select name="package_recurring_trial_type" id ="package_recurring_trial_type" class="ctrl-combobox form-control">
									<option value="day"><?php esc_html_e( 'Day(s)', 'epfitness' );?></option>
									<option value="week"><?php esc_html_e( 'Week(s)', 'epfitness' );?></option>
									<option value="month"><?php esc_html_e( 'Month(s)', 'epfitness' );?></option>
									<option value="year"><?php esc_html_e( 'Year(s)', 'epfitness' );?></option>
								</select>
							</div>
							<div class='col-md-12'><label for="text" class="col-md-2 control-label"></label>
								<?php esc_html_e('After The Trial Period "Billing Amount"	Will Be Billed.','epfitness'); ?>
							</div>
						</div>
					</div> 
					<?php
					}
				?>
			</div> 
			<?php
				if(get_option('ep_fitness_payment_gateway')=='woocommerce'){
					if ( class_exists( 'WooCommerce' ) ) {
					?>
					<div class="form-group">
						<label for="text" class="col-md-2 control-label"><?php esc_html_e('Woocommerce Product','epfitness'); ?></label>
						<div class="col-md-3">
							<select  class="form-control" id="Woocommerce_product" name="Woocommerce_product">
								<?php
									$product='product';
									$sql=$wpdb->prepare("SELECT * FROM $wpdb->posts where post_type='%s'  and post_status='publish'",$product);
									$product_rows = $wpdb->get_results($sql);
									if(sizeof($product_rows)>0){
										foreach ( $product_rows as $row )
										{	$selected='';
											echo '<option value="'.$row->ID.'"'.$selected.' >'.$row->post_title.' </option>';
										}
									}
								?>
							</select>
						</div>
					</div>
					<?php
					}
				}
			?>
		</form>
		<div class="row">
			<div class="col-xs-12">
				<div align="center">
					<div id="loading"></div>
				<button class="btn btn-info btn-lg" onclick="return save_the_form();"><?php esc_html_e('Save Package','epfitness'); ?></button></div>
				<p>&nbsp;</p>
			</div>
		</div>
	</div>
</div>