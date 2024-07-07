<?php 



//STORE CLASS START //



class MJ_gmgt_store

{	

	//PRODUCT ENTRY RECORD//

	public function MJ_gmgt_get_entry_records($data)

	{

		$all_income_entry=$data['product_id'];

		$all_income_quentity=$data['quentity'];

		$entry_data=array();

		$i=0;

		foreach($all_income_entry as $one_entry)

		{

			$entry_data[]= array('entry'=>$one_entry,'quentity'=>$all_income_quentity[$i]);

			$i++;

		}

		return json_encode($entry_data);

	}

	//-------SELL PRODUCT----------------//

	public function MJ_gmgt_sell_product($data)

	{

		global $wpdb;

		$table_sell = $wpdb->prefix. 'gmgt_store';

		$table_income=$wpdb->prefix.'gmgt_income_expense';

		$table_product = $wpdb->prefix. 'gmgt_product';

		$entry_value=$this->MJ_gmgt_get_entry_records($data);

		$storedata['member_id']=sanitize_text_field($data['member_id']);		

		$storedata['entry']=$entry_value;

		if(!empty($data['sell_date']))

		{

			$storedata['sell_date']=MJ_gmgt_get_format_for_db(sanitize_text_field($data['sell_date']));

		}

		else

		{

			$storedata['first_payment_date']="0000-00-00";

		}

		$storedata['tax']=0;

		if(isset($data['tax']))
		{

			$storedata['tax']=implode(",",(array)$data['tax']);

		}
		else
		{

			$storedata['tax_id']=null;

		}

		$storedata['sell_by']=get_current_user_id();

		if($data['action']=='edit')

		{

		   //add old quentiy

			$all_income_entry=sanitize_text_field($data['old_product_id']);

			$all_income_quentity=sanitize_text_field($data['old_quentity']);

			if(!empty($all_income_entry))

			{

				$i=0;

				foreach($all_income_entry as $oldentry)

				{

					$product_id=$oldentry;

					$quentity=$all_income_quentity[$i];

					$obj_product=new MJ_gmgt_product;

					$product = $obj_product->MJ_gmgt_get_single_product($product_id);

					//	remainig_quentiy					

					$before_quentity=$product->quentity;

					$remainig_quentiy=$before_quentity+$quentity;

					$productdata['quentity']=$remainig_quentiy;

					$productid['id']=$product->id;

					$wpdb->update( $table_product, $productdata ,$productid); 
		
					$i++;

				}

			}

			$entry_valuea=json_decode($entry_value);

			$amount=0;

			foreach($entry_valuea as $entry_valueb)

			{

				$product_id=$entry_valueb->entry;

				$quentity=$entry_valueb->quentity;

				$obj_product=new MJ_gmgt_product;

				$product = $obj_product->MJ_gmgt_get_single_product($product_id);

				$price=$product->price;

				$amount+= $quentity * $price;				

				//	remainig_quentiy					

				$before_quentity=$product->quentity;

				$remainig_quentiy=$before_quentity-$quentity;

				$productdata['quentity']=$remainig_quentiy;

				$productid['id']=$product->id;

				$wpdb->update( $table_product, $productdata ,$productid); 				

			}			

			if(!empty($data['discount']))

			{

			  $discount=$data['discount'];

			}

			else

			{

			   $discount=0;

			}

			if($discount>$amount)

			{

				$alert_amount='3';

				return $alert_amount;

			}

			$total_after_discount_amount= $amount - $discount;

			if(!empty($data['tax']))

			{

				$total_tax=0;

				foreach($data['tax'] as $tax_id)

				{

					$tax_percentage=MJ_gmgt_tax_percentage_by_tax_id($tax_id);

					$tax_amount=$total_after_discount_amount * $tax_percentage / 100;

					$total_tax=$total_tax + $tax_amount;				

				}

				$total_amount_withtax=$total_after_discount_amount + $total_tax;

			}

			else

			{

				$total_tax=0;			

				$total_amount_withtax=$total_after_discount_amount + $total_tax;

			}

			$storedata['discount']=sanitize_text_field($data['discount']);

			$storedata['amount']=$amount;

			$storedata['total_amount']=$total_amount_withtax;



			$paid_amount=$data['paid_amount'];			



			if($paid_amount >= $total_amount_withtax)



			{



				$status='Fully Paid';



			}



			elseif($paid_amount > 0)



			{



				$status='Partially Paid';



			}



			else



			{



				$status= 'Unpaid';	



			}



			$storedata['payment_status']=$status;



			$sellid['id']=sanitize_text_field($data['sell_id']);



			$result1=$wpdb->update( $table_sell, $storedata ,$sellid);



			$user_data = get_userdata($data['member_id']);



			gym_append_audit_log(''.esc_html__('Sell Product Updated','gym_mgt').' ('.$user_data->display_name.')',$data['sell_id'],get_current_user_id(),'edit',$_REQUEST['page']);



		  //---------edit Entry into income invoice------------				



			$table_income=$wpdb->prefix.'gmgt_income_expense';



			$incomedata['entry']=$entry_value;



			$incomedata['supplier_name']=sanitize_text_field($data['member_id']);



			$incomedata['invoice_date']=MJ_gmgt_get_format_for_db(sanitize_text_field($data['sell_date']));



			$incomedata['receiver_id']=get_current_user_id();



			$incomedata['amount']=$amount;



			$incomedata['discount']=sanitize_text_field($data['discount']);



			$incomedata['tax']=0;



			if(isset($data['tax']))



			{



				$incomedata['tax_id']=implode(",",$data['tax']);



			}



			$incomedata['total_amount']=$total_amount_withtax;



			$incomedata['payment_status']=$status;



			$invoice_no['invoice_no']=sanitize_text_field($data['invoice_number']);



			$result=$wpdb->update( $table_income, $incomedata ,$invoice_no);



			return $result;



		}



		else



		{		



               $discount=0;	



			   //invoice number generate



				$result_invoice_no=$wpdb->get_results("SELECT * FROM $table_income");						



				



				if(empty($result_invoice_no))



				{							



					$invoice_no='00001';



				}



				else



				{							



					$result_no=$wpdb->get_row("SELECT invoice_no FROM $table_income where invoice_id=(SELECT max(invoice_id) FROM $table_income)");



					$last_invoice_number=$result_no->invoice_no;



					$invoice_number_length=strlen($last_invoice_number);



					if($invoice_number_length=='5')



					{



						$invoice_no = str_pad($last_invoice_number+1, 5, 0, STR_PAD_LEFT);



					}



					else	



					{



						$invoice_no='00001';



					}				



				}



				$entry_valuea=json_decode($entry_value);		 



				$amount=0;



				foreach($entry_valuea as $entry_valueb)



				{



					$product_id=$entry_valueb->entry;



					$quentity=$entry_valueb->quentity;



					$obj_product=new MJ_gmgt_product;



					$product = $obj_product->MJ_gmgt_get_single_product($product_id);



					$price=$product->price;



					$amount+= $quentity * $price;



					



					//	remainig_quentiy					



					$before_quentity=$product->quentity;



					$remainig_quentiy=$before_quentity-$quentity;



					$productdata['quentity']=$remainig_quentiy;



					$productid['id']=$product->id;



					$wpdb->update( $table_product, $productdata ,$productid);



				}



				if(!empty($data['discount']))



				{



				  $discount=$data['discount'];



				}



				else



				{



					$discount=0;



				}



				if($discount>$amount)



				{



					$alert_amount='3';



					return $alert_amount;



				}



                $total_after_discount_amount= $amount - $discount;



				if(!empty($data['tax']))



				{



					$total_tax=0;



					foreach($data['tax'] as $tax_id)



					{



						$tax_percentage=MJ_gmgt_tax_percentage_by_tax_id($tax_id);



						$tax_amount=$total_after_discount_amount * $tax_percentage / 100;



						$total_tax=$total_tax + $tax_amount;				



					}



					$total_amount_withtax=$total_after_discount_amount + $total_tax;



				}



				else



				{



					$total_tax=0;			



					$total_amount_withtax=$total_after_discount_amount + $total_tax;



				}



				$storedata['invoice_no']=$invoice_no;



		        $storedata['discount']=sanitize_text_field($data['discount']);



		        $storedata['amount']=$amount;



		        $storedata['total_amount']=$total_amount_withtax;



		        $storedata['paid_amount']=0;



			    $storedata['payment_status']='Unpaid';



				$storedata['created_date']=date('Y-m-d');



				$result=$wpdb->insert( $table_sell, $storedata );



				$insert_id=$wpdb->insert_id;



				$user_data = get_userdata($data['member_id']);



				gym_append_audit_log(''.esc_html__('Sell Product Added','gym_mgt').' ('.$user_data->display_name.')',$insert_id,get_current_user_id(),'insert',$_REQUEST['page']);



				//---------Add Entry into income invoice------------



			    $table_income=$wpdb->prefix.'gmgt_income_expense';



				$incomedata['entry']=$entry_value;	



				$incomedata['invoice_type']='income';



				$incomedata['invoice_label']=esc_html__("Sell Product","gym_mgt");



				$incomedata['supplier_name']=sanitize_text_field($data['member_id']);



				$incomedata['invoice_date']=MJ_gmgt_get_format_for_db(sanitize_text_field($data['sell_date']));



				$incomedata['receiver_id']=get_current_user_id();



				$incomedata['amount']=$amount;



				$incomedata['discount']=sanitize_text_field($data['discount']);



				$incomedata['tax']=0;



				$incomedata['tax_id']=implode(",",(array)($data['tax']));



				$incomedata['total_amount']=$total_amount_withtax;



				$incomedata['invoice_no']=$invoice_no;



				$incomedata['paid_amount']=0;



				$incomedata['payment_status']='Unpaid';



				



				$result_income=$wpdb->insert( $table_income,$incomedata); 



				//------------- SEND MESSAGE --------------------//



				$current_sms_service 	= 	get_option( 'gmgt_sms_service');



	



				if(is_plugin_active('sms-pack/sms-pack.php'))



				{



					$userdata=get_userdata(sanitize_text_field($data['member_id']));



					$mobile_number=array(); 



					$gymname=get_option( 'gmgt_system_name' );



					$mobile_number[] = "+".MJ_gmgt_get_countery_phonecode(get_option( 'gmgt_contry' )).$userdata->mobile;



					$message_content ="You have been purchased new Product at ".$gymname;



					$args = array();



					$args['mobile']=$mobile_number;



					$args['message_from']="Sell Product";



					$args['message']=$message_content;			



					if($current_sms_service=='telerivet' || $current_sms_service ="MSG91" || $current_sms_service=='bulksmsgateway.in' || $current_sms_service=='textlocal.in' || $current_sms_service=='bulksmsnigeria' || $current_sms_service=='africastalking' || $current_sms_service == 'clickatell')



					{				



						$send = send_sms($args);							



					}



				}



				else



				{	



					if(isset($data['gmgt_sms_service_enable']))



					{	



						$userinfo=get_userdata(esc_attr($data['member_id']));



						$gymname=get_option( 'gmgt_system_name' );						



						$reciever_number = $userinfo->mobile;		



						$message_content ="You have been purchased new Product at ".$gymname;



						if($current_sms_service == 'clickatell')



						{



							$clickatell=get_option('gmgt_clickatell_sms_service');



							$to = $reciever_number;



							$message = str_replace(" ","%20",$message_content);



							$username = $clickatell['username']; //clickatell username



							$password = $clickatell['password']; // clickatell password



							$api_key = $clickatell['api_key'];//clickatell apikey



							$baseurl ="http://api.clickatell.com";									



							$url = "$baseurl/http/auth?user=$username&password=$password&api_id=$api_key";									



							$ret = file($url);									



							$sess = explode(":",$ret[0]);



							



							if ($sess[0] == "OK")



							{



								$sess_id = trim($sess[1]); // remove any whitespace



								$url = "$baseurl/http/sendmsg?session_id=$sess_id&to=$to&text=$message";									



								$ret = file($url);



								$send = explode(":",$ret[0]);



							}				



						}



						if($current_sms_service == 'msg91')



						{



							//MSG91



							$mobile_number= $userinfo->mobile;



							$country_code="+".MJ_gmgt_get_countery_phonecode(get_option( 'gmgt_contry' ));



							$message = $message_content; // Message Text



							gmgt_msg91_send_mail_function($mobile_number,$message,$country_code);



						}	



					}							



				}



				//sell product invoice invoice mail send				



				$gymname=get_option( 'gmgt_system_name' );



				$userdata=get_userdata(sanitize_text_field($data['member_id']));



				$arr['[GMGT_USERNAME]']=MJ_gmgt_get_user_full_display_name($data['member_id']);	



				$arr['[GMGT_GYM_NAME]']=$gymname;				



				$subject =get_option('sell_product_subject');



				$sub_arr['[GMGT_GYM_NAME]']=$gymname;



				$subject = MJ_gmgt_subject_string_replacemnet($sub_arr,$subject);



				$message = get_option('sell_product_template');	



				$message_replacement = MJ_gmgt_string_replacemnet($arr,$message);



				$to[]=$userdata->user_email;

				$type='sell_invoice';

				MJ_gmgt_send_invoice_generate_mail($to,$subject,$message_replacement,$insert_id,$type);

				



			return $result;



		}



	}



