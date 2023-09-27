<?php
use Editiel98\SmartyMKD;
use Editiel98\Autoloader;

require 'classes/Autoloader.php';
Autoloader::register();

$smarty = new SmartyMKD();


$smarty->assign('name','Ned');

$smarty->display('index.tpl');

?>