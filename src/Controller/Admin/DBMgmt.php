<?php

namespace App\Controller\Admin;

use Editiel98\App;
use Editiel98\Manager\DBManager;
use Editiel98\Router\Controller;
use Editiel98\Services\CSRFCheck;
use Exception;

class DBMgmt extends Controller
{
    private array $updateFiles = [];
    private CSRFCheck $csrfCheck;

    public function render()
    {
        if (App::ADMIN === $this->userRank) {
            $this->csrfCheck = new CSRFCheck($this->session);
            $this->smarty->assign('adminDB_menu', 'true');
            $this->loadUpdateFiles();
            //If form, do
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $this->doPost();
            }
            //Load updates
            $this->displayPage();
        } else {
            $this->smarty->assign('accueil', 'accueil');
            $this->smarty->display('index.tpl');
        }
    }

    private function displayPage(mixed $details = null,?array $done=[])
    {
        if (!is_null($details)) {
            $this->smarty->assign('versionFile', $details->version);
            $this->smarty->assign('descVersion', $details->description);
            $this->smarty->assign('stepSQL', $details->code);
        }
        $dbManager = new DBManager($this->dbConnection);
        $dbVersion = $dbManager->getCurrentVersion();
        $appVersion = App::VERSION;
        $token=$this->csrfCheck->createToken();
        $this->smarty->assign('token',$token);
        $this->smarty->assign('arrayResult',$done);
        $this->smarty->assign('listUpdate', $this->updateFiles);
        $this->smarty->assign('appVersion', $appVersion);
        $this->smarty->assign('dbVersion', $dbVersion);
        $this->smarty->display('admin/bdMgmt.tpl');
        die();
    }

    private function loadUpdateFiles()
    {
        $baseDir = __DIR__ . '/../../upgrade/';
        $scandir = scandir($baseDir);
        foreach ($scandir as $file) {
            $path_parts = pathinfo($file);
            if (($file !== '.' && $file !== '..' && $path_parts['extension'] === 'json')) {
                $this->updateFiles[] = $file;
            }
        }
    }

    private function doPost()
    {
        if (!empty($_POST['action'])) {
            switch ($_POST['action']) {
                case 'show':
                    $config = $this->loadUpdates($_POST['version']);
                    if ($config) {
                        $this->session->setKey('fileVersion', $_POST['version']);
                        $this->displayPage($config);
                    }
                    break;
                case 'update':
                    $this->updateDb();
                    break;
            }
        }
        header('Location: /admin_database');
         die();
    }

    private function loadUpdates(string $fileName): mixed
    {
        try {
            if (!file_exists(__DIR__ . '/../../upgrade/' . $fileName)) {
                return false;
            }
            $content = file_get_contents(__DIR__ . '/../../upgrade/' . $fileName);
            $config = json_decode($content);

            return $config;
        } catch (Exception $e) {
            return false;
        }
    }

    private function updateDb()
    {
        if(empty($_POST['token'])) {
            return false;
        }
        $token=$_POST['token'];
        if(!$this->csrfCheck->checkToken($token)){
           return false;
        }
        $file = $this->session->getKey('fileVersion');
        $updates = $this->loadUpdates($file);
        if (!$updates) {
            return false;
        }
        $dbManager = new DBManager($this->dbConnection);
        $sqlStrings = $updates->code;
        $result=[];
        foreach ($sqlStrings as $line) {
            try {
                $sql=$line->SQL;
                $desc=$line->description;
                $status="ERROR";
                $resulstDb=$dbManager->updateDb($sql);
                if($resulstDb){
                    $status='OK';
                }
                $result[]=array('desc'=>$desc,'status'=>$status);
            } catch (Exception $e) {
                $result[]=array('desc'=>$desc,'status'=>$e->getMessage());
            }
        }
        $this->displayPage(done:$result);
    }
}
