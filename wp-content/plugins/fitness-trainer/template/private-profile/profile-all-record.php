<?php
	$profile_url=get_permalink($current_page_permalink);
	global $current_user;
	$current_user = wp_get_current_user();
	$user = $current_user->ID;
	$message='';
	if(isset($_GET['delete_id']))  {
		$post_id=$_GET['delete_id'];
		$post_edit = get_post($post_id);
		if(isset($post_edit)){
			if($post_edit->post_author==$current_user->ID){
				wp_delete_post($post_id);
				delete_post_meta($post_id,true);
				$message=esc_html__('Deleted Successfully','epfitness');
			}
		}
	}
?>
<div class="profile-content">
	<div class="portlet light">
		<div class="portlet-title tabbable-line clearfix">
			<div class="caption caption-md">
				<span class="caption-subject">
					<?php
						$iv_post = 'physical-record'; 
						esc_html_e('My Records','epfitness');
					?></span>
					<span class="btn btn-xs">
						<a  class="btn btn-xs green-haze" href="<?php echo get_permalink($current_page_permalink); ?>?&fitprofile=add-record" role="button">
							<?php esc_html_e('Add New Record','epfitness');?>
						</a>
					</span>
			</div>
		</div>
		<?php
			include(  wp_ep_fitness_template. 'private-profile/record-chat.php');
		?>
		<div class="panel panel-default">
			<div class="panel-heading"><?php esc_html_e('Saved Records','epfitness'); ?>
			</div>
			<div class="panel-body">
				<?php
					if($message!=''){
						echo  '<div class="alert alert-info alert-dismissable"><a class="panel-close close" data-dismiss="alert">x</a>'.$message.'.</div>';
					}
				?>
				<div class="listing-table">
					<table class="">
						<?php
							global $wpdb;
							$per_page=200;$row_strat=0;$row_end=$per_page;
							$current_page=0 ;
							if(isset($_REQUEST['cpage']) and $_REQUEST['cpage']!=1 ){
								$current_page=$_REQUEST['cpage']; $row_strat =($current_page-1)*$per_page;
								$row_end=$per_page;
							}
							$sql=$wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_type IN ('physical-record' )  and post_author='%s' and post_status IN ('publish','pending','draft' )  ORDER BY 'ID' DESC limit %d , %d ", $current_user->ID,$row_strat,$row_end);
							$authpr_post = $wpdb->get_results($sql);
							$total_post=count($authpr_post);
							if($total_post>0){
								$i=0;
								foreach ( $authpr_post as $row )
								{
								?>
								<tr>
									<td width="20%"  class="tdtop">
										<?php $feature_image = wp_get_attachment_image_src( get_post_thumbnail_id( $row->ID), 'large' );
											if(isset($feature_image[0])){ ?>
											<a data-fancybox="gallery" href="<?php echo esc_url($feature_image[0]); ?>">
												<img title="profile image" class="img_100" src="<?php  echo esc_url($feature_image[0]); ?>">
											</a>
											<?php
												}else{
												echo'	 <img src="'. wp_ep_fitness_URLPATH.'assets/images/Blank-Profile.jpg">';
											}
										?>
										&nbsp;
									</td>
									<td width="22%" class="tdfont">
										<p> <?php esc_html_e('Date','epfitness'); ?>: <?php echo  get_post_meta($row->ID,'date',true); ?></p>
										<p> <?php esc_html_e('Week','epfitness'); ?> #: <?php echo  get_post_meta($row->ID,'week',true); ?> </p>
										<?php
											$default_fields=array();
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
											foreach ( $default_fields as $field_key => $field_value ) { ?>
											<p> <?php echo esc_html_e($field_value, 'epfitness'); ?>: <?php echo get_post_meta($row->ID,$field_key,true); ?> </p>
											<?php
												if($i==5){ ?>
												</td><td width="22%" class="tdfont">
												<?php
												}
												$i++;
											}
										?>
									</td>
									<td width="24%" class="tdfont">
										<p> <b> <?php  esc_html_e('Expert Review:','epfitness');?>  </b> </p>
										<p>
											<?php
												$content = $row->post_content; 
												$content = str_replace( ']]>', ']]&gt;', $content );
												echo  $content;
											?>
										</p>
									</td>
									<td width="12%" class="tdfont">
										<?php
											$edit_url='record';
											$edit_post= $profile_url.'?&fitprofile='.$edit_url.'-edit&post-id='.$row->ID;
										?>
										<a href="<?php echo esc_url($profile_url).'?&fitprofile='.$edit_url.'-edit&post-id='.$row->ID ;?>"  class="btn btn-success btn-xs"><?php esc_html_e('Edit','epfitness'); ?>
										</a>
										<a href="<?php echo esc_url($profile_url).'?&fitprofile=records&delete_id='.$row->ID ;?>"  onclick="return confirm('Are you sure to delete this post?');"  class="btn btn-xs btn-danger">X
										</a>
									</td>
								</tr>
								<?php
								}
								}else{
							?>
							<tr>
								<td colspan="100%">
									<?php esc_html_e('Currently you have no data added. Please manage your account from the sidebar on the left.','epfitness'); ?>
								</td>
							</tr>
							<?php
							}
						?>
					</table>
				</div>
				<div class="center">
					<?php
						$sql2=$wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_type IN ('physical-record' )  and post_author='%s' and post_status IN ('publish' ) ", $current_user->ID );
						$authpr_post2 = $wpdb->get_results($sql2);
						$total_post=count($authpr_post2);
						$total_page= $total_post/$per_page;
						$total_page=ceil( $total_page);
						$current_page =($current_page==''? '1': $current_page );
						echo ' <ul class="iv-pagination">';
						for($i=1;$i<= $total_page;$i++){
							echo '<li class="list-pagi '.($i==$current_page  ? 'active-li': '').'"><a href="'.get_permalink($current_page_permalink).'?&fitprofile=all-records&cpage='.$i.'"> '.$i.'</a></li>';
						}
						echo'</ul>';
					?>
				</div>
			</div>
		</div>
	</div>
</div>