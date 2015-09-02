var debugMode = true;

var debugMsg = function(msg) {
    if (debugMode)
        console.log('!!!DEBUG!!! ' + msg);
}

var serverMsg = function(msg) {
    console.log('<<<SERVER>>> ' + msg);
}

serverMsg('Initializing node.js server:');
var app = require('express')();
serverMsg('  Initialized express');
var http = require('http').Server(app);
serverMsg('  Initialized http');
var dl  = require('delivery');
serverMsg('  Initialized delivery');
var fs  = require('fs');
serverMsg('  Initialized fs');
var io  = require('socket.io').listen(http);
serverMsg('  Initialized socket.io');
serverMsg('node.js server initialized');

http.listen(3000, function(){
    serverMsg('Listening on *:3000');
});

io.sockets.on('connection', function(socket){
    var delivery = dl.listen(socket);
    delivery.on('delivery.connect',function(delivery){

        delivery.send({
            name: 'template.png',
            path : __dirname + '/img/template.png'
        });
        delivery.on('send.success',function(file){
            serverMsg('File successfully sent to client!');
        });

    });
});