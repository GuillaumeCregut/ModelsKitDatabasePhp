<?php
namespace App\Controller\Kit;

use Editiel98\App;
use Editiel98\Entity\User;
use Editiel98\Router\Controller;
use Editiel98\Session;

class Management extends Controller
{
    private array $liked=[];
    private array $buy=[];
    private array $stock=[];
    private array $wip=[];
    private array $finished=[];

    public function render()
    {
        if(!$this->isConnected){
        //Render antoher page and die
            $this->smarty->assign('profil','profil');
            $this->smarty->display('profil/notconnected.tpl');
            die();
        }
        $userId=$this->session->getKey(Session::SESSION_USER_ID);
        $user=new User();
        $user->setId($userId);
        $models=$user->getModels();
        $this->parseModels($models);
        $this->displayPage();
    }

    private function displayPage()
    {
        $this->smarty->assign('likeModels',$this->liked);
        $this->smarty->assign('buyModels',$this->buy);
        $this->smarty->assign('stockedModels',$this->stock);
        $this->smarty->assign('wipModels',$this->wip);
        $this->smarty->assign('finishedModels',$this->finished);
        $this->smarty->assign('zoneLike', App::STATE_LIKED);
        $this->smarty->assign('zoneBuy',App::STATE_BUY);
        $this->smarty->assign('zoneStock',App::STATE_STOCK);
        $this->smarty->assign('zoneWip',App::STATE_WIP);
        $this->smarty->assign('zoneFinished',App::STATE_FINISHED);
        $this->smarty->assign('stock_menu',true);
        $this->smarty->assign('kits', true);
        $this->smarty->display('kit/management.tpl');
    }

    private function parseModels(array $models): void
    {
        foreach($models as $model){
            switch($model->state){
                case App::STATE_LIKED:
                    $this->liked[]=$model;
                    break;
                case App::STATE_BUY:
                    $this->buy[]=$model;
                    break;
                case App::STATE_STOCK:
                    $this->stock[]=$model;
                    break;
                case App::STATE_WIP:
                    $this->wip[]=$model;
                    break;
                case App::STATE_FINISHED:
                    $this->finished[]=$model;
                    break;
            }
        }
    }
}