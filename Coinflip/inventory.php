<title>BTC Battles - My Inventory</title>
<?php include 'settings.php'; ?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <script src="assets/js/jquery-3.2.1.js"></script>
    <script src="assets/js/jquery.cookie.js"></script>
    <script src="assets/js/notify.js"></script>
    <script src="assets/js/socket.io-1.4.5.js"></script>
    <script src="assets/js/inventory.js"></script>
    <script src="assets/js/notification.js"></script>
    
    <link rel="stylesheet" type="text/css" href="assets/css/app.css?v=<?=time()?>">
    <link rel="stylesheet" type="text/css" href="assets/css/notification.css">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css?v=<?=time()?>">
    <link rel="stylesheet" type="text/css" href="assets/css/animate.min.css?v=<?=time()?>">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css?v=<?=time()?>">
    <link rel="stylesheet" type="text/css" href="assets/css/w3.css?v=<?=time()?>">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/themify-icons/0.1.2/css/themify-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Mono:400,500,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
</head>
<script>
$.notify.defaults({
	clickToHide: true,
	autoHide: true,
	autoHideDelay: 2000,
	arrowShow: true,
	arrowSize: 177,
	position: 'top center',
	elementPosition: 'top center',
	globalPosition: 'top center',
	style: 'bootstrap',
	className: 'error',
	showAnimation: 'slideToggle',
	showDuration: 600,
	hideAnimation: 'slideToggle',
	hideDuration: 600,
	gap: 2
});

$(document).ready(function(){
	var position =1;
	$(function () {
		$('.position').click(function (event) {
			var el = $(event.target);
			$('.position').removeClass('selected');
			el.addClass('selected');
			position = el.attr('data-position');
		});
	});
	
	$("#Withdraw").click(function(){
		if(parseFloat($("#selected_amounts").html()) < 10)
		{
			Notification.create(
				// Title
				"Error!",
				// Text
				"Minimum withdrawal amount is $10",
				// Illustration
				"/assets/images/msg.svg",
				// Effect
				"shake",
				// Position
				position
			);
			return;
		}else{
			$("#s_withdraw_amount").html("$"+parseFloat($("#selected_amounts").html()));
			$("#withdraw").modal();
		}
	});
	
	$("#b_withdraw").click(function(){
		var user_bitcoin_address = $("#user_bitcoin_address").val();
		var user_withdraw_amount = parseFloat($("#selected_amounts").html());
		$("#form_withdraw").show();
		if(user_withdraw_amount < 10)
		{
			Notification.create(
				// Title
				"Error!",
				// Text
				"Minimum withdrawal amount is $10",
				// Illustration
				"/assets/images/msg.svg",
				// Effect
				"shake",
				// Position
				position
			);
			return;
		}
		if(user_bitcoin_address == '')
		{
			Notification.create(
				// Title
				"Error!",
				// Text
				"Please enter bitcoin address",
				// Illustration
				"/assets/images/msg.svg",
				// Effect
				"shake",
				// Position
				position
			);
			return;
		}
		$("#user_withdraw_amount").val(user_withdraw_amount);
		$("#user_assets").val(passetIds);
		var form = $("#form_withdraw");
        $('.b_withdraw').button('loading');
		$('.withdraw_info').hide();
		$.post("accounts/withdraw.php", $(form).serializeArray(), function(data) {
			$('.b_withdraw').button('reset');
			if(data.status=='success'){
				Notification.create(
					// Title
					"Success!",
					// Text
					data.msg,
					// Illustration
					"/assets/images/msg.svg",
					// Effect
					"shake",
					// Position
					position
				);
				$('.b_withdraw').attr("disabled", true);
				setTimeout(function() {
					window.location = 'history.php?deposit=2';
				}, 3000);
			}else if(data.status=='error'){
				Notification.create(
					// Title
					"Error!",
					// Text
					data.msg,
					// Illustration
					"/assets/images/msg.svg",
					// Effect
					"shake",
					// Position
					position
				);
				return false;
			}else{
				setTimeout(function() {
					window.location = 'logout.php';
				}, 200);
				return false;
			}
		},'json');
		return false;
      });
});

</script>
 <?php include 'preheader.php'; ?>
<nav class="navbar navbar-inverse">
    <div class="logo">
        <a href="/">
            <img src="assets/images/logo-72dpi.png" srcset="assets/images/logo-retina.png 2x" alt="Logo">
        </a>
    </div>
    <div class="">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/"></a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">

            <ul class="nav navbar-nav menu header-menu">
                <?php include 'Header.php'; ?>
            </ul>

            <ul class="nav navbar-nav navbar-right header-menu">
                <li>
                    <?php
                    if ($user) {
                        echo '';
                    } else {
                        echo '<button id="openLogin" class="btn duel-btn-lg btn-create btn-lg btn-block">LOGIN</button> <button id="openRegister" class="btn duel-btn-lg btn-create btn-lg btn-block">REGISTER</button>';
                    }
                    ?>
                </li>

            </ul>
        </div>
    </div>
</nav>
<body class="hellos">
<?php
if($user)
{

  ?>
<div class="container inventory-container" style="width: 1170px;">

    <div class="starter-template inventory-inner-container" style="text-align:center; ">
        <div class="text-right">
            <button id="Withdraw" class="btn duel-btn-lg btn-create btn-lg btn-block new__game__button">WITHDRAW</button>
            <button id="Tobalance" class="btn duel-btn-lg btn-create btn-lg btn-block new__game__button">Sell Item</button>
        </div>
        <h3 class="inventory-header inventory-main-header">My Inventory:</h3>


      <div class="row row-header" style="color:grey">
        <div class="col-md-3 col-xs-3">
          <span>Total Items:</span><span id='total_items'>0</span>
        </div>
        <div class="col-md-3 col-xs-3">
          <span>Total amounts:</span><span id="total_amounts">0.0</span>
        </div>
        <div class="col-md-3 col-xs-3">
          <span>Selected Items:</span><span id='selected_items'>0</span>
        </div>
        <div class="col-md-3 col-xs-3">
          <span>amounts:</span><span id="selected_amounts">0.0</span>
        </div>


      </div>
      <div class="containerinv" style="overflow:scroll; overflow-x:hidden;margin-top:5px">
       </div>
    </div>

  </div>
<?php include 'bottom.php'; ?>


<!-- ALLL MODALS -->
<?php include 'Modals.php'; ?>
<!-- ALL MODALS -->


<?php } ?>




</body>
