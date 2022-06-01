var socket  = require( 'socket.io' );
var express = require('express');
var app     = express();
var server  = require('http').createServer(app);
var io      = socket.listen( server );
var port    = process.env.PORT || 3000;

// server.globalAgent.maxSockets = 60;

server.listen(port, function () {
  console.log('Server listening at port %d', port);
});


io.on('connection', function (socket) {
  socket.on( 'payroll', function( data ) {
    io.sockets.emit( 'payroll', data);
  });
});
