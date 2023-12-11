<?php
namespace App\Controller\Admin;

use Editiel98\App;
use Editiel98\Router\Controller;

class DBMgmt extends Controller
{
    public function render()
    {
        if(App::ADMIN===$this->userRank){
            $this->smarty->assign('adminDB_menu','true');
            //Get all Logs
           $this->smarty->display('admin/bdMgmt.tpl');
        } else{
            $this->smarty->assign('accueil','accueil');
            $this->smarty->display('index.tpl');
        }

    }
}