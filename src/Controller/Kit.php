<?php
namespace App\Controller;

use Editiel98\Router\Controller;

class Kit extends Controller{

    public function render()
    {
        $this->smarty->assign('kits','kits');
        $this->smarty->display('kit/index.tpl');
    }
}
