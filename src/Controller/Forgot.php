<?php

namespace App\Controller;

use Editiel98\Mailer;
use Editiel98\Manager\UserManager;
use Editiel98\Router\Controller;

class Forgot extends Controller
{
    /**
     * manage display page
     * @return void
     */
    public function render():void
    {
        $template = 'forgot.tpl';
        if (!empty($_POST)) {
            if ($this->usePost()) {
                $template = 'mailsentreset.tpl';
            }
        }
        $this->displayPage($template);
    }

    /**
     * Process form datas
     * @return bool
     */
    private function usePost(): bool
    {
        if (!isset($_POST['action'])) {
            return false;
        }
        if ($_POST['action'] !== 'sendmail') {
            return false;
        }

        if (!isset($_POST['email']) || $_POST['email'] === '') {
            return false;
        }
        $email = htmlentities($_POST['email']);
        $userManager = new UserManager($this->dbConnection);
        $user = $userManager->findByMail($email);
        if ($user->getValid() === 0) {
            return false;
        }
        if (is_null($user)) {
            return false;
        }
        $code = [];
        for ($i = 0; $i < 6; $i++) {
            $j = rand(0, 9);
            $code[] = $j;
        }
        $codemail = implode('', $code);
        $result = $userManager->setResetCode($user->getId(), $codemail);
        if (!$result) {
            return false;
        }
        $mailer = new Mailer();
        $serverAdress = $_SERVER['SERVER_NAME'] . '/recover';
        $values = [
            'firstname' => $user->getFirstname(),
            'code' => $codemail,
            'server' => $serverAdress
        ];
        if ($mailer->sendHTMLMailToUser($email, 'réinitialisation mot de passe', $values, 'forgot')) {
            return true;
        } else return false;
    }

    /**
     * render page
     * @param string $template
     * 
     * @return void
     */
    private function displayPage(string $template): void
    {
        $this->smarty->display($template);
    }
}
