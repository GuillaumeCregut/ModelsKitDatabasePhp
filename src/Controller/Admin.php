<?php
namespace App\Controller;

use Editiel98\Router\Controller;

class Admin extends Controller
{
    public function render()
    {
        if($this->isConnected){
            var_dump($this->subPages);
            if (empty($this->subPages)) {
                $this->smarty->assign('admin','params');
                $this->smarty->display('admin/index.tpl');
            } 
        }
        else{
            $this->smarty->assign('accueil','accueil');
            $this->smarty->display('index.tpl');
        }
    }
}