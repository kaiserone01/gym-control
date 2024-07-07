<?php
	wp_enqueue_style('cubeportfolio', wp_ep_fitness_URLPATH . 'assets/cube/css/cubeportfolio.css');
	$iii=0;
	$search_user=$_REQUEST['report_for_user'];
	$report_user = get_userdata($search_user);
	$roles = $report_user->roles;
	$role = array_shift( $roles );
	$default_fields = array();
	$field_set=get_option('_ep_fitness_url_postype' );
	if($field_set!=""){
		$default_fields=get_option('_ep_fitness_url_postype' );
		}else{
		$default_fields['training-plans']='Training Plans';
		$default_fields['detox-plans']='Detox Plans';
		$default_fields['diet-plans']='Diet Plans';
		$default_fields['diet-guide']='Diet Guide';
		$default_fields['recipes']='Recipes';
	}
	foreach ( $default_fields as $field_key => $field_value ) {
		$f_cpt=$field_key;
		break;
	}
	$profile=(isset($_REQUEST['cpt_page'])?$_REQUEST['cpt_page']:$f_cpt);
	$current_post_type=	$profile;
	$args = array(
	'post_type' => $profile, 
	'post_status' => 'publish',
	'posts_per_page'=> '9999', 
	);
	$the_query = new WP_Query( $args );
	$user_content= get_user_meta($search_user, 'iv_user_content_setting', true);
	if($user_content==''){$user_content='both_content';}
	$has_access='no';
	$trainer_package= get_user_meta($current_user->ID, 'trainer_package', true);
	if($trainer_package>0){
		$has_access='yes';
	}
	if(strtoupper($crole)==strtoupper('administrator')){
		$has_access='yes';
	}
	if($has_access=='no'){
		esc_html_e('<h1>Access Denied</h1> ','epfitness');
		}else{
	?>
	<div class="profile-content portlet light">
		<div class="">
			<div class="row">
				<?php
					$argscat = array(
					'type'                     => $current_post_type,
					'orderby'                  => 'name',
					'order'                    => 'ASC',
					'hide_empty'               => true,
					'hierarchical'             => 1,
					'exclude'                  => '',
					'include'                  => '',
					'number'                   => '',
					'taxonomy'                 => $current_post_type.'-category',
					'pad_counts'               => false
					);
					$categories = get_categories( $argscat );
					if(sizeof($categories)){
					?>
					<div id="js-filters-blog-posts" class="cbp-l-filters-list cbp-l-filters-left">
            <div data-filter="*" class="cbp-filter-item-active cbp-filter-item cbp-l-filters-list-first"><?php esc_html_e('All','epfitness'); ?>  (<div class="cbp-filter-counter"></div>)</div>
            <?php
							if ( $categories && !is_wp_error( $categories ) ) :
							$i=1;
							foreach ( $categories as $term ) {	?>
							<div data-filter=".<?php echo esc_html($term->slug);?>" class="cbp-filter-item <?php echo($i==sizeof($categories)?'cbp-l-filters-list-last':'');?>"><?php echo esc_html($term->name); ?> (<div class="cbp-filter-counter"></div>)</div>
							<?php
								$i++;
							}
							endif;
						?>
					</div>
					<?php
					}
				?>
			</div>
			<div id="js-grid-blog-posts" class="cbp">
				<?php
					if ( $the_query->have_posts() ) :
					$iii=0;
					while ( $the_query->have_posts() ) : $the_query->the_post();
					if ( function_exists('icl_object_id') ) {
						$id = icl_object_id(get_the_ID(),'page',true);
						}else{
						$id = get_the_ID();
					}
					$have_access='';
					$feature_img='';
					if(has_post_thumbnail()){
						$feature_image = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'medium' );
						if($feature_image[0]!=""){
							$feature_img =$feature_image[0];
						}
						}else{
						$feature_img= wp_ep_fitness_URLPATH."/assets/images/default-directory.jpg";
					}
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
					$currentCategory=wp_get_object_terms( $id, $current_post_type.'-category');
					$cat_link='';$cat_name='';$cat_slug='';
					if(isset($currentCategory)){
						if(isset($currentCategory[0]->slug)){
							for($i=0;$i<20;$i++){
								if(isset($currentCategory[$i]->slug)){
									$cat_slug=$cat_slug.' '.(isset($currentCategory[$i]->slug) ? $currentCategory[$i]->slug :'');
								}
							}
							$cat_name = $currentCategory[0]->name;
							$cat_link= get_term_link($currentCategory[0], $current_post_type.'-category');
						}
					}
					// Check  Access
					if($have_access==1){
						$post_content = get_post($id);
					?>
					<div class="cbp-item <?php echo esc_html($cat_slug); ?> ">
						<a href="<?php echo get_permalink($current_page_permalink); ?><?php echo'?&fitprofile=post&id='.$post_content->ID;?>" class="cbp-caption">
							<div class="cbp-caption-defaultWrap">
								<div class="image-container" style="background: url('<?php echo esc_attr($feature_img);?>') center center no-repeat; background-size: cover;">
								</div>
							</div>
							<div class="cbp-caption-activeWrap">
								<div class="cbp-l-caption-alignCenter">
									<div class="cbp-l-caption-body">
										<div class="cbp-l-caption-text"><?php esc_html_e('VIEW DETAIL','epfitness'); ?> </div>
									</div>
								</div>
							</div>
						</a>
						<div class="cbp-l-grid-blog-title">
							<a href="<?php echo get_permalink($current_page_permalink); ?><?php echo'?&fitprofile=post&id='.$post_content->ID;?>" class=""><?php echo esc_html($post_content->post_title);?> </a>
						</div>
						<div class="cbp-l-grid-blog-desc">
							<a href="?&fitprofile=edit-post&postid=<?php echo esc_html($post_content->ID); ?>"><img class="plist_img" src="<?php echo wp_ep_fitness_URLPATH. "assets/images/edit.png";?>" /></a>
						</div>
					</div>
					<?php
						$iii++;
					}
					endwhile;
					endif;
				?>
			</div>
			<?php
				if($iii==0){
					esc_html_e( 'Sorry, no posts matched your criteria.','epfitness' );
				}
			?>
		</div>
	</div>
	<?php
	}
	wp_enqueue_script('cubeportfolio', wp_ep_fitness_URLPATH . 'assets/cube/js/jquery.cubeportfolio.min.js');
	wp_enqueue_script('iv_fitness-post-listing', wp_ep_fitness_URLPATH . 'admin/files/js/profile/post-listing.js');
?>