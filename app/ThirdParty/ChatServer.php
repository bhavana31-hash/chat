<?php

namespace ChatApp;
 use Ratchet\MessageComponentInterface;
 use Ratchet\ConnectionInterface;

 
class ChatServer implements MessageComponentInterface {
    protected $clients;
    public function __construct() {
    $this->clients = new \SplObjectStorage;
    }
    public function onOpen(ConnectionInterface $conn) {
    // Add new client connection
    $this->clients->attach($conn);
    echo "New connection! ({$conn->resourceId})\n";
    }
    public function onClose(ConnectionInterface $conn) {
    // Remove client on disconnect
    $this->clients->detach($conn);
    echo "Connection {$conn->resourceId} has disconnected\n";
    }
    public function onMessage(ConnectionInterface $from, $msg) {
    // Broadcast message to all connected clients
    foreach ($this->clients as $client) {
    // Send message to everyone except the sender
    if ($from !== $client) {
    $client->send($msg);
    }
    }
    }
    public function onError(ConnectionInterface $conn, \Exception $e) {
    echo "An error has occurred: {$e->getMessage()}\n";
    $conn->close();
    }
 }