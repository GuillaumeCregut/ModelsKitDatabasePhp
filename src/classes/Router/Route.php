<?php
namespace Editiel98\Router;

use Editiel98\App;
use Editiel98\Factory;
use Editiel98\Flash;
use Editiel98\Session;
use Editiel98\SmartyMKD;

abstract class Route
{
    protected SmartyMKD $smarty;
    protected array $subPages;
    protected array $params;
    protected Session $session;
    protected Flash $flash;

    public function __construct(array $subPages=[], array $params=[])
    {
        $this->smarty=new SmartyMKD();
        $this->subPages=$subPages;
        $this->params=$params;
        $this->session=Factory::getSession();
        $this->flash=new Flash();
    }
    
    abstract public function render();

    protected function getCredentials(){
        $connected=$this->session->getKey('isConnected');
        if(!is_null($connected)){
            if($connected){
                $this->smarty->assign('logged_in','accueil');
                $this->smarty->assign('fullname',$this->session->getKey('fullName'));
                if (App::ADMIN===$this->session->getKey('rankUser')){
                    $this->smarty->assign('loggedInAdmin','true');
                }
            }
        }
    }

}