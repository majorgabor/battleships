$(document).ready(function(){

    $("#myShips").html(table.cloneNode(true));
    $("#myBattlefield").html(table.cloneNode(true));
    
    // to battlerequest
    $("#acceptBattleModal").modal({
        backdrop: "static",
        keyboard: false
    });
    $("#requesrWaiting").hide();
    $("#enemyDiscarded").hide();
    $("#youDiscarded").hide();
    $("#placeShipsAlert").hide();
    $("#fireMissileAlert").hide();
    $("#fireMissleButtons").hide();
    mainCounter(10, "battleRequestCounter");
    $("#accept").on("click", function(){
        $("#requesrWaiting").show();
        sendMessage("BATTLEREQUEST", "ACCEPT");
    });
    $("#discard").on("click", function(){
        $("#youDiscarded").show();
        sendMessage("BATTLEREQUEST", "DISCARD");
    });
    $("#requestButtons").on("click", function(){
        // clearInterval(battleRequestCounter);
        clearInterval(counter);
        $("#discard").prop("disabled", true);
        $("#accept").prop("disabled", true);
        $("#requesrCounter").hide();
    });
    
    // to place ships
    $("#ready").hide();
    $("#placeShipsAlert").show();    
    $("#myShips").find("td").on("click", function(){
        if(placeinfShipId > 0) {
            var x = parseInt(this.dataset.x);
            var y = parseInt(this.dataset.y);
            if(isPlacebal(x, y, "horisontal", shipSize[placeinfShipId])){
                markShip(x, y, "horisontal", shipSize[placeinfShipId], placeinfShipId);
                placeinfShipId--;
            }
            if(placeinfShipId === 0){
                $("#ready").show();    
            }
        }
    }).on("contextmenu", function(){
        if(placeinfShipId > 0) {
            var x = parseInt(this.dataset.x);
            var y = parseInt(this.dataset.y);
            if(isPlacebal(x, y, "vertical", shipSize[placeinfShipId])){
                markShip(x, y, "vertical", shipSize[placeinfShipId], placeinfShipId);
                placeinfShipId--;
            }
            if(placeinfShipId === 0){
                $("#ready").show();  
            }
        }
    });
    $("#reset").on("click", function(){
        $("#ready").hide();
        placeinfShipId = 7;
        for(i = 0; i < 10; i++){
            for(j = 0; j < 10; j++){
                shipArray[i][j] = undefined;
                $("#myShips").find("td[data-x="+ i +"][data-y="+ j +"]").css("background","inherit");   
            }
        }
    });
    $("#random").on("click", function(){
        $("#reset").trigger("click");
        var orientation;
        var x, y;
        while(placeinfShipId > 0){
            if(Math.random() >= 0.5){
                orientation = "horisontal";
            } else {
                orientation = "vertical";
            }
            x = Math.floor(Math.random() * 10);
            y = Math.floor(Math.random() * 10);
            if(isPlacebal(x, y, orientation, shipSize[placeinfShipId])){
                markShip(x, y, orientation, shipSize[placeinfShipId], placeinfShipId);
                placeinfShipId--;
            }
        }
        $("#ready").show();        
    });
    $("#ready").on("click", function(){
        $("#placeShipsButtons").hide();
        $("#placeShipsAlert").hide();
        clearInterval(counter);
        sendMessage("PLACEDSHIPS", shipArray);
        $("#gamingModal").modal({
            backdrop: "static",
            keyboard: false
        });
        $("#gamingModalText").html("<p>Waiting for the enemy to place the ships.</p>");
        
    });

    // to fire missile
    var firedMissile;
    $("#myBattlefield").find("td").on("click", function(){
        firedMissile = {
            x: parseInt(this.dataset.x),
            y: parseInt(this.dataset.y),
        };
        $("#fireMissleButtons").show();
    });
    $("#fireMissile").on("click", function(){
        sendMessage("MISSILE_FIRED", firedMissile);
        clearInterval(counter);        
        $("#fireMissileAlert").hide();
        $("#fireMissleButtons").hide();
    });

    $(".exitGame").on("click", function() {
        sendMessage("GAME_END", "EXIT");
    });
});

