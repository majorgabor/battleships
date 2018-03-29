
var app = angular.module("myApp", []);

app.controller("signupCtrl", function($scope, $http){

    $scope.errors = {};
    $scope.message = {};

    $scope.errors.hide = "d-none";
    $scope.message.hide = "d-none";

    $scope.submitSingup = function(){
        $http({
            method : "POST",
            url    : "services/register.php",
            data   : $scope.user
        }).then(function(response){
            $scope.errors.hide = "d-none";
            if(response.data.success){
                $scope.message = {
                    hide : "d-block",
                    type : "success",
                    text : response.data.message
                };
                window.location="./login";
            } else {
                if(response.data.errors != undefined){
                    $scope.errors = response.data.errors;
                    $scope.errors.hide = "d-block";
                }
                $scope.message = {
                    hide : "d-block",
                    type : "danger",
                    text : response.data.message
                };
            }
            $scope.user.password = undefined;
            $scope.user.password2 = undefined;            
        }, function(response){
            console.log(response.status, response.statusText);
            $scope.user.password = undefined;
            $scope.user.password2 = undefined;
        });
    };
});