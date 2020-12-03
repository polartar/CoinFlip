<title>BTCBattles - The Most Fun You Can Have With Your Bitcoin</title>
<?php
include 'settings.php';

$error = 0;
$message = '';

if ($_GET['error']) {
    $error = 1;
}

if ($_GET['message']) {
    $message = $_GET['message'];
}

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
    <script src="assets/js/notification.js"></script>
    
    <script src="assets/js/jquery.cookie.js"></script>
    <script src="assets/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/socket.io-1.4.5.js"></script>
    <script src="assets/js/cryptojs.js"></script>
    <script src="assets/js/notify.js"></script>
    <script src="assets/js/tinysort.js"></script>
    <script src="assets/js/global.js?v<?= time() ?>"></script>
    <script src="assets/js/app.js?v<?= time() ?>"></script>
    <script src="assets/js/offers.js?v<?= time() ?>"></script>
    <script src="assets/js/countdownHackerTimer.js"></script>
    <script src="assets/js/countTo.js"></script>
    <script src="assets/js/alertify.min.js"></script>
     
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

        function noURL() {
            if(balance<parseFloat($("#allValue").text()))
            {
                     Notification.create(
                // Title
                "Your balance is not enough to by this item. Your balance is "+balance,
                // Text
                " ",
                // Illustration
                "/assets/images/msg.svg",
                // Effect
                "shake",
                // Position
                position
             );
                
                return;
            }
            if(passetIds.length == 0)
            {
                 Notification.create(
                // Title
                "Can't create game",
                // Text
                "Please select more than 1 item ",
                // Illustration
                "/assets/images/msg.svg",
                // Effect
                "shake",
                // Position
                position
             );
                 return;
            }
            balance = balance - parseFloat($("#allValue").text());
            newCoinflip(passetIds);

            //alertify.message('You need to set tradelink');
        }
    </script>
    <link rel="stylesheet" type="text/css" href="assets/css/app.css?v=<?= time() ?>">
    
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css?v=<?= time() ?>">
    <link rel="stylesheet" type="text/css" href="assets/css/animate.min.css?v=<?= time() ?>">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css?v=<?= time() ?>">
    <link rel="stylesheet" type="text/css" href="assets/css/w3.css?v=<?= time() ?>">
    <link rel="stylesheet" type="text/css" href="assets/css/notification.css">
    <link rel="stylesheet" type="text/css" href="assets/css/alertify.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/themify-icons/0.1.2/css/themify-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Mono:400,500,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
</head>
<?php

if ($message != '') {
    if ($error > 0) {
        echo "<script>window.onload = function(e) { alertify.error('" . $message . "') }</script>";
    } else {
        echo "<script>window.onload = function(e) { alertify.success('" . $message . "') }</script>";
    }
}

?>
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
                        echo '<button id="createCF" class="btn duel-btn-lg btn-create btn-lg btn-block new__game__button">Create new</button>';
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


<div class="panel-open" id="right-panel">
    <div id="chatWindow">
        <div class="online" id="chatStatus">
            <div class="dot"></div>
            <span class="online__count"><span class="users-online-value"
                                              style="color: #e94b24; font-size: 16px;">0</span> Online</span><i
                    id="mChatRules" class="fa fa-bookmark rules__info" aria-hidden="true"></i>
        </div>
        <form id="Message" name="Message">
            <div id="chat-ctn">
                <div id="chatMessages" style="overflow-wrap: break-word;"></div>
                <div id="chatActions">
                    <input class="form-control" id="theMessage" placeholder="Type your message..." type="text">
                    <?php if($user){?>
                    <button class="button__send__chat" id="sendMsg" type="submit" value="Send">SEND</button>
                    <?php } else{?>
                       <button class="button__send__chat" id="adsada" type="button" value="Send">SEND</button>
                        <?php } ?>
                    
                </div>
            </div>
        </form>
    </div>
</div>


<div id="coinflip-wrapper" class="row">
    <div id="topHH" style="margin-left: -15px;">
        <div class="row no-gutters" style="text-align: left; max-width: 80%;">
            <div class="">
                <div class="panel panel-default">
                    <div class="panel-body">
                      
                        <div class="row" style="text-align: center;">

                            <div class="col-sm-4">
                                <span class="stats-up">$ <span id="cfTotalAmount" data-decimals="2">0.00</span></span>
                                <br>
                                <span class="stats-down">TOTAL AMOUNT</span>
                            </div>
                            <div class="col-sm-4">
                                <span class="stats-up cfTotalItems">0</span>
                                <br>
                                <span class="stats-down">TOTAL ITEMS</span>
                            </div>
                            <div class="col-sm-4">
                                <span class="stats-up cfActiveGames">0</span>
                                <br>
                                <span class="stats-down">ACTIVE GAMES</span>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="tabelul table table-striped" style="width:100%;">
                    <thead>
                    <tr>
                        <th>GameName</th>
                        <th>PLAYER</th>
                        <th>SKINS</th>
                        <th>TOTAL</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody id="games"></tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<?php include 'bottom.php'; ?>

<!-- ALLL MODALS -->
<?php include 'Modals.php'; ?>
<!-- ALL MODALS -->


<div class="modal fade" id="depositModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <p id="myModalLabel" class="depositAlert modal-title alert text-center alert-success">Loaded ~ items (<i
                            class="fa fa-gg-circle"></i> 0) from cache.</p>
            </div>
            <div class="modal-body deposit-items text-center" id="deposit-items"
                 style="text-align:center;height:500px;overflow-x:hidden;">
            </div>
            <div class="modal-footer">
                <div class="btn-group dropup pull-left" style="margin-bottom:0;">
                    <button type="button" class="btn btn-primary refreshInv"><i class="fa fa-refresh"></i></button>
                </div>
                <b><span style="color: orange">Items selected: <span class="itemsSelected">0</span>/20</span></b>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn cfDep depositNow btn-primary">Deposit</button>
            </div>
        </div>
    </div>
</div>
</body>
