<?php
namespace App\Controller;

use Editiel98\Router\Controller;

class ContactOwner extends Controller
{
    public function render()
    {
        $this->display();
    }

    private function display(): void
    {
        $this->smarty->display('params/contactOwner.tpl');
    }
}