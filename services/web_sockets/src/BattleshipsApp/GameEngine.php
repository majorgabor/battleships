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
            case "BATTLEREQUEST":
                print_r($this->clientIds);
                $response = array(
                    "type" => "BATTLEREQUEST",
                    "data" => $message->data->answer
                );
                foreach($this->clients as $client) {
                    if($client->resourceId == $this->clientIds[$message->enemy]) {
                        $client->send(json_encode($response));
                        break;
                    }
                }
                break;
        }
    }

    public function onClose(ConnectionInterface $conn) {
        foreach($this->clientIds as $key => $value) {
            if($conn->resourceId ==  $value) {
                unset($this->clientIds[$key]);
                break;
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