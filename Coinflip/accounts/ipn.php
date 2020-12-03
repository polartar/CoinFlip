<?php
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
$mail = new PHPMailer\PHPMailer\PHPMailer();

include '../settings.php';

if((isset($_POST) && !empty($_POST))){
	$cp_merchant_id = 'f17e51d71496f582f6b524f872651c54'; 
	$cp_ipn_secret  = '4990'; 
	
	if(!isset($_POST['ipn_mode']) || $_POST['ipn_mode'] != 'hmac') { 
		$msgbody.= "<br>IPN Mode is not HMAC";
		die; 
	} 

	if(!isset($_SERVER['HTTP_HMAC']) || empty($_SERVER['HTTP_HMAC'])) { 
		$msgbody.= "<br>No HMAC signature sent";
		die; 
	} 

	$request = file_get_contents('php://input'); 
	if ($request === FALSE || empty($request)) { 
		$msgbody.= "<br>Error reading POST data";
		die;
	} 

	if (!isset($_POST['merchant']) || $_POST['merchant'] != trim($cp_merchant_id)) { 
		$msgbody.= "<br>No or incorrect Merchant ID passed";
		die;
	} 

	$hmac = hash_hmac("sha512", $request, trim($cp_ipn_secret)); 
	if ($hmac != $_SERVER['HTTP_HMAC']) { 
		$msgbody.= "<br>HMAC signature does not match";
		die;
	} 

	// HMAC Signature verified at this point, load some variables. 
	/*$txn_id      = 'CPDI0MNSQ73BCWVIB6RWYPUEB2'; 
	$amount1     = 150; 
	$amount2     = 0.01455862; 
	$currency1   = 'USD'; 
	$currency2   = 'BTC'; 
	$status      = '100'; 
	$status_text = 'Success'; */
	
	$txn_id      = $_POST['txn_id']; 
	$amount1     = $_POST['amount1']; 
	$amount2     = $_POST['amount2']; 
	$currency1   = $_POST['currency1']; 
	$currency2   = $_POST['currency2']; 
	$status      = $_POST['status']; 
	$status_text = $_POST['status_text']; 

	//GET USER DEPOSIT DATA FROM TXN ID
	$query = $db->query('SELECT * FROM `user_deposit` WHERE `txn_id`="'.$txn_id.'"');
	$user_deposit = $query->fetch();
	
	if($user_deposit){
		//These would normally be loaded from your database, the most common way is to pass the Order ID through the 'custom' POST field. 
		$subject   = "IPN Call Successfully!::".$status_text;
		$order_currency = 'USD'; 

		// Check the original currency to make sure the buyer didn't change it. 
		if ($currency1 != $order_currency) { 
			$msgbody.= "<br>Original currency mismatch!";
			die;
		}     

		// Check amount against order total 
		if ($amount1 < $user_deposit['amount']) { 
			$msgbody.= "<br>Amount is less than order total!";
			die;
		} 

		if ($status < 0) { 
		 	// Failures/Errors
			$db->query("UPDATE `user_deposit` SET `status` = '".$status."', `status_text` = '".$status_text."' WHERE `id` = '".$user_deposit['id']."'"); 
		}else if ($status >= 100) { 
		 	// payment is complete or queued for nightly payout, success 
			$db->query("UPDATE `user_deposit` SET `status` = '".$status."', `status_text` = '".$status_text."' WHERE `id` = '".$user_deposit['id']."'"); 
			//Get user data
			$user_query = $db->query('SELECT * FROM `users` WHERE `id`="'.$user_deposit['userID'].'"');
			$user_data = $user_query->fetch();
			
			$db->query("UPDATE `users` set `balance` =".($user_data['balance']+$amount1)." WHERE `id` = " .$user_data['id']);
			
			//Send email to Admin
			try {
				//Server settings
				$mail->SMTPDebug = 2;                                       // Enable verbose debug output
				$mail->isSMTP();                                            // Set mailer to use SMTP
				$mail->Host       = 'smtp.gmail.com';  // Specify main and backup SMTP servers
				$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
				$mail->Username   = 'btcbattles.com.no.reply@gmail.com';                     // SMTP username
				$mail->Password   = '&uZCC6YVDxB3g*ez';                               // SMTP password
				$mail->SMTPSecure = 'ssl';                                  // Enable TLS encryption, `ssl` also accepted
				$mail->Port       = 465;                                    // TCP port to connect to
			
				//Recipients
				$mail->setFrom('btcbattles.com.no.reply@gmail.com', 'No-reply - BTCBattles.com');
				$mail->addAddress('btcbattles@gmail.com', 'BTC Battles');
			
				// Content
				$mail->isHTML(true);                                  // Set email format to HTML
				$mail->Subject = 'Deposit Confirmation on BTC Battles';
				$mail->Body    = 'Hi Admin,<br>
				One of user has deposited $'.$amount1.' on BTC Battles. Please find details below.<br><br>
				<table cellspacing="0" cellpadding="10" border="0" width="50%" style="border-color: #e1e1e1;color: #666666;">
					<tr>
						<td width="30%" style="background-color: #f5f5f5;border-bottom: 1px solid #ccc;border-right: 1px solid #ccc;">User Email</td>
						<td width="70%" style="background-color: #f5f5f5;border-bottom: 1px solid #ccc;">'.$user_data['email'].'</td>
					</tr>
					<tr>
						<td width="30%" style="border-bottom: 1px solid #ccc;border-right: 1px solid #ccc;">Amount($)</td>
						<td width="70%" style="border-bottom: 1px solid #ccc;">$'.$amount1.'</td>
					</tr>
					<tr>
						<td width="30%" style="background-color: #f5f5f5;border-bottom: 1px solid #ccc;border-right: 1px solid #ccc;">Amount (BTC)</td>
						<td width="70%" style="background-color: #f5f5f5;border-bottom: 1px solid #ccc;">'.$amount2.' BTC</td>
					</tr>
                    <tr>
                        <td width="30%" style="border-bottom: 1px solid #ccc;border-right: 1px solid #ccc;">Transactions ID</td>
                        <td width="70%" style="background-color: #f5f5f5;border-bottom: 1px solid #ccc;">' . $txn_id . '</td>
                    </tr>
					<tr>
						<td width="30%" style="border-bottom: 1px solid #ccc;border-right: 1px solid #ccc;">Date</td>
						<td width="70%" style="border-bottom: 1px solid #ccc;">' . date("j F, Y", strtotime($user_deposit['date_created'])) . '</td>
					</tr>
				</table>';
				
				$mail->send();
			
			} catch (Exception $e) {
				echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
			}

		}else { 
			if($status==0){
				$status_text = 'Waiting for depositor funds...';
			}
			//Payment is Pending in some way 
			$db->query("UPDATE `user_deposit` SET `status` = '".$status."', `status_text` = '".$status_text."' WHERE `id` = '".$user_deposit['id']."'");
		}
	}
	else{
		$msgbody.= "<br>No transactions data found!::".$txn_id;
		die;
	}
}


/*try {
	//Server settings
	$mail->SMTPDebug = 2;                                       // Enable verbose debug output
	$mail->isSMTP();                                            // Set mailer to use SMTP
	$mail->Host       = 'smtp.gmail.com';  // Specify main and backup SMTP servers
	$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
	$mail->Username   = 'btcbattles.com.no.reply@gmail.com';                     // SMTP username
	$mail->Password   = '&uZCC6YVDxB3g*ez';                               // SMTP password
	$mail->SMTPSecure = 'ssl';                                  // Enable TLS encryption, `ssl` also accepted
	$mail->Port       = 465;                                    // TCP port to connect to

	//Recipients
	$mail->setFrom('btcbattles.com.no.reply@gmail.com', 'No-reply - BTCBattles.com');
	$mail->addAddress('ketanlathiya@gmail.com', 'Ketan');

	// Content
	$mail->isHTML(true);                                  // Set email format to HTML
	$mail->Subject = 'Test Subject';
	$mail->Body    = 'Hi<br>Ketan:'.date("Y-m-d H:i:s");

	$mail->send();

} catch (Exception $e) {
	echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}*/
?>
