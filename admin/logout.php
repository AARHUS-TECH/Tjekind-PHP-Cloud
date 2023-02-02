<?php
require_once('../config/init.php');

if (Session::exists('userID')) {
    Session::delete('userID');
    Session::flash('home_success', 'Du blev logget ud!');
    Redirect::to('/');
}