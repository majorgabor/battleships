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
            
            case "EXIT_END":
                $this->sendToEnemy("ENEMY_LEFT", $message->data, $message->enemy);
                $this->sendBackToMe("ENEMY_LEFT", $message->data, $from);
                break;

            case "BATTLEREQUEST":
                if($message->data == "ACCEPT") {
                    if(isset($this->accepted[$this->clientIds[$message->enemy]])) {
                        $this->sendToEnemy("BATTLEREQUEST", "ACCEPT", $message->enemy);
                        $this->sendBackToMe("BATTLEREQUEST", "ACCEPT", $from);
                    } else {
                        $this->accepted[$from->resourceId] = true;
                    }
                } else if($message->data == "DISCARD") {
                    $this->sendToEnemy("BATTLEREQUEST", "DISCARD", $message->enemy);                    
                    $from->close();
                }    
                break;
            
            case "PLACEDSHIPS":
                $this->ships[$message->username] = $message->data;              
                if(isset($this->ships[$message->enemy])) {
                    if(rand(0, 9) < 5) {
                        $this->sendToEnemy("YOU_WAIT", NULL, $message->enemy);
                        $this->sendBackToMe("YOU_TURN", NULL, $from);
                    } else {
                        $this->sendToEnemy("YOU_TURN", NULL, $message->enemy);
                        $this->sendBackToMe("YOU_WAIT", NULL, $from);
                    }                    
                }
                break;
            
            case "MISSILE_FIRED":
                $result = "MISSED";
                if(isset($this->ships[$message->enemy][$message->data->x][$message->data->y])) {
                    $this->ships[$message->enemy][$message->data->x][$message->data->y] = 0;
                    $result = "HIT";
                }
                if($result != "MISSED" && $this->isGameOver($message->enemy)) {
                    $this->sendToEnemy("GAME_END", "Your ships sank. You lost.", $message->enemy);
                    $this->sendBackToMe("GAME_END", "You won!", $from);
                    break;
                } else {
                    $this->sendToEnemy(
                        "YOU_TURN",
                        array("result" => $result, "x" => $message->data->x, "y" => $message->data->y),
                        $message->enemy
                    );
                    $this->sendBackToMe(
                        "YOU_WAIT",
                        array("result" => $result, "x" => $message->data->x, "y" => $message->data->y),
                        $from
                    );
                }
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

    protected function sendBackToMe($type, $data, $me) {
        $message = array(
            "type" => $type,
            "data" => $data
        );
        $me->send(json_encode($message));
    }

    protected function sendToEnemy($type, $data, $enemy) {
        $message = array(
            "type" => $type,
            "data" => $data
        );
        foreach($this->clients as $client) {
            if($client->resourceId == $this->clientIds[$enemy]) {
                $client->send(json_encode($message));
                break;
            }
        }
    }

    protected function isGameOver($user) {
        foreach($this->ships[$user] as $column) {
            foreach($column as $cell) {
                if($cell != 0) {
                    return false;
                }
            }
        }
        return true;
    }
}
?>