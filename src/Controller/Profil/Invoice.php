<?php
namespace App\Controller\Profil;

use Editiel98\Entity\Order;
use Editiel98\Entity\User;
use Editiel98\Flash;
use Editiel98\Manager\UserManager;
use Editiel98\Router\Controller;
use Editiel98\Session;

class Invoice extends Controller
{
    private User $user;
    private array $providers;
    public  function render()
    {
        if(!$this->isConnected){
            //Render antoher page and die
            $this->smarty->assign('profil','profil');
            $this->smarty->display('profil/notconnected.tpl');
            die();
        }
        $this->getUser();
        if(!empty($_POST)){
            $this->usePost();
        }
        $this->hasFlash=$this->flash->hasFlash();
        /* Render flashes messages */
        if($this->hasFlash){
            $flashes=$this->flash->getFlash();
            $this->smarty->assign('flash',$flashes);
        }
        //todo 
        $this->displayPage();

    }

    private function getUser()
    {
        $userId=$this->session->getKey(Session::SESSION_USER_ID);
        $userManager=new UserManager($this->dbConnection);
        $user=$userManager->findById($userId);
        $this->user=$user;
        $providers=$this->user->getProviders();
        $this->providers=$providers;
    }

    private function usePost(){
        if(isset($_POST['newRef'])){
            $newRef=trim(htmlspecialchars($_POST['newRef'], ENT_NOQUOTES, 'UTF-8'));
        }else return;
        if(isset($_POST['newDate'])){
            $newDate=trim(htmlspecialchars($_POST['newDate'], ENT_NOQUOTES, 'UTF-8'));
        }else return;
        if(isset($_POST['newProvider'])){
            $newProvider=intval($_POST['newProvider']);
        }else return;
        if(isset($_POST['lines'])){
           $lines=$_POST['lines'];
        } else return;
        $error=!is_array($lines) || $newRef==='' || $newDate==='' ||  $newProvider===0;
        if($error){
            return;
        }
        $this->createOrder($newRef,$newDate,$newProvider,$lines);
       
        
    }

    private function displayPage()
    {
        $orders=$this->user->getOrders();
        $this->smarty->assign('providers',$this->providers);
        $this->smarty->assign('orders',$orders);
        $this->smarty->assign('profil','profil');
        $this->smarty->assign('bills_menu','profil');
        $this->smarty->display('profil/invoice.tpl');
    }

    private function createOrder(string $RefOrder, string $dateOrder, int $provider,array $linesOrder)
    {
        $order=new Order();
        $order->setOwner($this->user->getId());
        $order->setRef($RefOrder);
        $order->setDate($dateOrder);
        $order->setProvider($provider);
        foreach($linesOrder as $info){
            $newLine=explode(';',$info);
            //check if values are OK
            $idModel=intval($newLine[0]);
            $price=floatval($newLine[1]);
            $qty=intval($newLine[2]);
            if($idModel===0 || $price===0 || $qty===0){
                continue;
            }
            $order->addLines($idModel,$price,$qty);
        }
        $result=$order->save();
        if(!$result){
            $flash=new Flash();
            $flash->setFlash("Une erreur c'est produite à l'enregistrement",'error');
        }
    }
}