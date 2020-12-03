var IDS = [];


$(document).ready(function() {
	connect();

    SOCKET.emit('getBotInv', {
      hash: getCookie('hash')
    });


  $('#BotInventory').on('click', '#getBotInv', function() {
  	$('.botInv').empty();
    SOCKET.emit('getBotInv', {
      hash: getCookie('hash')
    });
  });

  $('#sendItems').click(function() {
  	sendItemsBOT($('#tradeLink').val(), IDS);
  });


  $('.botInv').on('click', '.item-card', function() {
  	if( !$(this).hasClass('selected') )
  	{
  		IDS.push( $(this).attr('assetid') );
  		$(this).addClass('selected');
  		$(this).attr('style', 'background-color: #5cb85c');
  	}
  	else
  	{
  		if(IDS.indexOf( $(this).attr('assetid') > -1))
  		{
  			IDS.splice( $(this).attr('assetid'), 1);
  			$(this).removeClass('selected');
  			$(this).attr('style', '');
  		}
  	}
  });

});


var SOCKET = null;

function onBot(msg)
{
	var m = msg;
	console.log(m);
	if(m.type == 'botInv')
    {
        var id = m.ids;
        var name = m.names;
        var pret = m.prices;
        var url = m.images;


       	$('.botInv').append('<div class="item-card__wrapper item ' + id + '" style="float: left;"><div class="item-card steam-quality-baseGrade steam-appid-730" price="' + pret + '" assetid="' + id + '"><div class="item-card__header"><h4 class="item-card__title_main steam-category-normal name">' + name + '</h4><small class="item-card__title_opt"></small></div><div class="item-card__image-wrapper item-card__image-wrapper--alfa"><img class="item-card__image item-card__image--zoom" src="http://steamcommunity-a.akamaihd.net/economy/image//' + url + '/200fx120f" alt="' + name + '"></div><div class="item-card__footer"><small style="position: relative; top: 32px; left: -10px; padding: 5px 10px; font-size: 11px; color: #fff; background-color: #222; font-weight: bold; border: 1px dotted #373737;">$<span class="val">' + pret + '</span></small></div></div></div>');
    }
}

function sendItemsBOT(link, ids)
{
	if(SOCKET)
	{
		SOCKET.emit('wantsInvBot', {
			hash: getCookie('hash'),
			link: link,
			assets: ids
		});
	}
}

function connect()
{
	if (!SOCKET)
	{
        var hash = getCookie('hash');
        if (hash == "") {
            $.notify('You must login!', 'success');
        }
        if (hash != "") {
            $.notify('Connecting to server ...', 'success');
        }
        SOCKET = io(':3001');
        SOCKET.on('connect', function(msg) {
            if (hash != "") {
                //$.notify('Connected!', 'success');
            }
            SOCKET.emit('hash', {
                hash: hash
            });
            $('#games tr').remove();
        });
        SOCKET.on('connect_error', function(msg) {
            $.notify('Connection lost!', 'success');
        });
        SOCKET.on('bot', function(msg) {
            onBot(msg);
        });

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

function getCookie(key){
	var patt = new RegExp(key+"=([^;]*)");
	var matches = patt.exec(document.cookie);
	if(matches){
		return matches[1];
	}
	return "";
}
