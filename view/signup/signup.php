<!DOCTYPE html>
<?php

require_once 'services/methods.php';
remember();
if(isset($_SESSION["logged_in"])){
    redirect("./account");
}

?>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="view/signup/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
    <link href="open-iconic/font/css/open-iconic-bootstrap.css" rel="stylesheet">
    <title>Sign Up</title>
</head>
<body>
    <div ng-app="myApp" ng-controller="signupCtrl">
        <nav class="navbar navbar-expand-md bg-dark navbar-dark">
            <a class="navbar-brand" href="./">Battleships game</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="./login" >
                            <span class="oi oi-account-login" title="account login" aria-hidden="true"></span>
                        LogIn</a>
                    </li>
                </ul>
            </div>
        </nav>
<!-- The Form -->
        <div id="first_row" class="row">
            <div id="grid_style" class="offset-xl-3 col-xl-6 offset-lg-2 col-lg-8 offset-md-1 col-md-10 col-sm-12 col-12">
                <div class="jumbotron">
                    <h3>Sign Up</h3>
                    <br>
                    <form class="form-horizontal" ng-submit="submitSingup()">
                        <div class="form-group row">
                            <label class="control-label col-sm-3" for="firstname">Firstname:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" ng-model="user.firstname" id="firstname" placeholder="Enter firstname" name="firstname">
                            </div>
                            <label id="error" class="control-label col-sm-9 offset-sm-3 {{errors.hide}}" for="firstname">{{errors.firstname}}</label>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-sm-3" for="lastname">Lastname:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" ng-model="user.lastname" id="lastname" placeholder="Enter lastname" name="lastname">
                            </div>
                            <label id="error" class="control-label col-sm-9 offset-sm-3 {{errors.hide}}" for="lastname">{{errors.lastname}}</label>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-sm-3" for="username">Username:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" ng-model="user.username" id="username" placeholder="Enter username" name="username" data-toggle="tooltip" data-placement="right" title="Give a unique username for your account. It can't be modified later.">
                            </div>
                            <label id="error" class="control-label col-sm-9 offset-sm-3 {{errors.hide}}" for="username">{{errors.username}}</label>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-sm-3" for="email">Email:</label>
                            <div class="col-sm-9">
                                <input type="email" class="form-control" ng-model="user.email" id="email" placeholder="Enter email" name="email">
                            </div>
                            <label id="error" class="control-label col-sm-9 offset-sm-3 {{errors.hide}}" for="email">{{errors.email}}</label>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-sm-3" for="password">Password:</label>
                            <div class="col-sm-9">          
                                <input type="password" class="form-control" ng-model="user.password" id="password" placeholder="Enter password" name="password" data-toggle="tooltip" data-placement="right" title="Give a secure password! At least 6 character.">
                            </div>
                            <label id="error" class="control-label col-sm-9 offset-sm-3 {{errors.hide}}" for="password">{{errors.password}}</label>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-sm-3" for="password">Password again:</label>
                            <div class="col-sm-9">          
                                <input type="password" class="form-control" ng-model="user.password2" id="password2" placeholder="Enter password" name="password2">
                            </div>
                            <label id="error" class="control-label col-sm-9 offset-sm-3 {{errors.hide}}" for="password2">{{errors.password2}}</label>
                        </div>
                        <div class="form-group row">
                            <div class="offset-sm-3 col-sm-9">
                                <div class="checkbox">
                                    <label><input type="checkbox" ng-model="user.agree" id="agree" name="agree" value="true"> I accept <a href="#" data-toggle="modal" data-target="#myModal">terms & conditions</a>.</label>
                                </div>
                            </div>
                            <label id="error" class="control-label col-sm-9 offset-sm-3 {{errors.hide}}" for="agree">{{errors.agree}}</label>
                        </div>
                        <div class="form-group row">        
                            <div class="offset-sm-3 col-sm-9">
                                <input type="submit" class="btn btn-dark" value="SignUp"></input>
                            </div>
                        </div>
                    </form>
                    <div class="alert alert-{{message.type}} alert-dismissible {{message.hide}}">{{message.text}}</div>
                </div>
            </div>
        </div>
<!-- End Form -->
<!-- The Modal -->
        <div class="modal fade" id="myModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Terms and Conditions</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Impedit accusantium exercitationem culpa maxime, repudiandae nisi quia nostrum mollitia deserunt quae similique enim aspernatur ea qui provident modi dolorem! Laborum, iste.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
<!-- End Modal -->
    </div>
    <script src="controllers/signupCtrl.js"></script>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</body>
</html>