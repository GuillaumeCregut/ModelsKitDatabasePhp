<?php

namespace Editiel98\Manager;

use Editiel98\Database\Database;
use Editiel98\DbException;
use Exception;

/**
 * Manager for database updates
 */
class DBManager extends Manager
{
    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    /**
     * @return string
     */
    public function getCurrentVersion(): string
    {
        $query = "SELECT value FROM system_mkd WHERE name='version'";
        try {
            $data = $this->db->query($query);
            return $data[0]->value;
        } catch (DbException $e) {
            return 'Une erreur de lecture est survenue';
        }
        return '';
    }

    /**
     * execute query to update DB
     * @param mixed $query : query to execute
     * 
     * @return [type]
     */
    public function updateDb($query)
    {
        try {
            return $this->db->execStraight($query);
        } catch (DbException $e) {
            throw new Exception($e->getMessage());
        }
    }
}
