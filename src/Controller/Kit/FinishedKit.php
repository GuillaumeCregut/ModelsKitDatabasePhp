<?php

namespace App\Controller\Kit;

use Editiel98\Manager\ModelManager;
use Editiel98\Router\Controller;

class FinishedKit extends Controller
{
    private int $count = 0;
    private array $models = [];
    public function render()
    {
        if (!$this->isConnected) {
            //Render antoher page and die
            $this->smarty->assign('kits', 'kits');
            $this->smarty->display('kit/notconnected.tpl');
            die();
        }
        $modelManager = new ModelManager($this->dbConnection);
        $models = $modelManager->getFinishedModels($this->userId);
        $this->models = $models;
        $this->count = count($models);
        $this->displayPage();
    }

    private function displayPage()
    {
        $this->smarty->assign('countKit', $this->count);
        $this->smarty->assign('dataList', $this->models);
        $this->smarty->assign('finished_menu', true);
        $this->smarty->assign('kits', true);
        $this->smarty->display('kit/finished.tpl');
    }
}
