<?php
include 'config.php';

if (isset($_COOKIE['hash'])) {
	$sql = $db->query("SELECT * FROM `users` WHERE `hash` = " . $db->quote(filter_var($_COOKIE['hash'], FILTER_SANITIZE_STRING)));
	if ($sql->rowCount() != 0) {
		$row = $sql->fetch();
		$user = $row;
	}
	$sql = $db->query("SELECT * FROM `users` WHERE `id` = 1");
	if ($sql->rowCount() != 0) {
		$row = $sql->fetch();
		$yours = $row;
	}
}
?>
