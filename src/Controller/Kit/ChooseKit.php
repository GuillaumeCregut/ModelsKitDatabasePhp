<?php

namespace App\Controller\Kit;

use Editiel98\App;
use Editiel98\Flash;
use Editiel98\Manager\ModelManager;
use Editiel98\Manager\UserManager;
use Editiel98\Router\Controller;

class ChooseKit extends Controller
{
    private $model=null;
    public function render()
    {
        if (!$this->isConnected) {
            //Render antoher page and die
            $this->smarty->assign('kits', 'kits');
            $this->smarty->display('kit/notconnected.tpl');
            die();
        }
        if(!empty($_POST)){
            $this->usePost();
        }
        if($this->flash->hasFlash()){
            $flashes=$this->flash->getFlash();
            $this->smarty->assign('flash',$flashes);
        }
        $this->displayPage();
    }

    private function displayPage()
    {
        if(!is_null($this->model)){
            $this->smarty->assign('kitSelected',$this->model);
        }
        $this->smarty->assign('choose_menu', true);
        $this->smarty->assign('kits', true);
        $this->smarty->display('kit/choose.tpl');
    }

    private function usePost(){
        if(!isset($_POST['action']))
            return false;
        switch($_POST['action']){
            case 'random': $this->getModel();
                break;
            case 'add-wip': $this->changeStateModel();
                break;
            default: return;
        }
    }

    private function getModel()
    {
        $userManager=new UserManager($this->dbConnection);
        $this->model=$userManager->getRandomKit($this->userId);
    }

    private function changeStateModel()
    {
        if(!isset($_POST['id']) || intval($_POST['id'])===0){
            return;
        }
        $id=$_POST['id'];
        $modelManager=new ModelManager($this->dbConnection);
        $result=$modelManager->changeUserModelState($id,App::STATE_WIP,$this->userId);
        $flash=new Flash();
        if($result){
            $flash->setFlash('Modèle ajouter à votre atelier',Flash::FLASH_SUCCESS);
        }else{
            $flash->setFlash('Une erreur est survenue',Flash::FLASH_ERROR);
        }
    }
}
