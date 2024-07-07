<?php
	global $wpdb;
	$newpost_id='';
	$post_name='ep_fitness_paypal_setting';
	$row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_name = '%s' ",$post_name ));
	if(isset($row->ID )){
		$newpost_id= $row->ID;
	}
	$paypal_mode=get_post_meta( $newpost_id,'ep_fitness_paypal_mode',true);
	$newpost_id='';
	$post_name='ep_fitness_stripe_setting';
	$row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_name = '%s' ",$post_name ));
	if(isset($row->ID )){
		$newpost_id= $row->ID;
	}
	$stripe_mode=get_post_meta( $newpost_id,'ep_fitness_stripe_mode',true);
?>
<div class="bootstrap-wrapper">
	<div class="dashboard-eplugin container-fluid">
		<div class="row">
			<div class="col-md-12">
				<h3 class="page-header" >
					<?php esc_html_e('Payment Gateways', 'epfitness'); ?>
				</h3>
			
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				
				<table class="table">
					<thead>
						<tr>
						  <th><?php esc_html_e( '#', 'epfitness' );?></th>
						  <th><?php esc_html_e( 'Gateways Name', 'epfitness' );?></th>
						  <th><?php esc_html_e( 'Mode', 'epfitness' );?></th>
						  <th><?php esc_html_e( 'Status', 'epfitness' );?></th>
						  <th><?php esc_html_e( 'Action', 'epfitness' );?></th>
						</tr>
					</thead>
					<tbody>
						<tr>
						  <td><?php esc_html_e( '1', 'epfitness' );?></td>
						  <td> <label>
								<input name='payment_gateway' id='payment_gateway'  type="radio" <?php echo (get_option('ep_fitness_payment_gateway')=='paypal-express')? 'checked':'' ?> value="paypal-express">
								<?php esc_html_e( 'Paypal', 'epfitness' );?>
							</label>
						  </td>
						  <td><?php echo strtoupper($paypal_mode); ?></td>
						  <td><?php echo (get_option('ep_fitness_payment_gateway')=='paypal-express')? 'Active':'Inactive' ?> </td>
							<td><a class="btn btn-primary btn-xs" href="?page=wp-ep_fitness-payment-paypal"> <?php esc_html_e( 'Edit Setting', 'epfitness' );?></a></td>
						</tr>
						<tr>
						  <td><?php esc_html_e( '2', 'epfitness' );?></td>
						  <td>
								<label>
									<input name='payment_gateway' id='payment_gateway'  type="radio" <?php echo (get_option('ep_fitness_payment_gateway')=='stripe')? 'checked':'' ?>  value="stripe">
									<?php esc_html_e( 'Stripe', 'epfitness' );?>
								</label> </td>
								<td><?php echo strtoupper($stripe_mode); ?></td>
								<td><?php echo (get_option('ep_fitness_payment_gateway')=='stripe')? 'Active':'Inactive' ?></td>
								<td> <a class="btn btn-primary btn-xs" href="?page=wp-ep_fitness-payment-stripe"> <?php esc_html_e( 'Edit Setting', 'epfitness' );?></a> </td>
						</tr>
						<?php
							if ( class_exists( 'WooCommerce' ) ) {
							?>
							<tr>
								<td><?php esc_html_e( '3', 'epfitness' );?></td>
								<td><input name='payment_gateway' id='payment_gateway'  type="radio" <?php echo (get_option('ep_fitness_payment_gateway')=='woocommerce')? 'checked':'' ?>  value="woocommerce">
									<b><?php esc_html_e('WooCommerce', 'epfitness'); ?></b><?php esc_html_e( ' [You need to select the payment gateway from woocommerce settings]', 'epfitness' );?> 
								</label> </td>
								<td>	</td>
								<td><?php echo (get_option('ep_fitness_payment_gateway')=='woocommerce')? 'Active':'Inactive' ?></td>
								<td>  </td>
						</tr>
						<?php
						}
					?>
				</tbody>
			</table>
			<div class="col-md-12" id="update_message_payment"></div>
		</div>
	</div>
</div>
</div>