<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
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

    <script src="js/main.js"></script>
    <link rel="stylesheet" href="css/main.css">
</head>
<body class="text-center" ng-app="ngApp" ng-controller="ngCtrlPrimary">
<div class="main-container col-centered">
    <div id="camera"></div>
    <div id="result"></div>
</div>
<button type="button" onclick="javascript:void(take_snapshot())" ng-disabled="photoTaken" ng-click="photoTaken = true" class="btn btn-primary btn-lg">
    <i class="fa fa-camera"></i> Take Photo
</button>
<button type="button" onclick="javascript:void(resetSnapshot())" ng-disabled="!photoTaken" ng-click="photoTaken = false" class="btn btn-danger btn-lg">
    <i class="fa fa-user-times"></i> Reset Photo
</button>

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
    }
</script>
<form action="convert.php" method="post" class="">
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
        <button class="btn btn-success" ng-disabled="!summonerName" type="submit">Submit</button>
      </span>
        </div>
    </div>
    <input type="hidden" id="base" name="base" value="">
</form>
</body>
</html>