<?php
namespace App\Controller\Parameters;

use Editiel98\App;
use Editiel98\Entity\Builder as EntityBuilder;
use Editiel98\Manager\BuilderManager;
use Editiel98\Manager\CountryManager;
use Editiel98\Router\Controller;

class Builder extends Controller
{
    private array $builders;

    public function render()
    {
        if(!empty($_POST)){
            if(!$this->usePost())
            {
                $this->hasFlash=$this->flash->hasFlash();
                // Render flashes messages 
                if($this->hasFlash){
                    $flashes=$this->flash->getFlash();
                    $this->smarty->assign('flash',$flashes);
                }
            }
        }
        if(!isset($this->builders)){
            $this->getBuilders();
        }
        $countryManager=new CountryManager($this->dbConnection);
        $countries= $countryManager->getAll();
        $this->smarty->assign('list',$this->builders);
        if($this->isConnected){
            $this->smarty->assign('connected',true);
            if(App::ADMIN===$this->userRank || App::MODERATE===$this->userRank){
                $this->smarty->assign('isAdmin',true);
            }
        }
        $this->smarty->assign('countries',$countries);
        $this->smarty->assign('builder_menu','params');
        $this->smarty->display('params/builders.tpl');
    }

    private function getBuilders(?string $filter=null)
    {
        $builderManager=new BuilderManager($this->dbConnection);
        if(is_null($filter)){
            $builders=$builderManager->getAll();
        }else{
            $builders=$builderManager->getAllFiltered($filter);
        }
        $this->builders=$builders;
    }

    private function usePost(): bool{
        if(isset($_POST['action'])){
            switch ($_POST['action']){
                case "add" :
                    if(isset($_POST['name'])){
                        $name=trim(htmlspecialchars($_POST['name'], ENT_NOQUOTES, 'UTF-8'));
                        if($name==='') return false;
                        if(isset($_POST['countryId'])){
                            $countryId=intval($_POST['countryId']);
                            if($countryId===0) return false;
                            return $this->add($name, $countryId);
                        }
                        else
                            return false;
                    }
                    else
                        return false;
                    break;
                case "remove": 
                    if(isset($_POST['id'])){
                        $id=intval($_POST['id']);
                        return $this->remove($id);
                    }
                    else
                        return false;
                    break;
                case "update":
                    if(isset($_POST['name'])){
                        $name=trim(htmlspecialchars($_POST['name'], ENT_NOQUOTES, 'UTF-8'));
                        if($name==='') return false;
                    }
                    else
                        return false;
                    if(isset($_POST['id'])){
                        $id=intval($_POST['id']);
                        if($id===0) return false;
                    }
                    else
                        return false;
                    if(isset($_POST['countryId'])){
                        $countryId=intval($_POST['countryId']);
                        if($countryId===0) return false;
                    }
                    else
                        return false; 
                    return $this->update($id,$name,$countryId);   
                    break;
                case 'filter': return $this->search();
                    break;
                default:
                    return false;
            }
        }
        else{
            return false;
        }
    }

    private function search() : bool
    {
        if(isset($_POST['searchName'])){
            $name=htmlspecialchars($_POST['searchName'], ENT_NOQUOTES, 'UTF-8');
        }
        else  return false;
        $this->getBuilders($name);
        return true;
    }

    private function add(string $name,int $countryId): bool 
    {
        if(!$this->isConnected){
            return false;
        }
        if($countryId===0 || $name===''){
            return false;
        }
        $builder=new EntityBuilder();
        $builder
            ->setName($name)
            ->setCountryId($countryId);
         $result=$builder->save();
         return !!$result;
    }

    private function remove(int $id): bool 
    {
        if(!(App::ADMIN===$this->userRank || App::MODERATE==$this->userRank)){
            return false;
        }
        if($id===0){
            return false;
        }
        $builder=new EntityBuilder();
        $builder->setId($id);
        return $builder->delete();
        
    }

    private function update(int $id, string $name, int $countryId): bool 
    {
        if(!(App::ADMIN===$this->userRank || App::MODERATE==$this->userRank)){
            return false;
        }
        if(($id===0) || ($name==='') ||($countryId===0)){
            return false;
        }
        $builder=new EntityBuilder();
        $builder
            ->setName($name)
            ->setCountryId($countryId)
            ->setId($id);
        return $builder->update();
    }
}