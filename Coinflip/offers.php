<title>BTC Battles - Offers</title>
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
  <script src="assets/js/socket.io-1.4.5.js"></script>


 <script src="assets/js/notification.js"></script>
    <script src="assets/js/notify.js"></script>
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
  <div class="container offers-container" style="width: 1170px;">
    <div class="starter-template offers-inner-container" style="text-align:center; ">
        <h3 class="offers-header offers-main-header">Claim An Offer</h3>
        <p class="offers-paragraph offers-paragraph-1">Everyone loves a deal, and here at BTCBattles we're always trying to give back to your community. Here you'll
            be able to claim bonuses, partner codes and onsite giveaways.</p>
        <form action="" method="POST">
            <input class="offers-input" type="text" id="input_code" name="input_code">
            <button class="btn duel-btn-lg btn-create btn-lg btn-block new__game__button" type="submit">CLAIM</button>
        </form>
    </div>
  </div>
<?php include 'bottom.php'; ?>


<!-- ALLL MODALS -->
<?php include 'Modals.php'; ?>
<!-- ALL MODALS -->


<?php } ?>




</body>
