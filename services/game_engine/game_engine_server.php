<?php

$host = "localhost";
$port = $argv[1];

$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP) or die("Could not create socket\n");
socket_bind($socket, $host, $port) or die("Could not bind to socket\n");
socket_listen($socket, 3) or die("Could not set up socket listener\n");

echo "Game Engine Server is running on ".$host." : ".$port."\n";


$connection1 = socket_accept($socket) or die("Could not accept incoming connection\n");
$to_connection2 = socket_read($connection1, 1024) or die("Could not read input\n");

$connection2 = socket_accept($socket) or die("Could not accept incoming connection\n");
$to_connection1 = socket_read($connection2, 1024) or die("Could not read input\n");

socket_write($connection1, $to_connection1, strlen($to_connection1)) or die("Could not write output\n");
socket_write($connection2, $to_connection2, strlen($to_connection2)) or die("Could not write output\n");

socket_close($connection1);
socket_close($connection2);

// while(true){
//     echo "Waiting for palyers.\n";

//     $connection1 = socket_accept($socket) or die("Could not accept incoming connection\n");
//     $player1 = socket_read($connection1, 1024) or die("Could not read input\n");

//     if($player1 === "STOP_SERVER"){
//         socket_close($connection1);
//         break;
//     }

//     echo "player1 is connected\n";

//     $connection2 = socket_accept($socket) or die("Could not accept incoming connection\n");
//     $player2 = socket_read($connection2, 1024) or die("Could not read input\n");

//     if($player2 === "STOP_SERVER"){
//         socket_close($connection1);
//         socket_close($connection2);
//         break;
//     }
    
//     echo "Match Makeing: player1: ".$player1." player2: ".$player2.".\n";

//     do{
//         $engine_port = rand(30000, 40000);
//     } while(in_array($port, $_SESSION["engine_port"]));

//     array_push($_SESSION["engine_port"], $engine_port);

//     echo "New Game Engine port is ".$engine_port."\n";

//     $to_connection1 = serialize(["port" => $engine_port, "enemy" => $player2]);
//     $to_connection2 = serialize(["port" => $engine_port, "enemy" => $player1]);

//     socket_write($connection1, $to_connection1, strlen($to_connection1)) or die("Could not write output\n");
//     socket_write($connection2, $to_connection2, strlen($to_connection2)) or die("Could not write output\n");

//     socket_close($connection1);
//     socket_close($connection2);
// }

socket_close($socket);
echo "Server stopped.\n";
?>