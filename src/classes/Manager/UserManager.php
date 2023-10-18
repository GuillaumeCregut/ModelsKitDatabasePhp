<?php
namespace Editiel98\Manager;

use DateTime;
use DateTimeZone;
use Editiel98\App;
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
            $query="SELECT firstname, lastname, email, login,isVisible, avatar, allow, rankUser, id, isvalid FROM " . $this->table . " WHERE id=:id";
            $classname='Editiel98\Entity\User';
            $values=[':id'=>$id];
            $result= $this->db->prepare($query,$classname,$values,true);
            if($result){
                return $result;
            } else return null;
        }
        catch(DbException $e){
           throw new Exception($e->getdbMessage());
        }
     }

     public function findByMail(string $mail)
     {
        try{
            $query="SELECT id, firstname, lastname, isvalid FROM " . $this->table . " WHERE email=:email";
            $values=[':email'=>$mail];
            $result= $this->db->prepare($query,null,$values,true);
            if($result){
                return $result;
            } else return null;
        }
        catch(DbException $e){
           return false;
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
            $query="SELECT firstname, lastname,email, rankUser, id, email, isvalid FROM " . $this->table . " WHERE login=:login";
            $classname='Editiel98\Entity\User';
            $values=[':id'=>$lastname];
            $result=$this->db->prepare($query,$classname,$values,true);
            return $result;
        }
        catch(DbException $e){
           throw new Exception($e->getdbMessage());
        }
    }

    public function update(User $entity): bool
    {
        $query="UPDATE " . $this->table . " SET 
        firstname=:firstname,
        lastname=:lastname,
        login=:login,
        email=:email,
        isVisible=:visible,
        allow=:allow,
        avatar=:avatar
        ";
        if($entity->getPassword()!=='')
        {
            $query.=" password=:password";
            $values[':password']=$entity->getPassword();
        }
        $query.=" WHERE id=:id";
        $values[':firstname']=$entity->getFirstname();
        $values[':lastname']=$entity->getLastname();
        $values[':login']=$entity->getLogin();
        $values[':email']=$entity->getEmail();
        $values[':visible']=$entity->getVisible();
        $values[':allow']=$entity->getAllow();
        $values[':avatar']=$entity->getAvatar();
        $values[':id']=$entity->getId();
        try{
            $result=$this->db->exec($query,$values);
            return $result;
        }
        catch(DbException $e){
           return false;
        }
        return false;
    }

    public function save(User $entity): bool
    {
        return false;
    }

    public function delete(User $entity) : bool
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

    public function getResetCredentials(string $email)
    {
        $query="SELECT id, pwdtoken, pwdTokenDate, isvalid, email FROM user WHERE email=:email";
        $values=[
            ':email'=>$email
        ];
        try{
            $result=$this->db->prepare($query,null,$values,true);
            return $result;
        }
        catch(DbException $e){
           return false;
        }

    }

    public function setResetCode(int $id, string $code)
    {
        $mysql_date_now = new DateTime('now',new DateTimeZone('Europe/Paris')); 
        $mysql_date_now->modify('+1 day');
        $expireDate=$mysql_date_now->format('Y-m-d H:i:s');
        $query="UPDATE user SET pwdtoken=:code, pwdTokenDate=:newDate  WHERE id=:id";
        $values=[
            ':id'=>$id,
            ':code'=>$code,
            ':newDate'=>$expireDate
        ];
        try{
            return $this->db->exec($query,$values);
        }catch(DbException $e){
            var_dump($e->getdbMessage());
            return false;
        }
    }

    public function resetPassword(int $id, string $newPass)
    {
        $query="UPDATE user SET passwd=:pass, pwdtoken=null, pwdTokenDate=null WHERE id=:id";
        $values=[
            ':pass'=>$newPass,
            ':id'=>$id
        ];
        try{
            $test=$this->db->exec($query,$values);
            return $test;
        }catch(DbException $e){
            return false;
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

    public function getMyModels(User $user): array
    {
        $userId=$user->getId();
        $query="SELECT id, idModel,state, pictures,price, stateName, modelName, reference, boxPicture,builderName, scaleName, brandName, providerName 
        FROM mymodels WHERE owner=:id";
        $values=[':id'=>$userId];
        try{
            $result=$this->db->prepare($query,null,$values);
            if($result){
                return $result;
            }else return [];
        }
        catch(DbException $e){
           throw new Exception($e->getdbMessage());
        }

    }

    public function addFavorite(User $user, int $idModel) : bool
    {
        $query='INSERT model_user (state,owner,model) VALUES ('. App::STATE_LIKED . ',:user,:model)';
        $values=[':user'=>$user->getId(), ':model'=>$idModel];
        $result=$this->db->exec($query,$values);
        return $result;
    }

    public function removeFavorite(User $user, int $idModel): bool
    {
        $query='DELETE FROM model_user WHERE state=' . App::STATE_LIKED .' AND owner=:user AND model=:model';
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

    public function getProviders(User $entity): array
    {
        $idUser=$entity->getId();
        $classname='Editiel98\Entity\Provider';
        $query='SELECT id, name FROM provider WHERE owner=:id';
        $values=[':id'=>$idUser];
        try{
            return $this->db->prepare($query,$classname,$values);
        }
        catch(DbException $e){
            throw new Exception($e->getdbMessage());
         }
    }

    public function getOrders(User $entity): array
    {
        $query="SELECT o.provider, o.owner,o.reference,DATE_FORMAT(o.dateOrder,\"%d/%m/%Y\") as dateOrder, p.name 
        FROM orders o INNER JOIN provider p ON o.provider=p.id 
        WHERE o.owner=:id";
        $values=[':id'=>$entity->getId()];
        try{
            return $this->db->prepare($query, null, $values);
        }
        catch(DbException $e){
            throw new Exception($e->getdbMessage());
         }
    }

    public function deleteModelFromStock(int $id, int $user): bool
    {
        //Vérifier si il y a des photos dans le kit, si oui, les supprimer, et supprimer le répertoire qui va bien
        $queryKit="SELECT owner, id,state,pictures FROM model_user WHERE id=:id";
        $valuesKit=[':id'=>$id];
        try{
            $theKit= $this->db->prepare($queryKit, null, $valuesKit,true);
            if($theKit){
                if($theKit->owner!==$user) return false;
                if($theKit->pictures){
                    //Delete pictures 
                }
                //delete from db
                $query="DELETE FROM model_user WHERE id=:id";
                try{
                    return $this->db->exec($query,$valuesKit);
                }catch(DbException $e){
                    return false;
                }
            }
            else return false; //The kit does not exists, so no need to do more
        }
        catch(DbException $e){
            echo "Erreur";
            return false;
         }
        return false;
    }

    public function getKitByState(int $state, int $user, ?string $filter=''):array 
    {
        $query="SELECT id, pictures, modelName, reference, boxPicture,builderName, scaleName, brandName 
        FROM mymodels WHERE state=:state AND owner=:owner";
        $values=[
            ':state'=>$state,
            ':owner'=>$user
        ];
        if($filter!==''){
            $query.=' AND modelName like :name';
            $values[':name']="%{$filter}%";
        }
        try{
            return $this->db->prepare($query, null, $values);
        }catch(DbException $e){
            return [];
        }
    }

    public function getRandomKit(int $user)
    {
        $query="SELECT id,modelName,reference,boxPicture,builderName,scaleName,brandName 
        FROM mymodels WHERE owner=:owner AND state=:state ORDER BY RAND() LIMIT 1";
        $values=[
            ':owner'=>$user,
            ':state'=>App::STATE_STOCK
        ];
        try{
           return $this->db->prepare($query, null, $values,true);
        }
        catch(DbException $e){
            return null;
        }
    }
}