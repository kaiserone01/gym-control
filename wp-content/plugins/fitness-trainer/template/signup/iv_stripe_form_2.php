<?php
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
<div class="row form-group">
	<label for="text" class="col-md-3 control-label"><?php  esc_html_e('Package Name','epfitness');?></label>
	<div class="col-md-9 ">
		<?php
			if( $package_name==""){
				$ep_fitness_pack='ep_fitness_pack';
				$sql=$wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_type = '%s'  and post_status='draft' ",$ep_fitness_pack) ;
				$membership_pack = $wpdb->get_results($sql);
				$total_package=count($membership_pack);
				if(sizeof($membership_pack)>0){
					$i=0;
					echo'<select name="package_sel" id ="package_sel" class=" form-control">';
					foreach ( $membership_pack as $row )
					{
						echo '<option value="'. $row->ID.'" >'. esc_html($row->post_title).'</option>';
						if($i==0){$package_id=$row->ID;}
						$i++;
					}
					echo '</select>';
					$package_id= $membership_pack[0]->ID;
					$recurring= get_post_meta($package_id, 'ep_fitness_package_recurring', true);
					if($recurring == 'on'){
						$package_amount=get_post_meta($package_id, 'ep_fitness_package_recurring_cost_initial', true).' '.$api_currency.'/'.get_post_meta($package_id, 'ep_fitness_package_recurring_cycle_count', true).' '.get_post_meta($package_id, 'ep_fitness_package_recurring_cycle_type', true);
						}else{
						$package_amount=get_post_meta($package_id, 'ep_fitness_package_cost',true);
					}
				?>
				<?php
				}
				}else{
				echo '<label class="control-label"> '.$package_name.'</label>';
				$recurring= get_post_meta($package_id, 'ep_fitness_package_recurring', true);
				if($recurring == 'on'){
					$package_amount=get_post_meta($package_id, 'ep_fitness_package_recurring_cost_initial', true).' '.$api_currency.'/'.get_post_meta($package_id, 'ep_fitness_package_recurring_cycle_count', true).' '.get_post_meta($package_id, 'ep_fitness_package_recurring_cycle_type', true);
					}else{
					$package_amount=get_post_meta($package_id, 'ep_fitness_package_cost',true);
				}
			}
		?>
	</div>
</div>
<div class="row form-group">
	<label for="text" class="col-md-3 control-label"><?php  esc_html_e('Amount','epfitness');?></label>
	<div class="col-md-9 " id="p_amount"> <label class="control-label"> <?php echo esc_html($package_amount) ; ?> </label>
	</div>
</div>
<?php
	if( get_option('_ep_fitness_payment_coupon')==""){
	?>
	<div class="row form-group" id="show_hide_div">
		<label for="text" class="col-md-3 control-label"></label>
		<div class="col-md-9 mtb10" >
			<button type="button" onclick="show_coupon();"  class="btn-new btn-default-new center"><?php  esc_html_e('Have a coupon?','epfitness');?></button>
		</div>
	</div>
	<?php
		require_once(wp_ep_fitness_template.'signup/coupon_form_2.php');
	}
?>
<div class="row form-group">
	<label for="text" class="col-md-3 control-label"><?php  esc_html_e('Card Number','epfitness');?></label>
	<div class="col-md-9 " >
		<input type="text" name="card_number" id="card_number"  data-validation="creditcard required"  class="form-control-solid ctrl-textbox" placeholder="<?php esc_html_e( 'Enter card number', 'epfitness' );?>"  data-validation-error-msg="<?php  esc_html_e('Card number is not correct','epfitness');?>" >
	</div>
</div>
<div class="row form-group">
	<label for="text" class="col-md-3 control-label"><?php  esc_html_e('Card CVV ','epfitness');?></label>
	<div class="col-md-9 " >
		<input type="text" name="card_cvc" id="card_cvc" class="form-control-solid ctrl-textbox"   data-validation="number"
		data-validation-length="2-6" data-validation-error-msg="<?php  esc_html_e('CVV number is not correct','epfitness');?>"placeholder="<?php  esc_html_e('Enter card CVC','epfitness');?>" >
	</div>
</div>
<div class="row form-group">
	<label for="text" class="col-md-3 control-label"><?php  esc_html_e('Expiration (MM/YYYY)','epfitness');?></label>
	<div class="col-md-4" >
		<select name="card_month" id="card_month"  class="card-expiry-month stripe-sensitive required form-control">
			<option value="01" <?php esc_html_e( '01', 'epfitness' );?>></option>
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
	<div class="col-md-5 " >
		<select name="card_year"  id="card_year"  class="card-expiry-year stripe-sensitive  form-control">
		</select>									
	</div>
</div>
<?php
	$ep_fitness_payment_terms=get_option('ep_fitness_payment_terms');
	$term_text='I have read & accept the Terms & Conditions';
	if( get_option( 'ep_fitness_payment_terms_text' ) ) {
		$term_text= get_option('ep_fitness_payment_terms_text');
	}
	if($ep_fitness_payment_terms=='yes'){
	?>
	<div class="row">
		<div class="col-md-3 ">
		</div>
		<div class="col-md-9 ">
			<label>
				<input type="checkbox" data-validation="required"
				data-validation-error-msg="<?php esc_html_e( 'You have to agree to our terms', 'epfitness' );?> "  name="check_terms" id="check_terms"> <?php echo $term_text; ?>
			</label>
			<div class="text-danger" id="error_message" > </div>
		</div>
	</div>
	<?php
	}
?>
<input type="hidden" name="package_id" id="package_id" value="<?php echo esc_html($package_id); ?>">
<input type="hidden" name="form_reg" id="form_reg" value="">
<input type="hidden" name="action" value="stripe"/>
<input type="hidden" name="redirect" value="<?php echo get_permalink($current_page_permalink); ?>"/>
<input type="hidden" name="stripe_nonce" value="<?php echo wp_create_nonce('stripe-nonce'); ?>"/>
<div class="row form-group">
	<label for="text" class="col-md-3 control-label"></label>
	<div class="col-md-9 margin-top-20" >
		<div id="loading-3"><img src='<?php echo wp_ep_fitness_URLPATH. 'admin/files/images/loader.gif'; ?>' /></div>
		<button  id="submit_ep_fitness_payment"  type="submit" class="btn-new btn-custom ctrl-btn"  > <?php  esc_html_e('Submit','epfitness');?> </button>
	</div>
</div>