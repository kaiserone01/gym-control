<?php
	if(isset($_REQUEST['fitnesspdf'])){ 
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
		require ( wp_ep_fitness_ABSPATH. 'inc/vendor/autoload.php');
		
		
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
		
		//$mpdf =  new mPDF($mpdf_config); ///this is working woocommerce plugin 1
		
		
		$footer_html='';
		if(isset($_REQUEST['fitnesspdf'])){ $pdfpost_id=sanitize_text_field($_REQUEST['fitnesspdf']); $postid=$pdfpost_id;}
		$postid=$pdfpost_id;	
		// Check access****************
		$has_access='no';
		$current_userID= get_current_user_id();
		$post_author_id = get_post_field( 'post_author', $postid );
		$user_for=get_post_meta($postid,'report_for_user',true);
		if($current_userID ==$user_for || $current_userID==$post_author_id){
			$has_access='yes';
		}
		if(isset($current_user->roles[0]) and $current_user->roles[0]=='administrator'){
			$has_access='yes';					
		}
		$trainer_package= get_user_meta($current_user->ID, 'trainer_package', true);	
		if($trainer_package>0){
			$has_access='yes';
		}
		if($has_access=='no'){
			die('Access denied');
		}
		//***********End Access Check****************
		$con_user=get_post_meta($postid,'report_for_user',true);
		$client_user = get_userdata((int)$con_user);
		$display_name=$client_user->user_nicename;
		$name_display=get_user_meta($con_user,'first_name',true).' '.get_user_meta($con_user,'last_name',true);
		if(trim($name_display)==''){$display_name=$client_user->user_nicename;}
		$epfitness_report_title1 =(get_option('epfitness_report_title1')==''?"FITNESS": get_option('epfitness_report_title1'));
		$epfitness_report_title2 =(get_option('epfitness_report_title2')==''?"REPORT":get_option('epfitness_report_title2') );
		$footer_html=''.get_bloginfo();
		$header = '<body style="font-family: HelveticaNeueLT-BlackCond;">
		<h2> <font color="#19b5fe"> '.$epfitness_report_title1.' </font> <font color="#f6821f"> '.$epfitness_report_title2.' </font></h2>
		 
		<table border: 0px solid black; >
		<tr style="padding-top: 50px;">
		<td width="10%"> <h4> <font> '. esc_html__( 'Client Name','epfitness').' </font></h4>
		</td>
		<td width="2%">:</td>
		<td width="40%">
		<h4> <font > '.$display_name.' </font></h4>
		</td>	
		</tr>
		<tr style="padding-top: 50px;">
		<td width="10%"> <h4> <font >  '. esc_html__( 'Date','epfitness').' </font></h4>
		</td>
		<td width="2%">:</td>
		<td width="40%">
		<h4> <font > '. date( 'd M Y', strtotime(nl2br(get_post_meta($postid,'report_date',true)))  ) .' </font></h4>
		</td>	
		</tr>
		</table>
		<img src="'.wp_ep_fitness_URLPATH.'/assets/images/reporttop2.png"></body>
		';
		$default_fields = array();
		$field_set=get_option('ep_fitness_report_fields' );					
		if($field_set!=""){ 
			$default_fields=get_option('ep_fitness_report_fields' );
			}else{															
			$default_fields['goals']='Goals';
			$default_fields['reportsummary']='Report Summary';
			$default_fields['in_short']='In Short';
			$default_fields['weight_related_goals']='Weight related goals';
			$default_fields['fitness_related_goals']='Fitness related goals';
			$default_fields['blood_pressure']='Blood pressure';
			$default_fields['Other_notes']='Other notes';
			$default_fields['commit_suggestions']='We agreed you commit to the following suggestions:';
			$default_fields['Nutrition']='Nutrition';
			$default_fields['Hydration']='Hydration';
			$default_fields['Exercise_and_activity']='Exercise and activity';
			$default_fields['Other_consumables ']='Other consumables';
			$default_fields['Sleep']='Sleep';
			$default_fields['Rest']='Rest';
			$default_fields['focus_following_areas']='We agreed that you focus on the following area';
			$default_fields['following_weekly_plan']='We agreed to the following overall/weekly plan';
			$default_fields['motivation1']='You highlighted the following main challenges you face in committing to the above plan';
			$default_fields['motivation2']='We agreed on the following strategies for overcoming these challenges';		
		}
		$i=1;
		$html_pdf='
		<table  class="tableContainer" style="border-collapse: collapse;width:100%;"   ><tbody>';	
		foreach ( $default_fields as $field_key => $field_value ) {		
			$html_pdf=$html_pdf.'	
			<tr '.($i % 2 == 0? '':'bgcolor="#EEEEEE"').'>
			<th scope="row" style="text-align: left;width:50%">'.$field_value .'</th>
			<td scope="row" style="text-align: left;width:50%">'. nl2br(get_post_meta($postid,$field_key,true)).'</td>			 		
			</tr>		
			';
			$i++;
		}
	
		$html_pdf=$html_pdf.'</tbody></table>';
		$stylesheet = file_get_contents(wp_ep_fitness_URLPATH . 'admin/files/css/pdf.css');
		$mpdf->SetHTMLHeader($header);
		$mpdf->setFooter(''.$footer_html.', Page # {PAGENO}');
		
		$mpdf->WriteHTML($stylesheet,1); 
		$mpdf->WriteHTML($html_pdf);
	
		$mpdf->Output();
		exit;
	}
?>