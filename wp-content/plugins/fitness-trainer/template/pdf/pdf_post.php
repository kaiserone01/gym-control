<?php
	if(isset($_REQUEST['fitnessplanpdf'])){ 
		global $html_pdf;
		global $current_user;
		$pdfpost_id='';$footer_html='';$header='';
		$current_lang="en";
		$lang=get_bloginfo("language");
		$language_array= explode("-",$lang);
		if(isset($language_array[0])){
			$current_lang=$language_array[0];
		}
		ob_clean();
		require_once( wp_ep_fitness_ABSPATH. 'inc/vendor/autoload.php');
	  $epfit_margin_left = '15';
		$epfit_margin_right ='15';
		$epfit_margin_top = '60';
		$epfit_margin_bottom = '30';
		$epfit_margin_header = '15';
		$mpdf_config = apply_filters('epfit_mpdf_config',[              
		'format'            => 'A4',
		'margin_left'       => $epfit_margin_left,
		'margin_right'      => $epfit_margin_right,
		'margin_top'        => $epfit_margin_top,
		'margin_bottom'     => $epfit_margin_bottom,
		'margin_header'     => $epfit_margin_header,        
		]);
		$mpdf = new \Mpdf\Mpdf( $mpdf_config );
		$footer_html='';
		if(isset($_REQUEST['fitnessplanpdf'])){ $pdfpost_id=sanitize_text_field($_REQUEST['fitnessplanpdf']); $postid=$pdfpost_id;}
		$postid=$pdfpost_id;	
		$post_id=$postid;
		$have_access='0';
		$current_userID= $current_user->ID;
		$roles = $current_user->roles;
		$role = array_shift( $roles );
		$post_author_id = get_post_field( 'post_author', $postid );
		$user_content= get_user_meta($current_user->ID, 'iv_user_content_setting', true);
		if($user_content==''){$user_content='both_content';}
		if(get_post_meta( $post_id,'_ep_post_for', true )=='role'){  
			$package_arr=get_post_meta( $post_id,'_ep_postfor_package', true);
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
		if(isset($current_user->roles[0]) and $current_user->roles[0]=='administrator'){
			$have_access='1';				
		}
		$trainer_package= get_user_meta($current_user->ID, 'trainer_package', true);	
		if($trainer_package>0){ 
			$have_access='1';
		}
		if($have_access=='0'){ 
			die('Access denied');
		}
		//***********End Access Check****************
		global $current_user;
		$post_data = get_post($postid ); 
		$display_name=$current_user->display_name;
		$name_display=get_user_meta($current_user->ID,'first_name',true).' '.get_user_meta($current_user->ID,'last_name',true);
		if(trim($name_display)==''){$display_name=$current_user->display_name;}
		$epfitness_report_title1 =ucwords($post_data->post_title); 
		$epfitness_report_title2 ='';
		$footer_html=''.get_bloginfo();
		$header = '<body style="font-family: HelveticaNeueLT-BlackCond;">
		<h2> <font color=""> '.$epfitness_report_title1.' </font> <font color=""> '.$epfitness_report_title2.' </font></h2>
		<table border: 0px solid black;>
		<tr style="padding-top: 50px;">
		<td width="10%"> <h4> <font> '. esc_html__( 'Client Name','epfitness').' </font></h4>
		</td>
		<td width="2%">:</td>
		<td width="40%">
		<h4> <font > '.ucwords($display_name).' </font></h4>
		</td>	
		</tr>
		<tr style="padding-top: 50px;">
		<td width="10%"> <h4> <font >  '. esc_html__( 'Date','epfitness').' </font></h4>
		</td>
		<td width="2%">:</td>
		<td width="40%">
		<h4> <font > '. date( 'd M Y' ) .' </font></h4>
		</td>	
		</tr>
		</table>
		<img src="'.wp_ep_fitness_URLPATH.'/assets/images/reporttop2.png">
		';
		$day_num='';
		$content = $post_data->post_content;
		$content = apply_filters('the_content', $content);
		$content = str_replace(']]>', ']]&gt;', $content);
		$content = str_replace('[day_number]',$day_num,$content);
		$i=1;
		$content = do_shortcode($content) ;
		$html_pdf=$content;
		$stylesheet = file_get_contents(wp_ep_fitness_URLPATH . 'admin/files/css/pdf.css');
		$mpdf->setFooter(''.$footer_html.', Page # {PAGENO}');
		$mpdf->SetHTMLHeader($header);
		$mpdf->WriteHTML($stylesheet,1); 
		$mpdf->WriteHTML($html_pdf);
		$mpdf->Output();
		exit;
	}
?>