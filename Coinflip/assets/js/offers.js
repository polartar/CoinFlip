

var assetidsItems = [];
var values = 0;
var minimumItems = 1;
var maximumItems = 12
var totalInventory = 0;

var priceSort = 'H2L';
var invpage = 1;

//CREATE INVENTORY
var passetIds = [];
var pValues = 0;
var ptotalInventory = 0;
var coin=1;
var balance2 =0;

$(document).ready(function() {
    $("#name").change(function(){
        search();
    })
    for(var i = 1; i <= 6; i++)
    {
        $("#price"+i).click(function(){
          search();
        })      
    }
    
    $('#invRefresh').click(function() {
        assetidsItems = [];
        values = 0;

        totalInventory = 0.00;

        $('#totalValue').text(parseFloat(values).toFixed(2));
        $('.itemsVar').text(assetidsItems.length);
    });

    $('.pages_next').click(function() {
         
        if(invpage <= 243) {
            invpage++;
            $('.page_number').text(invpage);
            showCreateInv();
        }
    });

    $('.pages_preview').click(function() {
        if(invpage >= 2) {
            invpage--;
            $('.page_number').text(invpage);
            showCreateInv();
        }
    });

    $('#CFjoinGame').on('hidden.bs.modal', function () {
       // assetidsItems = [];
        //values = 0;

        totalInventory = 0.00;

        $('#totalValue').text(parseFloat(pValues).toFixed(2));
        $('.itemsVar').text(passetIds.length);
    });

    $('#CFcreate').on('hidden.bs.modal', function () {
        passetIds = [];
        pValues = 0;

        ptotalInventory = 0.00;

        $('#totalValue2').text(parseFloat(pValues).toFixed(2));
         var fee = pValues * 0.06;
            var all = pValues + fee;
        $("#allValue").text(parseFloat(all).toFixed(2))
            $("#fee").text(parseFloat(fee).toFixed(2))
        $('#totalValue2').text(parseFloat(pValues).toFixed(2));
        $('.itemsVar2').text(passetIds.length);
    });

    $('#CFcreate').on('click', '#sendItemsCF', function() {
        newCoinflip(passetIds);
    });

    $('#invRefresh2').click(function() {
        passetIds = [];
        pValues = 0;

        ptotalInventory = 0.00;

        $('#totalValue2').text(parseFloat(pValues).toFixed(2));
        $('.itemsVar2').text(passetIds.length);
    });

    $('#createCF').click(function() {
        showCreateInv();
    });


    $('.container3').on('click', '.item-card', function() {
        if(!$(this).hasClass('selected'))
        {
            if(assetidsItems.length == maximumItems)
            {
                $.notify('Error: You can select maximum 12 items!', 'success');
                return;
            }

            values += parseFloat($(this).attr('price'));
            $(this).addClass('selected');

            $(this).attr('style', 'background-color: #5cb85c');
            if(values <= 0)
            {
                values = 0;
            }

            assetidsItems.push($(this).attr('assetid'));

            $('.itemsVar').text(assetidsItems.length);
            $('#totalValue').text(parseFloat(values).toFixed(2));

            if(values < Gapa01)
            {
                $('.offerValidator').html('Needs: <span class="ofhighlightred">+ $' + parseFloat(Gapa01-values).toFixed(2) + '</span>');
            }
            else if(values > Gapa02)
            {
                $('.offerValidator').html('Needs: <span class="ofhighlightred">- $' + parseFloat(Gapa02-values).toFixed(2).replace('-', '') + '</span>');
            }
            else if(values >= Gapa01 && values <= Gapa02)
            {
                $('.offerValidator').html('Needs: <span class="ofhighlightgreen">Valid offer</span>');
            }
        }
        else
        {
            values -= parseFloat($(this).attr('price'));
            $(this).removeClass('selected');

            $(this).attr('style', 'background-color: ');
            if(values <= 0)
            {
                values = 0;
            }

            var remove = assetidsItems.indexOf($(this).attr('assetid'));
            if(remove != -1)
            {
                assetidsItems.splice(remove, 1);
            }

            $('.itemsVar').text(assetidsItems.length);
            $('#totalValue').text(parseFloat(values).toFixed(2));

            if(values < Gapa01)
            {
                $('.offerValidator').html('Needs: <span class="ofhighlightred">+ $' + parseFloat(Gapa01-values).toFixed(2) + '</span>');
            }
            else if(values > Gapa02)
            {
                $('.offerValidator').html('Needs: <span class="ofhighlightred">- $' + parseFloat(Gapa02-values).toFixed(2).replace('-', '') + '</span>');
            }
            else if(values >= Gapa01 && values <= Gapa02)
            {
                $('.offerValidator').html('Needs: <span class="ofhighlightgreen">Valid offer</span>');
            }
        }
    });

    $('#coin1').click(function(){
        coin = 1;
        $(this).children().addClass("border");
        $("#coin2").children().removeClass("border");
    })
     $('#coin2').click(function(){
      
        coin = 2;
        $(this).children().addClass("border");
        $("#coin1").children().removeClass("border");
        
    })
    $('.container2').on('click', '.item-card', function() {
        if(!$(this).hasClass('selected'))
        {
            if(passetIds.length == maximumItems)
            {
                $.notify('Error: You can select maximum 12 items!', 'success');
                return;
            }

            pValues += parseFloat($(this).attr('price'));
            var fee = pValues * 0.06;
            var all = pValues + fee;
            if(!balance)
                balance = $("#u_balance").val();
            
            $(this).addClass('selected');

            $(this).attr('style', 'background-color: #5cb85c');
            if(pValues <= 0)
            {
                pValues = 0;
            }

            passetIds.push($(this).attr('assetid'));
            $("#allValue").text(parseFloat(all).toFixed(2))
            $("#fee").text(parseFloat(fee).toFixed(2))
            $('.itemsVar2').text(passetIds.length);
            $('#totalValue2').text(parseFloat(pValues).toFixed(2));
        }
        else
        {
            pValues -= parseFloat($(this).attr('price'));
            $(this).removeClass('selected');

            $(this).attr('style', 'background-color: ');
            if(pValues <= 0)
            {
                pValues = 0;
            }
            var fee = pValues * 0.06;
            var all = pValues + fee;
            var remove = passetIds.indexOf($(this).attr('assetid'));
            if(remove != -1)
            {
                passetIds.splice(remove, 1);
            }
              $("#allValue").text(parseFloat(all).toFixed(2))
            $("#fee").text(parseFloat(fee).toFixed(2))
            $('.itemsVar2').text(passetIds.length);
            $('#totalValue2').text(parseFloat(pValues).toFixed(2));
        }
    });
});

