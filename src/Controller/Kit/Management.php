<?php
namespace App\Controller\Kit;

use Editiel98\Router\Controller;

class Management extends Controller
{
    public function render()
    {
        $this->displayPage();
    }

    private function displayPage()
    {
        $this->smarty->assign('stock_menu',true);
        $this->smarty->display('kit/management.tpl');
    }
}