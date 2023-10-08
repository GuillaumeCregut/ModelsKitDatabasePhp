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

    public function getFavorites(User $user): array
    {
        $userId=$user->getId();
        $query="SELECT model as idModel FROM model_favorite WHERE owner=:owner";
        $values=['owner'=>$userId];
        try{
            $test=$this->db->prepare($query,null,$values);
            return $test;
        }
        catch(DbException $e){
           throw new Exception($e->getdbMessage());
        }
    }

    public function addFavorite(User $user, int $idModel) : bool
    {
        $query='INSERT model_user (state,owner,model) VALUES (4,:user,:model)';
        $values=[':user'=>$user->getId(), ':model'=>$idModel];
        $result=$this->db->exec($query,$values);
        return $result;
    }

    public function removeFavorite(User $user, int $idModel): bool
    {
        $query='DELETE FROM model_user WHERE state=4 AND owner=:user AND model=:model';
        $values=[':user'=>$user->getId(), ':model'=>$idModel];
        $result=$this->db->exec($query,$values);
        return $result;
    }

    public function addModelStock(User $user, int $idModel, ?int $provider=null, ?float $price=null): bool
    {
        if (is_null($provider)){
            $query='INSERT model_user (state,owner,model) VALUES (1,:user,:model)';
            $values=[':user'=>$user->getId(), ':model'=>$idModel];
        }else{
            $query='INSERT model_user (state,owner,model,provider,price) VALUES (5,:user,:model,:provider,:price)';
            $values=[
                ':user'=>$user->getId(),
                ':model'=>$idModel,
                ':provider'=>$provider,
                ':price'=>$price
            ];
        }
       
        $result=$this->db->exec($query,$values);
        return $result;
    }
}