<?php
namespace App\Controller;

use Editiel98\App;
use Editiel98\Router\Controller;

class Error extends Controller
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
            $this->smarty->assign('errMsg',$this->message);
        }
        $this->getCredentials();
        $this->smarty->display($template);
    }
}