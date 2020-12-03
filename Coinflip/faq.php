<title>BTCBattles - Frequently Asked Questions</title>
<?php
 include 'settings.php';
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
  <script src="assets/js/cryptojs.js"></script>
  <script src="assets/js/notify.js"></script>
  <script src="assets/js/tinysort.js"></script>
  <script src="assets/js/app.js?v<?=time()?>"></script>
  <script src="assets/js/countdownHackerTimer.js"></script>
  <script src="assets/js/countTo.js"></script>

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
  </script>
  <link rel="stylesheet" type="text/css" href="assets/css/app.css?v=<?=time()?>">
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

<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container">
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
    <li style="
    margin-top: 10px;
    padding: 5px;
    margin-top: 5px;
">
  <?php
  if($user)
  { ?>
  <?php }else{ ?>
    <a href="login.php" style="padding: 2px 5px 0 5px; "><img src="https://steamcommunity-a.akamaihd.net/public/images/signinthroughsteam/sits_01.png"></a>
  <?php } ?>
    </li>

      </ul>
    </div>
  </div>
</nav>

<body class="hellos">


<div class="container" style="width: 1170px;">
<div class="starter-template" style="text-align: center;padding: 150px;margin-bottom: 60px!important;">
<h1 style="font-size: 27px;color: #FCB941;font-family: 'Montserrat', sans-serif;letter-spacing: 0.5px;">Frequently Asked Questions</h1>
<h2 style="color: #b7b7b7 !important;font-size: 18px !important;font-weight: 600 !important;font-family: Open Sans, sans-serif !important;letter-spacing: 1px !important;">WHAT CAN I DEPOSIT FOR ONSITE BALANCE?</h2>
<p>Here at BTCBattles the only method of deposit we accept is Bitcoin. In the future we may offer additional payment methods. </p>
<h2 style="color: #b7b7b7 !important;font-size: 18px !important;font-weight: 600 !important;font-family: Open Sans, sans-serif !important;letter-spacing: 1px !important;">WHAT ARE MY WITHDRAW OPTIONS?</h2>
<p>At this stage we only offer Bitcoin cashout. Be sure to have set your wallet address within the settings page. <br>If you have any specific withdraw questions submit an online support request <a href="https://btcbattles.deskero.com">here</a>.</p>
<p>Minimum deposit is currently $6 and includes fees. </p>
<h2 style="color: #b7b7b7 !important;font-size: 18px !important;font-weight: 600 !important;font-family: Open Sans, sans-serif !important;letter-spacing: 1px !important;">HOW ARE ITEMS PRICED?</h2>
<p>Items are priced using an API and specific BTCBattles modifiers. The item pricing is only used to determine the value of the battles you wish to create. All items won are sold at time of withdraw and converted to Bitcoin. </p>
<h2 style="color: #b7b7b7 !important;font-size: 18px !important;font-weight: 600 !important;font-family: Open Sans, sans-serif !important;letter-spacing: 1px !important;">WHAT ARE OUR ONSITE FEES?</h2>
<p>Operating a transparent platform such as BTCBattles requires significant costs which need to be covered. <br>In spirit of 100% openness our round fee is added ontop of each battle cost. <br>The winner receives 100% of the skins value from each battle.    </p>
<h2 style="color: #b7b7b7 !important;font-size: 18px !important;font-weight: 600 !important;font-family: Open Sans, sans-serif !important;letter-spacing: 1px !important;">WHAT ARE OUR ONSITE FEES?</h2>
<p>Operating a transparent platform such as BTCBattles requires signiifcant costs which need to be covered. <br>In spirit of 100% openness our round fee is added ontop of each battle cost. <br>The winner receives 100% of the skins value from each battle.    </p>
</div>
</div>


<!-- ALLL MODALS -->
<?php include 'Modals.php'; ?>
<!-- ALL MODALS -->

</body>
