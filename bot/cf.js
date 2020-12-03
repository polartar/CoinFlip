var fs = require("fs");
var request = require("request");
var config = require("./config.json");
var CryptoJS = require("crypto-js");
var log4js = require("log4js");
var mysql = require("mysql");
var express = require("express");
var app = express();
var logger = log4js.getLogger();
var server = require("http").createServer();
var io = require("socket.io")(server);
server.listen(4433);
var first_price = [0, 5, 20, 50, 100, 200];
var second_price = [5, 20, 50, 100, 200, 10000000];

updateLog();
function updateLog() {
  logger.debug("New log...");

  log4js.configure({
    appenders: {
      out: { type: "console" },
      app: { type: "file", filename: "logs/site_" + time() + ".log" },
    },
    categories: {
      default: { appenders: ["out", "app"], level: "all" },
    },
  });
  setTimeout(function () {
    updateLog();
  }, 24 * 3600 * 1000);
}

var logger = log4js.getLogger();

var pool;
const useragent =
  "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/57.0.2987.133 Safari/537.36";

var db_config = {
  host: config.options.sql["host"],
  user: config.options.sql["username"],
  socketPath: "/var/run/mysqld/mysqld.sock",
  password: config.options.sql["password"],
  queueLimit: 0,
  connectionLimit: 0,
  database: config.options.sql["database"],
};

handleDisconnect();

process.on("uncaughtException", function (err) {
  logger.error("Strange error");
  logger.error(err);
});

//GAME INFO
var AppID = 730;
var ContextID = 2;
var minDep = config.options.minDeposit;

var proxies = config.proxies;

var deletingTrades = [];

var inventoryTimer = {};
var socketBySteam = {};

var tradingRequests = {};

var loadGames = [];
var timerGame = {};
var timer11Game = {};

var depositTrades = [];
var depositSteamTrades = [];

var gamesPending = {};

var antiFlood = {};
var timesFlooding = {};

var inventorySite = {};

//CHAT FUNCTIONS
var chatMessages = [];
var usersOnline = {};
var count = 0;
var antiSpamChat = {};
//CHAT FUNCTIONS

getInv();
loadAllGames();
function sendmyItems(socket, hash) {
  pool.query(
    "SELECT * FROM users WHERE hash =" + pool.escape(hash),
    function (err, row) {
      if (err) throw err;

      if (row.length == 0) return;
      pool.query(
        "SELECT assets FROM items WHERE userID =" + row[0].id,
        function (err, row1) {
          if (err) throw err;

          if (row1.length == 0) {
            socket.emit("myItems", {
              assets: "000",
              name: [],
              price: [],
              img: [],
              balance: row[0].balance,
            });
            return;
          }

          var assets = row1[0].assets.split("/");
          var inventory = inventorySite["items"];

          var name = inventory["name"].split(",");
          var price = inventory["price"].split(",");
          var img = inventory["img"].split(",");

          var name_page = [];
          var price_page = [];
          var img_page = [];
          for (var i = 0; i < assets.length; i++) {
            var temp = name[assets[i]];

            while (temp.indexOf("★") != -1) {
              temp = temp.replace("★", "##");
            }
            while (temp.indexOf("™") != -1) {
              temp = temp.replace("™", "#$");
            }
            name_page.push(temp);
            price_page.push(price[assets[i]]);
            img_page.push(img[assets[i]]);
          }

          socket.emit("myItems", {
            assets: row1[0].assets,
            name: name_page,
            price: price_page,
            img: img_page,
            balance: row[0].balance,
          });
        }
      );
    }
  );
}

function loadAllGames() {
  pool.query(
    "SELECT * FROM games WHERE `ended` = 0",
    function (err, res, fields) {
      if (err) throw err;

      loadGames = [];

      for (var i in res) {
        loadGames.push({
          id: res[i].id,
          cemail: res[i].cemail,
          cusername: res[i].cname,
          cavatar: res[i].cavatar,
          cskinsurl: res[i].cskinsurl,
          cskinsusernames: res[i].cskinsnames,
          cskinsprices: res[i].cskinsprices,
          cskins: res[i].cskins,
          ctp: res[i].ctp,
          pemail: res[i].pemail,
          pusername: res[i].pname,
          assets: res[i].passetids,
          pavatar: res[i].pavatar,
          pskinsurl: res[i].cskinsurl,
          pskinsusernames: res[i].cskinsnames,
          pskinsprices: res[i].cskinsprices,
          pskins: res[i].cskins,
          ptp: res[i].ctp,
          hash: res[i].hash,
          secret: res[i].secret,
          scode: res[i].scode,
          winner: res[i].winner,
          timer11: res[i].timer11,
        });
      }
    }
  );
}

