<?php
use Editiel98\SmartyMKD;
use Editiel98\Autoloader;

require 'classes/Autoloader.php';
Autoloader::register();
session_start();
$smarty = new SmartyMKD();


$smarty->assign('accueil','accueil');

$smarty->display('index.tpl');

?>