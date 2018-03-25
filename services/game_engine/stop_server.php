<?php

require_once "address.php";

echo "<p>Try to stop server.</p><br>";

$msg = "STOP_SERVER";

$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP) or die("Could not create socket\n");
socket_connect($socket, $host, $port) or die("Could not connect to server\n");  

socket_write($socket, $msg, strlen($msg)) or die("Could not send data to server\n");

socket_close($socket);

echo "<p>STOP signal sendt.</p><br>";
?>