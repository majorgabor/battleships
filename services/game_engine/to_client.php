<?php

session_start();

$json = file_get_contents("php://input");
$post_data = json_decode($json);



// $playerShips = $post_data => 


// $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP) or die("Could not create socket\n");
// socket_connect($socket, "localhost", $_SESSION["game_engine_port"]) or die("Could not connect to server\n");  

// socket_write($socket, $requestAnswer, strlen($requestAnswer)) or die("Could not send data to server\n");

// $requestAnswer = socket_read ($socket, 1024) or die("Could not read server response\n");

// socket_close($socket);

print_r($json);
print_r($post_data);

?>