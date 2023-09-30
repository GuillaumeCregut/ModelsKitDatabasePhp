<?php
namespace App\Controller;

use Editiel98\App;
use Editiel98\Router\Route;

class Error extends Route
{
    private string $error;
    private string $message;
    
    public function __construct(string $error,?string $message=null)
    {
        parent::__construct();
        $this->error=$error;
        if(!is_null($message)){
            $this->message=$message;
        }
    }
    
    public function render()
    {
        //$this->smarty->assign('accueil','accueil');
        $template=$this->error . '.tpl';
        if(isset($this->message)){
            $this->smarty->assign('errMesg',$this->message);
        }
        $this->getCredentials();
        $this->smarty->display($template);
    }
}