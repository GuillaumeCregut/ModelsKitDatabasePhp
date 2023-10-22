<?php
namespace Editiel98\Manager;

use Editiel98\Database\Database;
use Editiel98\DbException;

class SocialManager extends Manager
{
    const USER_UNKNOWN=0;
    const USER_WAITING=1;
    const USER_FRIEND=2;
    const USER_REFUSED=3;

    public function __construct(Database $db)
    {
        $this->db=$db;
    }
    
    public function findVisible(int $idUser)
    {
        $query="SELECT firstname,id,lastname,avatar FROM user WHERE isVisible=true and id!=:userId";
        $value=[
            ':userId'=>$idUser
        ];
        try{
            return $this->db->prepare($query,null,$value);
        }catch(DbException $e){
            return [];
        }
    }

    public function getFriendList(int $idUser)
    {
        $query='SELECT * FROM `friend` WHERE id_friend1=:idUser or id_friend2=:idUser';
        $value=[
            ':idUser'=>$idUser
        ];
        try{
            return $this->db->prepare($query,null,$value);
        }catch(DbException $e){
            return [];
        }
    }

    public function getFriends(int $userId)
    {
        $query="SELECT u.firstname, u.lastname,u.avatar, u.id FROM user u 
        INNER JOIN (SELECT `id_friend1` as friendId 
        FROM `friend` WHERE id_friend2=:idUser and is_ok=:status UNION SELECT `id_friend2` 
        FROM `friend` WHERE id_friend1=:idUser and is_ok=:status) as friends ON u.id=friends.friendId;";
        $values=[
            ':idUser'=>$userId,
            ':status'=>self::USER_FRIEND
        ];
        try{
            return $this->db->prepare($query,null,$values);
        }catch(DbException $e){
            echo $e->getdbMessage();
            return [];
        }
    }

    public function getMessageCount(int $userId)
    {
        $query="SELECT count(*) as nb, exp FROM `private_message` WHERE is_read=0 and dest=:idUser GROUP BY exp";
        $value=[
            ':idUser'=>$userId
        ];
        try{
            return $this->db->prepare($query,null,$value);
        }catch(DbException $e){
            return [];
        }
    }

    public function getFriendVisibility(int $user)
    {
        $query="SELECT isVisible FROM user WHERE id=:user";
        $value=[':user'=>$user];
        try{
            return $this->db->prepare($query,null,$value);
        }catch(DbException $e){
            return [];
        }
    }

    public function addFriendShip(int $user, int $friend)
    {
        $query="INSERT INTO friend (id_friend1,id_friend2,is_ok) VALUES(:user,:friend,:state)";
        $values=[
            ':user'=>$user,
            ':friend'=>$friend,
            ':state'=>self::USER_WAITING
        ];
        try{
            return $this->db->exec($query,$values);
        }catch(DbException $e){
           return $e->getDbCode();
        }
    }

    public function getDemand(int $user)
    {
        $query="SELECT f.id_friend1 as id,u.firstname, u.lastname, u.avatar FROM 
        friend f INNER JOIN user u ON f.id_friend1=u.id WHERE is_ok=:state AND id_friend2=:user";
        $values=[
            ':state'=>self::USER_WAITING,
            ':user'=>$user
        ];
        try{
            return $this->db->prepare($query,null,$values);
        }catch(DbException $e){
            echo "crash";
            return [];
        }
    }
}