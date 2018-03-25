<?php

session_start();

require_once "address.php";

$username = $_SESSION["logged_in"];

$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP) or die("Could not create socket\n");
socket_connect($socket, $host, $port) or die("Could not connect to server\n");  

socket_write($socket, $username, strlen($username)) or die("Could not send data to server\n");

$data = unserialize(socket_read ($socket, 1024)) or die("Could not read server response\n");

$_SESSION["enemy"] = $data["enemy"];
$_SESSION["game_engine_port"] = $data["game_engine_port"];

socket_close($socket);

echo "200 OK";

?>