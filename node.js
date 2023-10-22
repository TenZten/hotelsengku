const express = require('express');
const http = require('http');
const socketIo = require('socket.io');

const app = express();
const server = http.createServer(app);
const io = socketIo(server);

app.get('/', (req, res) => {
  res.sendFile(__dirname + '/index.html'); // Buat halaman web chat sederhana
});

io.on('connection', (socket) => {
  console.log('User terhubung');

  socket.on('chat message', (msg) => {
    io.emit('chat message', msg);
  });

  socket.on('disconnect', () => {
    console.log('User terputus');
  });
});

server.listen(3000, () => {
  console.log('Server berjalan pada http://localhost:3000');
});
