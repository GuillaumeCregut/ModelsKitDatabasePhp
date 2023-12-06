<?php
namespace App\Controller;

use Editiel98\Router\Controller;

class Logout extends Controller
{
    public function render()
    {
        //Empty $_Session
        $this->session->destroy();
        header('Location: /');
    }
}