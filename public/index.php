<?php
use Editiel98\Autoloader;
use Editiel98\App;
require '../src/classes/Autoloader.php';
Autoloader::register();
session_start();
$app=new App();
$app->run();


?>