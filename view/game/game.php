<!DOCTYPE html>
<?php
session_start();
echo "you are ".$_SESSION["logged_in"]."<br>";
echo "your enemy is ".$_SESSION["enemy"]."<br>";
echo "port is ".$_SESSION["game_engine_port"]."<br>";
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
    <title>Game</title>
</head>
<body oncontextmenu="return false;">
    <div ng-app="myApp" ng-controller="gameCtrl">
        <nav class="navbar navbar-expand-md bg-dark navbar-dark">
            <div class="navbar-brand">Battleships game</div>
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
                        <a class="nav-link" href="" >
                            <span class="oi oi-flag" title="exit game" aria-hidden="true"></span>
                        Exit Game</a>
                    </li>
                </ul>
            </div>
        </nav>
<!-- End Menu -->
<!-- The First Row -->
        <div id="first_row" class="row">
            <div class="col-12">
                <div class="jumbotron">
                    <h3>Your enemy is <b><?php echo $_SESSION["enemy"]; ?></b></h3>
                    <br>
                    <div class="container">
                        <button type="button" class="btn btn-primary">Exit Game</button>
                    </div>
                </div>
            </div>
        </div>
<!-- End first Row -->
<!-- The Gmane Row -->
        <div id="game_row" class="row">
            <div class="col-xl-6 col-lg-12">
                <div class="jumbotron">
                    <h3>Your Ships</h3>
                    <br>
                    <div id="myShips" ng-modell="setShip"></div>
                    <br>
                    <div id="shipPlaceButtons" class="container">
                        <div class="btn-group">
                            <button id="reset" type="button" class="btn btn-primary">Reset Table</button>
                            <button id="ready" type="button" class="btn btn-primary">Ready</button>
                            <button id="random" type="button" class="btn btn-primary">Random</button>
                        </div> 
                    </div>
                </div>
                <div class="alert alert-primary">
                    You have to step in {{placeShipCounter}} secons!
                </div>
            </div>
            <div class="col-xl-6 col-lg-12">
                <div class="jumbotron">
                    <h3>Battlefield</h3>
                    <br>
                    <div id="myBattlefield"></div>
                    <br>
                    <div class="container">
                        <button type="button" class="btn btn-primary">Fire Missle</button>
                    </div>
                </div>
                <div class="alert alert-primary">
                    You have to step in XX secons!
                </div>
            </div>
        </div>
<!-- End Game Row -->
<!-- Change Password Change Modal -->
<div class="modal fade" id="acceptBattleModal">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Battle request</h4>
                    </div>
                    <div class="modal-body">
                    <div class="container">
                        <h3>Your enemy is <b><?php echo $_SESSION["enemy"]; ?></b></h3>
                        <br>
                        <div id="requestButtons">
                            <button id="accept" type="button" class="btn btn-success">Accept</button>
                            <button id="discard" type="button" class="btn btn-danger">Discard</button>
                        </div>
                        <!-- <div id="waitingForOpponent" class="alert alert-primary">
                            Waiting for your other player reaction.
                        </div> -->
                    </div>
                    </div>
                    <div class="modal-footer">
                        <div id="requesrCounter">
                            Answer in {{requestCounter}} seconds.
                        </div>
                        <div id="requesrWaiting">
                            Waiting for the enemy.
                        </div>
                        <div id="enemyDiscarded">
                            Enemy player is discarded.
                        </div>
                        <div id="youDiscarded">
                            You discard.
                        </div>
                    </div>
                </div>
            </div>
        </div>
<!-- End Password Change Modal -->
        <script src="../../js/shipTable.js"></script>
        <script src="../../js/battleTable.js"></script>
    </div>
    <script src="../../controllers/gameCtrl.js"></script>    
</body>
</html>