<?php
	global $wpdb;
	global $current_user;
	$ii=1;
?>
<div class="bootstrap-wrapper">
	<div class="dashboard-eplugin container-fluid">
		<div class="row">
			<div class="col-md-12"><h3 class="page-header"><?php esc_html_e('Record Fields','epfitness'); ?>  <br /><small> &nbsp;</small> </h3>
			</div>
		</div>
		<div id="success_message">	</div>
		<div class="panel panel-info">
			<div class="panel-heading"><h4><?php esc_html_e('Record Fields','epfitness'); ?> </h4></div>
			<div class="panel-body">
				<form id="record_fields" name="record_fields" class="form-horizontal" role="form" onsubmit="return false;">
					<div class="row ">
						<div class="col-sm-5 ">
							<h4><?php esc_html_e('Post Meta Name','epfitness'); ?></h4>
						</div>
						<div class="col-sm-5">
							<h4>
								<?php esc_html_e('Display Label','epfitness'); ?>
							</h4>
						</div>
						<div class="col-sm-2">
							<h4>
								<?php esc_html_e('Action','epfitness'); ?>
							</h4>
						</div>
					</div>
					<div id="record_field_div">
						<?php
							$default_fields = array();							
							$field_set=get_option('ep_fitness_fields' );
							if($field_set!=""){
								$default_fields=get_option('ep_fitness_fields' );
								}else{
								$default_fields['height']='Height';
								$default_fields['weight']='Weight';
								$default_fields['chest']='Chest';
								$default_fields['l-arm']='Left Arm';
								$default_fields['r-arm']='Right Arm';
								$default_fields['waist']='Waist';
								$default_fields['abdomen']='Abdomen';
								$default_fields['hips']='Hips';
								$default_fields['l-thigh']='Left Thigh';
								$default_fields['r-thigh']='Right Thigh';
								$default_fields['l-calf']='Left Calf';
								$default_fields['r-calf']='Right Calf';
							}
							$i=1;
							foreach ( $default_fields as $field_key => $field_value ) {
								echo '<div class="row form-group " id="record_field_'.$i.'"><div class=" col-sm-5"> <input type="text" class="form-control" name="meta_name[]" id="meta_name[]" value="'.$field_key . '" placeholder="'.esc_html__( 'Enter Post Meta Name', 'epfitness' ).'"> </div>
								<div  class=" col-sm-5">
								<input type="text" class="form-control" name="meta_label[]" id="meta_label[]" value="'.$field_value . '" placeholder="'.esc_html__( 'Enter Post Meta Label', 'epfitness' ).'">
								</div>
								<div  class=" col-sm-2">';
							?>
							<button class="btn btn-danger btn-xs" onclick="return iv_record_remove_field('<?php echo esc_html($i); ?>');"><?php esc_html_e('Delete','epfitness'); ?></button>
							<?php
								echo '</div></div>';
								$i++;
							}
						?>
					</div>
					<div class="col-xs-12">
						<button class="btn btn-warning btn-xs" onclick="return iv_add_record_field();"><?php esc_html_e('Add More', 'epfitness'); ?></button>
					</div>
					<input type="hidden" name="dir_name" id="dir_name" value="<?php echo esc_html($main_category); ?>">
				</form>
				<div class="col-xs-12">
					<div align="center">
						<div id="record_field_message"></div>
						<button class="btn btn-info btn-lg" onclick="return update_dir_fields();"><?php esc_html_e('Update','epfitness'); ?> </button>
					</div>
					<p>&nbsp;</p>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
	wp_enqueue_script('iv_property-script-record-fields', wp_ep_fitness_URLPATH . 'admin/files/js/record-fields.js');
	wp_localize_script('iv_property-script-record-fields', 'recordfields', array(
	'ajaxurl' 				=> admin_url( 'admin-ajax.php' ),
	'loading_image'		=> '<img src="'.wp_ep_fitness_URLPATH.'admin/files/images/loader.gif">',				
	'settings'=> wp_create_nonce("settings"), 	
	'wp_ep_fitness_ADMINPATH' => wp_ep_fitness_ADMINPATH,
	'i'=> esc_html($i), 
	'ii'=> esc_html($ii), 
	) );
?>			