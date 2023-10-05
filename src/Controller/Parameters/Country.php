<?php
namespace App\Controller\Parameters;

use Editiel98\App;
use Editiel98\Entity\Country as EntityCountry;
use Editiel98\Factory;
use Editiel98\Manager\CountryManager;
use Editiel98\Router\Controller;

class Country extends Controller
{
    public function render()
    {
        if(!empty($_POST)){
            var_dump($_POST);
            if(!$this->usePost())
            {
                //Une erreur s'est produite;
            }
        }
        $countryManager=new CountryManager($this->dbConnection);
        $countries= $countryManager->getAll();
        //var_dump($countries);
        if($this->isConnected){
            $this->smarty->assign('connected',true);
            if(App::ADMIN===$this->userRank){
                $this->smarty->assign('isAdmin',true);
            }
        }
        $this->smarty->assign('list',$countries);
        $this->smarty->assign('params','params');
        $this->smarty->assign('country_menu','params');
        $this->smarty->display('params/countries.tpl');
    }

    private function usePost(): bool{
        if(isset($_POST['action'])){
            switch ($_POST['action']){
                case "add" :
                    if(isset($_POST['name'])){
                        $name=htmlspecialchars($_POST['name'], ENT_NOQUOTES, 'UTF-8');
                        return $this->add($name);
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
                    return $this->update($id,$name);   
                    break;
                default:
                    return false;
            }
        }
    }

    private function add(string $name): bool 
    {
        $country=new EntityCountry();
        $country->setName($name);
        $test=$country->save();
        var_dump($test);
        return false;
    }

    private function remove(int $id): bool 
    {
        return false;
    }

    private function update(int $id, string $name): bool 
    {
        return false;
    }

    
}