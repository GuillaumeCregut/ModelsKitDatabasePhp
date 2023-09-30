<?php
namespace App\Controller;

use Editiel98\Router\Route;

class Home extends Route{

    public function render()
    {
        $this->getCredentials();
        $this->smarty->assign('accueil','accueil');
        $this->smarty->display('index.tpl');
    }
}
