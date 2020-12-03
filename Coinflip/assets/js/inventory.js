var balance =0;
var SOCKET = null;
var passetIds=[];
var pValues = 0;
$(document).ready(function() {
	connect();
	  $('#settingsMenu').click(function() {
        $('#settingsModal').modal();
    });
	  // $('#showTradeURL').click(function() {
   //      $('#tradeLink').modal();
   //  });
	
	$("#Tobalance").click(function(){
		console.log("toBalance",passetIds);
		SOCKET.emit("toBalance",{assets:passetIds,hash:getCookie('hash'),price:pValues});
		 
	})
    $('.containerinv').on('click', '.item-card', function() {
        if(!$(this).hasClass('selected'))
        {
             

            pValues += parseFloat($(this).attr('price'));
            
            
            $(this).addClass('selected');

            $(this).attr('style', 'background-color: #5cb85c');
            if(pValues <= 0)
            {
                pValues = 0;
            }

            passetIds.push($(this).attr('assetid'));
          	console.log("push",passetIds);
            $('#selected_items').text(passetIds.length);
            $('#selected_amounts').text(parseFloat(pValues).toFixed(2));
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
           
            var remove = passetIds.indexOf($(this).attr('assetid'));
            if(remove != -1)
            {
                passetIds.splice(remove, 1);
            }
            
             $('#selected_items').text(passetIds.length);
            $('#selected_amounts').text(parseFloat(pValues).toFixed(2));
        }
    });
})

function getCookie(key){
    var patt = new RegExp(key+"=([^;]*)");
    var matches = patt.exec(document.cookie);
    if(matches){
        return matches[1];
    }
    return "";
}
 
function connect()
{
	if (!SOCKET)
	{
	   SOCKET = io(':3001');
	   var hash = getCookie("hash");
       SOCKET.on('connect', function(msg) {
            if (hash != "") {
                //$.notify('Connected!', 'success');
            }
            SOCKET.emit('myItems', {
                hash: hash
            });
            
        });
        SOCKET.on('connect_error', function(msg) {
            $.notify('Connection lost!', 'success');
        }); 
       SOCKET.on("myItems",function(m){
       	 
       		balance = m.balance;
       		var total = 0.0;
       		var assets = m.assets;
       		$('.containerinv').empty();
       		if(m.assets=="000")
       		{
       			
       			return;
       		}
       		assets = assets.split("/");
       		$("#total_items").text(m.name.length);
       		
       		console.log("len",m.name.length);
       		for(var i =0; i<m.name.length; i++) {
       			var temp = m.name[i];
		        while(temp.indexOf('##') != -1)
		         {
		            temp = temp.replace("##","★");
		         }
		         
       			total = total+ parseFloat(m.price[i]);
            	$('.containerinv').append('<div class="item-card__wrapper item" style="float: left;"><div class="item-card steam-quality-baseGrade steam-appid-730" assetid="'+ assets[i] +'" price="' + m.price[i] + '"><div class="item-card__header"><h4 class="item-card__title_main steam-category-normal name">' + temp + '</h4><small class="item-card__title_opt"></small></div><div class="item-card__image-wrapper item-card__image-wrapper--alfa"><img class="item-card__image item-card__image--zoom" src="' + m.img[i] + '" alt="' + temp + '"></div><div class="item-card__footer"><small style="position: relative;top: 24px;left: 0px;padding: 5px 10px;font-size: 11px;color: #fff;font-weight: bold;">$<span class="val">' + m.price[i] + '</span></small></div></div></div>');
        	}
        	console.log(total);
        	total = total.toFixed(2);
        	$("#total_amounts").text(total);
        	$("#u_balance").text(m.balance);

       })
 		 SOCKET.on('disconnect', function(m) {
            SOCKET.emit('disconnect', {
                uhash: hash
            });
        });    
    }
    else
    {
        console.log("Error: connection already exists.");
    }
}
