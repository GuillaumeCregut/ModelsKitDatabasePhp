<?php
namespace App\Controller\Profil;

use App\Controller\Error;
use Editiel98\Entity\User;
use Editiel98\Manager\OrderManager;
use Editiel98\Manager\UserManager;
use Editiel98\Router\Controller;
use Editiel98\Session;

class PopUpDetail extends Controller
{
    private string $ref;

    public function render()
    {
        if(!$this->isConnected){
            //Render antoher page and die
            $this->smarty->display('403.tpl');
            die();
        }
        if(!$this->checkParams()){
            $this->smarty->display('403.tpl');
            die();
        }
        $orderManager=new OrderManager($this->dbConnection);
        $orderInfo=$orderManager->findByRef($this->ref);
        $details=$orderManager->findDetailsByRef($this->ref);
        $this->smarty->assign('orderInfo',$orderInfo[0]);
        $this->smarty->assign('orderDetails',$details);
        $this->smarty->display('profil/orderdetails.tpl');

    }
    private function checkParams(): bool
    {
        $userId=$this->session->getKey(Session::SESSION_USER_ID);
        if(count($this->params)!==2){
            return false;
        }
        $refArray=$this->decodeParams($this->params[0]);
        if($refArray[0]!=='ref'){
            return false;
        }
        $userKey=$this->decodeParams($this->params[1]);
        if ($userKey[0]!=='key'){
            return false;
        }
        if (intval($userKey[1])!==$userId){
            return false;
        }
        $this->ref=$refArray[1];
        return true;
        
    }

    private function decodeParams(string $param): array
    {
        $urldecode=str_replace('%20',' ',$param);
        return explode('=',$urldecode);
       
    }
}