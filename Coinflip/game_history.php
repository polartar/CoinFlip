<title>BTCBattles - My Game History</title>
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
  GAME HISTORY
</h3>

<center>
<div class="container" style="padding-top: 30px; ">
      <table class="tabelul table table-striped" style="width:100%;">
        <thead>
           <tr>
            <th class="text-center">#</th>
            <th class="text-center">Game ID</th>
            <th  class="text-center">PLAYER1 NAME</th>
            <th  class="text-center">PLAYER2 NAME</th>
            <th  class="text-center">SKINS</th>
            <th  class="text-center">VALUE</th>
            <th  class="text-center">WINER</th>
            <th  class="text-center">VERIFY</th>
            <th  class="text-center">Created</th>
            <th  class="text-center">Joined</th>
          </tr>
        </thead>
        <tbody>
  <?php

      $Xp01 = $db->query('SELECT * FROM games where cemail="'.$user['email'].'" or pemail="'.$user['email'].'" order by time DESC limit 50');
      $Xp = $Xp01->fetchAll();


      $i = 0;
      foreach ($Xp as $row) {
        $i ++;
        echo '<tr><td class="text-center">'.$i.'</td>';

        echo '<td class="text-center">#'.$row['id'].'</td>';

        echo '<td class="text-center"><img title="'.$row['cname'].'" width="40px" height="40px" src="/uploads/'.$row['cavatar'].'"></td>';
        if($row['pname'] !="")
          echo '<td class="text-center"><img title="'.$row['pname'].'" width="40px" height="40px" src="/uploads/'.$row['pavatar'].'"></td>';
        else
          echo "<td class='text-center'>waiting...</td>";

        $cskinsImages = explode("/@", $row['cskinsurl']);

        $cskinsNames = explode("/", $row['cskinsnames']);
        $cskinsPrices = explode("/", $row['cskinsprices']);

        $td2 = "";
        $more = 0;
        for($j = 0; $j < sizeof($cskinsNames); $j++)
            {
                if($j < 5)
                {

                    $td2 .= '<img style="border: 1px solid rgba(15, 16, 16, 0.2);" title="' . $cskinsNames[$j] . ' - $' . $cskinsPrices[$j] . '" price="' . $cskinsPrices[$j] . '" src="'. $cskinsImages[$j]. '/70fx50f">';

                }
                else
                {
                    $more++;
                }
            }

        if($more > 0)
        {
            $td2 .= '+' . $more . ' more';
        }
        echo '<td class="text-center">'.$td2.'</td>';
        echo '<td class="text-center">'.$row['ctp'].'</td>';
        if($row['winner'] =='-1')
          $win="";
        else if($row['winner'] =='1')
          $win="Player1";
        else if($row['winner'] =='2')
          $win="Player2";
        echo '<td class="text-center">'.$win.'</td>';
        echo '<td class="text-center"><a href="fair.php?hash='.$row['hash'].'&secret='.$row['secret'].'&tickets='.$row['wcode'].'" target="_blank">Verify this round</a></td>';
        echo '<td class="text-center">'.$row['time'].'</td>';
        echo '<td class="text-center">'.$row['join_time'].'</td></tr>';
      }
   ?>
   </tbody>
  </table>
</div>
</center>

<?php include 'bottom.php'; ?>
<!-- ALLL MODALS -->
<?php include 'Modals.php'; ?>
<!-- ALL MODALS -->
</body>
