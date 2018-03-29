$(document).ready(function(){
    
    $(window).on("load",function(){
        $("#acceptBattleModal").modal("show");
    });
    
    $("#acceptBattleModal").modal({
        backdrop: "static",
        keyboard: false
    });

    $("#requesrWaiting").hide();
    $("#enemyDiscarded").hide();
    $("#youDiscarded").hide();
});

var app = angular.module("myApp", []);

app.controller("gameCtrl", function($scope, $http, $timeout){
    
    $scope.requestCounter = 10;
    $scope.requestTimeout = function(){
        $scope.requestCounter--;
        if($scope.requestCounter > 0){
            mytimeout = $timeout($scope.requestTimeout,1000);
        } else {
            $("#discard").trigger("click");            
        }
    }
    var mytimeout = $timeout($scope.requestTimeout,1000);

    $scope.placeShipCounter = 20;
    $scope.placeShipTimeout = function(){
        $scope.placeShipCounter--;
        if($scope.placeShipCounter > 0){
            mytimeout = $timeout($scope.placeShipTimeout,1000);
        } else {
            $scope.sendPlaceShipTimeout();
        }
    }   

    $scope.sendAnswerForRequest = function(){
        $http({
            method: "POST",
            url: "services/game_engine/accept_client.php",
            data: $scope.requestAnswer
        }).then(function(response){
            $timeout.cancel(mytimeout);           
            $("#requesrWaiting").hide();
            mytimeout = $timeout($scope.placeShipTimeout,1000);
            if($scope.requestAnswer === "accept" && response.data === "accept"){
                $("#acceptBattleModal").modal("hide");
            } else if($scope.requestAnswer === "discard"){
                window.location = "./account";
            } else if(response.data === "discard"){
                $("#enemyDiscarded").show();
                setTimeout(function() {window.location = "./account"; }, 1500);
            } else {
                console.log(response.data);
            }
        },function(response){
            console.log(response.status, response.statusText);
        });
    };

    $scope.sendPlaceShipTimeout = function(){
        $http({
            method: "POST",
            url: "services/game_engine/client.php",
            data: "PLACESHIP_TIMEOUT"
        }).then(function(response){
            setTimeout(function() {window.location = "./account"; }, 1500);
        }, function(response){
            console.log(response.status, response.statusText);
        });
    }

    $(document).ready(function(){
    
        $("#accept").on("click", function(){
            $scope.requestAnswer = "accept";
            $("#requesrWaiting").show();
            $scope.sendAnswerForRequest();
        });
        $("#discard").on("click", function(){
            $scope.requestAnswer = "discard";
            $("#youDiscarded").show(); 
            $scope.sendAnswerForRequest();
        });
        $("#requestButtons").on("click", function(){
            $timeout.cancel($scope.requestTimeout);
            $("#discard").prop("disabled", true);
            $("#accept").prop("disabled", true);
            $("#requesrCounter").hide();
        });
        $("#ready").on("click", function(){
            $timeout.cancel($scope.placeShipTimeout);            
        });
    });
});