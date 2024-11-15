<?php

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use ChatApp\ChatServer;
require dirname(__FILE__) . '/vendor/autoload.php'; // Ensure Ratchet is autoloaded
// Create the WebSocket server instance
$server = IoServer::factory(
    new HttpServer(
    new WsServer(
    new ChatServer()
    )
),
8080 // WebSocket server will listen on port 8080
);
echo "WebSocket Server started on port 8080\n";
$server->run();