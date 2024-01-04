<?php

namespace App\Controller\Profil;

use App\Controller\Error;
use Editiel98\Entity\User;
use Editiel98\Manager\SocialManager;
use Editiel98\Manager\UserManager;
use Editiel98\Router\Controller;
use Editiel98\Services\CSRFCheck;

class PersonnalMessage extends Controller
{
    private CSRFCheck $csfrCheck;
    private SocialManager $socialManager;

    public function render()
    {
        $this->csfrCheck = new CSRFCheck($this->session);
        if (!$this->isConnected) {
            //Render antoher page and die
            $this->smarty->assign('profil', 'profil');
            $this->smarty->display('profil/notconnected.tpl');
            die();
        }

        $this->socialManager = new SocialManager($this->dbConnection);
        if (!empty($_POST)) {
            if (!isset($_POST['idFriend']) || intval($_POST['idFriend']) === 0 || !isset($_POST['message'])) {
                $this->displayError();
            }
            $message = trim(htmlspecialchars($_POST['message'], ENT_QUOTES, 'UTF-8'));
            $friendId = intval($_POST['idFriend']);
            $this->addMessage($friendId, $message);
            header("location: profil_messages?id={$friendId}");
        } else if (empty($_GET) || !isset($_GET['id']) || intval($_GET['id']) === 0) {
            $this->displayError();
        } else {
            $friendId = intval($_GET['id']);
        }
        $userManager = new UserManager($this->dbConnection);
        $user = $userManager->findById($this->userId);
        if (is_null($user->getAvatar()) || $user->getAvatar() === 0) {
            $userAvatar = null;
        } else {
            $userAvatar = 'assets/uploads/users/' . $this->userId . '/' . $user->getAvatar();
        }
        $friendList = $this->socialManager->getFriends($this->userId);
        $friend = null;
        foreach ($friendList as $friendIn) {
            if ($friendIn->id === $friendId) {
                $friend = $friendIn;
            }
        }
        if (is_null($friend)) {
            $this->displayError();
        }
        $messages = $this->socialManager->getMessages($friendId, $this->userId);
        if (!empty($messages)) {
            $this->socialManager->setRead($friendId, $this->userId);
        }

        $this->displayPage($friend, $messages, $userAvatar, $user);
    }

    private function addMessage(int $friendId, string $message): void
    {
        if (empty($_POST['token'])) {
            return;
        }
        $token = $_POST['token'];
        if (!$this->csfrCheck->checkToken($token)) {
            return;
        }
        $this->socialManager->addMessage($friendId, $this->userId, $message);
    }

    private function displayPage(object $friend, array $messages, string $userAvatar, User $user)
    {
        $this->smarty->assign('profil', true);
        $this->smarty->assign('social_menu', true);
        if (!empty($messages)) {
            $this->smarty->assign('messages', $messages);
        }
        $token = $this->csfrCheck->createToken();
        $this->smarty->assign('token', $token);
        $this->smarty->assign('user', $user);
        $this->smarty->assign('userAvatar', $userAvatar);
        $this->smarty->assign('friend', $friend);
        $this->smarty->display('profil/personnalmessage.tpl');
        die();
    }

    function displayError()
    {
        $page = new Error(404);
        $page->render();
        die();
    }
}
