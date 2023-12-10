<?php

namespace App\Controller\Profil;

use Editiel98\Router\Controller;

class ExportCSV extends Controller
{
    public function render()
    {
        $this->displayPage();
    }

    private function displayPage()
    {
        $this->smarty->assign('profil', true);
        $this->smarty->assign('csv_menu', true);
        $this->smarty->display('profil/statscsv.tpl');
    }
}