<?php

namespace App\Controller\Profil;

use App\Controller\Error;
use Editiel98\Manager\SocialManager;
use Editiel98\Router\Controller;
use Editiel98\Services\CSRFCheck;

class FriendBuild extends Controller
{
    private SocialManager $socialManager;
    private CSRFCheck $csfrCheck;

    public function render()
    {
        $this->socialManager = new SocialManager($this->dbConnection);
        if (!$this->isConnected) {
            //Render antoher page and die
            $this->smarty->assign('profil', 'profil');
            $this->smarty->display('profil/notconnected.tpl');
            die();
        }
        $this->csfrCheck = new CSRFCheck($this->session);
        if (empty($_POST) || !isset($_POST['action'])) {
            $this->displayError();
        }
        switch ($_POST['action']) {
            case 'go':
                $this->displayPage();
                break;
            case 'add':
                $this->storeMessage();
                break;
            default:
                $this->displayError();
        }
    }

    private function displayPage()
    {
        if (!isset($_POST['id']) || intval($_POST['id']) === 0 || !isset($_POST['friend']) || intval($_POST['friend']) === 0) {
            $this->displayError();
        }
        $idModel = intval($_POST['id']);
        $idFriend = intval($_POST['friend']);
        $models = $this->socialManager->getFriendModelDetails($idFriend, $idModel);
        if (empty($models)) {
            $this->displayError();
        }
        $model = $models[0];
        //get pictures
        $dirPictures = $model->pictures;
        $files = [];
        if ($dirPictures) {
            //Get pictures if there are
            $baseDir = dirname(dirname(dirname(__DIR__))) . '/public/';
            if (is_dir($baseDir . $dirPictures)) {
                $scan = scandir($baseDir . $dirPictures);
                foreach ($scan as $file) {
                    if ($file !== '.' && $file !== '..') {
                        $files[] = $dirPictures . '/' . $file;
                    }
                }
            }
        }
        //get messages
        $messages = $this->getMessages($idModel);
        if (!empty($files)) {
            $this->smarty->assign('pictures', $files);
        }
        if ($model->allow === 1) {
            $this->smarty->assign('allow', true);
        }
        if (!empty($messages)) {
            $this->smarty->assign('messages', $messages);
        }
        $token = $this->csfrCheck->createToken();
        $this->smarty->assign('token', $token);
        $this->smarty->assign('model', $model);
        $this->smarty->assign('friend', $idFriend);
        $this->smarty->assign('profil', true);
        $this->smarty->assign('social_menu', true);
        $this->smarty->display('profil/friendbuild.tpl');
        die();
    }

    
    /**
     * Get all messages from db for a model
     * @param int $idModel
     * 
     * @return array
     */
    private function getMessages(int $idModel): array
    {
        $messages = $this->socialManager->getModelMessages($idModel);
        //Organise les messages comme dans finishedModel

        $allMessages = [];
        foreach ($messages as $message) {
            if (is_null($message->replyId)) {
                $newMessage = [
                    'message' => $message,
                    'replies' => []
                ];
                $allMessages[$message->id] = $newMessage;
            } else {
                $allMessages[$message->replyId]['replies'][] = $message;
            }
        }
        return $allMessages;
    }

    /**
     * Store a message in DB
     * @return void
     */
    private function storeMessage(): void
    {
        //Check token
        if (empty($_POST['token'])) {
            $this->displayPage();
        }
        $token = $_POST['token'];
        if (!$this->csfrCheck->checkToken($token)) {
            $this->displayPage();
        }
        if (!isset($_POST['id']) || intval($_POST['id']) === 0 || !isset($_POST['message']) || $_POST['message'] === '' || !isset($_POST['friend']) || intval($_POST['friend']) === 0) {
            $this->displayError();
        }
        $model = intval($_POST['id']);
        $message = htmlspecialchars($_POST['message'], ENT_QUOTES, 'UTF-8');
        $this->socialManager->postModelMessage($this->userId, $message, $model);
        $this->displayPage();
    }

    private function displayError()
    {
        $page = new Error(404);
        $page->render();
        die();
    }
}
