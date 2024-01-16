<?php

namespace App\Controller;

use Editiel98\App;
use Editiel98\Router\Controller;

/**
 * Controller for errors pages
 */
class Error extends Controller
{
    private string $error;
    private string $message;

    public function __construct(string $error, ?string $message = null)
    {
        parent::__construct();
        $this->error = $error;
        if (!is_null($message)) {
            $env = App::getEnv();
            if ($env === 'debug') {
                $this->message = $message;
            } else {
                $this->message = 'Une erreur est survenue';
            }
        }
    }

    /**
     * render page
     * @return void
     */
    public function render(): void
    {
        //$this->smarty->assign('accueil','accueil');
        $template = $this->error . '.tpl';
        if (isset($this->message)) {
            $this->smarty->assign('errMsg', $this->message);
        }
        $this->getCredentials();
        $this->smarty->display($template);
    }
}