io.on("connection", function (socket) {
  socket.on("toBalance", function (m) {
    var assets = m.assets;
    var inventory = inventorySite["items"];

    var sql = "SELECT * FROM users WHERE hash='" + m.hash + "'";
    pool.query(sql, function (err, row) {
      if (err) throw err;

      if (row.length == 0) return;
      var balance = row[0].balance;
      balance = parseFloat(balance) + parseFloat(m.price);
      var sql =
        "UPDATE users set balance=" + balance + " WHERE hash='" + m.hash + "'";
      pool.query(sql, function (err, row1) {
        if (err) throw err;
        if (row1.length == 0) return;
      });

      var sql = "SELECT * FROM items WHERE userID=" + row[0].id;
      pool.query(sql, function (err, row2) {
        if (err) throw err;

        var ids = row2[0].assets;

        var flag = 0;
        for (var i = 0; i < assets.length; i++) {
          ids = ids.replace(assets[i], "");
          ids = ids.replace("//", "/");
        }

        if (ids[0] == "/") ids = ids.substring(1);

        if (ids[ids.length - 1] == "/") ids = ids.substring(0, ids.length - 1);

        if (ids == "") {
          var sql = "DELETE from items WHERE id='" + row2[0].id + "'";
          pool.query(sql, function (err, row3) {
            if (err) throw err;
            sendmyItems(socket, m.hash);
          });
        } else {
          var sql =
            "UPDATE items set assets='" +
            ids +
            "' WHERE id='" +
            row2[0].id +
            "'";
          pool.query(sql, function (err, row3) {
            if (err) throw err;
            sendmyItems(socket, m.hash);
          });
        }
      });
    });
  });

  socket.on("myItems", function (m) {
    sendmyItems(socket, m.hash);
  });

  socket.on("hash", function (m) {
    loadAllGames();
    var address =
      socket.client.request.headers["x-forwarded-for"] ||
      socket.request.connection.remoteAddress;
    addHistory(socket);

    if (!usersOnline[address]) {
      usersOnline[address] = 1;
    }

    var limit = 5;

    pool.query(
      "SELECT email FROM users WHERE hash = " + pool.escape(m.hash),
      function (err, row) {
        if (err) throw err;

        if (row.length == 0) return;

        if (row.length > 0) {
          if (socketBySteam.hasOwnProperty(row[0].email)) {
            delete socketBySteam[row[0].email];
            socketBySteam[row[0].email] = {
              info: socket.id,
            };
          } else {
            socketBySteam[row[0].email] = {
              info: socket.id,
            };
          }
        }
      }
    );

    loadStatistics(socket);

    io.sockets.emit("message", {
      type: "connections",
      total: Object.keys(usersOnline).length,
    });

    loadGames.forEach(function (itm) {
      var temp = itm.cskinsusernames;
      while (temp.indexOf("★") != -1) {
        temp = temp.replace("★", "##");
      }
      while (temp.indexOf("™") != -1) {
        temp = temp.replace("™", "#$");
      }

      socket.emit("message", {
        type: "addGame",
        games: {
          id: itm.id,
          cemail: itm.cemail,
          cname: itm.cusername,
          cavatar: itm.cavatar,
          cskinsurl: itm.cskinsurl,
          cskinsnames: temp,
          cskinsprices: itm.cskinsprices,
          cskins: itm.cskins,
          ctp: itm.ctp,
          pemail: itm.pemail,
          pname: itm.pusername,
          assets: itm.assets,
          pavatar: itm.pavatar,
          pskinsurl: itm.pskinsurl,
          pskinsnames: temp,
          pskinsprices: itm.pskinsprices,
          pskins: itm.cskins,
          ptp: itm.ctp,
          hash: itm.hash,
          secret: itm.secret,
          winner: itm.winner,
          timer: timerGame[itm.id] - time(),
          timer11: itm.timer11,
          scode: itm.scode,
          ttimer11: timer11Game[itm.id] - time(),
        },
      });
    });
  });

  //CHAT FUNCTIONS
  socket.on("nMsg", function (m) {
    var mesaj = m.message;
    var utilizator = m.user;
    var hide = m.hide;
    var address =
      socket.client.request.headers["x-forwarded-for"] ||
      socket.request.connection.remoteAddress;

    pool.query(
      "SELECT `username`,`avatar`,`email`,`rank`,`mute`,`level` FROM `users` WHERE `hash` = " +
        pool.escape(utilizator),
      function (err, res) {
        if (err) throw err;
        var row = res;

        if (!res[0]) return err;

        if (mesaj.length > 128 || (mesaj.length < 6 && res[0].rank != 69)) {
          return;
        } else {
          if (antiSpamChat[res[0].email] + 2 >= time() && res[0].rank != 69) {
            return;
          } else {
            antiSpamChat[res[0].email] = time();
          }

          var caca = null;
          if ((caca = /^\/clear/.exec(mesaj))) {
            if (row[0].rank == 69 || row[0].rank == 92) {
              io.sockets.emit("message", {
                type: "addMessage",
                tip: "clear",
                username: "",
                rank: "",
                avatar: "",
                hide: true,
                msg: "",
              });
              chatMessages = [];
              //logger.trace('Chat: Cleared by Admin ' + row[0].username + '.');
            }
          } else if ((caca = /^\/mute ([0-9]*) ([0-9]*)/.exec(mesaj))) {
            if (row[0].rank == 69 || row[0].rank == 92) {
              var t = time();
              pool.query(
                "UPDATE `users` SET `mute` = " +
                  pool.escape(parseInt(t) + parseInt(caca[2])) +
                  " WHERE `email` = " +
                  pool.escape(caca[1]),
                function (err2, row2) {
                  if (err2) throw err2;
                  if (row2.affectedRows == 0) {
                    //logger.trace('Mute: email not found in database (' + caca[1] + ').');
                    return;
                  }
                  //logger.trace('Mute: email ' + caca[1] + ' has been muted for ' + caca[2] + ' seconds by ' + row[0].username + ' (' + row[0].email + ').');
                }
              );
            }
          } else {
            if (row[0].mute > time() && row[0].mute != 0) {
              //logger.trace('Mute: ' + row[0].username + ' (' + row[0].email + ') tried to speak (' + mesaj + ') while muted (seconds remaining: ' + parseInt(row[0].mute - time()) + ').');
              return;
            }

            if (chatMessages.length > 20) {
              chatMessages.shift();
            }

            chatMessages.push({
              username: res[0].username,
              avatar: res[0].avatar,
              email: res[0].email,
              rank: res[0].rank,
              hide: hide,
              level: res[0].level,
              message: mesaj,
            });

            io.sockets.emit("message", {
              type: "addMessage",
              msg: mesaj,
              avatar: res[0].avatar,
              email: res[0].email,
              rank: res[0].rank,
              hide: hide,
              level: res[0].level,
              username: res[0].username,
            });
            //logger.trace('Chat: Message from ' + row[0].username + ' (SID: ' + row[0].email + ', IP: ' + address + ', hide: ' + hide + ') --> ' + mesaj);
          }
        }
      }
    );
  });

  socket.on("wantInv2", function (m) {
    if (m.hash) {
      pool.query(
        "SELECT * FROM users WHERE hash = " + pool.escape(m.hash),
        function (err, row) {
          if (err) throw err;

          if (row.length == 0) return;

          if (row.length > 0) {
            if (
              inventorySite["items"] != null &&
              inventorySite["items"] != undefined
            ) {
              var name_page = [];
              var price_page = [];
              var img_page = [];

              var inventory = inventorySite["items"];

              var max = m.page * 50;
              var min = m.page * 50 - 50;

              var name = inventory["name"].split(",");
              var price = inventory["price"].split(",");
              var img = inventory["img"].split(",");
              var Items = [];
              for (var i = 0; i < name.length; i++) {
                //Items[i] = [];
                if (price[i])
                  Items.push({
                    id: i,
                    name: name[i],
                    price: price[i],
                    image: img[i],
                  });
              }

              var temp;
              if (m.name)
                temp = Items.filter(
                  (item) => item["name"].indexOf(m.name) >= 0
                );
              else {
                temp = Items;
              }

              var prices = m.prices.split("/");

              for (var i = 0; i < prices.length; i++) {
                if (prices[i] == "false") {
                  temp = temp.filter(function (item) {
                    if (
                      item["price"] >= first_price[i] &&
                      item["price"] <= second_price[i]
                    )
                      return false;
                    else return true;
                  });
                }
              }

              var ids = [];

              for (var i = min; i < max; i++) {
                if (temp.length <= i) break;
                var temp_name = temp[i]["name"];
                while (temp.indexOf("★") != -1) {
                  temp = temp.replace("★", "##");
                }
                while (temp.indexOf("™") != -1) {
                  temp = temp.replace("™", "#$");
                }
                name_page.push(temp_name);
                price_page.push(temp[i]["price"]);
                img_page.push(temp[i]["image"]);
                ids.push(temp[i]["id"]);
              }

              socket.emit("message", {
                type: "getInventory2",
                name: name_page,
                price: price_page,
                id: ids,
                img: img_page,
                balance: row[0].balance,
              });

              socket.emit("message", {
                type: "msg",
                tip: "Inv2",
              });
            }
          }
        }
      );
    }
  });

  socket.on("wantInv", function (m) {
    if (m.hash) {
      pool.query(
        "SELECT * FROM users WHERE hash = " + pool.escape(m.hash),
        function (err, row) {
          if (err) throw err;

          if (row.length == 0) return;

          if (row.length > 0) {
            if (
              inventorySite["items"] != null &&
              inventorySite["items"] != undefined
            ) {
              var name_page = [];
              var price_page = [];
              var img_page = [];
              var ids = [];
              var inventory = inventorySite["items"];

              var max = m.page * 50;
              var min = m.page * 50 - 50;

              for (var i = min; i < max; i++) {
                name_page.push(inventory["name"][i]);
                price_page.push(inventory["price"][i]);
                img_page.push(inventory["img"][i]);
                ids.push(i);
              }

              socket.emit("message", {
                type: "getInventory",
                name: name_page,
                price: price_page,
                img: img_page,
                id: ids,
              });

              socket.emit("message", {
                type: "msg",
                tip: "Inv2",
              });
            }
          }
        }
      );
    }
  });

  socket.on("disconnect", function (m) {
    var address =
      socket.client.request.headers["x-forwarded-for"] ||
      socket.request.connection.remoteAddress;
    if (usersOnline[address]) {
      delete usersOnline[address];
    }
    io.sockets.emit("message", {
      type: "connections",
      total: Object.keys(usersOnline).length,
    });
  });

  socket.on("newGame", function (m) {
    if (m.hash) {
      var assets = m.assets.split("/");

      pool.query(
        "SELECT * FROM users WHERE hash = " + pool.escape(m.hash),
        function (err, row) {
          if (err) throw err;

          if (row.length == 0) return;

          var cemail = row[0].email;
          var cname = row[0].username;
          var cavatar = row[0].avatar;

          var inventory = inventorySite["items"];
          var names = inventory["name"].split(",");
          var prices = inventory["price"].split(",");
          var images = inventory["img"].split(",");

          var name_page = [];
          var price_page = [];
          var img_page = [];

          var total_price = m.total;
          for (var i = 0; i < assets.length; i++) {
            name_page.push(names[assets[i]]);
            price_page.push(prices[assets[i]]);
            img_page.push(images[assets[i]]);
          }

          var sql =
            "INSERT INTO games (cemail, cname,cavatar,cskinsurl,cskinsnames,cskinsprices,hash,cskins,ctp,cassetids,scode) VALUES ('" +
            cemail +
            "','" +
            cname +
            "','" +
            cavatar +
            "','" +
            img_page.join("/@") +
            "','" +
            name_page.join("/") +
            "','" +
            price_page.join("/") +
            "','" +
            row[0]["hash"] +
            "','" +
            assets.length +
            "','" +
            total_price +
            "','" +
            m.assets +
            "','" +
            m.coin +
            "')";
          pool.query(sql, function (err, result) {
            if (err) throw err;

            var total = total_price * 1.06;
            total = total.toFixed(2);
            var balance = parseFloat(row[0].balance) - total;
            balance = balance.toFixed(2);
            pool.query(
              'UPDATE users set balance="' +
                balance +
                '" WHERE id =' +
                row[0].id,
              function (err, row) {
                if (err) throw err;

                var temp = name_page.join("/");
                while (temp.indexOf("★") != -1) {
                  temp = temp.replace("★", "##");
                }
                while (temp.indexOf("™") != -1) {
                  temp = temp.replace("™", "#$");
                }

                io.sockets.emit("message", {
                  type: "addGame",
                  games: {
                    id: result.insertId,
                    cemail: cemail,
                    cname: cname,
                    cavatar: cavatar,
                    cskinsurl: img_page.join("/@"),
                    cskinsnames: temp,
                    cskinsprices: price_page.join("/"),
                    cskins: assets.length,
                    ctp: total_price,
                    pemail: "",
                    pname: "",
                    assets: m.assets,
                    pavatar: "",
                    pskinsurl: "",
                    pskinsnames: "",
                    pskinsprices: "",
                    pskins: "",
                    ptp: "",
                    hash: "",
                    secret: "",
                    winner: -1,
                    scode: m.coin,
                    timer: 0,
                    timer11: 0,
                    ttimer11: 0,
                  },
                });

                socket.emit("newSuccess", {
                  id: result.insertId,
                  balance: balance,
                });
              }
            );
          });
        }
      );
    }
  });

  socket.on("watchGame", function (m) {
    if (m.left != 10) {
      var sql = "UPDATE games set timer11=" + m.left + " where id =" + m.gameid;
      pool.query(sql, function (err, row) {
        if (err) throw err;
        sendGames(m.gameid, m.flag);
      });
    } else {
      sendGames(m.gameid, m.flag);
    }
  });

  socket.on("getGame", function (m) {
    if (m.hash) {
      pool.query(
        "SELECT * FROM users WHERE hash = " + pool.escape(m.hash),
        function (err, row1) {
          if (err) throw err;

          if (row1.length == 0) return;

          pool.query(
            "SELECT * FROM games WHERE id = " + pool.escape(m.gameID),
            function (err, row) {
              if (err) throw err;

              if (row.length == 0) return;
              var sql =
                "UPDATE games set timer11=10 where id='" + m.gameID + "'";
              socket.emit("message", {
                type: "getGame",
                games: {
                  cskinsurl: row[0].cskinsurl,
                  cskinsnames: row[0].cskinsnames,
                  cskinsprices: row[0].cskinsprices,
                  cskins: row[0].cskins,
                  balance: row1[0].balance,
                  ctp: row[0].ctp,
                  scode: row[0].scode,
                },
              });
              sendGames(m.gameID);
            }
          );
        }
      );
    }
  });
  socket.on("getWinner", function (m) {
    var winner;

    var random = require("node-random");

    // Get 2 random numbers between 1 and 6

    random.numbers(
      {
        number: 1,
        minimum: 1,
        maximum: 100,
      },
      function (error, data) {
        if (error) throw error;

        if (data <= 50) winner = 1;
        else winner = 2;

        var flag;
        var hash;
        var assets;
        var scode;

        pool.query(
          "SELECT * FROM games WHERE id =" + pool.escape(m.id),
          function (err, row) {
            if (err) throw err;
            if (row.length == 0) {
              return;
            }

            scode = parseInt(row[0].scode);
            assets = row[0].cassetids;

            var CryptoJS = require("crypto-js");
            if (row[0].ended != 1) {
              var cryptedCode = CryptoJS.AES.encrypt(
                winner.toString(),
                row[0].hash.concat(row[0].secret)
              ).toString();
              var sql =
                "UPDATE games set winner =" +
                winner +
                ", wcode=" +
                data +
                ",cryptedData='" +
                cryptedCode +
                "' ,ended=1,timer11=10 where id=" +
                m.id;
              pool.query(sql, function (err, row1) {
                if (err) throw err;
              });
            } else winner = parseInt(row[0].winner);

            var email = row[0].cemail;

            if (winner == 2) email = row[0].pemail;
            pool.query(
              "SELECT * FROM users WHERE email =" + pool.escape(email),
              function (err, row2) {
                if (err) throw err;

                if (row2.length == 0) return;
                var balance = row2[0].balance;

                balance = parseFloat(m.price) + balance;

                if (winner == 1) {
                  if (scode == 1) winner = 1;
                  else winner = 2;
                } else {
                  if (scode == 1) winner = 2;
                  else winner = 1;
                }

                if (row[0].ended != 1) {
                  pool.query(
                    "SELECT * FROM items WHERE userID =" +
                      pool.escape(row2[0].id),
                    function (err, row5) {
                      if (err) throw err;

                      if (row5.length == 0)
                        query =
                          "INSERT INTO items (userID,assets) VALUES ('" +
                          row2[0].id +
                          "','" +
                          assets +
                          "/" +
                          assets +
                          "')";
                      else {
                        assets = row5[0].assets + "/" + assets + "/" + assets;
                        query =
                          "UPDATE items set assets ='" +
                          assets +
                          "' where userID=" +
                          row2[0].id;
                      }
                      pool.query(query, function () {
                        socket.emit("getWinner", {
                          winner: winner,
                          hash: row2[0].hash,
                          id: m.id,
                        });
                      });
                    }
                  );
                } else
                  socket.emit("getWinner", {
                    winner: winner,
                    hash: row2[0].hash,
                    id: m.id,
                  });

                if (loadGames.length < 50)
                  setTimeout(
                    function (id) {
                      socket.emit("killGame", { id: id });
                    },
                    120000,
                    m.id
                  );
                else
                  setTimeout(
                    function (id) {
                      socket.emit("killGame", { id: id });
                    },
                    60000,
                    m.id
                  );
              }
            );
          }
        );
      }
    );
  });

  socket.on("joingame", function (m) {
    if (m.hash) {
      pool.query(
        "SELECT * FROM users WHERE hash = " + pool.escape(m.hash),
        function (err, row) {
          if (err) throw err;

          if (row.length == 0) return;

          var pemail = row[0].email;
          var pname = row[0].username;
          var pavatar = row[0].avatar;
          var randomstring = require("randomstring");
          var secret = randomstring.generate();

          var today = new Date();
          var sql =
            "UPDATE games set pemail='" +
            row[0].email +
            "',pname='" +
            row[0].username +
            "',pavatar='" +
            row[0].avatar +
            "',join_time='" +
            today +
            "',secret='" +
            secret +
            "',timer11=10 where id='" +
            m.gameID +
            "'";
          pool.query(sql, function (err, result) {
            if (err) throw err;
          });

          var balance = row[0].balance - m.price;
          pool.query(
            'UPDATE users set balance="' +
              balance +
              '" WHERE id = ' +
              row[0].id,
            function (err, row) {
              socket.emit("joinSuccess", {
                id: m.gameID,
                balance: balance,
              });
            }
          );
        }
      );
    }
  });
});