	//sell product payment



	public function MJ_gmgt_sell_payment($data)



	{



		global $wpdb;



		$gmgt_sales_payment_history = $wpdb->prefix. 'gmgt_sales_payment_history';



		$saledata['sell_id']=sanitize_text_field($data['mp_id']);



		$saledata['member_id']=sanitize_text_field($data['member_id']);



		$saledata['amount']=sanitize_text_field($data['amount']);



		$saledata['payment_method']=sanitize_text_field($data['payment_method']);	



		$saledata['payment_description']=sanitize_text_field($data['payment_description']);	



		if(isset($data['trasaction_id']))



		{



			$saledata['trasaction_id']=sanitize_text_field($data['trasaction_id']) ;



		}



		$saledata['paid_by_date']=date("Y-m-d");



		$saledata['created_by']=sanitize_text_field($data['created_by']);



		$paid_amount_data= $this->MJ_gmgt_get_paid_amount_by_sellpayid(sanitize_text_field($data['mp_id']));



		$total_amount=$paid_amount_data->total_amount;



		$paid_amount=$paid_amount_data->paid_amount;



		$total_paid_amount=	$paid_amount + sanitize_text_field($data['amount']);



			if($total_paid_amount >= $total_amount)



			{



				$status='Fully Paid';



			}



			elseif($total_paid_amount > 0)



			{



				$status='Partially Paid';



			}



			else



			{



				$status= 'Unpaid';	



			}



			$uddate_data['paid_amount'] = $total_paid_amount;



			$uddate_data['payment_status'] =$status;



		    $uddate_data['mp_id'] = sanitize_text_field($data['mp_id']);



		    $this->MJ_gmgt_update_paid_sales_amount($uddate_data);



		$result=$wpdb->insert( $gmgt_sales_payment_history,$saledata );



		$insert_id=$wpdb->insert_id;



		//------------- SEND MESSAGE --------------------//



		$current_sms_service 	= 	get_option( 'gmgt_sms_service');



		if(is_plugin_active('sms-pack/sms-pack.php'))



		{



			$userdata=get_userdata(sanitize_text_field($data['member_id']));



			$mobile_number=array();



			$gymname=get_option( 'gmgt_system_name' );



			$mobile_number[] = "+".MJ_gmgt_get_countery_phonecode(get_option( 'gmgt_contry' )).$userdata->mobile;



			$message_content ="You have successfully paid your invoice at ".$gymname;



			$args = array();



			$args['mobile']=$mobile_number;



			$args['message_from']="Received Payment";



			$args['message']=$message_content;					



			if($current_sms_service=='telerivet' || $current_sms_service ="MSG91" || $current_sms_service=='bulksmsgateway.in' || $current_sms_service=='textlocal.in' || $current_sms_service=='bulksmsnigeria' || $current_sms_service=='africastalking' || $current_sms_service == 'clickatell')



			{



				$send = send_sms($args);							



			}



		}



		//payment success mail



		$gymname=get_option( 'gmgt_system_name' );



		$userdata=get_userdata(sanitize_text_field($data['member_id']));



		$arr['[GMGT_USERNAME]']=MJ_gmgt_get_user_full_display_name($data['member_id']);	



		$arr['[GMGT_GYM_NAME]']=$gymname;



		$subject =get_option('payment_received_against_invoice_subject');



		$sub_arr['[GMGT_GYM_NAME]']=$gymname;



		$subject = MJ_gmgt_subject_string_replacemnet($sub_arr,$subject);



		$message = get_option('payment_received_against_invoice_template');	



		$message_replacement = MJ_gmgt_string_replacemnet($arr,$message);



		$to[]=$userdata->user_email;



		$type='sell_invoice';



		MJ_gmgt_send_invoice_generate_mail($to,$subject,$message_replacement,$data['mp_id'],$type);



		return $result;



	}



