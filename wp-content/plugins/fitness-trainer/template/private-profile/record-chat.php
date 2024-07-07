<?php
	wp_enqueue_style('wp-ep_fitness-report-11', wp_ep_fitness_URLPATH . 'admin/files/css/report/normalize.css');
	wp_enqueue_script('amcharts', wp_ep_fitness_URLPATH . 'admin/files/js/amcharts.js');
	global $wpdb;
	$default_fields =array();
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
	$chart_for='weight';
	if(isset($_REQUEST['chart_for'])){
		$chart_for=sanitize_text_field($_REQUEST['chart_for']);
	}
	$user_chart= array();
	$user_chart_string='';
	$args = array(
	'post_type' => 'physical-record', 
	'posts_per_page'=> '999',  
	'orderby' => 'date',
	'order' => 'ASC',
	);
	$args['author']=$current_user->ID;
	$i=0;
	$the_query = new WP_Query( $args );
	if ( $the_query->have_posts() ) :
	while ( $the_query->have_posts() ) : $the_query->the_post();
	$id = get_the_ID();
	if(get_post_meta($id,'date',true)!=""){
		$user_chart[$i]['udate']=date('Y-m-d',strtotime(get_post_meta($id,'date',true)));
		foreach ( $default_fields as $field_key => $field_value ) {
			if($field_key==$chart_for){
				$user_chart[$i]['value']= get_post_meta($id,$field_key,true);
			}
		}
		$i++;
	}
	endwhile;
	endif;
	$user_chart_string= $user_chart;
?>
<div class="row record_chat">
	<div class="col-md-12" class="rcmgtp20">
		<form id="chartfor" name="chartfor" method="post" >
			<div class="col-md-3">  <?php esc_html_e('Chart For','epfitness'); ?>  </div>
			<div class="col-md-9">
				<select class="form-control"  name="chart_for" id="chart_for" >
					<?php
						foreach ( $default_fields as $field_key => $field_value ) { ?>
						<option value="<?php echo esc_html($field_key);?>" <?php echo($chart_for==$field_key?' selected':'');?>><?php echo esc_html($field_value) ;?></option>
						<?php
						}
					?>
				</select>
			</div>
		</form>	
	</div>
	<div class="col-md-12">
		<div id="chart-line" class="mapbackground-color"  ></div>
	</div>
</div>
<?php	
	wp_enqueue_script('ep-record-chat', wp_ep_fitness_URLPATH . 'admin/files/js/profile/record-chat.js');
	wp_localize_script('ep-record-chat', 'recordfit_data', array(
	'ajaxurl' 			=> admin_url( 'admin-ajax.php' ),
	'imagepath'		=> wp_ep_fitness_URLPATH.'admin/files/images/',
	'user_chart_string'	=> $user_chart_string ,
	
	) );
?>	