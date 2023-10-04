<?php

namespace App\Controller;

use Editiel98\Router\Controller;

class Parameters extends Controller
{
    public function render()
    {
        
        var_dump($this->subPages);
        if (empty($this->subPages)) {
            $this->smarty->assign('params','params');
            $this->smarty->display('params/index.tpl');
        } else {
            switch ($this->subPages[0]) {
                case 'country':
                    $className = 'Country';
                    break;
                case 'brand':
                    $className = 'Brand';
                    break;
                case 'period':
                    $className = 'Period';
                    break;
                case 'builder':
                    $className = 'Builder';
                    break;
                case 'category':
                    $className = 'Category';
                    break;
                case 'scale':
                    $className = 'Scale';
                    break;
                case 'model':
                    $className = 'Model';
                    break;
                default: 
                    $page=new Error('404');
                    $page->render();
                    die();
            }
            $classPage = 'App\\Controller\\Parameters\\' . $className;
            $page=new $classPage($this->params);
            $page->render();
        }
    }
}