function getInv(sort) {
  var res = require("./items.json");
  var items = res["items"];

  var namess = [];
  var pricess = [];
  var imgss = [];

  var Names = "";
  var Prices = "";
  var Imgs = "";

  for (var i in items) {
    var item = items[i];
    var name = item["market_hash_name"];
    if (PriceOfItem(name) != false && PriceOfItem(name) != undefined) {
      var price = PriceOfItem(name);
      var img = item["icon_url"];
      if (price >= minDep) {
        if (price >= 0.5) {
          namess.push(name);
          pricess.push(price);
          imgss.push(img);
        }
      }
    }
  }

  Names = namess.join(",");
  Prices = pricess.join(",");
  Imgs = imgss.join(",");

  inventorySite["items"] = {
    name: Names,
    price: Prices,
    img: Imgs,
  };
}

function getTest() {
  var res = require("./items.json");
  var items = res["items"];

  var counter = 0;

  var idss = [];
  var namess = [];
  var pricess = [];
  var imgss = [];

  var Ids = "";
  var Names = "";
  var Prices = "";
  var Imgs = "";

  items.forEach(function (item) {});
}

/*
  Getting prices
*/
var priceUrl =
  "https://api.csgo.steamlytics.xyz/v2/pricelist?key=bfdf7773e73defb5965b739a9d3c909c";

