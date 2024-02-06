<?php

namespace App\Controller;

use Editiel98\Database\DatabaseMake;
use Editiel98\Session;
use Editiel98\SmartyMKD;
use Exception;
use PDO;
use PDOException;


/**
 * Controller for init app
 */
class Init
{
    private SmartyMKD $smarty;
    private string $user;
    private string $host;
    private string $name;
    private string $pass;
    private array $messages;
    private $pdo;
    private array $subPages;
    private string $port;

    public function __construct(array $subPages = [], array $params = [])
    {
        $this->subPages = $subPages;
        $this->smarty = new SmartyMKD();
    }


    public function render()
    {
        if (!empty($this->subPages)) {
            $classPage = 'App\\Controller\\Init\\Start';
            $page = new $classPage([], []);
            $page->render();
        }
        $this->loadCredentials();
        $init = false;
        try {
            $this->pdo = new PDO('mysql:dbname=' . $this->name . ';host=' . $this->host . '; port=' . $this->port, $this->user, $this->pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->messages[] = "Connexion base OK";
        } catch (PDOException $e) {
            $this->messages[] = "Erreur à la connexion à la base de données, vérifiez vos informations";
            $this->displayPage();
            die();
        }
        $query = "SELECT * FROM system_mkd";
        try {
            $st = $this->pdo->query($query);
            $init = true;
        } catch (PDOException $e) {
            $errCode = intVal($e->getCode());
            if ($errCode === 42) {
                $init = false;
            } else {
                $this->messages[] = $e->getMessage();
                $this->displayPage();
                die();
            }
        }
        if ($init) {
            $datas = $st->fetchAll(PDO::FETCH_OBJ);
            $dbInit = $datas[0];
            if ($dbInit->value === "1") {
                $this->messages[] = "Le système a déja été initialisé";
                $this->displayPage();
                die();
            }
        }
        $this->smarty->assign('display_form', true);
        //Ici, la base n'est pas crée, on la créée.
        $this->messages[] = "Base non initialisée";
        $databaseMake = new DatabaseMake();
        $makeQueries = $databaseMake->getQueries();
        try {
            $this->messages[] = "Création de la base de données.";
            $this->pdo->exec('DROP DATABASE IF EXISTS ' . $this->name);
            $this->pdo->exec('CREATE DATABASE ' . $this->name);
            $this->pdo->exec('USE ' . $this->name);
            foreach ($makeQueries as $query) {
                $statement = $this->pdo->prepare($query);
                $statement->execute();
            }
            //Create database
            $this->messages[] = "Création de la base de données effectuée.";
        } catch (PDOException $e) {
            $this->messages[] = "Echec de création de la base : " . $e->getMessage();
        }
        //Une fois la base crée avec succès

        //On affiche un lien pour recharger la page et afficher le formulaire
        $this->displayPage();
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
            $this->port = $config->database->port;
        } catch (Exception $e) {
            //Echec de lecture du fichier init
            $this->messages[] = "erreur de lecture du fichier init";
        }
    }

    private function displayPage()
    {
        if (!empty($this->messages)) {
            $this->smarty->assign('messages', $this->messages);
            $this->smarty->display('init.tpl');
        }
    }
}
