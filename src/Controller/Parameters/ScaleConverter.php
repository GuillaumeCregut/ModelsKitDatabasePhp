<?php

namespace App\Controller\Parameters;

use Editiel98\Router\Controller;

class ScaleConverter extends Controller
{
    public function render()
    {
        $this->smarty->assign('params', 'params');
        $this->smarty->assign('converter_menu', 'params');
        $this->smarty->display('params/ScaleConverter.tpl');
    }
}
