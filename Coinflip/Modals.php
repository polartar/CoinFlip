<!-- MODALS -->
<div class="modal fade" id="tradeLink">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $user['username']; ?></h4>
            </div>
            <div id="settings-msg" class="modal-title text-center settings__url">By supplying your steam trade link, you're confirming that you've read and agree to <br/><a href="terms.php" style="color: #f7c22c !important">BTCBattles Terms of Service</a>.</div>
            <br>
            <form action="upload.php" method="post" enctype="multipart/form-data">
                Select image to upload:
                <input type="file" name="file_image" id="file_image">
                <input type="submit" value="Upload Image" name="submit">
            </form>
            <p style="font-weight: 600;letter-spacing: 1.5px;font-size: 12px;color: #b1b1b1;font-family: Open Sans, sans-serif;" class="form-description text-right"><a href="http://steamcommunity.com/id/id/tradeoffers/privacy#trade_offer_access_url" target="_blank">Check your tradelink here.</a></p>
            <div class="modal-footer">
                <input type="submit" value="Submit" type="button" class="btn duel-btn-lg">
                <script>
                    $(document).ready(function() {
                      $('#input1').val("<?php echo $user['tradelink']; ?>");
                    });
                </script>
            </div>
        </div>
    </div>
</div>
<!-- MODALS trade-url -->
<!-- MODALS register -->
<div class="modal fade" id="register">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">REGISTER</h4>
            </div>
            <div id="settings-msg" class="modal-title text-center settings__url">By making an account here you are accepting all terms of use. <br/><a href="terms.php" style="color: #f7c22c !important">Terms of Service</a></div>
            <br>
            <div class="input-group">
                <input id="input_email" type="text" name="email" id="email" class="form-control" required="" parsley-type="text" value="" size="256" placeholder="Email" data-parsley-id="40" style="margin-bottom: 10px;">
                <input id="input_username" type="text" name="username" id="username" class="form-control" required="" parsley-type="text" value="" size="256" placeholder="Username" data-parsley-id="40" style="margin-bottom: 10px;">
                <input id="input_pass1" type="password" name="password" id="password" class="form-control" required="" parsley-type="text" value="" size="256" placeholder="Password" data-parsley-id="40" style="margin-bottom: 10px;">
                <input id="input_pass2" type="password" name="password" id="password2" class="form-control" required="" parsley-type="text" value="" size="256" placeholder="Password confirmation" data-parsley-id="40">
            </div>
            <p style="font-weight: 600;letter-spacing: 1.5px;font-size: 12px;color: #b1b1b1;font-family: Open Sans, sans-serif;" class="form-description text-right"><a href="#" target="_blank">Click the register button below to create your account.</a></p>
            <div class="modal-footer">
                <input id="button2" value="Register" type="button" class="btn duel-btn-lg">
            </div>
        </div>
    </div>
</div>
<!--  !Modals for deposit  -->
<div class="modal fade" id="deposit">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">DEPOSIT</h4>
            </div>
            <div id="settings-msg" class="modal-title text-center settings__url">By depositing to your account, you are accepting all terms of use. <br/><a href="terms.php" style="color: #f7c22c !important">Terms of Service</a></div>
            <div class="row" >
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">Your balance from the onsite: $<span id="onsite_balance"><?php echo $user['balance']; ?></span></div>
                <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1 col-lg-6 col-lg-offset-3">
                  <form action="#" id="form_deposit" method="POST" class="deposit-form">
                      <div class="form-group">
                          <label>Deposite Amount $</label>
                          <input id="input_amount" type="number" name="input_amount"  class="form-control" required="" placeholder="$">
                      </div>
                      <button type="button" id="b_deposit" class="btn duel-btn-lg btn-create btn-lg btn-block new__game__button b_deposit" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Please wait...">Deposit</button>
                  </form>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1">
                  <div class="row deposit_info" style="display:none;">
                      <div class="col-sm-3 col-xs-3 col-xxs-12 deposit-info-code">
                          <img id="qrcode_url" src="" alt="Qrcode Url" class="img-responsive" />
                      </div>
                      <div class="col-sm-9 col-xs-9 col-xxs-12 deposit-info-address">
                          <p class="response-amount-address">Send <b id="response_amount_btc"> 0.00 BTC</b> to address: </p>
                          <div class="input-group">
                              <input class="form-control" id="response_address" type="text"  readonly="">
                              <div class="input-group-addon btn red"><a href="javascript:void(0)" class="postfix copy_url">Copy Address</a></div>
                          </div>
                          <b class="notice">* Deposit will be credited instantly after few confirmations</b>
                      </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!--  !Modals for withdraw  -->
