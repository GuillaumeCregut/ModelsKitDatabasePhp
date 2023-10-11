<?php
namespace App\Controller\Profil;

use Editiel98\Router\Controller;

class ModelSelector extends Controller
{
    public function render(){
        $this->smarty->display('profil/addmodelorder.tpl');
    }
}