const username = window.location.pathname.split("/").slice(-2)[0];
const enemy = window.location.pathname.split("/").slice(-2)[1];
var counter;

var shipArray = [];

// var myShips = document.getElementById("myShips");
// var myBattlefield = document.getElementById("myBattlefield");

var table = document.createElement("table");
for(i = 0; i < 10; i++){
    var tr = document.createElement("tr");
    shipArray[i] = [];
    for(j = 0; j < 10; j++){
        var td = document.createElement("td");
        td.setAttribute("data-x", j);
        td.setAttribute("data-y", i);
        tr.appendChild(td);
        shipArray[i][j] = undefined;
    }
    table.appendChild(tr);
}
// myShips.appendChild(table);
// myBattlefield.appendChild(table);

const shipSize = [null, 1, 1, 2, 2, 3, 4, 5];
var placeinfShipId = 7;

//game engine web socket
const webSock = new WebSocket("ws://localhost:7070");

webSock.onopen = function() {
    sendMessage("INIT", null);
}

webSock.onmessage = function(event) {
    message = JSON.parse(event.data);
    console.log(message);
    switch(message.type) {
        case "ENEMY_LEFT":
            console.log("enemy left", message.data);
            webSock.close();
            break;

        case "BATTLEREQUEST":
            console.log(message.data);
            if(message.data === "DISCARD") {
                $("#requesrWaiting").hide();
                $("#enemyDiscarded").show(); 
                $("#requestButtons").trigger("click");       
                webSock.close();
            } else if(message.data === "ACCEPT") {
                $("#acceptBattleModal").modal("hide");
                mainCounter(20, "placeShipsCounter");
            }
            break;

        case "YOU_TURN":
            if(message.data) {
                switch(message.data.result) {
                    case "MISSED":
                        $("#gamingModalText").html(
                            "<p>The enemy missile is <b>missed</b> on x: "+message.data.x+" y: "+message.data.y+".</p>"+
                            "<p>Ti's your turn.</p>"
                        );
                        break;
                    case "HIT":
                        $("#gamingModalText").html(
                            "<p>The enemy missile is <b>hit</b> the your ship on x: "+message.data.x+" y: "+message.data.y+".</p>"+
                            "<p>Ti's your turn.</p>"
                        );
                        break;
                    case "SANK":
                        $("#gamingModalText").html(
                            "<p>The enemy missile is <b>hit</b> and your ship <b>sank</b> on x: "+message.data.x+" y: "+message.data.y+".</p>"+
                            "<p>Ti's your turn.</p>"
                        );
                        break;
                    }        
            } else {
                $("#gamingModalText").html("<p>You are the first! Get ready!</p>");
            }
            setTimeout(function(){
                $("#gamingModal").modal("hide");
            }, 2000);
            // mainCounter(17, "fireMissileCounter");
            $("#fireMissileAlert").show();
            $("#fireMissleButtons").show();
            break;
        
        case "YOU_WAIT":
            if(message.data) {
                switch(message.data.result) {
                    case "MISSED":
                        $("#gamingModalText").html(
                            "<p>Your missile is <b>missed</b> on x: "+message.data.x+" y: "+message.data.y+".</p>"+
                            "<p>Your enemy turn.</p>"
                        );
                        break;
                    case "HIT":
                        $("#gamingModalText").html(
                            "<p>Your missile is <b>hit</b> the enemy ship on x: "+message.data.x+" y: "+message.data.y+".</p>"+
                            "<p>Your enemy turn.</p>"
                        );
                        break;
                    case "SANK":
                        $("#gamingModalText").html(
                            "<p>Your missile is <b>hit</b> and the enemy ship <b>sank</b> on x: "+message.data.x+" y: "+message.data.y+".</p>"+
                            "<p>Your enemy turn.</p>"
                        );
                        break;
                    }
            } else {
                $("#gamingModalText").html("<p>Your enemy turn.</p>");
            }
            $("#gamingModal").modal({
                backdrop: "static",
                keyboard: false
            });
            break;
    }
}

