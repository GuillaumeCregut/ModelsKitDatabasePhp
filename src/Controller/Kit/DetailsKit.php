<?php

namespace App\Controller\Kit;

use App\Controller\Error;
use Editiel98\Manager\ModelManager;
use Editiel98\Router\Controller;

class DetailsKit extends Controller
{
    public function render()
    {
        if (!$this->isConnected || !isset($_GET['id'])) {
            //Render antoher page and die
            $this->smarty->assign('kits', 'kits');
            $this->smarty->display('kit/notconnected.tpl');
            die();
        }
        $id=intval($_GET['id']);
        if($id===0){
            $page=new Error('404', 'le kit n\'existe pas');
            $page->render();
            die();
        }
        $modelManager=new ModelManager($this->dbConnection);
        $modelDetails=$modelManager->getOneFullById($id,$this->userId);
        if($modelDetails){
            $this->smarty->assign('model', $modelDetails);
        }
        $this->smarty->assign('kits', true);
        $this->smarty->display('kit/detail.tpl');
    }
}
