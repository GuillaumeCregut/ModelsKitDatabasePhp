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
                case 'userValid':
                        $className='Admin\\ChangeValidUser';
                        break;
                case 'userRole':
                        $className='Admin\\ChangeRoleUser';
                        break;
                case 'likemodel':
                        $className='Params\\LikeModel';
                        break;
                case 'addCart':
                        $className='Params\\AddCart';
                        break;
                case 'updateState':
                        $className='Kit\\UpdateState';
                        break;
                case 'addPictures':
                        $className='Kit\\AddPictures';
                        break;
                case 'friend':
                        $className='Profil\\Friend';
                        break;
                default :
                    header("HTTP/1.1 404 Not Found");
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