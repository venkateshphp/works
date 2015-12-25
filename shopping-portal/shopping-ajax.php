<?php
@ob_start();
@session_start();
include_once('../../../wp-config.php');

global $post,$wpdb;

if($_REQUEST['action']=='details_of_company_user') {
	$a_company_data_ajax= $_REQUEST['a_company_data_ajax'];
	$explode_data = explode('_', $a_company_data_ajax);
$validation_data = get_user_meta($explode_data[0], 'user_clicked_company_identify', false);
//print_r($validation_data);
	if(!in_array($a_company_data_ajax, $validation_data)){
		add_user_meta( $explode_data[0], 'user_clicked_company_identify', $a_company_data_ajax);
	}
 }
 if($_REQUEST['action']=='delete_details_of_company_user_store') {
	$a_company_data_ajax_del = $_REQUEST['a_company_data_ajax_del'];
	$current_user = wp_get_current_user();
	//$explode_data = explode('_', $a_company_data_ajax_del);
	delete_user_meta( $current_user->ID, 'user_stored',$a_company_data_ajax_del);
	echo 'success';
 }
 if($_REQUEST['action']=='details_of_company_user_member') {
	$a_company_data_ajax_member = $_REQUEST['a_company_data_ajax_member'];
	$current_user = wp_get_current_user();
	//$explode_data = explode('_', $a_company_data_ajax_del);
	delete_user_meta( $current_user->ID, 'user_stored',$a_company_data_ajax_member);
	echo 'success';
 }
if($_REQUEST['action']=='add_favourite_company_user_store') { 
	$a_favourite_check_post= $_REQUEST['a_favourite_check_post'];
	$current_user = wp_get_current_user();
	$favourite_data = get_user_meta($current_user->ID, 'user_favourite_store', false);
//print_r($validation_data);
	if(!in_array($a_favourite_check_post, $favourite_data)){
		add_user_meta( $current_user->ID, 'user_favourite_store', $a_favourite_check_post);
		echo 'success';
	}else {
	delete_user_meta( $current_user->ID, 'user_favourite_store',$a_favourite_check_post);
	}	
}

if($_REQUEST['action']=='user_login_post_values') {
//for login action
$user_name= $_REQUEST['a_username'];
$password_login= $_REQUEST['a_password_login'];
$user_ID = username_exists( $user_name );
$check = wp_authenticate_username_password( NULL, $user_name, $password_login );
if(is_wp_error( $check )){
echo 'Please Check Your Login Details';
 } else { 
	wp_set_current_user($user_ID, $user_name);
	wp_set_auth_cookie($user_ID);
	do_action('wp_login', $user_name);
 	echo 'success';
 	}
 }
 if($_REQUEST['action']=='user_update_post_values') {
	$a_fname_updatee= $_REQUEST['a_fname_updatee'];
	$a_lname_update= $_REQUEST['a_lname_update'];
	
	$address_update= $_REQUEST['a_address_update'];
	$apartment_update= $_REQUEST['a_apartment_update'];
	$city_update= $_REQUEST['a_city_update'];
	$state_update = $_REQUEST['a_state_update'];
	$country_update = $_REQUEST['a_country_update'];
	
	
	$zip_update= $_REQUEST['a_zip_update'];
	
	$email_conf_update = $_REQUEST['a_email_conf_update'];
	$a_repeat_password_update = $_REQUEST['a_repeat_password_update'];
	$paypal_id_update = $_REQUEST['a_paypal_id_update'];
	$paypal_check_select_update = $_REQUEST['a_paypal_check_select_update'];
	$current_user = wp_get_current_user();
	
	$result_user_id = wp_update_user( array( 'ID' => $current_user->ID, 'user_email' => $email_conf_update ) );
	if(!empty($a_repeat_password_update)){
	wp_set_password( $a_repeat_password_update, $current_user->ID );
	}
		if ( is_wp_error( $result_user_id ) ) {
	//There was an error, probably that user doesn't exist.
	echo 'Error While Update User Mail. Try Again';

	}
	update_user_meta( $current_user->ID, 'first_name', $a_fname_updatee);
	update_user_meta( $current_user->ID, 'last_name', $a_lname_update);
	
	
	update_user_meta( $current_user->ID, 'user_address', $address_update);
	update_user_meta( $current_user->ID, 'user_apartment', $apartment_update);
	update_user_meta( $current_user->ID, 'user_city', $city_update);
	update_user_meta( $current_user->ID, 'user_country', $country_update);
	update_user_meta( $current_user->ID, 'user_state', $state_update);
	update_user_meta( $current_user->ID, 'user_zip', $zip_update);
	
	update_user_meta( $current_user->ID, 'user_paypal_check_radio', $paypal_check_select_update);
	
	$updated_paypal_id = get_user_meta($current_user->ID, 'user_paypal', true);
	$updated_check_details = get_user_meta($current_user->ID, 'user_check', true);
		
	if(($updated_paypal_id == '') && ($updated_check_details == '')){
	update_user_meta( $current_user->ID, 'user_paypal', $paypal_id_update);
	update_user_meta( $current_user->ID, 'user_check', $paypal_check_select_update);
	} else {
	$paypal_update_assign = '';
	$paypale_name_update_assign = '';
	update_user_meta( $current_user->ID, 'user_paypal', $paypal_update_assign);
	update_user_meta( $current_user->ID, 'user_check', $paypale_name_update_assign);
	
	}
	echo 'success';
 }