<div class="modal fade" id="withdraw">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">WITHDRAW</h4>
            </div>
            <div id="settings-msg" class="modal-title text-center settings__url">* Minimum withdrawal amount is $10</div>
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1 col-lg-6 col-lg-offset-3">
                <form action="#" id="form_withdraw" method="POST" class="withdrawal-form">
                  <div class="form-group">
                    <label>Your Bitcoin Address</label>
                    <input id="user_bitcoin_address" type="text" name="user_bitcoin_address" class="form-control">
                  </div>
                  <label class="your-withdraw-label">Your Withdraw Amount : <span id="s_withdraw_amount"></span></label>
                  <input type="hidden" name="user_withdraw_amount" id="user_withdraw_amount" value="" />
                  <input type="hidden" name="user_assets" id="user_assets" value="" />

                  <button type="button" id="b_withdraw" class="btn duel-btn-lg btn-create btn-lg btn-block new__game__button b_withdraw" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Please wait...">Withdraw</button>
                </form>
              </div>
              <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1">
                <div class="row withdraw_info" style="display:none;">
                    <div class="col-sm-3 col-xs-3 col-xxs-12 deposit-info-code">
                        <img id="qrcode_url" src="" alt="Qrcode Url" class="img-responsive" />
                    </div>
                    <div class="col-sm-9 col-xs-9 col-xxs-12 deposit-info-address">
                        <p class="response-amount-address">Send <b id="response_amount_btc"> 0.00 BTC</b> to address: </p>
                        <div class="input-group">
                            <input class="form-control" id="response_address" type="text"  readonly="">
                            <div class="input-group-addon btn red"><a href="javascript:void(0)" class="postfix copy_url">Copy Address</a></div>
                        </div>
                        <b class="notice">* Deposit will be credited instantly after few confirmations</b>
                    </div>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- MODALS View Single Deposit History -->
<div class="modal fade" id="viewDepositHistory" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog deposit-info modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Deposit History</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>
<!-- MODALS login -->
<div class="modal fade" id="login">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">LOGIN</h4>
            </div>
            <div id="settings-msg" class="modal-title text-center settings__url">Login to your BTCBattles account using an email and password.</div>
            <br>
            <div class="input-group">
                <input id="login_email" type="text" name="email" id="email" class="form-control" required="" parsley-type="text" value="" size="256" placeholder="Email" data-parsley-id="40" style="margin-bottom: 10px;">
                <input id="login_password" type="password" name="password" id="password" class="form-control" required="" parsley-type="text" value="" size="256" placeholder="Password" data-parsley-id="40" style="margin-bottom: 10px;">
            </div>
            <p style="font-weight: 600;letter-spacing: 1.5px;font-size: 12px;color: #b1b1b1;font-family: Open Sans, sans-serif;" class="form-description text-right"><a href="terms.php" target="_blank">By logging into your account you are accepting our terms and conditions</a></p>
            <div class="modal-footer">
                <input id="button3" value="Login" type="button" class="btn duel-btn-lg">
            </div>
        </div>
    </div>
</div>
<!-- Modal COINFLIP GAME -->
<div class="modal fade" id="coinflip">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Coinflip <span id="coinflip-watch-gameid" class="cfvGameID"></span></h4>
            </div>
            <div class="modal-inner">
                <div id="cfRoundView" data-gameid="26">
                    <div class="row">
                        <div class="col-xs-4">
                            <div class="col-header col-left"><img id="P1avatar" style="width: 130px"><img id="P1coin">
                            </div>
                        </div>
                        <div class="col-xs-4 col-timer">
                            <div id="coinflip-coin">
                                <div class="coinflip-coin coinflip_winner_2" style="margin-top:-5px;margin-left:65px;">
                                    <div id="coin-flip-cont" style="position:relative;" class="">
                                        <div id="coin" class="">
                                            <div class="front"></div>
                                            <div class="back"></div>
                                        </div>
                                        <div class="counter"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="col-header col-right"><img id="P2avatar" style="width: 130px"><img id="P2coin">
                            </div>
                        </div>
                    </div>
                    <div class="row row-header">
                        <div class="col-xs-4 lname text-right">
                            <div id="name-1"><span id="P1name">none</span></div>
                        </div>
                        <div class="col-xs-4 verify">
                            <span style="font-size: 12px;color: #888;">Hash: </span><span class="gameHashh" style="color: #888;"></span>
                            <div class="gameSecrettt" style="color: #888;"></div>
                        </div>
                        <div class="col-xs-4 rname text-left">
                            <div id="name-2"><span id="P2name">None</span></div>
                        </div>
                    </div>
                    <div class="row">
                        <div id="cfRoundCreator" class="col-xs-6">
                            <div class="row row-total">
                                <div class="col-xs-4"><i class="fa fa-dollar"></i> <span id="ctp" class="total-amount">0</span></div>
                                <div class="col-xs-4"><span class="P1-tItems"></span> items</div>
                                <div class="col-xs-4"><span class="P1chance"></span></div>
                            </div>
                            <div id="ItemsP1" class="col-items">
                            </div>
                        </div>
                        <div id="cfRoundOpponent" class="col-xs-6">
                            <div class="row row-total">
                                <div class="col-xs-4"><i class="fa fa-dollar"></i> <span id="ptp" class="total-amount">0</span></div>
                                <div class="col-xs-4"><span class="P2-tItems"></span> items</div>
                                <div class="col-xs-4"><span class="P2chance"></span></div>
                            </div>
                            <div id="ItemsP2" class="col-items"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
