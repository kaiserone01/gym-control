<?php
	if(isset($_REQUEST['delete_id']))  {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( 'Are you cheating:user Permission?' );
		}
		$post_id=sanitize_text_field($_REQUEST['delete_id']);
		wp_delete_post($post_id);
		delete_post_meta($post_id,true);
		$message=esc_html__( 'Deleted Successfully', 'epfitness' );
	}
?>
<div class="bootstrap-wrapper">
	<div class="dashboard-eplugin container-fluid">
		<?php
			if(!isset($_REQUEST['id']))  {
			?>
			<div class="row ">
				<div class="col-md-12" id="submit-button-holder">
					<div class="pull-right ">
						<a class="btn btn-info "  href="<?php echo wp_ep_fitness_ADMINPATH; ?>admin.php?page=wp-ep_fitness-coupon-create"><?php esc_html_e( 'Create A New Coupon', 'epfitness' );?></a>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 table-responsive">
					<h3  class="page-header"><?php esc_html_e( 'Coupon List', 'epfitness' );?>
						<small >
							<?php
								if (isset($_REQUEST['form_submit']) AND $_REQUEST['form_submit'] <> "") {
									echo  '<span class="couponspan"> ['.esc_html__( 'The Coupon Create Successfully', 'epfitness' ).'  ]</span>';
								}
								if (isset($message) AND $message <> "") {
									echo  '<span class="couponspan"> [ '.$message.' ]</span>';
								}
							?>
						</small>
					</h3>
					<table class="table table-striped col-md-12">
						<thead >
							<tr>
								<th><?php esc_html_e( 'Coupon Code/ Name', 'epfitness' );?></th>
								<th><?php esc_html_e( 'Start Date', 'epfitness' );?></th>
								<th><?php esc_html_e( 'End Date', 'epfitness' );?></th>
								<th><?php esc_html_e( 'Uses Limit', 'epfitness' );?></th>
								<th><?php esc_html_e( 'Amount', 'epfitness' );?> </th>
								<th ><?php esc_html_e( 'Action', 'epfitness' );?></th>
							</tr>
						</thead>
						<tbody>
							<?php
								global $wpdb, $post;
								$iv_coupon='iv_coupon';
								$sql=$wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_type = '%s'",$iv_coupon);
								$products_rows = $wpdb->get_results($sql);
								if(sizeof($products_rows)>0){
									$i=0;
									foreach ( $products_rows as $row )
									{
										echo'<tr>';
										echo '<td>'. $row->post_title.'</td>';
										echo '<td>'. get_post_meta($row->ID, 'iv_coupon_start_date', true).'</td>';
										echo '<td>'. get_post_meta($row->ID, 'iv_coupon_end_date', true).'</td>';
										echo '<td>'. get_post_meta($row->ID, 'iv_coupon_limit', true).' / '.get_post_meta($row->ID, 'iv_coupon_used', true).' </td>';
										echo '<td>'. get_post_meta($row->ID, 'iv_coupon_amount', true).'</td>';
										echo '<td>  <a class="btn btn-primary btn-xs" href="?page=wp-ep_fitness-coupon-update&id='.$row->ID.'"> Edit</a> ';
										echo '  <a href="?page=wp-ep_fitness-coupons-form&delete_id='.$row->ID.'" class="btn btn-danger btn-xs" onclick="return confirm(\'Are you sure to delete this form?\');">'.esc_html__( 'Delete', 'epfitness' ).'</a></td>';
										echo'</tr>';
										$i++;
									}
								}
							?>
						</tbody>
					</table>
					<div class=" col-md-12  bs-callout bs-callout-info">
						<?php esc_html_e( 'Note : Coupon will work on "One Time Payment" only. Coupon will not work on recurring payment and 100% discount will not support.		', 'epfitness' );?>
					</div>
					.
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="">
						<a class="btn btn-info "  href="<?php echo wp_ep_fitness_ADMINPATH; ?>admin.php?page=wp-ep_fitness-coupon-create"><?php esc_html_e( 'Create A New Coupon', 'epfitness' );?></a>
					</div>
				</div>
			</div>
			<div class="row">
				<br/>
			</div>
			<?php
			} 
		?>
	</div>
</div>