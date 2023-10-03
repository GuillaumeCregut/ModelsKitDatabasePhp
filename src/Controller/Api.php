<?php
namespace App\Controller;

use Editiel98\Router\Controller;


class Api extends Controller
{
    public function render()
    {
        if (empty($this->subPages)) {
            $this->smarty->assign('admin','params');
            $this->smarty->display('admin/index.tpl');
        } else{
            switch ($this->subPages[0]) {
                case 'userRank':
                        $className='Admin\\ChangeRankUser';
                        break;
                case 'users':
                        $className='Users';
                        break;
                default :
                    $page=new Error('404');
                    $page->render();
                    die();
            }
            if(isset($className))
            {
                $classPage = 'Editiel98\\Api\\' . $className;
                $page=new $classPage($this->params);
                $page->manage();
            }
        }
    }
}