
var app = angular.module("myApp", []);

app.controller("gameCtrl", function($scope, $http, $timeout){
    
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
        $scope.battleRequest("ACCEPT");
        if(enemyBattleRequestAnswer === "ACCEPT") {
            $("#acceptBattleModal").modal("hide");
        }
    });
    $("#discard").on("click", function(){
        $("#youDiscarded").show();
        $scope.battleRequest("DISCARD");
    });
    $("#requestButtons").on("click", function(){
        $timeout.cancel(mytimeout);
        $("#discard").prop("disabled", true);
        $("#accept").prop("disabled", true);
        $("#requesrCounter").hide();
    });
    // $("#ready").on("click", function(){
    //     $timeout.cancel($scope.placeShipTimeout);            
    // });

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
        }, 1000);
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
    
    //declaration
    $scope.battleRequestCounter = 10;
    
    //angularjs functions
    $scope.battleRequest = function(answer) {
        sendMessage("BATTLEREQUEST", {
            answer: answer,
        });
        if(answer === "DISCARD") {
            webSock.close();
        }
    }
    
    $scope.battleRequestTimeout = function(){
        $scope.battleRequestCounter--;
        if($scope.battleRequestCounter > 0){
            mytimeout = $timeout($scope.battleRequestTimeout,1000);
        } else {
            $scope.battleRequest("DISCARD");
        }
    }
    var mytimeout = $timeout($scope.battleRequestTimeout,1000);

    // $scope.placeShipCounter = 20;
    // $scope.placeShipTimeout = function(){
    //     $scope.placeShipCounter--;
    //     if($scope.placeShipCounter > 0){
    //         mytimeout = $timeout($scope.placeShipTimeout,1000);
    //     } else {
    //         $scope.sendPlaceShipTimeout();
    //     }
    // } 

    


    $(document).ready(function(){
    
        
    });
});