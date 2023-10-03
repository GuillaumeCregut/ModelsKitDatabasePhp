<?php
namespace App\Controller\Admin;

use Editiel98\App;
use Editiel98\Manager\UserManager;
use Editiel98\Router\Controller;

class Users extends Controller
{
    public function render()
    {
        if(App::ADMIN===$this->userRank){
        
            $userManager=new UserManager($this->dbConnection);
            $users=$userManager->getAll();
            //var_dump($users);
            $this->smarty->assign('defaultUser',App::DEFAULT_ADMIN);
            $this->smarty->assign('users',$users);
            $this->smarty->display('admin/users.tpl');
        }else{
            $this->smarty->assign('accueil','accueil');
            $this->smarty->display('index.tpl');
        }

    }
}