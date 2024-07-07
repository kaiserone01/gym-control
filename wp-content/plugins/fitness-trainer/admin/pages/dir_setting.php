<h3  class=""><?php esc_html_e('Settings','epfitness');  ?><small></small>
</h3>
<br/>
<div id="update_message"> </div>
<form class="form-horizontal" role="form"  name='directory_settings' id='directory_settings'>
	<h4><?php esc_html_e('Color Options','epfitness');  ?> </h4>
	<hr>
	<?php
		
		$dir_color=get_option('_dir_color');
		if($dir_color==""){$dir_color='#fd7e14';} 
		$dir_color=str_replace('#','',$dir_color);
	?>
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Plugin Color','epfitness');  ?></label>
		<div class="col-md-6">
			<label>
				<input type="color" name="dir_color" id="dir_color" value='#<?php echo esc_html($dir_color);?>' >
			</label>
		</div>
	</div>
	<h4><?php esc_html_e('Single Page Done Option','epfitness');  ?> </h4>
	<hr>
	<?php
		$dir_done=get_option('_dir_done');
		if($dir_done==""){$dir_done='yes';}
	?>
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Done Button','epfitness');  ?></label>
		<div class="col-md-2">
			<label>
				<input type="radio" name="dir_done" id="dir_done" value='yes' <?php echo ($dir_done=='yes' ? 'checked':'' ); ?> ><?php esc_html_e('Show  Done Button','epfitness');  ?>
			</label>
		</div>
		<div class="col-md-3">
			<label>
				<input type="radio"  name="dir_done" id="dir_done" value='no' <?php echo ($dir_done=='no' ? 'checked':'' );  ?> > <?php esc_html_e('Hide Done Button','epfitness');  ?>
			</label>
		</div>
	</div>
	<h4><?php esc_html_e('Training Calendar view Option ','epfitness');  ?> </h4>
	<hr>
	<?php
		$fitness_calendar_days=get_option('fitness_calendar_days');
		if($fitness_calendar_days==""){$fitness_calendar_days='30';}
	?>
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Training calendar View Days','epfitness');  ?></label>
		<div class="col-md-2">
			<label>
				<input type="text" name="fitness_calendar_days" id="fitness_calendar_days" value='<?php echo esc_html($fitness_calendar_days); ?>' >
			</label>
		</div>
	</div>
	<h4><?php esc_html_e('Cron Job','epfitness');  ?> </h4>
	<hr>
	<div class="form-group">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Cron Job URL','epfitness');  ?>
		</label>
		<div class="col-md-6">
			<label>
				<b> <a href="<?php echo admin_url('admin-ajax.php'); ?>?action=ep_fitness_cron_job"><?php echo admin_url('admin-ajax.php'); ?>?action=ep_fitness_cron_job </a></b>
			</label>
		</div>
		<div class="col-md-3">
			<?php esc_html_e('Cron JOB Detail : Hide Listing( Package setting),Subscription Remainder email.','epfitness');  ?>
		</div>
	</div>
	<div class="form-group">
		<label  class="col-md-3 control-label"> </label>
		<div class="col-md-8">
			<button type="button" onclick="return  iv_update_dir_setting();" class="btn btn-success"><?php esc_html_e('Update','epfitness');  ?>	</button>
		</div>
	</div>
</form>