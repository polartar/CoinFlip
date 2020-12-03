<title>BTCBattles - Draw Winner</title>
<?php
include 'settings.php';

if($_GET['id'])
{
	if($user['rank'] == 69)
	{
		$isActive01 = $db->query('SELECT ended FROM giveaways WHERE id = ' . $db->quote($_GET['id']));
		$isActive = $isActive01->fetch();

		if($isActive['ended'] == 1)
		{
			echo 'This giveaway is ended, you can\'t pick another winner.';
		}
		else
		{
			$winnerPick01 = $db->query('SELECT user FROM users_giveaways WHERE giveaway = ' . $db->quote($_GET['id']) . ' ORDER BY RAND() LIMIT 1');
			$winnerPick = $winnerPick01->fetch();


			$winnerName01 = $db->query('SELECT name FROM users WHERE steamid = ' . $db->quote($winnerPick['user']));
			$winnerName = $winnerName01->fetch();

			echo 'The winner of this giveaway is: ' . $winnerName['name'] . ' ( ' . $winnerPick['user'] . ' )';

			$db->exec('UPDATE giveaways SET ended = 1, winner_steamid = ' . $db->quote($winnerPick['user']) . ' WHERE id = ' . $db->quote($_GET['id']));
		}
	}
}
else
{
	header('Location: index.php');
}
