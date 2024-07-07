<?php
	wp_enqueue_style('wp-ep_fitness-style-11', wp_ep_fitness_URLPATH . 'admin/files/css/iv-bootstrap.css');
	wp_enqueue_style('user-dir-style', wp_ep_fitness_URLPATH .'admin/files/css/user-directory.css');
	wp_enqueue_style('front-end', wp_ep_fitness_URLPATH . 'admin/files/css/front-end.css');
	wp_enqueue_style('all', wp_ep_fitness_URLPATH . 'admin/files/css/all.min.css');
	wp_enqueue_script('ep_fitness-userdir', wp_ep_fitness_URLPATH . 'admin/files/js/userdir.js');
	global $wpdb;
	$package ='';
	if(isset($_REQUEST['package_sel'])){
		$package = sanitize_text_field($_REQUEST['package_sel']);
	}
	if($package==''){
		if(isset($_REQUEST['package'])){
			$package=sanitize_text_field($_REQUEST['package']);
		}
	}
	$search_user='';
	if(isset($_POST['search_user'])){
		$search_user = sanitize_text_field($_POST['search_user']);
	}
?>
<div id="directory-temp" class="bootstrap-wrapper user-directory-content">
	<div class="main clearfix directory-option row">
		<div class="row">
			<form class="dd col-md-6 col-sm-7"   action="<?php echo the_permalink(); ?>" method="post"  >
				<span class="pull-left sort-by"><?php esc_html_e('Sort By:','epfitness');	 ?>  </span>
				<div class="row">
					<select id="package_sel" name="package_sel" class="form-control-solid" >
						<?php
							$ep_fitness_pack='ep_fitness_pack';
							$sql=$wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_type = '%s'  and post_status='draft' " ,$ep_fitness_pack);
							$membership_pack = $wpdb->get_results($sql);
							echo'<option value="">All</option>';
							foreach ( $membership_pack as $row ){
								echo'<option value="'.esc_html($row->ID).'"  '.($package==$row->ID ? " selected" : " ") .' >'.esc_html($row->post_title).'</option>';
							}
						?>
					</select >
				</div>
			</form>
			<form class="dd col-md-6 col-sm-5"   action="<?php echo the_permalink(); ?>" method="post"  >
				<div class="search-username">
					<input type="text" name="search_user" id="search_user" class="form-control-solid" value="<?php echo esc_html($search_user); ?>">
					<button class="submit"><i class="fa fa-search"></i></button>
					<input type="hidden" name="package_hidden" id="package_hidden" value="<?php echo esc_html($package); ?>">
				</div>
			</form>
		</div>
	</div>
	<section class="main">
		<ul class="ch-grid">
			<?php
				if(isset($atts['per_page'])){
					$no=$atts['per_page'];
					}else{
					$no=12;
				}
				$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
				if($paged==1){
					$offset=0;
					}else {
					$offset= ($paged-1)*$no;
				}
				$args = array();
				$args['number']=$no;
				$args['offset']=$offset;
				$args['orderby']='registered';
				$args['order']='DESC';
				if($package!=''){
					$role_package= get_post_meta( $package,'ep_fitness_package_user_role',true);
					$args['role']=$role_package;
				}
				if($search_user!=''){
					$args['search']='*'.$search_user.'*';
				}
				$iv_redirect_user = get_option( '_ep_fitness_profile_public_page');
				$reg_page_user='';
				if($iv_redirect_user!='defult'){
					$reg_page_user= get_permalink( $iv_redirect_user) ;
				}
				if(isset($atts['role'])){
					$args['role']=$atts['role'];
				}
				$user_query = new WP_User_Query( $args );
				if ( ! empty( $user_query->results ) ) {
					foreach ( $user_query->results as $user ) {
						if (isset($user->wp_capabilities['administrator'])!=1 ){
							$iv_profile_pic_url=get_user_meta($user->ID, 'iv_profile_pic_url',true);
							$reg_page_u=$reg_page_user.'?&id='.$user->ID; 
						?>
						<li>
							<div class="ch-item">
								<a href="<?php echo esc_url($reg_page_u); ?>">
									<?php
										if($iv_profile_pic_url!=''){ ?>
										<img src="<?php echo esc_url($iv_profile_pic_url); ?>" class="home-img wide tall">
										<?php
											}else{
											echo'	 <img src="'. wp_ep_fitness_URLPATH.'assets/images/Blank-Profile.jpg" class="home-img wide tall">';
										} ?>
										<div class="ch-info">
										</div>
								</a>
							</div>
							<p class="para text-center">
								<?php
									if(get_user_meta($user->ID,'twitter',true)!=''){
									?>
									<a href="www.twitter.com/<?php  echo get_user_meta($user->ID,'twitter',true);  ?>/">
										<i class="fa fa-twitter"></i>
									</a>
									<?php
									}
									if(get_user_meta($user->ID,'linkedin',true)!=''){
									?>
									<a href="www.linkedin.com/<?php  echo get_user_meta($user->ID,'linkedin',true);  ?>/">
										<i class="fa fa-linkedin"></i>
									</a>
									<?php
									}
									if(get_user_meta($user->ID,'facebook',true)!=''){
									?>
									<a href="www.facebook.com/<?php  echo get_user_meta($user->ID,'facebook',true);  ?>/">
										<i class="fa fa-facebook"></i>
									</a>
									<?php
									}
									if(get_user_meta($user->ID,'gplus',true)!=''){
									?>
									<a href="www.plus.google.com/<?php  echo get_user_meta($user->ID,'gplus',true);  ?>/">
										<i class="fa fa-google-plus"></i>
									</a>
									<?php
									}
								?>
							</p>
							<a href="<?php echo esc_url($reg_page_u); ?>">
								<h5 class="text-center"><?php echo esc_html($user->display_name); ?></h5>
							</a>
							<p class="para1 text-center">
								<?php  	if(get_user_meta($user->ID,'occupation',true)==!""){
									echo get_user_meta($user->ID,'occupation',true);
								}
								}
							}
							} else {
							esc_html_e( 'No users found', 'epfitness' );
						}
					?>
				</ul>
			</section>
			<div class="text-center">
				<?php
					$total_user = $user_query->total_users;
					$total_pages=ceil($total_user/$no);
					echo '<div id="iv-pagination" class="iv-pagination">';
					echo paginate_links( array(
					'base' =>  '%_%'.'?&package='.$package, 
					'prev_text' => esc_html__( '&laquo; Previous', 'epfitness' ), 
					'next_text' => esc_html__( 'Next &raquo;', 'epfitness' ),
					'total' => $total_pages, 
					'current' => $paged, 
					'end_size' => 1,
					'mid_size' => 5,
					));
					echo '</div>';
				?>
			</div>			
</div>