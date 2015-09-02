var debugMode = true;

var debugMsg = function(msg) {
    if (debugMode)
        console.log('!!!DEBUG!!! ' + msg);
}

var clientMsg = function(msg) {
    console.log('<<<CLIENT>>> ' + msg);
}



function take_snapshot() {
    Webcam.snap( function(data_uri) {
        document.getElementById('my_result').innerHTML = '<img src="'+data_uri+'"/>';
    } );
}

/*
$(function(){
    var socket = io.connect('http://localhost:3000');

    socket.on('connect', function(){
        var delivery = new Delivery(socket);

        delivery.on('receive.start',function(fileUID){
            clientMsg('Receiving a file!');
        });

        delivery.on('receive.success',function(file){
            clientMsg('File received!');
            if (file.isImage()) {
                $('img').attr('src', file.dataURL());


            };
        });
    });
});*/
