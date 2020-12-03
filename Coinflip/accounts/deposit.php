<?php
include '../settings.php';
if($user['id']!=''){ // Check if user is logged in or not
	if(isset($_POST) && !empty($_POST)){ // Check if data sent by POST only
		if($_POST['input_amount']!=''){
			if($_POST['input_amount']>=10){
				$deposit_amount = $_POST['input_amount'];
				
				require('../coinpayments.inc.php');
                $cps = new CoinPaymentsAPI();
                $cps->Setup('8013d91333d1cC6C04F10C6D7Ba577773ED4F3C005dbE1B397f9fbb082906B0F', 'd8d740d4e93870b0714f57ccdb1622d139272ca1b9f7f773b6ce6f631501ff97');
				
				$result = $cps->CreateTransactionSimple($deposit_amount, 'USD', 'BTC', $user['email'], '', '');
                $response = json_encode($result,true);
				
				if ($result['error'] == 'ok') {
					$user_deposit_data = array(
						'userID'=>$user['id'],
						'txn_id'=>$result['result']['txn_id'],
						'amount'=>$deposit_amount,
						'bitcoin_amount'=>$result['result']['amount'],
						'bitcoin_address'=>$result['result']['address'],
						'confirms_needed'=>$result['result']['confirms_needed'],
						'timeout'=>$result['result']['timeout'],
						'status_url'=>$result['result']['status_url'],
						'qrcode_url'=>$result['result']['qrcode_url'],
						'status'=>'0',
						'status_text'=>'Waiting for depositor funds...',
						'response'=>$response
					);
					$db->query("INSERT INTO `user_deposit`(".implode(',', array_keys($user_deposit_data)).") VALUES ('".implode("','", array_values($user_deposit_data))."')");
					
					echo json_encode(array(
						'status'=>'success',
						'btc'=>$result['result']['amount'].' BTC',
						'amount'=>'$'.number_format($amount,2),
						'address'=>$result['result']['address'],
						'qrcode_url'=>$result['result']['qrcode_url'],
						'msg'=>'<strong>SUCCESS!</strong> Deposit request successfully processed',
					));
					exit;
				}else{
					echo json_encode(array(
                        'status'=>'error',
                        'msg'=>$result['error'],
                        'e_code'=>$result['error'],
                    ));
                    exit;
				}
			}else{
				echo json_encode(array( // If POST is not there, dispaly error
					'status'=>'error',
					'msg'=>'Minimum deposit amount must be $10'
				));
				exit;
			}
		}else{
			echo json_encode(array( // If POST is not there, dispaly error
				'status'=>'error',
				'msg'=>'Please enter deposit amount'
			));
			exit;
		}
	}else{
		echo json_encode(array( // If POST is not there, dispaly error
			'status'=>'error',
			'msg'=>'Please enter deposit amount'
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
