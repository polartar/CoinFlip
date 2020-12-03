<?php
include '../settings.php';
function url(){
  return sprintf(
    "%s://%s",
    isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
    $_SERVER['SERVER_NAME']
  );
}


if($user['id']!=''){ // Check if user is logged in or not
	if(isset($_POST) && !empty($_POST)){ // Check if data sent by POST only
		if($_POST['user_bitcoin_address']!='' && $_POST['user_withdraw_amount']!=''){
			if($_POST['user_withdraw_amount']>=10){
				$withdraw_amount = $_POST['user_withdraw_amount'];
				$user_bitcoin_address = $_POST['user_bitcoin_address'];
				$assets = $_POST['user_assets'];
				//check if user has deposited or not
				$query = $db->query('SELECT SUM(`amount`) as `total` FROM `user_deposit` WHERE `userID`="'.$user['id'].'" AND `status` = "100"');
				$sum_deposit = $query->fetch();
				if($sum_deposit['total']<10){
					echo json_encode(array(
						'status'=>'error',
						'msg'=>'Please deposit at least $10 first.'
					));
					exit;
				}
				
				require('../coinpayments.inc.php');
				$cps = new CoinPaymentsAPI();
				$cps->Setup('8013d91333d1cC6C04F10C6D7Ba577773ED4F3C005dbE1B397f9fbb082906B0F', 'd8d740d4e93870b0714f57ccdb1622d139272ca1b9f7f773b6ce6f631501ff97');
				
				$site_url = url();
				$result = $cps->CreateAutoWithdrawal($withdraw_amount, 'BTC', 'USD', $user_bitcoin_address, $site_url.'/accounts/withdrawals_ipn.php');
				/*$result['error'] = 'ok';
				$result['result']['id'] = 123456;
				$result['result']['amount'] = 10;
				$result['result']['status'] = 1;
				$result['result']['status_text'] = 'Pending';*/
				
				if ($result['error'] == 'ok') {
					$user_withdrawal_data = array(
						'userID'=>$user['id'],
						'assets'=>$assets,
						'withdrawal_id'=>$result['result']['id'],
						'transaction_id'=>'',
						'amount'=>$withdraw_amount,
						'bitcoin_amount'=>$result['result']['amount'],
						'bitcoin_address'=>$user_bitcoin_address,
						'status'=>$result['result']['status'],
						'status_text'=>'Pending',
						'response'=>json_encode($result),
					);
					
					
					//update items table for assets
					$query = $db->query('SELECT * FROM `items` WHERE `userID`="'.$user['id'].'"');
					$row_assets = $query->fetch();
					if($row_assets['assets'] != ''){
						$user_assets = explode("/",$row_assets['assets']);
						$selected_assets = explode(",",$assets);
						foreach($selected_assets as $asset){
							$removeKey = array_search($asset,$user_assets);
							unset($user_assets[$removeKey]);
						}
						$newAssets = implode('/', $user_assets);
						$db->query('UPDATE items SET assets = "'.$newAssets.'" WHERE `userID`="'.$user['id'].'"');
					}
					
					$is_withdrawal = $db->query("INSERT INTO `user_withdrawal`(".implode(',', array_keys($user_withdrawal_data)).") VALUES ('".implode("','", array_values($user_withdrawal_data))."')");
					
					if($is_withdrawal){
						echo json_encode(array(
							'status'=>'success',
							'result'=>$user_withdrawal_data,
							'msg'=>'<strong>SUCCESS!</strong> Amount withdrawn successfully.'
						));
						exit;
					}
				}
				else{
					echo json_encode(array(
						'status'=>'error',
						'msg'=>'<strong>ERROR!</strong> '.$result['error'],
					));
					exit;
				}
			}else{
				echo json_encode(array( // If POST is not there, dispaly error
					'status'=>'error',
					'msg'=>'Minimum withdraw amount must be $10'
				));
				exit;
			}
		}else{
			echo json_encode(array( // If POST is not there, dispaly error
				'status'=>'error',
				'msg'=>'Please enter withdraw amount'
			));
			exit;
		}
	}else{
		echo json_encode(array( // If POST is not there, dispaly error
			'status'=>'error',
			'msg'=>'Please enter withdraw amount'
		));
		exit;
	}
}else{ // If user is not logged in, redirect to homepage
	echo json_encode(array(
		'status'=>'redirect',
		'msg'=>'redirect'
	));
	exit;
}
?>
