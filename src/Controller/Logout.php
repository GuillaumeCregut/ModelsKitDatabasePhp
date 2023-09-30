<?php
namespace App\Controller;

use Editiel98\Router\Route;

class Logout extends Route
{
    public function render()
    {
        //Empty $_Session
        session_destroy();
        header('Status: 200');
        header('Location: /');
    }
}