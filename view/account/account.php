<?php
    require_once "services/methods.php";
    require_once "services/connect.php";
    auth();
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../view/account/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
    <link href="../open-iconic/font/css/open-iconic-bootstrap.css" rel="stylesheet">
    <title>Account</title>
</head>
<body>
    <div ng-app="myApp" ng-controller="accountCtrl">
<!-- The Menu -->
        <nav class="navbar navbar-expand-md bg-dark navbar-dark">
            <a class="navbar-brand" href="../">Battleships game</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <span class="navbar-text">
                        Logged in as <b><?php echo $_SESSION["logged_in"]; ?></b>
                        </span>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="" ng-click="matchMaking()" >
                            <span class="oi oi-flag" title="start game" aria-hidden="true"></span>
                        Start Game</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../services/logout.php" >
                            <span class="oi oi-account-logout" title="account logout" aria-hidden="true"></span>
                        Logout</a>
                    </li>
                </ul>
            </div>
        </nav>
<!-- End Menu -->
        <div ng-show="loading">
            <img src="images/loading.gif">
        </div>
<!-- Firs Row -->
        <div ng-show="!loading" >
            <div id="first_row" class="row">
                <div class="offset-xl-2 col-xl-5 offset-lg-1 col-lg-6 col-md-7 col-sm-12 col-xs-12">
                    <div class="jumbotron">
                        <h3>Account</h3>
                        <br>
                        <table>
                            <tr>
                                <td><h3>Name</h3></td>
                                <td>{{user.firstname}} {{user.lastname}}</td>
                            </tr>
                            <tr>
                                <td><h3>Username</h3></td>
                                <td>{{user.username}}</td>
                            </tr>
                            <tr>
                                <td><h3>Email</h3></td>
                                <td>{{user.email}}</td>
                            </tr>
                        </table>
                        <br>
                        <div id="buttons" class="container">
                            <div class="btn-group">
                                <button type="button" data-toggle="modal" data-target="#modifyProfileModel" class="btn btn-primary">Modify Profile</button>
                                <button type="button" data-toggle="modal" data-target="#passwordChangeModal" class="btn btn-primary">Change Password</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-5 col-sm-12 col-xs-12">
                    <div id="second_grid" class="jumbotron">
                        <h3>Statistic</h3>
                        <br>
                        <table>
                            <tr>
                                <td><h3>Battles</h3></td>
                                <td>{{user.battles}}</td>
                            </tr>
                            <tr>
                                <td><h3>Wins</h3></td>
                                <td>{{user.wins}}</td>
                            </tr>
                            <tr>
                                <td><h3>Points</h3></td>
                                <td>{{user.points}}</td>
                            </tr>
                        </table>
                        <br>
                        <div class="container">
                            <button type="button" class="btn btn-primary">View Scoreboard</button>                    
                        </div>
                    </div>
                </div>
            </div>
<!-- End First Row -->
<!-- The Second Row -->
            <div id="second_row" class="row">
                <div class="offset-xl-2 col-xl-8 offset-lg-1 col-lg-10 col-md-21 col-sm-12 col-xs-12">
                    <div class="jumbotron">
                        <div class="container">
                            <h3>Join to Battle</h3>
                            <button id="matchMaking" type="button" class="btn btn-primary" data-toggle="modal" data-target="#matchMakingModal" data-backdrop="static" data-keyboard="false">Start Game</button>                    
                        </div>
                    </div>
                </div>
            </div>
        </div>
<!-- End Second Row -->
<!-- The Modify Modal -->
        <?php
            require "view/account/modifyModal.html";
        ?>
<!-- End modify Modal -->
<!-- Change Password Change Modal -->
        <?php
            require "view/account/passwordChangeModal.html";
        ?>
<!-- End Password Change Modal -->
        <!--  -->
        <?php
            require "view/account/matchMakingModal.html";
        ?>
        <!--  -->
    </div>
    <script src="../controllers/accountCtrl.js"></script>
    <script src="../js/matchMakeWS.js"></script>
</body>