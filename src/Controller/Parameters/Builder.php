<?php
namespace App\Controller\Parameters;

use Editiel98\App;
use Editiel98\Entity\Builder as EntityBuilder;
use Editiel98\Manager\BuilderManager;
use Editiel98\Manager\CountryManager;
use Editiel98\Router\Controller;

class Builder extends Controller
{
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
        $builderManager=new BuilderManager($this->dbConnection);
        $builders=$builderManager->getAll();
        $countryManager=new CountryManager($this->dbConnection);
        $countries= $countryManager->getAll();
        $this->smarty->assign('list',$builders);
        if($this->isConnected){
            $this->smarty->assign('connected',true);
            if(App::ADMIN===$this->userRank){
                $this->smarty->assign('isAdmin',true);
            }
        }
        $this->smarty->assign('countries',$countries);
        $this->smarty->assign('builder_menu','params');
        $this->smarty->display('params/builders.tpl');
    }

    private function usePost(): bool{
        if(isset($_POST['action'])){
            switch ($_POST['action']){
                case "add" :
                    if(isset($_POST['name'])){
                        $name=htmlspecialchars($_POST['name'], ENT_NOQUOTES, 'UTF-8');
                        if(isset($_POST['countryId'])){
                            $countryId=intval($_POST['countryId']);
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
                        $name=htmlspecialchars($_POST['name'], ENT_NOQUOTES, 'UTF-8');
                    }
                    else
                        return false;
                    if(isset($_POST['id'])){
                        $id=intval($_POST['id']);
                    }
                    else
                        return false;
                    if(isset($_POST['countryId'])){
                        $countryId=intval($_POST['countryId']);
                    }
                    else
                        return false; 
                    return $this->update($id,$name,$countryId);   
                    break;
                default:
                    return false;
            }
        }
        else{
            return false;
        }
    }

    private function add(string $name,int $countryId): bool 
    {
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
        if($id===0){
            return false;
        }
        $builder=new EntityBuilder();
        $builder->setId($id);
        return $builder->delete();
        
    }

    private function update(int $id, string $name, int $countryId): bool 
    {
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