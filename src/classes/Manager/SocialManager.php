<?php

namespace Editiel98\Manager;

use Editiel98\App;
use Editiel98\Database\Database;
use Editiel98\DbException;

/**
 * Manage users relations and private messages
 */
class SocialManager extends Manager
{
    const USER_UNKNOWN = 0;
    const USER_WAITING = 1;
    const USER_FRIEND = 2;
    const USER_REFUSED = 3;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    /**
     * Find all visible users
     * @param int $idUser : id user
     * 
     * @return [type] arrray of users
     */
    public function findVisible(int $idUser)
    {
        $query = "SELECT firstname,id,lastname,avatar FROM user WHERE isVisible=true and id!=:userId";
        $value = [
            ':userId' => $idUser
        ];
        try {
            return $this->db->prepare($query, null, $value);
        } catch (DbException $e) {
            return [];
        }
    }

    /**
     * Get user friend list
     * @param int $idUser : id user
     * 
     * @return [type] : array of users' friends
     */
    public function getFriendList(int $idUser)
    {
        $query = 'SELECT * FROM `friend` WHERE id_friend1=:idUser or id_friend2=:idUser';
        $value = [
            ':idUser' => $idUser
        ];
        try {
            return $this->db->prepare($query, null, $value);
        } catch (DbException $e) {
            return [];
        }
    }

    /**
     * @param int $userId
     * 
     * @return [type] : array
     */
    public function getFriends(int $userId)
    {
        $query = "SELECT u.firstname, u.lastname,u.avatar, u.id FROM user u 
        INNER JOIN (SELECT `id_friend1` as friendId 
        FROM `friend` WHERE id_friend2=:idUser and is_ok=:status UNION SELECT `id_friend2` 
        FROM `friend` WHERE id_friend1=:idUser and is_ok=:status) as friends ON u.id=friends.friendId;";
        $values = [
            ':idUser' => $userId,
            ':status' => self::USER_FRIEND
        ];
        try {
            return $this->db->prepare($query, null, $values);
        } catch (DbException $e) {
            return [];
        }
    }

    /**
     * get messages count group by expeditor
     * @param int $userId : user id
     * 
     * @return [type] :array of result as [user=>count]
     */
    public function getMessageCount(int $userId)
    {
        $query = "SELECT count(*) as nb, exp FROM `private_message` WHERE is_read=0 and dest=:idUser GROUP BY exp";
        $value = [
            ':idUser' => $userId
        ];
        try {
            return $this->db->prepare($query, null, $value);
        } catch (DbException $e) {
            return [];
        }
    }

    /**
     * Get the user visibility
     * @param int $user
     * 
     * @return [type] array with visibility
     */
    public function getFriendVisibility(int $user)
    {
        $query = "SELECT isVisible FROM user WHERE id=:user";
        $value = [':user' => $user];
        try {
            return $this->db->prepare($query, null, $value);
        } catch (DbException $e) {
            return [];
        }
    }

    /**
     * Create relationship between users
     * @param int $user
     * @param int $friend
     * 
     * @return [type]
     */
    public function addFriendShip(int $user, int $friend)
    {
        $query = "INSERT INTO friend (id_friend1,id_friend2,is_ok) VALUES(:user,:friend,:state)";
        $values = [
            ':user' => $user,
            ':friend' => $friend,
            ':state' => self::USER_WAITING
        ];
        try {
            return $this->db->exec($query, $values);
        } catch (DbException $e) {
            return $e->getDbCode();
        }
    }

    /**
     * Return list of user waiting demand
     * @param int $user : id of the user
     * 
     * @return [type]
     */
    public function getDemand(int $user)
    {
        $query = "SELECT f.id_friend1 as id,u.firstname, u.lastname, u.avatar FROM 
        friend f INNER JOIN user u ON f.id_friend1=u.id WHERE is_ok=:state AND id_friend2=:user";
        $values = [
            ':state' => self::USER_WAITING,
            ':user' => $user
        ];
        try {
            return $this->db->prepare($query, null, $values);
        } catch (DbException $e) {
            return [];
        }
    }

    /**
     * Change the relationship between users
     * @param int $user
     * @param int $friend
     * @param int $status
     * 
     * @return [type]
     */
    public function changeStatusFriend(int $user, int $friend, int $status)
    {
        $query = "UPDATE friend SET is_ok=:status WHERE (id_friend1=:user AND id_friend2=:friend) OR (id_friend1=:friend AND id_friend2=:user)";
        $values = [
            ':user' => $user,
            ':friend' => $friend,
            ':status' => $status
        ];
        try {
            return $this->db->exec($query, $values);
        } catch (DbException $e) {
            return $e->getDbCode();
        }
    }

