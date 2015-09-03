<?php
$data = $_POST["base"];
$name = $_POST["summonerName"];
$border = $_POST["borderType"];

list($type, $data) = explode(';', $data);
list(, $data)      = explode(',', $data);
$data = base64_decode($data);

$today = getdate();
$file_name =  $today['year'] . '' . $today['mon'] . ''  . $today['mday'] . '-' . $today['hours'] . '' . $today['minutes'] . '' . $today['seconds'];
    file_put_contents('../node/img/raw/' . $file_name . '-' . $name . '.png', $data);
?>

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
    <!-- webcam.js -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.4/webcam.js"></script>

    <!-- JQuery 2.1.4 -->
    <script src="js/socket.io.js"></script>
    <!-- JQuery 2.1.4 -->
    <script src="js/delivery.js"></script>

    <script src="js/main.js"></script>

    <link rel="stylesheet" href="css/main.css">

</head>
<body class="text-center">
<header class="col-centered">
    <img src="img/logo.png">
</header>
<script>
    $(function(){
        var socket = io.connect('http://localhost:3000');
        socket.on('connect', function(){
            socket.emit('generate_image', $('#code').val(), $('#name').val(), $('#border').val());

            var delivery = new Delivery(socket);

            delivery.on('receive.start',function(fileUID){
                clientMsg('Receiving a file!');
            });

            delivery.on('receive.success',function(file){
                clientMsg('File received!');
                $('#loading').css('display', 'none');
                $('#post-buttons').css('display', 'initial');
                if (file.isImage()) {
                    $('#final').attr('src', file.dataURL());


                };
            });
        });
    });
</script>
<input id="code" value="<?php echo($file_name);?>" type="hidden">
<input id="name" value="<?php echo(htmlspecialchars($name));?>" type="hidden">
<input id="border" value="<?php echo($border);?>" type="hidden">

<div class="col-centered">
    <div id="loading">
        <i class="fa fa-refresh fa-spin fa-5x"></i><br>
        <h4>Your picture is currently being processed.</h4>
    </div>
    <img id="final">

    <br>
    <div id="post-buttons">
        <button onclick="$('#form-email').css('display', 'initial')" class="btn btn-success btn-lg"><i class="fa fa-envelope-o"></i> Email</button>
        <a href="index.php">
            <button class="btn btn-primary btn-lg"><i class="fa fa-reply"></i> Start Over</button>
        </a>
    </div>
    <div id="form-email">
        <form class="col-lg-4 col-centered" style="padding-top: 10px;" role="form">
            <div class="alert alert-warning" role="alert"><i class="fa fa-wrench"></i> Email function is currently unavailable.</div>
                <div class="form-group input-group">
                    <span class="input-group-addon" id="sizing-addon2">Email</span>
                    <input type="text" class="form-control" placeholder="Email Address">
            </div>

            <div class="form-group input-group">
                <span class="input-group-addon" id="sizing-addon2">Name</span>
                <input type="text" class="form-control" placeholder="First and Last">
            </div>

            <div class="form-group input-group">
                <span class="input-group-addon" id="sizing-addon2">Summoner Name</span>
                <input type="text" class="form-control" placeholder="What is your summoner name?">
            </div>

            <button class="btn btn-success btn-lg" disabled><i class="fa fa-upload"></i> Send</button>
        </form>
    </div>
</div>
</body>
</html>
