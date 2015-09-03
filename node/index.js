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
var gm  = require('gm').subClass({imageMagick: true});
serverMsg('  Initialized gm');
serverMsg('node.js server initialized');

http.listen(3000, function(){
    serverMsg('Listening on *:3000');
});

io.sockets.on('connection', function(socket){
    var delivery = dl.listen(socket);
    socket.on('generate_image', function(code, name, border){
        serverMsg('Code ' + code + ' received!');
        serverMsg('Name ' + name + ' received!');
        serverMsg('Border ' + border + ' received!');

        serverMsg('Generating image.')
        gm('img/raw/' + code + '-' + name + '.png')
            .crop(245, 376, 150, 100)
            .write('img/steps/resize.png', function (err) {
                if (!err) {
                    serverMsg(  'Stage 1: Merge with blank.')
                    gm('img/templates/blank.png')
                        .composite('img/steps/resize.png')
                        .geometry('+11+11')
                        .write('img/steps/stage-1.png', function (err) {
                            if (!err) {
                                serverMsg(  'Stage 2: Merge with template.')
                                gm('img/steps/stage-1.png')
                                    .composite('img/templates/' + border + '.png')
                                    .geometry('+0+0')
                                    .write('img/steps/stage-2.png', function (err) {
                                        if (!err) {
                                            serverMsg(  'Stage 3: Merge with text.')
                                            gm('img/steps/stage-2.png')
                                                .fill('#FFFFFF')
                                                .font("Calibri.ttf", 12)
                                                .drawText(0, 160, name, 'Center')
                                                .write('img/final/' + code + '-' + name + '.png', function (err) {
                                                    if (!err) {
                                                        delivery.send({
                                                            name:  + code + '-' + name + '.png',
                                                            path : __dirname + '/img/final/' + code + '-' + name + '.png'
                                                        });
                                                        delivery.on('send.success',function(file){
                                                            serverMsg('File successfully sent to client!');
                                                        });
                                                    } else {
                                                        console.log(err);
                                                    }
                                                });
                                        } else {
                                            console.log(err);
                                        }
                                    });
                            } else {
                                console.log(err);
                            }
                        });
                } else {
                    console.log(err);
                }
            });
    });
});






