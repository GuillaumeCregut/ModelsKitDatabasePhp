<?php

namespace App\Controller;

use Editiel98\Auth\DbAuth;
use Editiel98\Router\Route;
use Exception;

class Login extends Route
{
    public function render()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['login'])) {
                $login = htmlspecialchars($_POST['login'], ENT_NOQUOTES, 'UTF-8');
            } else {
                $login = '';
            }
            if (isset($_POST['password'])) {
                $password = htmlspecialchars($_POST['password'], ENT_NOQUOTES, 'UTF-8');
            } else {
                $password = '';
            }
            if ($password === '' || $login === '') {
                $this->smarty->assign('errMsg', 'Les identifiants sont invalides');
                $this->smarty->display('login.tpl');
                die();
            }
            $auth = new DbAuth();
            try {
                $isOK = $auth->login($login, $password);
                if (!$isOK) {
                    $this->smarty->assign('errMsg', 'Les identifiants sont invalides');
                    $this->smarty->display('login.tpl');
                    die();
                }
                header('Status: 200');
                header('Location: /');
            } catch (Exception $e) {
                $errPage=new Error('500',$e->getMessage());
                $errPage->render();
                die();
            }
        } else {
            $this->smarty->display('login.tpl');
        }
    }
}