	//add_sellpayment_history



	public function MJ_gmgt_add_sellpayment_history($data)



	{ 



		global $wpdb;



		$gmgt_sales_payment_history = $wpdb->prefix. 'gmgt_sales_payment_history';



		if($data['payment_method'] == "Stripe")



		{



			$saledata['member_id']=get_current_user_id();



			$saledata['sell_id']=sanitize_text_field($data['mp_id']);		



		    $saledata['trasaction_id']='';



		}



		else



		{



			$saledata['member_id']=sanitize_text_field($data['member_id']);



			$saledata['sell_id']=sanitize_text_field($data['sell_id']);



            $saledata['trasaction_id']=sanitize_text_field($data['trasaction_id']);		   



		}



	    $saledata['payment_method']=sanitize_text_field($data['payment_method']);



	    $saledata['amount']=sanitize_text_field($data['amount']);



		$saledata['paid_by_date']=date("Y-m-d");



		$saledata['created_by']=get_current_user_id();



		$result=$wpdb->insert( $gmgt_sales_payment_history,$saledata );	



		$paid_amount_data= $this->MJ_gmgt_get_paid_amount_by_sellpayid($saledata['sell_id']);



		$total_amount=$paid_amount_data->total_amount;



		$paid_amount=$paid_amount_data->paid_amount;



		$total_paid_amount=	$paid_amount + sanitize_text_field($data['amount']);



			if($total_paid_amount >= $total_amount)



			{



				$status='Fully Paid';



			}



			elseif($total_paid_amount > 0)



			{



				$status='Partially Paid';



			}



			else



			{



				$status= 'Unpaid';	



			}	



		   	$uddate_data['paid_amount'] = $total_paid_amount;



		   	$uddate_data['payment_status'] =$status;



		   	$uddate_data['mp_id'] = $saledata['sell_id'];



		    $this->MJ_gmgt_update_paid_sales_amount($uddate_data);



			//------------- SEND MESSAGE --------------------//



			$current_sms_service 	= 	get_option( 'gmgt_sms_service');



			if(is_plugin_active('sms-pack/sms-pack.php'))



			{



				$userdata=get_userdata($saledata['member_id']);



				$mobile_number=array(); 



				$gymname=get_option( 'gmgt_system_name' );



				$mobile_number[] = "+".MJ_gmgt_get_countery_phonecode(get_option( 'gmgt_contry' )).$userdata->mobile;



				$message_content ="You have successfully paid your invoice at ".$gymname;



				$args = array();



				$args['mobile']=$mobile_number;



				$args['message_from']="Received Payment";



				$args['message']=$message_content;					



				if($current_sms_service=='telerivet' || $current_sms_service ="MSG91" || $current_sms_service=='bulksmsgateway.in' || $current_sms_service=='textlocal.in' || $current_sms_service=='bulksmsnigeria' || $current_sms_service=='africastalking' || $current_sms_service == 'clickatell')



				{				



					$send = send_sms($args);							



				}



			}



			//payment success mail



			$gymname=get_option( 'gmgt_system_name' );



			$userdata=get_userdata($saledata['member_id']);



			$arr['[GMGT_USERNAME]']=MJ_gmgt_get_user_full_display_name($saledata['member_id']);	



			$arr['[GMGT_GYM_NAME]']=$gymname;



			$subject =get_option('payment_received_against_invoice_subject');



			$sub_arr['[GMGT_GYM_NAME]']=$gymname;



			$subject = MJ_gmgt_subject_string_replacemnet($sub_arr,$subject);



			$message = get_option('payment_received_against_invoice_template');	



			$message_replacement = MJ_gmgt_string_replacemnet($arr,$message);



			$to[]=$userdata->user_email;



			$type='sell_invoice';



			$enable_notofication=get_option('gym_enable_notifications');



			if($enable_notofication=='yes'){



				MJ_gmgt_send_invoice_generate_mail($to,$subject,$message_replacement,$saledata['sell_id'],$type);



			}



		return $result;



	}



