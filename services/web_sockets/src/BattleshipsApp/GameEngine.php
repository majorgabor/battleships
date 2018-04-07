<?php
namespace BattleshipsApp;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class GameEngine implements MessageComponentInterface {
    protected $clients;
    protected $clientIds;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
        $this->clientIds = array();
        $this->accepted = array();
        $this->ships = array();
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $json) {
        $message = json_decode($json);
        
        switch($message->type) {
            case "INIT":
                $this->clientIds[$message->username] = $from->resourceId;
                break;
            
            case "GAME_END":
                $response = array(
                    "type" => "ENEMY_LEFT",
                    "data" => $message->data
                );
                foreach($this->clients as $client) {
                    if($client->resourceId == $this->clientIds[$message->enemy]) {
                        $client->send(json_encode($response));
                        break;
                    }
                }
                $from->close();
                break;

            case "BATTLEREQUEST":
                if($message->data == "ACCEPT") {
                    if(isset($this->accepted[$this->clientIds[$message->enemy]])) {
                        $response = array(
                            "type" => "BATTLEREQUEST",
                            "data" => "ACCEPT"
                        );
                        foreach($this->clients as $client) {
                            if($client->resourceId == $this->clientIds[$message->enemy]) {
                                $client->send(json_encode($response));
                                break;
                            }
                        }
                        $from->send(json_encode($response));
                    } else {
                        $this->accepted[$from->resourceId] = true;
                    }
                } else if($message->data == "DISCARD") {
                    $response = array(
                        "type" => "BATTLEREQUEST",
                        "data" => "DISCARD"
                    );
                    foreach($this->clients as $client) {
                        if($client->resourceId == $this->clientIds[$message->enemy]) {
                            $client->send(json_encode($response));
                            break;
                        }
                    }
                    $from->close();
                }    
                break;
            
            case "PLACEDSHIPS":
                $this->ships[$message->username] = $message->data;
                break;
        }
    }

    public function onClose(ConnectionInterface $conn) {
        if($key = array_search($conn->resourceId, $this->clientIds)) {
            unset($this->clientIds[$key]);
            if(isset($this->accepted[$key])) {
                unset($this->accepted[$key]);
            }
            if(isset($this->ships[$key])) {
                unset($this->ships[$key]);
            }
        }
        $this->clients->detach($conn);
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }
}
?>