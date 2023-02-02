<?php 
/**
 * Beskrivelse kommer snarest
 *
 * @author      Benjamin Jørgensen <bj@dunkstormen.dk>
 * @author 		Karsten Reitan Sørensen <krs@aarhustech.dk>
 * @copyright   Aarhus Tech SKP 2017-2023
 */

require_once('../config/init.php');

$y    = ( isset($_REQUEST['y']) && $_REQUEST['y']!='')?$_REQUEST['y']:0;
$user = new User();

if( isset($_REQUEST['sort']) )
	$user->sorting=$_REQUEST['sort'];

if( isset($_REQUEST['sortdirection']) )
	$user->sortdirection=$_REQUEST['sortdirection'];

$data  = $user->getAllElever();

foreach($data as $row) {
	if ($row->tjekind_timestamp > 0) {
		$time = date('H:i - j F, Y', strtotime($row->tjekind_timestamp));
	} else {
		$time = 'Mangler første tjek ind!';
	}

	$status = $user->getStatusString($row->status);
	$statusClass = $user->getStatusClass($row->status);
	
	//Karsten: Tjek de forskellige bemaærkninger. Vi vil gerne kunne filtrere på ukendte, noteret som '?'
	if ($row->bemning=='?') {
		$css_class='show-question';
	} else {
		$css_class='';
	}

	echo '<tr class="content ' . $statusClass . ' ' . $css_class . '">';
	echo '<td>' . $row->fornavn . ' ' . $row->efternavn . '</td>';
	echo '<td>' . $time . '</td>';
	echo '<td id="getTableStatus">' . $status . '</td>';
	

	
	echo '<td id="notes" class="show-notes bmning">' . $row->bemning . '</td>';

	echo '<td style="padding: 0px;">
			 <div style="display: inline-block">
				 <a title="Tjek ind" onclick="editStudentIkon('.$row->userID.', 1)"><img src="/assets/images/signIn.svg" style="width:2em; height:2em; padding-right:0.5em;"></a>
			 </div>	 
			 <div style="display: inline-block;">
				 <a title="Tjek ud" onclick="editStudentIkon('.$row->userID.', 0)"><img src="/assets/images/signOut.svg" style="width:2em; height:2em; padding-right:0.4em;"></a>
			 </div>
			 <div style="display: inline-block">
				 <a title="Rediger" onclick="editStudent('.$row->userID.')"><img src="/assets/images/editUser.svg" style="width:2em; height:2em;"></a>
			 </div>		 
		 </td>';
	echo '</tr>'; 
}

?>
