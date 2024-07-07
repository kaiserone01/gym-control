<?php
	wp_enqueue_script('ep_fitness-script-upgrade-15', wp_ep_fitness_URLPATH . 'admin/files/js/jquery.form-validator.js');
	$newpost_id='';
	$post_name='ep_fitness_stripe_setting';
	$row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_name = '%s' ",$post_name ));
	if(isset($row->ID )){
		$newpost_id= $row->ID;
	}
	$stripe_mode=get_post_meta( $newpost_id,'ep_fitness_stripe_mode',true);
	if($stripe_mode=='test'){
		$stripe_publishable =get_post_meta($newpost_id, 'ep_fitness_stripe_publishable_test',true);
		}else{
		$stripe_publishable =get_post_meta($newpost_id, 'ep_fitness_stripe_live_publishable_key',true);
	}
	wp_enqueue_script('stripe', 'https://js.stripe.com/v2/');
?>
<div id="payment-errors"></div>
<div id="stripe_form">
	<div class="row form-group">
		<label for="text" class="col-md-4 col-xs-4 col-sm-4 control-label"><?php esc_html_e('Package Name', 'epfitness'); ?></label>
		<div class="col-md-8 col-xs-8 col-sm-8 ">
			<?php
				$ep_fitness_pack='ep_fitness_pack';
				$sql=$wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_type = '%s'  and post_status='draft' ", $ep_fitness_pack );
				$membership_pack = $wpdb->get_results($sql);
				$total_package=count($membership_pack);
				if(sizeof($membership_pack)>0){
					$i=0; $current_package_id=get_user_meta($current_user->ID,'ep_fitness_package_id',true);
					echo'<select name="package_sel" id ="package_sel" class=" form-control-solid">';
					foreach ( $membership_pack as $row )
					{
						if($current_package_id==$row->ID){
							echo '<option value="'. $row->ID.'" >'. $row->post_title.' [Your Current Package]</option>';
							}else{
							echo '<option value="'. $row->ID.'" >'. $row->post_title.'</option>';
						}
						if($i==0){
							$package_id=$row->ID;
							if(get_post_meta($row->ID, 'ep_fitness_package_recurring',true)=='on'){
								$package_amount=get_post_meta($row->ID, 'ep_fitness_package_recurring_cost_initial', true);
								}else{
								$package_amount=get_post_meta($row->ID, 'ep_fitness_package_cost',true);
							}
						}
						$i++;
					}
					echo '</select>';
				}
			?>
		</div>
	</div>
	<div class="row form-group">
		<label for="text" class="col-md-4 col-xs-4 col-sm-4 control-label"><?php esc_html_e('Amount', 'epfitness'); ?></label>
		<div class="col-md-8 col-xs-8 col-sm-8 " id="p_amount"> <label class="control-label"> <?php  echo esc_html($amount).' '.esc_html($recurring_text); ?> </label>
		</div>
	</div>
	<div class="row form-group">
		<label for="text" class="col-md-4 col-xs-4 col-sm-4 control-label"><?php esc_html_e('Card Number', 'epfitness'); ?></label>
		<div class="col-md-8 col-xs-8 col-sm-8 " >
			<input type="text" name="card_number" id="card_number"  data-validation="creditcard required"  class="form-control-solid ctrl-textbox" placeholder="<?php esc_html_e( 'Enter card number', 'epfitness' );?>" data-validation-error-msg="<?php esc_html_e( 'Card number is not correct', 'epfitness' );?>" >
		</div>
	</div>
	<div class="row form-group">
		<label for="text" class="col-md-4 col-xs-4 col-sm-4 control-label"><?php esc_html_e('Card CVV', 'epfitness'); ?> </label>
		<div class="col-md-8 col-xs-8 col-sm-8 " >
			<input type="text" name="card_cvc" id="card_cvc" class="form-control-solid ctrl-textbox"   data-validation="number"
			data-validation-length="2-6" data-validation-error-msg="<?php esc_html_e( 'CVC number is not correct', 'epfitness' );?> " placeholder="<?php esc_html_e( 'Enter card CVC', 'epfitness' );?>" >
		</div>
	</div>
	<div class="row form-group">
		<label for="text" class="col-md-4 col-xs-4 col-sm-4 control-label"><?php esc_html_e('Expiration (MM/YYYY)', 'epfitness'); ?></label>
		<div class="col-md-4 col-xs-4 col-sm4" >
			<select name="card_month" id="card_month"  class="card-expiry-month stripe-sensitive required form-control-solid">
				<option value="01" ><?php esc_html_e( '01', 'epfitness' );?></option>
				<option value="02"><?php esc_html_e( '02', 'epfitness' );?></option>
				<option value="03"><?php esc_html_e( '03', 'epfitness' );?></option>
				<option value="04"><?php esc_html_e( '04', 'epfitness' );?></option>
				<option value="05"><?php esc_html_e( '05', 'epfitness' );?></option>
				<option value="06"><?php esc_html_e( '06', 'epfitness' );?></option>
				<option value="07"><?php esc_html_e( '07', 'epfitness' );?></option>
				<option value="08"><?php esc_html_e( '08', 'epfitness' );?></option>
				<option value="09"><?php esc_html_e( '09', 'epfitness' );?></option>
				<option value="10"><?php esc_html_e( '10', 'epfitness' );?></option>
				<option value="11"><?php esc_html_e( '11', 'epfitness' );?></option>
				<option value="12" selected ><?php esc_html_e( '12', 'epfitness' );?></option>
			</select>
		</div>
		<div class="col-md-4 col-xs-4 col-sm-4 " >
			<select name="card_year"  id="card_year"  class="card-expiry-year stripe-sensitive  form-control-solid">
			</select>								  
		</div>
	</div>
	<?php
		$ep_fitness_payment_terms=get_option('ep_fitness_payment_terms');
		$term_text='I have read & accept the <a href="#"> Terms & Conditions</a>';
		if( get_option( 'ep_fitness_payment_terms_text' ) ) {
			$term_text= get_option('ep_fitness_payment_terms_text');
		}
		if($ep_fitness_payment_terms=='yes'){
		?>
		<div class="row">
			<div class="col-md-4 col-xs-4 col-sm-4 ">
			</div>
			<div class="col-md-8 col-xs-8 col-sm-8 ">
				<label>
					<input type="checkbox" data-validation="required"
					data-validation-error-msg="<?php esc_html_e( 'You have to agree to our terms', 'epfitness' );?> "  name="check_terms" id="check_terms"> <?php echo esc_html($term_text); ?>
				</label>
				<div class="text-danger" id="error_message" > </div>
			</div>
		</div>
		<?php
		}
	?>
	<input type="hidden" name="package_id" id="package_id" value="<?php echo esc_html($package_id); ?>">
	<input type="hidden" name="coupon_code" id="coupon_code" value="">
	<input type="hidden" name="redirect" value="<?php echo get_permalink($current_page_permalink); ?>"/>
	<input type="hidden" name="stripe_nonce" value="<?php echo wp_create_nonce('stripe-nonce'); ?>"/>
	<div class="row form-group">
		<label for="text" class="col-md-4 col-xs-4 col-sm-4 control-label"></label>
		<div class="col-md-8 col-xs-8 col-sm-8 " > <div id="loading"> </div>
			<button  id="submit_ep_fitness_payment"  type="submit" class="btn-new btn-custom ctrl-btn"  > <?php esc_html_e('Submit', 'epfitness'); ?> </button>
		</div>
	</div>
</div>
<?php
	wp_enqueue_script('iv_fitness-ar-stripe-upgrade', wp_ep_fitness_URLPATH . 'admin/files/js/profile/stripe-upgrade.js');
	wp_localize_script('iv_fitness-ar-stripe-upgrade', 'fit_data', array(
	'ajaxurl' 			=> admin_url( 'admin-ajax.php' ),
	'loading_image'		=> '<img src="'.wp_ep_fitness_URLPATH.'admin/files/images/loader.gif">',
	'current_user_id'	=>get_current_user_id(),		
	'iv_gateway'=> $iv_gateway,
	'stripe_publishable'=> $stripe_publishable,
	'edit'=> esc_html__( 'Edit','epfitness'),		
	'settingnonce'=> wp_create_nonce("settings"),
	) );
?>