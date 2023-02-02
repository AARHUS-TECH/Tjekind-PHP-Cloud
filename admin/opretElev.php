<?php
require_once('../config/init.php');

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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$fornavn		= $_POST['fornavn'];
	$efternavn	  = $_POST['efternavn'];
	$magnetstribe   = $_POST['magnetstribe'];
	
	$user->opretElev($fornavn, $efternavn, $magnetstribe);
}
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
	</head>
	<body>
		<div class="container">
			<div class="row">
                <div class="col-md-10 offset-1" style="margin-top: 50px;">
					<div class="card card-default">
                        
						<div id="splash" class="card-body">
							<h3 class="text-center">OPRET ELEV</h3>
							<!-- h5 class="text-center"><strong>Logget ind som:</strong> <?php echo $userdata['fulde_navn']; ?></h5 -->
							<br />
							<div class="row">
								<div class="col-md-11 offset-1">
									<form class="form-horizontal" method="post" style="padding-top: 21px;">
										<fieldset>
											<div class="form-group">
											<label for="inputFornavn" class="col-lg-6 control-label">Fornavn(e)</label>
											<div class="col-lg-10">
												<input type="text" class="form-control" id="inputFornavn" name="fornavn" placeholder="Steffen">
											</div>
											</div>
											<div class="form-group">
											<label for="inputEfternavn" class="col-lg-6 control-label">Efternavn</label>
											<div class="col-lg-10">
												<input type="text" class="form-control" id="inputEfternavn" name="efternavn" placeholder="Sørensen">
											</div>
											</div>
											<div class="form-group">
											<label for="inputMagnetstribe" class="col-lg-6 control-label">Chip kode</label>
											<div class="col-lg-10">
												<input type="password" class="form-control" id="inputMagnetstribe" name="magnetstribe" placeholder="æ123_">
											</div>
											</div>
				                            <div class="form-group">
                                            <div class="col-lg-10 col-lg-offset-2">
                                                <button type="submit" class="btn btn-success">Opret elev</button>
                                                <button type="reset" class="btn btn-danger">Nulstil</button>
                                                <a class="btn btn-danger" href="/admin/dashboard.php">Tilbage</a>
                                            </div>
                                            </div>
										</fieldset>
										</form>
									</div>
								</div>
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
	</body>
</html>
