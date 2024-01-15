<?php

namespace App\Controller;

use Editiel98\App;
use Editiel98\Router\Controller;

class Admin extends Controller
{
    public function render()
    {
        if (App::ADMIN === $this->userRank) {
            if (empty($this->subPages)) {
                $this->smarty->assign('admin', 'params');
                $this->smarty->display('admin/index.tpl');
            } else {
                switch ($this->subPages[0]) {
                    case 'logs':
                        $className = 'Logs';
                        break;
                    case 'users':
                        $className = 'Users';
                        break;
                    case 'database':
                        $className = 'DBMgmt';
                        break;
                    default:
                        $page = new Error('404');
                        $page->render();
                        die();
                }
                if (isset($className)) {
                    $classPage = 'App\\Controller\\Admin\\' . $className;
                    $page = new $classPage($this->params);
                    $page->render();
                }
            }
        } else {
            $this->smarty->assign('accueil', 'accueil');
            $this->smarty->display('index.tpl');
        }
    }
}
