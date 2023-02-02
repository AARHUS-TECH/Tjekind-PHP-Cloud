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


$userdata     = $user->getInfo(Session::get('userID'));
$filter       = ( isset($_REQUEST['filter']) && $_REQUEST['filter']!='' )?$_REQUEST['filter']:0;
$y            = ( isset($_REQUEST['y'])      && $_REQUEST['y']!='')?$_REQUEST['y']:0;
$inactiveElev = ( isset($_REQUEST['inactiveElev']) && $_REQUEST['inactiveElev']!='')?$_REQUEST['inactiveElev']:'unchecked';

//Tjek ind og tjek ud for dashboard ikoner
//if($_REQUEST['status'] == 0 && isset($_GET['status'])) 
//if(isset($_GET['status'])) virker

if(!empty($_REQUEST['status']) == 0 && isset($_GET['status'])) 
{
	$user->tjekUd($_REQUEST['id']);
	Session::flash('admin_success', 'Du tjekkede eleven ud!');
	Redirect::to('/admin/dashboard.php?y='.$_REQUEST['y'].'&filter='.$_REQUEST['filter']);
}
else if(isset($_REQUEST['status']) == 1) 
{
	if (date('Hi') > Config::get('tjek_ind/max'))
	{
		$user->tjekIndForsinket($_REQUEST['id'], date('H'), date('i'));
		Session::flash('admin_success', 'Du tjekkede eleven ind, og markerede dem som værende kommet forsent!');
		Redirect::to('/admin/dashboard.php?y='.$_REQUEST['y'].'&filter='.$_REQUEST['filter']);
	}
	if (date('Hi') < Config::get('tjek_ind/max')){
		$user->tjekInd($_REQUEST['id'], time());
		Session::flash('admin_success', 'Du tjekkede eleven ind!');
		Redirect::to('/admin/dashboard.php?y='.$_REQUEST['y'].'&filter='.$_REQUEST['filter']);
	}
}
//Nasty workaround, gotta fix the shit over this from line 22.
// error_reporting(E_ALL ^ E_NOTICE);

