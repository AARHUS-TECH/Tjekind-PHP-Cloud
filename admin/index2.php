<?php
require_once('../core/init.php');

$user = new User();

if(Session::exists('userID')) {
    if(!$user->isAdmin(Session::get('userID'))) {
        Session::delete('userID');
        Redirect::to('/');
    }
} else {
    Redirect::to('/');
}

$userdata = $user->getInfo(Session::get('userID'));
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Tjek ind | Aarhus Tech SKP</title>

        <link rel="stylesheet" type="text/css" href="/assets/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="/assets/css/custom.css">
    </head>
    <body onload="refreshTable();">
        <div class="container">
            <div class="row" style="margin-top: 50px;">
                <div class="col-md-3">
                    <div class="list-group">
                        <a href="#" class="list-group-item list-group-item-action active">
                        Cras justo odio
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">Dapibus ac facilisis in
                        </a>
                        <a href="#" class="list-group-item list-group-item-action disabled">Morbi leo risus
                        </a>
                </div>
                </div>
                
                <div class="col-md-9">
                    <div class="panel panel-default">

                        <?php echo Errors::getErrorMessage('admin_error'); ?>
                        <?php echo Errors::getSuccessMessage('admin_success'); ?>

                        <div id="splash" class="panel-body">
                            <h3 class="text-center">INSTRUKTØR OVERSIGT</h3>
                            <h5 class="text-center"><strong>Logget ind som:</strong> <?php echo $userdata['fulde_navn']; ?></h5>
                            <br />
                            <center>
                                <a class="btn btn-success" href="opretElev.php">Registrer elev</a>
                                <a class="btn btn-success" href="opretInstruktoer.php">Registrer instruktør</a>
                                <a class="btn btn-warning" href="logout.php">Log ud</a>
                            </center>
                            <br />
                            
                            <h4 class="text-center" style="font-weight: bold;">Instruktører</h4>
                            <table class="table table-striped table-hover ">
                                <thead>
                                    <tr>
                                    <th>Navn</th>
                                    <th>Brugernavn</th>
                                    <th>Handlinger</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $data = $user->getAllInstruktoerer();
                                        
                                        foreach($data as $row) {
                                            echo '<tr>';
                                            echo '<td>' . $row->fornavn . ' ' . $row->efternavn . '</td>';
                                            echo '<td>' . $row->brugernavn . '</td>';
                                            echo '<td><a href="/admin/redigerInstruktoer.php?id=' . $row->userID . '">Rediger</a></td>';
                                            echo '</tr>';
                                        }
                                    ?>
                                    </tr>
                                    
                                </tbody>
                                </table>
                            <br />
                            <h4 class="text-center" style="font-weight: bold;">Aktive Elever</h4>
                            <table id="elevTable" class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                    <th>Navn</th>
                                    <th>Seneste indtjekning</th>
                                    <th>Status &nbsp;
                                    <select id='filterText' style='display:inline-block; color: #000;' onchange='filterText()'>
                                        <option value='all'>Alle</option>
                                        <option value='Tjekket ind'>Tjekket ind</option>
                                        <option value='Forsinket'>Tjekket ind (Forsinket)</option>
                                        <option value='Tjekket ud'>Tjekket ud</option>
                                    </select>
                                    </th>
                                    <th>Bemærkning</th>
                                    <th>Handlinger</th>
                                    </tr>
                                </thead>
                                <tbody id="holderTable">
                                    
                                </tbody>
                                </table>
                                <h4 class="text-center" style="font-weight: bold;">Inaktive Elever</h4>
                                <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                    <th>Navn</th>
                                    <th>Seneste indtjekning</th>
                                    <th>Status</th>
                                    <th>Handlinger</th>
                                    </tr>
                                </thead>
                                <tbody id="holderTable2">
                                    
                                    
                                </tbody>
                                </table> 
                            <br />
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