if($_REQUEST['action']=='show_hide_category_stores') { 
	$a_category_id_pass= $_REQUEST['a_category_id_pass'];
	$taxonomy_name = 'store_cat';
	$store_posts = get_posts(array('post_type' => 'stores', 'posts_per_page' => -1 ,'tax_query' => array( array( 'taxonomy' => $taxonomy_name, 'field' => 'term_id', 'terms' => $a_category_id_pass))));
	foreach($store_posts as $store_post){
		echo '<div class="inner_portal_store">';
			echo '<div class="logo_store">';
				$url = wp_get_attachment_image_src( get_post_thumbnail_id($store_post->ID), 'product_page_list');
				$trimmed_words = wp_trim_words($store_post->post_content, 11);
				$store_offer_code = get_post_meta( $store_post->ID, 'store_offer_code', true );
				echo '<img src="'.$url[0].'" />';
			echo '</div>';
			echo '<div class="logo_store">';
				echo '<h3 style="border:none;margin: 30% 0;">'.$store_post->post_title.'</h3>';
			echo '</div>';
			echo '<div class="logo_store">';
				echo '<p>'.$trimmed_words.'</p>';
			echo '</div>';
			echo '<div class="logo_store">';
				echo '<h3 style="border:none;margin: 30% 0;">'.$store_offer_code.'</h3>';
			echo '</div>';
			echo '<div class="logo_store">';
				echo '<input id="'.$store_post->ID.'" class="favourite_check" type="checkbox" name="favourite_check" value="'.$store_post->ID.'">';
			echo '</div>';
		echo '</div>';
	}
 }
