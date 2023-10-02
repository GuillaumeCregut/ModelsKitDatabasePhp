<?php
namespace Editiel98\Router;

use Editiel98\App;
use Editiel98\Factory;
use Editiel98\Flash;
use Editiel98\Session;
use Editiel98\SmartyMKD;
/**
 * Class to generate views
 */
abstract class Route
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
    protected bool $hasFlash=false;

    public function __construct(array $subPages=[], array $params=[])
    {
        $this->smarty=new SmartyMKD();
        $this->subPages=$subPages;
        $this->params=$params;
        $this->session=Factory::getSession();
        $this->flash=new Flash();
        $this->hasFlash=$this->flash->hasFlash();
        /* Render flashes messages */
        if($this->hasFlash){
            $flashes=$this->flash->getFlash();
            $this->smarty->assign('flash',$flashes);
        }
}
    
    abstract public function render();

    /**
     * Get user information from session
     * And set Smarty with 
     * @return void
     */
    protected function getCredentials(){
        $connected=$this->session->getKey('isConnected');
        if(!is_null($connected)){
            if($connected){
                $this->smarty->assign('logged_in','accueil');
                $this->smarty->assign('fullname',$this->session->getKey('fullName'));
                if (App::ADMIN===$this->session->getKey('rankUser')){
                    $this->smarty->assign('loggedInAdmin','true');
                }
            }
        }
    }

}