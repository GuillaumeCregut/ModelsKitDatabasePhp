<?php

namespace App\Controller\Profil;

use Editiel98\Manager\SocialManager;
use Editiel98\Router\Controller;
use Editiel98\Services\CSRFCheck;

class Social extends Controller
{
    private SocialManager $socialManager;
    private array $allUsers = [];
    private array $friends = [];
    private array $demands = [];
    private CSRFCheck $csfrCheck;

    public function render()
    {
        if (!$this->isConnected) {
            //Render antoher page and die
            $this->smarty->assign('profil', 'profil');
            $this->smarty->display('profil/notconnected.tpl');
            die();
        }
        $this->csfrCheck = new CSRFCheck($this->session);
        $this->socialManager = new SocialManager($this->dbConnection);
        if (!empty($_POST)) {
            $this->usePost();
        }
        $this->getAllVisibleUsers();
        $this->getFriends();
        $this->getDemands();
        $this->displayPage();
    }

    private function displayPage()
    {
        if (!empty($this->allUsers)) {
            $this->smarty->assign('allUsers', $this->allUsers);
        }
        if (!empty($this->friends)) {
            $this->smarty->assign('allFriends', $this->friends);
        }
        if (!empty($this->demands)) {
            $this->smarty->assign('demandList', $this->demands);
        }
        $token = $this->csfrCheck->createToken();
        $this->smarty->assign('token', $token);
        $this->smarty->assign('profil', true);
        $this->smarty->assign('social_menu', true);
        $this->smarty->display('profil/socialhome.tpl');
    }

    private function getDemands(): void
    {
        $list = $this->socialManager->getDemand($this->userId);
        $this->demands = $list;
    }

    private function getAllVisibleUsers(): void
    {
        $allUsers = $this->socialManager->findVisible($this->userId);
        $friendList = $this->socialManager->getFriendList($this->userId);
        $userList = [];
        foreach ($allUsers as $user) {
            $user->is_ok = 0;
            $user->className = 'action-user-unknown';
            foreach ($friendList as $item) {
                if ($user->id === $item->id_friend1 || $user->id === $item->id_friend2) {
                    $user->is_ok = $item->is_ok;
                    switch ($item->is_ok) {
                        case SocialManager::USER_WAITING:
                            $user->className = 'action-user-waiting';
                            break;
                        case SocialManager::USER_FRIEND:
                            $user->className = 'action-user-friend';
                            break;
                        case SocialManager::USER_REFUSED:
                            $user->className = 'action-user-refused';
                            break;
                        default:
                            $user->className = 'action-user-unknown';
                    }
                    break;
                }
            }
            $userList[] = $user;
        }
        $this->allUsers = $userList;
    }

    private function getFriends():  void
    {
        $listFriends = $this->socialManager->getFriends($this->userId);
        $listMessages = $this->socialManager->getMessageCount($this->userId);
        $list = [];
        foreach ($listFriends as $friend) {
            $friend->nbMessage = 0;
            foreach ($listMessages as $message) {
                if ($message->exp === $friend->id) {
                    $friend->nbMessage = $message->nb;
                    break;
                }
            }
            $list[] = $friend;
        }
        $this->friends = $list;
    }

    private function usePost()
    {
        if (empty($_POST['token'])) {
            return false;
        }
        $token = $_POST['token'];
        if (!$this->csfrCheck->checkToken($token)) {
            return false;
        }
        if (!isset($_POST['action'])) {
            return;
        }
        switch ($_POST['action']) {
            case 'accept':
                $this->processDemand();
                break;
            case 'remove-friend':
                $this->removeFriend();
                break;
            default:
                return;
        }
    }

    private function removeFriend(): void
    {
        if (!isset($_POST['idFriend']) || intval($_POST['idFriend']) === 0) {
            return;
        }
        $friendId = intval($_POST['idFriend']);
        $this->socialManager->changeStatusFriend($this->userId, $friendId, SocialManager::USER_UNKNOWN);
    }

    private function processDemand(): void
    {
        if (!isset($_POST['user']) || intval($_POST['user']) === 0 || !isset($_POST['choice']) || intval($_POST['choice']) === 0) {
            return;
        }
        $friendId = intval($_POST['user']);
        $choice = intval($_POST['choice']);
        if ($choice === 1) {
            $this->socialManager->changeStatusFriend($this->userId, $friendId, SocialManager::USER_REFUSED);
        } elseif ($choice === 2) {
            $this->socialManager->changeStatusFriend($this->userId, $friendId, SocialManager::USER_FRIEND);
        } else {
            return;
        }
        return;
    }
}
