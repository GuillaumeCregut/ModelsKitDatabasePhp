<?php
namespace App\Controller;

use Editiel98\Router\Controller;

class Home extends Controller{

    public function render()
    {
        $this->getCredentials();
        $this->smarty->assign('accueil','accueil');
        $this->smarty->display('index.tpl');
    }
}
