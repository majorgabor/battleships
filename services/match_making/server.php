<?php

require_once "address.php";

$_SESSION["game_room"] = [];

$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP) or die("Could not create socket\n");
socket_bind($socket, $host, $port) or die("Could not bind to socket\n");
socket_listen($socket, 3) or die("Could not set up socket listener\n");

echo "<h3>Server is running on ".$host." : ".$port."</h3><br>";


while(true){
    $connection1 = socket_accept($socket) or die("Could not accept incoming connection\n");
    $player1 = socket_read($connection1, 1024) or die("Could not read input\n");

    if($player1 === "STOP_SERVER"){
        socket_close($connection1);
        break;
    }

    $connection2 = socket_accept($socket) or die("Could not accept incoming connection\n");
    $player2 = socket_read($connection2, 1024) or die("Could not read input\n");

    if($player2 === "STOP_SERVER"){
        socket_close($connection1);
        socket_close($connection2);
        break;
    }
    
    echo "<p>player1: ".$player1." player2: ".$player2."</p><br>";

    array_push($_SESSION["game_room"], ["player1" => $player1, "player2" => $player2]);

    socket_write($connection1, $player2, strlen ($player2)) or die("Could not write output\n");
    socket_write($connection2, $player1, strlen ($player1)) or die("Could not write output\n");

    socket_close($connection1);
    socket_close($connection2);
}

socket_close($socket);
echo "<p>Server stopped.</p><br>";

print_r($_SESSION["game_room"]);
?>