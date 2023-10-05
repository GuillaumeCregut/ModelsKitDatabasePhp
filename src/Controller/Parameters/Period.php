<?php
namespace App\Controller\Parameters;

use Editiel98\App;
use Editiel98\Entity\Period as EntityPeriod;
use Editiel98\Manager\PeriodManager;
use Editiel98\Router\Controller;

class Period extends Controller
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
        $periodManager=new PeriodManager($this->dbConnection);
        $periods= $periodManager->getAll();
        if($this->isConnected){
            $this->smarty->assign('connected',true);
            if(App::ADMIN===$this->userRank){
                $this->smarty->assign('isAdmin',true);
            }
        }
        $this->smarty->assign('list',$periods);
        $this->smarty->assign('params','params');
        $this->smarty->assign('period_menu','params');
        $this->smarty->display('params/periods.tpl');
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
        $period=new EntityPeriod();
        $period->setName($name);
        $result=$period->save();
        return !!$result;
    }

    private function remove(int $id): bool 
    {
        $period=new EntityPeriod();
        $period->setId($id);
        return $period->delete();
    }

    private function update(int $id, string $name): bool 
    {
       $period=new EntityPeriod();
       $period->setId($id);
       $period->setName($name);
       return $period->update();
    }
}