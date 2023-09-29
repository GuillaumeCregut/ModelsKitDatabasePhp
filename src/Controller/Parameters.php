<?php
namespace App\Controller;

use Editiel98\Router\Route;

class Parameters extends Route
{
    public function render()
    {
        var_dump($this->subPages);
        echo "param";
      /*  $this->smarty->assign('params','params');
        $this->smarty->display('params/index.tpl');*/
        
    }
}