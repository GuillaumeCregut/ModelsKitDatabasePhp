<?php

namespace App\Controller\Kit;

use App\Controller\Error;
use Editiel98\Manager\MessageManager;
use Editiel98\Manager\ModelManager;
use Editiel98\Router\Controller;
use Editiel98\Services\CSRFCheck;
use Exception;

class FinishedDetails extends Controller
{
    private object $model;
    private array $messages = [];
    private array $files = [];
    private int $modelId;
    private ModelManager $modelManager;
    private MessageManager $messageManager;
    private CSRFCheck $csrfCheck;

    public function render()
    {
        //get id from GET
        if (!$this->isConnected || !isset($_GET['id'])) {
            //Render antoher page and die
            $this->smarty->assign('kits', 'kits');
            $this->smarty->display('kit/notconnected.tpl');
            die();
        }
        $id = intval($_GET['id']);
        if ($id === 0) {
            $page = new Error('404', 'le kit n\'existe pas');
            $page->render();
            die();
        }
        $this->csrfCheck = new CSRFCheck($this->session);
        $this->modelManager = new ModelManager($this->dbConnection);
        $this->messageManager = new MessageManager($this->dbConnection);
        $this->modelId = $id;
        if (!empty($_POST)) {
            $this->usePost();
        }
        //Get model
        $model = $this->modelManager->getOneFullById($id, $this->userId);
        if (!$model) {
            $page = new Error('404', 'le kit n\'existe pas');
            $page->render();
            die();
        }

        $this->model = $model;
        $dirPictures = $model->pictures;
        if ($dirPictures) {
            //Get pictures if there are
            $baseDir = dirname(dirname(dirname(__DIR__))) . '/public/';
            if (is_dir($baseDir . $dirPictures)) {
                $scan = scandir($baseDir . $dirPictures);
                foreach ($scan as $file) {
                    if ($file !== '.' && $file !== '..') {
                        $this->files[] = $dirPictures . '/' . $file;
                    }
                }
            }
        }
        //get messages
        $this->getMessages($id);
        $this->displayPage();
    }

    private function getMessages(int $id)
    {
        $messages = $this->messageManager->getMessagesForModel($id);
        if (!empty($messages)) {
            $formattedMessages = $this->formatAvatar($messages);
            $allMessages = [];
            //Reconstruire proprement le tableau de messages
            foreach ($formattedMessages as $message) {
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
            $this->messages = $allMessages;
        }
    }



    private function displayPage()
    {
        $token = $this->csrfCheck->createToken();
        $this->smarty->assign('token', $token);
        $this->smarty->assign('kits', true);
        $this->smarty->assign('model', $this->model);
        if (!empty($this->messages)) {
            $this->smarty->assign('messages', $this->messages);
        }
        if (!empty($this->files)) {
            $this->smarty->assign('pictures', $this->files);
            $this->smarty->assign('countPicture', count($this->files));
        } else
            $this->smarty->assign('countPicture', 0);
        $this->smarty->display('kit/finishedDetails.tpl');
    }

    private function formatAvatar(array $messages): array
    {
        $formatted = [];
        foreach ($messages as $message) {
            $id = $message->userId;
            if ($message->avatar) {
                $baseUrl = 'assets/uploads/users/' . $id . '/' . $message->avatar;
                $message->avatar = $baseUrl;
            }
            $formatted[] = $message;
        }
        return $formatted;
    }

    private function usePost()
    {
        if (!isset($_POST['action'])) {
            return;
        }
        if (empty($_POST['token'])) {
            return;
        }
        $token = $_POST['token'];
        if (!$this->csrfCheck->checkToken($token)) {
            return;
        }
        switch ($_POST['action']) {
            case 'deletePicture':
                if (!isset($_POST['file'])) return;
                $this->deletePicture($_POST['file']);
                break;
            case 'reply':
                $this->replyMessage();
                break;
            case 'removeKit':
                $this->removeKit();
                break;
            default:
                return;
        }
    }

    private function removeKit()
    {
        //Vérifier si le kit existe et Vérifier si l'utilisateur est bien le possesseur du kit
        $model =  $this->modelManager->getOneFullById($this->modelId, $this->userId);
        if (!$model) {
            return;
        }
        try {
            //Supprimer tous les messages liés au kit
            $this->messageManager->removeMessagesFromKit($this->modelId);
            //Supprimer toutes les photos liées au kit
            $picturesdir = $model->pictures;
            if (!is_null($picturesdir)) {
                //Récupérer toutes les photos et les supprimer
                $baseDir = dirname(dirname(dirname(__DIR__))) . '/public/';
                $fullDir = $baseDir . $picturesdir;
                $files = [];
                if (is_dir($fullDir)) {
                    $files = scandir($fullDir);
                }
                if (!empty($files)) {
                    foreach ($files as $file) {

                        if (($file !== '.' && $file !== '..') && is_file($fullDir . $file)) {
                            $this->deletePicture($picturesdir . $file);
                        }
                    }
                }
            }
            $this->modelManager->deleteStraight($this->modelId);
            header('Location: /kit_finis');
            die();
        } catch (Exception $e) {
        }
    }

    private function replyMessage()
    {
        $model =  $this->modelManager->getOneFullById($this->modelId, $this->userId);
        if (!$model) {
            return;
        }
        if (!empty($_POST['response'])) {
            $response = htmlspecialchars($_POST['response'], ENT_NOQUOTES, 'UTF-8');
        } else
            $response = '';
        if (!empty($_POST['messageId'])) {
            $messageId = intval($_POST['messageId']);
        } else
            $messageId = 0;
        if ($response === '' || $messageId === 0) {
            return;
        }
        //Send message to DB
        $this->messageManager->postAnswerMessage($this->userId, $response, $this->modelId, $messageId);
    }

    private function deletePicture(string $filename)
    {
        if (!isset($_POST['id']) || intval($_POST['id']) === 0) return;
        $idModel = intval($_POST['id']);
        $needle = "assets/uploads/users/{$this->userId}";
        if (!str_contains($filename, $needle)) {
            return;
        }
        $baseDir = dirname(dirname(dirname(__DIR__))) . '/public/';
        $fileToDelete = $baseDir . $filename;
        if (!file_exists($fileToDelete) || !is_file($fileToDelete)) {
            return;
        }
        if (unlink($fileToDelete)) {
            /*Check if there are more files.
            If not, delete from DB pictures */
            $path = explode('/', $filename);
            array_pop($path);
            $fileDirectory = implode('/', $path);
            if (is_dir($baseDir . $fileDirectory)) {
                $scan = scandir($baseDir . $fileDirectory);
                $countFiles = 0;
                foreach ($scan as $file) {
                    if ($file !== '.' && $file !== '..') {
                        $countFiles++;
                    }
                }
                if ($countFiles === 0) {
                    $dirRemoved = rmdir($baseDir . $fileDirectory);
                    if ($dirRemoved) {
                        $modelManager = new ModelManager($this->dbConnection);
                        //update field in DB, with picture=null;
                        $modelManager->updatelinkModelUser($idModel, $this->userId, null);
                    }
                }
            }
        }
    }
}
