<title>BTCBattles - My Transaction History</title>
<?php
 include 'settings.php';
 if(isset($_GET['deposit']))
  $flag = $_GET['deposit'];
  else $flag = 1;
?>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <script>
    var STEAMID = '<?php echo $user['steamid']; ?>';
    var TRADELINK = '<?php echo $user['tradelink']; ?>';
  </script>

  <script src="assets/js/jquery-3.2.1.js"></script>
  <script src="assets/js/jquery.cookie.js"></script>
  <script src="assets/js/jquery.dataTables.min.js"></script>
  <script src="assets/js/socket.io-1.4.5.js"></script>

  <script src="assets/js/notify.js"></script>



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

      function change(){

         $("#form_recent").submit();
      }

	function d_copy_url(){
		$('#d_response_address').select();
		document.execCommand('copy');
		$('.d_copy_url').addClass('success').text('Copied');
	}
	 function viewDepositHistory(id){
		$.post("accounts/history.php?mode=deposit", {id : id}, function(data) {
			$('#viewDepositHistory').modal('show');
			if(data.status=='success'){
				$('#viewDepositHistory .modal-body').html('');
				$('#viewDepositHistory .modal-body').html(data.msg);
				return false;
			}
			else if(data.status == 'redirect'){
				setTimeout(function() {
					window.location = logout;
				}, 200);
			}
			else{
				$('#viewDepositHistory .modal-body').html('');
				$('#viewDepositHistory .modal-body').html(data.msg);
				return false;
			}
		}, 'json');
	}

  </script>
  <link rel="stylesheet" type="text/css" href="assets/css/app.css?v=<?=time()?>">
  <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css?v=<?=time()?>">
  <link rel="stylesheet" type="text/css" href="assets/css/animate.min.css?v=<?=time()?>">
  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css?v=<?=time()?>">
  <link rel="stylesheet" type="text/css" href="assets/css/w3.css?v=<?=time()?>">
  <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">
</head>

<?php include 'preheader.php'; ?>

<nav class="navbar navbar-inverse">
    <div class="logo">
        <a href="">
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

 <h3 class='text-center' style="font-size: 27px;color: #FFFFFF;font-family: 'Montserrat', sans-serif;letter-spacing: 0.5px;">
  <?php
    if($flag ==1) echo "MY DEPOSIT HISTORY";
    else echo "MY WITHRAW HISTORY";
   ?>
</h3>

<center>
<?php if($flag==1) { ?>
    <div class="container" style="padding-top: 30px;width: 50%">
          <table class="tabelul table table-striped" style="width:100%;">
            <thead>
               <tr>
                <th class="text-center">#</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Date</th>
                <th>View</th>
              </tr>
            </thead>
            <tbody>
      <?php
	  	  $Xp01 = $db->query('SELECT `id`,`amount`,`status`,`status_text`,`date_created` FROM user_deposit where userID='.$user['id']);
          $Xp = $Xp01->fetchAll();


          $i = 0;
          foreach ($Xp as $row) {
            $i ++;
            echo '<tr><td>'.$i.'</td>';
            echo '<td>$'.$row['amount'].'</td>';
            echo '<td>'.$row['status_text'].'</td>';
			echo '<td>'.date("j F, Y", strtotime($row['date_created'])).'</td>';
            echo '<td><a href="javascript:void(0)" onclick="viewDepositHistory('.$row['id'].')">View</a></td></tr>';
          }
      ?>
       </tbody>
      </table>
    </div>
<?php } else if($flag==2) { ?>
    <div class="container" style="padding-top: 30px;width: 50%">
          <table class="tabelul table table-striped" style="width:100%;">
            <thead>
               <tr>
                <th class="text-center">#</th>
                <th>Withdrawal ID</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Date</th>
                <th>View</th>
              </tr>
            </thead>
            <tbody>
      <?php
       	  $Xp01 = $db->query('SELECT `id`,`withdrawal_id`,`amount`,`status`,`status_text`,`date_created` FROM user_withdrawal where userID='.$user['id']);
          $Xp = $Xp01->fetchAll();


          $i = 0;
          foreach ($Xp as $row) {
            $i ++;
            echo '<tr><td>'.$i.'</td>';
            echo '<td>'.$row['withdrawal_id'].'</td>';
			echo '<td>$'.$row['amount'].'</td>';
            echo '<td>'.$row['status_text'].'</td>';
			echo '<td>'.date("j F, Y", strtotime($row['date_created'])).'</td>';
            echo '<td><a href="javascript:void(0)" onclick="viewWithdrawHistory('.$row['id'].')">View</a></td></tr>';
          }
       ?>
       </tbody>
      </table>
    </div>
<?php } ?>
</center>

<?php include 'bottom.php'; ?>
<!-- ALLL MODALS -->
<?php include 'Modals.php'; ?>
<!-- ALL MODALS -->
</body>
