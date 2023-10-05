<?php
namespace App\Controller\Parameters;

use Editiel98\App;
use Editiel98\Entity\Scale as EntityScale;
use Editiel98\Manager\ScaleManager;
use Editiel98\Router\Controller;

class Scale extends Controller
{
    public function render()
    {
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
            if(App::ADMIN===$this->userRank){
                $this->smarty->assign('isAdmin',true);
            }
        }
        $this->smarty->assign('list',$scales);
        $this->smarty->assign('params','params');
        $this->smarty->assign('scale_menu','params');
        $this->smarty->display('params/scales.tpl');
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
        else{
            return false;
        }
    }

    private function add(string $name): bool 
    {
        $scale=new EntityScale();
        $scale->setName($name);
        $result=$scale->save();
        return !!$result;
    }

    private function remove(int $id): bool 
    {
        $scale=new EntityScale();
        $scale->setId($id);
        return $scale->delete();
    }

    private function update(int $id, string $name): bool 
    {
       $country=new EntityScale();
       $country->setId($id);
       $country->setName($name);
       return $country->update();
    }
}