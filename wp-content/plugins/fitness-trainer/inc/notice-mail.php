<?php
global $wpdb;	
		
	$email_body = get_option( 'ep_fitness_contact_email');
	$contact_email_subject = get_option( 'ep_fitness_contact_email_subject');			
					
		$admin_mail = get_option('admin_email');	
		if( get_option( 'admin_email_ep_fitness' )==FALSE ) {
			$admin_mail = get_option('admin_email');						 
		}else{
			$admin_mail = get_option('admin_email_ep_fitness');								
		}						
	
	$wp_title = get_bloginfo();
	
					

	// Email for Client	
	$author_id = get_post_field ('post_author', $post_id_review);
	$user_info = get_userdata( $author_id);		
		
	$client_email_address =$user_info->user_email;
	
	
	$email_body = str_replace("[iv_member_sender_email]","", $email_body);
	$email_body = str_replace("Sender Email:", "", $email_body);
	$email_body = str_replace("New Message", "Expert Review", $email_body);	
	
	$email_body = str_replace("[iv_member_directory]", "", $email_body);
	$email_body = str_replace("Your Directory :", "", $email_body);	
	$email_body = str_replace("[iv_member_message]", $review_data, $email_body);	
	
	
			
	$auto_subject=  $contact_email_subject; 
	
	$headers = array("From: " . $wp_title . " <" . $admin_mail . ">", "Reply-To: ".$client_email_address  ,"Content-Type: text/html");
	
		
	$h = implode("\r\n", $headers) . "\r\n";
	wp_mail($client_email_address, $auto_subject, $email_body, $h);
	
	// Contact Email 

	
	
	
