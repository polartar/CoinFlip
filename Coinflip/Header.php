  <script src="assets/js/bootstrap.min.js?v<?=time()?>"></script>

              <li class="active-menu menu-item-1">
                                  <a href="index.php">BATTLES</a></li>
                              <li class="menu-item-2">
                                  <a href="top.php">TOP PLAYERS</a></li>
                              <li class="menu-item-3">
                                  <a href="giveaway.php">GIVEAWAYS</a></li>
                              <li class="menu-item-4">
                                  <a href="offers.php">OFFERS</a></li>
                              
             <?php if ($user) {
                echo '<li class="menu-item-5">
                        <a href="inventory.php">INVENTORY</a></li>
                        <li class="menu-item-6">
                        <a id="showTradeURL" href="account.php">ACCOUNT</a>
                    </li>';
              } ?>

