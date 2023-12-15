<?php

namespace App\Controller\Admin;

use Editiel98\App;
use Editiel98\Manager\DBManager;
use Editiel98\Router\Controller;

class DBMgmt extends Controller
{
    public function render()
    {
        if (App::ADMIN === $this->userRank) {
            $this->smarty->assign('adminDB_menu', 'true');
            //Get all Logs
            $dbManager = new DBManager($this->dbConnection);
            $dbVersion = $dbManager->getCurrentVersion();
            var_dump($dbVersion);
            $appVersion = App::VERSION;
            $this->smarty->assign('appVersion',$appVersion);
            $this->smarty->assign('dbVersion',$dbVersion);
            $this->smarty->display('admin/bdMgmt.tpl');
        } else {
            $this->smarty->assign('accueil', 'accueil');
            $this->smarty->display('index.tpl');
        }
    }

    public function loadUpdates()
    {
        //Récupérer la liste des fichiers updates

        //Lire chaque fichier et retourner celui avec la version en cours de l'application
        //Sous forme d'objet XML
    }
}
