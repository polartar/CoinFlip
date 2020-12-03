
    <div class="pre-header">
    <div class="bitcoin-course">
        <div>
            <img src="assets/images/bitcoin.svg" alt="" class="bitcoin-course-icon"><span
                    class="bitcoin-course-text"><span class="money-sign">$</span><span id="b_rate"> </span></span>
            <img src="assets/images/tree.svg" alt="" class="tree-icon"><span
                    class="tree-number"><span class="money-sign"></span>21</span>
        </div>
    </div>
    <div class="user-balance">
        <?php
        if ($user) {
            echo '<div>
            <span src="" alt="" class="user-balance-sign">balance:</span>
            <span class="user-balance-sum"><span class="money-sign">$</span><span id="u_balance">'.$user['balance'].'</span></span>
        </div>';
        }
        ?>
    </div>
</div>
 <?php
    $rate=0.0;
        require('coinpayments.inc.php');
                $cps = new CoinPaymentsAPI();
                $cps->Setup('8013d91333d1cC6C04F10C6D7Ba577773ED4F3C005dbE1B397f9fbb082906B0F', 'd8d740d4e93870b0714f57ccdb1622d139272ca1b9f7f773b6ce6f631501ff97');
                    $result = $cps->GetRates();
                if ($result['error'] == 'ok') {
                    $rate = number_format(1/floatval($result['result']['USD']['rate_btc']),3);
                } else {
                    $rate = "Connection error";
                }
                echo "<script>$('#b_rate').text('".$rate."');</script>";

    ?>