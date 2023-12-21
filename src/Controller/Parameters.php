<?php

namespace App\Controller;

use Editiel98\Router\Controller;

class Parameters extends Controller
{
    public function render()
    {
        if (empty($this->subPages)) {
            $this->smarty->assign('params','params');
            $this->smarty->display('params/index.tpl');
        } else {
            switch ($this->subPages[0]) {
                case 'countries':
                    $className = 'Country';
                    break;
                case 'brands':
                    $className = 'Brand';
                    break;
                case 'periods':
                    $className = 'Period';
                    break;
                case 'builders':
                    $className = 'Builder';
                    break;
                case 'categories':
                    $className = 'Category';
                    break;
                case 'scales':
                    $className = 'Scale';
                    break;
                case 'models':
                    $className = 'Model';
                    break;
                case 'modelUpdate':
                    $className="UpdateModel";
                    break;
                case 'converter':
                    $className="ScaleConverter";
                    break;
                default: 
                    $page=new Error('404');
                    $page->render();
                    die();
            }
            $classPage = 'App\\Controller\\Parameters\\' . $className;
            $page=new $classPage([],$this->params);
            $page->render();
        }
    }
}
