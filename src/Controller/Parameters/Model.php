<?php
namespace App\Controller\Parameters;

use Editiel98\App;
use Editiel98\Entity\User;
use Editiel98\Manager\BrandManager;
use Editiel98\Manager\BuilderManager;
use Editiel98\Manager\CategoryManager;
use Editiel98\Manager\CountryManager;
use Editiel98\Manager\ModelManager;
use Editiel98\Manager\PeriodManager;
use Editiel98\Manager\ScaleManager;
use Editiel98\Router\Controller;
use Editiel98\Session;

class Model extends Controller
{

    public function render()
    {
        if(!empty($_POST))
            var_dump($_POST);
        if($this->isConnected){
            $this->smarty->assign('connected',true);
            if(App::ADMIN===$this->userRank){
                $this->smarty->assign('isAdmin',true);
            }
        }
        $modelManager=new ModelManager($this->dbConnection);
        $models=$modelManager->getAll();
        if($this->isConnected){
            $this->smarty->assign('connected',true);
            if(App::ADMIN===$this->userRank){
                $this->smarty->assign('isAdmin',true);
            }
            $userId=$this->session->getKey(Session::SESSION_USER_ID);
            $user=new User();
            $user->setId($userId);
            $favorite=$user->getFavorite();
            foreach($models as $model){
                $id=$model->getId();
                if(in_array($id,$favorite)){
                    $model->setLiked(true);
                }
            }
        }      
        
        //var_dump($models);
        //Get all needed datas for create a model
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
        $countryManager=new CountryManager($this->dbConnection);
        $countries=$countryManager->getAll();

        $this->smarty->assign('list',$models);
        $this->smarty->assign('countries',$countries);
        $this->smarty->assign('categories',$categories);
        $this->smarty->assign('periods',$periods);
        $this->smarty->assign('builders',$builders);
        $this->smarty->assign('scales',$scales);
        $this->smarty->assign('brands',$brands);
        $this->smarty->assign('$model_menu','');
        $this->smarty->assign('params','params');
        $this->smarty->display('params/models.tpl');
    }
}