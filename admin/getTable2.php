<?php
require_once('../config/init.php');

$user = new User();
if( isset($_REQUEST['sort']) )
	$user->sorting=$_REQUEST['sort'];

if( isset($_REQUEST['sortdirection']) )
	$user->sortdirection=$_REQUEST['sortdirection'];

$data  = $user->getAllNotActiveElever();

foreach($data as $row) {
	if ($row->tjekind_timestamp > 0) {
		$time = date('H:i - j F, Y', strtotime($row->tjekind_timestamp));
	} else {
		$time = 'Mangler første tjek ind!';
	}

	$status = $user->getStatusString($row->status);
	$statusClass = $user->getStatusClass($row->status);
	
	echo '<tr class="' . $statusClass . '">';
	echo '<td>' . $row->fornavn . ' ' . $row->efternavn . '</td>';
	echo '<td>' . $time . '</td>';
	echo '<td>' . $status . '</td>';
	echo '<td>
			<a class="fas fa-user-edit" style="text-decoration: none; margin-right:0.2em; font-size:1.5em; line-height:0;" onclick="editStudent('.$row->userID.')" title="Rediger" ></a>
		 </td>';
	echo '</tr>';
}
?>
