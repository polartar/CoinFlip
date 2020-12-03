<?php
include '../settings.php';
$mode = $_GET['mode'];
if($mode == 'deposit')
{
	$id = $_POST['id'];
	if($id!=''){
		$query = $db->query('SELECT * FROM `user_deposit` WHERE `id`='.$id);
		$user_deposit = $query->fetch();
		if(count($user_deposit)==0)
		{
			$user_deposit_html='<tr>
				<td colspan="5"><div class="alert-box warning">You seems to have selected incorrect deposit.</div></td>
			  </tr>';
			echo json_encode(array(
				'status'=>'error',
				'msg'=>$user_deposit_html
			));
			exit;
		}
		else
		{	
			$amount = $user_deposit['amount'];
			
			if($user_deposit['status'] == '100')
			{
				$msg = '<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1">
						<ul class="deposit-info-response">
							<li><b>Deposit Amount:</b> '.$user_deposit['amount'].'</li>
							<li><b>Payment Status:</b> '.$user_deposit['status_text'].'</li>
							<li><b>Transaction ID:</b> <span>'.$user_deposit['txn_id'].'</span></li>
							<li><b>Paid On:</b> <span>'.date("j F, Y", strtotime($user_deposit['date_created'])).'</span></li>
						</ul>
					</div>
				</div>';
			}
			else if($user_deposit['status'] == '0')
			{
				$msg = '<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1">
						<div class="row deposit-history__info">
							<div class="col-sm-3 col-xs-3 col-xxs-12 deposit-info-code">
								<img id="qrcode_url" src="'.$user_deposit['qrcode_url'].'" alt="Qrcode Url" class="img-responsive"/>
							</div>
							<div class="col-sm-9 col-xs-9 col-xxs-12 deposit-info-address">
								<p class="response-amount-address">Send <b id="response_amount_btc"> '.$user_deposit['bitcoin_amount'].' BTC</b> to address: </p>
								<div class="input-group">
									<input class="form-control" id="d_response_address" type="text" value="'.$user_deposit['bitcoin_address'].'" readonly="readonly">
									<div class="input-group-addon btn red"><a href="javascript:void(0)" onclick="javascript:d_copy_url();" class="postfix d_copy_url">Copy Address</a></div>
								</div>
								<b class="notice">* Deposit will be credited instantly after few confirmations</b>
							</div>
						</div>
					</div>
				</div>';
			}
			else
			{
				$msg = '<div class="row">
					<div class="col-sm-12">
						<ul class="deposit-info-response">
							<li><b>Debit Amount:</b> <span id="response_amount">$'.number_format($amount,2).'</span></li>
						</ul>
						<ul class="deposit-info-response">
							<li><b>Payment Status:</b> '.$user_deposit['status_text'].'</li>
						</ul>
					</div>
				</div>';
			}
							
			echo json_encode(array(
				'status'=>'success',
				'msg'=>$msg
			));
			exit;
		}
	}
}
else if($mode == 'withdraw')
{}
else{
	echo json_encode(array(
		'status'=>'redirect',
		'msg'=>'redirect'
	));
	exit;
}
?>
