<?php
	wp_enqueue_style('wp-ep_fitness-piblic-11', wp_ep_fitness_URLPATH . 'admin/files/css/iv-bootstrap.css');
	wp_enqueue_style('pricing_table_one_css', wp_ep_fitness_URLPATH . 'admin/files/css/pricing-table.css');
	global $wpdb, $post;
	$currencies = array();
	$currencies['AUD'] ='$';$currencies['CAD'] ='$';
	$currencies['EUR'] ='€';$currencies['GBP'] ='£';
	$currencies['JPY'] ='¥';$currencies['USD'] ='$';
	$currencies['NZD'] ='$';$currencies['CHF'] ='Fr';
	$currencies['HKD'] ='$';$currencies['SGD'] ='$';
	$currencies['SEK'] ='kr';$currencies['DKK'] ='kr';
	$currencies['PLN'] ='zł';$currencies['NOK'] ='kr';
	$currencies['HUF'] ='Ft';$currencies['CZK'] ='Kč';
	$currencies['ILS'] ='₪';$currencies['MXN'] ='$';
	$currencies['BRL'] ='R$';$currencies['PHP'] ='₱';
	$currencies['MYR'] ='RM';$currencies['AUD'] ='$';
	$currencies['TWD'] ='NT$';$currencies['THB'] ='฿';
	$currencies['TRY'] ='TRY';	$currencies['CNY'] ='¥';
	$currencies['INR'] ='₹';
	$currencyCode= get_option('_ep_fitness_api_currency');
	$currencyCode=(isset($currencies[$currencyCode]) ? $currencies[$currencyCode] :$currencyCode );
	$args = array(
	'post_type' => 'ep_fitness_pack', 
	'post_status' => 'draft',
	'posts_per_page'=> '200',  
	'orderby'       => 'meta_value',
	'meta_key'      => 'ep_fitness_display_order',
	'order'          => 'ASC',
	);
	$the_query = new WP_Query( $args );
	$total_package=$the_query->found_posts;
	if($the_query->found_posts>0){
		if($total_package==1 || $total_package==2){
			$window_ratio='33.33';
			}else{
			$window_ratio= 100/$total_package;
		}
	}
	$color_setting=get_option('_dir_color');
	if($color_setting==""){$color_setting='#bfbfbf';}
	$color_setting=str_replace('#','',$color_setting);
?>
<style>
	ul .submit-btn a{
	background-color: #<?php echo esc_html($color_setting); ?>;
	}
</style>
<div class="bootstrap-wrapper pricing-table-content">
	<div class="container">
	<div class="text-center row">
		<?php
			 esc_html__( 'Month' ,'epfitness');
			 esc_html__( 'Week' ,'epfitness');
			 esc_html__( 'Day' ,'epfitness');
			 esc_html__( 'year' ,'epfitness');
			$membership_pack = $the_query->posts;
			$iv_gateway = get_option('ep_fitness_payment_gateway');
			if($iv_gateway=='woocommerce'){
				$api_currency= get_option( 'woocommerce_currency' );
				$currencyCode= get_woocommerce_currency_symbol( $api_currency );
			}
			if($the_query->found_posts>0){
				$page_name_reg=get_option('_ep_fitness_registration' );
				$feature_max=0;
				foreach ( $membership_pack as $row5 )
				{
					$feature_arr = array_filter(explode("\n", $row5->post_content));
					$last_li_no=sizeof($feature_arr);
					if($last_li_no > $feature_max){
						$feature_max=$last_li_no;
					}
				}
				$i=0;
				$pt=0;
				foreach ( $membership_pack as $row )
				{
					$recurring_text='  ';
					if(get_post_meta($row->ID, 'ep_fitness_package_cost', true)=='0' or get_post_meta($row->ID, 'ep_fitness_package_cost', true)==""){
						$amount=  esc_html__( 'Free','epfitness');
						}else{
						$amount= $currencyCode.' '. get_post_meta($row->ID, 'ep_fitness_package_cost', true);
					}
					$recurring= get_post_meta($row->ID, 'ep_fitness_package_recurring', true);
					if($recurring == 'on'){
						$amount= $currencyCode.' '. get_post_meta($row->ID, 'ep_fitness_package_recurring_cost_initial', true);
						$count_arb=get_post_meta($row->ID, 'ep_fitness_package_recurring_cycle_count', true);
						if($count_arb=="" or $count_arb=="1"){
							$recurring_text= esc_html__( ' Per ' ,'epfitness').' '. esc_html__( get_post_meta($row->ID, 'ep_fitness_package_recurring_cycle_type', true),'epfitness');
							}else{
							$recurring_text= esc_html__( ' Per ' ,'epfitness').$count_arb.' '. esc_html__( get_post_meta($row->ID, 'ep_fitness_package_recurring_cycle_type', true).'s' ,'epfitness');
						}
						}else{
						$recurring_text=' &nbsp; ';
					}
					if($i>3){
						$pt=0;
					}
					$pt++;
					?>
					<div class="col-md-4">
					<ul id="pt<?php echo esc_html($pt);?>" >
						<li>
							<h2><?php echo strtoupper($row->post_title); ?></h2>
							<h3><?php echo esc_html($amount); ?><span><?php echo esc_html($recurring_text); ?></span></h3>
							<ul>
								<?php
									$row->post_content;
									$ii=0;
									$feature_all = explode("\n", $row->post_content);
									$last_li_no=sizeof($feature_all);
									foreach($feature_all as $feature){
										if(trim($feature)!=""){
											echo '<li class=" '.($ii == 0 ? 'first' : ''). ($ii == $last_li_no ? 'last' : ''). ($ii %2== 0 ? ' even' : ' odd').'">'.$feature.'</li>';
											$ii++;
										}
									}
									if($feature_max > $ii){
										while ($ii < $feature_max) {
											echo '<li class=" '.($ii == 0 ? 'first' : ''). ($ii == $feature_max ? 'last' : ''). ($ii %2== 0 ? ' even' : ' odd').'">&nbsp; </li>';
											$ii++;
										}
									}
								?>
							</ul>
							<div class="submit-btn"> <a href="<?php echo get_page_link($page_name_reg).'?&package_id=	'.$row->ID ; ?>"><?php  esc_html_e('Sign up','epfitness');?></a> </div>
						</li>
					</ul>
					</div><?php
					$i++;
				}
			}
		?>
	</div>
	</div>	
</div>
	<?php
	wp_enqueue_script('iv_property-script-pricing-table', wp_ep_fitness_URLPATH . 'admin/files/js/pricing-table.js');	
?>	
