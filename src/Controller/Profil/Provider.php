<?php
namespace App\Controller\Profil;

use Editiel98\App;
use Editiel98\Entity\Provider as EntityProvider;
use Editiel98\Entity\User;
use Editiel98\Manager\UserManager;
use Editiel98\Router\Controller;
use Editiel98\Session;

class Provider extends Controller
{
    private User $user;
    private array $providers;
    public function render()
    {
        if(!$this->isConnected){
        //Render antoher page and die
            $this->smarty->assign('profil','profil');
            $this->smarty->display('profil/notconnected.tpl');
            die();
        }
        if(!empty($_POST)){
            $this->usePost();
        }
        $this->hasFlash=$this->flash->hasFlash();
        /* Render flashes messages */
        if($this->hasFlash){
            $flashes=$this->flash->getFlash();
            $this->smarty->assign('flash',$flashes);
        }
        $this->getUser();
        //todo 
        $this->displayPage();
    }

    private function usePost(){
        if(!isset($_POST['action'])){
            return;
        }
        switch($_POST['action']){
            case 'add' :
                $this->addProvider();
                break;
            case 'update': 
                $this->updateProvider();
                break;
            case 'delete': 
                $this->deleteProvider();
                break;
            default: return;
        }

    }

    private function addProvider()
    {
        if(!isset($_POST['name'])){
            return;
        }
        $name=trim(htmlspecialchars($_POST['name']));
        if($name===''){
            return;
        }
        $userId=$this->session->getKey(Session::SESSION_USER_ID);
        $provider=new EntityProvider();
        $provider->setName($name);
        $provider->setOwner($userId);
        $provider->save();
    }

    private function updateProvider()
    {
        if(!isset($_POST['name'])){
            return;
        }
        $name=trim(htmlspecialchars($_POST['name'], ENT_NOQUOTES, 'UTF-8'));
        if($name===''){
            return;
        }
        if(!isset($_POST['id'])){
            return;
        }
        $id=intval($_POST['id']);
        if($id===0){
            return;
        }
        $provider=new EntityProvider();
        $provider->setName($name);
        $provider->setId($id);
        $provider->update();
    }

    private function deleteProvider()
    {
        if(!isset($_POST['id'])){
            return;
        }
        $id=intval($_POST['id']);
        if($id===0){
            return;
        }
        $provider=new EntityProvider();
        $provider->setId($id);
        $provider->delete();
    }

    private function getUser()
    {
        $userId=$this->session->getKey(Session::SESSION_USER_ID);
        $userManager=new UserManager($this->dbConnection);
        $user=$userManager->findById($userId);
        $this->user=$user;
        $providers=$this->user->getProviders();
        $this->providers=$providers;
        $this->stringToLink();
    }

    private function displayPage()
    {
        var_dump($this->providers);
        $this->smarty->assign('providers',$this->providers);
        $this->smarty->assign('profil','profil');
        $this->smarty->assign('provider_menu','profil');
        $this->smarty->display('profil/provider.tpl');
    }

    private function stringToLink()
    {
        foreach($this->providers as $key=> $provider) {
            
            $url=parse_url($provider->getName());
            var_dump($url);
           if(!empty($url['scheme'])) {
                $provider->setUrl($provider->getName());
                $provider->setName($url['host']);
           }
        }
    }

}