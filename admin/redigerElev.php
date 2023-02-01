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

$userdata	   = $user->getInfo(Session::get('userID'));
$updatedata	 = $user->getInfo($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$userID		  = $_GET['id'];
	$fornavn	  = $_POST['fornavn'];
	$efternavn	  = $_POST['efternavn'];
	$brugernavn	  = '';
	$adgangskode  = '';
	$magnetstribe = $_POST['magnetstribe'];

	if(isset($_POST['iSKP'])) {
		if($_POST['iSKP'] == 'on') {
			$iSKP = '1';
		} else {
			$iSKP = '0';
		}
	} else {
		$iSKP = '0';
	}

	if(isset($_POST['bemning'])) {
		if($_POST['bemning'] === '') {
			$bemning = NULL;
		} else {
			$bemning = $_POST['bemning'];
		}
	} else {
		$bemning = NULL;
	}
	
	$user->update($userID, $fornavn, $efternavn, $brugernavn, $adgangskode, $magnetstribe, $iSKP, $bemning);
	Session::flash('admin_success', 'Du redigerede eleven <b>' . $fornavn . ' ' . $efternavn . '</b>!');
}

if(Input::get('status') == 0 && isset($_GET['status'])) {
	$user->tjekUd(Input::get('id'), time());
	Session::flash('admin_success', 'Du tjekkede eleven ud!');
	Redirect::to('/admin/dashboard.php?y='.$_REQUEST['y'].'&filter='.$_REQUEST['filter']);
} else if(Input::get('status') == 1) {
	$user->tjekInd(Input::get('id'), time());
	Session::flash('admin_success', 'Du tjekkede eleven ind!');
	Redirect::to('/admin/dashboard.php?y='.$_REQUEST['y'].'&filter='.$_REQUEST['filter']);
} else if(Input::get('status') == 2) {
	$user->tjekIndForsinket(Input::get('id'), date('H'), date('i'));
	Session::flash('admin_success', 'Du tjekkede eleven ind, og markerede dem som værende kommet forsent!');
	Redirect::to('/admin/dashboard.php?y='.$_REQUEST['y'].'&filter='.$_REQUEST['filter']);
}

if($updatedata['iSKP'] == 1) {
	$checked = 'checked';
} else {
	$checked = '';
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
	</head>s
	<body>
		<div class="container">
			<div class="row">
				<div class="col-md-8 offset-2" style="margin-top: 50px;">
					<div class="card card-default">

						<div id="splash" class="card-body">
							<h3 class="text-center">REDIGER ELEV</h3>
							<!-- h5 class="text-center"><strong>Logget ind som:</strong> <?php echo $userdata['fulde_navn']; ?></h5 -->
							<br />
							<div class="row">
								<div class="col-md-10 offset-1 center">
									<?php echo $user->instruktoerControls($_GET['id']); ?>
									<br /><br />
								</div>
								<div class="col-md-11 offset-1">
									<form class="form-horizontal" method="post">
										<fieldset>
											<div class="form-group">
											<label for="inputFornavn" class="col-lg-6 control-label">Fornavn(e)</label>
											<div class="col-lg-10">
												<input type="text" class="form-control" id="inputFornavn" name="fornavn" placeholder="angiv" value="<?php echo $updatedata['fornavn']; ?>">
											</div>
											</div>
											<div class="form-group">
											<label for="inputEfternavn" class="col-lg-6 control-label">Efternavn</label>
											<div class="col-lg-10">
												<input type="text" class="form-control" id="inputEfternavn" name="efternavn" placeholder="angiv" value="<?php echo $updatedata['efternavn']; ?>">
											</div>
											</div>
											<div class="form-group">
											<label for="inputMagnetstribe" class="col-lg-6 control-label">Chip kode</label>
											<div class="col-lg-10">
												<input type="password" class="form-control" id="inputMagnetstribe" name="magnetstribe" placeholder="xxxxxxxx" value="<?php echo $updatedata['magnetstribe']; ?>">
											</div>
											</div>
											<div class="form-group">
											<label for="inputBemning" class="col-lg-6 control-label">Bemærkning</label>
											<div class="col-lg-10">
												<select class="form-control" id="inputBemning" name="bemning">
													<?php
													$bm=$updatedata['bemning'];
													echo "<option value=''			    ".(($bm==null)?'selected':'').">Ingen bemærkning</option>";
													echo "<option value='Syg'		    ".(($bm=='Syg')?'Selected':'').">Syg</option>";
													echo "<option value='Ekstern Opgave'".(($bm=='Ekstern Opgave')?'selected':'').">Ekstern Opgave</option>";
													echo "<option value='Forsinket'     ".(($bm=='Forsinket')?'selected':'').">Forsinket</option>";
													echo "<option value='Job Samtale'   ".(($bm=='Job Samtale')?'selected':'').">Job Samtale</option>";
													echo "<option value='Andet'		    ".(($bm=='Andet')?'selected':'').">Andet</option>";
													echo "<option value='Datastue'		    ".(($bm=='Datastue')?'selected':'').">Datastue</option>";
													echo "<option value='Ulovlig fravær'".(($bm=='Ulovlig fravær')?'selected':'').">Ulovlig fravær</option>";
													echo "<option value='Ferie / Fridag'		    ".(($bm=='Ferie / Fridag')?'selected':'').">Ferie / Fridag</option>";
													echo "<option value='?'		        ".(($bm=='?')?'selected':'').">?</option>";
													?>
												</select>
											</div>
											</div>
											<div class="form-group">
											<label for="inputPassword" class="col-lg-6 control-label"></label>
											<div class="col-lg-10">
												<div class="checkbox">
												<label>
													<input type="checkbox" name="iSKP" <?php echo $checked; ?>> På HF / I praktik / Inaktiv
												</label>
												</div>
											</div>
											</div>
											<div class="form-group">
											<div class="col-lg-10 col-lg-offset-2">
												<?php 
												if ($checked == ''){
													echo '<button type="submit" class="btn btn-success">Opdatér elev</button>';
												}
												if ($checked == 'checked'){
													
													echo '<button type="submit" class="btn btn-success">Opdatér elev</button>';

												}
												?>
												<button type="reset" class="btn btn-danger">Nulstil</button>
												<?php 
												if ($checked == ''){
													echo "<a class='btn btn-danger' href='/admin/dashboard.php?y=". $_REQUEST['y'].'&filter='.$_REQUEST['filter']."'>Tilbage</a>";
												}
												if ($checked == 'checked'){
													echo "<a class='btn btn-danger' href='/admin/dashboard.php?y=". $_REQUEST['y'].'&filter='.$_REQUEST['filter'].'&inactiveElev='.$checked."'>Tilbage</a>";
												}
												?>
												
												<!-- Updatet 14-02-2020. Til at slette bruger. -->
												<?php $ass = $_GET['id']; ?>
												<a class='btn btn-danger' href="sletElev.php?userID=<?php echo $ass ?>" onclick="javascript: return confirm('Er du sikker på du ville gøre dette?');">Slet elev</a>
												<!-- /////////////////////////////-->
												
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
