<?php 

$obj_membership_payment=new MJ_gmgt_membership_payment;

$obj_membership=new MJ_gmgt_membership;

$obj_member=new MJ_gmgt_member;

$active_tab=isset($_REQUEST['tab'])?$_REQUEST['tab']:'paymentlist';

$fees_detail_result = '';

$user_access=MJ_gmgt_get_userrole_wise_page_access_right_array();

if (isset ( $_REQUEST ['page'] ))

{	

	if($user_access['view']=='0')

	{	

		MJ_gmgt_access_right_page_not_access_message();

		die;

	}

}

if(!empty($_REQUEST['action']))

{

	if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == $user_access['page_link'] && ($_REQUEST['action']=='edit'))

	{

		if($user_access['edit']=='0')
		{	

			MJ_gmgt_access_right_page_not_access_message();

			die;

		}			

	}

	if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == $user_access['page_link'] && ($_REQUEST['action']=='delete'))

	{

		if($user_access['delete']=='0')

		{	

			MJ_gmgt_access_right_page_not_access_message();

			die;

		}	

	}

	if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == $user_access['page_link'] && ($_REQUEST['action']=='insert'))



	{



		if($user_access['add']=='0')



		{	



			MJ_gmgt_access_right_page_not_access_message();



			die;



		}	



	}



}



//SAVE MEMBERSHIP PAYMENT DATA



if(isset($_POST['save_membership_payment']))



{

	



	$nonce = $_POST['_wpnonce'];



	if (wp_verify_nonce( $nonce, 'save_membership_payment_nonce' ) )



	{

		

		if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')



		{



			$result=$obj_membership_payment->MJ_gmgt_add_membership_payment($_POST);



			if($result)



			{



				wp_redirect ( home_url().'?dashboard=user&page=membership_payment&tab=paymentlist&message=3');



			}	



		}



		else

		{

			if($_REQUEST['tab1'] == 'renew_upgrade')

			{

				$result=MJ_gmgt_add_membership_payment_by_member($_POST);

			}

			else{

				$result=$obj_membership_payment->MJ_gmgt_add_membership_payment($_POST);

			}



			if($result)



			{



				$user_info=get_userdata($_POST['member_id']);



				$to = $user_info->user_email;           



				$subject = get_option('subscription_template_title'); 



				$search=array('[GMGT_MEMBERNAME]','[GMGT_MEMBERID]','[GMGT_STARTDATE]','[GMGT_ENDDATE]','[GMGT_MEMBERSHIP]','[GMGT_MEMBERSHIP_AMOUNT]');



				$membership_name=MJ_gmgt_get_membership_name($_POST['membership_id']);



				$replace = array(MJ_gmgt_get_user_full_display_name($_POST['member_id']),$user_info->member_id,$_POST['start_date'],$_POST['end_date'],$membership_name,$_POST['membership_amount']);



				$message = str_replace($search, $replace,get_option('subcription_mailcontent'));	



				$sent=wp_mail($to, $subject, $message);



				wp_redirect ( home_url().'?dashboard=user&page=membership_payment&tab=paymentlist&message=1');



			}



		}



	}



}

//DELETE PAYMENT DATA



if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')



{



	if(isset($_REQUEST['mp_id']))



	{



		$result=$obj_membership_payment->MJ_gmgt_delete_payment($_REQUEST['mp_id']);



		if($result)



		{



			wp_redirect ( home_url().'?dashboard=user&page=membership_payment&tab=paymentlist&message=3');



		}



	}



}



//ADD FEES PAYMENT DATA



if(isset($_POST['add_fee_payment']))



{

	//POP up data save in payment history



	if($_POST['payment_method'] == 'Paypal')
	{
		require_once GMS_PLUGIN_DIR. '/lib/paypal/paypal_process.php';				
	}
	if($_POST['payment_method'] == 'stripe_gym')
	{				
		require_once GMS_PLUGIN_DIR. '/lib/stripe/index.php';				
	}
	elseif($_POST['payment_method'] == 'Stripe')
	{
		require_once PM_PLUGIN_DIR. '/lib/stripe/index.php';			
	}
	elseif($_POST['payment_method'] == 'Skrill')
	{			
		require_once PM_PLUGIN_DIR. '/lib/skrill/skrill.php';
	}
	elseif($_POST['payment_method'] == 'Instamojo')
	{			
		require_once PM_PLUGIN_DIR. '/lib/instamojo/instamojo.php';
	}
	elseif($_POST['payment_method'] == 'PayUMony')
	{
		require_once PM_PLUGIN_DIR. '/lib/OpenPayU/index.php';			
	}
	elseif($_REQUEST['payment_method'] == '2CheckOut')
	{				
		require_once PM_PLUGIN_DIR. '/lib/2checkout/index.php';
	}
	elseif($_POST['payment_method'] == 'Paystack')
	{
		require_once PM_PLUGIN_DIR. '/lib/paystack/paystack.php';
	}
	elseif($_POST['payment_method'] == 'paytm')
	{
		require_once PM_PLUGIN_DIR. '/lib/PaytmKit/index.php';
	}
	elseif($_POST['payment_method'] == 'razorpay')
	{
		require_once PM_PLUGIN_DIR. '/lib/razorpay/index.php';
	}
	else
	{
		if($_POST['payment_method'] == "Cash" || $_POST['payment_method'] == "Cheque" || $_POST['payment_method'] == "Bank Transfer")
		{
			$result=$obj_membership_payment->MJ_gmgt_add_feespayment_history($_POST);	
			if($result)	
			{
				wp_redirect ( home_url() . '?dashboard=user&page=membership_payment&message=1');
			}
		}			
	}
}



if(isset($_REQUEST['action'])&& $_REQUEST['action']=='success')

{ 
	
	?>

	<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">

		<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span>

		</button>

		<?php esc_html_e('Payment successfully.','gym_mgt');?>

	</div>

	<?php
}	

if(isset($_REQUEST['action'])&& $_REQUEST['action']=='renew_upgrade_success')

{ 

	?>

	<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">

		<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span>

		</button>

		<?php esc_html_e('Membership Renew Successfully.','gym_mgt');?>

	</div>

	<?php

}


if(isset($_REQUEST['action']) && $_REQUEST['action']=="ideal_payments" && $_REQUEST['page']=="membership_payment" && isset($_REQUEST['ideal_pay_id']) && isset($_REQUEST['ideal_amt']))

{			

	$feedata['mp_id']=esc_attr($_REQUEST['ideal_pay_id']);

	$feedata['amount']=esc_attr($_REQUEST['ideal_amt']);

	$feedata['payment_method']='PayUMoney';	

	$feedata['trasaction_id']="";

	$feedata['created_by']=get_current_user_id();

	$result = $obj_membership_payment->MJ_gmgt_add_feespayment_history($feedata);		

	if($result)

	{ 

		wp_redirect ( home_url() . '?dashboard=user&page=membership_payment&action=success');

	}	

}

if(isset($_REQUEST['skrill_mp_id']) && (isset($_REQUEST['amount'])))

{


	$feedata['mp_id']=esc_attr($_REQUEST['skrill_mp_id']);

	$feedata['amount']=esc_attr($_REQUEST['amount']);

	$feedata['payment_method']='Skrill';	

	$feedata['trasaction_id']="";

	$feedata['created_by']=get_current_user_id();	

	$result = $obj_membership_payment->MJ_gmgt_add_feespayment_history($feedata);	

	if($result)

	{ 

		wp_redirect ( home_url() . '?dashboard=user&page=membership_payment&action=success');

	}

}

if(isset($_REQUEST['amount'])  && (isset($_REQUEST['pay_id'])) && isset($_REQUEST['payment_request_id']) )

{	

	$feedata['mp_id']=esc_attr($_REQUEST['pay_id']);

	$feedata['amount']=esc_attr($_REQUEST['amount']);

	$feedata['payment_method']='Instamojo';	

	$feedata['trasaction_id']=esc_attr($_REQUEST['payment_request_id']);

	$feedata['created_by']=get_current_user_id();	

	$result = $obj_membership_payment->MJ_gmgt_add_feespayment_history($feedata);		

	if($result)

	{

		wp_redirect ( home_url() . '?dashboard=user&page=membership_payment&action=success');	

	}	

}


