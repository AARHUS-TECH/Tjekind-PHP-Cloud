<?php 
	class User {

		private $_db;
		public $sorting;
		public $sortdirection;

		function __construct() {
			$this->_db = new Database();
			$this->sorting = 'fornavn'; //Default query by name
			$this->sortdirection = 'ASC'; //Default query ascending
		}

		function setSorting($s) {
			$this->sorting = $s;
		}
		
		function setSortdirection($d) {
			$this->sortdirection = $d;
		}

		/**
		 *  Tjek om den pågældende bruger eksisterer
		 *
		 *  @param $value Brugerens userID, magnetstribe eller brugernavn
		 *
		 *  @return boolean 
		 */
		public function exists($value) {
			// Tjek om $value har en værdi
			if(!empty($value)) {

				// Tjek om $value er numerisk
				if(is_numeric($value)) {
					
					// Difiner userID i data arrayet
					$data = array(
						'userID' => $value
					);
				
				// Tjek om $value er en streng
				} else if(is_string($value)) {
					// Tjek om $value indeholder "æ" og om "æ" er på første posistion
					$value = substr($value, 0, 11);
					if(preg_match('^[A-Z0-9]{2}-[A-Z0-9]{2}-[A-Z0-9]{2}-[A-Z0-9]{2}$', $value)) {

						// Difiner magnetstribe i data arrayet
						$data = array(
							'magnetstribe' => $value
						);

						// Hvis $value ikke er et userID eller strengen fra magnetstriben bliver det betraget som et brugernavn
					} else {

						// Difiner brugernavn i data arrayet
						$data = array(
							'brugernavn' => $value
						);

					}
				}

				// Sender data queryet til databasen, hvor svaret bliver gemt i variablet $result
				$result = $this->_db->check_exist('tjekind_brugere', $data);

				// Returner resultatet i variablet $result
				return $result;
			}

			return false;
		}

		/**
		 *  Opret en ny elev i systemet
		 *
		 *  @param $fornavn		 Elevens fornavn og mellemnavn(e)
		 *  @param $efternavn	   Elevens efternavn
		 *  @param $magnetstribe	Strengen fra elevens tjek ind kort
		 *
		 */
		public function opretElev($fornavn, $efternavn, $magnetstribe) {
			// Tjek om alle felter er udfyldte
			if(!empty($fornavn) && !empty($efternavn) && !empty($magnetstribe)) {

				// Tjek om der allerede eksistere en bruger med samme magnetstribe
				if($this->exists($magnetstribe)) {

					// Sender en fejl besked til instruktøren og sender ham/hende tilbage til opretElev.php
					Session::flash('admin_error', 'Der eksisterer allerede en bruger med den valgte studiekort!');
					Redirect::to('/admin/opretElev.php');
				}
				
				// Difiner de data der skal indsættes i databasen i data arrayet
				$data = array(
					'fornavn'		   	=> $fornavn,
					'efternavn'		 	=> $efternavn,  
					'magnetstribe'	  	=> $magnetstribe,
					'magnet_crypt'	   	=> hash('sha256', $magnetstribe),
					'user_level'		=> '0',
					'iSKP'			  	=> '0',
					'bemning' => NULL
				);
	
				// Indsætter den nye elev i databasen
				$this->_db->insert('tjekind_brugere', $data);
				Session::flash('admin_success', 'Eleven <b>' . $fornavn . ' ' . $efternavn . '</b> blev registreret i systemet!' );
				Redirect::to('/admin/opretElev.php');
			} else {
				// Sender en fejl besked til instruktøren
				Session::flash('admin_error', 'Alle felter skal udfyldes!');
				Redirect::to('/admin/opretElev.php');
			}
		}


		/**
		 *  Opret en ny instruktør i systemet
		 *
		 *  @param $fornavn			Instruktørens fornavn og mellemnavn(e)
		 *  @param $efternavn		Instruktørens efternavn
		 *  @param $magnetstribe	Strengen fra instruktørens medarbejder kort
		 *  @param $brugernavn	  	Instruktørens brugernavn
		 *  @param $password		Instruktørens adgangskode
		 *
		 */
		public function opretInstruktoer($fornavn, $efternavn, $brugernavn, $password, $magnetstribe) {
			// Tjekker om alle felter er udfyldt
			if(!empty($fornavn) && !empty($efternavn) && !empty($brugernavn) && !empty($password) && isset($magnetstribe)) {
				
				// Tjekker om der allerede eksistere en bruger med den valgte magnetstribe
				if($this->exists($magnetstribe)) {

					// Sender en fejl besked til instruktøren og sender ham/hende tilbage til opretInstruktoer.php
					Session::flash('admin_error', 'Der eksisterer allerede en bruger med den valgte magnetstribe!');
					Redirect::to('/admin/opretInstruktoer.php');
				}
	
				// Tjekker om der allerede eksistere en bruger med det valgte brugernavn
				if($this->exists($brugernavn)) {

					// Sender en fejl besked til instruktøren og sender ham/hende tilbage til opretInstruktoer.php
					Session::flash('admin_error', 'Der eksisterer allerede en bruger med det valgte brugernavn!');
					Redirect::to('/admin/opretInstruktoer.php');
				}
				
				// Difiner de data der skal indsættes i databasen i data arrayet 
				$data = array(
					'fornavn'		   	=> $fornavn,
					'efternavn'		 	=> $efternavn,
					'brugernavn'		=> $brugernavn,
					'password'		  	=> $password,
					'magnetstribe'	  	=> $magnetstribe,
					'magnet_crypt'	   	=> hash('sha256', $magnetstribe),
					'user_level'		=> '1',
					'iSKP'			  	=> '0'
				);
	
				// Indsætter den nye instruktør i databasen
				$this->_db->insert('tjekind_brugere', $data);
				Session::flash('admin_success', 'Instruktøreren <b>' . $fornavn . ' ' . $efternavn . '</b> blev registreret i systemet!' );
				Redirect::to('/admin/dashboard.php?instruktoerPopUp=ja');
			} else {
				// Sender en fejl besked til instruktøren
				Session::flash('admin_error', 'Alle felter skal udfyldes!');
				Redirect::to('/admin/opretInstruktoer.php');
			}
		}


		public function update($userID, $fornavn, $efternavn, $brugernavn, $password = null, $magnetstribe, $iSKP, $bemning = null) {
			if(!$password == null) {
				$data = array(
					'fornavn'		   => $fornavn,
					'efternavn'		   => $efternavn,
					'brugernavn'	   => $brugernavn,
					'password'		   => password_hash($password, PASSWORD_BCRYPT),
					'magnetstribe'	   => $magnetstribe,
					'magnet_crypt'	   => hash('sha256', $magnetstribe),
					'iSKP'			   => $iSKP,
					'bemning'		   => $bemning
				);
			} else {
				$data = array(
					'fornavn'		   => $fornavn,
					'efternavn'		   => $efternavn,
					'brugernavn'	   => $brugernavn,
					'magnetstribe'	   => $magnetstribe,
					'magnet_crypt'	   => hash('sha256', $magnetstribe),
					'iSKP'			   => $iSKP,
					'bemning'		   => $bemning
				);
			}
			
			$sql = "SELECT user_level FROM tjekind_brugere WHERE userID=?";
			$bindings = array($userID);
			$result = $this->_db->custom_query($sql, $bindings);
			foreach ($result as $row){
				$user_level = $row->user_level;
			}

			$this->_db->update('tjekind_brugere', $data, 'userID', $userID);
			Session::flash('admin_success', 'Du redigerede brugeren <b>' . $data['fornavn'] . ' ' . $data['efternavn'] . '</b>!');
			if ($user_level == 1){
				Redirect::to('/admin/dashboard.php?instruktoerPopUp=ja');
			}

			if ($iSKP != 1){
				//Scroller ned til SKP eleven som er redigeret
				Redirect::to('/admin/dashboard.php?y='.$_REQUEST['y'].'&filter='.$_REQUEST['filter']);
			}
			
			if ($iSKP == 1){
				//Scroller ned til ikke-SKP eleven som er redigeret
				Redirect::to('/admin/dashboard.php?y='.$_REQUEST['y'].'&filter='.$_REQUEST['filter'].'&inactiveElev=checked');
			}
		}


		public function delete($id) {
			$this->_db->delete('tjekind_brugere', 'id', $id);
		}


		public function auth() {

			if(Input::get('studiekort') || Input::get('brugernavn')) {

				if(Input::get('studiekort')) {
					//Sikrer at det kun er bestemte enheder som kan give adgang til bruger log in_array
					//Findes i init.php
					if(//!isset($_COOKIE['whitelistip']) && 
						($_SERVER['REMOTE_ADDR'] != Config::get('info/tjekind_pc_ip'))
					) 
					{
						//Session::ajaxResp('danger', 'Det er <b>IKKE</b> tilladt at tjekke ind/ud fra egen enhed!');
						Session::flash('index_error', 'Det er <b>IKKE</b> tilladt at tjekke ind/ud fra egen enhed!');
						Redirect::to('/');
					}

					$studiekort = substr(Input::get('studiekort'), 0, 11);
					if(preg_match('/^[A-Z0-9]{2}-[A-Z0-9]{2}-[A-Z0-9]{2}-[A-Z0-9]{2}$/', $studiekort)) {
						$this->login(hash('sha256',Input::get('studiekort')));
					} else {
						//Session::ajaxResp('danger', 'Det brugte kort er ugyldigt!');
						Session::flash('index_error', 'Det brugte kort er ugyldigt!');
						Redirect::to('/');
					}

				} else if(Input::get('brugernavn')) {
					$this->login(Input::get('brugernavn'), Input::get('adgangskode'));
				}
			}
		}


		private function login($value1, $value2 = null) {
			if(!$value2) {

				$sql = "SELECT userID, status, fornavn, efternavn, tjekind_timestamp FROM tjekind_brugere WHERE magnet_crypt=? LIMIT 1";
				$bindings = array($value1);

				$result = $this->_db->custom_query($sql, $bindings);

				foreach($result as $row) {

					$userID = $row->userID;
					$status = $row->status;
					$fornavn = $row->fornavn;
					$efternavn = $row->efternavn;
					$tjekind = $row->tjekind_timestamp;
				}

				//Sikrer at det kun er bestemte enheder som kan give adgangn til bruger log in_array
				//Findes i init.php
				if(//!isset($_COOKIE['whitelistip']) &&
					($_SERVER['REMOTE_ADDR'] != Config::get('info/tjekind_pc_ip'))
				)
				{
					//Session::ajaxResp('danger', 'Det er <b>IKKE</b> tilladt at tjekke ind/ud fra egen enhed!');
					Session::flash('index_error', 'Det er <b>IKKE</b> tilladt at tjekke ind/ud fra egen enhed!');
					Redirect::to('/');
				}

				if( empty($userID) ) {
					//Session::ajaxResp('danger', 'Det brugte kort er ikke registreret i systemet!');
					Session::flash('index_error', 'Det brugte kort er ikke registreret i systemet!');
					Redirect::to('/');
				}

				if($this->isAdmin($userID)) {
					$_SESSION['userID'] = $userID;
					Redirect::to('/admin/dashboard.php');
				} else {
					$_SESSION['userID'] = $userID;
					if($status == 1 && $this->isTjekUdAllowed($userID)) {
						$this->createLogSlut($userID); //Laver historik på tjek ud
						Redirect::to('/elev/?status=0');
					} else if ($status == 2 && $this->isTjekUdAllowed($userID)) {
						$this->createLogSlut($userID); //Laver historik på tjek ud
						Redirect::to('/elev/?status=0');
					} else if ($status == 0 && $this->isTjekIndAllowed($userID)) {
						$this->createLogStart($userID); //Laver historik på tjek ind
						Redirect::to('/elev/?status=1');
					} else if($status == 0 && date('Hi') >= '1430') {
						//Session::ajaxResp('danger', '<b>' . $fornavn . ' ' . $efternavn . '</b> er allerede tjekket ud!');
						Session::flash('index_error', '<b>' . $fornavn . ' ' . $efternavn . '</b> er allerede tjekket ud!');
						Redirect::to('/');
					} else if($status == 0 && date('Hi') > '830') {
						//Session::ajaxResp('danger', '<b>' . $fornavn . ' ' . $efternavn . '</b> skal kontakte sin instruktør for at blive tjekket ind!');
						Session::flash('index_error', '<b>' . $fornavn . ' ' . $efternavn . '</b> skal kontakte sin instruktør for at blive tjekket ind!');
						Redirect::to('/');
					} else if($status == 1 && date('Hi') < '830') {
						//Session::ajaxResp('danger', '<b>' . $fornavn . ' ' . $efternavn . '</b> er allerede tjekket ind!');
						Session::flash('index_error', '<b>' . $fornavn . ' ' . $efternavn . '</b> er allerede tjekket ind!');
						Redirect::to('/');
					} else if($status == 1 || $status == 2 && date('Hi') >= '830') {
						if(date('D') != 'Fri') {
							$tjekUd = strtotime(Config::get('tjek_ud/ts'), strtotime($tjekind));
							
							if(date('Hi', $tjekUd) < '1500') {
								$tjekUd = strtotime('15:00');
							} else if ( (date('Hi', $tjekUd) > '1600') && $status == 2 ) {
								$tjekUd = strtotime('16:00');
							}
						} else {
							$tjekUd = strtotime(Config::get('tjek_ud/ts_fredag'), strtotime($tjekind));
							
							if(date('Hi', $tjekUd) < '1430') {
								$tjekUd = strtotime('14:30');
							} else if ( (date('Hi', $tjekUd) > '1530') && $status == 2 ) {
								$tjekUd = strtotime('15:30');
							}
						}
						
						//Session::ajaxResp('danger', '<b>' . $fornavn . ' ' . $efternavn . '</b> kan først tjekke ud kl. ' . date('H:i', $tjekUd) . '!');
						Session::flash('index_error', '<b>' . $fornavn . ' ' . $efternavn . '</b> kan først tjekke ud kl. ' . date('H:i', $tjekUd) . '!');
						Redirect::to('/');
					} else {
						Redirect::to('/elev/');
					}

				}
			} else {
				$sql = "SELECT userID, password, status FROM tjekind_brugere WHERE brugernavn=? LIMIT 1";
				$bindings = array($value1);

				$result = $this->_db->custom_query($sql, $bindings);
				
				foreach($result as $row) {
					$userID = $row->userID;
					$passwd = $row->password;
				}

				if(empty($userID)) {
					Session::flash('admin_login_error', 'Det brugte brugernavn og adgangskode er ikke registreret i systemet!');
					Redirect::to('/admin');
				}

				if(password_verify($value2, $passwd)) {
					if($this->isAdmin($userID)) {
						$_SESSION['userID'] = $userID;
						Redirect::to('/admin/dashboard.php');
					}
				} else {
					Session::flash('admin_login_error', 'Det brugte brugernavn og adgangskode er ikke registreret i systemet!');
					Redirect::to('/admin');
				}
			}
		}
		
		
		/********************************************//**
		 * @name		createLogStart()
		 * @param		userID
		 * @description	
		 ***********************************************/
		public function createLogStart($userID) {
			$sqlTjekindBrugere = "SELECT * FROM tjekind_brugere WHERE userID=?";
			$bindings = array($userID);

			$resultTjekindBrugere = $this->_db->custom_query($sqlTjekindBrugere, $bindings);
			foreach ($resultTjekindBrugere as $row){
				$fornavn = $row->fornavn;
				$efternavn = $row->efternavn;
				$start = $row->tjekind_timestamp;
			}
			
			$sql = "SELECT * FROM tjekind_historik";
			$result = $this->_db->custom_query($sql);
			foreach ($result as $row){
				if ($userID != $row->userID && $start != $row->start || $userID == $row->userID && $start != $row->start){
					$sqlInsert = "INSERT INTO tjekind_historik (userID, fornavn, efternavn, start) VALUES ('$userID', '$fornavn', '$efternavn','$start')";
				} else {
					$sqlUpdate = "UPDATE tjekind_historik SET userID='$userID', fornavn='$fornavn', efternavn='$efternavn', start='$start' WHERE userID='$userID' AND start='$start'";
				}
			}
			
			if ($userID != $row->userID && $start != $row->start || $userID == $row->userID && $start != $row->start){
				$this->_db->custom_query($sqlInsert);
			} else {
				$this->_db->custom_query($sqlUpdate);
			}
			
		}
		
		/********************************************//**
		 * @name		createLogSlut()
		 * @param		userID
		 * @description	
		 ***********************************************/		
		public function createLogSlut($userID) {
			$sqlTjekudBrugere = "SELECT * FROM tjekind_brugere WHERE userID=?";
			$bindings = array($userID);
			$resultTjekudBrugere = $this->_db->custom_query($sqlTjekudBrugere, $bindings);
			foreach ($resultTjekudBrugere as $row){
				$fornavn = $row->fornavn;
				$efternavn = $row->efternavn;
				$start = $row->tjekind_timestamp;
				$slut = date('Y-m-d H:i:00');
			}

			$sql = "SELECT * FROM tjekind_historik";
			$result = $this->_db->custom_query($sql);

			foreach ($result as $row){
				if ($userID != $row->userID && $start != $row->start || $userID == $row->userID && $start != $row->start){
					$sqlInsert = "INSERT INTO tjekind_historik (userID, fornavn, efternavn, start, slut) VALUES ('$userID', '$fornavn', '$efternavn', '$start', '$slut')";
					
				} else {
					$sqlUpdate = "UPDATE tjekind_historik SET slut='$slut' WHERE userID='$userID' AND start='$start'";

				}
			}
			if ($userID != $row->userID && $start != $row->start || $userID == $row->userID && $start != $row->start){
				$this->_db->custom_query($sqlInsert);
			} else {
				$this->_db->custom_query($sqlUpdate);
			}
		}


		public function changeStatus($userID, $status) {
			switch($status) {
				case '0':
					$data = array(
						'status' => '0'
					);

					$this->_db->update('tjekind_brugere', $data, 'userID', $userID);
					break;
				case '1':
					$data = array(
						'status' => '1'
					);

					$this->_db->update('tjekind_brugere', $data, 'userID', $userID);
					break;
				case '2':
					$data = array(
						'status' => '2'
					);

					$this->_db->update('tjekind_brugere', $data, 'userID', $userID);
					break;
			}
		}

		public function isAdmin($userID) {
			$data = array(
				'userID' => $userID,
				'user_level' => '1'
			);

			return $this->_db->check_exist('tjekind_brugere', $data);
		}

		public function getInfo($value) {
			if(is_numeric($value)) {
				$sql = "SELECT * FROM tjekind_brugere WHERE userID=?";
				$bindings = array($value);

				$result = $this->_db->custom_query($sql,$bindings);
				
				foreach($result as $row) {
					$userdata = array(
						'userID' => $row->userID,
						'fornavn' => $row->fornavn,
						'efternavn' => $row->efternavn,
						'fulde_navn' => $row->fornavn . ' ' . $row->efternavn,
						'brugernavn' => $row->brugernavn,
						'magnetstribe' => $row->magnetstribe,
						'status' => $row->status,
						'tjekind_timestamp' => $row->tjekind_timestamp,
						'user_level' => $row->user_level,
						'iSKP' => $row->iSKP,
						'bemning' => $row->bemning
					);
				}
				return $userdata;
			} else {
				die('Value given is not numeric! getInfo(> ! <)');
			}

		}


		public function getAllElever() {
			$sql = "SELECT * FROM tjekind_brugere WHERE user_level='0' AND iSKP='0' ORDER BY ".$this->sorting." ".$this->sortdirection;
			//echo "<script>console.log(\"$sql\")</script>";
	
			return $this->_db->custom_query($sql);
		}


		public function getAllNotActiveElever() {
			$sql = "SELECT * FROM tjekind_brugere WHERE user_level='0' AND iSKP='1' ORDER BY ".$this->sorting." ".$this->sortdirection;
			//echo "<script>console.log(\"$sql\")</script>";

			return $this->_db->custom_query($sql);
		}

		public function getAllInstruktoerer() {
			$sql = "SELECT * FROM tjekind_brugere WHERE user_level='1'";

			return $this->_db->custom_query($sql);
		}

		public function getStatusString($value) {
			switch($value) {
				case '0':
					$status = 'Tjekket ud';
					break;
				case '1':
					$status = 'Tjekket ind';
					break;
				case '2':
					$status = 'Tjekket ind (Forsinket)';
					break;
				default:
					$status = 'Ukendt';
			}

			return $status;
		}

		public function getStatusClass($value) {
			switch($value) {
				case '0':
					$status = 'text-bg-danger';
					break;
				case '1':
					$status = 'text-bg-success';
					break;
				case '2':
					$status = 'text-bg-warning';
					break;
				default:
					$status = 'text-bg-default';
			}

			return $status;
		}

		public function isTjekIndAllowed($userID) {
			$userdata = $this->getInfo($userID);
			
			if($userdata['status'] == 0) {
				if(date('Hi') <= Config::get('tjek_ind/max')) {
					return true;
				} else {
					return false;
				}
			}
			return false;
		}

		public function isTjekUdAllowed($userID) {
			$userdata = $this->getInfo($userID);
			if(date('D') != 'Fri') {
				$tjekUdStamp = strtotime(Config::get('tjek_ud/ts'), strtotime($userdata['tjekind_timestamp']));
			} else {
				$tjekUdStamp = strtotime(Config::get('tjek_ud/ts_fredag'), strtotime($userdata['tjekind_timestamp']));
			}

			if($userdata['status'] == 1 || $userdata['status'] == 2) {
				if(date('D') != 'Fri') {
					if(date('Hi') >= Config::get('tjek_ud/min') && time() >= $tjekUdStamp || date('Hi') >= Config::get('tjek_ud/max')){
						return true;
					} else {
						return false;
					}
				} else {
					if(date('Hi') >= Config::get('tjek_ud/min_fredag') && time() >= $tjekUdStamp|| date('Hi') >= Config::get('tjek_ud/max_fredag')) {
						return true;
					} else {
						return false;
					}
				}
			}
			return false;
		}

		public function tjekInd($userID, $time = null) {

			//KRS 19-09-2018: Hvis eleven tjekker ind, skal bemærkning fjernes og vedkommende skal blive aktiv
			if($time) {
				$data = array(
					'status'			=> '1',
					'tjekind_timestamp' => date('Y-m-d H:i:00', $time),
					'bemning'			=> NULL,
					'iSKP'				=> '0'
				);
			} else {
				$data = array(
					'status'			=> '1',
					'tjekind_timestamp' => date('Y-m-d H:i:00'),
					'bemning'			=> NULL,
					'iSKP'				=> '0'
				);
			}
			$this->_db->update('tjekind_brugere', $data, 'userID', $userID);
			$this->createLogStart($userID); //Laver historik på tjek ind
		}

		public function tjekIndForsinket($userID, $timer = null, $minuter = null) {
			if($timer){
				if ($minuter >= 55){ //Hvis du kommer forsent, skal tidspunktet rundes op til nærmeste 5 minut. så hvis vi er ved 55, skal minuterne gå til 00, og timen + 1
					$intTimer = $timer+1;
					$minuter = 00;
					$tid = "$intTimer".':'."$minuter";
				} 
				if ($minuter <= 54){ //pluser minutet med 5 da vi skal runde 5 minuter op. Så minuser vi det med modulo "(originale minuter) % 5"
					$intMinuter = $minuter + 5 - $minuter%5;
					$tid = "$timer".':'."$intMinuter";
				}

				$data = array(
					'status'			=> '2',
					'tjekind_timestamp' => date('Y-m-d ').$tid,
					'bemning'			=> NULL,
					'iSKP'				=> '0'
				);
			} else {
				echo "<script>console.log(if virker ikke - timer:$timer minuter: $minuter);</script>";
				$data = array(
				'status'			=> '2',
				'tjekind_timestamp' => date('Y-m-d H:i:00', time())
				);
			}
			$this->_db->update('tjekind_brugere', $data, 'userID', $userID);
			$this->createLogStart($userID); //Laver historik på tjek ind
		} 
		public function tjekUd($userID, $time = null ) {
			$data = array(
				'status'			=> '0'
			);

			$this->_db->update('tjekind_brugere', $data, 'userID', $userID);
			//$this->createLogSlut($userID); //Laver historik på tjek ud
		}

		public function elevControls($userID, $currentStatus) {
			switch($currentStatus) {
				case '0':
					if($this->isTjekIndAllowed($userID)) {
						$response = '<a class="btn btn-success" href="?status=1" style="width: 40%;">Tjek ind</a>';
					} else {
						$response = '<a class="btn btn-success disabled" style="width: 40%;">Tjek ind</a>';
					}
					break;
				case '1':
					if($this->isTjekUdAllowed($userID)) {
						$response = '<a class="btn btn-danger" href="?status=0" style="width: 40%;">Tjek ud</a>';
					} else {
						$response = '<a class="btn btn-danger disabled" style="width: 40%;">Tjek ud</a>';
					}
					break;
				case '2':
					if($this->isTjekUdAllowed($userID)) {
						$response = '<a class="btn btn-danger" href="?status=0" style="width: 40%;">Tjek ud</a>';
					} else {
						$response = '<a class="btn btn-danger disabled" style="width: 40%;">Tjek ud</a>';
					}
					break;
			}
			return $response;
		}

		public function instruktoerControls($userID) {
			$controlData = $this->getInfo($userID);
			
			switch($controlData['status']) {
				case '0':
					if (date('Hi') > Config::get('tjek_ind/max')) {
						$result  = '<a class="btn btn-success btn-full-width disabled">Tjek eleven ind</a>';
						$result .= '<div style="padding-bottom: 10px;"></div>';
						$result .= '<a class="btn btn-warning btn-full-width" href="?id=' . $userID . '&status=2&y='.$_REQUEST['y'].'">Tjek eleven ind (Forsinket)</a>';
						$result .= '<div style="padding-bottom: 10px;"></div>';
						$result .= '<a class="btn btn-danger btn-full-width disabled">Tjek eleven ud</a>';
					} else {
						$result  = '<a class="btn btn-success btn-full-width" href="?id=' . $userID . '&status=1&y='.$_REQUEST['y'].'">Tjek eleven ind</a>';
						$result .= '<div style="padding-bottom: 10px;"></div>';
						$result .= '<a class="btn btn-warning btn-full-width" href="?id=' . $userID . '&status=2&y='.$_REQUEST['y'].'">Tjek eleven ind (Forsinket)</a>';
						$result .= '<div style="padding-bottom: 10px;"></div>';
						$result .= '<a class="btn btn-danger btn-full-width disabled">Tjek eleven ud</a>';
					}
					
					break;
				case '1':
					$result  = '<a class="btn btn-success btn-full-width disabled">Tjek eleven ind</a>';
					$result .= '<div style="padding-bottom: 10px;"></div>';
					$result .= '<a class="btn btn-warning btn-full-width disabled">Tjek eleven ind (Forsinket)</a>';
					$result .= '<div style="padding-bottom: 10px;"></div>';
					$result .= '<a class="btn btn-danger btn-full-width" href="?id=' . $userID . '&status=0&y='.$_REQUEST['y'].'">Tjek eleven ud</a>';
					break;
				case '2':
					$result  = '<a class="btn btn-success btn-full-width disabled">Tjek eleven ind</a>';
					$result .= '<div style="padding-bottom: 10px;"></div>';
					$result .= '<a class="btn btn-warning btn-full-width disabled">Tjek eleven ind (Forsinket)</a>';
					$result .= '<div style="padding-bottom: 10px;"></div>';
					$result .= '<a class="btn btn-danger btn-full-width" href="?id=' . $userID . '&status=0&y='.$_REQUEST['y'].'">Tjek eleven ud</a>';
					break;
			}
			return $result;
		}
	}
