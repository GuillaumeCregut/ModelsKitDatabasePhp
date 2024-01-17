<?php

namespace App\Controller;

use DateTimeImmutable;
use DateTimeZone;
use Editiel98\Manager\UserManager;
use Editiel98\Router\Controller;

/**
 * Controller for recovery password reset
 */
class Recover extends Controller
{
    public function render()
    {
        $template = 'recoveryform.tpl';
        if (!empty($_POST)) {
            if ($this->usePost()) {
                $template = 'recoveryok.tpl';
            } else {
                $template = 'recoveryfail.tpl';
            }
        }
        $this->displayPage($template);
    }

    private function usePost(): bool
    {
        if (!isset($_POST['action'])) {
            return false;
        }
        $action = $_POST['action'];
        if ($action !== 'change') {
            return false;
        }
        if (!isset($_POST['email']) || !isset($_POST['password']) || !isset($_POST['code'])) {
            return false;
        }
        $email = htmlspecialchars($_POST['email'], ENT_NOQUOTES, 'UTF-8');
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        $userManager = new UserManager($this->dbConnection);
        $user = $userManager->getResetCredentials($email);
        $expireDate = new DateTimeImmutable($user->pwdTokenDate, new DateTimeZone('Europe/Paris'));
        $now = new DateTimeImmutable('now', new DateTimeZone('Europe/Paris'));
        if ($now > $expireDate) {
            return false;
        }
        if ($_POST['code'] !== $user->pwdtoken) {
            echo "code pas bon";
            return false;
        }
        $pass = $_POST['password'];
        $hashedPassword = password_hash($pass, PASSWORD_DEFAULT);
        if ($userManager->resetPassword($user->id, $hashedPassword)) {
            return true;
        }
        return false;
    }

    private function displayPage(string $template)
    {
        $this->smarty->display($template);
    }
}
