<div class="profile-content">
	<div class="portlet light">
		<div class="portlet-title tabbable-line clearfix">
			<div class="caption caption-md">
				<span class="caption-subject"><?php esc_html_e('My Report','epfitness');?>
				</span>
				<?php
					$has_report_access="no";
					$report_access=get_option('epfitness_report_access');
					if($report_access=='users'){
					?>
					<span class="btn btn-xs">
						<a  class="btn btn-xs green-haze" href="<?php echo get_permalink($current_page_permalink); ?>?&fitprofile=new-report" role="button">
							<?php esc_html_e('Add New Report','epfitness');?>
						</a>
					</span>
					<?php
					}
				?>
			</div>
		</div>
		<div class="clearfix">
			<div class="row">
				<?php
					$args = array(
					'post_type' => 'fitnessreport', 
					'post_status' => 'private',
					'posts_per_page'=> '999', 
					'orderby' => 'date',
					'order' => 'ASC',
					);
					$clientid=$current_user->ID;
					$args['meta_query'] =
					array(
					'relation' => 'AND',
					array(
					'key'     => 'report_for_user',
					'value'   => $clientid,
					'compare' => '='
					),
					);
					$the_query = new WP_Query( $args );
					$i=1;
					if ( $the_query->have_posts() ) :
					while ( $the_query->have_posts() ) : $the_query->the_post();
					$id = get_the_ID();
					$con_user=get_post_meta($id,'report_for_user',true);
					$client_user = get_userdata((int)$con_user);
					$display_name=$client_user->user_nicename;
					$name_display=get_user_meta($con_user,'first_name',true).' '.get_user_meta($con_user,'last_name',true);
					if(trim($name_display)==''){$display_name=$client_user->user_nicename;}
				?>
				<div class="col-md-3 col-sm-6 form-group" id="<?php echo esc_html($id);?>">
					<div class="panel panel-default">
						<div class="panel-body text-center">
							<a href="<?php echo get_permalink($current_page_permalink);?>?&?fitnesspdf=<?php echo esc_html($id);?>" target="_blank">
								<img src="<?php echo wp_ep_fitness_URLPATH. "admin/files/images/pdf.png"; ?>">
							</a>
							<div class="row" >
								<div class="col-md-12 col-sm-12 ">
									<label > <?php echo esc_html($display_name);?>  </label>
								</div>
								<div class="col-md-12 col-sm-12  ">
									<label > <?php esc_html_e('Report','epfitness');?>  </label>
								</div>
								<div class="col-md-12 col-sm-12 ">
									<small><?php echo date( 'd M Y', strtotime(get_post_meta($id,'report_date',true))  ); ?> </small>
								</div>
							</div>
							<div class="row">
								<?php
									$post_author_id = get_post_field( 'post_author', $id );
									if($current_user->ID==$post_author_id){
									?>
									<div class=" col-md-6  col-xs-6 btn-xs green-haze custom_border">
										<a class="btn btn-xs green-haze" href="?&fitprofile=edit-report&postid=<?php echo esc_html($id);?>" role="button"><?php esc_html_e('Edit','epfitness');?></a>
									</div>
									<div class=" col-md-6  col-xs-6 btn-xs green-haze custom_border" >
										<a onclick="return delete_report('<?php echo esc_html($id);?>');"  class="btn btn-xs green-haze" type="button" target="_blank"><?php esc_html_e('Delete','epfitness');?> </a>
									</div>
									<?php
									}
								?>
							</div>
							<div class="row">
								<div class="col-md-12 btn btn-xs green-haze custom_border">
									<a href="<?php echo get_permalink($current_page_permalink);?>?&?fitnesspdf=<?php echo esc_html($id);?>" class="custom_color" type="button" target="_blank"><?php esc_html_e('View / Download','epfitness');?>  </a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php
					if($i==4){?><div class="row"> </div><?php $i=1;}
					$i++;
					endwhile;
					endif;
				?>
			</div>
		</div>
	</div>
</div>
<?php
	wp_enqueue_script('iv_fitness-ar-script-r11', wp_ep_fitness_URLPATH . 'admin/files/js/profile/report.js');
	wp_localize_script('iv_fitness-ar-script-r11', 'fit_data', array(
	'ajaxurl' 			=> admin_url( 'admin-ajax.php' ),
	'loading_image'		=> '<img src="'.wp_ep_fitness_URLPATH.'admin/files/images/loader.gif">',
	'current_user_id'	=>get_current_user_id(),
	'delete_message'=> esc_html__( 'Do you want to delete the report?','epfitness'),
	'add'=> 		   esc_html__( 'Add','epfitness'),
	'setimage'=> esc_html__( 'Set Image','epfitness'),
	'edit'=> esc_html__( 'Edit','epfitness'),
	'remove'=> esc_html__( 'Remove','epfitness'),
	'settingnonce'=> wp_create_nonce("settings"),
	) );
?>