function getPriceList() {
  request(priceUrl, function (error, response, body) {
    if (!error) {
      var res = JSON.parse(body);
      if (res.success == true) {
        fs.writeFileSync("/var/www/bot/BOT/prices.json", body);
        fs.writeFileSync("/var/www/html/prices.json", body);
        console.log("[SERVER] Loading Prices - API prices loaded!");
      } else {
        console.log(response.success);
        console.log("Error on get prices");
      }
    } else {
      console.log(error);
    }
  });
}

/*
  Getting items
*/

var itemsUrl =
  "http://api.csgo.steamlytics.xyz/v1/items?key=bfdf7773e73defb5965b739a9d3c909c";

function getItemsList() {
  request(itemsUrl, function (error, response, body) {
    if (!error) {
      var res = JSON.parse(body);
      if (res.success == true) {
        fs.writeFileSync("/var/www/bot/BOT/items.json", body);
        fs.writeFileSync("/var/www/html/items.json", body);
        console.log("[SERVER] Loading Prices - API items loaded!");
        getPriceList();
      } else {
        console.log(response.success);
        console.log("Error on get items");
      }
    } else {
      console.log(error);
    }
  });
}

function PriceOfItem(name) {
  var prices = require("./prices.json");
  if (prices["items"][name] != undefined || prices["items"][name] != null) {
    var priceItem = 0;
    priceItem = prices["items"][name]["safe_price"];
    return priceItem;
  } else {
    return false;
  }
}