//------------PAYSTACK SUCCESS ----------------------//

$reference='';

$reference = isset($_GET['reference']) ? $_GET['reference'] : '';

if($reference)

{



	$paystack_secret_key=get_option('paystack_secret_key');



	$curl = curl_init();



	curl_setopt_array($curl, array(



	CURLOPT_URL => "https://api.paystack.co/transaction/verify/" . rawurlencode($reference),



	CURLOPT_RETURNTRANSFER => true,



	CURLOPT_HTTPHEADER => [



		"accept: application/json",



		"authorization: Bearer $paystack_secret_key",



		"cache-control: no-cache"



	  ],



	));



	$response = curl_exec($curl);



	$err = curl_error($curl);



	if($err)



	{



		// there was an error contacting the Paystack API



	  	die('Curl returned error: ' . $err);



	}



	$tranx = json_decode($response);



	if(!$tranx->status)



	{



	  // there was an error from the API



	  die('API returned error: ' . $tranx->message);



	}



	if('success' == $tranx->data->status)



	{



		$trasaction_id  = $tranx->data->reference;



		$feedata['mp_id']=$tranx->data->metadata->custom_fields->fees_pay_id;



		$feedata['amount']=$tranx->data->amount / 100;



		$feedata['payment_method']='Paystack';	



		$feedata['trasaction_id']=$trasaction_id;



		$feedata['created_by']=get_current_user_id();	



		$result = $obj_membership_payment->MJ_gmgt_add_feespayment_history($feedata);		



		if($result)



		{ 



			wp_redirect ( home_url() . '?dashboard=user&page=membership_payment&action=success');



		}	



	}



}



//Paytm Success//



if(isset($_REQUEST['STATUS']) && $_REQUEST['STATUS'] == 'TXN_SUCCESS')



{ 



	$trasaction_id  = esc_attr($_REQUEST["TXNID"]);



	$custom_array = explode("_",esc_attr($_REQUEST['ORDERID']));



	$feedata['mp_id']=$custom_array[1];



	$feedata['amount']=esc_attr($_REQUEST['TXNAMOUNT']);



	$feedata['payment_method']='Paytm';	



	$feedata['trasaction_id']=$trasaction_id;



	$feedata['created_by']=get_current_user_id();	



	$result = $obj_membership_payment->MJ_gmgt_add_feespayment_history($feedata);		



	if($result)



	{ 



		wp_redirect ( home_url() . '?dashboard=user&page=membership_payment&action=success');



	}	



}



if(isset($_REQUEST['action'])&& $_REQUEST['action']=='cancel')



{ 



	?>



	<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">



		<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span>



		</button>



		<?php esc_html_e('Payment Cancel.','gym_mgt');?>



	</div>



	<?php



}	



if(isset($_REQUEST['message']))



{



	$message =esc_attr($_REQUEST['message']);



	if($message == 1)



	{



		?>



		<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">



			<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span>



			</button>



			<?php esc_html_e('Membership Payment Invoice added successfully.','gym_mgt');?>



		</div>



		<?php 	



	}



	elseif($message == 2)



	{



		?>



		<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">



			<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span>



			</button>



			<?php esc_html_e('Membership Payment Invoice updated successfully.','gym_mgt');?>



		</div>



		<?php 	



	}



	elseif($message == 3) 



	{



		?>



		<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">



			<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span>



			</button>



			<?php esc_html_e('Membership Payment Invoice deleted successfully.','gym_mgt');?>



		</div>



		<?php		



	}



}	



?>



<!-- POP up code -->



<div class="popup-bg">



    <div class="overlay-content">



		<div class="modal-content">



		  <div class="invoice_data"></div>



		</div>



    </div> 



</div>



<!-- End POP-UP Code -->



<script>



