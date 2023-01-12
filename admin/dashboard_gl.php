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

$filter   = ( isset($_REQUEST['filter']) && $_REQUEST['filter']!='' )?$_REQUEST['filter']:0;
$y        = ( isset($_REQUEST['y'])      && $_REQUEST['y']!='')?$_REQUEST['y']:0;

?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Tjek ind | Aarhus Tech SKP</title>

		<link rel="stylesheet" type="text/css" href="/assets/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="/assets/css/custom.css">
		<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css">
	</head>
	<body onload="refreshTable();">
		<div class="container-fluid">
			<div class="row">
				<div class="col" style="margin-top: 50px;">
					<div class="card card-default">

						<?php //echo Errors::getErrorMessage('admin_error'); ?>
						<?php //echo Errors::getSuccessMessage('admin_success'); ?>

						<div id="splash" class="card-body">
							<h3 class="text-center" style="font-variant: small-caps;">Oversigt - Instruktør</h3>
							<!-- h6 class="text-center"><strong>Logget ind som:</strong><?php echo $userdata['fulde_navn']; ?></h6 -->
							<br />
							<center>
								<div class="btn-group" role="group" aria-label="instructorOverview">
									<a class="btn btn-success" href="opretElev.php?y=<?php echo $y.'&filter='.$filter; ?>" type="button" class="btn btn-secondary">Opret elev</a>
									<a 
										class="btn btn-success" 
										id="inactivebtn" 
										href="#multiCollapseInactiveStudents" 
										data-toggle="collapse" 
										type="button" 
										aria-expanded="false" 
										aria-controls="multiCollapseExample1" 
										class="btn btn-secondary" 
									>Vis inaktive</a>
									<a class="btn btn-success" href="opretInstruktoer.php?y=<?php echo $y.'&filter='.$filter; ?>" type="button" class="btn btn-secondary">Opret instruktør</a>
									<a 
										class="btn btn-success" 
										id="instructor" 
										data-toggle="collapse" 
										href="#multiCollapseInstructor" 
										type="button" 
										aria-expanded="false" 
										aria-controls="multiCollapseExample1"
									>Vis instruktør</a>
									<a class="btn btn-success" href="logout.php" type="button" class="btn btn-secondary">Log ud</a>
								</div>
							</center>
							<br />
							<div class="row">
								<div class="col">
									<div class="collapse multi-collapse" id="multiCollapseInstructor">
										<div class="card card-body">
											<h4 class="text-center" style="font-weight: bold;">Instruktører&nbsp;
												<a 
													id="eye_close" 
													data-toggle="collapse" 
													href="#multiCollapseInstructor" 
													role="button" 
													aria-expanded="false" 
													aria-controls="multiCollapseExample1"
												>
												<svg style="height: 20px;width: 20px;color: #EBEBEB;margin-bottom: -3px;" aria-hidden="true" data-prefix="far" data-icon="eye-slash" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" class="svg-inline--fa fa-eye-slash fa-w-18">
													<path fill="currentColor" d="M272.702 359.139c-80.483-9.011-136.212-86.886-116.93-167.042l116.93 167.042zM288 392c-102.556 0-192.092-54.701-240-136 21.755-36.917 52.1-68.342 88.344-91.658l-27.541-39.343C67.001 152.234 31.921 188.741 6.646 231.631a47.999 47.999 0 0 0 0 48.739C63.004 376.006 168.14 440 288 440a332.89 332.89 0 0 0 39.648-2.367l-32.021-45.744A284.16 284.16 0 0 1 288 392zm281.354-111.631c-33.232 56.394-83.421 101.742-143.554 129.492l48.116 68.74c3.801 5.429 2.48 12.912-2.949 16.712L450.23 509.83c-5.429 3.801-12.912 2.48-16.712-2.949L102.084 33.399c-3.801-5.429-2.48-12.912 2.949-16.712L125.77 2.17c5.429-3.801 12.912-2.48 16.712 2.949l55.526 79.325C226.612 76.343 256.808 72 288 72c119.86 0 224.996 63.994 281.354 159.631a48.002 48.002 0 0 1 0 48.738zM528 256c-44.157-74.933-123.677-127.27-216.162-135.007C302.042 131.078 296 144.83 296 160c0 30.928 25.072 56 56 56s56-25.072 56-56l-.001-.042c30.632 57.277 16.739 130.26-36.928 171.719l26.695 38.135C452.626 346.551 498.308 306.386 528 256z" class=""></path>		
												</svg>
												</a>
											</h4>
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
														echo '<td><a class="btn btn-outline-white" href="/admin/redigerInstruktoer.php?id=' . $row->userID . '&y='.$y.'&filter='.$filter.'">Rediger</a></td>';
														echo '</tr>';
													}
												?>
												</tr>
											</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
							<br />
							<div class="row">
							<div class="col">
							<div class="card card-body">
							<h4 class="text-center" style="font-weight: bold;">Aktive Elever</h4>
							<table id="elevTable" class="table table-hover" unselectable="on" onselectstart="return false">
								<thead>
									<tr>
										<th style="width: 30%;">Navn&nbsp;
											<a id="namesort" role="button" onclick="sort='fornavn';sortDir();">
											
											<svg id="name_asc" aria-hidden="false" data-prefix="fas" data-icon="angle-up" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" class="svg-inline--fa fa-angle-up fa-w-10" style="display: inline-block; width: 13px; margin: 0px; padding: 0px; vertical-align: middle; margin-left: 5px;">
												<path fill="currentColor" d="M177 159.7l136 136c9.4 9.4 9.4 24.6 0 33.9l-22.6 22.6c-9.4 9.4-24.6 9.4-33.9 0L160 255.9l-96.4 96.4c-9.4 9.4-24.6 9.4-33.9 0L7 329.7c-9.4-9.4-9.4-24.6 0-33.9l136-136c9.4-9.5 24.6-9.5 34-.1z" class=""></path>
											</svg>
											
											<svg id="name_desc" aria-hidden="true" data-prefix="fas" data-icon="angle-down" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" class="svg-inline--fa fa-angle-down fa-w-10" style="display: none; width: 13px;margin: 0px;padding: 0px;vertical-align: middle;margin-left: 5px;">
												<path fill="currentColor" d="M143 352.3L7 216.3c-9.4-9.4-9.4-24.6 0-33.9l22.6-22.6c9.4-9.4 24.6-9.4 33.9 0l96.4 96.4 96.4-96.4c9.4-9.4 24.6-9.4 33.9 0l22.6 22.6c9.4 9.4 9.4 24.6 0 33.9l-136 136c-9.2 9.4-24.4 9.4-33.8 0z" class=""></path>
											</svg>
											
											</a>
										</th>
										<th style="width: 20%;">Seneste indtjekning&nbsp;
											<a id="datesort" role="button" onclick="sort='tjekind_timestamp';sortDir();">
											
											<svg id="date_asc" aria-hidden="true" data-prefix="fas" data-icon="angle-up" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" class="svg-inline--fa fa-angle-up fa-w-10" style="display: inline-block;width: 13px;margin: 0px;padding: 0px;vertical-align: middle;margin-left: 5px;">
												<path fill="currentColor" d="M177 159.7l136 136c9.4 9.4 9.4 24.6 0 33.9l-22.6 22.6c-9.4 9.4-24.6 9.4-33.9 0L160 255.9l-96.4 96.4c-9.4 9.4-24.6 9.4-33.9 0L7 329.7c-9.4-9.4-9.4-24.6 0-33.9l136-136c9.4-9.5 24.6-9.5 34-.1z" class=""></path>
											</svg>

											<svg id="date_desc" aria-hidden="true" data-prefix="fas" data-icon="angle-down" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" class="svg-inline--fa fa-angle-down fa-w-10" style="display: none; width: 13px;margin: 0px;padding: 0px;vertical-align: middle;margin-left: 5px;">
												<path fill="currentColor" d="M143 352.3L7 216.3c-9.4-9.4-9.4-24.6 0-33.9l22.6-22.6c9.4-9.4 24.6-9.4 33.9 0l96.4 96.4 96.4-96.4c9.4-9.4 24.6-9.4 33.9 0l22.6 22.6c9.4 9.4 9.4 24.6 0 33.9l-136 136c-9.2 9.4-24.4 9.4-33.8 0z" class=""></path>
											</svg>											
												
											</a>
										</th>
										<th style="width: 18%;">
											<div style="display: inline-block">
												<div style="display: inline-flex;">Status</div>
												<div style="display: inline-flex;">
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
										<th class="bmning" style="width: 22%">Bemærkning</th>
										<th style="width: 10%;">Handlinger</th>
									</tr>
								</thead>
								<tbody id="holderTable">
									
								</tbody>
							</table>
							</div>
							</div>
							</div>
								<div id="inactive"></div>
								<div class="row">
									<div class="col">
										<div class="collapse multi-collapse" id="multiCollapseInactiveStudents">
											<div class="card card-body">
												<h4 class="text-center" style="font-weight: bold;">Inaktive Elever&nbsp;
													<a 
														id="eye_close" 
														data-toggle="collapse" 
														href="#multiCollapseInactiveStudents" 
														role="button" 
														aria-expanded="false" 
														aria-controls="multiCollapseExample1"
													>
														<svg style="height: 20px;width: 20px;color: #EBEBEB;margin-bottom: -3px;" aria-hidden="true" data-prefix="far" data-icon="eye-slash" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" class="svg-inline--fa fa-eye-slash fa-w-18">
															<path fill="currentColor" d="M272.702 359.139c-80.483-9.011-136.212-86.886-116.93-167.042l116.93 167.042zM288 392c-102.556 0-192.092-54.701-240-136 21.755-36.917 52.1-68.342 88.344-91.658l-27.541-39.343C67.001 152.234 31.921 188.741 6.646 231.631a47.999 47.999 0 0 0 0 48.739C63.004 376.006 168.14 440 288 440a332.89 332.89 0 0 0 39.648-2.367l-32.021-45.744A284.16 284.16 0 0 1 288 392zm281.354-111.631c-33.232 56.394-83.421 101.742-143.554 129.492l48.116 68.74c3.801 5.429 2.48 12.912-2.949 16.712L450.23 509.83c-5.429 3.801-12.912 2.48-16.712-2.949L102.084 33.399c-3.801-5.429-2.48-12.912 2.949-16.712L125.77 2.17c5.429-3.801 12.912-2.48 16.712 2.949l55.526 79.325C226.612 76.343 256.808 72 288 72c119.86 0 224.996 63.994 281.354 159.631a48.002 48.002 0 0 1 0 48.738zM528 256c-44.157-74.933-123.677-127.27-216.162-135.007C302.042 131.078 296 144.83 296 160c0 30.928 25.072 56 56 56s56-25.072 56-56l-.001-.042c30.632 57.277 16.739 130.26-36.928 171.719l26.695 38.135C452.626 346.551 498.308 306.386 528 256z" class=""></path>		
														</svg>
													</a>
												</h4>
								<table class="table table-hover">
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
								</div>
								</div>
								</div>
							</div>
							<br />
							<center>
								<p class="text-center">&copy; Aarhus Tech SKP <?php echo date('Y'); ?><br/>Udviklet af elever og instruktører SKP Data IT</p>
							</center>
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
		
		<script>
			var y=<?php echo ($_REQUEST['y'])?$_REQUEST['y']:0; ?>;
			var inactive=<?php echo ($_REQUEST['inactive'])?$_REQUEST['inactive']:0; ?>;
			var scroll_once=false;
			var del = false;
			var inactive = false;
			var sort='fornavn';
			var sortdirection='ASC';
			var filter = <?php echo $filter; ?>;
			var urlactive;
			var urlinactive;
			

			$(document).ready(function(){
				
				$("#inactivebtn").click(
					function(){
						//Set timer to wait for expanding script to end
						var expandTimer = setInterval(myTimer, 500);

						function myTimer() {
							//Use a toggle switch as indicator for expanding script status
							if ($("#inactivebtn").attr("aria-expanded") == "true") {
								//Scroll into view when done expanding
								//document.getElementById("inactive").scrollIntoView(true);
								document.getElementById("inactive").scrollIntoView({behavior: "instant", block: "start", inline: "nearest"});
								
								clearInterval(expandTimer);
							}
						}		
					}
				);
				
				$("#eye_close").click(
					function(){
						//Set timer to wait for expanding script to end
						var expandTimer = setInterval(myTimer, 500);

						function myTimer() {
							//Use a toggle switch as indicator for expanding script status
							if ($("#eye_close").attr("aria-expanded") == "false") {
								//Scroll into view when done expanding
								document.body.scrollTop = 0; // For Safari
								document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
								clearInterval(expandTimer);
							}
						}		
					}
				);

		
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
				url='/admin/redigerElev.php?id='+id+'&y='+window.pageYOffset+'&filter='+status;
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


			function flipfilter(filter) {
			/* 1. value='all' 			Alle
			   2. value='Tjekket ind' 	Tjekket ind
			   3. value='Forsinket' 	Tjekket ind (Forsinket)
			   4. value='Tjekket ud' 	Tjekket ud
			   */
			   
			   //alert();
			   filterval   = ['all','Tjekket ind','Forsinket','Tjekket ud'];
			   filtercolor = ['white','green','orange','red'];
			   //filter = (++filter >= filterval.length)?0:filter;
			   //console.log( 'filter; '+filter );
			   
			   document.forms[0]['filter'].value = filter;
			   //document.getElementById('filterbullet').style.color = filtercolor[filter];
			   filterText();
			}
			
</script -->  
		</script>
		<style>
			@media (max-width: 800px) {
			}
			
			@media (max-width: 769px) {
				/*background: url(/assets/images/background.jpg) no-repeat top left fixed;*/
				/*background-size: contain;*/
				
				/*.container {
					width: 100%;
					padding-right: 15px;
					padding-left: 15px;
					margin-right: auto;
					margin-left: auto;
				}*/
			}
		</style>
	</body>
</html>