require_once( TEMPLATES. 'html_head.php');
?>	
	<body onload="refreshTable();">
		<div class="container-fluid dashboard-mobile">
			<div class="row">
				<div class="col">
					<nav class="navbar navbar-expand-lg bg-light">
						<div class="container-fluid">
							<a class="navbar-brand" href="#">Navbar</a>
							<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
								<span class="navbar-toggler-icon"></span>
							</button>
							<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
								<div class="navbar-nav">
									<a class="nav-item nav-link active" href="#">Forsiden <span class="sr-only">(current)</span></a>
									<a class="nav-item nav-link disabled" href="profile.php">Profile</a>
									<a class="nav-item nav-link" href="opretElev.php?y=<?php echo $y.'&filter='.$filter; ?>">Opret elev</a>
									<!-- begin: Knap som trigger modal vindue til input for kort data
									HTML koden til modal vindue findes længere nede efterfulgt
									af JavaScript koden. Benytter ajaxResponse.php og
									funtionen ajaxGetData($cardnumber) i User.php -->
									<a class="nav-item nav-link" href="#" data-bs-toggle="modal" data-bs-target="#exampleModal">Tjek kort</a>
									<a class="btn btn-success" href="logout.php" type="button" style="margin-top: 15px;">Log ud</a>
								</div>
							</div>
						</div>
					</nav>
				</div>
			</div>
			<div class="row">
				<div class="col">
					<?php echo Errors::getErrorMessage('admin_error'); ?>
					<?php echo Errors::getSuccessMessage('admin_success'); ?>

					<div class="accordion" id="accordionPanelsStayOpenExample">
						<div class="accordion-item">
							<h2 class="accordion-header" id="panelsStayOpen-headingOne">
								<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
									Aktive Elever
								</button>
							</h2>
							<div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
								<div class="accordion-body">
									<div style="text-align: center;">
									<div id="statusFilterHalvSkaerm" style="display: inline-flex; padding-top: 5px; padding-bottom: 10px;">
										<div id="filterbullet" onclick="flipfilter('all');" style="color: white;">
											<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="width: 12px; margin-left: 5px;">
												<path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z"/>
											</svg>
										</div>

										<div id="filterbullet" onclick="flipfilter('Tjekket ind');" style="color: green; display: inline-block;">
											<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="width: 12px; margin-left: 5px;">
												<path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z"/>
											</svg>
										</div>

										<div id="filterbullet" onclick="flipfilter('Forsinket');" style="color: orange; display: inline-block;">
											<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="width: 12px; margin-left: 5px;">
												<path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z"/>
											</svg>
										</div>

										<div id="filterbullet" onclick="flipfilter('Tjekket ud');" style="color: red; display: inline-block;">
											<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="width: 12px; margin-left: 5px;">
												<path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z"/>
											</svg>
										</div>
									</div>
									</div>
									<table id="elevTable" class="table table-hover" unselectable="on" onselectstart="return false">
										<thead class="dashboard-mobile">
											<tr>
												<th style="width: 30%;">Navn&nbsp;
													<a id="namesort" role="button" onclick="sort='fornavn';sortDir();">
														<svg id="name_asc" aria-hidden="false" data-prefix="fas" data-icon="angle-up" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" class="svg-inline--fa fa-angle-up fa-w-10" style="display: inline-block; width: 13px; margin: 0; padding: 0px; vertical-align: middle; margin-left: 5px;">
															<path fill="currentColor" d="M177 159.7l136 136c9.4 9.4 9.4 24.6 0 33.9l-22.6 22.6c-9.4 9.4-24.6 9.4-33.9 0L160 255.9l-96.4 96.4c-9.4 9.4-24.6 9.4-33.9 0L7 329.7c-9.4-9.4-9.4-24.6 0-33.9l136-136c9.4-9.5 24.6-9.5 34-.1z" class=""></path>
														</svg>
														<svg id="name_desc" aria-hidden="true" data-prefix="fas" data-icon="angle-down" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" class="svg-inline--fa fa-angle-down fa-w-10" style="display: none; width: 13px;margin: 0px;padding: 0px;vertical-align: middle;margin-left: 5px;">
															<path fill="currentColor" d="M143 352.3L7 216.3c-9.4-9.4-9.4-24.6 0-33.9l22.6-22.6c9.4-9.4 24.6-9.4 33.9 0l96.4 96.4 96.4-96.4c9.4-9.4 24.6-9.4 33.9 0l22.6 22.6c9.4 9.4 9.4 24.6 0 33.9l-136 136c-9.2 9.4-24.4 9.4-33.8 0z" class=""></path>
														</svg>
													</a>
												</th>
												<th style="width: 20%; white-space: nowrap;">Seneste indtjekning&nbsp;
													<a id="datesort" role="button" onclick="sort='tjekind_timestamp';sortDir();">
														<svg id="date_asc" aria-hidden="true" data-prefix="fas" data-icon="angle-up" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" class="svg-inline--fa fa-angle-up fa-w-10" style="display: inline-block;width: 13px;margin: 0px;padding: 0px;vertical-align: middle;margin-left: 5px;">
															<path fill="currentColor" d="M177 159.7l136 136c9.4 9.4 9.4 24.6 0 33.9l-22.6 22.6c-9.4 9.4-24.6 9.4-33.9 0L160 255.9l-96.4 96.4c-9.4 9.4-24.6 9.4-33.9 0L7 329.7c-9.4-9.4-9.4-24.6 0-33.9l136-136c9.4-9.5 24.6-9.5 34-.1z" class=""></path>
														</svg>
														<svg id="date_desc" aria-hidden="true" data-prefix="fas" data-icon="angle-down" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" class="svg-inline--fa fa-angle-down fa-w-10" style="display: none; width: 13px;margin: 0px;padding: 0px;vertical-align: middle;margin-left: 5px;">
															<path fill="currentColor" d="M143 352.3L7 216.3c-9.4-9.4-9.4-24.6 0-33.9l22.6-22.6c9.4-9.4 24.6-9.4 33.9 0l96.4 96.4 96.4-96.4c9.4-9.4 24.6-9.4 33.9 0l22.6 22.6c9.4 9.4 9.4 24.6 0 33.9l-136 136c-9.2 9.4-24.4 9.4-33.8 0z" class=""></path>
														</svg>											
													</a>
												</th>
												<th id='statusFuldSkaerm' style="width: 18%; vertical-align: top;">
													<div style="display: inline-block">
														<div style="display: inline-flex;">Status</div>
														<div style="display: inline-flex; padding-top: 3px;">
															<div id="filterbullet" onclick="flipfilter('all');" style="color: white;">
																<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="width: 12px; margin-left: 5px;">
																	<path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z"/>
																</svg>
															</div>
															
															<div id="filterbullet" onclick="flipfilter('Tjekket ind');" style="color: green; display: inline-block;">
																<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="width: 12px; margin-left: 5px;">
																	<path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z"/>
																</svg>
															</div>

															<div id="filterbullet" onclick="flipfilter('Forsinket');" style="color: orange; display: inline-block;">
																<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="width: 12px; margin-left: 5px;">
																	<path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z"/>
																</svg>
															</div>

															<div id="filterbullet" onclick="flipfilter('Tjekket ud');" style="color: red; display: inline-block;">
																<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="width: 12px; margin-left: 5px;">
																	<path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z"/>
																</svg>
															</div>
														</div>
													</div>

													<form><input id="filterText" name="filter" onchange='filterText()' type="hidden" value='all'></form>
												</th>
												<th class="bmning" style="width: 20%; padding-bottom: 14px;">Bemærkning
													<a id="question-filter" role="button">
														<img src="/assets/images/41443-200.png" style="width: 18px; height: 18px;" />
													</a>
												</th>
												<th style="width: 12%; padding-bottom: 14px; text-align: left; padding-left: 0px;">Handlinger</th>
											</tr>
										</thead>
										<tbody id="holderTable">
										</tbody>
									</table>
								</div>
							</div>
						</div>

						<div class="accordion-item">
							<h2 class="accordion-header" id="panelsStayOpen-headingTwo">
								<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
									Inaktive elever
								</button>
							</h2>
							<div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwo">
								<div class="accordion-body">
									<table class="table table-hover">
										<thead>
											<tr>
												<th>Navn</th>
												<th>Seneste indtjekning</th>
												<th>Status</th>
												<th>Handlinger</th>
											</tr>
										</thead>
				
										<tbody id='holderTable2'>
										</tbody>
									</table> 
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col">
					<div class="app-footer" style="text-align: center">
						<p class="text-center">&copy; Aarhus Tech SKP <?php echo date('Y'); ?><br/>Udviklet af elever og instruktører SKP Data IT</p>
					</div>
				</div>
			</div>