$(document).ready(function() 



{



	"use strict";



    $('#payment_list').DataTable({



        // "responsive": true,



		dom: 'lifrtp',



		"aoColumns":[											  



						{"bSortable": false},



						{"bSortable": true},



						{"bSortable": true},



						{"bSortable": true},



						{"bSortable": true},



						{"bSortable": true},



						{"bSortable": true},



						{"bSortable": true},



						{"bSortable": true},



						{"bSortable": true},



						{"bSortable": false}],



		language:<?php echo MJ_gmgt_datatable_multi_language();?>	



    });



	$('.dataTables_filter input').attr("placeholder", "<?php esc_html_e('Search...', 'gym_mgt') ?>");



	$('#payment_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});	



	$.datepicker.setDefaults($.datepicker.regional['<?php echo MJ_gmgt_get_current_lan_code(); ?>']);



		    var date = new Date();



            date.setDate(date.getDate()-0);



            $('#begin_date').datepicker({



			dateFormat: '<?php echo get_option('gmgt_datepicker_format');?>',



	       	<?php



			if(get_option('gym_enable_datepicker_privious_date')=='no')



			{



			?>



				minDate:'today',



			<?php



			}



			?>	



             	autoclose: true



           });



	$(".display-members").select2();



	// $('.sl').select2(



	// {



    //     placeholder:'Select'   



    // })



} );



</script>



<div class="panel-body panel-white padding_0 gms_main_list"><!--PANEL BODY DIV START-->



	<div class="tab-content padding_0"><!--TAB CONTENT DIV START-->



		<?php 



		if($active_tab == 'paymentlist')



		{ 



			if($obj_gym->role == 'member')



			{



				if($user_access['own_data']=='1')



				{



					$user_id=get_current_user_id();	



					$paymentdata=$obj_membership_payment->MJ_gmgt_get_all_membership_payment_byuserid($user_id);



				}



				else



				{



					$paymentdata=$obj_membership_payment->MJ_gmgt_get_all_membership_payment();



				}						



			}



			else



			{						



				$paymentdata=$obj_membership_payment->MJ_gmgt_get_all_membership_payment();



			}



			if(!empty($paymentdata))



			{



				?>



				<div class="table-responsive"><!--TABLE RESPONSIVE DIV START-->



					<div class="panel-body padding_0"><!--PANEL BODY DIV START-->



						<table id="payment_list" class="display" cellspacing="0" width="100%"><!--TABLE PAYMENT LIST START-->

							<thead class="<?php echo MJ_gmgt_datatable_heder(); ?>">

								<tr>

								<th><?php esc_html_e('Photo','gym_mgt');?></th>

									<th><?php esc_html_e('Invoice No.','gym_mgt');?></th>

									<th><?php esc_html_e('Membership Name','gym_mgt');?></th>

									<th><?php esc_html_e('Member Name','gym_mgt');?></th>

									<th><?php esc_html_e('Total Amount','gym_mgt');?></th>

									<th><?php esc_html_e('Paid Amount','gym_mgt');?></th>

									<th><?php esc_html_e('Due Amount','gym_mgt');?></th>

									<th><?php esc_html_e('Start Date','gym_mgt');?></th>

									<th><?php esc_html_e('End Date','gym_mgt');?></th>

									<th><?php esc_html_e('Payment Status','gym_mgt');?></th>

									<th class="text_align_end"><?php esc_html_e('Action','gym_mgt');?></th>

								</tr>

							</thead>

							<tbody>



								<?php



								if(!empty($paymentdata))



								{



									$i=0;



									foreach ($paymentdata as $retrieved_data)



									{

										$due_amount =  $retrieved_data->membership_amount - $retrieved_data->paid_amount;

										if($i == 10)



										{



											$i=0;



										}



										if($i == 0)



										{



											$color_class='smgt_class_color0';



										}



										elseif($i == 1)



										{



											$color_class='smgt_class_color1';



										}



										elseif($i == 2)



										{



											$color_class='smgt_class_color2';



										}



										elseif($i == 3)



										{



											$color_class='smgt_class_color3';



										}



										elseif($i == 4)



										{



											$color_class='smgt_class_color4';



										}



										elseif($i == 5)



										{



											$color_class='smgt_class_color5';



										}



										elseif($i == 6)



										{



											$color_class='smgt_class_color6';



										}



										elseif($i == 7)



										{



											$color_class='smgt_class_color7';



										}



										elseif($i == 8)



										{



											$color_class='smgt_class_color8';



										}



										elseif($i == 9)



										{



											$color_class='smgt_class_color9';



										}



										?>



										<tr>



											<td class="user_image width_50px profile_image_prescription padding_left_0">	



												<p class="prescription_tag padding_15px margin_bottom_0px <?php echo $color_class; ?>">	



													<img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/Payment.png"?>" alt="" class="massage_image center image_icon_height_25px margin_top_3px">



												</p>



											</td>



											<td class="productname">



												<?php



												if(!empty($retrieved_data->invoice_no))



												{



													echo esc_html($retrieved_data->invoice_no);



												}



												else



												{



													echo 'N/A';



												}		



												?> 



												<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Invoice No.','gym_mgt');?>" >



											</td>



											<td class="productname"><?php echo MJ_gmgt_get_membership_name(esc_html($retrieved_data->membership_id));?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Membership Name','gym_mgt');?>" ></td>



											<td class="paymentby"><?php 



											$user=get_userdata($retrieved_data->member_id);



											$memberid=get_user_meta($retrieved_data->member_id,'member_id',true); 



											// if(!empty($user->display_name))

											// {

											// 	$display_label=$user->display_name; 

											// }

											// else

											// {

											// 	$display_label="N/A";

											// }

											// if($memberid)

											// {

											// 	$display_label.=" (".$memberid.")";

											// }



											

											$display_label = MJ_gmgt_get_member_full_display_name_with_memberid(esc_html($retrieved_data->member_id));



											echo esc_html($display_label); 



											?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Member Name','gym_mgt');?>" >



											</td>



											<td class="totalamount"><?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?> <?php echo number_format(esc_html($retrieved_data->membership_amount),2);?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Total Amount','gym_mgt');?>" ></td>



											<td class="paid_amount"><?php echo MJ_gmgt_get_currency_symbol(get_option('gmgt_currency_code')); ?> <?php echo number_format(esc_html($retrieved_data->paid_amount),2);?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Paid Amount','gym_mgt');?>" ></td>



											<td class="totalamount"><?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?> <?php echo number_format(esc_html($due_amount),2);?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Due Amount','gym_mgt');?>" ></td>



											<td class="paymentdate"><?php if($retrieved_data->start_date == "0000-00-00"){ echo "0000-00-00"; }else{echo MJ_gmgt_getdate_in_input_box(esc_html($retrieved_data->start_date)); } ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Membership Start Date','gym_mgt');?>" ></td>



											<td class="paymentdate"><?php if($retrieved_data->end_date == "0000-00-00"){ echo "0000-00-00"; }else{ echo MJ_gmgt_getdate_in_input_box(esc_html($retrieved_data->end_date)); } ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Membership End Date','gym_mgt');?>" ></td>



											<td class="paymentdate">



												<?php



												$memberhsip_status=MJ_gmgt_get_membership_paymentstatus($retrieved_data->mp_id);

												

												



												if($memberhsip_status == 'Unpaid')



												{



													echo "<span class='Unpaid_status_color'>";



												}



												elseif($memberhsip_status == 'Partially Paid')



												{



													echo "<span style = 'color:blue;'>";



												}



												else



												{



													echo "<span class='fullpaid_status_color'>";



												}													 



												echo esc_html__($memberhsip_status,'gym_mgt' );



												echo "</span>"; ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Payment Status','gym_mgt');?>" >



											</td>



											<?php 



											if(MJ_gmgt_get_membership_paymentstatus($retrieved_data->mp_id) =='Fully Paid')



											{



												?>



												<td class="action"> 



													<div class="gmgt-user-dropdown">



														<ul class="" style="margin-bottom: 0px !important;">



															<li class="">



																<a class="" href="#" data-bs-toggle="dropdown" aria-expanded="false">



																	<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/More.png"?>" >



																</a>



																<ul class="dropdown-menu heder-dropdown-menu action_dropdawn" aria-labelledby="dropdownMenuLink">



																	<li class="float_left_width_100">



																		<a href="?dashboard=user&page=membership_payment&tab=view_invoice&idtest=<?php echo $retrieved_data->mp_id; ?>&invoice_type=membership_invoice" class="float_left_width_100" ><i class="fa fa-eye"></i> <?php esc_html_e('View Invoice', 'gym_mgt' ) ;?></a>



																	</li>



																</ul>



															</li>



														</ul>



													</div>	



												</td>



												<?php 



											}			



											else



											{



												$due_amount=$retrieved_data->membership_amount-$retrieved_data->paid_amount;



												?>



												<td class="action"> 



													<div class="gmgt-user-dropdown">



														<ul class="" style="margin-bottom: 0px !important;">



															<li class="">



																<a class="" href="#" data-bs-toggle="dropdown" aria-expanded="false">



																	<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/More.png"?>" >



																</a>



																<ul class="dropdown-menu heder-dropdown-menu action_dropdawn" aria-labelledby="dropdownMenuLink">



																	<li class="float_left_width_100">



																		<a href="?dashboard=user&page=membership_payment&tab=view_invoice&idtest=<?php echo $retrieved_data->mp_id; ?>&invoice_type=membership_invoice" class="float_left_width_100" ><i class="fa fa-eye"></i> <?php esc_html_e('View Invoice', 'gym_mgt' ) ;?></a>



																	</li>



																	<li class="float_left_width_100">


												
																		<a href="#" class="show-payment-popup float_left_width_100" idtest="<?php echo $retrieved_data->mp_id; ?>" due_amount="<?php echo $due_amount; ?>" member_id="<?php echo $retrieved_data->member_id; ?>" view_type="payment" ><i class="fa fa-credit-card"></i> <?php esc_html_e('Pay', 'gym_mgt' ) ;?></a>



																	</li>



																	<?php 



																	if($user_access['edit']=='1' && $memberhsip_status == 'Unpaid')



																	{ 



																		if(isset($_REQUEST['product_list_app_view']) && $_REQUEST['product_list_app_view'] == 'productlist_app')



																		{



																			?>



																			<li class="float_left_width_100 border_bottom_item">



																				<a href="?dashboard=user&page=membership_payment&tab=addpayment&action=edit&product_list_app_view=productlist_app&page_action=web_view_hide&mp_id=<?php echo esc_attr($retrieved_data->mp_id)?>" class="float_left_width_100"><i class="fa fa-edit"></i> <?php esc_html_e('Edit', 'gym_mgt' ) ;?></a>



																			</li>



																			<?php 



																		}



																		else



																		{



																			?>



																			<li class="float_left_width_100 border_bottom_item">



																				<a href="?dashboard=user&page=membership_payment&tab=addpayment&action=edit&mp_id=<?php echo esc_attr($retrieved_data->mp_id); ?>" class="float_left_width_100"><i class="fa fa-edit"></i> <?php esc_html_e('Edit', 'gym_mgt' ) ;?></a>



																			</li>



																			<?php 



																		}



																	}



																	if($user_access['delete'] =='1')



																	{ 



																		if(isset($_REQUEST['product_list_app_view']) && $_REQUEST['product_list_app_view'] == 'productlist_app')



																		{



																			?>



																			<li class="float_left_width_100">



																				<a href="?dashboard=user&page=membership_payment&tab=paymentlist&action=delete&product_list_app_view=productlist_app&page_action=web_view_hide&mp_id=<?php echo esc_attr($retrieved_data->mp_id);?>" class="float_left_width_100 list_delete_btn" onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','gym_mgt');?>');"><i class="fa fa-trash"></i> <?php esc_html_e( 'Delete', 'gym_mgt' ) ;?> </a>



																			</li>



																			<?php 



																		}



																		else



																		{



																			?>



																			<li class="float_left_width_100">



																				<a href="?dashboard=user&page=membership_payment&tab=paymentlist&action=delete&mp_id=<?php echo esc_attr($retrieved_data->mp_id);?>" class="float_left_width_100 list_delete_btn" onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','gym_mgt');?>');"><i class="fa fa-trash"></i> <?php esc_html_e( 'Delete', 'gym_mgt' ) ;?> </a>



																			</li>



																			<?php 



																		}



																	} 



																	?>



																</ul>



															</li>



														</ul>



													</div>	



												</td>



												<?php 



											}



											?>	



										</tr>



										<?php	



										$i++;	



									}



								}



								?>



							</tbody>



						</table><!--TABLE PAYMENT LIST END-->



					</div><!--PANEL BODY DIV END-->



				<div>



				<?php 



			}



			else



			{



				if($user_access['add']=='1')

				{



					?>



					<div class="no_data_list_div"> 



						<a href="<?php echo home_url().'?dashboard=user&page=membership_payment&tab=addpayment';?>">



							<img class="width_100px" src="<?php echo get_option( 'gmgt_no_data_img' ) ?>" >



						</a>



						<div class="col-md-12 dashboard_btn margin_top_20px">



							<label class="no_data_list_label"><?php esc_html_e('Tap on above icon to add your first Record.','gym_mgt'); ?> </label>



						</div> 



					</div>      



					<?php



				}



				else



				{



					?>



					<div class="calendar-event-new"> 



						<img class="no_data_img" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/no_data_img.png"?>" >



					</div>



					<?php



				}



			}



		}



		if($active_tab == 'addpayment')



		{ 



			$mp_id=0;	



			$edit=0;



			if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')



			{



				$mp_id=$_REQUEST['mp_id'];



				$edit=1;



				$result = $obj_membership_payment->MJ_gmgt_get_single_membership_payment($mp_id);



			}



			?>



			<div class="panel-body padding_0"><!--PANEL BODY DIV START-->



				<form name="payment_form" action="" method="post" class="form-horizontal" id="payment_form"><!--PAYMENT FORM START-->



					<?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>



					<input type="hidden" name="action" value="<?php echo esc_attr($action);?>">



					<input type="hidden" name="mp_id" value="<?php if($edit){ echo esc_attr($mp_id); }?>"  />



					<input type="hidden" name="created_by" value="<?php echo get_current_user_id();?>"  />



					<input type="hidden" name="paid_amount" value="<?php if($edit){ echo esc_attr($result->paid_amount); }?>" />



					<input type="hidden" class="user_coupon" name="coupon_id" value=""/>



					<input type="hidden" name="invoice_no" value="<?php if($edit){ echo esc_attr($result->invoice_no); }?>" />



					<div class="header">	



						<h3 class="first_hed"><?php esc_html_e('Membership Payment Information','gym_mgt');?></h3>



					</div>



					<div class="form-body user_form"> <!-- user_form Strat-->   



						<div class="row"><!--Row Div Strat-->



							<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 input">



								<!-- <label class="ml-1 custom-top-label top" for="Source"><?php //esc_html_e('Member','gym_mgt');?><span class="require-field">*</span></label> -->



								<?php if($edit){ $member_id=$result->member_id; }elseif(isset($_REQUEST['member_id'])){$member_id=$_REQUEST['member_id'];}else{$member_id='';} ?>



								<select id="member_list" class="form-control display-members member-select2" required="true" name="member_id">



									<option value=""><?php esc_html_e('Select Member','gym_mgt');?></option>



									<?php

									

									$get_members = array('role' => 'member');



									$membersdata=get_users($get_members);

									

									if(!empty($membersdata))



									{



										foreach ($membersdata as $member)



										{

											if($_REQUEST['tab1'] == 'renew_upgrade')

											{

											

												?>



												<option value="<?php echo esc_attr($member->ID);?>" <?php selected(get_current_user_id(),$member->ID);?>><?php echo esc_html(MJ_gmgt_get_member_full_display_name_with_memberid(esc_html($member->ID))); ?> </option>



												<?php

											}else{

												?>



												<option value="<?php echo esc_attr($member->ID);?>" <?php selected($member_id,$member->ID);?>><?php echo esc_html(MJ_gmgt_get_member_full_display_name_with_memberid(esc_html($member->ID))); ?> </option>



												<?php

											}



										}



									}?>



								</select>



							</div>

							<?php

							if(isset($_REQUEST['tab1']) && ($_REQUEST['tab1'] == 'renew_upgrade'))

							{ 

								?>

								<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 input display_none">



									<input type="hidden" name="payment_status" value="paid">

									<input type="hidden" name="view_type" value="payment">

									<input type="hidden" name="view_type" value="payment">

									<input type="hidden" name="created_by" value="<?php echo get_current_user_id();?>">

									<label class="ml-1 custom-top-label top" for="payment_method"><?php esc_html_e('Payment Method','gym_mgt');?><span class="require-field">*</span></label>



									<?php 



									global $current_user;



									$user_roles = $current_user->roles;



									$user_role = array_shift($user_roles);



									?>



									<select name="payment_method" id="payment_method" class="form-control" >



										<?php 



										if($user_role != 'member')



										{ ?>



											<option value="Cash"><?php esc_html_e('Cash','gym_mgt');?></option>



											<option value="Cheque"><?php esc_html_e('Cheque','gym_mgt');?></option>



											<option value="Bank Transfer"><?php esc_html_e('Bank Transfer','gym_mgt');?></option>		



											<?php



										} 



										else 



										{					



											if(is_plugin_active('paymaster/paymaster.php') && get_option('gmgt_paymaster_pack')=="yes")



											{ 



												$payment_method = get_option('pm_payment_method');



												print '<option value="'.$payment_method.'">'.$payment_method.'</option>';



											} 



											else



											{



												$gym_recurring_enable=get_option("gym_recurring_enable");



												$gmgt_one_time_payment_setting=get_option("gmgt_one_time_payment_setting");



												if($gym_recurring_enable == "yes" || $gmgt_one_time_payment_setting == '1')



												{



													print '<option value="stripe_gym">Stripe</option>';



												}



												else



												{



													print '<option value="Paypal">Paypal</option>';



												}



											} 



										}



										?>						



									</select>



								</div>

								<?php

							} ?>

							<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 input">



								<label class="ml-1 custom-top-label top" for="Membership"><?php esc_html_e('Membership','gym_mgt');?><span class="require-field">*</span></label>



								<?php 	$obj_membership=new MJ_gmgt_membership;



								$membershipdata=$obj_membership->MJ_gmgt_get_all_membership();?>



								<?php if($edit){ $membership_id=$result->membership_id; }elseif(isset($_POST['membership_id'])){$membership_id=$_POST['membership_id'];}else{$membership_id='';}?>



								<select name="membership_id" class="form-control payment_membership_detail coupon_membership_id validate[required]" type="renew_membership" id="membership_id">



									<option value=""><?php esc_html_e('Select Membership ','gym_mgt');?></option>



									<?php 



									if(!empty($membershipdata))



									{



										foreach ($membershipdata as $membership)



										{



											echo '<option value='.$membership->membership_id.' '.selected($membership_id,$membership->membership_id).'>'.$membership->membership_label.'</option>';



										}



									}



									?>



								</select>



							</div>



							<?php wp_nonce_field( 'save_membership_payment_nonce' ); ?>



							



							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



								<div class="form-group input">



									<div class="col-md-12 form-control">



										<input id="begin_date" class="form-control validate[required] date_picker" type="text"  name="start_date" value="<?php if($edit){ echo esc_attr(MJ_gmgt_getdate_in_input_box($result->start_date));}elseif(isset($_POST['start_date'])) echo esc_attr($_POST['start_date']);?>" readonly>



										<label class="date_label" for="triel_date"><?php esc_html_e('Membership Start Date','gym_mgt');?><span class="require-field">*</span></label>



									</div>



								</div>



							</div>



							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



								<div class="form-group input">



									<div class="col-md-12 form-control">



										<input id="end_date" class="form-control validate[required] date_picker"  type="text" name="end_date" value="<?php if($edit){ echo esc_attr(MJ_gmgt_getdate_in_input_box($result->end_date));}elseif(isset($_POST['end_date'])) echo esc_attr($_POST['end_date']);?>" >



										<label class="date_label" for="triel_date"><?php esc_html_e('Membership End Date','gym_mgt');?><span class="require-field">*</span></label>



									</div>



								</div>



							</div>

							<?php

							if($edit == 0){



							?>

							<div class="col-sm-5 col-md-5 col-lg-5 col-xl-5 ">



								<div class="form-group input">



									<div class="col-md-12 form-control">



										<input id="coupon_code" class="form-control coupon_code" type="text" value="" name="coupon_code" >



										<label class="" for=""><?php esc_html_e('Add Coupon Code','gym_mgt');?></label>

										

									</div>

									<span class="coupon_span"></span>

								</div>

							</div>





							<div class="col-sm-12 col-md-1 col-lg-1 col-xl-1 mb-3 rtl_margin_top_15px">	



								<button id=""  class="btn add_btn apply_coupon" ><?php esc_html_e('Apply','gym_mgt');?></button>



							</div>

							<?php

							}

							?>

							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



								<div class="form-group input">



									<div class="col-md-12 form-control">



										<input id="total_amount" class="form-control validate[required,custom[number]] date_picker" type="text" value="<?php if($edit){ echo esc_attr($result->membership_amount);}?>" name="membership_amount" readonly>



										<label class="date_label" for="triel_date"><?php esc_html_e('Membership Amount','gym_mgt');?>(<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?>)<span class="require-field">*</span></label>



									</div>



								</div>



							</div>

							<?php

							if($edit == 0){



							?>

							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 discount_display">



								<div class="form-group input">



									<div class="col-md-12 form-control">



										<input id="coupon_discount" class="form-control" type="text" value="" name="discount" readonly>



										<label class="" for=""><?php esc_html_e('Discount','gym_mgt');?></label>



									</div>



								</div>



							</div>

							<?php

							}

								?>

							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 rtl_margin_top_15px">



								<div class="form-group">



									<div class="col-md-12 form-control">



										<div class="row padding_radio">



											<div class="">



												<label class="custom-top-label" for="member_convert"><?php esc_html_e('Send SMS To Member','gym_mgt');?></label>



												<input id="chk_sms_sent" type="checkbox"  value="1" name="gmgt_sms_service_enable">&nbsp;<?php esc_html_e('Enable','gym_mgt'); ?>



											</div>												



										</div>



									</div>



								</div>



							</div>



						</div>



					</div>	


					<span class="payment_detail_span"></span>
					<div class="form-body user_form"> <!-- user_form Strat-->   



						<div class="row"><!--Row Div Strat--> 



							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">



								<input type="submit" value="<?php if($edit){ esc_html_e('Save','gym_mgt'); }else{ esc_html_e('Save','gym_mgt');}?>" name="save_membership_payment" class="save_member_validate btn save_btn"/>



							</div>



						</div>



					</div>



				</form><!--PAYMENT FORM END-->



			</div><!--PANEL BODY DIV END-->



			<?php



		}



		if($active_tab == 'view_invoice')



		{



			$obj_payment= new MJ_gmgt_payment();







			if($_REQUEST['invoice_type']=='membership_invoice')



			{		



				$obj_membership_payment=new MJ_gmgt_membership_payment;	



				$membership_data=$obj_membership_payment->MJ_gmgt_get_single_membership_payment($_REQUEST['idtest']);



				$history_detail_result = MJ_gmgt_get_payment_history_by_mpid($_REQUEST['idtest']);



			}



			if($_REQUEST['invoice_type']=='income')



			{



				$income_data=$obj_payment->MJ_gmgt_get_income_data($_REQUEST['idtest']);



				$history_detail_result = MJ_gmgt_get_income_payment_history_by_mpid($_REQUEST['idtest']);



			}



			if($_REQUEST['invoice_type']=='expense')



			{



				$expense_data=$obj_payment->MJ_gmgt_get_income_data($_REQUEST['idtest']);



			}



			if($_REQUEST['invoice_type']=='sell_invoice')



			{



				$obj_store=new MJ_gmgt_store;



				$selling_data=$obj_store->MJ_gmgt_get_single_selling($_REQUEST['idtest']);



				$history_detail_result = MJ_gmgt_get_sell_payment_history_by_mpid($_REQUEST['idtest']);



			}



			?>



			<div class="penal-body" id="invoice_print"><!----- penal Body --------->



				<div class="modal-body border_invoice_page margin_top_15px_rs invoice_model_body float_left_width_100 height_600px"><!---- model body  ----->



					<img class="rtl_image_set_invoice invoiceimage float_left invoice_image_model"  src="<?php echo plugins_url('/gym-management/assets/images/invoice.png'); ?>" width="100%">



					<div class="main_div float_left_width_100 payment_invoice_popup_main_div">



						<div class="invoice_width_100 float_left_width_100" border="0">



							<h3 class="school_name_for_invoice_view"><?php echo get_option( 'gmgt_system_name' ) ?></h3>



							<div class="row margin_top_20px">



								<div class="col-md-1 col-sm-2 col-xs-3">



									<div class="width_1 rtl_width_80px">



										<img class="system_logo"  src="<?php echo esc_url(get_option( 'gmgt_gym_other_data_logo' )); ?>">



									</div>



								</div>	



								<div class="col-md-11 col-sm-10 col-xs-9 invoice_address invoice_address_css">	



									<div class="row">	



										<div class="col-md-12 col-sm-12 col-xs-12 invoice_padding_bottom_15px padding_right_0">	



											<label class="popup_label_heading"><?php esc_html_e('Address','gym_mgt'); ?>



											</label><br>



											<label for="" class="label_value word_break_all">	<?php



													echo chunk_split(get_option( 'gmgt_gym_address' ),100,"<BR>").""; 



												?></label>



										</div>



										<div class="row col-md-12 invoice_padding_bottom_15px">	



											<div class="col-md-6 col-sm-6 col-xs-6 address_css padding_right_0 email_width_auto">	



												<label class="popup_label_heading"><?php esc_html_e('Email','gym_mgt');?> </label><br>



												<label for="" class="label_value word_break_all"><?php echo get_option( 'gmgt_email' ),"<BR>";  ?></label>



											</div>



									



											<div class="col-md-6 col-sm-6 col-xs-6 address_css padding_right_0 padding_left_30px">



												<label class="popup_label_heading"><?php esc_html_e('Phone','gym_mgt');?> </label><br>



												<label for="" class="label_value"><?php echo get_option( 'gmgt_contact_number' )."<br>";  ?></label>



											</div>



										</div>	



										<div align="right" class="width_24"></div>									



									</div>				



								</div>



							</div>



							<div class="col-md-12 col-sm-12 col-xl-12 mozila_display_css margin_top_20px">



								<div class="row">



									<div class="width_50a1 float_left_width_100">



										<div class="col-md-8 col-sm-8 col-xs-5 padding_0 float_left display_grid display_inherit_res margin_bottom_20px rs_main_billed_to">



											<div class="billed_to float_left_width_100 display_flex invoice_address_heading rs_width_billed_to">				



												<?php



												$issue_date='DD-MM-YYYY';



												if(!empty($income_data))



												{



													$issue_date=$income_data->invoice_date;



													$payment_status=$income_data->payment_status;



													$invoice_no=$income_data->invoice_no;



												}



												if(!empty($membership_data))



												{



													$issue_date=$membership_data->created_date;



													if($membership_data->payment_status!='0')



													{	



														$payment_status=$membership_data->payment_status;



													}



													else



													{



														$payment_status='Unpaid';



													}		



													$invoice_no=$membership_data->invoice_no;



												}



												if(!empty($expense_data))



												{



													$issue_date=$expense_data->invoice_date;



													$payment_status=$expense_data->payment_status;



													$invoice_no=$expense_data->invoice_no;



												}



												if(!empty($selling_data))



												{



													$issue_date=$selling_data->sell_date;	



													if(!empty($selling_data->payment_status))



													{



														$payment_status=$selling_data->payment_status;



													}	



													else



													{



														$payment_status='Fully Paid';



													}		



													



													$invoice_no=$selling_data->invoice_no;



												}			



													



												?>



												<h3 class="billed_to_lable invoice_model_heading bill_to_width_12 rs_bill_to_width_40"><?php esc_html_e('Bill To','gym_mgt');?> : </h3>



												



												<?php



												if(!empty($expense_data))



												{



													$party_name=$expense_data->supplier_name; 



													echo "<h3 class='display_name invoice_width_100'>".chunk_split(ucwords($party_name),30,"<BR>"). "</h3>";



												}



												else{



													if(!empty($income_data))



														$member_id=$income_data->supplier_name;



													if(!empty($membership_data))



														$member_id=$membership_data->member_id;



													if(!empty($selling_data))



														$member_id=$selling_data->member_id;



													$patient=get_userdata($member_id);						



													echo "<h3 class='display_name invoice_width_100'>".chunk_split(MJ_gmgt_get_user_full_display_name(esc_html($member_id)),30,"<BR>"). "</h3>";







												}



												?>



											</div> 



											<div class="width_60b2 address_information_invoice">



												<?php 	



												if(!empty($expense_data))



												{



													// $party_name=$expense_data->supplier_name; 



													// echo "<h3 class='display_name invoice_width_100'>".chunk_split(ucwords($party_name),30,"<BR>"). "</h3>";



												}



												else



												{



													if(!empty($income_data))



														$member_id=$income_data->supplier_name;



													if(!empty($membership_data))



														$member_id=$membership_data->member_id;



													if(!empty($selling_data))



														$member_id=$selling_data->member_id;



													$patient=get_userdata($member_id);						



													// echo "<h3 class='display_name invoice_width_100'>".chunk_split(ucwords($patient->display_name),30,"<BR>"). "</h3>";



													$address=get_user_meta( $member_id,'address',true );



													$city_name = get_user_meta( $member_id,'city_name',true );



													$zip_code = get_user_meta( $member_id,'zip_code',true );



													echo chunk_split($address,30,"<BR>"); 



													if(!empty($zip_code))

													{
														echo get_user_meta( $member_id,'zip_code',true ).",<BR>"; 
													}



													if(!empty($city_name))



													{



														echo get_user_meta( $member_id,'city_name',true ).","."<BR>"; ; 



													}



												}		



												?>	



											</div>



										</div> 



										<div class="col-md-3 col-sm-4 col-xs-7 float_left">



											<div class="width_50a1112">



												<div class="width_20c" align="center">



													<?php



													if($_REQUEST['invoice_type']!='expense')



													{



														?>	



														<h3 class="invoice_lable"><?php echo esc_html__('INVOICE','gym_mgt')."  #".$invoice_no;?></h3>								



														<?php



													}



													?>



													<h5 class="align_left"> <label class="popup_label_heading text-transfer-upercase"><?php   echo esc_html__('Date :','gym_mgt') ?> </label>&nbsp;  <label class="invoice_model_value"><?php echo MJ_gmgt_getdate_in_input_box(date("Y-m-d", strtotime($issue_date))); ?></label></h5>



													<h5 class="align_left"><label class="popup_label_heading text-transfer-upercase"><?php echo esc_html__('Status :','gym_mgt')?> </label>  &nbsp;<label class="invoice_model_value">
													<?php 
														if($payment_status == 'Unpaid')
														{
															echo '<span style="color:red;">'.esc_html__($payment_status,'gym_mgt').'</span>';
														}
														elseif($payment_status == 'Partially Paid')
														{
															echo '<span style="color:blue;">'.esc_html__($payment_status,'gym_mgt').'</span>';
														}
														elseif($payment_status == 'Part Paid')
														{
															echo '<span style="color:blue;">'.esc_html__($payment_status,'gym_mgt').'</span>';
														}
														elseif($payment_status == 'Paid')
														{
															echo '<span style="color:green;">'.esc_html__($payment_status,'gym_mgt').'</span>';
														} 
														else
														{
															echo '<span style="color:green;">'.esc_html__($payment_status,'gym_mgt').'</span>';
														}
													?>
													</h5>	



												</div> 



											</div> 



										</div> 



									</div> 



								</div>  



							</div>



							<table class="width_100 margin_top_10px_res">	



								<tbody>		



									<tr>



										<td>



											<?php



											if($_REQUEST['invoice_type']=='membership_invoice')



											{ 



												?>



												<h3 class="display_name"><?php esc_attr_e('Membership Entries','gym_mgt');?></h3>



												<?php



											}



											elseif($_REQUEST['invoice_type']=='income')



											{ 



												?>



												<h3 class="display_name"><?php esc_attr_e('Income Entries','gym_mgt');?></h3>



												<?php



											}



											elseif($_REQUEST['invoice_type']=='sell_invoice')



											{ 



												?>



												<h3 class="display_name"><?php esc_attr_e('Sale Product','gym_mgt');?></h3>



												<?php



											}



											else



											{



												?>



												<h3 class="display_name"><?php esc_attr_e('Expense Entries','gym_mgt');?></h3>



												<?php



											}



											?>



											



										<td>	



									</tr>



								</tbody>



							</table>



							<div class="table-responsive table_max_height_180px rtl_padding-left_40px">



								<table class="table model_invoice_table">



									<thead class="entry_heading invoice_model_entry_heading">	



										<?php



										if($_REQUEST['invoice_type']=='membership_invoice')



										{



											?>				



											<tr>



												<th class="entry_table_heading align_center">#</th>



												<th class="entry_table_heading align_center"> <?php esc_attr_e('Date','gym_mgt');?></th>



												<th class="entry_table_heading align_center"><?php esc_attr_e('Membership Name','gym_mgt');?> </th>



												<th class="entry_table_heading align_center"><?php esc_attr_e('Amount','gym_mgt');?></th>



											</tr>



											<?php



										}



										elseif($_REQUEST['invoice_type']=='sell_invoice')



										{



											?>				



											<tr>



												<th class="entry_table_heading align_center">#</th>



												<th class="entry_table_heading align_center"> <?php esc_attr_e('Date','gym_mgt');?></th>



												<th class="entry_table_heading align_center"><?php esc_attr_e('Product Name','gym_mgt');?> </th>



												<th class="entry_table_heading align_center"><?php esc_attr_e('Quantity','gym_mgt');?></th>



												<th class="entry_table_heading align_center"><?php esc_attr_e('Price','gym_mgt');?> </th>



												<th class="entry_table_heading align_center"><?php esc_attr_e('Total','gym_mgt');?></th>



											</tr>



											<?php



										}



										else



										{



											?>				



											<tr>



												<th class="entry_table_heading align_center">#</th>



												<th class="entry_table_heading align_center"> <?php esc_attr_e('Date','gym_mgt');?></th>



												<th class="entry_table_heading align_center"><?php esc_attr_e('Entry','gym_mgt');?> </th>



												<th class="entry_table_heading align_center"><?php esc_attr_e('Amount','gym_mgt');?></th>



											</tr>



											<?php



										}



										?>						



									</thead>



									<tbody>



										<?php 



										$id=1;



										$i=1;



										$total_amount=0;



										if(!empty($income_data) || !empty($expense_data))



										{



											if(!empty($expense_data))



											{



												$income_data=$expense_data;



											}



											



											$member_income=$obj_payment->MJ_gmgt_get_oneparty_income_data_incomeid($income_data->invoice_id);



											



											foreach($member_income as $result_income)



											{



												$income_entries=json_decode($result_income->entry);



												$discount_amount=$result_income->discount;



												$paid_amount=$result_income->paid_amount;



												$total_discount_amount= $result_income->amount - $discount_amount;



												if($result_income->tax_id!='')



												{									



													$total_tax=0;



													$tax_array=explode(',',$result_income->tax_id);



													foreach($tax_array as $tax_id)



													{



														$tax_percentage=MJ_gmgt_tax_percentage_by_tax_id($tax_id);



																			



														$tax_amount=$total_discount_amount * $tax_percentage / 100;



														



														$total_tax=$total_tax + $tax_amount;				



													}



												}



												else



												{



													$total_tax=$total_discount_amount * $result_income->tax/100;



												}



												$due_amount=0;



												$due_amount=$result_income->total_amount - $result_income->paid_amount;



												$grand_total=$total_discount_amount + $total_tax;







												foreach($income_entries as $each_entry)



												{



													$total_amount+=$each_entry->amount;								



													?>



													<tr>



														<td class="align_center invoice_table_data"><?php echo $id;?></td>



														<td class="align_center invoice_table_data"><?php echo MJ_gmgt_getdate_in_input_box($result_income->invoice_date);?></td>



														<td class="align_center invoice_table_data"><?php echo $each_entry->entry; ?> </td>



														<td class="align_center invoice_table_data"><?php echo "<span>".MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ))."</span> ".number_format($each_entry->amount,2); ?></td>



													</tr>



													<?php 



													$id+=1;



													$i+=1;



												}



												if($grand_total=='0')									



												{	



													if($income_data->payment_status=='Paid')



													{



														



														$grand_total=$total_amount;



														$paid_amount=$total_amount;



														$due_amount=0;										



													}



													else



													{



														



														$grand_total=$total_amount;



														$paid_amount=0;



														$due_amount=$total_amount;															



													}



												}



											}



										}



										if(!empty($membership_data))



										{



											$membership_signup_amounts=$membership_data->membership_signup_amount;



											?>



											<tr>



												<td class="align_center invoice_table_data"><?php echo $i;?></td>



												<td class="align_center invoice_table_data"><?php echo MJ_gmgt_getdate_in_input_box($membership_data->created_date);?></td>



												<td class="align_center invoice_table_data"><?php echo MJ_gmgt_get_membership_name($membership_data->membership_id);?></td>



												<td class="align_center invoice_table_data"><?php echo "<span>".MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ))."</span> ".number_format($membership_data->membership_fees_amount,2); ?></td>



											</tr>



											<?php 



											if( $membership_signup_amounts  > 0) 



											{



												?>



												<tr class="">



													<td class="align_center invoice_table_data"><?php echo 2 ;?></td> 



													<td class="align_center invoice_table_data"><?php echo MJ_gmgt_getdate_in_input_box($membership_data->created_date);?></td> 



													<td class="align_center invoice_table_data"><?php esc_html_e('Membership Signup Fee','gym_mgt');?></td>								



													<td class="align_center invoice_table_data"><?php echo "<span>".MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ))."</span> ".number_format($membership_data->membership_signup_amount,2); ?></td>



												</tr>



												<?php



											}



										}



										if(!empty($selling_data))



										{



											$all_entry=json_decode($selling_data->entry);



											if(!empty($all_entry))



											{



												foreach($all_entry as $entry)



												{



													$obj_product=new MJ_gmgt_product;



													$product = $obj_product->MJ_gmgt_get_single_product($entry->entry);



												



													$product_name=$product->product_name;					



													$quentity=$entry->quentity;	



													$price=$product->price;	







													?>



													<tr class="">										



														<td class="align_center invoice_table_data"><?php echo $i;?></td> 



														<td class="align_center invoice_table_data"><?php echo MJ_gmgt_getdate_in_input_box($selling_data->sell_date);?></td>



														<td class="align_center invoice_table_data"><?php echo $product_name;?> </td>



														<td  class="align_center invoice_table_data"> <?php echo $quentity; ?></td>



														<td class="align_center invoice_table_data"><?php echo MJ_gmgt_get_floting_value($price); ?></td>



														<td class="align_center invoice_table_data"><?php echo "<span>".MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ))."</span> ".number_format($quentity * $price,2); ?></td>



													</tr>



													<?php



													$id+=1;



													$i+=1;



												}



											}



											else



											{



												$obj_product=new MJ_gmgt_product;



												$product = $obj_product->MJ_gmgt_get_single_product($selling_data->product_id); 



												



												$product_name=$product->product_name;					



												$quentity=$selling_data->quentity;	



												$price=$product->price;	



												?>



												<tr class="">										



													<td class="align_center invoice_table_data"><?php echo $i;?></td> 



													<td class="align_center invoice_table_data"><?php echo MJ_gmgt_getdate_in_input_box($selling_data->sell_date);?></td>



													<td class="align_center invoice_table_data"><?php echo $product_name;?> </td>



													<td  class="align_center invoice_table_data"> <?php echo $quentity; ?></td>



													<td class="align_center invoice_table_data"> <?php echo $price; ?></td>



													<td class="align_center invoice_table_data"> <?php echo "<span>".MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ))."</span> ".number_format($quentity * $price,2); ?></td>



												</tr>



												<?php



												$id+=1;



												$i+=1;



											}



										}



										?>



									</tbody>



								</table>



							</div>



							<div class="table-responsive rtl_padding-left_40px rtl_float_left_width_100px">



								<?php 



								if(!empty($membership_data))



								{

									if(!empty($membership_data->tax_id)){

										$tax_name = MJ_gmgt_tax_name_by_tax_id_array_for_invoice(esc_html($membership_data->tax_id));

									}

									else{

										$tax_name = '';

									}

									$total_amount=$membership_data->membership_fees_amount+$membership_data->membership_signup_amount;



									$discount_amount = $membership_data->discount_amount;



									$total_tax=$membership_data->tax_amount;							



									$paid_amount=$membership_data->paid_amount;



									$due_amount=abs($membership_data->membership_amount - $paid_amount);



									$grand_total=$membership_data->membership_amount;							



								}



								if(!empty($expense_data))



								{



									$grand_total=$total_amount;



								}



								if(!empty($selling_data))



								{



									$all_entry=json_decode($selling_data->entry);



									



									if(!empty($all_entry))



									{



										$total_amount=$selling_data->amount;



										$discount_amount=$selling_data->discount;



										$total_discount_amount=$total_amount-$discount_amount;



										



										if($selling_data->tax_id!='')



										{									



											$total_tax=0;



											$tax_array=explode(',',$selling_data->tax_id);



											foreach($tax_array as $tax_id)



											{



												$tax_percentage=MJ_gmgt_tax_percentage_by_tax_id($tax_id);



																	



												$tax_amount=$total_discount_amount * $tax_percentage / 100;



												



												$total_tax=$total_tax + $tax_amount;				



											}



										}



										else



										{



											$tax_per=$selling_data->tax;



											$total_tax=$total_discount_amount * $tax_per/100;



										}



										



										$paid_amount=$selling_data->paid_amount;



										$due_amount=abs($selling_data->total_amount - $paid_amount);



										$grand_total=$selling_data->total_amount;



									}



									else



									{	



										$obj_product=new MJ_gmgt_product;



										$product = $obj_product->MJ_gmgt_get_single_product($selling_data->product_id);



										$price=$product->price;	



										



										$total_amount=$price*$selling_data->quentity;



										$discount_amount=$selling_data->discount;



										$total_discount_amount=$total_amount-$discount_amount;



										



										if($selling_data->tax_id!='')



										{									



											$total_tax=0;



											$tax_array=explode(',',$selling_data->tax_id);



											foreach($tax_array as $tax_id)



											{



												$tax_percentage=MJ_gmgt_tax_percentage_by_tax_id($tax_id);



																	



												$tax_amount=$total_discount_amount * $tax_percentage / 100;



												



												$total_tax=$total_tax + $tax_amount;				



											}



										}



										else



										{



											$tax_per=$selling_data->tax;



											$total_tax=$total_discount_amount * $tax_per/100;



										}



																		



										$paid_amount=$total_amount;



										$due_amount='0';



										$grand_total=$total_amount;								



									}		



								}							



								?>



								<div class="row width_100 col-md-12 col-sm-12 col-lg-12">



									<div class="col-md-7 col-sm-7 col-lg-7 col-xs-12">



										<h3 class="display_name align_left"><?php esc_attr_e('Payment Method','gym_mgt');?></h3>



										<table width="100%" border="0">



											<tbody>							



												<tr style="">



													<td class="label_min_width_130px rtl_float_left_label padding_bottom_15px total_heading"><?php esc_attr_e('Bank Name','gym_mgt');?></td>



													<td class="rtl_width_15px padding_bottom_15px total_value">:&nbsp;&nbsp;<?php echo get_option( 'gmgt_bank_name' );?></td>



												</tr>



												<tr style="">



													<td  class="label_min_width_130px rtl_float_left_label padding_bottom_15px total_heading"><?php esc_attr_e('Account No.','gym_mgt');?></td>



													<td class="rtl_width_15px padding_bottom_15px total_value">:&nbsp;&nbsp;<?php echo get_option( 'gmgt_bank_acount_number' );?></td>



												</tr>



												<tr style="">



													<td  class="label_min_width_130px rtl_float_left_label padding_bottom_15px total_heading"><?php esc_attr_e('IFSC Code','gym_mgt');?></td>



													<td class="rtl_width_15px padding_bottom_15px total_value">:&nbsp;&nbsp;<?php echo get_option( 'gmgt_bank_ifsc_code' );?></td>



												</tr>



												<tr style="">



													<td  class="label_min_width_130px rtl_float_left_label padding_bottom_15px total_heading"><?php esc_attr_e('Paypal ID','gym_mgt');?></td>



													<td class="rtl_width_15px padding_bottom_15px total_value">:&nbsp;&nbsp;<?php echo get_option( 'gmgt_paypal_email' );?></td>



												</tr>



											</tbody>



										</table>



									</div>



									<div class="col-md-5 col-sm-5 col-lg-5 col-xs-12">



										<table width="100%" border="0">



											<tbody>							



												<tr style="">



													<td  align="right" class="rtl_float_left_label padding_bottom_15px total_heading"><?php esc_attr_e('Sub Total :','gym_mgt');?></td>



													<td align="left" class="rtl_width_15px padding_bottom_15px total_value"><?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?><?php echo number_format($total_amount,2);?></td>



												</tr>



												<?php



												if($_REQUEST['invoice_type']!='expense')



												{

													?>



													<tr>



														<td width="85%" class="rtl_float_left_label padding_bottom_15px total_heading" align="right"><?php esc_attr_e('Discount Amount :','gym_mgt');?></td>



														<td align="left" class="rtl_width_15px padding_bottom_15px total_value"><?php  echo "-";echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?><?php if(!empty($discount_amount)){ echo number_format($discount_amount,2);}else{ echo number_format('0',2);} ?></td>



													</tr>



													<tr>

														

														<td width="85%" class="rtl_float_left_label padding_bottom_15px total_heading" align="right"><?php echo esc_attr__('Tax Amount','gym_mgt').'('.$tax_name.')'.' :';?></td>



														<td align="left" class="rtl_width_15px padding_bottom_15px total_value"><?php  echo "+";echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?><?php echo number_format($total_tax,2); ?></td>



													</tr>



													<tr>



														<td width="85%" class="rtl_float_left_label padding_bottom_15px total_heading" align="right"><?php esc_attr_e('Due Amount :','gym_mgt');?></td>



														<?php if(!empty($fees_detail_result->total_amount)){ $Due_amount = $fees_detail_result->total_amount - $fees_detail_result->fees_paid_amount; } ?>



														<td align="left" class="rtl_width_15px padding_bottom_15px total_value"><?php  echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?><?php echo number_format($due_amount,2); ?></td>



													</tr>



													<tr>



														<td width="85%" class="rtl_float_left_label padding_bottom_15px total_heading" align="right"><?php esc_attr_e('Paid Amount :','gym_mgt');?></td>



														<td align="left" class="rtl_width_15px padding_bottom_15px total_value"><?php  echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?><?php echo number_format($paid_amount,2); ?></td>



													</tr>	



													<?php



												}	



												?>		



											</tbody>



										</table>



									</div>



								</div>



							</div>



							<div class="rtl_float_left row margin_top_10px_res col-md-4 col-sm-4 col-xs-4 view_invoice_lable_css inovice_width_100px_rs float_left grand_total_div invoice_table_grand_total" style="float: right;margin-right:0px;">



								<div class="width_50_res align_right col-md-5 col-sm-5 col-xs-5 view_invoice_lable padding_11 padding_right_0_left_0 float_left grand_total_label_div invoice_model_height line_height_1_5 padding_left_0_px"><h3 style="float: right;" class="padding color_white margin invoice_total_label"><?php esc_html_e('Grand Total','gym_mgt');?> </h3></div>



								<div class="width_50_res align_right col-md-7 col-sm-7 col-xs-7 view_invoice_lable  padding_right_5_left_5 padding_11 float_left grand_total_amount_div"><h3 style="float: left;" class="padding margin text-right color_white invoice_total_value"><?php echo "<span>".MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ))."</span> ".number_format($grand_total,2); ?></h3></div>



							</div>



							<?php				



							if(!empty($history_detail_result))



							{



								?>



								<hr class="width_100 flot_left_invoice_history_hr">



								<table class="width_100">	



									<tbody>	



										<tr>



											<td>



												<h3  class="display_name"><?php esc_html_e('Payment History','gym_mgt');?></h3>



											</td>	



										</tr>	



									</tbody>



								</table>



								<div class="table-responsive rtl_padding-left_40px table_max_height_250px">



									<table class="table model_invoice_table">



										<thead class="entry_heading invoice_model_entry_heading">



											<tr>



												<th class="entry_table_heading align_left"><?php esc_attr_e('Date','gym_mgt');?></th>



												<th class="entry_table_heading align_left"> <?php esc_attr_e('Amount','gym_mgt');?></th>



												<th class="entry_table_heading align_left"><?php esc_attr_e('Method','gym_mgt');?> </th>



												<th class="entry_table_heading align_left"><?php esc_html_e('Payment Details','gym_mgt');?></th>



											</tr>



										</thead>



										<tbody>



											<?php 



											foreach($history_detail_result as  $retrive_data)



											{



												?>



												<tr>



													<td class="align_left invoice_table_data"><?php echo MJ_gmgt_getdate_in_input_box($retrive_data->paid_by_date);?></td>



													<td class="align_left invoice_table_data"><?php echo "<span>".MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ))."</span> ".MJ_gmgt_get_floting_value($retrive_data->amount); ?></td>



													<td class="align_left invoice_table_data"><?php echo  esc_html__($retrive_data->payment_method,"gym_mgt"); ?></td>



													<td class="align_left invoice_table_data"><?php if(!empty($retrive_data->payment_description)){ echo  $retrive_data->payment_description; }else{ echo 'N/A'; }?></td>



												</tr>



												<?php 



											} ?>



										</tbody>



									</table>



								</div>



								<?php



							}



							?>



							<div class="col-md-12 grand_total_main_div rtl_margin_top_15px total_padding_15px rtl_float_none margin_top_20px">



								<div class="row margin_top_10px_res rtl_margin_top_15px width_50_res col-md-6 col-sm-6 col-xs-6 print-button pull-left invoice_print_pdf_btn">



									<div class="col-md-2 print_btn_rs width_50_res">



										<a href="?page=invoice&print=print&invoice_id=<?php echo $_REQUEST['idtest'];?>&invoice_type=<?php echo $_REQUEST['invoice_type'];?>" target="_blank" class="btn btn save_btn invoice_btn_div"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/print.png" ?>" > </a>



									</div>



									<div class="col-md-3 pdf_btn_rs width_50_res">



										<a href="?page=invoice&pdf=pdf&invoice_id=<?php echo $_REQUEST['idtest'];?>&invoice_type=<?php echo $_REQUEST['invoice_type'];?>" target="_blank" class="btn color_white invoice_btn_div btn save_btn"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/pdf.png" ?>" ></a>



									</div>



								</div>



							</div>



						</div>



					</div><!---------- Main Div ---------------->



				</div><!--------- Model Body --------------->



			</div><!----- penal Body --------->



			<?php



		}



		?>



    </div><!--TAB CONTENT DIV END-->



</div><!--PANEL BODY DIV END-->



</div><!--TAB CONTENT DIV END-->