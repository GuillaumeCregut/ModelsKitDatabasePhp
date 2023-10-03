<?php
namespace App\Controller;

use Editiel98\Router\Controller;

class Logout extends Controller
{
    public function render()
    {
        //Empty $_Session
        session_destroy();
        header('Status: 200');
        header('Location: /');
    }
}