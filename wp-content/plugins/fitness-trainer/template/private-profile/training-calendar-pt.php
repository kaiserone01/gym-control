<?php
	$search_user=$_REQUEST['report_for_user'];
	$report_user = get_userdata($search_user);
	$roles = $report_user->roles;
	$role = array_shift( $roles );
	$default_fields = array();
	$field_set=get_option('_ep_fitness_url_postype' );
	$li_data='';
	$profile=(isset($_REQUEST['cpt_page'])? $_REQUEST['cpt_page']:'');
	$paged='1';
	$args = array(
	'post_type' => $profile, 
	'paged' => $paged,
	'post_status' => 'publish',
	'posts_per_page'=> '99999', 
	);
	$the_query = new WP_Query( $args );
	$user_content= get_user_meta($search_user, 'iv_user_content_setting', true);
	if($user_content==''){$user_content='both_content';}
	$fitness_calendar_days=get_option('fitness_calendar_days');
	if($fitness_calendar_days==""){$fitness_calendar_days='30';}
?>
<div class="profile-content">
	<div class="row">
    <div class="col-md-12 ">
			<div class="plan-content">
				<ul class="training-calendar"><?php
					$no=(int)$fitness_calendar_days;
					$ii=1;
					for($i=1;$i<=$no;$i++){
						if ( $the_query->have_posts() ) :
						$li_data='';
						while ( $the_query->have_posts() ) : $the_query->the_post();
						if ( function_exists('icl_object_id') ) {
							$id = icl_object_id(get_the_ID(),'page',true);
							}else{
							$id = get_the_ID();
						}
						$have_access='';
						if(get_post_meta( $id,'_ep_post_for', true )=='role'){
							$package_arr=get_post_meta( $id,'_ep_postfor_package', true);
							if(is_array($package_arr)){
								if(in_array(strtolower($role), array_map('strtolower', $package_arr) )){
									if($user_content=='both_content'  OR $user_content=='package_only'){
										$have_access='1';
										}else{
										$have_access='0';
									}
								}
							}
						}
						if(get_post_meta( $id,'_ep_post_for', true )=='user'){
							$user_arr= array();
							if(get_post_meta( $id,'_ep_postfor_user', true )!=''){$user_arr=get_post_meta( $id,'_ep_postfor_user', true ); }
							if(is_array($user_arr)){
								if(in_array($report_user->ID, $user_arr)){
									if($user_content=='both_content'  OR $user_content=='specific_content'){
										$have_access='1';
										}else{
										$have_access='0';
									}
								}
							}
						}
						if ( class_exists( 'WooCommerce' ) ) {
							if(get_post_meta( $id,'_ep_post_for', true )=='Woocommerce'){
								$product_arr= array();
								if(get_post_meta( $id,'_ep_postfor_woocommerce', true )!=''){$product_arr=get_post_meta( $id,'_ep_postfor_woocommerce', true ); }
								if($user_content=='both_content'  OR $user_content=='woocommerce_content'){
									foreach($product_arr as $selected_product){
										if( wc_customer_bought_product( $report_user->user_email, $report_user->ID, $selected_product ) ){
											$have_access='1';
										}
									}
								}
							}
						}
						if($have_access=='1'){
							$day_arr=array();
							$day_arr= explode(",",trim(get_post_meta( $id,'_ep_user_day_number', true )));
							if(sizeof($day_arr)<2){
								if(isset($day_arr[0]) and $day_arr[0]==""){
									$day_arr[0]='1';
								}
							}
							if(in_array($i, $day_arr)){
								$done_status='';
								$done_status=get_user_meta($report_user->ID,'_post_done_day_'.$id.'_'.$i,true);
								$done_image='';
								if($done_status=='done'){
									$done_image='<img class="tc_img" src="'.wp_ep_fitness_URLPATH.'assets/images/done.png" />';
									$li_color='done';
									}else{
									$done_image='<img class="tc_img" src="'.wp_ep_fitness_URLPATH.'assets/images/not-done.png" />';
								}
								$post_content = get_post($id);
								$li_data=$li_data.' <h4>'.$done_image.'<a href="'. get_permalink($current_page_permalink).'?&fitprofile=post&id='.$post_content->ID.'&cday='.$i.'">'.substr($post_content->post_title,0,50).'</a><a href="'. get_permalink($current_page_permalink).'?&fitprofile=edit-post&postid='.$post_content->ID.'"><img class="tc_img2" src="'.wp_ep_fitness_URLPATH. "assets/images/edit.png".'" /></a></h4>';
							}
						}
						endwhile;
						endif;
						if($li_data!=''){
							$li_color=($ii%2==0 ? 'even': 'odd');
							echo '<li class="'.$li_color.'"><h5>'. esc_html__( 'Day', 'epfitness').' '.$i.'</h5>';
							echo do_shortcode($li_data);
							echo'</li>';
							$ii=$ii+1;
						}
					}
				?>
				</ul>
				<?php
					if($ii==1){
						esc_html_e( 'Sorry, no posts matched your criteria.','epfitness' );
					}
				?>
			</div>
		</div>
	</div>
</div>