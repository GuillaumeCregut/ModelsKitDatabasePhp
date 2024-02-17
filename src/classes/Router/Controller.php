<?php

namespace Editiel98\Router;

use Editiel98\App;
use Editiel98\Database\Database;
use Editiel98\Event\Emitter;
use Editiel98\Factory;
use Editiel98\Flash;
use Editiel98\Session;
use Editiel98\SmartyMKD;

/**
 * Class to generate views
 */
abstract class Controller
{
    /**
     * Smarty : Template generator
     *
     * @var SmartyMKD smarty
     */
    protected SmartyMKD $smarty;

    /**
     * subPages : array of sub pages
     *
     * @var array subPages
     */
    protected array $subPages;

    /**
     * params : url parameters used in get URL type (?,=,&)
     *
     * @var array params
     */
    protected array $params;

    /**
     * session : Session manager
     *
     * @var Session session
     */
    protected Session $session;

    /**
     * Flash manager
     *
     * @var Flash flash
     */
    protected Flash $flash;

    /**
     * hasFlash : Is there any flash in session
     *
     * @var boolean hasFlash
     */
    protected bool $hasFlash = false;

    /**
     * Allow to emit an action to event listener
     *
     * @var Emitter
     */
    protected Emitter $emitter;

    protected int $userId;

    protected int $userRank;

    protected bool $isConnected = false;

    protected Database $dbConnection;

    public function __construct(array $subPages = [], array $params = [])
    {
        $this->smarty = new SmartyMKD();
        $this->subPages = $subPages;
        $this->params = $params;
        $this->session = Factory::getSession();
        $this->flash = new Flash();
        $this->hasFlash = $this->flash->hasFlash();
        /* Render flashes messages */
        if ($this->hasFlash) {
            $flashes = $this->flash->getFlash();
            $this->smarty->assign('flash', $flashes);
        }
        $this->smarty->assign('AppVersion', App::VERSION);
        $this->emitter = Emitter::getInstance();
        $this->getCredentials();
        $this->dbConnection = Database::getInstance();
    }

    abstract public function render();

    /**
     * Get user information from session
     * And set Smarty with 
     * @return void
     */
    protected function getCredentials()
    {
        $connected = $this->session->getKey(Session::SESSION_CONNECTED);
        if (!is_null($connected)) {
            if ($connected) {
                $this->isConnected = true;
                $this->smarty->assign('logged_in', 'accueil');
                $this->smarty->assign('fullname', $this->session->getKey(Session::SESSION_FULLNAME));
                $this->userRank = $this->session->getKey(Session::SESSION_RANK_USER);
                $this->userId = $this->session->getKey(Session::SESSION_USER_ID);
                if (App::ADMIN === $this->session->getKey(Session::SESSION_RANK_USER)) {
                    $this->smarty->assign('loggedInAdmin', 'true');
                }
            }
        } else {
            $this->userRank = 0;
        }
    }
}
