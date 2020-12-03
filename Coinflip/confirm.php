<?php
	include 'config.php';

	if(isset($_GET['code']))
	{
		$success = 0;
		$message = '';
		$code = $_GET['code'];
		$results = $db->query('SELECT * FROM users WHERE verify_code = '.$db->quote($code));
		foreach($results as $result) {
			
			if($result['verify_code'] == $code) {
				$success = 1;
				if($result['verify'] > 0) {
					$success = 2;
				}
			}
		}
		
		if($success == 1) {
			$exec = $db->query('UPDATE `users` SET `verify` = 1 WHERE `verify_code` = '.$db->quote($code));
			$exec->fetch(PDO::FETCH_ASSOC);
			
			if($exec) {
				$message = 'Your account has been confirmed, make the login now';
				header('Location: index.php?message='.$message);
			} else {
				$message = 'Error on confirm your account';
				header('Location: index.php?error=1&message='.$message);
			}
		} else if($success == 2) {
			$message = 'This account has already been verified';
			header('Location: index.php?message='.$message);
		} else {
			$message = 'Error on confirm your account, enter in contact on support';
			header('Location: index.php?error=1&message='.$message);
		}
	}
?>
