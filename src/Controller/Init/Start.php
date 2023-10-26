<?php

namespace App\Controller\Init;

use Editiel98\App;
use Editiel98\Auth\DbAuth;
use Editiel98\SmartyMKD;
use Exception;
use PDO;
use PDOException;

class Start
{
    private SmartyMKD $smarty;
    private string $user;
    private string $host;
    private string $name;
    private string $pass;
    private array $messages;
    private $pdo;

    public function __construct(array $subPages = [], array $params = [])
    {

        $this->smarty = new SmartyMKD();
    }

    public function render()
    {
        $this->loadCredentials();
        if (empty($_POST)) {
            $this->smarty = new SmartyMKD();
            $this->messages[] = "Veuillez remplir le formulaire";
            $this->displayPage();
        }
        if (
            !isset($_POST['firstname']) ||
            !isset($_POST['lastname']) ||
            !isset($_POST['email']) ||
            !isset($_POST['login']) ||
            !isset($_POST['password'])
        ) {
            $this->messages[] = "Veuillez remplir le formulaire";
            $this->displayPage();
        }
        try {
            $this->pdo = new PDO('mysql:dbname=' . $this->name . ';host=' . $this->host, $this->user, $this->pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->messages[] = "Connexion base OK";
        } catch (PDOException $e) {
            $this->messages[] = "Erreur à la connexion à la base de données, vérifiez vos informations";
            $this->displayPage();
        }
        $query = "SELECT * FROM system_mkd";
        try {
            $st = $this->pdo->query($query);
            $datas = $st->fetchAll(PDO::FETCH_OBJ);
            $dbInit = $datas[0];
            if ($dbInit->value === "1") {
                $this->messages[] = "Le système a déja été initialisé";
                $this->displayPage();
            }
        } catch (PDOException $e) {
            $this->messages[] = $e->getMessage();
            $this->displayPage();
        }
        $firstname = htmlspecialchars($_POST['firstname'], ENT_NOQUOTES, 'UTF-8');
        $lastname = htmlspecialchars($_POST['lastname'], ENT_NOQUOTES, 'UTF-8');
        $email = htmlspecialchars($_POST['email'], ENT_NOQUOTES, 'UTF-8');
        $login = htmlspecialchars($_POST['login'], ENT_NOQUOTES, 'UTF-8');
        $pass = $_POST['password'];
        try {
            $auth = new DbAuth();
            $isOK = $auth->signUp($login, $email, $firstname, $lastname, $pass,true,App::ADMIN);
            if ($isOK) {
                $this->messages[] = "Inscription effectuée";
                //set init to true in DB
                $queryInit = "UPDATE system_mkd SET value='1' WHERE name='init'";
                try {
                    $statement = $this->pdo->prepare($queryInit);
                    $statement->execute();
                } catch (PDOException $e) {
                    $this->messages[] = "Erreur : " . $e->getMessage();
                }
            } else {
                $this->messages[] = "Erreur à l'inscription";
            }
        } catch (Exception $e) {
            $this->messages[] = "Erreur : " . $e->getMessage();
        }
        $this->displayPage();
    }

    private function loadCredentials()
    {
        try {
            $config = simplexml_load_file(__DIR__ . '/../../config.xml');
            if ($config === false) {
                throw new Exception('Impossible de lire les credentials');
            }
            $this->user = $config->database->login;
            $this->pass = $config->database->pass;
            $this->name = $config->database->name;
            $this->host = $config->database->host;
        } catch (Exception $e) {
            //Echec de lecture du fichier init
            $this->messages[] = "erreur init";
        }
    }

    private function displayPage()
    {
        if (!empty($this->messages)) {
            $this->smarty->assign('messages', $this->messages);
            $this->smarty->display('start.tpl');
            die();
        }
    }
}
