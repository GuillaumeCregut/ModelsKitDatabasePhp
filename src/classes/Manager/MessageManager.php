<?php
namespace Editiel98\Manager;

use Editiel98\Database\Database;
use Editiel98\DbException;
use Editiel98\Entity\Entity;

class MessageManager extends Manager implements ManagerInterface
{
    public function __construct(Database $db)
    {
        $this->db=$db;
    }
    
    public function getAll(): array
    {
        return [];
    }

    public function findById(int $id): ?Entity
    {
        return null;
    }

    public function findByName(string $name): ?Entity
    {
        return null;
    }

    public function save(Entity $entity): bool
    {
        return false;
    }

    public function update(Entity $entity): bool
    {
        return false;
    }

    public function delete(Entity $entity): bool
    {
        return false;
    }

    public function getMessagesForModel(int $id)
    {
        $query="SELECT mm.id,DATE_FORMAT(mm.date_message,\"%d %M %Y\") as dateMessage, mm.message,mm.reply_id as replyId,u.firstname,u.lastname,u.id as userId,u.avatar 
        FROM model_message mm INNER JOIN user u ON mm.fk_author=u.id WHERE fk_model=:id ORDER BY mm.date_message ASC, id ASC";
        $value=[':id'=>$id];
        try{
            return $this->db->prepare($query,null,$value);
        }
        catch(DbException $e){
            return [];
        }
    }

    /**
     * Undocumented function
     *
     * @param integer $author
     * @param string $message
     * @param integer $model
     * @param integer $replyId
     * @return void
     */
    public function postAnswerMessage(int $author, string $message, int $model, int $replyId)
    {
        $query="INSERT INTO model_message (fk_model,fk_author,date_message,message,reply_id) VALUES  (:model,:author,now(),:message,:reply_id);";
        $values=[
            ':model'=>$model,
            ':author'=>$author,
            ':message'=>$message,
            ':reply_id'=>$replyId
        ];
        try {
            return $this->db->exec($query, $values);
        } catch (DbException $e) {
            return $e->getDbCode();
        }
    }
}