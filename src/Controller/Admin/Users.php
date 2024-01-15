<?php

namespace App\Controller\Admin;

use Editiel98\App;
use Editiel98\Flash;
use Editiel98\Manager\UserManager;
use Editiel98\Router\Controller;
use Editiel98\Services\CSRFCheck;

class Users extends Controller
{
    private UserManager $userManager;
    private CSRFCheck $csrfCheck;

    public function render()
    {
        if (App::ADMIN === $this->userRank) {
            $this->csrfCheck = new CSRFCheck($this->session);
            $this->userManager = new UserManager($this->dbConnection);
            if (!empty($_POST)) {
                $this->usePost();
            }
            $this->hasFlash = $this->flash->hasFlash();
            if ($this->hasFlash) {
                $flashes = $this->flash->getFlash();
                $this->smarty->assign('flash', $flashes);
            }
            $users = $this->userManager->getAll();
            $token = $this->csrfCheck->createToken();
            $this->smarty->assign('token', $token);
            $this->smarty->assign('defaultUser', App::DEFAULT_ADMIN);
            $this->smarty->assign('users', $users);
            $this->smarty->display('admin/users.tpl');
        } else {
            $this->smarty->assign('accueil', 'accueil');
            $this->smarty->display('index.tpl');
        }
    }

    private function usePost()
    {
        if (!isset($_POST['action']) || $_POST['action'] !== 'delete') {
            return;
        }
        if (!isset($_POST['id']) || intval($_POST['id']) === 0) {
            return;
        }
        if (empty($_POST['token'])) {
            return;
        }
        $token = $_POST['token'];
        if (!$this->csrfCheck->checkToken($token)) {
            return;
        }
        $id = intval($_POST['id']);
        $result = $this->userManager->removeUser($id);
        if (!$result) {
            $this->flash->setFlash('Une erreur est survenue', Flash::FLASH_ERROR);
        }
    }
}
