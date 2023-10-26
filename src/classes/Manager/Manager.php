<?php
namespace Editiel98\Manager;

use Editiel98\Database\Database;
use App\Controller\Error as ControllerError;

/**
 * Manage informations from DB to Entity
 */
abstract class Manager
{
    /**
     * Name of the table represent entity
     *
     * @var string
     */
    protected string $table;

    /**
     * Instance of the DB connection
     *
     * @var Database
     */
    protected Database $db;

    /**
     * Class name of the entity
     *
     * @var string
     */
    protected string $className;

    /**
     * Magic function for getters
     *
     * @param [type] $name
     * @return void
     */
    public function __get($name)
    {
        $method='get' . ucfirst($name);
        return $this->$method();
    }

    /**
     * On DB Error, log to lofile, and display error page
     *
     * @param string $message : Error message from DB
     * @return void
     */
    protected function loadErrorPage(string $message)
    {
        //Log to error log
        //display error page
        $errPage=new ControllerError('500',$message);
        $errPage->render();
        die();
    }
    
} 