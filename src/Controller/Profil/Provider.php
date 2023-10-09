<?php
namespace App\Controller\Profil;

use Editiel98\App;
use Editiel98\Entity\User;
use Editiel98\Manager\UserManager;
use Editiel98\Router\Controller;
use Editiel98\Session;

class Provider extends Controller
{
    private User $user;
    private array $providers;
    public function render()
    {
        if(!$this->isConnected){
        //Render antoher page and die
            $this->smarty->assign('profil','profil');
            $this->smarty->display('profil/notconnected.tpl');
            die();
        }
        $this->getUser();
        //todo 
        $this->displayPage();
    }

    private function getUser()
    {
        $userId=$this->session->getKey(Session::SESSION_USER_ID);
        $userManager=new UserManager($this->dbConnection);
        $user=$userManager->findById($userId);
        $this->user=$user;
        $providers=$this->user->getProviders();
        $this->providers=$providers;
    }

    private function displayPage()
    {
        $this->smarty->assign('providers',$this->providers);
        $this->smarty->assign('profil','profil');
        $this->smarty->assign('provider_menu','profil');
        $this->smarty->display('profil/provider.tpl');
    }

}