<?php
	include 'config.php';

	if(isset($_GET['email']) && isset($_GET['password']))
	{
		//Login details
		
		$email = $_GET['email'];
		$password = $_GET['password'];
		
		$results = $db->query('SELECT * FROM users WHERE email = '.$db->quote($email).' AND password = '.$db->quote(md5($password)));
		
		if ($results) {
			$success = 0;
			$verify = 0;
			$message = '';
			foreach ($results as $result) {
				if($result['email'] == $email && $result['password'] == md5($password)) {
					$success = 1;
				}
				if($result['verify'] == 0) {
					$verify = 0;
				} else {
					$verify = 1;
				}
			}
			
			if($verify == 0) {
				$message = 'Confirm your account in email to make login';
				header('Location: index.php?error=1&message='.$message);
			} else if($success == 1) {
				$hash = md5($email . time() . rand(1, 50));
				$sethash = $db->exec('UPDATE users SET hash = ' . $db->quote($hash) . ' WHERE email = '.$db->quote($email));
				if($sethash) {
					setcookie('hash', $hash, time() + 3600 * 24 * 7, '/');
					header('Location: sets.php?id=' . $hash);	
				} else {
					$message = 'Error on setup hash';
					header('Location: index.php?error=1&message='.$message);
				}
			} else {
				$message = 'Incorrect email or password';
				header('Location: index.php?error=1&message='.$message);
			}
		} else {
			$message = 'Error on access databases';
			header('Location: index.php?error=1&message='.$message);
		}
	}
?>