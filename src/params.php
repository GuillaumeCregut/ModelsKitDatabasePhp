<?php
use Editiel98\SmartyMKD;
use Editiel98\Autoloader;

require 'classes/Autoloader.php';
Autoloader::register();
session_start();
$smarty = new SmartyMKD();



$smarty->assign('params','accueil');
/*$smarty->assign('firstname','accueil');
$smarty->assign('admin','accueil');
$smarty->assign('lastname','accueil');
$smarty->assign('logged_in','accueil');
$smarty->assign('loggedInAdmin','accueil');*/


$smarty->display('params/index.tpl');

?>