<?php

namespace App\Controller\Profil;

use Editiel98\Entity\User;
use Editiel98\Manager\UserManager;
use Editiel98\Router\Controller;
use Editiel98\Services\CSRFCheck;
use Editiel98\Session;
use App\Controller\Error;

class Info extends Controller
{
    private User $user;
    private CSRFCheck $csfrCheck;

    public function render()
    {
        $this->csfrCheck = new CSRFCheck($this->session);
        if (!$this->isConnected) {
            //Render antoher page and die
            $this->smarty->assign('profil', 'profil');
            $this->smarty->display('profil/notconnected.tpl');
            die();
        }
        //todo
        if (!empty($_POST)) {
            $template = $this->usePost();
        } else $template = 'profil/info.tpl';
        $this->getUser();
        $this->displayPage($template);
    }

    private  function loadErrorPage(string $message)
    {
        //Log to error log
        //display error page
        $errPage = new Error('500', $message);
        $errPage->render();
        die();
    }


    private function usePost(): string
    {
        if (!isset($_POST['action']))
            return 'profil/info.tpl';
        $action = $_POST['action'];
        switch ($action) {
            case 'start-update':
                return 'profil/update.tpl';
                break;
            case 'update':
                $this->updateUser();
                return 'profil/info.tpl';
                break;
            default:
                return 'profil/info.tpl';
        }
    }

    /**
     * Update user in DB
     * @return bool
     */
    private function updateUser(): bool
    {
        if (empty($_POST['token'])) {
            return false;
        }
        $token = $_POST['token'];
        if (!$this->csfrCheck->checkToken($token)) {
            return false;
        }
        $this->getUser();
        $changeUser = false;
        //Check POST values
        if (isset($_POST['firstname'])) {
            $firstname = trim(htmlspecialchars($_POST['firstname'], ENT_NOQUOTES, 'UTF-8'));
        } else {
            $firstname = '';
        }
        if (isset($_POST['lastname'])) {
            $lastname = trim(htmlspecialchars($_POST['lastname'], ENT_NOQUOTES, 'UTF-8'));
        } else {
            $lastname = '';
        }
        if (isset($_POST['login'])) {
            $login = trim(htmlspecialchars($_POST['login'], ENT_NOQUOTES, 'UTF-8'));
        } else {
            $login = '';
        }
        if (isset($_POST['email'])) {
            $email = trim(htmlspecialchars($_POST['email'], ENT_NOQUOTES, 'UTF-8'));
        } else {
            $email = '';
        }
        if (isset($_POST['password'])) {
            $password = htmlspecialchars($_POST['password'], ENT_NOQUOTES, 'UTF-8');
        } else {
            $password = '';
        }
        if (isset($_POST['isvisible'])) {
            $isVisible = $_POST['isvisible'];
            if ($isVisible === 'on') {
                $isVisible = true;
            } else $isVisible = false;
        } else {
            $isVisible = false;
        }
        if (isset($_POST['allow'])) {
            $allow = $_POST['allow'];
            if ($allow === 'on') {
                $allow = true;
            } else $allow = false;
        } else {
            $allow = false;
        }
        if (isset($_POST['change-pass'])) {
            $changePass = $_POST['change-pass'];
            if ($changePass === 'on') {
                $changePass = true;
            } else $changePass = false;
        } else {
            $changePass = false;
        }
        //Check Users values
        if ($this->user->getFirstname() !== $firstname) {
            if ($firstname !== '') {
                $this->user->setFirstname($firstname);
                $changeUser = true;
            }
        }
        if ($this->user->getLastname() !== $lastname) {
            if ($lastname !== '') {
                $this->user->setLastname($lastname);
                $changeUser = true;
            }
        }
        if ($this->user->getLogin() !== $login) {
            if ($login !== '') {
                $this->user->setLogin($login);
                $changeUser = true;
            }
        }
        if ($this->user->getEmail() !== $email) {
            if ($email !== '') {
                $this->user->setEmail($email);
                $changeUser = true;
            }
        }
        if ($password != '' && $changePass) {
            $this->user->setPassword($password);
            $changeUser = true;
        }
        if ($this->user->getVisible() !== $isVisible) {
            $this->user->setVisible($isVisible);
            $changeUser = true;
        }
        if ($this->user->getAllow() !== $allow) {
            $this->user->setAllow($allow);
            $changeUser = true;
        }
        //Check avatar
        $fileOK = $this->storeFile($this->user->getId());
        if ($fileOK !== '') {
            $this->user->setAvatar($fileOK);
            $changeUser = true;
        }
        if ($changeUser) {
            $this->user->update();
        }
        return false;
    }

    /**
     * Get user's information from DB
     * @return void
     */
    private function getUser(): void
    {
        $userId = $this->session->getKey(Session::SESSION_USER_ID);
        $userManager = new UserManager($this->dbConnection);
        $user = $userManager->findById($userId);
        if(!$user){
            $this->loadErrorPage('500','Une erreur est survenue');
        }
        $this->user = $user;
    }

    private function displayPage(string $template)
    {
        $baseUrl = '';
        if (!is_null($this->user->getAvatar()) && $this->user->getAvatar() !== '') {
            $id = $this->user->getId();
            $baseUrl = 'assets/uploads/users/' . $id . '/' . $this->user->getAvatar();
        }
        $token = $this->csfrCheck->createToken();
        $this->smarty->assign('token', $token);
        $this->smarty->assign('profil', 'profil');
        $this->smarty->assign('baseUrl', $baseUrl);
        $this->smarty->assign('info_menu', 'profil');
        $this->smarty->assign('user', $this->user);
        $this->smarty->display($template);
    }

    /**
     * Store avatar picture
     * @param int $idUser
     * 
     * @return string : path to avatar
     */
    private function storeFile(int $idUser): string
    {
        $filename = '';
        $baseDir = '/public/assets/uploads/users/' . $idUser . '/';
        if (isset($_FILES['avatar'])) {
            $image = $_FILES['avatar'];
            if ($image['error'] == UPLOAD_ERR_OK) {
                $type = $image['type'];
                if ($type === 'image/jpeg' || $type === 'image/png') {
                    $ext = explode('/', $type)[1];
                    if ($image['size'] <= 500 * 1000) {
                        $uploadDir = dirname(dirname(dirname(__DIR__))) . $baseDir;
                        if (!is_dir($uploadDir)) {
                            mkdir($uploadDir, 0777, true);
                        }
                        $destFile = $uploadDir . 'avatar.' . $ext;
                        $fileOK = move_uploaded_file($image['tmp_name'], $destFile);
                        if ($fileOK) {
                            $filename = 'avatar.' . $ext;
                        }
                    }
                }
            }
        }
        return $filename;
    }
}
