<?php
	$post_id='';
	if(isset($_REQUEST['id'])){
		$post_id=sanitize_text_field($_REQUEST['id']);
	}
	$day_num='';
	if(isset($_REQUEST['cday'])){
		$day_num=sanitize_text_field($_REQUEST['cday']);
	}
	$current_user = wp_get_current_user();
	$roles = $current_user->roles;
	//$role = array_shift( $roles );
	$post_data = get_post( $post_id );
	$user_content= get_user_meta($current_user->ID, 'iv_user_content_setting', true);
	if($user_content==''){$user_content='both_content';}
	$have_access='0';
	if(get_post_meta( $post_id,'_ep_post_for', true )=='role'){ 
			$package_arr=get_post_meta( $post_id,'_ep_postfor_package', true);
			if(is_array($package_arr)){			
				foreach($roles as $one_role){  
					
					if(in_array(strtolower($one_role), array_map('strtolower', $package_arr) )){
						if($user_content=='both_content'  OR $user_content=='package_only'){ 
							$have_access='1';
						  }
					}
				}
				
			}
	}
	
	if(get_post_meta( $post_id,'_ep_post_for', true )=='user'){
		$user_arr= get_post_meta( $post_id,'_ep_postfor_user', true);
		if(in_array($current_user->ID, $user_arr)){
			if($user_content=='both_content'  OR $user_content=='specific_content'){
				$have_access='1';
				}else{
				$have_access='0';
			}
		}
	}
	
	if ( class_exists( 'WooCommerce' ) ) {
		if(get_post_meta( $post_id,'_ep_post_for', true )=='Woocommerce'){
			$product_arr=get_post_meta( $post_id,'_ep_postfor_woocommerce', true);
			if($user_content=='both_content'  OR $user_content=='woocommerce_content'){
				foreach($product_arr as $selected_product){
					if( wc_customer_bought_product( $current_user->email, $current_user->ID, $selected_product ) ){
						$have_access='1';
					}
				}
			}
		}
	}
	$user_role= $current_user->roles[0];
	if(isset($current_user->roles[0]) and $current_user->roles[0]=='administrator'){
		$have_access='1';
	}
	$trainer_package= get_user_meta($current_user->ID, 'trainer_package', true);
	if($trainer_package>0){
		$have_access='1';
	}
	
?>
<div class="profile-content">
	<h2> <?php echo ucwords(esc_html($post_data->post_title));?><small> <a class="btn btn-xs green-haze custom_color" href="<?php echo get_permalink($current_page_permalink);?>?&fitnessplanpdf=<?php echo esc_html($post_id);?>" type="button" target="_blank"><?php esc_html_e('Download PDF','epfitness');?>  </a> </small></h2>
	<div class="portlet-body">
		<?php
			if($have_access=='0'){
				esc_html_e('Access Denied', 'epfitness');
				}else{			
				$content = $post_data->post_content;
				$content = apply_filters('the_content', $content);
				$content = str_replace(']]>', ']]&gt;', $content);
				
				if (class_exists("\\Elementor\\Plugin")) {					
					$pluginElementor = \Elementor\Plugin::instance();
					//$content = $pluginElementor->frontend->get_builder_content_for_display($post_id,$with_css = true);	
					
				}
				
				echo do_shortcode( str_replace('[day_number]',$day_num,$content) );
			?>
			<div class="col-sm-12 " id="training_done">
				<?php
					$done_status='';
					if($day_num!=''){
						$done_status=get_user_meta($current_user->ID,'_post_done_day_'.$post_id.'_'.$day_num,true);
						}else{
						$done_status=get_user_meta($current_user->ID,'_post_done_'.$post_id,true);
					}
					$dir_done=get_option('_dir_done');
					if($dir_done==""){$dir_done='yes';}
					if($dir_done=='yes'){
						if($done_status=='done'){
							esc_html_e('You have successfully completed the course!  ','epfitness');
						}else{ ?>
						<button type="button" onclick="done_iv();" class="btn done-training"><?php echo esc_html_e('Done','epfitness'); ?></button>
						<?php
						}
					}
				?>
			</div>
			<?php
				include('comments.php');
			}
		?>
	</div>
</div>
<?php
	wp_enqueue_script('iv_fitness-ar-script-p15', wp_ep_fitness_URLPATH . 'admin/files/js/profile/single-post.js');
	wp_localize_script('iv_fitness-ar-script-p15', 'fit_p15', array(
	'ajaxurl' 			=> admin_url( 'admin-ajax.php' ),
	'loading_image'		=> '<img src="'.wp_ep_fitness_URLPATH.'admin/files/images/loader.gif">',
	'donemessage'=> esc_html__( 'You have successfully completed the training','epfitness'),
	'postid'=>$post_id,
	'daynumber'=>$day_num,
	'settingnonce'=> wp_create_nonce("settings"),
	) );
?>