	//get all selling product



	public function MJ_gmgt_get_all_selling()



	{



		global $wpdb;



		$table_sell = $wpdb->prefix. 'gmgt_store';



		$result = $wpdb->get_results("SELECT * FROM $table_sell");



		return $result;



	}



	//get all selling product by sell by



	public function MJ_gmgt_get_all_selling_by_sell_by($user_id)



	{



		global $wpdb;



		$table_sell = $wpdb->prefix. 'gmgt_store';



		$result = $wpdb->get_results("SELECT * FROM $table_sell where sell_by=$user_id");



		return $result;



	}



	//get all selling product by member



	public function MJ_gmgt_get_all_selling_by_member($user_id)



	{



		global $wpdb;



		$table_sell = $wpdb->prefix. 'gmgt_store';



		$result = $wpdb->get_results("SELECT * FROM $table_sell where member_id=$user_id");



		return $result;	



	}



	//get single sell product



	public function MJ_gmgt_get_single_selling($id)



	{



		global $wpdb;



		$table_sell = $wpdb->prefix. 'gmgt_store';



		$result = $wpdb->get_row("SELECT * FROM $table_sell where id=".$id);



		return $result;



	}



	//delete sell product



	public function MJ_gmgt_delete_selling($id)



	{



		global $wpdb;



		$table_sell = $wpdb->prefix. 'gmgt_store';



		$table_income=$wpdb->prefix.'gmgt_income_expense'; 



		$member_id = $wpdb->get_row("SELECT member_id FROM $table_sell where id=".$id);



		$user_data = get_userdata($member_id);



		$invoice_no=$this->MJ_gmgt_get_invoice_no_by_id($id);



		gym_append_audit_log(''.esc_html__('Sale Product Deleted','gym_mgt').' ('.$user_data->display_name.')',$id,get_current_user_id(),'delete',$_REQUEST['page']);

		gym_append_audit_log(''.esc_html__('Sale Product Invoice Deleted','gym_mgt').' ('.$user_data->display_name.')',$invoice_no,get_current_user_id(),'delete',$_REQUEST['page']);



		$result = $wpdb->query("DELETE FROM $table_sell where id= ".$id);



		$result_delete_income = $wpdb->query("DELETE FROM $table_income where invoice_no=".$invoice_no);



		return $result;



	}



