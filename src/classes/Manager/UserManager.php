<?php
namespace Editiel98\Manager;

use Editiel98\Database\Database;
use Editiel98\DbException;

class UserManager extends Manager //implements ManagerInterface
{
    public function __construct(Database $db)
    {
        $this->db=$db;
        $this->table='user';
        $this->className='Editiel98\Entity\User';
    }

    // public function findById(int $id): Entity{
        
    // }

    public function getAll(): array
    {
        try{
            $result=$this->db->query('SELECT id,rankUser,firstname,lastname, isvalid FROM ' . $this->table); 
            return $result;
        }
        catch(DbException $e){
            $this->loadErrorPage($e->getdbMessage());
        }
    }
/*
    public function findByName(string $name): Entity
    {

    }

    public function update(Entity $entity): bool
    {

    }

    public function save(Entity $entity): bool
    {

    }

    public function delete(Entity $entity) : bool
    {
        return false;
    }*/
}