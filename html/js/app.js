var debugMode = false;

var debugMsg = function(msg) {
    if (debugMode)
        console.log('!!!DEBUG!!! ' + msg);
};

var clientMsg = function(msg) {
    console.log('<<<CLIENT>>> ' + msg);
};

var ngApp = angular.module('ngApp', []);

ngApp.filter('capitalize', function() {
    return function(input, all) {
        return (!!input) ? input.replace(/([^\W_]+[^\s-]*) */g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();}) : '';
    }});

ngApp.controller('ngCtrlPrimary', ['$scope', function($scope) {
    $scope.photoTaken = false;
    $scope.borderType = "Select a Border";

    Webcam.on( 'live', function() {
        $scope.$apply(function() {
            $scope.checkLive = true;
            debugMsg($scope.checkLive);
        });
    });
}]);

