<?php
    set_time_limit(0);

    use Ratchet\MessageComponentInterface;
    use Ratchet\ConnectionInterface;
    use Ratchet\Server\IoServer;
    use Ratchet\Http\HttpServer;
    use Ratchet\WebSocket\WsServer;

    require_once __DIR__ . '/vendor/autoload.php';

    /**
     * To run the websocket server call `php websocket/ChatServer.php` from base directory
     */
	class ChatServer implements MessageComponentInterface {
        // Store client connections as ConnectionInterface objects
        protected $clients;

        /**
         * Instantiate client storage object
         */
		public function __construct(){
            $this->clients = new \SplObjectStorage;
        }
        
        /**
         * Add new client connection to storage
         */
        public function onOpen(ConnectionInterface $conn) {
            $this->clients->attach($conn);
            echo "New user connected! ({$conn->resourceId})\n";
            //TODO: send "User x connected"
        }

        /**
         * Remove client connection from storage
         */
        public function onClose(ConnectionInterface $conn) {
            $this->clients->detach($conn);
            echo "Connection ({$conn->resourceId}) has disconnected\n";
            //TODO: send "User x disconnected"
        }

        /**
         * Handle incoming packet
         * Message format (encoded as JSON):
         *      {
         *          "type": "message",
         *          "msg": "response message"
         *      }
         */
        public function onMessage(ConnectionInterface $from,  $msg) {
            $from_userid = $from->resourceId;
            $jsonData = json_decode($msg);
            // print_r($jsonData);
            $type = $jsonData->type;
            switch ($type) {
                case 'message':
                    $user_id = $jsonData->user_id;
                    $chatMessage = $jsonData->chatMessage;
                    // Create response messages
                    $response_from = "<span style='color:#999'><b>".$user_id.":</b> ".$chatMessage."</span><br>";
                    $response_to = "<b>".$user_id."</b>: ".$chatMessage."<br>";
                    // Send response messages
                    $from->send(json_encode(array("type"=>$type,"msg"=>$response_from)));
                    foreach($this->clients as $c) {
                        if($from!=$c) {
                            $c->send(json_encode(array("type"=>$type,"msg"=>$response_to)));
                        }
                    }
                    break;
            }

        }

        /**
         * Handle error by closing connection
         */
        public function onError(ConnectionInterface $conn, \Exception $e) {
            echo "An error has occurred: {$e->getMessage()}\n";
    
            $conn->close();
        }

    }
    

    // Enter event loop and listen for incoming connections on port 8080
    $server = IoServer::factory(
        new HttpServer(new WsServer(new ChatServer())),
        8080
    );
    $server->run();
