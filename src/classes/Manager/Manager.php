<?php
namespace Editiel98\Manager;

use Editiel98\Database\Database;

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

    public function __construct(Database $db)
    {
        $this->db=$db;
    }

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
    
} 