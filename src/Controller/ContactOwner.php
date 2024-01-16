<?php

namespace App\Controller;

use Editiel98\Entity\Model;
use Editiel98\Mailer;
use Editiel98\Manager\ModelManager;
use Editiel98\Manager\UserManager;
use Editiel98\Router\Controller;
use Exception;

class ContactOwner extends Controller
{
    private int $modelId = 0;
    private array $errors = [];
    private array $owners = [];
    private Model $model;

    /**
     * manage the page rendering
     * @return void
     */
    public function render():void
    {
        if (!$this->isConnected) {
            $this->smarty->assign('connected', true);
            $this->smarty->display('403.tpl');
            die();
        }
        if (empty($_GET['id']) || intval($_GET['id']) === 0) {
            header('Location: /');
        }
        $done = false;
        $this->modelId = intval($_GET['id']);
        //Check if model exists
        $model = $this->getModel($this->modelId);
        if (is_null($model)) {
            $this->errors[] = "Le modèle n'existe pas";
            $this->displaypage(false);
        }
        $this->model = $model;
        $this->owners = $this->getOwners($this->modelId);

        if (!empty($this->owners)) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $done = $this->doPost();
            }
        } else {
            $this->errors[] = 'Personne ne possède ce kit';
        }
        $this->displayPage($done);
    }

    /**
     * get a model in DB
     * @param int $id
     * 
     * @return [type] Entity or null
     */
    private function getModel(int $id)
    {
        $modelManager = new ModelManager($this->dbConnection);
        $model = $modelManager->findById($id);
        return $model;
    }

    /**
     * Return list of model's owners
     * @param int $id : id of model
     * 
     * @return array
     */
    private function getOwners(int $id): array
    {
        $modelManager = new ModelManager($this->dbConnection);
        $owners = $modelManager->findOwner($id);
        if ($owners === false) {
            return [];
        }
        return $owners;
    }

    /**
     * render the page
     * @param bool $done : if error or not
     * 
     * @return void
     */
    private function displaypage(bool $done): void
    {
        $this->smarty->assign('params', 'params');
        $this->smarty->assign('modelId', $this->modelId);
        $this->smarty->assign('errors', $this->errors);
        if (!$done) {
            $this->smarty->display('params/contactOwner.tpl');
            die();
        }
        $this->smarty->display('params/contactOwnerOK.tpl'); 
        die();
    }

    /**
     * Process POST values
     * 
     * @return [type] boolean if OK or not
     */
    private function doPost()
    {
        if (empty($_POST['message'])) {
            $this->errors[] = 'Veuillez saisir un message';
            return false;
        }
        $message = trim(htmlspecialchars($_POST['message'], ENT_NOQUOTES, 'UTF-8'));
        try {
            $userManager = new UserManager($this->dbConnection);
            $user = $userManager->findById($this->userId);
            $identity = $user->getFirstname() . ' ' . $user->getLastname();
            //Send message
            return $this->sendMessage($user->getEmail(), $this->owners, $message, $identity);
        } catch (Exception $e) {
            $this->errors[] = 'Une erreur est survenue';
            return false;
        }
    }

    /**
     * Send a mail to owners
     * @param string $sender sender mail
     * @param array $dest recpient mail
     * @param string $message
     * @param string $identity sender name
     * 
     * @return bool
     */
    private function sendMessage(string $sender, array $dest, string $message, string $identity): bool
    {
        $mailer = new Mailer();
        try {
            foreach ($dest as $userOnwer) {
                if ($userOnwer->email === $sender) {
                    continue;
                }
                //send mail to dest
                $values = [
                    'userName' => $identity,
                    'modelName' => $this->model->getName(),
                    'modelBrand' => $this->model->getBrand(),
                    'modelScale' => $this->model->getScale(),
                    'modelReference' => $this->model->getRef(),
                    'message' => $message,
                    'userMail' => $sender,
                ];
                $mailer->sendHTMLMailToUser($userOnwer->email, 'Model Kits Database : demande d\information sur un kit', $values, 'contactOwner');
            }
            return true;
        } catch (Exception $e) {
            //Logger l'erreur
            $this->errors[] = 'Une erreur interne est survenue';
            throw new Exception('Une erreur est survenue');
        }
    }
}
