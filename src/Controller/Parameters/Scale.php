<?php
namespace App\Controller\Parameters;

use Editiel98\App;
use Editiel98\Entity\Scale as EntityScale;
use Editiel98\Manager\ScaleManager;
use Editiel98\Router\Controller;
use Editiel98\Services\CSRFCheck;

class Scale extends Controller
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
        $scaleManager=new ScaleManager($this->dbConnection);
        $scales= $scaleManager->getAll();
        if($this->isConnected){
            $this->smarty->assign('connected',true);
            if(App::ADMIN===$this->userRank || App::MODERATE===$this->userRank){
                $this->smarty->assign('isAdmin',true);
            }
        }
        $token=$this->csfrCheck->createToken();
        $this->smarty->assign('token',$token);
        $this->smarty->assign('list',$scales);
        $this->smarty->assign('params','params');
        $this->smarty->assign('scale_menu','params');
        $this->smarty->display('params/scales.tpl');
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
        $scale=new EntityScale();
        $scale->setName($name);
        $result=$scale->save();
        return !!$result;
    }

    private function remove(int $id): bool 
    {
        if(!(App::ADMIN===$this->userRank || App::MODERATE===$this->userRank)){
            return false;
        }
        $scale=new EntityScale();
        $scale->setId($id);
        return $scale->delete();
    }

    private function update(int $id, string $name): bool 
    {
        if(!(App::ADMIN!==$this->userRank || App::MODERATE!==$this->userRank)){
            return false;
        }
        $scale=new EntityScale();
        $scale->setId($id);
        $scale->setName($name);
       return $scale->update();
    }
}