<?php
	include 'config.php';

	if(isset($_GET['link']))
	{
		$url = html_entity_decode($_GET['link'].'&token='.$_GET['token']);
		$exec = $db->query('UPDATE `users` SET `tradelink` = '.$db->quote($url).' WHERE `hash` = '.$db->quote($_COOKIE['hash']));
		$exec->fetch(PDO::FETCH_ASSOC);
	}
	header('Location: index.php');
?>
