<?php

namespace Editiel98\Manager;

use Editiel98\Database\Database;
use Editiel98\DbException;
use Editiel98\Entity\Entity;
use Editiel98\Entity\Provider;
use Editiel98\Event\Emitter;
use Editiel98\Flash;

class ProviderManager extends SingleManager
{
    public function __construct(Database $db)
    {
        $this->db = $db;
        $this->table = 'provider';
        $this->className = 'Editiel98\Entity\Provider';
    }

    /**
     * Save
     * Save the provider in database
     *
     * @param Provider $provider
     * @return boolean
     */
    public function save(Entity $provider): bool
    {
        $query = 'INSERT INTO ' . $this->table . ' (owner, name) VALUES (:owner,:name)';
        $values = [
            ':owner' => $provider->getOwner(),
            ':name' => $provider->getName(),
        ];
        return $this->execSQL($query, $values);
    }

    /**
     * Update
     * update provider values in DB
     *
     * @param Provider $provider
     * @return boolean
     */
    public function update(Entity $provider): bool
    {
        $query = 'UPDATE ' . $this->table . ' SET name=:name WHERE id=:id';
        $values = [
            ':id' => $provider->getId(),
            ':name' => $provider->getName(),
        ];
        return $this->execSQL($query, $values);
    }
    /**
     * delete
     * Delete provider from DB
     *
     * @param Provider $provider
     * @return boolean
     */
    public function delete(Entity $provider): bool
    {
        $query = 'DELETE FROM ' . $this->table . ' WHERE id=:id';
        $values = [
            ':id' => $provider->getId(),
        ];
        return $this->execSQL($query, $values);
    }

    public function getOrders(int $providerId): array
    {
        $query="SELECT owner, reference,  DATE_FORMAT(dateOrder,\"%d/%m/%Y\") as dateOfOrder FROM orders WHERE provider=:provider";
        $values =  [
            ':provider'=>$providerId
        ];
        try {
            $result= $this->db->prepare($query, null, $values);
            return $result;
        } catch (DbException $e) {
            $message = 'SQL : ' . $query . 'a poser problème';
            $emitter = Emitter::getInstance();
            $emitter->emit(Emitter::DATABASE_ERROR, $message);
            return [];
        }
        
       
    }

    /**
     * Exec the query
     *
     * @param string $query : Query to execute
     * @param array $vars : vars for the query
     * @return mixed
     */
    private function execSQL(string $query, array $vars): mixed
    {
        try {
            $result = $this->db->exec($query, $vars);
            return $result;
        } catch (DbException $e) {
            if ($e->getDbCode() === 23000) {
                $flash = new Flash();
                $flash->setFlash('Modification impossible', 'error');
                return false;
            }
            $message = 'SQL : ' . $query . 'a poser problème';
            $emitter = Emitter::getInstance();
            $emitter->emit(Emitter::DATABASE_ERROR, $message);
            $this->loadErrorPage($e->getdbMessage());
        }
    }

   
}
