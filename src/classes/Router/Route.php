<?php
namespace Editiel98\Router;

use Editiel98\App;
use Editiel98\SmartyMKD;

abstract class Route
{
    protected SmartyMKD $smarty;
    protected array $subPages;
    protected array $params;

    public function __construct(array $subPages=[], array $params=[])
    {
        $this->smarty=new SmartyMKD();
        $this->subPages=$subPages;
        $this->params=$params;
    }
    abstract public function render();
    protected function getCredentials(){
        if(isset($_SESSION['isConnected'])){
            if($_SESSION['isConnected']){
                $this->smarty->assign('logged_in','accueil');
                $this->smarty->assign('fullname',$_SESSION['fullName']);
                if (App::ADMIN===$_SESSION['rankUser']){
                    $this->smarty->assign('loggedInAdmin','true');
                }
            }
        }
    }

}