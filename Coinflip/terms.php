<title>BTC Battles - Terms Of Use</title>
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
  <?php } ?>
    </li>

      </ul>
    </div>
  </div>
</nav>

<body class="hellos">


<div class="container terms-container" style="width: 1170px;">
    <div class="starter-template terms-inner-container" style="text-align:center; ">
        <h1 class="terms-header terms-main-header">TERMS OF SERVICE</h1>
        <p>1. By entering this website, the user is automatically agreeing to the terms of service stated on this page.</p>
        <p>1.1. Any person logged into the site is bound by these rules and must immediately leave the site if he or she has any disagreements with them.</p>
        <p>1.2. It is the responsibility of the user to read and understand these rules.</p>
        <p>1.3. Users on this site must be at least 18 or 21 (EIGHTEEN or TWENTY-ONE) years of age depending on what your countries law say about gambling.</p>
        <p>1.4. The user must not use the site in ways that can be described as harmful, dishonest or with the intent to exploit.</p>
        <h2 class="terms-header">Personal Responsibility</h2>
        <p>You are solely responsible for managing your account and password and for keeping your password confidential.</p>
        <p>You are also solely responsible for restricting access to your account.</p>
        <p>You agree that you are responsible for all activities that occur on your account or through the use of your password by yourself or by other persons. If you believe that a third party has access to your password, use the password regeneration feature of the Service to obtain a new password as soon as possible.</p>
        <p>In all circumstances, you agree not to permit any third party to use or access the Service.</p>
        <h2 class="terms-header">Usage Acceptance</h2>
        <ul>
            <li>Impersonate or misrepresent your affiliation with any person or entity;</li>
            <li>Access, tamper with, or use any non-public areas of the Service or BTCBattles.com computer systems;</li>
            <li>Attempt to probe, scan, or test the vulnerability of the Service or any related system or network or breach any security or authentication measures used in connection with the service and such systems and networks;</li>
            <li>Attempt to decipher, decompile, disassemble, reverse engineer or otherwise investigate any of the software or components used to provide the service;</li>
            <li>Harm or threaten to harm other users in any way or interfere with, or attempt to interfere with, the access of any user, host or network, including without limitation, by sending a virus, overloading, flooding, spamming, or mail-bombing the Service;</li>
            <li>Provide payment information belonging to a third party;</li>
            <li>Use the service in an abusive way contrary to its intended use, to BTCBattles.com policies and instructions and to any applicable law;</li>
            <li>Systematically retrieve data or other content from the service to create or compile, directly or indirectly, in single or multiple downloads, a collection, compilation, database, directory or the like, whether by manual methods, through the use of bots, crawlers, or spiders, or otherwise;</li>
            <li>Make use of the service in a manner contrary to the terms and conditions under which third parties provide facilities and technology necessary for the operation of the Service, such as Bitcoin wallets, exchanges or Valve;</li>
            <li>Infringe third party intellectual property rights when using or accessing the Service, including but not limited to in making available virtual items by using the Service;</li>
            <li>Make use of, promote, link to or provide access to materials deemed by BTCBattles.com at its sole discretion to be offensive or cause harm to BTCBattles.com reputation, including, but not limited to, illegal content and pornographic content and content deemed offensive or injurious to BTCBattles.com and/or the Service (such as Warez sites, IRC bots and bittorent sites).</li>


            <h2 class="terms-header">Losses</h2>
            <p>2. BTCBattles.com reserves the right to cancel any bet at any time.</p>
            <p>2.1. The site is not liable for any losses that may occur during such an instance.</p>
            <p>2.2. BTCBattles is in no way responsible for losses made on the site and offers no warranty or refund guarantee.</p>
            <p>2.3. BTCBatles will not be held accountable upon losses due to disconnection or latency.</p>
            <p>2.4. BTCBattles reserves the right to terminate any account for any reason and without prior notice.</p>
            <p>2.5. If the user has not notified support within 1 week after a problem has occured, he is no longer eligible for an eventual refund.</p>
            <p>2.6. It is the users responsibility to take note of the round and time when a problem occured before notifying support.</p>
            <h2 class="terms-header">Affiliations</h2>
            <p>3. BTCBattles / BTCBattles.com is in no way affiliated with steam, the valve corporation, or Counter-Strike.</p>
            <h2 class="terms-header">Deposits</h2>
            <p>The only deposit method we accept is Bitcoin (BTC) and the minimum deposit amount is $10 (USD value).</p>
            <p>It usually takes anywhere from 5 to 20 minutes for a Bitcoin transaction to be confirmed.</p>
            <p>Upon receiving 2 confirmations you will automatically be credited with onsite balance.</p>
            <p>Your onsite deposits are not withdrawable. More information can be read under withdraws. </p>
            <h2 class="terms-header">Withdraws</h2>
            <p>The only method of withdraw we offer is Bitcoin (BTC). </p>
              <p>Minimum amount to withdraw is 0.0019 BTC ($20 USD) </p>
                <p>Your onsite balance can't be withdrawn. You must wager your onsite balance and withdraw the value of the items won.  </p>
                  <p>Most withdrawal's are processed automatically. If there is a delay in receiving your withdrawal it is most likely a delay on the bitcoin network.  </p>
            <h2 class="terms-header">Content</h2>
            <p>4. The terms of service are subject to change at any time and might therefore be in effect without being updated on this page.</p>
            <h2 class="terms-header">Laws and jurisdictions</h2>
            <p>5. These Terms of Service will be governed by and construed in accordance with the laws of Willemstad, Curacao and any disputes relating to these terms and conditions will be subject to the exclusive jurisdiction of the courts of Willemstad, Curacao.</p>
        </ul></div>
</div>


<!-- ALLL MODALS -->
<?php include 'Modals.php'; ?>
<!-- ALL MODALS -->

</body>