<!-- Modal COINFLIP GAME -->
<!-- Modal cfjoin -->
<div class="modal fade" id="CFjoinGame">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Join a coinflip battle</h4>
            </div>
            <div id="invUser">
                <div class="row row-inventory">
                    <div class="col-xs-3 col-md-5">
                        <p class="small">
                            min. $<span class="Gap01"></span>, max. $<span class="Gap02"></span>,
                            <br>Here at BTCBattles our battles are 100% transparent. <br/> Each side of the coin offers true 50% chance of winning. Our fee<br /> is 6% payable by both parties ontop of the cost of items.  
                        </p>
                    </div>
                    <div class="col-xs-2 col-md-2">
                        <img id='join_coin' src='/assets/images/coin-ct2.png'   >
                    </div>
                    <div class="col-xs-7 col-md-5">
                        <div id="inventoryMakeOffer">
                            <div class="row">
                                <div style="line-height: 1.5;width: 265px;" class="col-sm-4">
                                    <div class="inventory-selected">Total: <span class="itemsVar">0</span> <span>items, valued at: </span>$ <span id="totalValue">0.00</span><br><span>Fee: $</span><span id="fee1">0.0</span>&nbsp;&nbsp;&nbsp;<span>Total value: $</span><span id="allValue1">0.0</span><br>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="inventory-selected"></div>
                                </div>
                                <div class="col-sm-4 col-button"><button class="btn duel-btn-lg new__game__button" id="cfJoin" onclick="cfJoinGame()" value="Deposit" readonly>Join</button></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--   <div class="row row-header">
                    <button id="invRefresh" class="btn btnref pull-right"><i class="fa fa-refresh"></i> Refresh inventory</button>
                    <div class="pages_preview">>> </div>
                    <div>1</div>
                    <div class="pages_next"> <<</div>
                    </div>
                    -->
                <div class="inventory-user">
                    <div class="modal-loading" style="margin: 25% 50% 50% 50%;position: absolute;"><img src="assets/images/loading.gif" alt="Loading" class="icon-loading"></div>
                    <div class="row item-holder noselect ps-container" data-ps-id="3d673896-2360-0f6d-b9b6-e99aab918636" style="height: 515px; display: block;">
                        <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 0px;">
                            <div class="ps-scrollbar-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                        </div>
                        <div class="ps-scrollbar-y-rail" style="top: 0px; right: 0px;">
                            <div class="ps-scrollbar-y" tabindex="0" style="top: 0px; height: 0px;">
                                <div class="container1" style="overflow:scroll; overflow-x:hidden;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