getTest();

/*
  Offer handling
*/
function isInArray(value, array) {
  return array.indexOf(value) > -1;
}

function time() {
  return parseInt(new Date().getTime() / 1000);
}

function addHistory(socket) {
  chatMessages.forEach(function (itm) {
    socket.emit("message", {
      type: "addMessage",
      msg: itm.message,
      avatar: itm.avatar,
      email: itm.email,
      rank: itm.rank,
      hide: itm.hide,
      level: itm.level,
      username: itm.username,
    });
  });
}

function makeCode() {
  var text = "";
  var possible =
    "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

  for (var i = 0; i < 6; i++)
    text += possible.charAt(Math.floor(Math.random() * possible.length));

  return text;
}

function getProxy() {
  return "http://" + proxies[random(0, proxies.length - 1)];
}

function random(min, max) {
  return Math.floor(Math.random() * (max - min + 1)) + min;
}

function loadStatistics(socket) {
  var totalAmount = 0;
  var totalItems = 0;
  var activeGames = 0;

  pool.query(
    "SELECT SUM(`ctp`) AS `totalAmount`, SUM(`cskins`) AS `totalItems`, COUNT(`id`) AS `activeGames` FROM games WHERE `winner` = -1",
    function (error, res) {
      if (error) throw error;

      if (res.length == 0) {
        totalAmount = 0;
        totalItems = 0;
        activeGames = 0;

        if (!socket) {
          io.sockets.emit("message", {
            type: "loadStatistics",
            totalAmount: totalAmount,
            totalItems: totalItems,
            activeGames: activeGames,
          });
        } else {
          socket.emit("message", {
            type: "loadStatistics",
            totalAmount: totalAmount,
            totalItems: totalItems,
            activeGames: activeGames,
          });
        }
      }

      if (res.length > 0) {
        totalAmount = res[0].totalAmount;
        totalItems = res[0].totalItems;
        activeGames = res[0].activeGames;

        if (totalAmount == null) {
          totalAmount = 0;
        }
        if (totalItems == null) {
          totalItems = 0;
        }
        if (activeGames == null) {
          activeGames = 0;
        }

        if (!socket) {
          io.sockets.emit("message", {
            type: "loadStatistics",
            totalAmount: totalAmount,
            totalItems: totalItems,
            activeGames: activeGames,
          });
        } else {
          socket.emit("message", {
            type: "loadStatistics",
            totalAmount: totalAmount,
            totalItems: totalItems,
            activeGames: activeGames,
          });
        }
      }
    }
  );
}

