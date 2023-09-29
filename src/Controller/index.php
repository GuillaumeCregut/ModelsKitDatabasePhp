<?php
namespace App\Controller;

use Editiel98\Router\Route;

class Index extends Route{

    public function render()
    {
        $this->smarty->assign('accueil','accueil');

        $this->smarty->display('index.tpl');
    }
}