webSock.onclose = function() {
    console.log("Connection lost.");
    clearInterval(counter);    
    setTimeout(() => {
        window.location = "../../account/"+username;
    }, 2000);
}

webSock.onerror = function() {
    webSock.close();
}

function sendMessage(type, data){
    const message = {
        type: type,
        username: username,
        enemy: enemy,
        data: data,
    };
    webSock.send(JSON.stringify(message));
}

function mainCounter(totalTime, whereToPrint) {
    var timer = (function() {
        var x = totalTime;
        return function() {
          return x -= 1;  
        };
    })();
    counter = setInterval(function() {
        var timeLeft = timer();
        console.log(timeLeft);
        $("#"+whereToPrint).text(timeLeft);
        if(timeLeft === 0) {
            clearInterval(counter);
            sendMessage("GAME_END", "TIME_OUT");        
        }
    }, 1000);
}

function isPlacebal(x, y, orientation, length){
    if(orientation === "horisontal"){
        if(x > 10-length) return false;
        if(y > 0){
            for(i = 0; i < length; i++){
                if(shipArray[x+i][y-1]) return false;
            }    
        }
        if(x > 0){
            if(shipArray[x-1][y]) return false;            
        } 
        for(i = 0; i < length; i++){
            if(shipArray[x+i][y]) return false;
        }
        if(x+length < 9){
            if(shipArray[x+length][y]) return false;            
        } 
        if(y < 9){
            for(i = 0; i < length; i++){
                if(shipArray[x+i][y+1]) return false;
            }    
        }
    } else if(orientation === "vertical") {
        if(y > 10-length) return false;
        if(x > 0){
            for(i = 0; i < length; i++){
                if(shipArray[x-1][y+i]) return false;
            }    
        }
        if(y > 0){
            if(shipArray[x][y-1]) return false;            
        } 
        for(i = 0; i < length; i++){
            if(shipArray[x][y+i]) return false;
        }
        if(y+length < 9){
            if(shipArray[x][y+length]) return false;            
        } 
        if(x < 9){
            for(i = 0; i < length; i++){
                if(shipArray[x+1][y+i]) return false;
            }    
        }
    } else {
        return false;
    }
    return true;
}

function markShip(x, y, orientation, length, type){
    if(orientation === "horisontal"){
        for(i = 0; i < length; i++){
            shipArray[x+i][y] = type;
            $("#myShips").find("td[data-x="+ (x+i) +"][data-y="+ y +"]").css("background","#343a40");
        }
    } else if(orientation === "vertical"){
        for(i = 0; i < length; i++){
            shipArray[x][y+i] = type;            
            $("#myShips").find("td[data-x="+ x +"][data-y="+ (y+i) +"]").css("background","#343a40");
        }
    }
}

// $scope.battleRequest = function(answer) {
//     sendMessage("BATTLEREQUEST", {
//         answer: answer,
//     });
//     if(answer === "DISCARD") {
//         webSock.close();
//     }
// }

// $scope.battleRequestTimeout = function(){
//     $scope.battleRequestCounter--;
//     if($scope.battleRequestCounter > 0){
//         mytimeout = $timeout($scope.battleRequestTimeout,1000);
//     } else {
//         $scope.battleRequest("DISCARD");
//     }
// }
// var mytimeout = $timeout($scope.battleRequestTimeout,1000);


    

    // $scope.placeShipCounter = 20;
    // $scope.placeShipTimeout = function(){
    //     $scope.placeShipCounter--;
    //     if($scope.placeShipCounter > 0){
    //         mytimeout = $timeout($scope.placeShipTimeout,1000);
    //     } else {
    //         $scope.sendPlaceShipTimeout();
    //     }
    // } 

    

