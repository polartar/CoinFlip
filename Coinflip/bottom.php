<div class="menu__bottom">
    <div class="menu__bottom__item">
        <a href="fair.php" class="item__menu">Provably Fair</a>
    </div>
    <div class="menu__bottom__item">
        <a href="terms.php" class="item__menu">Terms Of Service</a>
    </div>
    <div class="menu__bottom__item">
        <a href="https://twitter.com/btcbattles" class="item__menu" target="_blank">Our Twitter</a>
    </div>
      <?php if($user){?>
     <div class="menu__bottom__item">
        <a href="game_history.php" class="item__menu">Game History</a>
    </div>
    <div class="menu__bottom__item">
        <a href="history.php?deposit=1" class="item__menu" >Deposit History</a>
    </div>
    <div class="menu__bottom__item">
        <a href="history.php?deposit=2" class="item__menu" >Withdraw History</a>
    </div>
    <?php }
    if ($user) {
        echo
        '
            <div class="menu__bottom__item">
                <a href="logout.php" class="item__menu">Logout</a>
            </div>
            ';
    } else {
    }
    ?>
    <div class="menu__bottom__item">
        <div class="item__menu"><?= $user['name'] ?></div>
    </div>
</div>