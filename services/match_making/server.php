<?php

require_once "address.php";

$generated_port = 0;

$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP) or die("Could not create socket\n");
socket_bind($socket, $host, $port) or die("Could not bind to socket\n");
socket_listen($socket, 3) or die("Could not set up socket listener\n");

echo "Match Making Server is running on ".$host." : ".$port."\n";


while(true){
    echo "Waiting for palyers.\n";

    $connection1 = socket_accept($socket) or die("Could not accept incoming connection\n");
    $player1 = socket_read($connection1, 1024) or die("Could not read input\n");

    if($player1 === "STOP_SERVER"){
        socket_close($connection1);
        break;
    }

    echo "player1 is connected\n";

    $connection2 = socket_accept($socket) or die("Could not accept incoming connection\n");
    $player2 = socket_read($connection2, 1024) or die("Could not read input\n");

    if($player2 === "STOP_SERVER"){
        socket_close($connection1);
        socket_close($connection2);
        break;
    }
    
    echo "Match Makeing: player1: ".$player1." player2: ".$player2.".\n";

    $generated_port = rand(30000, 40000);

    echo "New Game Engine port is ".$generated_port."\n";
    
    pclose(popen('start /B cmd /C "cd ..\game_engine && php game_engine_server.php '.$generated_port.' >NUL 2>NUL"', 'r'));
    // system("cd ..\game_engine && start cmd.exe /k dir && cd ..\match_making");

    $to_connection1 = serialize(["game_engine_port" => $generated_port, "enemy" => $player2]);
    $to_connection2 = serialize(["game_engine_port" => $generated_port, "enemy" => $player1]);

    socket_write($connection1, $to_connection1, strlen($to_connection1)) or die("Could not write output\n");
    socket_write($connection2, $to_connection2, strlen($to_connection2)) or die("Could not write output\n");

    socket_close($connection1);
    socket_close($connection2);
}

socket_close($socket);
echo "Server stopped.\n";

?>