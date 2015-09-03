var debugMode = true;

var debugMsg = function(msg) {
    if (debugMode)
        console.log('!!!DEBUG!!! ' + msg);
}

var clientMsg = function(msg) {
    console.log('<<<CLIENT>>> ' + msg);
}
