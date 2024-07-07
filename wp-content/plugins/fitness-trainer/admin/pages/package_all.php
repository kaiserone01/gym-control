<?php
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( 'Are you cheating:user Permission?' );
	}
	global $wpdb;
	$currencies = array();
	$currencies['AUD'] ='$';$currencies['CAD'] ='$';
	$currencies['EUR'] ='€';$currencies['GBP'] ='£';
	$currencies['JPY'] ='¥';$currencies['USD'] ='$';
	$currencies['NZD'] ='$';$currencies['CHF'] ='Fr';
	$currencies['HKD'] ='$';$currencies['SGD'] ='$';
	$currencies['SEK'] ='kr';$currencies['DKK'] ='kr';
	$currencies['PLN'] ='zł';$currencies['NOK'] ='kr';
	$currencies['HUF'] ='Ft';$currencies['CZK'] ='Kč';
	$currencies['ILS'] ='₪';$currencies['MXN'] ='$';
	$currencies['BRL'] ='R$';$currencies['PHP'] ='₱';
	$currencies['MYR'] ='RM';$currencies['AUD'] ='$';
	$currencies['TWD'] ='NT$';$currencies['THB'] ='฿';
	$currencies['TRY'] ='TRY';	$currencies['CNY'] ='¥';
	if(isset($_REQUEST['delete_id']))  {
		$post_id=sanitize_text_field($_REQUEST['delete_id']);
		$recurring= get_post_meta($post_id, 'ep_fitness_package_recurring', true);
		if($recurring=='on'){
			$iv_gateway = get_option('ep_fitness_payment_gateway');
			if($iv_gateway=='stripe'){
				include(wp_ep_fitness_DIR . '/admin/files/init.php');
				// delete Plan ******
				$post_name2='ep_fitness_stripe_setting';
				$row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_name = '%s' ", $post_name2));
				if(isset($row->ID )){
					$stripe_id= $row->ID;
				}
				$post_package = get_post($post_id);
				$p_name = $post_package->post_name;
				$stripe_mode=get_post_meta( $stripe_id,'ep_fitness_stripe_mode',true);
				if($stripe_mode=='test'){
					$stripe_api =get_post_meta($stripe_id, 'ep_fitness_stripe_secret_test',true);
					}else{
					$stripe_api =get_post_meta($stripe_id, 'ep_fitness_stripe_live_secret_key',true);
				}
				$plan='';
				\Stripe\Stripe::setApiKey($stripe_api);
				try {
					$plan = \Stripe\Plan::retrieve($p_name);
					$plan->delete();
					} catch (Exception $e) {
						print_r('Stripe does not work');
				}
			}
		}
		wp_delete_post($post_id);
		delete_post_meta($post_id,true);
		$message=esc_html__( 'Deleted Successfully', 'epfitness' );
	}
	if(isset($_REQUEST['form_submit']))  {
		$message=esc_html__( 'Update Successfully', 'epfitness' );
	}
  $api_currency= get_option('_ep_fitness_api_currency' );
