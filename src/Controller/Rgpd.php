<?php
namespace App\Controller;

use Editiel98\Router\Controller;

class Rgpd extends Controller{

    public function render()
    {
        $this->getCredentials();
        $this->smarty->assign('accueil','accueil');
        $this->smarty->display('rgpd.tpl');
    }
}
