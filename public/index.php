<?php
use Editiel98\Autoloader;
use Editiel98\App;

session_start();
require '../src/classes/Autoloader.php';
Autoloader::register();
$app=new App();
$app->run();  //remettre
//En dessous à supprimer




//Fin de suppression
?>