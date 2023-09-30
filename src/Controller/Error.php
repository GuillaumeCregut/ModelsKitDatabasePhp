<?php
namespace App\Controller;

use Editiel98\Router\Route;

class Error extends Route
{
    private string $error;
    
    public function __construct(string $error)
    {
        parent::__construct();
        $this->error=$error;
    }
    
    public function render()
    {
        //$this->smarty->assign('accueil','accueil');
        $template=$this->error . '.tpl';
        $this->smarty->display($template);
    }
}