<?php
session_start();

$request_uri = ltrim($_SERVER['REQUEST_URI'], "/");
// $request_uri = rtrim($request_uri, "/");

$request_uri = explode("/", $request_uri);

if(isset($request_uri[1])) {
    switch ($request_uri[1]) {
        case "":
            require 'view/index/index.php';
            break;
        
        case 'login':
            !isset($request_uri[2]) ? require 'view/login/login.php' : notfound();
            break;

        case 'signup':
            !isset($request_uri[2]) ? require 'view/signup/signup.php' : notfound();
            break;

        case "account":
            !isset($request_uri[3]) && isset($request_uri[2]) ? require 'view/account/account.php' : notfound();
            break;
            
        case "game":
            !isset($request_uri[4]) && isset($request_uri[3]) ? require 'view/game/game.php' : notfound();
            break;
            
        case "services":
            break;

        default:
            notfound();
            break;
    }
}

function notfound(){
    header('HTTP/1.0 404 Not Found');
    require 'view/404/404.php';
    echo $_SERVER["REQUEST_URI"];
}