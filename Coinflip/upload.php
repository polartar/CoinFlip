<?php
include 'settings.php';

$message = '';

if($user) {
	if($_FILES["file_image"]) {

		$target_dir = "uploads/";
		$target_file = $target_dir . basename($_FILES["file_image"]["name"]);
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
			$message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			header('Location: index.php?error=1&message='.$message);
		} else {
			$check = getimagesize($_FILES["file_image"]["tmp_name"]);
			if($check !== false) {
				$file_name = $user['verify_code'].'.'.$imageFileType;
				if(move_uploaded_file($_FILES['file_image']['tmp_name'], $target_dir.$file_name)) {
					$exec = $db->query('UPDATE `users` SET `avatar` = '.$db->quote($file_name).' WHERE `verify_code` = '.$db->quote($user['verify_code']));
					if($exec) {
						$message = 'Success in changing image';
						header('Location: index.php?message='.$message);
					} else {
						$message = 'Error on trade your image';
						header('Location: index.php?error=1&message='.$message);
					}
					$exec->fetch(PDO::FETCH_ASSOC);
				} else {
					$message = 'Error on move your file';
					header('Location: index.php?error=1&message='.$message);
				}
			} else {
				$message = 'Invalid image type';
				header('Location: index.php?error=1&message='.$message);
			}
		}
	
	} else {
		$message = 'Error on receive file';
		header('Location: index.php?error=1&message='.$message);
	}
} else {

}

?>