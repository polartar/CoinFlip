<title>BTCBattles - Top Players</title>
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

  <script src="../assets/js/jquery-3.2.1.js"></script>
  <script src="../assets/js/jquery.cookie.js"></script>
  <script src="../assets/js/jquery.dataTables.min.js"></script>
  <script src="../assets/js/socket.io-1.4.5.js"></script>
  
  <script src="../assets/js/notify.js"></script>
   
   

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
  <link rel="stylesheet" type="text/css" href="../assets/css/app.css?v=<?=time()?>">
  <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css?v=<?=time()?>">
  <link rel="stylesheet" type="text/css" href="assets/css/animate.min.css?v=<?=time()?>">
  <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css?v=<?=time()?>">
  <link rel="stylesheet" type="text/css" href="assets/css/w3.css?v=<?=time()?>">
  <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">
</head>

<?php include 'preheader.php'; ?>

<nav class="navbar navbar-inverse">
    <div class="logo">
        <a href="">
            <img src="../assets/images/logo-72dpi.png" srcset="assets/images/logo-retina.png 2x" alt="Logo">
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
                    if ($user) {echo "";
                        //echo '<a href="index.php?create=1"><button id="createCF" class="btn duel-btn-lg btn-create btn-lg btn-block new__game__button">Create new</button></a>';
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
 $flag = 0;
      if(isset($_POST['value']))
        if($_POST['value'] =="1")
          $flag =1;

?>
<div>
  <form action="" method="POST" id="form_recent">
    <label style="margin-left:40%">
      <?php
      if($flag ==1){
      ?>
      <input onclick="change()" id='recent' checked name ='recent' type="checkbox"> Recent 24hours
      <input type="hidden" value="0" id='value' name="value">
    <?php } else{?>
      <input onclick="change()" id='recent' name ='recent' type="checkbox"> Recent 24hours
      <input type="hidden" value="1" id='value' name="value">
    <?php }?>
    </label>
  </form>

</div>

<center>
<div class="container top-container" style="padding-top: 30px;">
      <table class="top tabelul table table-striped" style="width:100%;">
        <thead>
           <tr>
            <th>#</th>
            <th>PLAYER NAME</th>
            <th>Value</th>
          </tr>
        </thead>
        <tbody>
  <?php
  
 
      
      $query = $db->query('SELECT * FROM users');
      $rows = $query->fetchAll();
      $emails = array();
      $names = array();
      $avatars = array();
     foreach ($rows as $row) 
     {
        //array_push($emails,($row['email']=>'0'));
        $emails[$row['email']] = 0;
        $names[$row['email']] = $row['username'];
        $avatars[$row['email']] = $row['avatar'];
      }
    
       $yesterday = date('Y-m-d h:i:s', time()-86400);
      echo $yesterday;
      if($flag ==1)
        $Xp01 = $db->query('SELECT * FROM games where time>"'.$yesterday.'"');
      else  
        $Xp01 = $db->query('SELECT * FROM games');
      $Xp = $Xp01->fetchAll();

      foreach($Xp as $row)
      {

        $emails[$row['cemail']] = $emails[$row['cemail']] + $row['ctp'];
       
        if($row['timer11'] != -1)
          if($flag==0)
            $emails[$row['pemail']] = $emails[$row['pemail']] + $row['ctp'];
          else
          {
            if($row['join_time']> $yesterday)
              $emails[$row['pemail']] = $emails[$row['pemail']] + $row['ctp'];
          }

      }
      arsort($emails);
      $i = 0;
      foreach ($emails as $key => $value) {
        
        $i ++;
        echo '<tr><td>'.$i.'</td>';
        echo '<td><img style="width: 32px; height: 32px;" src="/uploads/' . $avatars[$key] . '"> '.$names[$key].'</td>';
        echo '<td>'.$value.'</td></tr>';
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
