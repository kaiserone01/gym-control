<?php
	global $wpdb;
	global $current_user;
	global $wp_roles;
	$ii=1;
?>
<div class="bootstrap-wrapper">
	<div class="dashboard-eplugin container-fluid">
		<div class="row">
			<div class="col-md-12"><h3 class="page-header"><?php esc_html_e('Report Fields','epfitness'); ?>  <br /><small> &nbsp;</small> </h3>
			</div>
		</div>
		<div id="success_message">	</div>
		<div class="panel panel-info">
			<div class="panel-heading"><h4><?php esc_html_e('Report Fields','epfitness'); ?>   </h4></div>
			<div class="panel-body">
				<form id="report_fields" name="report_fields" class="form-horizontal" role="form" onsubmit="return false;">
					<div class="row">
						<div class="col-sm-2 ">
							<label > <?php esc_html_e('Report Title','epfitness');?>: </label>
						</div>
						<div class="col-sm-3">
							<input type="text" name="report_title1" id="report_title1" value="<?php echo (get_option('epfitness_report_title1')==''?"FITNESS": get_option('epfitness_report_title1'));?>">
						</div>
						<div class="col-sm-3 form-group">
							<input type="text" name="report_title2" id="report_title2" value="<?php echo (get_option('epfitness_report_title2')==''?"REPORT":get_option('epfitness_report_title2') );?>">
							</div>
					</div>
					<div class="row">
						<div class="col-sm-5 ">
							<h4><?php esc_html_e('Who can create/add Report','epfitness'); ?>  </h4>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-4 ">
							<?php
								$report_access=get_option('epfitness_report_access');
								if(trim($report_access)==''){$report_access='users';}
							?>
							<label>
								<input type="radio" name="report_access" id="report_access" value='trainer' <?php echo ($report_access=='trainer' ? 'checked':'' ); ?> ><?php esc_html_e(' Only Trainer+ Admin can add report for user','epfitness');  ?>
							</label>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12 ">
							<label>
								<input type="radio" name="report_access" id="report_access" value='users' <?php echo ($report_access=='users' ? 'checked':'' ); ?> ><?php esc_html_e(' User can add his/her own report (Trainer + Admin too) ','epfitness');  ?>
							</label>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-5 ">
							<h4><?php esc_html_e('Post Meta Name','epfitness'); ?> </h4>
						</div>
						<div class="col-sm-5">
							<h4><?php esc_html_e('Display Label','epfitness'); ?> </h4>
						</div>
						<div class="col-sm-2">
							<h4><?php esc_html_e('Action','epfitness'); ?> </h4>
						</div>
					</div>
					<div id="pdf_field_div">
						<?php
							$default_fields = array();
							$field_set=get_option('ep_fitness_report_fields' );
							if($field_set!=""){
								$default_fields=get_option('ep_fitness_report_fields' );
								}else{
								$default_fields['goals']='Goals';
								$default_fields['reportsummary']='Report Summary';
								$default_fields['in_short']='In Short';
								$default_fields['weight_related_goals']='Weight related goals';
								$default_fields['fitness_related_goals']='Fitness related goals';
								$default_fields['blood_pressure']='Blood pressure';
								$default_fields['Other_notes']='Other notes';
								$default_fields['commit_suggestions']='We agreed you commit to the following suggestions:';
								$default_fields['Nutrition']='Nutrition';
								$default_fields['Hydration']='Hydration';
								$default_fields['Exercise_and_activity']='Exercise and activity';
								$default_fields['Other_consumables ']='Other consumables';
								$default_fields['Sleep']='Sleep';
								$default_fields['Rest']='Rest';
								$default_fields['focus_following_areas']='We agreed that you focus on the following area';
								$default_fields['following_weekly_plan']='We agreed to the following overall/weekly plan';
								$default_fields['motivation1']='You highlighted the following main challenges you face in committing to the above plan';
								$default_fields['motivation2']='We agreed on the following strategies for overcoming these challenges';
							}
							$i=1;
							foreach ( $default_fields as $field_key => $field_value ) {
								echo '<div class="row form-group " id="field_'.$i.'"><div class=" col-sm-5"> <input type="text" class="form-control" name="meta_name[]" id="meta_name[]" value="'.$field_key . '" placeholder="'.esc_html__( 'Enter Post Meta Name', 'epfitness' ).' "> </div>
								<div  class=" col-sm-5">
								<input type="text" class="form-control" name="meta_label[]" id="meta_label[]" value="'.$field_value . '" placeholder="'.esc_html__( 'Enter Post Meta Label', 'epfitness' ).'">
								</div>
								<div  class=" col-sm-2">';
							?>
							<button class="btn btn-danger btn-xs" onclick="return iv_remove_field_pdf('<?php echo esc_html($i); ?>');"><?php esc_html_e('Delete','epfitness'); ?></button>
							<?php
								echo '</div></div>';
								$i++;
							}
						?>
					</div>
					<div class="col-xs-12">
						<button class="btn btn-warning btn-xs" onclick="return iv_add_field_pdf();"> <?php esc_html_e('Add More','epfitness'); ?> </button>
					</div>
					<input type="hidden" name="dir_name" id="dir_name" value="<?php echo esc_html($main_category); ?>">
				</form>
				<div class="col-xs-12">
					<div align="center">
						<div id="success_message_pdf"></div>
						<button class="btn btn-info btn-lg" onclick="return update_pdf_fields();"> <?php esc_html_e('Update','epfitness'); ?>  </button>
					</div>
					<p>&nbsp;</p>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
	wp_enqueue_script('iv_property-script-pdf-fields', wp_ep_fitness_URLPATH . 'admin/files/js/pdf-fields.js');
	wp_localize_script('iv_property-script-pdf-fields', 'pdffields', array(
	'ajaxurl' 				=> admin_url( 'admin-ajax.php' ),
	'loading_image'		=> '<img src="'.wp_ep_fitness_URLPATH.'admin/files/images/loader.gif">',				
	'settings'=> wp_create_nonce("settings"), 	
	'wp_ep_fitness_ADMINPATH' => wp_ep_fitness_ADMINPATH,
	'i'=> esc_html($i), 
	'ii'=> esc_html($ii), 
	) );
?>