function sendGames(gameID, flag = 0) {
  loadAllGames();

  setTimeout(function () {
    if (flag == 0) {
      for (var i in loadGames) {
        if (loadGames[i].id == gameID) {
          timerGame[loadGames[i].id] = time() + 90;
          var temp = loadGames[i].cskinsusernames;
          while (temp.indexOf("★") != -1) {
            temp = temp.replace("★", "##");
          }
          while (temp.indexOf("™") != -1) {
            temp = temp.replace("™", "#$");
          }

          io.sockets.emit("message", {
            type: "editGame",
            games: {
              id: loadGames[i].id,
              cemail: loadGames[i].cemail,
              cname: loadGames[i].cusername,
              cavatar: loadGames[i].cavatar,
              cskinsurl: loadGames[i].cskinsurl,
              cskinsnames: temp,
              cskinsprices: loadGames[i].cskinsprices,
              cskins: loadGames[i].cskins,
              ctp: loadGames[i].ctp,
              pemail: loadGames[i].pemail,
              pname: loadGames[i].pusername,
              pavatar: loadGames[i].pavatar,
              pskinsurl: loadGames[i].cskinsurl,
              pskinsnames: temp,
              pskinsprices: loadGames[i].cskinsprices,
              pskins: loadGames[i].cskins,
              ptp: loadGames[i].ctp,
              hash: loadGames[i].hash,
              secret: loadGames[i].secret,
              scode: loadGames[i].scode,
              winner: loadGames[i].winner,
              timer: timerGame[loadGames[i].id] - time(),
              timer11: loadGames[i].timer11,
              ttimer11: timer11Game[loadGames[i].id] - time(),
            },
          });

          io.sockets.emit("message", {
            type: "watchCF",
            id: loadGames[i].id,
            cemail: loadGames[i].cemail,
            cname: loadGames[i].cusername,
            cavatar: loadGames[i].cavatar,
            cskinsurl: loadGames[i].cskinsurl,
            cskinsnames: temp,
            cskinsprices: loadGames[i].cskinsprices,
            cskins: loadGames[i].cskins,
            ctp: loadGames[i].ctp,
            pemail: loadGames[i].pemail,
            pname: loadGames[i].pusername,
            pavatar: loadGames[i].pavatar,
            pskinsurl: loadGames[i].cskinsurl,
            pskinsnames: temp,
            pskinsprices: loadGames[i].cskinsprices,
            pskins: loadGames[i].cskins,
            ptp: loadGames[i].ctp,
            hash: loadGames[i].hash,
            secret: loadGames[i].secret,
            winner: loadGames[i].winner,
            scode: loadGames[i].scode,
            timer: timerGame[loadGames[i].id] - time(),
            timer11: loadGames[i].timer11,
            ttimer11: timer11Game[loadGames[i].id] - time(),
            gameNumber: loadGames[i].id,
          });
        }
      }
    } else {
      pool.query("SELECT * FROM games WHERE id=" + gameID, function (err, res) {
        if (err) throw err;

        var temp = res[0].cskinsnames;
        while (temp.indexOf("★") != -1) {
          temp = temp.replace("★", "##");
        }
        while (temp.indexOf("™") != -1) {
          temp = temp.replace("™", "#$");
        }

        if (res[0]["pemail"] && res[0]["winner"] == -1) {
          io.sockets.emit("message", {
            type: "editGame",
            games: {
              id: res[0].id,
              cemail: res[0].cemail,
              cname: res[0].cname,
              cavatar: res[0].cavatar,
              cskinsurl: res[0].cskinsurl,
              cskinsnames: temp,
              cskinsprices: res[0].cskinsprices,
              cskins: res[0].cskins,
              ctp: res[0].ctp,
              pemail: res[0].pemail,
              pname: res[0].pname,
              pavatar: res[0].pavatar,
              pskinsurl: res[0].cskinsurl,
              pskinsnames: temp,
              pskinsprices: res[0].cskinsprices,
              pskins: res[0].cskins,
              ptp: res[0].ctp,
              hash: res[0].hash,
              secret: res[0].secret,
              scode: res[0].scode,
              winner: res[0].winner,
              timer: timerGame[res[0].id] - time(),
              timer11: res[0].timer11,
              ttimer11: timer11Game[res[0].id] - time(),
            },
          });
        }
        var temp1 = res[0].pskinsnames;
        io.sockets.emit("message", {
          type: "watchCF",
          id: res[0].id,
          cemail: res[0].cemail,
          cname: res[0].cname,
          cavatar: res[0].cavatar,
          cskinsurl: res[0].cskinsurl,
          cskinsnames: temp,
          cskinsprices: res[0].cskinsprices,
          cskins: res[0].cskins,
          ctp: res[0].ctp,
          pemail: res[0].pemail,
          pname: res[0].pname,
          pavatar: res[0].pavatar,
          pskinsurl: res[0].cskinsurl,
          pskinsnames: temp,
          pskinsprices: res[0].cskinsprices,
          pskins: res[0].cskins,
          ptp: res[0].ctp,
          hash: res[0].hash,
          secret: res[0].secret,
          winner: res[0].winner,
          scode: res[0].scode,
          timer: timerGame[res[0].id] - time(),
          timer11: res[0].timer11,
          ttimer11: timer11Game[res[0].id] - time(),
          gameNumber: res[0].id,
          flag: 1,
        });
      });
    }
  }, 1000);
}

