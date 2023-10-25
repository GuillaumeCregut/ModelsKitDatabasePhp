<?php

namespace App\Controller;

use Editiel98\Session;
use Editiel98\SmartyMKD;
use Exception;
use PDO;
use PDOException;

class Init
{
    private SmartyMKD $smarty;
    private string $user;
    private string $host;
    private string $name;
    private string $pass;
    private $pdo;

    public function render()
    {
        $this->loadCredentials();
        $init = false;
        //vérifie si la base est initialisée
        try {
            $this->pdo = new PDO('mysql:dbname=' . $this->name . ';host=' . $this->host, $this->user, $this->pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "<p>Connexion base OK</p>";
        } catch (PDOException $e) {
            echo "Erreur à la connexion à la base de données, vérifiez vos informations";
            die();
        }
        //si non, initialise la base
        $query = "SELECT * FROM system_mkd";
        try {
            $st =$this->pdo->query($query);
            $init=true;
        } catch (PDOException $e) {
            $errCode = intVal($e->getCode());
            if ($errCode === 42) {
                $init = false;
            } else{
                echo $e->getMessage();
                die();
            } 
        }
        if($init){
            $datas = $st->fetchAll(PDO::FETCH_OBJ);
            $dbInit=$datas[0];
            if($dbInit->value===1){
                echo "<p>Le système a déja été initialisé</p>";
                die();
            }
            //Ici on a la base de créée, mais init vaut 0.
            if(empty($_POST)){
                $this->smarty=new SmartyMKD();
                $this->smarty->display('init.tpl');
                die();
            }
            //ici le post est rempli, on vérifie si les informations sont bien rentrées
            if(!isset($_POST[''])){
                echo "<p>Veuillez remplir le formulaire</p>";
                die();
            }
        }
        //Ici, la base n'est pas crée, on la créée.
        echo "<p>Base non initialisée</p>";
        //Une fois la base crée avec succès

        //On affiche un lien pour recharger la page et afficher le formulaire

        

    }

    private function loadCredentials()
    {
        try {
            $config = simplexml_load_file(__DIR__ . '/../config.xml');
            if ($config === false) {
                throw new Exception('Impossible de lire les credentials');
            }
            $this->user = $config->database->login;
            $this->pass = $config->database->pass;
            $this->name = $config->database->name;
            $this->host = $config->database->host;
        } catch (Exception $e) {
            //Echec de lecture du fichier init
            echo "erreur init";
        }
    }
}
