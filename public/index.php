<?php
use Editiel98\Autoloader;
use Editiel98\App;

session_start();
require __DIR__ . '/../src/classes/Autoloader.php';
Autoloader::register();
$app=new App();
$app->run();  
?>