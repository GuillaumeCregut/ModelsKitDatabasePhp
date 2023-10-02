<?php
use Editiel98\Autoloader;
use Editiel98\App;
use Editiel98\Auth\DbAuth;

session_start();
require '../src/classes/Autoloader.php';
Autoloader::register();
$app=new App();
$app->run();  //remettre
//En dessous à supprimer
// $dbAuth=new DbAuth();
// try{
// $user=$dbAuth->login('gcregut','MUSTANG');
// }
// catch(PDOException $e){
//     echo "titi";
// }


//Fin de suppression
?>