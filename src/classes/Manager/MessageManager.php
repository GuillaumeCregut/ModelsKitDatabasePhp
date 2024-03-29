<?php

namespace Editiel98\Manager;

use Editiel98\Database\Database;
use Editiel98\DbException;
use Editiel98\Entity\Entity;
use Exception;

/**
 * Manage users messages with DB
 */
class MessageManager extends Manager implements ManagerInterface
{
    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    /**
     * Unused method
     * @return array
     */
    public function getAll(): array
    {
        return [];
    }

    /**
     * @param int $id
     * 
     * @return Entity|null
     */
    public function findById(int $id): ?Entity
    {
        return null;
    }

    /**
     * Unused method
     * @param string $name
     * 
     * @return Entity|null
     */
    public function findByName(string $name): ?Entity
    {
        return null;
    }

    /**
     * Unused method
     * @param Entity $entity
     * 
     * @return bool
     */
    public function save(Entity $entity): bool
    {
        return false;
    }

    /**
     * Unused method
     * @param Entity $entity
     * 
     * @return bool
     */
    public function update(Entity $entity): bool
    {
        return false;
    }

    /**
     * Unused method
     * @param Entity $entity
     * 
     * @return bool
     */
    public function delete(Entity $entity): bool
    {
        return false;
    }

    public function getMessagesForModel(int $id)
    {
        $query = "SELECT mm.id,DATE_FORMAT(mm.date_message,\"%d %M %Y\") as dateMessage, mm.message,mm.reply_id as replyId,u.firstname,u.lastname,u.id as userId,u.avatar 
        FROM model_message mm INNER JOIN user u ON mm.fk_author=u.id WHERE fk_model=:id ORDER BY mm.date_message ASC, id ASC";
        $value = [':id' => $id];
        try {
            return $this->db->prepare($query, null, $value);
        } catch (DbException $e) {
            return [];
        }
    }

    /**
     * Store an user message in DB
     *
     * @param integer $author : author of message
     * @param string $message 
     * @param integer $model : model Id linked with message
     * @param integer $replyId : id of answered message
     * @return void
     */
    public function postAnswerMessage(int $author, string $message, int $model, int $replyId)
    {
        $query = "INSERT INTO model_message (fk_model,fk_author,date_message,message,reply_id) VALUES  (:model,:author,now(),:message,:reply_id);";
        $values = [
            ':model' => $model,
            ':author' => $author,
            ':message' => $message,
            ':reply_id' => $replyId
        ];
        try {
            return $this->db->exec($query, $values);
        } catch (DbException $e) {
            return $e->getDbCode();
        }
    }

    /**
     * Remove all messages for a kit
     * @param int $idKit : id of the kit
     * 
     * @return mixed : result
     */
    public function removeMessagesFromKit(int $idKit)
    {
        $query = "DELETE FROM model_message WHERE fk_model=:id";
        try {
            return $this->db->exec($query, [':id' => $idKit]);
        } catch (DbException $e) {
            throw new Exception($e->getDbCode());
        }
    }
}
