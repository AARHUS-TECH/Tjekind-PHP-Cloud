<?php 
/**
 * Beskrivelse kommer snarest
 *
 * @author      Benjamin Jørgensen <bj@dunkstormen.dk>
 * @author 		Karsten Reitan Sørensen <krs@aarhustech.dk>
 * @copyright   Aarhus Tech SKP 2017-2023
 */

require_once('../config/init.php');

if (Session::exists('userID')) {
    Session::delete('userID');
    Session::flash('home_success', 'Du blev logget ud!');
    Redirect::to('/');
}