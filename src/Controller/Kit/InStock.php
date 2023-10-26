<?php
namespace App\Controller\Kit;

use Editiel98\Entity\User;
use Editiel98\Manager\UserManager;
use Editiel98\Router\Controller;

class InStock extends Controller
{
    private string $search='';
    public function render()
    {
        if(!$this->isConnected){
        //Render antoher page and die
            $this->smarty->assign('profil','profil');
            $this->smarty->display('profil/notconnected.tpl');
            die();
        }
        $user=new User();
        $user->setId($this->userId);
        if(!empty($_GET)){
            if(isset($_GET['name'])){
                $this->search=htmlspecialchars($_GET['name'], ENT_NOQUOTES, 'UTF-8');
            }
            else $this->search=false;
        }
        else $this->search='';
        if(!empty($_POST)){
            $this->usePost();
        }
        $kits=$user->getStockKit($this->search);
        $kitCount=count($kits);
        $page='kit_stock';
        $this->displayPage($kitCount, $page, $kits, $this->search);  //search : search from $_POST
    }

    private function displayPage(int $count, string $page, array $list, ?string $search='')
    {
        $this->smarty->assign('dataList',$list);
        $this->smarty->assign('kits', true);
        $this->smarty->assign('instock_menu', true);
        $this->smarty->assign('title','Kit en stock');
        $this->smarty->assign('titleDisplay','en stock');
        $this->smarty->assign('actionPage',$page);
        $this->smarty->assign('countKit',$count);
        $this->smarty->assign('searchValue',$search);
        $this->smarty->display('kit/kitlist.tpl');
    }

    private function usePost(){
        if(isset($_POST['search'])){
            $this->search=htmlspecialchars($_POST['search'], ENT_NOQUOTES, 'UTF-8');
        }
        if(!isset($_POST['action'])){
            return;
        }
        $action =$_POST['action'];
        if($action !=='delete'){
           return;
        }
        if(isset($_POST['id'])){
            $id=intval($_POST['id']);       
        }
        if($id!==0){
            $kitManager=new UserManager($this->dbConnection);
            return $kitManager->deleteModelFromStock($id,$this->userId);
        }
    }
}