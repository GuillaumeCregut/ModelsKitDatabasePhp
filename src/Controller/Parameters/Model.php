<?php
namespace App\Controller\Parameters;

use Editiel98\App;
use Editiel98\Entity\Model as EntityModel;
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
            var_dump($_POST);
            $this->usePost();
        }
        else{
            $this->getModels();
        }
        $this->displayPage();
    }

    private function displayPage()
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
        $this->smarty->assign('model_menu','');
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
        $result=false;
        switch($action){
            case 'search':
                $searchValues=$this->makeFilters();
                break;
            case 'remove':
                $result= $this->remove();
                break;
            case 'add':
                $result= $this->add();
                break;
            default : $result=false;
        }
        $this->getModels($searchValues);
        return $result;
    }

    private function remove() : bool
    {
        if(App::ADMIN!==$this->userRank){
            return false;
        }
        if(!isset($_POST['id'])){
            return false;    
        }
        $id=intval($_POST['id']);
        if($id===0){
            return false;
        }
        $model=new EntityModel();
        $model->setId($id);
        return $model->delete();
    }

    private function add() : bool
    {
        if(App::ADMIN!==$this->userRank){
            return false;
        }
        if(!isset($_POST['name'])){
            return false;
        }
        if(!isset($_POST['reference'])){
            return false;
        }
        if(!isset($_POST['new-brand'])){
            return false;
        }
        if(!isset($_POST['new-builder'])){
            return false;
        }
        if(!isset($_POST['new-scale'])){
            return false;
        }
        if(!isset($_POST['new-category'])){
            return false;
        }
        if(!isset($_POST['new-period'])){
            return false;
        }
        $scalemates='';
        if(isset($_POST['new-scalemates'])){
            $scalemates=htmlspecialchars($_POST['new-scalemates'], ENT_NOQUOTES, 'UTF-8');
        }
        $name=htmlspecialchars($_POST['name'], ENT_NOQUOTES, 'UTF-8');
        if($name===''){
            return false;
        }
        $reference=htmlspecialchars($_POST['reference'], ENT_NOQUOTES, 'UTF-8');
        if($reference===''){
            return false;
        }
        $brand=intval($_POST['new-brand']);
        if($brand==0){
            return false;
        }
        $builder=intval($_POST['new-builder']);
        if($builder==0){
            return false;
        }
        $scale=intval($_POST['new-scale']);
        if($scale==0){
            return false;
        }
        $category=intval($_POST['new-category']);
        if($category==0){
            return false;
        }
        $period=intval($_POST['new-period']);
        if($period==0){
            return false;
        }
        $filename='';
        $baseDir='assets/uploads/models/';
        if(isset($_FILES['new-picture'])){
            $image=$_FILES['new-picture'];
            if ($image['error'] == UPLOAD_ERR_OK){ 
                $type=$image['type'];
                if($type==='image/jpeg' || $type==='image/png'){
                    $ext=explode('/',$type)[1];
                    if($image['size']<=500*1000){
                        $uploadDir=dirname(dirname(dirname(__DIR__))) . '/public/';
                        $filename=$baseDir . $name . uniqid() . '.' . $ext;
                        $destFile=$uploadDir . $filename;
                        $resultFile=move_uploaded_file($image['tmp_name'],$destFile);
                        if(!$resultFile){
                            $filename='';
                        }
                    }
                }
            }
        }
        $model=new EntityModel();
        $model
            ->setName($name)
            ->setCategoryId($category)
            ->setScaleId($scale)
            ->setBrandId($brand)
            ->setBuilderId($builder)
            ->setPeriodId($period)
            ->setScalemates($scalemates)
            ->setRef($reference)
            ->setImage($filename);
        $result=$model->save();
        return $result;
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
            $this->smarty->assign('filtered',true);
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