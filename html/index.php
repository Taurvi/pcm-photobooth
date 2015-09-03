<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>UW-PCM Photobooth</title>
    <!-- JQuery 2.1.4 -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <!-- Bootstrap 3.3.5 CSS -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <!-- Bootstrap 3.3.5 Theme -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <!-- Bootstrap 3.3.5 JS -->
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <!-- FontAwesome 4.3.0 -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <!-- webcam.js 1.0.4 -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.4/webcam.js"></script>
    <!-- Angular 1.4.2 -->
    <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.4.2/angular.min.js"></script>

    <!-- socket.io -->
    <script src="js/socket.io.js"></script>
    <!-- delivery.js -->
    <script src="js/delivery.js"></script>

    <script src="js/app.js"></script>
    <link rel="stylesheet" href="css/main.css">
</head>
<body class="text-center" ng-app="ngApp" ng-controller="ngCtrlPrimary">
<div>
<header class="col-centered">
    <img src="img/logo.png">
</header>
<div class="main-container col-centered" id="cameraBox">
    <div class="" id="loadCam" role="alert">
        <div class="alert alert-info  col-centered col-lg-6">
            <i class="fa fa-refresh fa-spin"></i>
            Webcam libraries are loading.
        </div>
    </div>
    <div id="camera"></div>
    <div id="result"></div>
</div>
<div id="buttons" ng-hide="!checkLive">
    <button type="button" onclick="javascript:void(take_snapshot())" ng-disabled="photoTaken" ng-click="photoTaken = true" class="btn btn-primary btn-lg">
    <i class="fa fa-camera"></i> Take Photo
    </button>
    <button type="button" onclick="javascript:void(resetSnapshot())" ng-disabled="!photoTaken" ng-click="photoTaken = false" class="btn btn-danger btn-lg">
        <i class="fa fa-user-times"></i> Reset Photo
    </button>
</div>

<script language="JavaScript">
    var data;
    Webcam.set({
        width: 640,
        height: 480,
        dest_width: 640,
        dest_height: 480,
        image_format: 'png',
        force_flash: false
    });
    Webcam.attach( '#camera' );

    Webcam.on( 'load', function() {
        $('#loadCam').css('display', 'initial');

    } );

    Webcam.on( 'live', function() {
        $('#loadCam').css('display', 'none');
        $('#failCam').css('display', 'none');
    } );

    Webcam.on( 'error', function(err) {
        $('#failCam').css('display', 'initial');
        $('#loadCam').css('display', 'none');
        $('#buttons').css('display', 'none');
        $('#successForm').css('display', 'none');
        $('#cameraBox').css('display', 'none');
    } );

    function take_snapshot() {
        Webcam.snap( function(data_uri) {
            data = data_uri;
            document.getElementById('result').innerHTML = '<img src="'+data_uri+'"/>';
            $('#camera').css('display', 'none');
            $('#result').css('display', 'initial');
            $('#base').val(data_uri);
        } );
    }

    var resetSnapshot = function() {
        $('#camera').css('display', 'initial');
        $('#result').css('display', 'none');

        setTimeout(function(){ location.reload(); }, 15000);

    }
</script>
<form action="convert.php" id="successForm" method="post" class="">
    <div class="col-lg-4 col-centered" id="name-input" ng-hide="!photoTaken">
        <div class="input-group">
            <div class="input-group-btn">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">{{borderType | capitalize:true}} <span class="caret"></span></button>
                <ul class="dropdown-menu">
                    <li><a href="#" ng-click="borderType = 'silver'">Silver</a></li>
                    <li><a href="#" ng-click="borderType = 'gold'">Gold</a></li>
                    <li><a href="#" ng-click="borderType = 'platinum'">Platinum</a></li>
                    <li><a href="#" ng-click="borderType = 'diamond'">Diamond</a></li>
                    <li><a href="#" ng-click="borderType = 'master'">Master</a></li>
                    <li><a href="#" ng-click="borderType = 'challenger'">Challenger</a></li>
                </ul>
            </div>
            <input type="hidden" ng-value="borderType" id="borderType" name="borderType">
            <input type="text" ng-model="summonerName" ng-maxlength="30" class="form-control" id="summonerName" name="summonerName" placeholder="Enter your name">
      <span class="input-group-btn">
        <button class="btn btn-success" ng-disabled="!summonerName || borderType == 'Select a Border'" type="submit">Submit</button>
      </span>
        </div>
    </div>
    <input type="hidden" id="base" name="base" value="">
</form>

<div class="" id="failCam" role="alert">
    <div class="alert alert-danger  col-centered col-lg-6">
        <i class="fa fa-exclamation-triangle"></i>
        <span class="sr-only">Error:</span>
        A webcam is required in order to continue.<br>
    </div>
</div>
</div>

<footer class="navbar navbar-fixed-bottom">
    <div class="col-centered col-lg-5">
        <p><a href="http://na.leagueoflegends.com/" target="_blank">League of Legends</a> and all associated images are the property of <a href="http://www.riotgames.com/" target="_blank>">Riot Games</a></p>
        <p>Designed by Stephen (Taurvi) Rimbakusumo (<a href="https://github.com/Taurvi/" target="_blank"><i class="fa fa-github"></i></a> <a href="https://twitter.com/taurvi" target="_blank"><i class="fa fa-twitter"></i></a> <a href="https://www.facebook.com/taurvi23"><i class="fa fa-facebook-official"></i></a>) for the University of Washington <a href="https://www.facebook.com/groups/uwupcm/?fref=ts" target="_blank">Union of Purple Caster Minions</a>.</p>
    </div>
</footer>
</body>
</html>