	//get invoice no by id



	public function MJ_gmgt_get_invoice_no_by_id($id)

	{



		global $wpdb;



		$table_sell = $wpdb->prefix. 'gmgt_store';



		$result = $wpdb->get_row("SELECT invoice_no FROM $table_sell where id=".$id);



		return $result->invoice_no;



	}



	//update paid sale amount



	public function MJ_gmgt_update_paid_sales_amount($data)



	{



		global $wpdb;



		$table_sell = $wpdb->prefix. 'gmgt_store';



		$table_income=$wpdb->prefix.'gmgt_income_expense';



		$saledata['paid_amount'] = sanitize_text_field($data['paid_amount']);



		$saledata['payment_status'] = sanitize_text_field($data['payment_status']);



		$sale_id['id']=$data['mp_id'];



		$invoice_no['invoice_no']=$this->MJ_gmgt_get_invoice_no_by_mpid(sanitize_text_field($data['mp_id']));



		$result=$wpdb->update( $table_sell, $saledata ,$sale_id);



		$result_update_income=$wpdb->update( $table_income, $saledata ,$invoice_no);



		return $result;



	}



	//get invoice no by mp id



	public function MJ_gmgt_get_invoice_no_by_mpid($mp_id)



	{



		global $wpdb;



		$table_sell = $wpdb->prefix. 'gmgt_store';		



		$result = $wpdb->get_row("SELECT invoice_no FROM $table_sell where id = $mp_id");



		return $result->invoice_no;



	}



	public function MJ_gmgt_get_paid_amount_by_sellpayid($mp_id)



	{



		global $wpdb;



		$table_sell = $wpdb->prefix. 'gmgt_store';



		$result = $wpdb->get_row("SELECT * FROM $table_sell where id = $mp_id");



		return $result;



	}



}



//STORE CLASS END 



?>