<?php
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
$mail = new PHPMailer\PHPMailer\PHPMailer();

include '../settings.php';

if((isset($_POST) && !empty($_POST)))
{
	$cp_merchant_id = 'f17e51d71496f582f6b524f872651c54'; 
	$cp_ipn_secret  = '4990'; 
	
	if (!isset($_POST['ipn_mode']) || $_POST['ipn_mode'] != 'hmac') { 
		$msgbody.= "<br>IPN Mode is not HMAC";
		die; 
	} 

	if (!isset($_SERVER['HTTP_HMAC']) || empty($_SERVER['HTTP_HMAC'])) { 
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

	if (!isset($_POST['ipn_type']) || $_POST['ipn_type'] != 'withdrawal') { 
		$msgbody.= "<br>ipn_type is not withdrawal";
		die;
	}

	$hmac = hash_hmac("sha512", $request, trim($cp_ipn_secret)); 
	if ($hmac != $_SERVER['HTTP_HMAC']) { 
		$msgbody.= "<br>HMAC signature does not match";
		die;
	}

	$withdrawal_id  = $_POST['id']; 
	$transaction_id = $_POST['txn_id']; 
	$status         = $_POST['status']; 
	$status_text    = $_POST['status_text']; 
	
	/*$withdrawal_id  = '12345'; 
	$transaction_id = '67891'; 
	$status         = '-1'; 
	$status_text    = 'Complete1';*/ 

	$query = $db->query('SELECT * FROM `user_withdrawal` WHERE `withdrawal_id`="'.$withdrawal_id.'"');
	$user_withdrawal = $query->fetch();

	if($user_withdrawal){
		
		$db->query("UPDATE `user_withdrawal` SET `transaction_id` = '".$transaction_id."',`status` = '".$status."', `status_text` = '".$status_text."', `response` = '".json_encode($_POST)."' WHERE `withdrawal_id` = '".$withdrawal_id."'");
		
		$query = $db->query('SELECT * FROM `user_withdrawal` WHERE `withdrawal_id`="'.$withdrawal_id.'"');
		$user_withdrawal_data = $query->fetch();
		
		//Get user data
		$user_query = $db->query('SELECT * FROM `users` WHERE `id`="'.$user_withdrawal['userID'].'"');
		$user_data = $user_query->fetch();
		
		if($status==2){
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
				$mail->Subject = 'Withdraw Confirmation on BTC Battles';
				$mail->Body    = 'Hi Admin,<br>
				One of user has withdrawn $'.$user_withdrawal['amount'].' on BTC Battles. Please find details below.<br><br>
				<table cellspacing="0" cellpadding="10" border="0" width="50%" style="border-color: #e1e1e1;color: #666666;">
					<tr>
						<td width="30%" style="background-color: #f5f5f5;border-bottom: 1px solid #ccc;border-right: 1px solid #ccc;">User Email</td>
						<td width="70%" style="background-color: #f5f5f5;border-bottom: 1px solid #ccc;">'.$user_data['email'].'</td>
					</tr>
					<tr>
						<td width="30%" style="border-bottom: 1px solid #ccc;border-right: 1px solid #ccc;">Amount($)</td>
						<td width="70%" style="border-bottom: 1px solid #ccc;">$'.$user_withdrawal['amount'].'</td>
					</tr>
					<tr>
						<td width="30%" style="background-color: #f5f5f5;border-bottom: 1px solid #ccc;border-right: 1px solid #ccc;">Amount (BTC)</td>
						<td width="70%" style="background-color: #f5f5f5;border-bottom: 1px solid #ccc;">'.$user_withdrawal['bitcoin_amount'].' BTC</td>
					</tr>
                    <tr>
                        <td width="30%" style="border-bottom: 1px solid #ccc;border-right: 1px solid #ccc;">Withdrawal ID</td>
                        <td width="70%" style="background-color: #f5f5f5;border-bottom: 1px solid #ccc;">'.$user_withdrawal['withdrawal_id']. '</td>
                    </tr>
					<tr>
						<td width="30%" style="border-bottom: 1px solid #ccc;border-right: 1px solid #ccc;">Date</td>
						<td width="70%" style="border-bottom: 1px solid #ccc;">' . date("j F, Y", strtotime($user_withdrawal['date_created'])) . '</td>
					</tr>
				</table>';
				
				$mail->send();
			
			} catch (Exception $e) {
				echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
			}
		}
		else if($status== '-1'){
			$withdrawalAssets = explode(',', $user_withdrawal['assets']);
			$itemAssets = $db->query('SELECT * FROM `items` WHERE `userID`="'.$user_withdrawal['userID'].'"');
			$itemData = $itemAssets->fetch();
			$itemArray = [];
			if($itemData['assets'] != '') {
				$itemArray = explode('/', $itemData['assets']);
			}
			$newAssets = implode('/', array_merge($itemArray,$withdrawalAssets));
			$db->query('UPDATE items SET assets = "'.$newAssets.'" WHERE `userID`="'.$user_withdrawal['userID'].'"');
		}
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
