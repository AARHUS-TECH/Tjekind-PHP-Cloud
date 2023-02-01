<?php
header("Location: /admin/index.php");
exit();
require_once('core/init.php');

$user = new User();
$user->auth();
?>

<!DOCTYPE html>
<html>
    <head>
    <meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Tjek ind | Aarhus Tech SKP</title>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
		<link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
		<!-- link rel="stylesheet" type="text/css" href="/assets/css/bootstrap.min.css" -->
		<link rel="stylesheet" type="text/css" href="/assets/css/custom.scss">
		<link rel="stylesheet" type="text/css" href="/assets/css/mobile.scss">

        <script>
            function startTime() {
                var today = new Date();
                var h = today.getHours();
                var m = today.getMinutes();
                var s = today.getSeconds();
                m = checkTime(m);   
                s = checkTime(s);
                document.getElementById('clock').innerHTML =
                "- " + h + ":" + m + ":" + s + " -";
                var t = setTimeout(startTime, 500);
				document.getElementById("studiekort").focus();
            }
            function checkTime(i) {
                if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
                return i;
            }
        </script>
    </head>
    <body onload="startTime()" style="overflow-y: hidden;"  oncontextmenu="event.stopImmediatePropagation(); return false;">
        <div class="container">
            <div class="row vcenter">
                <div class="col-md-8">

                    <!--<div class="error-div" style="display:none;">-->
                    <?php echo Errors::getErrorMessage('index_error'); ?>
                    <?php echo Errors::getSuccessMessage('index_success'); ?>
                    <!--</div>-->

                    <div class="card card-default">
                        <div id="splash" class="card-body" >
                            <h3 class="text-center" id="clock">&nbsp;</h3>
                            <h4 class="text-center">LOG IND MED TJEK-IND KORT</h4>
                            <br />
                            <center>
                                <form method="post" name="studiekort-login-form" action="/" onsubmit="return validateFormStudiekort()">
                                    <div class="form-group">
                                        <input type="password" id="studiekort" class="form-control" name="studiekort" autocomplete="off" autofocus>
                                    </div>
                                    <!-- a id="bruger-login-btn" class="btn btn-success">Gå til brugernavn og adgangskode</a-->
                                </form>
                            </center>
                            <br />
                            <center><p class="text-center">&copy; Aarhus Tech SKP <?php echo date('Y'); ?><br />Udviklet af elever fra SKP Data IT</p></center>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <script src="/assets/js/jquery.min.js"></script>
        <script src="/assets/js/popper.js"></script>
        <script src="/assets/js/bootstrap.min.js"></script>
        <script src="/assets/js/dismiss-alerts.js"></script>
        <script src="/assets/js/login-page.js"></script>
        <!--<script type="text/javascript" src="/assets/js/ajax-login.js"></script>-->
    </body>
</html>
