<?php

session_start();

$requestAnswer = file_get_contents("php://input");

$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP) or die("Could not create socket\n");
socket_connect($socket, "localhost", $_SESSION["game_engine_port"]) or die("Could not connect to server\n");  

socket_write($socket, $requestAnswer, strlen($requestAnswer)) or die("Could not send data to server\n");

$requestAnswer = socket_read ($socket, 1024) or die("Could not read server response\n");

socket_close($socket);

echo $requestAnswer;

?>