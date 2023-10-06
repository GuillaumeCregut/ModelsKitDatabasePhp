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
    private ?User $user=null;
    private array $models=[];

    public function render()
    {
        if($this->isConnected){
            $this->smarty->assign('connected',true);
            $userId=$this->session->getKey(Session::SESSION_USER_ID);
            $this->user=new User();
            $this->user->setId($userId);
            if(App::ADMIN===$this->userRank){
                $this->smarty->assign('isAdmin',true);
            }
        }
        if(!empty($_POST)){
            $this->usePost();
        }
        else{
            $this->getModels();
        }
            var_dump($_POST);
        $this->displaPage();
    }

    private function displaPage()
    {
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
        $this->smarty->assign('list',$this->models);
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

    function usePost() : bool
    {
        if(!isset($_POST['action'])){
            return false;
        }
        $searchValues=[];
        $action=$_POST['action'];
        switch($action){
            case 'search':
                $searchValues=$this->makeFilters();
                break;
            case 'remove':
                return false;
                break;
            case 'add':
                return false;
                break;
            default : ;
        }
        $this->getModels($searchValues);
        return true;
    }

    private function makeFilters(): array{
        $request=[];
        if(isset($_POST['filter-category'])){
            $category=intval($_POST['filter-category']);
            if($category!==0)
                $request['category']=$category;
        }
        if(isset($_POST['filter-scale'])){
            $scale=intval($_POST['filter-scale']);
            if($scale!==0)
                $request['scale']=$scale;
        }
        if(isset($_POST['filter-period'])){
            $period=intval($_POST['filter-period']);
            if($period!==0)
                $request['period']=$period;
        }
        if(isset($_POST['filter-builder'])){
            $builder=intval($_POST['filter-builder']);
            if($builder!==0)
                $request['builder']=$builder;
        }
        if(isset($_POST['filter-country'])){
            $country=intval($_POST['filter-country']);
            if($country!==0)
                $request['countryid']=$country;
        }
        if(isset($_POST['filter-brand'])){
            $brand=intval($_POST['filter-brand']);
            if($brand!==0)
                $request['brand']=$brand;
        }
        if(isset($_POST['filter-name'])){
            $name=htmlspecialchars($_POST['filter-name'], ENT_NOQUOTES, 'UTF-8');
            if($name!=='')
                $request['name']=$name;
        }
        return $request;
    }

    function getModels(?array $filter=null)
    {
        $modelManager=new ModelManager($this->dbConnection);
        if(is_null($filter) || empty($filter)){
            $models=$modelManager->getAll(); //To change if filter !=null
        }
        else{
            $models=$modelManager->getFiltered($filter);
        }
        if($this->user){
            $favorite=$this->user->getFavorite();
            foreach($models as $model){
                $id=$model->getId();
                if(in_array($id,$favorite)){
                    $model->setLiked(true);
                }
            }
        }
        $this->models=$models;
    }
}