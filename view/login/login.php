<!DOCTYPE html>
<?php

require_once "../../services/methods.php";

/*if(isset($_COOKIE["remember"]) && isset($_SESSION[$_COOKIE["remember"]])){
    redirect("game.php");
} else if(isset($_COOKIE["remember"])){
    $_SESSION[$_COOKIE["remember"]] = "logged_in";
    redirect("game.php");
}*/
if(isset($_SESSION["logged_in"])){
    redirect("./account/index.php");
}

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
    <link href="../../open-iconic/font/css/open-iconic-bootstrap.css" rel="stylesheet">
    <title>Login</title>
</head>
<body>
    <div ng-app="myApp" ng-controller="loginCtrl">
        <nav class="navbar navbar-expand-md bg-dark navbar-dark">
            <a class="navbar-brand" href="../index/index.php">Battleships game</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../signup/signup.php">
                        <span class="oi oi-person" title="person" aria-hidden="true"></span>
                        Sign Up</a>
                    </li>
                </ul>
            </div>
        </nav>
<!-- The First Row -->
        <div id="first_row" class="row">
            <div id="grid_style" class="offset-xl-3 col-xl-6 offset-lg-2 col-lg-8 offset-md-1 col-md-10 col-sm-12 col-12" >
                <div class="jumbotron">
                    <h3>Helló {{user.username}}</h3>
                </div>
            </div>
        </div>
<!-- End First Row -->
<!-- The Second Row -->
        <div class="row">
            <div id="grid_style" class="offset-xl-3 col-xl-6 offset-lg-2 col-lg-8 offset-md-1 col-md-10 col-sm-12 col-12">
                <div class="jumbotron">
                    <h3>Login</h3>
                    <br>
<!-- The Form -->
                    <form class="form-horizontal" ng-submit="submitForm()">
                        <div class="form-group row">
                            <label class="control-label col-sm-3" for="username">Username:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" ng-model="user.username" id="username" placeholder="Enter username" name="username">
                            </div>
                            <label  class="control-label col-sm-9 offset-sm-3 {{errors.hide}}" for="username">{{errors.username}}</label>                            
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-sm-3" for="password">Password:</label>
                            <div class="col-sm-9">          
                                <input type="password" class="form-control" ng-model="user.password" id="password" placeholder="Enter password" name="password">
                            </div>
                            <label class="control-label col-sm-9 offset-sm-3 {{errors.hide}}" for="password">{{errors.password}}</label>
                        </div>
                        <div class="form-group row">        
                            <div class="offset-sm-3 col-sm-9">
                                <input type="submit" class="btn btn-dark" value="LogIn"></input>
                            </div>
                        </div>
                    </form>
                    <div class="alert alert-{{message.type}} alert-dismissible {{message.hide}}">{{message.text}}</div>
                </div>
            </div>
        </div>
    </div>
<!-- End Second Row -->
    <script src="../../controllers/loginCtrl.js"></script>
</body>
</html>