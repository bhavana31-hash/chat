<!DOCTYPE html>
 <html lang="en">
 <head>
 <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
 <title>WebSocket Chat</title>
 <style>
 #messages {
 height: 300px;
 border: 1px solid #ddd;
 padding: 10px;
 margin-bottom: 10px;
 overflow-y: auto;
 }
#messageInput {
 width: 80%;
 padding: 5px;
 }
 #sendButton {
 padding: 5px;
 width: 15%;
 }
 </style>
 </head>
 <body>
 <h1>Chat</h1>
 <div id="messages"></div>
 <input type="text" id="messageInput" placeholder="Type your message">
 <button id="sendButton">Send</button>
 <script>
 const socket = new WebSocket('ws://localhost:8080/demo');
//  console.log(socket);
 socket.onopen = () => {
 console.log("Connected to WebSocket server.");
 };
 socket.onmessage = (event) => {
 const messagesDiv = document.getElementById('messages');
 const newMessage = document.createElement('div');
 newMessage.textContent = event.data;
 messagesDiv.appendChild(newMessage);
 messagesDiv.scrollTop = messagesDiv.scrollHeight;
 };
 socket.onerror = (error) => {
 console.error('WebSocket Error:', error);
 };
 document.getElementById('sendButton').addEventListener('click', () => {
 const message = document.getElementById('messageInput').value;
 if (message) {
 socket.send(message);
 document.getElementById('messageInput').value = '';
 }
 });
 </script>
 </body>
</html>