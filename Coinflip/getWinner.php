<?php
	include 'settings.php';

	if($_GET['hash'] && $_GET['secret']&& $_GET['tickets'])
	{
		$exec01 = $db->query('SELECT winner,cryptedData FROM games WHERE `hash` = '.$db->quote($_GET['hash']).' and `secret` = '.$db->quote($_GET['secret']).' and `wcode` = '.$_GET['tickets']);

		if($exec01->rowCount() == 0)
		{
			exit(json_encode(array('success'=> false, 'error'=>'Error: Verification was not successful')));
		}
		else
		{
			$exec = $exec01->fetch();
			exit(json_encode(array('success'=> true,"A"=>"A", 'cryptedData'=>$exec['cryptedData'],'winner'=>$exec['winner'])));
		}
	}
?>