    /**
     * get all messages between 2 users
     * @param int $friend
     * @param int $user
     * 
     * @return [type] array of messages
     */
    public function getMessages(int $friend, int $user)
    {
        $query = "SELECT exp,dest,DATE_FORMAT(date_m,\"%d %M %Y\") as date_message,DATE_FORMAT(date_m,\"%H:%i\") as hour_message, message FROM `private_message` WHERE (exp=:user and dest=:friend) OR (exp=:friend and dest=:user) ORDER BY date_m DESC";
        $values = [
            ':user' => $user,
            ':friend' => $friend
        ];
        try {
            return $this->db->prepare($query, null, $values);
        } catch (DbException $e) {
            return [];
        }
    }

    /**
     * 
     * @param int $exp :id of user who send message
     * @param int $dest : id of user connected
     * 
     * @return [type]
     */
    public function setRead(int $exp, int $dest)
    {
        $query = "UPDATE private_message SET is_read=1 WHERE (dest=:dest and exp=:exp)";
        $values = [
            ':exp' => $exp,
            ':dest' => $dest
        ];
        try {
            return $this->db->exec($query, $values);
        } catch (DbException $e) {
            return $e->getDbCode();
        }
    }

    /**
     * Store a new message in DB
     * @param int $dest : id of recipient user
     * @param int $exp : id of connected user
     * @param string $message
     * 
     * @return [type]
     */
    public function addMessage(int $dest, int $exp, string $message)
    {
        $query = "INSERT INTO private_message (exp,dest,message) VALUES (:exp,:dest,:message)";
        $values = [
            ':exp' => $exp,
            ':dest' => $dest,
            ':message' => $message
        ];
        try {
            return $this->db->exec($query, $values);
        } catch (DbException $e) {
            return $e->getDbCode();
        }
    }

    /**
     * return list of friend's models
     * @param int $idFriend
     * 
     * @return [type]
     */
    public function getFriendModels(int $idFriend)
    {
        $query = "SELECT id,modelname,pictures, reference,boxPicture,builderName,scaleName,brandName FROM mymodels WHERE owner=:owner AND state=:state";
        $values = [
            ':owner' => $idFriend,
            ':state' => App::STATE_FINISHED
        ];
        try {
            return $this->db->prepare($query, null, $values);
        } catch (DbException $e) {
            return [];
        }
    }

    /**
     * return details of friend's model
     * @param int $friend
     * @param int $model
     * 
     * @return [type] array with infos
     */
    public function getFriendModelDetails(int $friend, int $model)
    {
        $query = "SELECT m.id,m.modelname,m.pictures, m.reference,m.boxPicture,m.builderName,m.scaleName,m.brandName,u.allow 
        FROM mymodels m INNER JOIN user u ON m.owner=u.id WHERE m.id=:model and m.owner=:friend";
        $values = [
            ':model' => $model,
            ':friend' => $friend
        ];
        try {
            return $this->db->prepare($query, null, $values);
        } catch (DbException $e) {
            return [];
        }
    }

    /**
     * get messages from a model
     * @param int $id : id of model
     * 
     * @return [type]
     */
    public function getModelMessages(int $id)
    {
        $query = "SELECT mm.id,DATE_FORMAT(mm.date_message,\"%d %M %Y\") as dateMessage, mm.message,mm.reply_id as replyId,u.firstname,u.lastname,u.id as userId,u.avatar 
        FROM model_message mm INNER JOIN user u ON mm.fk_author=u.id WHERE fk_model=:id ORDER BY mm.date_message ASC, id ASC";
        $value = ['id' => $id];
        try {
            return $this->db->prepare($query, null, $value);
        } catch (DbException $e) {
            return [];
        }
    }

    /**
     * Send a message to user's model page
     * @param int $exp : id of expeditor
     * @param string $message 
     * @param int $idModel
     * 
     * @return [type]
     */
    public function postModelMessage(int $exp, string $message, int $idModel)
    {
        $query = "INSERT INTO model_message (fk_model, fk_author, date_message, message) VALUES(:idmodel,:exp,now(),:message)";
        $values = [
            ':idmodel' => $idModel,
            ':exp' => $exp,
            ':message' => $message
        ];
        try {
            return $this->db->exec($query, $values);
        } catch (DbException $e) {
            return $e->getDbCode();
        }
    }
}
