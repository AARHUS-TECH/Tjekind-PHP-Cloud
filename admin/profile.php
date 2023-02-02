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

?><!DOCTYPE html>
<html lang="da">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tjek ind | Aarhus Tech SKP</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="/assets/css/custom.scss">
    <link rel="stylesheet" type="text/css" href="/assets/css/mobile.scss">
</head>

<body>
<p>Profile page</p>
</body>

</html>