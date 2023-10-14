<?php
namespace App\Controller\Kit;

use Editiel98\Entity\User;
use Editiel98\Router\Controller;
use Editiel98\Session;

class OrderedKit extends Controller
{
    public function render()
    {
        if(!$this->isConnected){
        //Render antoher page and die
            $this->smarty->assign('profil','profil');
            $this->smarty->display('profil/notconnected.tpl');
            die();
        }
        $userId=$this->session->getKey(Session::SESSION_USER_ID);
        $user=new User();
        $user->setId($userId);
        $kitCount=0;
        $page='kit_commandes';
        $listKit=[];
        $this->displayPage($kitCount,$page,$listKit);  //search : search from $_POST
    }

    private function displayPage(int $count, string $page, array $list, ?string $search='')
    {
        $this->smarty->assign('commandes_menu', true);
        $this->smarty->assign('title','Kit commandés');
        $this->smarty->assign('titleDisplay','commandés');
        $this->smarty->assign('actionPage',$page);
        $this->smarty->assign('countKit',$count);
        $this->smarty->assign('searchValue',$search);
        $this->smarty->display('kit/kitlist.tpl');
    }
}