<!-- Modal cfjoin -->
<!-- Modal create game -->
<div class="modal fade" id="CFcreate">
<div class="modal-dialog modal-lg">
<div class="modal-content">
    <div class="modal-header">
    </div>
    <div id="invUser">
        <div class="row row-inventory">
            <div class="col-xs-8 col-md-6">
                <div id="inventoryMakeOffer">
                    <div class="row">
                        <div style="line-height: 1.5;width: 265px;" class="col-sm-4">
                            <div class="inventory-selected">Total: <span class="itemsVar2">0</span> <span>items, valued at: </span>$ <span id="totalValue2">0.00</span><br><span>Fee: $</span><span id="fee">0.0</span>&nbsp;&nbsp;&nbsp;<span>Total value: $</span><span id="allValue">0.0</span><br>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="inventory-selected"></div>
                        </div>
                        <?php
                            if($user['tradelink']) {
                              echo '<div class="col-sm-4 col-button"><button id="sendItemsCF" class="new__game__button" value="Create game" style="width: 150px;padding: 0.5em;" readonly>Create game</button></div>';
                            }else{
                              echo '<div class="col-sm-4 col-button"><a onclick="noURL()" href="#"><button class="new__game__button" value="Create game" style="width: 150px;padding: 0.5em;" readonly>Create game</button></a></div>';
                            }
                            ?>
                    </div>
                </div>
            </div>
            <div class="col-xs-4 col-md-6 text-center" style="padding-top:30px">
                <a href="#" id="coin1" style="margin-right: 50px"><img class="border" src='/assets/images/coin-t1.png'></a> <a href="#" id="coin2"><img src='/assets/images/coin-ct2.png'></a>
            </div>
        </div>
        <div class="row row-header">
            <select class="price-sorting type-regular" name="price-sorting">
                <option selected value="l2h">Low to high</option>
                <option value="h2l">High to low</option>
            </select>
            <form class="form-inline"  >
                <div class="form-group">
                    <label for="name">Item name:</label>
                    <input type="text" onkeyup="search()" class="form-control" style="border-bottom-width: 1px;border-bottom-color: white" id="name">
                </div>
                <div class="checkbox">
                    <label><input id='price1' checked type="checkbox"> 0-5$</label>
                </div>
                <div class="checkbox">
                    <label><input id='price2' checked type="checkbox"> 5-20$</label>
                </div>
                <div class="checkbox">
                    <label><input id='price3' checked type="checkbox"> 20-50$</label>
                </div>
                <div class="checkbox">
                    <label><input id='price4' checked type="checkbox"> 50-100$</label>
                </div>
                <div class="checkbox">
                    <label><input id='price5' checked  type="checkbox"> 100-200$</label>
                </div>
                <div class="checkbox">
                    <label><input id='price6' checked type="checkbox"> 200$-</label>
                </div>
            </form>
        </div>
        <div class="inventory-user">
            <div class="modal-loading2" style="margin: 25% 50% 50% 50%;position: absolute;"><img src="assets/images/loading.gif" alt="Loading" class="icon-loading"></div>
            <div class="row item-holder noselect ps-container" data-ps-id="3d673896-2360-0f6d-b9b6-e99aab918636" style="height: 400px; display: block;">
                <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 0px;">
                    <div class="ps-scrollbar-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                </div>
                <div class="ps-scrollbar-y-rail" style="top: 0px; right: 0px;">
                    <div class="ps-scrollbar-y" tabindex="0" style="top: 0px; height: 0px;">
                        <div class="container2" style="overflow:scroll; overflow-x:hidden;">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="change_page">
                    <i class="fa fa-angle-double-left pages_preview"></i>
                    <div class="page_number"> 1 </div>
                    <i class="fa fa-angle-double-right pages_next"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal create game -->
<!-- Modal settings -->
<div class="modal fade" id="settingsModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?=$user['name']?>'s settings</h4>
            </div>
            <center>
                <div class="input-group">
                    <input id="hidetheLink" type="checkbox"> hide link on chat
                    <br>
                </div>
            </center>
            <div class="modal-footer">
                <button id="submitSettings" value="Submit" type="button" class="btn duel-btn-lg">Accept</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal settings -->
<!-- Modal rules -->
<div class="modal fade" id="chatRules">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="confirmModalLabel">Rules</h4>
            </div>
            <div class="col-md-10 modal-text" style="margin-top: 35px;">
                <p>Everyone could use our chat platform by following these rules:</p>
                <ul>
                    <li>No advertising</li>
                    <li>No spamming</li>
                    <li>No begging</li>
                    <li>Not harassing other people</li>
                    <li>No caps</li>
                    <li>No trading/selling messages</li>
                </ul>
                <p class="fs11">If you don't follow the rules, you could get a mute between 5 minutes and 30 days. In extreme cases you could get a lifetime chat mute.</p>
                <p class="fs11">If you wanna get helped talk in english please.
            </div>
        </div>
    </div>
    <i id="rclose" type="submit" class="ti-close close__modal"></i>
</div>
<!-- Modal rules -->
<!-- Modal trades -->
<div class="modal fade" id="tradeModal">
    <div class="modal-dialog" style="top:40%;">
        <div class="modal-content">
            <!--<p style="font-weight: bold;" id="myModalLabel" class="tradeAlert modal-title alert text-center alert-danger"><i class="fa fa-spinner fa-spin"></i> Processing trade offer...</p>-->
        </div>
    </div>
</div>
<!-- Modal trades -->