<?php
namespace App\Controller\Parameters;

use App\Controller\Error;
use Editiel98\App;
use Editiel98\Entity\Model;
use Editiel98\Manager\BrandManager;
use Editiel98\Manager\BuilderManager;
use Editiel98\Manager\CategoryManager;
use Editiel98\Manager\ModelManager;
use Editiel98\Manager\PeriodManager;
use Editiel98\Manager\ScaleManager;
use Editiel98\Router\Controller;
use Editiel98\Services\CSRFCheck;

class UpdateModel extends Controller
{
    private Model $model;
    private CSRFCheck $csfrCheck;

    public function render()
    {
        $this->csfrCheck=new CSRFCheck($this->session);
        if($this->isConnected){
            $this->smarty->assign('connected',true);
            if(App::ADMIN===$this->userRank){
                $this->smarty->assign('isAdmin',true);
            }
            $this->getModel();
            $this->displayPage();
            
        }else{
            $this->smarty->assign('model_menu','');
            $this->smarty->assign('params','params');
            $this->smarty->display('params/updatemodel.tpl');
        }  
    }

    private function displayPage()
    {
        $builderManager=new BuilderManager($this->dbConnection);
        $builders=$builderManager->getAll();
        $brandManager=new BrandManager($this->dbConnection);
        $brands=$brandManager->getAll();
        $scaleManager=new ScaleManager($this->dbConnection);
        $scales=$scaleManager->getAll();
        $categoryManager=new CategoryManager($this->dbConnection);
        $categories=$categoryManager->getAll();
        $periodManager=new PeriodManager($this->dbConnection);
        $periods=$periodManager->getAll();
        $token=$this->csfrCheck->createToken();
        $this->smarty->assign('token',$token);
        $this->smarty->assign('categories',$categories);
        $this->smarty->assign('periods',$periods);
        $this->smarty->assign('builders',$builders);
        $this->smarty->assign('scales',$scales);
        $this->smarty->assign('brands',$brands);
        $this->smarty->assign('model',$this->model);
        $this->smarty->assign('model_menu','');
        $this->smarty->assign('params','params');
        $this->smarty->display('params/updatemodel.tpl');
    }

    private function getModel()
    {
        $paramModel=explode('=',$this->params[0]);
        if($paramModel[0]!=='model'){
            $page=new Error('404');
            $page->render();
            die();
        }
        $idModel=intval($paramModel[1]);
        if($idModel===0){
            $page=new Error('404');
            $page->render();
            die();
        }
        $modelManager=new ModelManager($this->dbConnection);
        $model=$modelManager->findById($idModel);
        if(is_null($model)){
            $page=new Error('404');
            $page->render();
            die();
        }
        $this->model=$model;
    }
}