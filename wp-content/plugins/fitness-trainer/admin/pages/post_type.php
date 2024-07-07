<?php
	$ii=1;
?>
<div class="bootstrap-wrapper">
	<div class="dashboard-eplugin container-fluid">
		<div class="row">
			<div class="col-md-12"><h3 class="page-header"><?php esc_html_e('Custom Post Type','epfitness'); ?>  <br /><small> &nbsp;</small> </h3>
			</div>
		</div>
		<div id="success_message">	</div>
		<div class="panel panel-info">
			<div class="panel-heading"><h4><?php esc_html_e('Custom Post type list','epfitness'); ?>   </h4></div>
			<div class="panel-body">
				<form id="dir_post_type" name="dir_post_type" class="form-horizontal" role="form" onsubmit="return false;">
					<div class="row ">
						<div class="col-sm-5 ">
							<h4><?php esc_html_e('Post Type Name','epfitness'); ?> </h4>
						</div>
						<div class="col-sm-5">
							<h4><?php esc_html_e('Display Label','epfitness'); ?></h4>
						</div>
						<div class="col-sm-2">
							<h4><?php esc_html_e('Action','epfitness'); ?></h4>
						</div>
					</div>
					<div id="posttype_field_div">
						<?php
							$default_fields = array();
							$field_set=get_option('_ep_fitness_url_postype' );
							if($field_set!=""){
								$default_fields=get_option('_ep_fitness_url_postype' );
								}else{
								$default_fields['training-plans']=esc_html__( 'Training Plans', 'epfitness' );
								$default_fields['detox-plans']=esc_html__( 'Detox Plans', 'epfitness' );
								$default_fields['diet-plans']=esc_html__( 'Diet Plans', 'epfitness' );
								$default_fields['diet-guide']=esc_html__( 'Diet Guide', 'epfitness' );
								$default_fields['recipes']=esc_html__( 'Recipes', 'epfitness' );
							}
							$i=1;
							foreach ( $default_fields as $field_key => $field_value ) {
								echo '<div class="row form-group " id="post_type_'.$i.'"><div class=" col-sm-5"> <input type="text" class="form-control" name="posttype_name[]" id="posttype_name[]" value="'.$field_key . '" placeholder="'.esc_html__( 'Enter Post Type Name', 'epfitness' ).' "> </div>
								<div  class=" col-sm-5">
								<input type="text" class="form-control" name="posttype_label[]" id="posttype_label[]" value="'.$field_value . '" placeholder="'.esc_html__( 'Enter Post Type Label', 'epfitness' ).'">
								</div>
								<div  class=" col-sm-2">';
							?>
							<button class="btn btn-danger btn-xs" onclick="return iv_remove_post_type('<?php echo esc_html($i); ?>');"><?php esc_html_e('Delete','epfitness'); ?></button>
							<?php
								echo '</div></div>';
								$i++;
							}
						?>
					</div>
					<div class="col-xs-12">
						<button class="btn btn-warning btn-xs" onclick="return iv_add_field_posttype();"><?php esc_html_e('Add More','epfitness'); ?></button>
					</div>
					<input type="hidden" name="dir_name" id="dir_name" value="<?php echo esc_html($main_category); ?>">
				</form>
				<div class="col-xs-12">
					<div align="center">
							<div id="success_post_type">	</div>
							<div id="loading_post_type"></div>
						<button class="btn btn-info btn-lg" onclick="return update_dir_post_type();"><?php esc_html_e('Update','epfitness'); ?> </button>
					</div>
					<p>&nbsp;</p>
				</div>
				<div class=" col-md-12  bs-callout bs-callout-info">
					<?php
						esc_html_e('Do not use Uppercase, Space & Special characters for custom psot type name. Please update your site permalink after update the post type.', 'epfitness');
					?>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12"><h3 class="page-header"><?php esc_html_e('Custom Post Type Page Setting','epfitness'); ?>  <br /><small> &nbsp;</small> </h3>
			</div>
		</div>
		
		<div class="panel panel-info">
			<div class="panel-heading"><h4><?php esc_html_e('Select Your Custom Post Type Single/Detail Page','epfitness'); ?>   </h4></div>
			<div class="panel-body">
				<?php
					$args = array(
					'child_of'     => 0,
					'sort_order'   => 'ASC',
					'sort_column'  => 'post_title',
					'hierarchical' => 1,
					'post_type' => 'page'
					);
				?>
				<form id="dir_post_type_page" name="dir_post_type_page" class="form-horizontal" role="form" onsubmit="return false;">
					
						<?php
							$default_fields = array();
							$field_set=get_option('_ep_fitness_url_postype' );
							if($field_set!=""){
								$default_fields=get_option('_ep_fitness_url_postype' );
								}else{
								$default_fields['training-plans']=esc_html__( 'Training Plans', 'epfitness' );
								$default_fields['detox-plans']=esc_html__( 'Detox Plans', 'epfitness' );
								$default_fields['diet-plans']= esc_html__( 'Diet Plans', 'epfitness' );
								$default_fields['diet-guide']=esc_html__( 'Diet Guide', 'epfitness' );
								$default_fields['recipes']=esc_html__( 'Recipes', 'epfitness' );
							}
							$i=1;
							foreach ( $default_fields as $field_key => $field_value ) {
								echo'<div class="row"><label  class="col-md-2   control-label">'.$field_value . ' Page</label>';
							?>
							<div class="col-md-10 col-xs-10 col-sm-10">
								<div class="checkbox col-md-4 ">
									<?php
										$old_select='';
										$old_select=get_option('cpt_page_'.$field_key);										
										echo "<select id='cpt_page_".$field_key."' name='cpt_page_".$field_key."'class='form-control'>";
										echo "<option value='training-calendar' ".($old_select=='training-calendar' ? 'selected':'').">Calendar view</option>";
										echo "<option value='post-list' ".($old_select=='post-list'? 'selected':'').">List View</option>";
										echo "</select>";
									?>
								</div>
							</div>
						</div>
						<?php
							$i++;
						}
					?>
				
			</form>
			<div class="col-xs-12">
				<div align="center">
					<div id="success_post_type2">	</div>
					<div id="loading_post_type2"></div>
					<button class="btn btn-info btn-lg" onclick="return update_dir_post_type_page();"><?php esc_html_e('Update','epfitness'); ?> </button>
				</div>
				<p>&nbsp;</p>
			</div>
		</div>
	</div>
</div>
</div>
<?php
	wp_enqueue_script('iv_property-script-post-type', wp_ep_fitness_URLPATH . 'admin/files/js/post-type.js');
	wp_localize_script('iv_property-script-post-type', 'posttype', array(
	'ajaxurl' 				=> admin_url( 'admin-ajax.php' ),
	'loading_image'		=> '<img src="'.wp_ep_fitness_URLPATH.'admin/files/images/loader.gif">',				
	'settings'=> wp_create_nonce("settings"), 	
	'i'=> esc_html($i), 
	'ii'=> esc_html($ii), 
	) );
	?>	