<?php require_once ('modalwindow.php') ?>
		
		<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>		<script src="/assets/js/dismiss-alerts.js"></script>
		<script src="/assets/js/sortlist.js"></script>
		
		<script>
			let y             = <?php echo (isset($_REQUEST['y']))?$_REQUEST['y']:0; ?>;
			let scroll_once   = false;
			let del           = false;
			let inactive      = false;
			let sort          ='fornavn';
			let sortdirection ='ASC';
			let filter        = '<?php echo isset($_REQUEST['filter'])?urldecode ( $_REQUEST['filter'] ):$filter; ?>';
			let urlactive;
			let urlinactive;

			$(document).ready(function(){
				var y=<?php echo isset($_REQUEST['y'])?$_REQUEST['y']:0; ?>;
				var instruktoerPopUp = "<?php echo isset($_REQUEST['instruktoerPopUp']); ?>";

				$("#name_asc").click(function(){
					$("#name_asc").hide();
					$("#name_desc").show();
				});

				$("#name_desc").click(function(){
					$("#name_asc").show();
					$("#name_desc").hide();
				});
				
				$("#date_asc").click(function(){
					$("#date_asc").hide();
					$("#date_desc").show();
				});

				$("#date_desc").click(function(){
					$("#date_asc").show();
					$("#date_desc").hide();
				});		
			});


			function doScroll() {
				if (y > 0 && scroll_once!=true) {
					//alert('Scroll y to:' + y);
					window.scrollBy(0, y);
					scroll_once=true;
				}
			}		

			
			function editStudent(id = 0, del = false){
				//var myIndex   = document.getElementById("filterText").selectedIndex;
				//var myOptions = document.getElementById("filterText").options;
				//var status    = myOptions[myIndex].index;
				
				// Using try-catch for iPad Chrome browser is fully supporting location.replace()
				url='/admin/redigerElev.php?id='+id+'&y='+window.pageYOffset+'&filter='+filter;
				try { window.location.replace(url); } 
				catch(e) { window.location = url; }
				
				//iOS Chrome Hack
				window.location.assign(url);
			}


			function editStudentIkon(id = 0, status){
				//var myIndex   = document.getElementById("filterText").selectedIndex;
				//var myOptions = document.getElementById("filterText").options;
				//var status    = myOptions[myIndex].index;
				
				// Using try-catch for iPad Chrome browser is fully supporting location.replace()
				url='/admin/dashboard.php?id='+id+'&y='+window.pageYOffset+'&filter='+filter+'&status='+status;
				try { window.location.replace(url); } 
				catch(e) { window.location = url; }
				
				//iOS Chrome Hack
				window.location.assign(url);
			}
			
				
			function sortDir() {
				//Toggle sorting direction and pick up empty value
				if (sortdirection === undefined || sortdirection=='') {
					sortdirection='ASC';
					//console.log('undefined');
				}
				else if (sortdirection=='ASC') {
					sortdirection='DESC';
					//console.log('else if');
				}
				else {
					sortdirection='ASC';
					//console.log('else');
				}
				
				//console.log('Sorting by '+sort+' '+sortdirection);
				refreshTable();
			}
			
			if (filter != 'all' && filter!= '') {
				flipfilter(filter);
			}


			function flipfilter(filter_val) {
			/* 1. value='all' 			Alle
			   2. value='Tjekket ind' 	Tjekket ind
			   3. value='Forsinket' 	Tjekket ind (Forsinket)
			   4. value='Tjekket ud' 	Tjekket ud
			   */
			   
			   //filterval   = ['all','Tjekket ind','Forsinket','Tjekket ud'];
			   //filtercolor = ['white','green','orange','red'];
			   
			   filter = encodeURI(filter_val);
			   console.log('var filter = '+filter);
			   document.forms[0]['filter'].value = filter_val;
			   filterText();
			}


			//Karsten: React to the ? button
			//
			$("#question-filter").click(function(){
				$(".content").hide();
				$(".show-question").show();
			});
		</script>
	</body>
</html>
