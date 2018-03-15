
var app = angular.module("myApp", []);

app.controller("accountCtrl", function($scope, $http){
    // get info
    $scope.user = {};
    $scope.fresh = function(){
        $http({
            method: "POST",
            url: "../../services/accountinfo.php"
        }).then(function(response){
            $scope.user = response.data;
        }, function(response){
            console.log(response.status, response.statusText);
        });
    };
    $scope.fresh();

    //modify profile
    $scope.modify_errors = {};
    $scope.modify_message = {};

    $scope.modify_errors.hide = "d-none";
    $scope.modify_message.hide = "d-none";

    $scope.submitModify = function(){
        $http({
            method : "POST",
            url    : "../../services/modify.php",
            data   : $scope.modify
        }).then(function(response){
            $scope.modify_errors.hide = "d-none";
            if(response.data.success){
                $scope.modify_message = {
                    hide : "d-block",
                    type : "success",
                    text : response.data.message
                };
                $scope.fresh();
            } else {
                if(response.data.errors != undefined){
                    $scope.modify_errors = response.data.errors;
                }
                $scope.modify_message = {
                    hide : "d-block",
                    type : "danger",
                    text : response.data.message
                };
            }
            $scope.modify.password = undefined;
        }, function(response){
            console.log(response.status, response.statusText);
            $scope.modify.password = undefined;
        });
    };

    // change password

    $scope.changePassword_errors = {};
    $scope.changePassword_message = {};

    $scope.changePassword_errors.hide = "d-none";
    $scope.changePassword_message.hide = "d-none";

    $scope.submitPasswordChange = function(){
        $http({
            method : "POST",
            url    : "../../services/changepwd.php",
            data   : $scope.change_password
        }).then(function(response){
            $scope.changePassword_errors.hide = "d-none";
            if(response.data.success){
                $scope.changePassword_message = {
                    hide : "d-block",
                    type : "success",
                    text : response.data.message
                };
            } else {
                if(response.data.errors != undefined){
                    $scope.changePassword_errors = response.data.errors;
                    $scope.changePassword_errors.hide = "d-block";
                }
                $scope.changePassword_message = {
                    hide : "d-block",
                    type : "danger",
                    text : response.data.message
                };
            }
            $scope.change_password = undefined;
        }, function(response){
            console.log(response.status, response.statusText);
            $scope.change_password = undefined;
        });
    };
});