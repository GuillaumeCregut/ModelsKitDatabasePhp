<?php
namespace App\Controller;

use Editiel98\Router\Controller;

class Kit extends Controller{

    public function render()
    {
        if (empty($this->subPages)) {
            $this->smarty->assign('kits','kits');
            $this->smarty->display('kit/index.tpl');
        }else{
            switch ($this->subPages[0]) {
                case'general':
                    $className='Management';
                    break;
                case 'commandes':
                    $className='OrderedKit';
                    break;
                case 'stock':
                    $className='InStock';
                    break;
                case 'wip':
                    $className='WipKit';
                    break;
                case 'choose':
                    $className='ChooseKit';
                    break;
                case 'finis':
                    $className='';
                    break;
                default: 
                    $page=new Error('404');
                    $page->render();
                    die();
            }
            $classPage = 'App\\Controller\\Kit\\' . $className;
            $page=new $classPage([],$this->params);
            $page->render();
        }
    }
}
