<?php
namespace BattleshipsApp;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class MatchMaking implements MessageComponentInterface {
    protected $clients;
    protected $usernames;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
        $this->usernames = array();
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $json) {
        $message = json_decode($json);
        
        print_r($this->usernames);
        
        switch($message->type){
            case "NAME":
                echo "Connection ".$from->resourceId." username is ".$message->data."\n";
                $this->usernames[$from->resourceId] = $message->data;
                break;
            case "MATCHMAKE":
                echo "Try to make match.\n";
                if(2 <= count($this->usernames)){
                    $this->sendToAll(
                        "INFO",
                        "Match making in progress."
                    );
                    $this->tryMatchMake();
                } else {
                    echo "Can't make match.\n";
                }
                break;
            case "ABORT":
                echo "Connection ".$from->resourceId." ".$message->data." left the match making.\n";
                $from->close();
                break;
        }
        $this->sendToAll(
            "INFO",
            "Waiting for match making. There are ".(count($this->clients)-1)." other players waiting."
        );
    }

    public function onClose(ConnectionInterface $conn) {
        unset($this->usernames[$conn->resourceId]);
        $this->clients->detach($conn);
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }

    protected function sendToAll($type, $data) {
        $message = array(
            "type" => $type,
            "data" => $data
        );
        $json = json_encode($message);
        foreach ($this->clients as $client) {
            $client->send($json);
        }
    }

    protected function tryMatchMake() {
        $idArray = [];
        foreach($this->usernames as $key => $value) {
            array_push($idArray, $key);    
        }
        $rand1 = rand(0, count($idArray)-1);
        $player1_id = $idArray[$rand1];
        do{
            $rand2 = rand(0, count($idArray)-1);        
        } while($rand1 == $rand2);
        $player2_id = $idArray[$rand2];

        foreach ($this->clients as $client) {
            if($client->resourceId ==  $player1_id) {
                $response = array(
                    "type" => "ENEMY",
                    "data" => $this->usernames[$player2_id],
                );
                $client->send(json_encode($response));
                $client->close();
                unset($this->usernames[$player2_id]);
            } else if($client->resourceId ==  $player2_id) {
                $response = array(
                    "type" => "ENEMY",
                    "data" => $this->usernames[$player1_id],
                );
                $client->send(json_encode($response));
                $client->close();
                unset($this->usernames[$player1_id]);
            }
        }
        echo "Match maked!\n";

    }
}
?>