if($_REQUEST['action']=='user_signup_post_values') {

$first_name= $_REQUEST['a_firstname'];
$last_name= $_REQUEST['a_last_name'];
$address= $_REQUEST['a_address'];
//$apartment= $_REQUEST['a_apartment'];
$city= $_REQUEST['a_city'];
$state= $_REQUEST['a_state'];

$country= $_REQUEST['a_country'];

$zip= $_REQUEST['a_zip'];
$email= $_REQUEST['a_email'];
$username = $_REQUEST['a_username'];

$paypal_check_select= $_REQUEST['a_paypal_check_select'];

$paypal= $_REQUEST['a_paypal'];
//$paypale_name= $_REQUEST['a_paypale_name'];
$check= $_REQUEST['a_check'];
$repeat_password= $_REQUEST['a_repeat_password'];

if( email_exists( $email )) {
     echo 'User Already Exists.Try Agin With Another Mail ID.';
   } else {
$userdata = array(
    'user_login'    =>  $username,
    'user_pass'  => $repeat_password,
	'user_nicename'  => $first_name,
	'user_email'  => $email,
	'display_name '  => $username,
);
$user_id = wp_insert_user( $userdata ) ;

add_user_meta( $user_id, 'user_address', $address);
//add_user_meta( $user_id, 'user_apartment', $apartment);
add_user_meta( $user_id, 'user_country', $country);
add_user_meta( $user_id, 'user_city', $city);
add_user_meta( $user_id, 'user_state', $state);
add_user_meta( $user_id, 'user_zip', $zip);

add_user_meta( $user_id, 'user_paypal_check_radio', $paypal_check_select);

//if(($paypal != '') && ($paypale_name != '')){
add_user_meta( $user_id, 'user_paypal', $paypal);
//add_user_meta( $user_id, 'user_paypale_name', $paypale_name);
//}
//if($check != ''){
add_user_meta( $user_id, 'user_check', $check);
//}
update_user_meta( $user_id, 'first_name', $first_name);
update_user_meta( $user_id, 'last_name', $last_name);

$to = $email;
$admin_email = get_option( 'admin_email' );
			$subject = 'Be-In-One';
			$message = '<html>
						<head>
						<title>Be-In-One Registration</title>
						</head>
						<body>
						<div style="background:#EEEEEE; width:748px; padding:25px;">
							<table align="center" border="0" cellpadding="4" cellspacing="4">
								<tr style="margin-bottom:20px; float:right;">
									<td colspan="3" valign="top"><img src="'.get_bloginfo('template_url').'/images/logo.png" width="242" height="95" align="right"></td>
								</tr>
								<tr>
									<td align="center" style="padding:0;">
										<table style="background:#FFF; padding:25px; margin:0 0 15px 0; color:#000000;border:5px solid #626262;">	
											<tr style="margin-bottom:5px; float:left; width:100%;">
												<td width="450" valign="top"><font size="2" face="Verdana, Arial, Helvetica, sans-serif;">A New User registered in Be-In-One. Their details are as follows : </font></td>
											</tr>
											<tr style="margin-bottom:5px; float:left; width:100%;">
												<td width="110" valign="top"><font size="2" face="Verdana, Arial, Helvetica, sans-serif;"><strong>Email ID</strong> </font></td>
												<td valign="top">:</td>
												<td valign="top"><font size="2" face="Verdana, Arial, Helvetica, sans-serif;"> '.$email.' </font></td>
											</tr>
											<tr style="margin-bottom:5px; float:left; width:100%;">
												<td width="110" valign="top"><font size="2" face="Verdana, Arial, Helvetica, sans-serif;"><strong>UserName</strong> </font></td>
												<td valign="top">:</td>
												<td valign="top"><font size="2" face="Verdana, Arial, Helvetica, sans-serif;"> '.$username.' </font></td>
											</tr>
											<tr style="margin-bottom:5px; float:left; width:100%;">
												<td width="110" valign="top"><font size="2" face="Verdana, Arial, Helvetica, sans-serif;"><strong>Password</strong> </font></td>
												<td valign="top">:</td>
												<td valign="top"><font size="2" face="Verdana, Arial, Helvetica, sans-serif;"> '.$repeat_password.' </font></td>
											</tr>
											<tr>
												<td style="border-bottom:1px dotted #cccccc;" colspan="3" valign="top"></td>
											</tr>
										</table>
									</td>
								</tr>	
							</table>
						</div>
						</body>
						</html>';
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From:Be-One-In <'.$admin_email .'>' . "\r\n";
			$headers .= 'Reply-To: '.$admin_email. "\r\n"; 
wp_mail ( $to, $subject, $message, $headers, '');
wp_set_current_user($user_id, $username);
wp_set_auth_cookie($user_id);
do_action('wp_login', $username);
echo 'success';
	}
}
 if($_REQUEST['action']=='user_forgot_post_values') {
// for forget password section
$forgot_email= $_REQUEST['a_forgot_email'];
if( email_exists( $forgot_email )) {
      	$new_password = wp_generate_password($length = 8, $special_chars = true);
		$user = get_user_by( 'email', $forgot_email );
		wp_set_password( $new_password, $user->ID );
		$to = $forgot_email;
		$admin_email = get_option( 'admin_email' );
		$subject = 'Be-In-One - New Password';
			$message = '<html>
						<head>
						<title>Be-In-One Forgot Password</title>
						</head>
						<body>
						<div style="background:#EEEEEE; width:748px; padding:25px;">
							<table align="center" border="0" cellpadding="4" cellspacing="4">
								<tr style="margin-bottom:20px; float:right;">
									<td colspan="3" valign="top"><h1>Be-In-One</h1></td>
								</tr>
								<tr>
									<td align="center" style="padding:0;">
										<table style="background:#FFF; padding:25px; margin:0 0 15px 0; color:#000000;border:5px solid #626262;">	
											<tr style="margin-bottom:5px; float:left; width:100%;">
												<td width="450" valign="top"><font size="2" face="Verdana, Arial, Helvetica, sans-serif;">Your Password Has Been Successfully Changed....!<br><br>New Password Details are following Below : </font></td>
											</tr>
											<tr style="margin-bottom:5px; float:left; width:100%;">
												<td width="150" valign="top"><font size="2" face="Verdana, Arial, Helvetica, sans-serif;"><strong>Your New Password</strong> </font></td>
												<td valign="top">:</td>
												<td valign="top"><font size="2" face="Verdana, Arial, Helvetica, sans-serif;"> '.$new_password.' </font></td>
											</tr>
											<tr>
												<td style="border-bottom:1px dotted #cccccc;" colspan="3" valign="top"></td>
											</tr>
										</table>
									</td>
								</tr>	
								<tr style="text-align:center;">
									<td style="color:#626262;" colspan="3" valign="top"><font size="2" face="Verdana, Arial, Helvetica, sans-serif;">Copyright &copy; '.date('Y').' <a href="http://www.lablibro.com" style="color:#52B5C8;text-decoration:none;">lalibro.com</a> . All Rights Reserved.</font> </td>
								</tr>
							</table>
						</div>
						</body>
						</html>';
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From: '.$admin_email . "\r\n";
			$headers .= 'Reply-To: '.$admin_email. "\r\n"; 
		wp_mail ( $to, $subject, $message, $headers, '');
		echo "Success";
   } else {
   echo 'Your Email-ID Doesnot exist';
   }
 }

?>