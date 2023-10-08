<?php
namespace Editiel98\Router;

use Editiel98\Database\Database;
use Editiel98\Event\Emitter;
use Editiel98\Factory;
use Editiel98\Session;
/**
 * Class to generate views
 */
abstract class ApiController
{
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
     * Allow to emit an action to event listener
     *
     * @var Emitter
     */
    protected Emitter $emitter;

    protected int $userId;

    protected int $userRank;

    protected bool $isConnected=false;

    protected Database $dbConnection;

    protected object $datas;

    public function __construct(array $subPages=[], array $params=[])
    {
        $this->subPages=$subPages;
        $this->params=$params;
        $this->session=Factory::getSession();
        $this->emitter=Emitter::getInstance();
        $this->getCredentials();
        $this->dbConnection=Database::getInstance();
        $rawData = file_get_contents("php://input");
        $this->datas=json_decode($rawData);
}
    
    abstract public function manage();

    /**
     * Get user information from session
     * And set Smarty with 
     * @return void
     */
    protected function getCredentials(){
        $connected=$this->session->getKey(Session::SESSION_CONNECTED);
        if(!is_null($connected)){
            if($connected){
                $this->isConnected=true;
                $this->userRank=$this->session->getKey(Session::SESSION_RANK_USER);
                $this->userId=$this->session->getKey(Session::SESSION_USER_ID);
            }
        }
    }

}