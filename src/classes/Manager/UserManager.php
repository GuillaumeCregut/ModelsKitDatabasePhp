<?php
namespace Editiel98\Manager;

use Editiel98\Database\Database;
use Editiel98\DbException;
use Editiel98\Entity\User;
use Exception;

class UserManager extends Manager //implements ManagerInterface
{
    public function __construct(Database $db)
    {
        $this->db=$db;
        $this->table='user';
        $this->className='Editiel98\Entity\User';
    }

     public function findById(int $id): User|bool
     {
        try{
            $query="SELECT firstname, lastname,email, rankUser, id, email,isvalid FROM " . $this->table . " WHERE id=:id";
            $classname='Editiel98\Entity\User';
            $values=[':id'=>$id];
            return $this->db->prepare($query,$classname,$values,true);
        }
        catch(DbException $e){
           throw new Exception($e->getdbMessage());
        }
     }

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

    public function findByName(string $lastname): User|bool
    {
        try{
            $query="SELECT firstname, lastname,email, rankUser, id, email,isvalid FROM " . $this->table . " WHERE login=:login";
            $classname='Editiel98\Entity\User';
            $values=[':id'=>$lastname];
            return $this->db->prepare($query,$classname,$values,true);
        }
        catch(DbException $e){
           throw new Exception($e->getdbMessage());
        }
    }

    public function update(USer $entity): bool
    {
        return false;
    }

    public function save(USer $entity): bool
    {
        return false;
    }

    public function delete(USer $entity) : bool
    {
        return false;
    }

    public function setNewStatus(int $user, bool $status) :bool
    {
        $query="UPDATE " . $this->table . " SET isvalid=:valid WHERE id=:id";
        $values=[":valid"=>$status,":id"=>$user];
        try{
            $test=$this->db->exec($query,$values);
            return $test;
        }
        catch(DbException $e){
           throw new Exception($e->getdbMessage());
        }
    }

    public function setNewRole(int $user, int $role) : bool
    {
        $query="UPDATE " . $this->table . " SET rankUser=:rankUser WHERE id=:id";
        $values=[":rankUser"=>$role,":id"=>$user];
        try{
            $test=$this->db->exec($query,$values);
            return $test;
        }
        catch(DbException $e){
           throw new Exception($e->getdbMessage());
        }
    }
}