<?php
namespace App\Controller\Parameters;

use Editiel98\App;
use Editiel98\Entity\Category as EntityCategory;
use Editiel98\Manager\CategoryManager;
use Editiel98\Router\Controller;
use Editiel98\Services\CSRFCheck;

class Category extends Controller
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
        $categoryManager=new CategoryManager($this->dbConnection);
        $categories= $categoryManager->getAll();
        if($this->isConnected){
            $this->smarty->assign('connected',true);
            if(App::ADMIN===$this->userRank || App::MODERATE===$this->userRank){
                $this->smarty->assign('isAdmin',true);
            }
        }
        $token=$this->csfrCheck->createToken();
        $this->smarty->assign('token',$token);
        $this->smarty->assign('list',$categories);
        $this->smarty->assign('params','params');
        $this->smarty->assign('cat_menu','params');
        $this->smarty->display('params/categories.tpl');
    }

    private function usePost(): bool{
        if(empty($_POST['token'])) {
            return false;
        }
        $token=$_POST['token'];
        if(!$this->csfrCheck->checkToken($token)){
           return false;
        }
        //then
        if(isset($_POST['action'])){
            switch ($_POST['action']){
                case "add" :
                    if(isset($_POST['name'])){
                        $name=trim(htmlspecialchars($_POST['name'], ENT_NOQUOTES, 'UTF-8'));
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
        $category=new EntityCategory();
        $category->setName($name);
        $result=$category->save();
        return !!$result;
    }

    private function remove(int $id): bool 
    {
        if(!(App::ADMIN===$this->userRank  || App::MODERATE===$this->userRank)){
            return false;
        }
        $category=new EntityCategory();
        $category->setId($id);
        return $category->delete();
    }

    private function update(int $id, string $name): bool 
    {
        if(!(App::ADMIN===$this->userRank || App::MODERATE==$this->userRank)){
            return false;
        }
        $category=new EntityCategory();
        $category->setId($id);
        $category->setName($name);
        return $category->update();
    }
}