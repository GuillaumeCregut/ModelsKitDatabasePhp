<?php
namespace App\Controller;

use Editiel98\Manager\ModelManager;
use Editiel98\Manager\UserManager;
use Editiel98\Router\Controller;

class ContactOwner extends Controller
{
    private int $modelId=0;

    public function render()
    {
        if(!$this->isConnected){
            $this->smarty->assign('connected',true);
            $this->smarty->display('403.tpl');
            die();
        }
        if(empty($_GET['id']) || intval($_GET['id'])===0)
        {
            header('Location: /');
        }
        $this->modelId=intval($_GET['id']);
        if ($_SERVER['REQUEST_METHOD']==='POST'){
            $this->doPost();
        }
        $this->displayPage();
    }

    private function displaypage(): void
    {
        $this->smarty->assign('params','params');
        $this->smarty->assign('modelId',$this->modelId);
        $this->smarty->display('params/contactOwner.tpl');
    }

    private function doPost() {
        echo "titi";
        //Get all users own this kit
        $modelManager=new ModelManager($this->dbConnection);
        $owners=$modelManager->findOwner($this->modelId);
        var_dump($owners);
        $userManager=new UserManager($this->dbConnection);
        $user=$userManager->findById($this->userId);
        var_dump($user);
        echo $user->getEmail();
    }
}