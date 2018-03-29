<?php

$request_uri = explode('?', $_SERVER['REQUEST_URI'], 2);


switch ($request_uri[0]) {
    case '/battleships/':
        require 'view/index/index.php';
        break;
    case '/battleships/login':
        require 'view/login/login.php';
        break;
    case '/battleships/signup':
        require 'view/signup/signup.php';
        break;
    case '/battleships/account':
        require 'view/account/account.php';
        break;
    case '/battleships/game':
        require 'view/gmae/gmae.php';
        break;
    // case '/battleships/game':
    //     require 'view/gmae/gmae.php';
    //     break;
    default:
        header('HTTP/1.0 404 Not Found');
        // require 'view/404/404.php';
        echo $request_uri[0];
        break;
}