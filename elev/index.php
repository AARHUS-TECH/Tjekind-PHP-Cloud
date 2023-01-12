<?php
require_once('../core/init.php');

$user = new User();

$user->auth();

$userdata = $user->getInfo(Session::get('userID'));

if(Input::get('status') == 0 && isset($_GET['status']) && $user->isTjekUdAllowed(Session::get('userID'))) {
    $user->tjekUd(Session::get('userID'));
    Session::flash('index_success', '<b>' . $userdata['fulde_navn'] . '</b> blev tjekket ud!');
    Session::delete('userID');
    Redirect::to('/');
} else if(Input::get('status') == 1 && isset($_GET['status']) && $user->isTjekIndAllowed(Session::get('userID'))) {
    $user->tjekInd(Session::get('userID'));
    Session::flash('index_success', '<b>' . $userdata['fulde_navn'] . '</b> blev tjekket ind!');
    Session::delete('userID');
    Redirect::to('/');
} else if (isset($_GET['status'])) {
    die('Some went wrong!');
}

$tjekUdTid = date('Hi', strtotime(Config::get('tjek_ud/ts'), strtotime($userdata['tjekind_timestamp'])));

if(date('D') != 'Fri') {
    
    if($tjekUdTid < Config::get('tjek_ud/min')) {
        $tjekUdTid = '15:00';
    } else {
        $tjekUdTid = date('H:i', strtotime(Config::get('tjek_ud/ts'), strtotime($userdata['tjekind_timestamp'])));
    }
} else {
    if($tjekUdTid < Config::get('tjek_ud/min_fredag')) {
        $tjekUdTid = '14:30';
    } else {
        $tjekUdTid = date('H:i', strtotime(Config::get('tjek_ud/ts_fredag'), strtotime($userdata['tjekind_timestamp'])));
    }
}


?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Tjek ind | Aarhus Tech SKP</title>

        <link rel="stylesheet" type="text/css" href="/assets/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="/assets/css/custom.css">
    </head>
    <body>
        <div class="container">
            <div class="row vcenter">
                <div class="col-md-8">
                    <div class="card card-default">

                        <?php echo Errors::getErrorMessage('elev_error'); ?>
                        <?php echo Errors::getSuccessMessage('elev_success'); ?>

                        <div id="splash" class="card-body">
                            <h3 class="text-center">ELEV OVERSIGT</h3>
                            <h6 class="text-center"><strong>Logget ind som:</strong> <?php echo $userdata['fulde_navn']; ?></h6>
                            <?php if($userdata['status'] != '0') { echo "<h6 class='text-center'><strong>Kan tjekke ud:</strong> $tjekUdTid</h6>"; } ?>

                            <br />
                            <center>
                                <?php echo $user->elevControls(Session::get('userID'), $userdata['status']); ?>
                                <a class="btn btn-warning" id="SecondsUntilExpire" href="logout.php" style="width: 40%;">Log ud (10)</a>
                            </center>
                            <br />
                            <center><p class="text-center">&copy; Aarhus Tech SKP <?php echo date('Y'); ?><br />Udviklet af elever og instruktører SKP Data IT</p></center>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="/assets/js/jquery.min.js"></script>
        <script src="/assets/js/popper.js"></script>
        <script src="/assets/js/bootstrap.min.js"></script>
        <script src="/assets/js/dismiss-alerts.js"></script>
        <script src="/assets/js/inactivity.js"></script>
    </body>
</html>
