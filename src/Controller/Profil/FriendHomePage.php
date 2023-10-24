<?php

namespace App\Controller\Profil;

use App\Controller\Error;
use Editiel98\Manager\SocialManager;
use Editiel98\Router\Controller;

class FriendHomePage extends Controller
{
    public function render()
    {
        if (!$this->isConnected) {
            //Render antoher page and die
            $this->smarty->assign('profil', 'profil');
            $this->smarty->display('profil/notconnected.tpl');
            die();
        }
        if (empty($_GET) || !isset($_GET['id']) || intval($_GET['id']) === 0) {
            $page = new Error(404);
            $page->render();
            die();
        }
        $friendId = intval($_GET['id']);
        $socialManager = new SocialManager($this->dbConnection);
        $friendList = $socialManager->getFriends($this->userId);
        $friend = null;
        foreach ($friendList as $friendIn) {
            if ($friendIn->id === $friendId) {
                $friend = $friendIn;
            }
        }
        if (is_null($friend)) {
            $page = new Error(404);
            $page->render();
            die();
        }
        //Get All finisehed Kits
        $models = $socialManager->getFriendModels($friendId);
        $this->displayPage($models, $friendId);
    }

    private function displayPage(array $models, int $friend)
    {
        $this->smarty->assign('profil', true);
        $this->smarty->assign('social_menu', true);
        $this->smarty->assign('friend', $friend);
        if (!empty($models)) {
            $this->smarty->assign('models', $models);
        }
        $this->smarty->display('profil/friendhome.tpl');
    }
}
