<?php
namespace App\Controller\Profil;

use App\Controller\Error;
use Editiel98\Entity\User;
use Editiel98\Manager\SocialManager;
use Editiel98\Manager\UserManager;
use Editiel98\Router\Controller;

class PersonnalMessage extends Controller
{
    public function render()
    {
        if (!$this->isConnected) {
            //Render antoher page and die
            $this->smarty->assign('profil', 'profil');
            $this->smarty->display('profil/notconnected.tpl');
            die();
        }
        if(empty($_GET) || !isset($_GET['id']) || intval($_GET['id'])===0){
            $page=new Error(404);
            $page->render();
            die();
        }
        $userManager=new UserManager($this->dbConnection);
        $user=$userManager->findById($this->userId);
        if(is_null($user->getAvatar()) || $user->getAvatar()===0){
            $userAvatar=null;
        }else{
            $userAvatar='assets/uploads/users/' . $this->userId . '/' . $user->getAvatar();
        }
        $friendId=intval($_GET['id']);
        $socialManager=new SocialManager($this->dbConnection);
        $friendList=$socialManager->getFriends($this->userId);
        $friend=null;
        foreach($friendList as $friendIn){
            if($friendIn->id===$friendId){
                $friend=$friendIn;
            }
        }
        if(is_null($friend)){
            $page=new Error(404);
            $page->render();
            die();
        }
        $messages=$socialManager->getMessages($friendId,$this->userId);
        if(!empty($messages)){
            $socialManager->setRead($friendId,$this->userId);
        }

        $this->displayPage($friend,$messages, $userAvatar, $user);
    }

    private function displayPage(object $friend, array $messages, string $userAvatar, User $user)
    {
        $this->smarty->assign('profil', true);
        $this->smarty->assign('social_menu', true);
        if(!empty($messages)){
            $this->smarty->assign('messages',$messages);
        }
        $this->smarty->assign('user',$user);
        $this->smarty->assign('userAvatar',$userAvatar);
        $this->smarty->assign('friend',$friend);
        $this->smarty->display('profil/personnalmessage.tpl');
    }
}