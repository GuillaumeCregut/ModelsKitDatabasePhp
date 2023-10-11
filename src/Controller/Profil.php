<?php

namespace App\Controller;

use Editiel98\Router\Controller;

class Profil extends Controller
{
    public function render()
    {
        if (empty($this->subPages)) {
            $this->smarty->assign('profil','profil');
            $this->smarty->display('profil/index.tpl');
        } else {
            switch ($this->subPages[0]) {
                case 'info':
                    $className = 'Info';
                    break;
                case 'fournisseurs':
                    $className = 'Provider';
                    break;
                case 'commandes':
                    $className = 'Invoice';
                    break;
                case 'stats':
                    $className = '';
                    break;
                case 'statpdf':
                    $className = '';
                    break;
                case 'social':
                    $className = '';
                    break;
                case 'popup':
                    $className ='PopupDetail';
                    break;
                case 'model':
                    $className='ModelSelector';
                    break;
                default: 
                    $page=new Error('404');
                    $page->render();
                    die();
            }
            $classPage = 'App\\Controller\\Profil\\' . $className;
            $page=new $classPage([],$this->params);
            $page->render();
        }
    }
}
