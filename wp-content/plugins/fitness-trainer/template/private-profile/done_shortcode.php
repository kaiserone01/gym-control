<?php
	$current_user = wp_get_current_user();
	$post_id='';
	if(isset($_REQUEST['id'])){
		$post_id=sanitize_text_field($_REQUEST['id']);
	}
	$post_data = get_post( $post_id );
	$day_num='';
	if(isset($_REQUEST['cday'])){
		$day_num=sanitize_text_field($_REQUEST['cday']);
	}
?>
<div class="col-sm-12 " id="training_done_button">
	<?php
		$done_status='';
		if($day_num!=''){
			$done_status=get_user_meta($current_user->ID,'_post_done_day_'.$post_id.'_'.$day_num,true);
			}else{
			$done_status=get_user_meta($current_user->ID,'_post_done_'.$post_id,true);
		}
		if($done_status=='done'){
			esc_html_e('You have successfully completed the ','epfitness').str_replace('-',' ',$post_data->post_type).'.';
		}else{ ?>
		<button type="button" onclick="done_iv();" class="btn done-training"><?php echo esc_html_e('Done','epfitness'); ?></button>
		<?php
		}
	?>
</div>
<?php
	wp_enqueue_script('iv_fitness-ar-script-done', wp_ep_fitness_URLPATH . 'admin/files/js/profile/done_shortcode.js');
	wp_localize_script('iv_fitness-ar-script-done', 'fit_data', array(
	'ajaxurl' 			=> admin_url( 'admin-ajax.php' ),
	'loading_image'		=> '<img src="'.wp_ep_fitness_URLPATH.'admin/files/images/loader.gif">',
	'current_user_id'	=>get_current_user_id(),
	'message'=> esc_html__( 'You have successfully completed the training','epfitness'),	
	'settingnonce'=> wp_create_nonce("settings"),	
	"post_id" 		: $post_id,
	"day_num" 		: $day_num,
	) );
?>	