<?php
	require 'PHPMailer/src/Exception.php';
	require 'PHPMailer/src/PHPMailer.php';
	require 'PHPMailer/src/SMTP.php';

	include '../config.php';
	
	$mail = new PHPMailer\PHPMailer\PHPMailer();

	if(isset($_GET['email']) && isset($_GET['username']) && isset($_GET['password']))
	{
		//Login details
		
		$email = $_GET['email'];
		$username = $_GET['username'];
		$password = $_GET['password'];
		$code = md5(uniqid(rand(), true));
		
		$results = $db->query('SELECT * FROM users WHERE email = '.$db->quote($email));
		$results1 = $db->query('SELECT * FROM users WHERE username = '.$db->quote($username));
		
		if ($results && $results1) {
			$error = 0;
			$error_message = '';
			foreach ($results as $result) {
				if($result['email'] == $email) {
					$error++;
					$error_message = 'Email already in use';
				}
			}
			foreach ($results1 as $result1) {
				if($result1['username'] == $username) {
					$error++;
					$error_message = 'Username already in use';
				}
			}
			
			if($error == 0) {
				try {
					
					//Server settings
					$mail->SMTPDebug = 2;                                       // Enable verbose debug output
					$mail->isSMTP();                                            // Set mailer to use SMTP
					$mail->Host       = 'smtp.gmail.com';  // Specify main and backup SMTP servers
					$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
					$mail->Username   = 'Your email';                     // SMTP username
					$mail->Password   = 'Email Password';                               // SMTP password
					$mail->SMTPSecure = 'ssl';                                  // Enable TLS encryption, `ssl` also accepted
					$mail->Port       = 465;                                    // TCP port to connect to

					//Recipients
					$mail->setFrom('vgocheapnoreply@gmail.com', 'No-reply');
					$mail->addAddress($email, $username);

					// Content
					$mail->isHTML(true);                                  // Set email format to HTML
					$mail->Subject = 'Account Confirmation';
					$mail->Body    = 'Access this link to confirm your account: <br> http://139.180.222.171/confirm.php?code='.$code;
					$mail->AltBody = 'VGOCheap agrements, automatic email!';

					$mail->send();
					
					$exec = $db->query('INSERT INTO `users` SET `email` = '.$db->quote($email).', `password` = '.$db->quote($password).', `username` = '.$db->quote($username).', `verify_code` = '.$db->quote($code));
					$exec->fetch(PDO::FETCH_ASSOC);
					
					$error_message = 'Your account are registered, confirm with a link sent to your email';
					header('Location: ../index.php?message='.$error_message);
					
					
				} catch (Exception $e) {
					echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
				}
			} else {
				header('Location: ../index.php?error=1&message='.$error_message);
			}
			
		} else {
			
		}
	}
		
?>