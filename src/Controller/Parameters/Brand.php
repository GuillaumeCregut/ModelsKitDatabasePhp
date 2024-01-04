<?php
namespace App\Controller\Parameters;

use Editiel98\App;
use Editiel98\Entity\Brand as EntityBrand;
use Editiel98\Manager\BrandManager;
use Editiel98\Router\Controller;
use Editiel98\Services\CSRFCheck;

class Brand extends Controller
{
    private CSRFCheck $csfrCheck;
    public function render()
    {
        $this->csfrCheck=new CSRFCheck($this->session);
        if(!empty($_POST)){
            if(!$this->usePost())
            {
                $this->hasFlash=$this->flash->hasFlash();
                /* Render flashes messages */
                if($this->hasFlash){
                    $flashes=$this->flash->getFlash();
                    $this->smarty->assign('flash',$flashes);
                }
            }
        }

        $brandManager=new BrandManager($this->dbConnection);
        $brands= $brandManager->getAll();
        if($this->isConnected){
            $this->smarty->assign('connected',true);
            if(App::ADMIN===$this->userRank || App::MODERATE===$this->userRank){
                $this->smarty->assign('isAdmin',true);
            }
        }
        $token=$this->csfrCheck->createToken();
        $this->smarty->assign('token',$token);
        $this->smarty->assign('list',$brands);
        $this->smarty->assign('params','params');
        $this->smarty->assign('brand_menu','params');
        $this->smarty->display('params/brands.tpl');
    }

    private function usePost(): bool{
        if(empty($_POST['token'])) {
            return false;
        }
        $token=$_POST['token'];
        if(!$this->csfrCheck->checkToken($token)){
           return false;
        }
        if(isset($_POST['action'])){
            switch ($_POST['action']){
                case "add" :
                    if(isset($_POST['name'])){
                        $name=trim(htmlspecialchars($_POST['name'], ENT_NOQUOTES, 'UTF-8'));
                        if($name==='') return false;
                        return $this->add($name);
                    }
                    else
                        return false;
                    break;
                case "remove":
                    if(isset($_POST['id'])){
                        $id=intval($_POST['id']);
                        if($id===0) return false;
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
                    return $this->update($id,$name);   
                    break;
                default:
                    return false;
            }
        }
        else{
            return false;
        }
    }

    private function add(string $name): bool 
    {
        if(!$this->isConnected){
            return false;
        }
        $brand=new EntityBrand();
        $brand->setName($name);
        $result=$brand->save();
        return !!$result;
    }

    private function remove(int $id): bool 
    {
        if(!(App::ADMIN===$this->userRank || App::MODERATE===$this->userRank)){
            return false;
        }
        $brand=new EntityBrand();
        $brand->setId($id);
        return $brand->delete();
    }

    private function update(int $id, string $name): bool 
    {
        if(!(App::ADMIN===$this->userRank || App::MODERATE==$this->userRank)){
            return false;
        }
        $brand=new EntityBrand();
       $brand->setId($id);
       $brand->setName($name);
       return $brand->update();
    }
}