function LevelCalculate(user) {
  pool.query(
    "SELECT xp,level FROM users WHERE email = " + pool.escape(user),
    function (err, row) {
      if (err) throw err;
      if (row.length == 0) return;

      var currentLevel = row[0].level;

      var currentXp = row[0].xp;
      var xpNeeded = 0;
      var xpMinus = 0;

      for (var i = 1; i < 500; i++) {
        xpNeeded += 40 * i;
        xpMinus = xpNeeded - (40 * i - 1);
        if (currentXp >= xpMinus && currentXp <= xpNeeded) {
          pool.query(
            "UPDATE users SET level = " +
              pool.escape(i) +
              " WHERE email = " +
              pool.escape(user)
          );
        }
      }
    }
  );
}

function getRandomFloat(min, max) {
  return (Math.random() * (max - min) + min).toFixed(10);
}

function handleDisconnect() {
  pool = mysql.createConnection(db_config);

  pool.connect(function (err) {
    if (err) {
      logger.trace("Error: Connecting to database: ", err);
      setTimeout(handleDisconnect, 2000);
    }
  });

  pool.on("error", function (err) {
    logger.trace("Error: Database error: ", err);
    if (err.code === "PROTOCOL_CONNECTION_LOST") {
      handleDisconnect();
    } else {
      throw err;
    }
  });
}
