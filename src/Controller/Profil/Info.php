<?php
namespace App\Controller\Profil;

use Editiel98\Entity\User;
use Editiel98\Manager\UserManager;
use Editiel98\Router\Controller;
use Editiel98\Session;

class Info extends Controller
{
    private User $user;
    public function render()
    {
        if(!$this->isConnected){
        //Render antoher page and die
            $this->smarty->assign('profil','profil');
            $this->smarty->display('profil/notconnected.tpl');
            die();
        }
        //todo
        if(!empty($_POST)){
            var_dump($_POST);
            $template=$this->usePost();
        }
        else $template='profil/info.tpl';
        $this->getUser();
        $this->displayPage($template);
    }

    private function usePost():string 
    {
        if(!isset($_POST['action']))
            return 'profil/info.tpl';
        $action=$_POST['action'];
        switch($action){
            case 'start-update': 
                return 'profil/update.tpl';
                break;
            case 'update':
                $this->updateUser();
                return 'profil/info.tpl';
                break;
            default : return 'profil/info.tpl';
        }
    }

    private function updateUser(): bool
    {
        return false;
    }

    private function getUser()
    {
        $userId=$this->session->getKey(Session::SESSION_USER_ID);
        $userManager=new UserManager($this->dbConnection);
        $user=$userManager->findById($userId);
        $this->user=$user;
    }

    private function displayPage(string $template)
    {
        $baseUrl='';
        if(!is_null($this->user->getAvatar())){
            $id=$this->user->getId();
            $baseUrl='assets/uploads/users/'. $id . '/' . $this->user->getAvatar();
        }
        $this->smarty->assign('profil','profil');
        $this->smarty->assign('baseUrl',$baseUrl);
        $this->smarty->assign('info_menu','profil');
        $this->smarty->assign('user',$this->user);
        $this->smarty->display($template);
    }

}