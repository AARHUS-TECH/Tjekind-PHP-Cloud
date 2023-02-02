<?php
require_once('../core/init.php');

$user = new User();
$user->auth();

?><!DOCTYPE html>
<html lang="da">
    <head>
        <meta charset="utf-8">
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
                        <div style="text-align: center;">
                            <form method="post" name="bruger-login-form" action="/" onsubmit="return validateFormBruger()">
                                <div id="brugernavn-form-group" class="form-group">
                                    <input type="text" id="brugernavn" class="form-control" name="brugernavn" placeholder="Brugernavn" autocomplete="off" autofocus>
                                </div>
                                <div id="adgangskode-form-group" class="form-group">
                                    <input type="password" id="adgangskode" class="form-control" name="adgangskode" placeholder="Adgangskode" autocomplete="off">
                                </div>
                                <button id="login" type="submit" class="btn btn-outline-success" style="width: 100%;">Log ind</button>
                            </form>
                        </div>
                        <br />
                        <div style="text-align: center;"><p class="text-center">&copy; Aarhus Tech SKP <?php echo date('Y'); ?><br/>Udviklet af elever og instruktører SKP Data IT</p></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>		<script src="/assets/js/dismiss-alerts.js"></script>
    <script src="/assets/js/sortlist.js"></script>
    <script src="/assets/js/dismiss-alerts.js"></script>
    <script src="/assets/js/login-page.js"></script>
    
    </body>
</html>
