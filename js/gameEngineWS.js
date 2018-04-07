$(document).ready(function(){
    
    $("#acceptBattleModal").modal({
        backdrop: "static",
        keyboard: false
    });
    $("#acceptBattleModal").modal("show");
    $("#requesrWaiting").hide();
    $("#enemyDiscarded").hide();
    $("#youDiscarded").hide();
    
    $("#accept").on("click", function(){
        $("#requesrWaiting").show();
        battleRequestAnswer = "ACCEPT";
        sendMessage("BATTLEREQUEST", "ACCEPT");
        if(enemyBattleRequestAnswer === "ACCEPT") {
            $("#acceptBattleModal").modal("hide");
        }
    });
    $("#discard").on("click", function(){
        $("#youDiscarded").show();
        sendMessage("BATTLEREQUEST", "DISCARD");
    });
    $("#requestButtons").on("click", function(){
        clearInterval(brt);
        $("#discard").prop("disabled", true);
        $("#accept").prop("disabled", true);
        $("#requesrCounter").hide();
    });
    
    // $("#ready").on("click", function(){
    //     $timeout.cancel($scope.placeShipTimeout);            
    // });
});

const username = window.location.pathname.split("/").slice(-2)[0];
const enemy = window.location.pathname.split("/").slice(-2)[1];

var battleRequestAnswer = "";
var enemyBattleRequestAnswer = "";

//game engine web socket
const webSock = new WebSocket("ws://localhost:7070");

webSock.onopen = function() {
    sendMessage("INIT", null);
}

webSock.onmessage = function(event) {
    message = JSON.parse(event.data);
    switch(message.type) {
        case "BATTLEREQUEST":
            console.log(message.data);
            if(message.data === "DISCARD") {
                $("#requesrWaiting").hide();
                $("#enemyDiscarded").show(); 
                $("#requestButtons").trigger("click");       
                webSock.close();
            } else if(message.data === "ACCEPT") {
                enemyBattleRequestAnswer = "ACCEPT";
                if(battleRequestAnswer === "ACCEPT") {
                    $("#acceptBattleModal").modal("hide");
                }
            }
            break;
    }
}

webSock.onclose = function() {
    console.log("Connection lost.");
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


var battleRequestCounter = (function() {
    var battleRequestTimer = 10;
    return function() {
      return battleRequestTimer -= 1;  
    };
})();

var brt = setInterval(function() {
    var counter = battleRequestCounter();
    console.log(counter);
    $("#battleRequestCounter").html(counter);
    if(counter === 0) {
        clearInterval(brt);
        sendMessage("BATTLEREQUEST", "DISCARD");        
    }
}, 1000);

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

    

