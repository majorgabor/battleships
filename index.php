<?php
session_start();

$request_uri = ltrim($_SERVER['REQUEST_URI'], "/");
$request_uri = rtrim($request_uri, "/");

$request_uri = explode("/", $request_uri);

if(isset($request_uri[4]))  {
    header('HTTP/1.0 404 Not Found');
    require 'view/404/404.php';
    echo $_SERVER["REQUEST_URI"];

} else if(isset($request_uri[3]) && $request_uri[1] == "game") {
    $_SESSION["enemy"] = $request_uri[2];
    require 'view/game/game.php';

} else if(isset($request_uri[2]) && $request_uri[1] == "account" && !isset($request_uri[3])) {
    require 'view/account/account.php';

} else if(isset($request_uri[1]) && !isset($request_uri[2])) {
    switch ($request_uri[1]) {
        case 'login':
            require 'view/login/login.php';
            break;
        case 'signup':
            require 'view/signup/signup.php';
            break;
        default:
            header('HTTP/1.0 404 Not Found');
            require 'view/404/404.php';
            echo $_SERVER["REQUEST_URI"];
            break;
    }

} else if(!isset($request_uri[1])) {
    require 'view/index/index.php';
}




// if(isset($request_uri[4])) {
//     header('HTTP/1.0 404 Not Found');
//     require 'view/404/404.php';
//     echo $_SERVER["REQUEST_URI"];
    
// } else if(!isset($request_uri[1]) && $request_uri[0] == "battleships") {
//     require 'view/index/index.php';
    
// } else if($request_uri[1] == "game" && isset($request_uri[2]) && isset($request_uri[3])) {
    

// } else if(!isset($request_uri[2])) {
    
// } else {
//     header('HTTP/1.0 404 Not Found');
//     require 'view/404/404.php';
//     echo $_SERVER["REQUEST_URI"];
// }