?>
<div class="bootstrap-wrapper">
	<div class="dashboard-eplugin container-fluid">
		<div class="row ">
			<div class="col-md-12" id="submit-button-holder">
				<div class="pull-right ">
					<a class="btn btn-info "  href="<?php echo wp_ep_fitness_ADMINPATH; ?>admin.php?page=wp-ep_fitness-package-create"><?php esc_html_e( 'Create A New Package', 'epfitness' );?></a>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 table-responsive">
				<h3  class=""><?php esc_html_e( 'All Package / Membership Level ', 'epfitness' );?> <small></small>
					<small >
						<?php
							if (isset($_REQUEST['form_submit']) AND $_REQUEST['form_submit'] <> "") {
							}
							if (isset($message) AND $message <> "") {
								echo  '<span class="couponspan"> [ '.$message.' ]</span>';
							}
						?>
					</small>
				</h3>
				<div class="panel panel-info">
					<div class="panel-body">
						<table class="table table-striped col-md-12">
							<thead >
								<tr>
									<th ><?php esc_html_e('Package Name','epfitness'); ?></th>
									<th ><?php esc_html_e('Amount','epfitness'); ?></th>
									<th><?php esc_html_e('Link','epfitness'); ?></th>
									<th><?php esc_html_e('User Role','epfitness'); ?></th>
									<th><?php esc_html_e('Status','epfitness'); ?></th>
									<th ><?php esc_html_e('Action','epfitness'); ?> </th>
								</tr>
							</thead>
							<tbody>
								<?php
									$currency=$api_currency ;
									$currency_symbol=(isset($currencies[$currency]) ? $currencies[$currency] :$currency );
									global $wpdb, $post;
									$ep_fitness_pack='ep_fitness_pack';
									$sql=$wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_type = '%s'", $ep_fitness_pack );
									$membership_pack = $wpdb->get_results($sql);
									$total_package=count($membership_pack);
									if(sizeof($membership_pack)>0){
										$i=0;
										foreach ( $membership_pack as $row )
										{
											echo'<tr>';
											echo '<td>'. esc_html($row->post_title).'</td>';
											$amount='';
											if(get_post_meta($row->ID, 'ep_fitness_package_cost', true)!="" AND get_post_meta($row->ID, 'ep_fitness_package_cost', true)!="0"){
												$amount= get_post_meta($row->ID, 'ep_fitness_package_cost', true).' '.$currency;
												}else{
												$amount= '0 '.$currency;
											}
											$recurring= get_post_meta($row->ID, 'ep_fitness_package_recurring', true);
											if($recurring == 'on'){
												$count_arb=get_post_meta($row->ID, 'ep_fitness_package_recurring_cycle_count', true);
												if($count_arb=="" or $count_arb=="1"){
													$recurring_text=" per ".' '.get_post_meta($row->ID, 'ep_fitness_package_recurring_cycle_type', true);
													}else{
													$recurring_text=' per '.$count_arb.' '.get_post_meta($row->ID, 'ep_fitness_package_recurring_cycle_type', true).'s';
												}
												}else{
												$recurring_text=' &nbsp; ';
											}
											$recurring= get_post_meta($row->ID, 'ep_fitness_package_recurring', true);
											if($recurring == 'on'){
												$amount= get_post_meta($row->ID, 'ep_fitness_package_recurring_cost_initial', true).' '.$currency;
												$amount=$amount. ' / '.$recurring_text;
											}
											echo '<td>'. $amount.'</td>';
											$page_name_reg=get_option('_ep_fitness_registration' );
											echo '<td><a target="blank" href="'.get_page_link($page_name_reg).'?&package_id='.$row->ID.'">'.get_page_link($page_name_reg).'?&package_id='.$row->ID.' </a>
											</td>';
											echo '<td>'. $row->post_title.'</td>';
										?>
										<td>
											<div id="status_<?php echo esc_html($row->ID); ?>">
												<?php
													if($row->post_status=="draft"){
														$pac_msg=esc_html__( 'Active', 'epfitness' );
														}else{
														$pac_msg=esc_html__( 'Inactive', 'epfitness' );
													}
												?>
												<button class="btn btn-info btn-xs" onclick="return iv_package_status_change('<?php echo esc_html($row->ID); ?>','<?php echo esc_html($row->post_status); ?>');"><?php echo esc_html($pac_msg); ?></button>
											</div>
											<?php
												echo" </td> ";
												echo '<td>  <a class="btn btn-primary btn-xs" href="?page=wp-ep_fitness-package-update&id='.$row->ID.'"> '.esc_html__( 'Edit', 'epfitness' ).'</a> <a href="?page=wp-ep_fitness-package-all&delete_id='.$row->ID.'" class="btn btn-danger btn-xs" onclick="return confirm(\'Are you sure to delete this package?\');">'.esc_html__( 'Delete', 'epfitness' ).'</a></td>';
												echo'</tr>';
												$i++;
											}
											}else{
											echo "	<br/>
											<br/><tr><td> <h4>".esc_html_e( 'Package List is Empty', 'epfitness' )."</h4></td></tr>";
										}
									?>
								</tbody>
							</table>
						
</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="">
						<a class="btn btn-info "  href="<?php echo wp_ep_fitness_ADMINPATH; ?>admin.php?page=wp-ep_fitness-package-create"><?php esc_html_e( 'Create A New Package', 'epfitness' );?></a>
					</div>
				</div>
			</div>
			<br/>
		
		</div>
	</div>	