function search()

{
    var name = $("#name").val();
    var prices =[];

    for(var i = 1;  i <= 6 ; i ++)
    {
       prices[i-1] = $("#price"+i).is(":checked");
    }
    var sort = $(".price-sorting").text();
    SOCKET.emit("wantInv2",{sort:sort,page:invpage,hash:getCookie('hash'),name:name,prices:prices.join("/")});
}

function showCreateInv()
{
    var user_hash = getCookie('hash');
    if(SOCKET)
    {
        $('.modal-loading2').css('display', 'block');
        $('.container2').empty();
        setTimeout(function() {
            $('.modal-loading2').css('display', 'none');
            ptotalInventory = 0.00;
             var name = $("#name").val();
            var prices =[];

            for(var i = 1;  i <= 6 ; i ++)
            {
               prices[i-1] = $("#price"+i).is(":checked");
            }
            SOCKET.emit('wantInv2', {
                hash: user_hash,
                page: invpage,sort:'H2L',
                name:name,prices:prices.join("/")
            });
        }, 500);
    }
}

function sortItemsPrice(sort) {
    var user_hash = getCookie('hash');
    if(SOCKET)
    {
        var name = $("#name").val();
        var prices =[];

        for(var i = 1;  i <= 6 ; i ++)
        {
           prices[i-1] = $("#price"+i).is(":checked");
        }

        if(sort == 'H2L') {
            priceSort = 'H2L';
            SOCKET.emit('wantInv2', {
                hash: user_hash,
                page: invpage,
                sort: priceSort,
                name:name,prices:prices.join("/")
            });
        } else if(sort == 'L2H') {
            priceSort = 'L2H';
            SOCKET.emit('wantInv2', {
                hash: user_hash,
                page: invpage,
                sort: priceSort,
                name:name,prices:prices.join("/")
            });
        }
    }
}


function cfJoinGame()
{
    var user_hash = getCookie('hash');
    var ids = assetidsItems.join('/');
    if(balance2<parseFloat($("#allValue1").text()))
            {
                Notification.create(
            // Title
            "Your balance is not enough to by this item. Your balance is "+balance2,
            // Text
            "",
            // Illustration
            "/assets/images/msg.svg",
            // Effect
            "shake",
            // Position
            position
           );
                 
                return;
            }
    
    if(SOCKET)
    {
        SOCKET.emit('joingame', {
            price: parseFloat($("#allValue1").text()),
            gameID: gameJoin,
            tradelink: tradeLink,
            hash: user_hash
        });
    }
    balance2 = balance2 - parseFloat($("#allValue1").text());
}

function wantInventory()
{
    var hashul = getCookie('hash');
    if(SOCKET)
    {
        $('.modal-loading').css('display', 'block');
        $('.container1').empty();
        setTimeout(function() {
            $('.modal-loading').css('display', 'none');
            totalInventory = 0.00;
            
            SOCKET.emit('wantInv', {
                hash: hashul,
                page: invpage
            });
        }, 500);
    }
}

function newCoinflip(Items)
{
    var user_hash = getCookie('hash');
    var ids = Items.join('/');
     
  
    if(SOCKET)
    {
        SOCKET.emit('newGame', {
            assets: ids,
            coin:coin,
            total: pValues,
            hash: user_hash
        });
    }
}
