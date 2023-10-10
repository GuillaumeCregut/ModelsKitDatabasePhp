<?php
namespace App\Controller\Profil;

use Editiel98\Entity\User;
use Editiel98\Manager\UserManager;
use Editiel98\Router\Controller;
use Editiel98\Session;

class Invoice extends Controller
{
    private User $user;
    private array $providers;
    public  function render()
    {
        if(!$this->isConnected){
            //Render antoher page and die
            $this->smarty->assign('profil','profil');
            $this->smarty->display('profil/notconnected.tpl');
            die();
        }
        if(!empty($_POST)){
            $this->usePost();
        }
        $this->hasFlash=$this->flash->hasFlash();
        /* Render flashes messages */
        if($this->hasFlash){
            $flashes=$this->flash->getFlash();
            $this->smarty->assign('flash',$flashes);
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

    private function usePost(){
        var_dump($_POST);
    }

    private function displayPage()
    {
        //$this->smarty->assign('providers',$this->providers);
        $this->smarty->assign('profil','profil');
        $this->smarty->assign('bills_menu','profil');
        $this->smarty->display('profil/invoice.tpl');
    }
}