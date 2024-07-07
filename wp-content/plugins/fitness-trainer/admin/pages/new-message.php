<div class="form-group">
	<label  class="col-md-2   control-label"> <?php esc_html_e( 'BCC to Admin all Message', 'epfitness' );?> : </label>
	<div class="col-md-4 ">
		<?php
			$bcc_message='';
			if( get_option( '_ep_fitness_bcc_message' ) ) {
				$bcc_message= get_option('_ep_fitness_bcc_message');
			}
			?><label>
		  <input  class="" type="checkbox" name="bcc_message" id="bcc_message" value="yes" <?php echo ($bcc_message=='yes'? 'checked':'' ); ?> >
			<?php esc_html_e( 'Yes, Admin will  get all message.', 'epfitness' );?>
		</div>
	</div> 
	<div class="form-group">
		<label  class="col-md-2   control-label"> <?php esc_html_e( 'New Message Subject', 'epfitness' );?> : </label>
		<div class="col-md-4 ">
			<?php
				$ep_fitness_contact_email_subject = get_option( 'ep_fitness_contact_email_subject');
			?>
			<input type="text" class="form-control" id="contact_email_subject" name="contact_email_subject" value="<?php echo esc_html($ep_fitness_contact_email_subject); ?>" placeholder="<?php esc_html_e( 'Enter subject', 'epfitness' );?>">
		</div>
	</div>
	<div class="form-group">
		<label  class="col-md-2   control-label"> <?php esc_html_e( 'New Message Template :', 'epfitness' );?> </label>
		<div class="col-md-10 ">
			<?php
				$settings_forget = array(
				'textarea_rows' =>'20',
				'editor_class'  => 'form-control',
				);
				$content_client = get_option( 'ep_fitness_contact_email');
				$editor_id = 'message_email_template';
			?>
			<textarea id="<?php echo esc_html($editor_id) ;?>" name="<?php echo esc_html($editor_id) ;?>" rows="20" class="col-md-12 ">
				<?php echo esc_html($content_client); ?>
			</textarea>
		</div>
	</div>	