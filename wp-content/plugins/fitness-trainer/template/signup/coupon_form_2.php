<div id="coupon-div">
	<div class="row form-group">
		<label for="text" class="col-md-3 control-label"><?php  esc_html_e('Discount Coupon','epfitness');?></label>
		<div class="col-md-8 ">  <input type="text" class="form-control-solid" name="coupon_name" id="coupon_name" value="" placeholder="<?php  esc_html_e('Enter Coupon Code','epfitness');?>">
		</div>
		<div class="col-md-1 pull-left" id="coupon-result">
		</div>
	</div>
	<div class="row">
		<label for="text" class="col-md-3 control-label"><?php  esc_html_e('(-) Discount','epfitness');?></label>
		<div class="col-md-9 " id="discount">
		</div>
	</div>
	<div class="row">
		<label for="text" class="col-md-3 control-label"><?php  esc_html_e('Total','epfitness');?></label>
		<div class="col-md-9" id="total"><label class="control-label">  <?php echo esc_html($package_amount).''.esc_html($api_currency); ?></label>
		</div>
	</div>
</div>