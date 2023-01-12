<?php
require_once('../core/init.php');

$user = new User();
$user->auth();

?><!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Tjek ind | Aarhus Tech SKP</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="/assets/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="/assets/css/custom.css">
        <link rel="stylesheet" type="text/css" href="/assets/css/mobile.css">

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
            }

            function checkTime(i) {
                if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
                return i;
            }
        </script>
    </head>
    
    <body onload="startTime();">
    <div class="container">
        <div class="row vcenter">
            <div class="col-md-8">
                <div class="card card-default">

                    <?php echo Errors::getErrorMessage('admin_login_error'); ?>
                    <?php echo Errors::getSuccessMessage('admin_login_success'); ?>

                    <div id="splash" class="card-body" >
                        <h3 class="text-center" id="clock">&nbsp;</h3>
                        <h4 class="text-center">INSTRUKTØR DASHBOARD</h4>
                        <br />
                        <center>
                            <form method="post" name="bruger-login-form" action="/" onsubmit="return validateFormBruger()">
                                <div id="brugernavn-form-group" class="form-group">
                                    <input type="text" id="brugernavn" class="form-control" name="brugernavn" placeholder="Brugernavn" autocomplete="off" autofocus>
                                </div>
                                <div id="adgangskode-form-group" class="form-group">
                                    <input type="password" id="adgangskode" class="form-control" name="adgangskode" placeholder="Adgangskode" autocomplete="off">
                                </div>
                                <button id="login" type="submit" class="btn btn-outline-success" style="width: 100%;">Log ind</button>
                            </form>
                        </center>
                        <br />
                        <center><p class="text-center">&copy; Aarhus Tech SKP <?php echo date('Y'); ?><br/>Udviklet af elever og instruktører SKP Data IT</p></center>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <script src="/assets/js/jquery.min.js"></script>
        <script src="/assets/js/popper.js"></script>
        <script src="/assets/js/bootstrap.min.js"></script>
        <script src="/assets/js/dismiss-alerts.js"></script>
        <script src="/assets/js/sortlist.js"></script>
    </body>
</html>
