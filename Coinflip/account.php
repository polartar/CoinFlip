<title>BTC Battles - My Account</title>
<?php
   include 'settings.php';
?>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">




  <script src="assets/js/jquery-3.2.1.js"></script>
  <script src="assets/js/jquery.cookie.js"></script>
  <script src="assets/js/notify.js"></script>
   <script src="assets/js/notification.js"></script>
    <script src="assets/js/notify.js"></script>
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
       $("#btn_deposit").click(function(){
          //console.log("depo");
		  $('#form_deposit').show();
		  $('.deposit_info').hide();
		  $('#form_deposit')[0].reset();
          $("#deposit").modal();
       })

      //START : Ketan
      $("#b_deposit").click(function(){
        var amount = $("#input_amount");
        if(amount.val() == ''){
              Notification.create(
              // Title
              "Enter amount",
              // Text
              "Please enter deposit amount",
              // Illustration
              "/assets/images/msg.svg",
              // Effect
              "shake",
              // Position
              position
             );
          amount.focus();
          return;
        }

        if(amount.val()<10){
            Notification.create(
              // Title
              "Enter min.amount",
              // Text
              "Minimum deposit amount must be $10",
              // Illustration
              "/assets/images/msg.svg",
              // Effect
              "shake",
              // Position
              position
             );
            amount.focus();
            return;
        }

        var form = $("#form_deposit");
        $('.b_deposit').button('loading');
		$('.deposit_info').hide();
		$.post("accounts/deposit.php", $(form).serializeArray(), function(data) {
			$('.b_deposit').button('reset');
			if(data.status=='success'){
				$('.deposit_info').show();
				$('#form_deposit').hide();
				$('#response_amount_btc').text(data.btc);
				$('#response_address').val(data.address);
				$('#qrcode_url').attr('src',data.qrcode_url);
				return false;
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

	$(".copy_url").click(function() {
		$('#response_address').select();
		document.execCommand('copy');
		$(this).addClass('success').text('Copied');
	});
      //END : Ketan

        $('#button2').click(function() {
              var email = $('#input_email').val();
          var username = $('#input_username').val();
          var pass1 = $('#input_pass1').val();
          var pass2 = $('#input_pass2').val();

              if(!email.includes("@"))
              {
                  //alertify.error('Incorrect email parameters');
                  Notification.create(
                  // Title
                  "Incorrect email parameters",
                  // Text
                  "Please input the correct email parameters",
                  // Illustration
                  "/assets/images/msg.svg",
                  // Effect
                  "shake",
                  // Position
                  position
               );
              }
              else if(pass1 != pass2)
              {
                 // alertify.error('Password confirmation must be the same');
                  Notification.create(
                  // Title
                  "Password confirmation",
                  // Text
                  "Password confirmation must be the same",
                  // Illustration
                  "/assets/images/msg.svg",
                  // Effect
                  "shake",
                  // Position
                  position
               );
              }
          else if(username.includes(" "))
          {
            //alertify.error('Remove all spaces from username');
                  Notification.create(
                  // Title
                  "Remove all spaces from username",
                  // Text
                  "",
                  // Illustration
                  "/assets/images/msg.svg",
                  // Effect
                  "shake",
                  // Position
                  position
               );
          }
          else if(username.length > 16)
          {
            //alertify.error('Max username length are (16)');
                  Notification.create(
                  // Title
                  "Max username length are (16)",
                  // Text
                  "",
                  // Illustration
                  "/assets/images/msg.svg",
                  // Effect
                  "shake",
                  // Position
                  position
               );
          }
          else if(username.length < 5)
          {
            //alertify.error('Min username lenght are (5)');
                  Notification.create(
                  // Title
                  "Min usernmae length are (5)",
                  // Text
                  "",
                  // Illustration
                  "/assets/images/msg.svg",
                  // Effect
                  "shake",
                  // Position
                  position
               );
          }
          else if(username == "" || pass1 == "" || pass2 == "" || email == "")
          {
            //alertify.error('Make sure all fields are filled');
                  Notification.create(
                  // Title
                  "Make sure all fields are filled",
                  // Text
                  "",
                  // Illustration
                  "/assets/images/msg.svg",
                  // Effect
                  "shake",
                  // Position
                  position
               );
          }
          else if(pass1.length < 8)
          {
            //alertify.error('Min password lenght are (8)');
                  Notification.create(
                  // Title
                  "Min password length are (8)",
                  // Text
                  "",
                  // Illustration
                  "/assets/images/msg.svg",
                  // Effect
                  "shake",
                  // Position
                  position
               );
          }
          else
          {
            window.location.assign("accounts/register.php?email=" + email + "&password=" + pass1 + "&username=" + username);
          }
        });
  })

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
  <div class="container" style="width: 1170px;">

    <div class="starter-template" style="text-align:center; ">
      <div class="text-right">
             <button id="btn_deposit" class="btn duel-btn-lg btn-create btn-lg btn-block new__game__button">Deposit</button>

      </div>
      <h3 style="font-size: 27px;color: #FFFFFF;font-family: 'Montserrat', sans-serif;letter-spacing: 0.5px;">My Account:</h3>


      <div class="row row-header" style="color:grey">

      </div>
      <div class="containerinv" style="overflow:scroll; overflow-x:hidden;margin-top:5px">


          <div id="settings-msg" class="modal-title text-center settings__url">By maintaining an account you are confirming that you've read and agree to <br/><a href="terms.php" style="color: #3981f2 !important">BTCBattles Terms of Service</a>.</div>
        <br>
        <form action="account.php" method="post" class="input-group" enctype="multipart/form-data">

            <input id="input_email" type="text" name="email"  class="form-control" required="" parsley-type="text" size="256" placeholder="Email" data-parsley-id="40" style="margin-bottom: 10px;" value="<?php echo $user['email'];?>">

          <input id="input_username" type="text" name="username"   class="form-control" required="" parsley-type="text"size="256" placeholder="Username" data-parsley-id="40" style="margin-bottom: 10px;"  value="<?php echo $user['username'];?>">

          <input id="input_pass1" type="password" name="password"   class="form-control" required="" parsley-type="text"  size="256" placeholder="Password" data-parsley-id="40" style="margin-bottom: 10px;" value="<?php echo $user['password'];?>">
          <input id="input_pass2" type="password" name="password"   class="form-control" required="" parsley-type="text" size="256" placeholder="Password confirmation" data-parsley-id="40"  value="<?php echo $user['password'];?>" style="margin-bottom: 10px;">

        <!--<input id="address1" type="text" name="address1"   class="form-control" required="" parsley-type="text"size="256" placeholder="Wallet Address1" data-parsley-id="40" style="margin-bottom: 10px;"   >

          <input id="address2" type="text" name="address2"   class="form-control" required="" parsley-type="text"size="256" placeholder="Wallet Address2" data-parsley-id="40" style="margin-bottom: 10px;"   >-->


          <div class="text-right"> <a href='https://www.coinpayments.net'>Coinpayments URL</a> </div>
          <input id="button2" value="Modify" type="button" class="btn duel-btn-lg" style="margin-top: 20px">
         </form>
          <form action="upload.php" method="post" enctype="multipart/form-data" style="text-align: left">
              Select image to upload:
              <input type="file" name="file_image" id="file_image">
              <input type="submit" value="Upload Image" name="submit">
           </form>


       </div>
    </div>

  </div>
<?php include 'bottom.php'; ?>


<!-- ALLL MODALS -->
<?php include 'Modals.php'; ?>
<!-- ALL MODALS -->


<?php } ?>


<script >

</script>


</body>
